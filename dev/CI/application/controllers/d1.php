<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class D1 extends MY_Controller {

    function __construct() {
        parent::__construct();
		$this->load->model('subjects_model');
    }

    function index() {
		$user_type = $this->session->userdata('user_type');
		if($user_type == 'teacher'){			
			$this->_data['curriculum_link'] = 'd1a';
			$this->_data['back'] = '/b2';
		}else{
			$this->_data['curriculum_link'] = 'd2_student';
			$this->_data['back'] = '/b1';
		}
        $subjects = $this->subjects_model->get_subjects();
        $c = 1;
        $arr_count = count($subjects);
		foreach($subjects as $key=>$val){
			$this->_data['subjects'][$key]['name'] = $val->name;
			$this->_data['subjects'][$key]['name_lower'] = strtolower($val->name);
			$this->_data['subjects'][$key]['id'] = $val->id;
            
            if($c==6){
		      	$this->_data['subjects'][$key]['plus_class'] ='sixth_subject';
            }
            elseif($c>5){
		      	$this->_data['subjects'][$key]['plus_class'] ='subject_second_row';
            }else{
		      	$this->_data['subjects'][$key]['plus_class'] ='';
            }
            $c++;
		}
		
        $this->_paste_public();
    }

}
