<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Int_assessment_ajax extends MY_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('interactive_assessment_model');
	}

	public function save_temp_data() {
		$assessment_id = $this->input->post('int_assessment_id');
		$db_data = array(
			'temp_data' => serialize($this->input->post('questions'))
		);
		$this->interactive_assessment_model->save_temp_data($db_data, $assessment_id);
		 $data['success'] = true;

		echo json_encode($data);
	}

}