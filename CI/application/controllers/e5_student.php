<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class E5_student extends MY_Controller {

	function __construct() {
		parent::__construct();

		$this -> load -> model('lessons_model');
		$this -> load -> model('interactive_content_model');
		$this -> load -> model('interactive_assessment_model');
		$this -> load -> model('resources_model');
	}

	function index($subject_id = '', $module_id = '', $lesson_id = '', $page_num = 1, $type = 'view') {
		$this -> _data['subject_id'] = $subject_id;
		$this -> _data['module_id'] = $module_id;
		$this -> _data['lesson_id'] = $lesson_id;

		$lesson = $this -> lessons_model -> get_lesson($lesson_id);
		if (empty($lesson)) {
			show_404();
		}

		$content_pages = $this -> interactive_content_model -> get_il_content_pages($lesson_id);
		$this -> _data['content_pages'] = array();
		foreach ($content_pages as $key => $val) {
			$this -> _data['content_pages'][$key]['cont_page_id'] = $val -> id;
			$this -> _data['content_pages'][$key]['cont_page_title'] = $val -> title;
			$this -> _data['content_pages'][$key]['cont_page_text'] = $val -> text;
			$this -> _data['content_pages'][$key]['cont_page_template_id'] = $val -> template_id;

			$this -> _data['content_pages'][$key]['resources'] = array();
			$resources = $this -> resources_model -> get_cont_page_resources($val -> id);
			foreach ($resources as $k => $v) {
				$this -> _data['content_pages'][$key]['resources'][$k]['resource_name'] = $v -> name;
				$this -> _data['content_pages'][$key]['resources'][$k]['resource_id'] = $v -> res_id;
				$this -> _data['content_pages'][$key]['resources'][$k]['preview'] = $this -> resoucePreview($v, '/e5_student/resource/');

			}
		}

		$int_assessments = $this -> interactive_content_model -> get_il_int_assesments($lesson_id);
		$this -> _data['int_assessments'] = array();

		foreach ($int_assessments as $key => $val) {
			$this -> _data['int_assessments'][$key]['assessment_id'] = $val -> id;
			$this -> unserialize_assessment($val -> id);
			$this -> _data['int_assessments'][$key] = $this -> tmp_data;
		}

		$teacher_led = !$lesson -> teacher_led;
		$this->_data['close'] = "/e1_student/index/{$subject_id}/{$module_id}/{$lesson_id}";
		$this->_data['close_text'] = 'Close Lesson';
		$this->_data['running'] = !$lesson -> teacher_led;
		// $type == 'running' &&
		/*
		 $this->_data['prev'] = "/e5_student/index/{$subject_id}/{$module_id}/{$lesson_id}/" . ($page_num - 1) . ($type != 'view' ? '/' . $type : '');
		 $this->_data['next'] = "/e5_student/index/{$subject_id}/{$module_id}/{$lesson_id}/" . ($page_num + 1) . ($type != 'view' ? '/' . $type : '');
		 $this->_data['prev_hidden'] = ($page_num == 1 || $teacher_led) ? 'hidden' : '';
		 $this->_data['next_hidden'] = ($page_num >= count($this->_data['content_pages']) + count($this->_data['int_assessments']) || $teacher_led) ? 'hidden' : '';
		 $this->_data['close_hidden'] = $teacher_led ? 'hidden' : '';
		 $this->_data['call_active'] = $teacher_led ? 'true' : 'false';

		 if ($page_num <= count($this -> _data['content_pages'])) {
		 $this -> _data['content_pages'] = array($this -> _data['content_pages'][$page_num - 1]);
		 $this -> _data['int_assessments'] = array();
		 } elseif ($page_num <= (count($this -> _data['content_pages']) + count($this -> _data['int_assessments']))) {
		 //log_message('error', "ci = ".($page_num - count($this->_data['content_pages']) - 1)."; all cnt = ".count($this->_data['int_assessments']));
		 $this -> _data['int_assessments'] = array($this -> _data['int_assessments'][$page_num - count($this -> _data['content_pages']) - 1]);
		 $this -> _data['content_pages'] = array();
		 *
		if ($page_num <= count($this -> _data['content_pages'])) {
			// print 'content page slide'
			//$this->_data['content_pages'] = array($this->_data['content_pages'][$page_num - 1]);
			$this -> _data['int_assessments'] = array();
		} elseif ($page_num <= count($this -> _data['content_pages']) + $cnt_assesments) {
			$assess_index = $page_num - count($this -> _data['content_pages']) - 1;
			$this -> _data['no_questions'] = $this -> _data['int_assessments'][$assess_index]['no_questions'];
			// set as global flag !
			$this -> _data['int_assessments'] = array($this -> _data['int_assessments'][$assess_index]);
			//$this->_data['int_assessments'] = array($this->_data['int_assessments']);
			$this -> _data['content_pages'] = array();
		} else {
			$this -> _data['content_pages'] = array();
			$this -> _data['int_assessments'] = array();
		}
		 * */
		 

		$this -> _paste_public();
	}

}