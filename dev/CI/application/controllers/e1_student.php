<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class E1_student extends MY_Controller {

    function __construct() {
        parent::__construct();
                $this->load->model('interactive_content_model');
		$this->load->model('lessons_model');
		$this->load->model('classes_model');
		$this->load->model('modules_model');
		$this->load->model('subjects_model');
                $this->load->library('breadcrumbs');
    }

    function index($subject_id = '',$module_id = '', $lesson_id = '')
    {
        
                $this->_data['subject_id'] = $subject_id;
		$this->_data['module_id'] = $module_id;
		$this->_data['lesson_id'] = $lesson_id;
		$lesson = $this->lessons_model->get_lesson($lesson_id);

		if (empty($lesson))
			show_404();

		// breadcrumb code
		$this->breadcrumbs->push('Subjects', '/d1');

		if($subject_id)
		{	
			$subject = $this->subjects_model->get_single_subject($subject_id);
			$this->breadcrumbs->push($subject->name, "/d2_student/index/".$subject_id);
		}

		$module = $this->modules_model->get_module($module_id);
		$this->breadcrumbs->push($module[0]->name, "/d4_student/index/".$subject_id."/".$module_id);
		$this->breadcrumbs->push($lesson->title, "/d5_student/index/".$subject_id."/".$module_id."/".$lesson_id);
		// end breadcrumb code

		/*
                if (!$lesson->interactive_lesson_exists) {
			$data = array(
				'interactive_lesson_exists' => 1,
			);
			$this->lessons_model->save($data, $lesson_id);		
		}
                */
                 	

		//get content pages slides
		$N=1;
                $content_pages = $this->interactive_content_model->get_il_content_pages($lesson_id);
		if(!empty($content_pages)){
			foreach ($content_pages as $kay => $val) {
				if (strlen($val->title) > 17)
					$val->title = substr($val->title, 0, 17)." ...";

				$this->_data['content_pages'][$kay]['cont_page_title'] = $val->title;
				$this->_data['content_pages'][$kay]['cont_page_id'] = $val->id;
                                $this->_data['content_pages'][$kay]['N'] = $N;
                                $N++;
			}
		}else{
			$this->_data['content_pages'] = array();
		}
		
		$int_assessments = $this->interactive_content_model->get_il_int_assesments($lesson_id);
		if(!empty($int_assessments)){
		foreach($int_assessments as $assessment_key =>$assessment){
			$this->_data['int_assessments'][$assessment_key]['assessment_id']=$assessment->id;
                        $this->_data['int_assessments'][$assessment_key]['N'] = $N;
                        $N++;
		}
		}else{
			$this->_data['int_assessments'] = array();
		}

		if ($lesson->teacher_led) {
			$this->_data['teacher_led'] = 'checked="checked"';
			$this->_data['student_led'] = '';
		} else {
			$this->_data['teacher_led'] = '';
			$this->_data['student_led'] = 'checked="checked"';
		}		
		
		if ($lesson->published_interactive_lesson) {
			$this->_data['il_publish_1'] = 'selected="selected"';
		} else {
			$this->_data['il_publish_0'] = 'selected="selected"';
		}
		
                
                
		//$this->_data['launch_disabled'] = count($content_pages) + count($int_assessments) > 0 ? '' : 'disabled="disabled"';
		
		$this->breadcrumbs->push("Slides", "/");
		$this->_data['breadcrumb'] = $this->breadcrumbs->show();
		$this->_paste_public();
       
        
    }

}