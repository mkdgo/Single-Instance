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
            //old $subjects = $this->subjects_model->get_subjects();
            $subjects = $this->subjects_model->get_teacher_assigned_subjects($this->session->userdata('id'));
            $not_assigned_subjects = $this->subjects_model->get_teacher_notassigned_subjects($this->session->userdata('id'));

            if( !count($not_assigned_subjects) ) { $this->_data['subjects'] = null; }
            foreach($not_assigned_subjects as $key=>$val) {
                $this->_data['na_subjects'][$key]['name'] = $val->name;
                $this->_data['na_subjects'][$key]['name_lower'] = strtolower($val->name);
                $this->_data['na_subjects'][$key]['id'] = $val->id;
                $this->_data['na_subjects'][$key]['logo_pic'] = $val->logo_pic;
            }

            $c = 1;
            $arr_count = count($subjects);
            if( !$arr_count ) { $this->_data['subjects'] = null; }
            foreach($subjects as $key=>$val) {
                $this->_data['subjects'][$key]['name'] = $val->name;
                $this->_data['subjects'][$key]['name_lower'] = strtolower($val->name);
                $this->_data['subjects'][$key]['id'] = $val->id;
                $this->_data['subjects'][$key]['logo_pic'] = $val->logo_pic;

                if ($c == 6) {
                    $this->_data['subjects'][$key]['plus_class'] = 'sixth_subject';
                } elseif ($c > 5) {
                    $this->_data['subjects'][$key]['plus_class'] = 'subject_second_row';
                } elseif($arr_count==4){
                    $this->_data['subjects'][$key]['plus_class'] ='subject_row4';
                } elseif($arr_count==3){
                    $this->_data['subjects'][$key]['plus_class'] ='subject_row3';
                } elseif($arr_count==2){
                    $this->_data['subjects'][$key]['plus_class'] ='subject_row2';
                } elseif($arr_count==1){
                    $this->_data['subjects'][$key]['plus_class'] ='subject_row1';
                } else {
                    $this->_data['subjects'][$key]['plus_class'] = '';
                }
                $c++;
            }
        } else {
            $subjects = $this->subjects_model->get_students_subjects($this->session->userdata('student_year'),$this->user_id);
            $c = 1;
            $arr_count = count($subjects);
            if( !$arr_count ) { $this->_data['subjects'] = null; }
            foreach($subjects as $key=>$val) {
                $this->_data['subjects'][$key]['name'] = $val->name;
                $this->_data['subjects'][$key]['name_lower'] = strtolower($val->name);
                $this->_data['subjects'][$key]['id'] = $val->id;
                $this->_data['subjects'][$key]['logo_pic'] = $val->logo_pic;
                if ($c == 6) {
                    $this->_data['subjects'][$key]['plus_class'] = 'sixth_subject';
                } elseif ($c > 5) {
                    $this->_data['subjects'][$key]['plus_class'] = 'subject_second_row';
                } elseif($arr_count==4){
                    $this->_data['subjects'][$key]['plus_class'] ='subject_row4';
                } elseif($arr_count==3){
                    $this->_data['subjects'][$key]['plus_class'] ='subject_row3';
                } elseif($arr_count==2){
                    $this->_data['subjects'][$key]['plus_class'] ='subject_row2';
                } elseif($arr_count==1){
                    $this->_data['subjects'][$key]['plus_class'] ='subject_row1';
                } else {
                    $this->_data['subjects'][$key]['plus_class'] = '';
                }
                $c++;
            }
            $this->_data['na_subjects'] = null;
        }

		//Home > Lessons Plans > Subjects
        $this->breadcrumbs->push('Home', base_url());
        //$this->breadcrumbs->push('Lessons plans', '/d1');
        $this->breadcrumbs->push('Subjects', '/d1');
                
        $this->_data['breadcrumb'] = $this->breadcrumbs->show();
                
        $this->_paste_public();
    }

}
