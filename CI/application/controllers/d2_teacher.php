<?php

    if (!defined('BASEPATH'))
        exit('No direct script access allowed');

    class D2_teacher extends MY_Controller {

        function __construct() {
            parent::__construct();

            $this->load->model('modules_model');
            $this->load->model('lessons_model');
            $this->load->model('interactive_content_model');
            $this->load->model('subjects_model');
            $this->load->library('breadcrumbs');    
            $this->load->library( 'nativesession' );

            $this->load->model('content_page_model');
            $this->load->model('interactive_assessment_model');
        }

        function index($subject_id, $year_id='') {

            $selected_year = $this->getSelectYearTeacher($this->nativesession, $this->subjects_model, $subject_id, $year_id);

            $this->_data['subject_id'] = $subject_id;
            $subject = $this->subjects_model->get_single_subject($subject_id);


            $subject_curriculum = $this->subjects_model->get_subject_curriculum($subject_id,$selected_year->year);


            $this->_data['curriculum_id'] = $subject_curriculum->id;
            $this->_data['year_id'] =$selected_year->year;

            $this->_data['subject_title'] = $subject->name;
            $this->_data['subject_intro'] = $subject->name;
            $this->_data['subject_objectives'] = $subject->name;

            if($subject_id){
                $modules = $this->modules_model->get_modules($subject_id, $selected_year->id);			
            }else{
                $modules = 0;
            }

            if(count($modules)==0){
                $this->_data['hide_modules'] = 'hidden';
            } else {
                $this->_data['hide_modules'] = '';
            }
            $odd=0;



            foreach($modules as $module){
                $module_id = $module->id;
                $this->_data['modules'][$module_id]['module_id'] = $module_id;
                $this->_data['modules'][$module_id]['module_name'] = $module->name;

                if($odd%2==0){  
                    $this->_data['modules'][$module_id]['float'] = 'moduleLeft';
                    $this->_data['modules'][$module_id]['clear'] = '';
                }else{
                    $this->_data['modules'][$module_id]['float'] = 'moduleRight';
                    $this->_data['modules'][$module_id]['clear'] = '<div class="clear"></div>';
                }
                $odd++;


                $lessons = $this->lessons_model->get_lessons_by_module(array('module_id' => $module_id));
                if(empty($lessons)){
                    $this->_data['modules'][$module_id]['hide_lessons'] = 'none';
                    $this->_data['modules'][$module_id]['lessons'] = array();
                }else{
                    $this->_data['modules'][$module_id]['hide_lessons'] = 'block';
                }
                $i = 1;
                foreach($lessons as $lesson){
                    $lesson_id = $lesson->id;
                    $this->_data['modules'][$module_id]['lessons'][$lesson_id]['lesson_id'] = $lesson_id;
                    $lesson_title = mb_strlen($lesson->title)>70? mb_substr($lesson->title,0,70).'...':$lesson->title;
                    $this->_data['modules'][$module_id]['lessons'][$lesson_id]['lesson_title'] = $lesson_title;
                    $this->_data['modules'][$module_id]['lessons'][$lesson_id]['lesson_count'] = $i;
                    //$this->_data['modules'][$module_id]['lessons'][$lesson_id]['lesson_interactive'] = $this->interactive_content_model->if_has_assesments($lesson_id) > 0 ? '<div class="yesdot">YES</div>' : '<div class="nodot">NO</div>';
                    $this->_data['modules'][$module_id]['lessons'][$lesson_id]['lesson_interactive'] = $this->lessons_model->interactive_lesson_published($lesson_id) > 0 ? '<a href="/e1_teacher/index/'.$subject_id.'/'.$module_id.'/'.$lesson_id.'"><span class="circle"><span class="glyphicon glyphicon-ok"></span></span></a>' : '';
                    $i++;
                }
            }
//echo '<pre>';var_dump( $this->_data['modules'] );die;
            $this->breadcrumbs->push('Home', base_url());
            $this->breadcrumbs->push('Subjects', '/d1');
            $this->breadcrumbs->push($subject->name, "/d1a/index/".$subject->id);
            $this->breadcrumbs->push('Year '.$selected_year->year, "/");

            $this->_data['breadcrumb'] = $this->breadcrumbs->show();

            $this->_paste_public();

        }

        function saveorder() {
            $order_data = json_decode($this->input->post('data'));

            foreach($order_data as $k_module=>$module) {
                foreach($module as $k_lesson=>$lesson) {
                    $lesson_data = explode(':', $lesson);
                    $lesson_module = $lesson_data[0];
                    $lesson_id = $lesson_data[1];
                    $this->db->update('lessons', array('order' => $k_lesson, 'module_id' => $lesson_module), array('id' => $lesson_id));
                }
                $this->db->update('modules', array('order' => $k_module), array('id' => $lesson_module));
            }
        }

        private function removeLesson($subject_id = '', $lesson_id = '') {
            $content_pages = $this->interactive_content_model->get_il_content_pages($lesson_id);
            foreach ($content_pages as $kay => $val)$this->content_page_model->delete($val->id);

            $int_assessments = $this->interactive_content_model->get_il_int_assesments($lesson_id);
            foreach($int_assessments as $assessment_key=>$assessment) {
                $questions = $this->interactive_assessment_model->get_ia_questions($assessment->id);
                foreach($questions as $question)$this->interactive_assessment_model->delete_answers($question->id);

                $this->interactive_assessment_model->delete_questions($assessment->id); 

                $this->interactive_assessment_model->delete_int_assessment($assessment->id);

            }
            $this->lessons_model->delete($lesson_id);
        }

        public function deleteLesson($subject_id = '', $lesson_id = '') {
            $this->removeLesson($subject_id, $lesson_id);
            redirect('/d2_teacher/index/'. $subject_id);
        }

        public function deleteModule($subject_id = '', $module_id = '') {
            $lessons = $this->lessons_model->get_lessons_by_module(array('module_id' => $module_id));
            foreach ($lessons as $lesson)$this->removeLesson($subject_id, $lesson->id);
            $this->modules_model->delete($module_id);

            redirect('/d2_teacher/index/'. $subject_id);
        }
    }
