<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class D4_student extends MY_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('modules_model');
		$this->load->model('resources_model');
        $this->load->model('lessons_model');
        $this->load->model('subjects_model');
        $this->load->library('breadcrumbs');
	}

	function index($subject_id = '', $id = '') {
		$this->_data['subject_id'] = $subject_id;
		$this->_data['module_id'] = $id;

		$mod_name = "New module";
		if ($id) {
			$module_obj = $this->modules_model->get_module($id);
			$mod_name = $module_obj[0]->name;
		}

		// breadcrumb code
        $this->breadcrumbs->push('Home', base_url());
		$this->breadcrumbs->push('Subjects', '/d1');

		if ($subject_id) {	
			$subject = $this->subjects_model->get_single_subject($subject_id);
			if (!empty($subject))
				$this->breadcrumbs->push($subject->name, "/d2_student/index/".$subject_id);
		}

		$this->breadcrumbs->push($mod_name, "/");
		// end breadcrumb code

		if (!empty($module_obj)) {
			foreach ($module_obj as $mod_key => $module) {

				$this->_data['module'][$mod_key]['module_name'] = $module->name;
				$this->_data['module'][$mod_key]['module_intro'] = html_entity_decode ( $module->intro );
				$this->_data['module'][$mod_key]['module_objectives'] = html_entity_decode ( $module->objectives );
				$this->_data['module'][$mod_key]['module_teaching_activities'] = html_entity_decode ( $module->teaching_activities );
				$this->_data['module'][$mod_key]['module_assessment_opportunities'] = html_entity_decode ( $module->assessment_opportunities );
				$this->_data['module'][$mod_key]['module_notes'] = html_entity_decode ( $module->notes );
                $module_id = $module->id;
						
				$lessons = $this->lessons_model->get_lessons_by_module(array('module_id' => $module_id, 'published_lesson_plan' => 1));
				if(empty($lessons)){
					$this->_data['hide_lessons'] = 'hidden';
				}else{
					$this->_data['hide_lessons'] = '';
				}
				$this->_data['hide_add_lesson'] = $module_id ? '' : 'hidden';
				
				foreach($lessons as $lesson){
					$lesson_id = $lesson->id;
					$this->_data['lessons'][$lesson_id]['lesson_id'] = $lesson_id;
					$this->_data['lessons'][$lesson_id]['lesson_title'] = $lesson->title;
				}

				$resources = $this->resources_model->get_module_resources($module_id);
				if (!empty($resources)) {
					foreach ($resources as $k => $v) {
						$this->_data['module'][$mod_key]['resources'][$k]['resource_name'] = $v->name;
						$this->_data['module'][$mod_key]['resources'][$k]['resource_id'] = $v->res_id;
                        $this->_data['module'][$mod_key]['resources'][$k]['preview'] = $this->resoucePreview($v, '/d4_student/resource/');
			
					}
				}else{
					$this->_data['module'][$mod_key]['resources'] = array();
				}
			}
		}
		
		$this->_data['breadcrumb'] = $this->breadcrumbs->show();
		$this->_paste_public();
	}

}
