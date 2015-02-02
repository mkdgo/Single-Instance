<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class F1_student extends MY_Controller {

  function __construct() {
    parent::__construct();
		$this->load->model('assignment_model');
  }
	
	private function process_assignments($name, $data) {
		$this->_data[$name] = array();
		$this->_data[$name . '_hidden'] = count($data) == 0 ? 'hidden' : '';
		foreach($data as $key => $value){
			$this->_data[$name][$key]['id'] = $value->id;
			$this->_data[$name][$key]['name'] = $value->title;
			$this->_data[$name][$key]['subject_name'] = $value->subject_name;
			$this->_data[$name][$key]['date'] = date('d.m.Y', strtotime($value->deadline_date));
			if ($value->grade) {
				switch ($value->grade_type) {
					case 'percentage':
						$value->grade .= '%';
						break;
					case 'mark_out_of_10':
						$value->grade .= '/10';
						break;
				}
			}			
			$this->_data[$name][$key]['grade'] = $value->grade;
		}	
	}	

  function index() {		
		$opened = $this->assignment_model->get_assignments(array('student_id = ' . $this->user_id, 'publish = 0'));
		$this->process_assignments('opened', $opened);		
		
		$submitted = $this->assignment_model->get_assignments(array('student_id = ' . $this->user_id, 'publish >= 1'));
		$this->process_assignments('submitted', $submitted);		
        
    $this->_paste_public();
  }
}