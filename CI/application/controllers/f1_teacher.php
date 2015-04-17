<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class F1_teacher extends MY_Controller {

    function __construct() {
        parent::__construct();
		$this->load->model('assignment_model');
        $this->load->library('breadcrumbs');
    }
	
	private function process_assignments($name, $data) {
		$this->_data[$name] = array();
		$this->_data[$name . '_hidden'] = count($data) == 0 ? 'hidden' : '';
		foreach($data as $key => $value){
			$this->_data[$name][$key]['id'] = $value->id;
			$this->_data[$name][$key]['name'] = $value->title;
			$this->_data[$name][$key]['subject_name'] = $value->subject_name;
			$this->_data[$name][$key]['date'] = ($value->deadline_date != '0000-00-00 00:00:00') ? date('D jS M Y', strtotime($value->deadline_date)) : '';
			$this->_data[$name][$key]['total'] = $value->total;
			$this->_data[$name][$key]['submitted'] = $value->submitted;
			$this->_data[$name][$key]['marked'] = $value->marked;
            $this->_data[$name][$key]['published'] = $value->publish;
            if($value->publish>0){$label='Published'; $editor = 'b';}else{$editor = 'c'; $label='Unpublished';}
			$this->_data[$name][$key]['editor'] = $editor;
            $this->_data[$name][$key]['label'] = $label;
        }
	}

    function index() {
                
                //FIND_IN_SET(35, class_id) > 0

        $assigned = $this->assignment_model->get_assignments(array('teacher_id = ' . $this->user_id, 'base_assignment_id=0', 'class_id!=0', 'publish>0', '(marked<total OR total=0)', 'deadline_date > NOW()'));
		$this->process_assignments('assigned', $assigned);

        $drafted =  $this->assignment_model->get_assignments(array('teacher_id = ' . $this->user_id, 'base_assignment_id=0', 'publish=0'));
		$this->process_assignments('drafted', $drafted);
                
        $past = $this->assignment_model->get_assignments(array('teacher_id = ' . $this->user_id, 'base_assignment_id=0', 'class_id!=0', 'publish>0', '(marked<total OR total=0)', 'deadline_date < NOW()'));
		$this->process_assignments('past', $past);
                
        $closed = $this->assignment_model->get_assignments(array('teacher_id = ' . $this->user_id, 'base_assignment_id=0', 'class_id!=0', 'publish>0', '(marked=total AND total!=0)'));
		$this->process_assignments('closed', $closed);	
                
        $this->breadcrumbs->push('Home', base_url());
		
		$this->breadcrumbs->push('Homework', '/f1_teacher');
        $this->_data['breadcrumb'] = $this->breadcrumbs->show();
//echo '<pre>';var_dump( $drafted );die;
        $this->_paste_public();
    }

}
