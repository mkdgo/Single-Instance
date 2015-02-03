<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class D1 extends MY_Controller {

    function __construct() {
        parent::__construct();
		$this->load->model('subjects_model');
                $this->load->library('breadcrumbs');  
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
                
                if($user_type == 'teacher'){
        $subjects = $this->subjects_model->get_subjects();
                }
                else {
         $subjects = $this->subjects_model->get_students_subjects($this->session->userdata('student_year'));
                }
        $c = 1;
        $arr_count = count($subjects);
	foreach($subjects as $key=>$val)
        {
			$this->_data['subjects'][$key]['name'] = $val->name;
			$this->_data['subjects'][$key]['name_lower'] = strtolower($val->name);
			$this->_data['subjects'][$key]['id'] = $val->id;
                        $this->_data['subjects'][$key]['logo_pic'] = $val->logo_pic;
            
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
		//Home > Lessons Plans > Subjects
            $this->breadcrumbs->push('Home', base_url());
            $this->breadcrumbs->push('Lessons plans', '/d1');
            $this->breadcrumbs->push('Subjects', '/d1');
                
            $this->_data['breadcrumb'] = $this->breadcrumbs->show();
                
        $this->_paste_public();
    }

}
