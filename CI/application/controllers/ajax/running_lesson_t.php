<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Running_lesson_t extends MY_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('lessons_model');
	}
	
	public function index($teacher_id) {
		//$this->user_model->update_last_seen($teacher_id);
	
		$running_lesson = $this->lessons_model->get_running_lesson_for_teacher($teacher_id);
		
		$data = array();
		if (!empty($running_lesson)) {
			$data = array(
				'subject_id' => $running_lesson->subject_id,
				'module_id' => $running_lesson->module_id,
				'lesson_id' => $running_lesson->id,
				'lesson_title' => $running_lesson->title,
//				'running_page' => $running_lesson->running_page,
				'teacher_led' => $running_lesson->teacher_led
			);
		}

		//log_message('error', "data: ".self::str($data));
		echo json_encode($data);
	}

}