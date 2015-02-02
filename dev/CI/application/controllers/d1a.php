<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class D1A extends MY_Controller {

    function __construct() {
        parent::__construct();
		$this->load->model('subjects_model');
    }

    function index($subject_id = '') {
        
        
	
                $this->_data['subject_id'] = $subject_id;
		$subject = $this->subjects_model->get_single_subject($subject_id);
		$this->_data['subject_title'] = $subject->name;
		$this->_data['subject_intro'] = $subject->name;
		$this->_data['subject_objectives'] = $subject->name;
        
        
                
        $years = $this->subjects_model->get_subject_years($subject_id);
        $c = 1;
        $arr_count = count($years);
        
	foreach($years as $key=>$val)
        {
			$this->_data['years'][$key]['name'] = 'Year '.$val->year;
			$this->_data['years'][$key]['name_lower'] = strtolower('Year '.$val->year);
			$this->_data['years'][$key]['id'] = $val->id;
            
                    if($c==6){
                                $this->_data['years'][$key]['plus_class'] ='sixth_subject';
                    }
                    elseif($c>5){
                                $this->_data['years'][$key]['plus_class'] ='subject_second_row';
                    }else{
                                $this->_data['years'][$key]['plus_class'] ='';
                    }
                    $c++;
       }
		
        $this->_paste_public();
    }

}
