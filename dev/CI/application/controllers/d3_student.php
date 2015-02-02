<?php
/*
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class D3_teacher extends MY_Controller {

    function __construct() {
        parent::__construct();
    }

    function index() {
        
        $this->_paste_public();
    }

}
*/


if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class D3_student extends MY_Controller {

    function __construct() {
        parent::__construct();
        
        $this->load->model('modules_model');
        $this->load->model('lessons_model');
        $this->load->model('subjects_model');
		$this->load->model('resources_model');
        $this->load->library('breadcrumbs');
    }

    function index($subject_id = '') {
		$this->_data['subject_id'] = $subject_id;
		$subject = $this->subjects_model->get_single_subject($subject_id);
		$this->_data['subject_title'] = $subject->name;
		$this->_data['subject_intro'] = $subject->intro;
		$this->_data['subject_objectives'] = $subject->objectives;
		$this->_data['subject_teaching_activities'] = $subject->teaching_activities;
		$this->_data['subject_assessment_opportunities'] = $subject->assessment_opportunities;
		$this->_data['subject_notes'] = $subject->notes;
		
		if($subject_id){
        	$modules = $this->modules_model->get_published_modules(					
						array('subject_id' => $subject_id,
						'publish' => 1));}else{
			$modules = 0;
		}
        
	    if(count($modules)==0){
				$this->_data['hide_modules'] = 'hidden';
				$this->_data['modules'] = array();
			} else {
				$this->_data['hide_modules'] = '';
			}

		$odd=0;
	    foreach($modules as $module){
				$module_id = $module->id;
				$this->_data['modules'][$module_id]['module_id'] = $module_id;
				$this->_data['modules'][$module_id]['module_name'] = $module->name;
	            if($odd%2==0){  
	                $this->_data['modules'][$module_id]['float'] = 'moduleLeft';
	                   $this->_data['modules'][$module_id]['clear'] = '';
	            }else{
	                $this->_data['modules'][$module_id]['float'] = 'moduleRight';
	                $this->_data['modules'][$module_id]['clear'] = '<div class="clear"></div>';
	            }
	            $odd++;
				
	            
	      		$lessons = $this->lessons_model->get_lessons_by_module(array('module_id' => $module_id));
				if(empty($lessons)){
					$this->_data['modules'][$module_id]['hide_lessons'] = 'hidden';
					$this->_data['modules'][$module_id]['lessons'] = array();
				}else{
					$this->_data['modules'][$module_id]['hide_lessons'] = '';
				}
				foreach($lessons as $lesson){
						$lesson_id = $lesson->id;
						$this->_data['modules'][$module_id]['lessons'][$lesson_id]['lesson_id'] = $lesson_id;
						$this->_data['modules'][$module_id]['lessons'][$lesson_id]['lesson_title'] = $lesson->title;
	                    
		
				}

	    }

		$this->breadcrumbs->push('Subjects', '/d1');
		$this->breadcrumbs->push($subject->name, "/d2_student/index/".$subject_id);
		$this->breadcrumbs->push("Curriculum", "/");
		$this->_data['breadcrumb'] = $this->breadcrumbs->show();

        $this->_paste_public();
    }

}

