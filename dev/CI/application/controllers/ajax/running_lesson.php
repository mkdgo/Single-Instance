<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Running_lesson extends MY_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('lessons_model');
	}
	
	public function index($student_id) {
		$this->user_model->update_last_seen($student_id);
	
		$running_lesson = $this->lessons_model->get_running_lesson_for_student($student_id);
		
		$data = array();
		if (!empty($running_lesson)) {
			$data = array(
				'subject_id' => $running_lesson->subject_id,
				'module_id' => $running_lesson->module_id,
				'lesson_id' => $running_lesson->id,
				'lesson_title' => $running_lesson->title,
				'teacher_first_name' => $running_lesson->first_name,
				'teacher_last_name' => $running_lesson->last_name,
				'running_page' => $running_lesson->running_page,
				'teacher_led' => $running_lesson->teacher_led
			);
		}
		else
		{
			// check for closed lesson
			$free_lesson = $this->lessons_model->get_free_lesson_for_student($student_id);

			if (!empty($free_lesson)) {
				$data = array(
					'subject_id' => $free_lesson->subject_id,
					'module_id' => $free_lesson->module_id,
					'lesson_id' => $free_lesson->id,
					'lesson_title' => $free_lesson->title,
					'teacher_first_name' => $free_lesson->first_name,
					'teacher_last_name' => $free_lesson->last_name,
					//'running_page' => 1,
					'free_preview' => 1
				);
			}
		}

		//log_message('error', "data: ".self::str($data));
		echo json_encode($data);
	}

}