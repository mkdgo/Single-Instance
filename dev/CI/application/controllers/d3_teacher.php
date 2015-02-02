<?php
/*
if (!defined('BASEPATH'))
exit('No direct script access allowed');

class D3_teacher extends MY_Controller {

function __construct() {
parent::__construct();
}

function index() {

$this->_paste_public();
}

}
*/


if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class D3_teacher extends MY_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('modules_model');
        $this->load->model('lessons_model');
        $this->load->model('subjects_model');
        $this->load->model('resources_model');
        $this->load->library('breadcrumbs');

        $this->load->library( 'nativesession' );
    }

    function index($subject_id = '') {
        $this->_data['subject_id'] = $subject_id;
        $subject = $this->subjects_model->get_single_subject($subject_id);
        $this->_data['subject_title'] = $subject->name;
        $this->_data['subject_intro'] = $subject->intro;
        $this->_data['subject_objectives'] = $subject->objectives;
        $this->_data['subject_teaching_activities'] = $subject->teaching_activities;
        $this->_data['subject_assessment_opportunities'] = $subject->assessment_opportunities;
        $this->_data['subject_notes'] = $subject->notes;
        $this->_data['subject_publish'] = $subject->publish;

        $this->_data['publish_active'] = '';
        $this->_data['publish_text'] = 'PUBLISH';
        if( $this->_data['subject_publish'] == 1 ) {
            $this->_data['publish_active'] = 'active';
            $this->_data['publish_text'] = 'PUBLISHED';
        } else {
            $this->_data['publish_active'] = '';
            $this->_data['publish_text'] = 'PUBLISH';
        }

        $selected_year = $this->getSelectYearTeacher($this->nativesession, $this->subjects_model, $subject_id, '');

        if($subject_id){
            $modules = $this->modules_model->get_modules($subject_id, $selected_year->id);			
        }else{
            $modules = 0;
        }

        if(count($modules)==0){
            $this->_data['hide_modules'] = 'hidden';
            $this->_data['modules'] = array();
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
                $this->_data['modules'][$module_id]['hide_lessons'] = 'hidden';
            }else{
                $this->_data['modules'][$module_id]['hide_lessons'] = '';
            }
            foreach($lessons as $lesson){
                $lesson_id = $lesson->id;
                $this->_data['modules'][$module_id]['lessons'][$lesson_id]['lesson_id'] = $lesson_id;
                $this->_data['modules'][$module_id]['lessons'][$lesson_id]['lesson_title'] = $lesson->title;


            }

        }
        $this->breadcrumbs->push('Home', base_url());
        $this->breadcrumbs->push('Subjects', '/d1');
        $this->breadcrumbs->push($subject->name, "/d1a/index/".$subject_id);
        $this->breadcrumbs->push('Year '.$selected_year->year, "/d2_teacher/index/".$subject_id);
        $this->breadcrumbs->push("Curriculum", "/");


        $this->_data['breadcrumb'] = $this->breadcrumbs->show();

        $this->_paste_public();

    }

    function save() {
       
        $subject_id = $this->input->post('subject_id', true);

        $db_data = array(
            'intro' => trim($this->input->post('subject_intro', true)),
            'objectives' => trim($this->input->post('subject_objectives', true)),
            'teaching_activities' => trim($this->input->post('subject_teaching_activities', true)),
            'assessment_opportunities' => trim($this->input->post('subject_assessment_opportunities', true)),
            'notes' => trim($this->input->post('subject_notes', true)),
            'publish' => $this->input->post('publish')
        );

        $this->subjects_model->save($db_data, $subject_id);
        if($this->input->post('redirect')!='') {
            redirect("d4_teacher/index/{$subject_id}", 'refresh'); 
        } else {
            redirect("d3_teacher/index/{$subject_id}", 'refresh');
        }
    }

    function saveajax() {
        $dt = $this->input->post('data');

        $dt_ = array();
        foreach( $dt as $k => $v ) $dt_[$v['name']] = $v['value'];

        if( $dt_ ) {
            $subject_id = $dt_['subject_id'];
            if( $dt_['publish'] ) {
                $dt_['publish'] = 0;
            } else {
                $dt_['publish'] = 1;
            }

            $db_data = array(
                'intro' => $dt_['subject_intro'],
                'objectives' => $dt_['subject_objectives'],
                'teaching_activities' => $dt_['subject_teaching_activities'],
                'assessment_opportunities' => $dt_['subject_assessment_opportunities'],
                'notes' => $dt_['subject_notes'],
                'publish' => $dt_['publish']
            );
            $this->subjects_model->save($db_data, $subject_id);

            echo json_encode( $dt_['publish'] );
        }

    }
}

