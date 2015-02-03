<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Interactive_lessons_ajax extends MY_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('interactive_content_model');
	}
	public function save_publish(){
		$this->load->model('interactive_content_model');
		$int_les_id= $this->input->post('int_lesson_id');
		$db_data = array(
			'publish' => $this->input->post('slider')
		);
	}
}