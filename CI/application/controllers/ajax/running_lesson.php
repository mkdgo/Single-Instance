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
        $this->user_model->update_online($student_id);
//		$this->user_model->update_last_seen($student_id);
	
		$running_lesson = $this->lessons_model->get_running_lesson_for_student($student_id);
		$data = array();
		if (!empty($running_lesson)) {
            $token = json_decode( $running_lesson->token );
            $this->_data['secret'] = $token->secret;
            $this->_data['socketId'] = $token->socketId;
            $show_slide_results = array();
            $this->db->select('id, show_answers')->where('lesson_id',$running_lesson->id);
            $query = $this->db->get('content_page_slides')->result_array();
            foreach( $query as $k => $v ) {
                $show_slide_results[$v['id']] = $v['show_answers'];
            }

			$data = array(
				'subject_id' => $running_lesson->subject_id,
				'module_id' => $running_lesson->module_id,
				'lesson_id' => $running_lesson->id,
				'lesson_title' => $running_lesson->title,
				'teacher_first_name' => $running_lesson->first_name,
                'teacher_last_name' => $running_lesson->last_name,
//                'running_page' => $running_lesson->running_page,
                'secret' => $token->secret,
				'socketId' => $token->socketId,
                'show_answers' => $running_lesson->show_answers,
                'slide_show_result' => $show_slide_results,
				'teacher_led' => 1//$running_lesson->teacher_led
			);
		} else {
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