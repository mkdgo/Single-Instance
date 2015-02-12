<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class D5_teacher extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('lessons_model');

        $this->load->model('content_page_model');
        $this->load->model('interactive_assessment_model');

        $this->load->model('modules_model');
        $this->load->model('interactive_content_model');
        $this->load->model('resources_model');
        $this->load->model('subjects_model');
        $this->load->library('breadcrumbs');

        $this->load->library( 'nativesession' );

    }

    public function index($subject_id, $module_id, $lesson_id = '0') {

        $selected_year = $this->getSelectYearTeacher($this->nativesession, $this->subjects_model, $subject_id, '');

        $user_type = $this->session->userdata('user_type');
        if($user_type == 'teacher'){			
            $this->_data['curriculum_link'] = 'd5_teacher';
            $this->_data['_header']['firstBack'] = 'saveform';
            $this->_data['_header']['secondback'] = '0';
        }else{
            $this->_data['curriculum_link'] = 'd5_student';
            $this->_data['_header']['back'] = '/d4_student/index/'.$subject_id.'/'.$module_id;
        }

        $this->_data['subject_id'] = $subject_id;
        $this->_data['module_id'] = $module_id;
        $this->_data['lesson_id'] = $lesson_id;

        // breadcrumb code
        $this->breadcrumbs->push('Home', base_url());
        $this->breadcrumbs->push('Subjects', '/d1');

        if( $subject_id ) {	
            $subject = $this->subjects_model->get_single_subject($subject_id);
            $this->breadcrumbs->push($subject->name, "/d1a/index/".$subject_id);
        }

        $this->breadcrumbs->push('Year '.$selected_year->year, "/d2_teacher/index/".$subject_id);

        $module = $this->modules_model->get_module($module_id);
        $this->breadcrumbs->push($module[0]->name, "/d4_teacher/index/".$subject_id."/".$module_id);
        // end breadcrumb code

        $interactive_content_exists = $this->interactive_content_model->if_has_assesments($lesson_id);

        if($lesson_id != 0) {
            if ($interactive_content_exists > 0) {
                $this->_data['create_edit_interactive_lesson'] = '<a href="/e1_teacher/index/'.$subject_id.'/'.$module_id.'/'.$lesson_id.'" class="red_btn">EDIT INTERACTIVE LESSON</a>';

            } else {
                $this->_data['create_edit_interactive_lesson'] = '<a href="/e1_teacher/index/'.$subject_id.'/'.$module_id.'/'.$lesson_id.'" class="red_btn">CREATE INTERACTIVE LESSON</a>';
            }
        } else {
            $this->_data['create_edit_interactive_lesson'] = '';
        }
        $lesson = $this->lessons_model->get_lesson($lesson_id);

        $this->_data['lesson_title'] = isset($lesson->title) ? $lesson->title : '';
        $this->_data['lesson_intro'] = isset($lesson->intro) ? $lesson->intro : '';
        $this->_data['lesson_objectives'] = isset($lesson->objectives) ? $lesson->objectives : '';
        $this->_data['lesson_teaching_activities'] = isset($lesson->teaching_activities) ? $lesson->teaching_activities : '';
        $this->_data['lesson_assessment_opportunities'] = isset($lesson->assessment_opportunities) ? $lesson->assessment_opportunities : '';
        $this->_data['lesson_notes'] = isset($lesson->notes) ? $lesson->notes : '';
        $this->_data['publish'] = isset($lesson->published_lesson_plan) ? $lesson->published_lesson_plan : '0';

        $this->_data['publish_active'] = '';
        $this->_data['publish_text'] = 'PUBLISH';
        if( $this->_data['publish'] == 1) {
            $this->_data['publish_active'] = 'active';
            $this->_data['publish_text'] = 'PUBLISHED';
            
        } else {
            $this->_data['publish_active'] = '';
            $this->_data['publish_text'] = 'PUBLISH';
        }


        if (isset($lesson->published_lesson_plan) && $lesson->published_lesson_plan == 1) {
            $this->_data['lesson_publish_0'] = '';
            $this->_data['lesson_publish_1'] = 'selected="selected"';
        } else {
            $this->_data['lesson_publish_0'] = 'selected="selected"';
            $this->_data['lesson_publish_1'] = '';
        }		

        if (isset($lesson->interactive_lesson_exists) && $lesson->interactive_lesson_exists) {
            $this->_data['int_lesson_text'] = 'Interactive Lesson';
            $this->_data['int_les_id'] = (isset($int_less_exist->interactive_lesson_id))?$int_less_exist->interactive_lesson_id  : '' ;		
        } else {
            $this->_data['int_lesson_text'] = 'Create interactive lesson';
            $this->_data['int_les_id'] = '';		
        }		

        $this->_data['resource_hidden'] = 'hidden';
        if ($lesson_id != 0) // show resources only for existing lesson
        {
            $resources = $this->resources_model->get_lesson_resources($lesson_id);
            if (!empty($resources)) {
                $this->_data['resource_hidden'] = '';

                foreach ($resources as $k => $v) {
                    $this->_data['resources'][$k]['resource_name'] = $v->name;
                    $this->_data['resources'][$k]['resource_id'] = $v->res_id;
                    $this->_data['resources'][$k]['preview'] = $this->resoucePreview($v, '/d5_teacher/resource/');
                }
            }
        }

        if ($lesson_id != 0){
            $this->_data['add_resource_button'] = '<a class=" right red_button add_lesson_butt" href="/c1/index/lesson/'.$lesson_id.'/'.$subject_id.'/'.$module_id.'" data-role="button" data-mini="true" data-icon="plus">ADD</a>';
            $this->_data['resource2_hidden'] = '';

        } else {
            $this->_data['add_resource_button'] = '';
            $this->_data['resource2_hidden'] = 'hidden';
            $this->_data['resource_hidden'] = 'hidden';
        }

        $less_name = (isset($lesson->title) ? $lesson->title : 'Lesson');
        $this->breadcrumbs->push($less_name, "/");
        $this->_data['breadcrumb'] = $this->breadcrumbs->show();
        $this->_paste_public();
    }

    public function save() {
        $subject_id = $this->input->post('subject_id', true);
        $module_id = $this->input->post('module_id', true);
        $lesson_id = $this->input->post('lesson_id', true);

        $db_data = array(
        'title' => trim($this->input->post('lesson_title', true)),
        'intro' => trim($this->input->post('lesson_intro', true)),
        'objectives' => trim($this->input->post('lesson_objectives', true)),
        'teaching_activities' => trim($this->input->post('lesson_teaching_activities', true)),
        'assessment_opportunities' => trim($this->input->post('lesson_assessment_opportunities', true)),
        'notes' => trim($this->input->post('lesson_notes', true)),
        'module_id' => trim($this->input->post('module_id', true)),
        'published_lesson_plan' => trim($this->input->post('publish', true)),
        'active' => '1'
        );

        $lesson_id = $this->lessons_model->save($db_data, $lesson_id);


        if ($this->input->post('submit') == 'Save') {
            redirect("/d5_teacher/index/{$subject_id}/{$module_id}/{$lesson_id}");
            //redirect("/d2_teacher/index/{$subject_id}");
        }
        else if($this->input->post('redirect')!='')
        {
        redirect("c1/index/lesson/".$this->input->post('redirect')); 
        }
        else {
            redirect("/d5_teacher/index/{$subject_id}/{$module_id}/{$lesson_id}");
            //	redirect("/d2_teacher/index/{$subject_id}");
        }
    }

    function saveajax() {
        $dt = $this->input->post('data');

        $dt_ = array();
        foreach( $dt as $k => $v ) $dt_[$v['name']]=$v['value'];

        if( $dt_ ) {
            $subject_id = $dt_['subject_id'];
            $module_id = $dt_['module_id'];
            $lesson_id = $dt_['lesson_id'];
            if( $dt_['publish'] ) {
                $dt_['publish'] = 0;
            } else {
                $dt_['publish'] = 1;
            }

            $db_data = array(
                'title' => $dt_['lesson_title'],
                'intro' => $dt_['lesson_intro'],
                'objectives' => $dt_['lesson_objectives'],
                'teaching_activities' => $dt_['lesson_teaching_activities'],
                'assessment_opportunities' => $dt_['lesson_assessment_opportunities'],
                'notes' => $dt_['lesson_notes'],
                'module_id' => $dt_['module_id'],
                'published_lesson_plan' => $dt_['publish'],
                'active' => '1'
            );

            $lesson_id = $this->lessons_model->save($db_data, $lesson_id);
            $json['lesson_id']=$lesson_id;
            $json['publish']=$dt_['publish'];
            echo json_encode( $json );
        }

        //  die(var_dump($dt_));
//        echo $lesson_id;

    }

}