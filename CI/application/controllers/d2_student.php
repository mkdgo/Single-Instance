<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class D2_student extends MY_Controller {

	function __construct() {
		parent::__construct();

		$this->load->model('modules_model');
		$this->load->model('lessons_model');
		$this->load->model('interactive_content_model');
		$this->load->model('subjects_model');
		$this->load->library('breadcrumbs');
	}

	function index($subject_id = '',$year_id ='') {
            
                $user_year = $this->session->userdata('student_year');
                $selected_year = $this->getSelectYearStudent($this->subjects_model, $subject_id, $user_year);
              
                
               $curriculum= $this->subjects_model->get_subject_curriculum($subject_id,$user_year);
                 $this->_data['curriculum_published']= $curriculum->publish;

		      $selected_year_id = $this->subjects_model->get_student_subject_year($subject_id, $user_year);

		//print_r($selected_year_id);
		//die();


               // print_r($selected_year);
               //die();
                //stdClass Object ( [id] => 1 [subject_id] => 1 [year] => 5 ) 1
                
                
                
		$this->_data['subject_id'] = $subject_id;
		if ($subject_id) {
			$modules = $this->modules_model->get_published_modules(array('subject_id' => $subject_id,'year_id'=>$selected_year_id->id, 'publish' => 1));
//                        echo '<pre>';
//                        print_r($modules);
//                        die();
                        
                } else {
			$modules = 0;
		}
		
		if (count($modules) == 0) {
			$this->_data['hide_modules'] = 'hidden';
		} else {
			$this->_data['hide_modules'] = '';
		}
		
		$subject = $this->subjects_model->get_single_subject($subject_id);
		$this->_data['subject_title'] = $subject->name;
		$this->_data['subject_intro'] = $subject->name;
		$this->_data['subject_objectives'] = $subject->name;
		$this->_data['subject_name'] = $subject->name;
		$c =1;

		foreach ($modules as $module) {
			$module_id = $module->id;
			$this->_data['modules'][$module_id]['module_id'] = $module_id;
			$this->_data['modules'][$module_id]['module_name'] = $module->name;

			$lessons = $this->lessons_model->get_lessons_by_module(array('module_id' => $module_id, 'published_lesson_plan' => 1));

			if (empty($lessons)) {
				$this->_data['modules'][$module_id]['hide_lessons'] = 'hidden';
				$this->_data['modules'][$module_id]['lessons'] = array();
			} else {
				$i = 1;

				foreach ($lessons as $lesson) {
					$lesson_id = $lesson->id;

					/*if (isset($int_lesson->publish) && $int_lesson->publish == '1') {
						$this->_data['modules'][$module_id]['lessons'][$lesson_id]['lesson_link_type'] = 'e1_student';
						$this->_data['modules'][$module_id]['lessons'][$lesson_id]['lesson_hide_icon'] = '';
					} else {
						$this->_data['modules'][$module_id]['lessons'][$lesson_id]['lesson_link_type'] = 'd5_student';
						$this->_data['modules'][$module_id]['lessons'][$lesson_id]['lesson_hide_icon'] = 'hidden';
					}*/
					$this->_data['modules'][$module_id]['lessons'][$lesson_id]['lesson_count'] = $i;
					$this->_data['modules'][$module_id]['lessons'][$lesson_id]['lesson_id'] = $lesson_id;
					$this->_data['modules'][$module_id]['lessons'][$lesson_id]['lesson_title'] = $lesson->title;
					$this->_data['modules'][$module_id]['lessons'][$lesson_id]['lesson_interactive'] = $this->interactive_content_model->if_has_assesments($lesson_id) > 0 ? '<div class="yesdot">YES</div>' : '<div class="nodot">NO</div>';
                                        $this->_data['modules'][$module_id]['lessons'][$lesson_id]['is_slides'] = $this->interactive_content_model->if_has_assesments($lesson_id) > 0 ? '' : 'hidden';
					
                                        $i++;
		
				}
			}

            if(true){
                $this->_data['modules'][$module_id]['clear'] ='<div class="clear"></div>';
                $c=0;
            }else{
                $this->_data['modules'][$module_id]['clear'] ='';
            }
            $c++;
            
		}
                $this->breadcrumbs->push('Home', base_url());
		$this->breadcrumbs->push('Subjects', '/d1');
		$this->breadcrumbs->push($subject->name, "/");
		$this->_data['breadcrumb'] = $this->breadcrumbs->show();

		$this->_paste_public();
	}

}
