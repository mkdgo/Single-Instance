<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Online_students extends MY_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('user_model');
	}
	
	public function index($lesson_id) {	
		$students = $this->user_model->get_students_for_lesson($lesson_id, true);
		
		$data = array();
		foreach($students as $key=>$value) {
			$data[$key] = $value->id;
            $this->user_model->reset_online( $value->id );
            
		}
//echo '<pre>';var_dump( $data );die;
//echo '<pre>';var_dump( $students );die;
		echo json_encode($data);
	}

}