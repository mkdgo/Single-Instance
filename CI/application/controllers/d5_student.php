<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class D5_student extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('lessons_model');
        $this->load->model('modules_model');
        $this->load->model('interactive_content_model');
        $this->load->model('resources_model');
        $this->load->model('subjects_model');
        $this->load->library('breadcrumbs');
    }

    function index($subject_id = '', $module_id = '', $lesson_id = '') {	
        $this->_data['subject_id'] = $subject_id;
        $this->_data['module_id'] = $module_id;
        $this->_data['lesson_id'] = $lesson_id;

        // breadcrumb code
        $this->breadcrumbs->push('Home', base_url());
        $this->breadcrumbs->push('Subjects', '/d1');

        if ($subject_id) {
            $subject = $this->subjects_model->get_single_subject($subject_id);
            $this->breadcrumbs->push($subject->name, "/d2_student/index/".$subject_id);
        }

        $module = $this->modules_model->get_module($module_id);
        $this->breadcrumbs->push($module[0]->name, "/d4_student/index/".$subject_id."/".$module_id);
        // end breadcrumb code

        $interactive_content_exists = $this->interactive_content_model->if_has_assesments($lesson_id);
        $interactive_content_published = $this->lessons_model->interactive_lesson_published($lesson_id);
        
        if ($interactive_content_published > 0) {
            $this->_data['view_interactive_lesson'] = '<a class="red_btn" href="/e1_student/index/'.$subject_id.'/'.$module_id.'/'.$lesson_id.'">VIEW LESSON SLIDES</a>';
            $this->_data['view_lesson'] = '';
        } else {
            $this->_data['view_interactive_lesson'] = '';
            $this->_data['view_lesson'] = '';
        }

        if ($lesson_id) {
            $lesson = $this->lessons_model->get_lesson($lesson_id);
        }
//        echo '<pre>';
//        print_r($lesson);
//        
//        die();
        

        $this->_data['lesson_title'] = $lesson->title;
        $this->_data['lesson_intro'] = $lesson->intro;
        $this->_data['lesson_objectives'] = $lesson->objectives;
        $this->_data['lesson_teaching_activities'] = $lesson->teaching_activities;
        $this->_data['lesson_assessment_opportunities'] = $lesson->assessment_opportunities;
        $this->_data['lesson_notes'] = $lesson->notes;

        $user_year = $this->session->userdata('student_year');
        $resources = $this->resources_model->get_lesson_resources($lesson->id, array( 'restriction_year' => $user_year ) );
//echo '<pre>';var_dump( $resources );die;
        if( !empty($resources) ) {
            foreach ($resources as $k => $v) {
                $this->_data['resources'][$k]['resource_name'] = $v->name;
                $this->_data['resources'][$k]['resource_id'] = $v->res_id;
                $this->_data['resources'][$k]['preview'] = $this->resoucePreview($v, '/d5_student/resource/');
            }
        } else {
            $this->_data['resources'] = array();
        }
        
        $this->breadcrumbs->push($lesson->title, "/");
        $this->_data['breadcrumb'] = $this->breadcrumbs->show();
        $this->_paste_public();
    }

}
