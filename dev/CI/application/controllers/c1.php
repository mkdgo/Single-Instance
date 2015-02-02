<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class C1 extends MY_Controller {

	function __construct() {
            
		parent::__construct();
		$this->load->model('resources_model');
		$this->load->model('modules_model');
		$this->load->model('lessons_model');
		$this->load->model('content_page_model');
		$this->load->model('interactive_assessment_model');
		$this->load->model('assignment_model');
	}
	
	private function getBackUrl($type, $elem_id, $subject_id, $module_id, $lesson_id, $assessment_id) {
		switch ($type) {
			case 'module':
				return "/d4_teacher/index/{$subject_id}/{$elem_id}";
			case 'lesson':
				return "/d5_teacher/index/{$subject_id}/{$module_id}/{$elem_id}";
			case 'content_page':
				return "/e2/index/{$subject_id}/{$module_id}/{$lesson_id}/{$elem_id}";
			case 'question':
				return "/e3/index/{$subject_id}/{$module_id}/{$lesson_id}/{$assessment_id}";
			case 'assignment':
				return "/f2b_teacher/index/{$elem_id}";
			default: // student resource library
				return '/c1';
				//return "/c2/index/resource/{$elem_id}";
		}	
	}

	public function index($type = '', $elem_id = '0', $subject_id = '', $module_id = '',  $lesson_id = '', $assessment_id = '') {	
		
                $this->_data['back'] = $this->getBackUrl($type, $elem_id, $subject_id, $module_id,  $lesson_id, $assessment_id);
                
                
		$this->_data['add'] = "/c2/index/{$type}/{$elem_id}" . ($subject_id ? '/' . $subject_id : '') . ($module_id ? '/' . $module_id : '') . ($lesson_id ? '/' . $lesson_id : '') . ($assessment_id ? '/' . $assessment_id : '');
		//$this->_data['hide_my_resources'] = $this->session->userdata('user_type') == 'teacher' ? '' : 'hidden';
		$this->_data['hide_my_resources'] = $this->session->userdata('user_type') == 'teacher' ? '' : 'hidden';
				
		$resources = $this->resources_model->get_all_resources();
		$this->_data['resources'] = array();
		foreach ($resources as $key => $resource) {
			$this->_data['resources'][$key]['resource_name'] = $resource->name;
			$this->_data['resources'][$key]['resource_id'] = $resource->id;
			if ($type != '') {
				$this->_data['resources'][$key]['resource_link'] = "/c1/save/{$resource->id}/{$type}/{$elem_id}" . ($subject_id ? '/' . $subject_id : '') . ($module_id ? '/' . $module_id : '') . ($lesson_id ? '/' . $lesson_id : '') . ($assessment_id ? '/' . $assessment_id : '');
				$this->_data['resources'][$key]['resource_class'] = '';
                                
                                $save_link = "/c1/save/{$resource->id}/{$type}/{$elem_id}" . ($subject_id ? '/' . $subject_id : '') . ($module_id ? '/' . $module_id : '') . ($lesson_id ? '/' . $lesson_id : '') . ($assessment_id ? '/' . $assessment_id : '');
                                $this->_data['resources'][$key]['preview'] = $this->resoucePreview($resource, $save_link);
			} else { // student resource library
				$this->_data['resources'][$key]['resource_link'] = "/c1/resource/{$resource->id}";
				$this->_data['resources'][$key]['resource_class'] = 'colorbox';
                                $this->_data['resources'][$key]['preview'] = $this->resoucePreview($resource, '/c1/resource/');
			}
		}
		
		$my_resources = $this->resources_model->get_teacher_resources($this->session->userdata('id'));
		$this->_data['my_resources'] = array();
		foreach ($my_resources as $key => $resource) {
			$this->_data['my_resources'][$key]['resource_name'] = $resource->name;
			$this->_data['my_resources'][$key]['resource_id'] = $resource->id;
			if ($type != '') {
				$this->_data['my_resources'][$key]['resource_link'] = "/c1/save/{$resource->id}/{$type}/{$elem_id}" . ($subject_id ? '/' . $subject_id : '') . ($module_id ? '/' . $module_id : '') . ($lesson_id ? '/' . $lesson_id : '') . ($assessment_id ? '/' . $assessment_id : '');
				$this->_data['my_resources'][$key]['resource_class'] = '';
                                 
                                $save_link = "/c1/save/{$resource->id}/{$type}/{$elem_id}" . ($subject_id ? '/' . $subject_id : '') . ($module_id ? '/' . $module_id : '') . ($lesson_id ? '/' . $lesson_id : '') . ($assessment_id ? '/' . $assessment_id : '');
                                $this->_data['my_resources'][$key]['preview'] = $this->resoucePreview($resource, $save_link);
			} else { // student resource library
				$this->_data['my_resources'][$key]['resource_link'] = "/c1/resource/{$resource->id}";
				$this->_data['my_resources'][$key]['resource_class'] = 'colorbox';
                                $this->_data['my_resources'][$key]['preview'] = $this->resoucePreview($resource, '/c1/resource/');
			}
		}		

		$this->_paste_public();
	}
	
	public function save($resource_id, $type, $elem_id = '0', $subject_id = '', $module_id = '', $lesson_id = '', $assessment_id = '') {
		if ($type == 'question') {
			$this->add_question_resource($resource_id, $type, $elem_id, $subject_id, $module_id, $lesson_id, $assessment_id);
		}
		
		if (!$elem_id) {
			switch ($type) {
				case 'module':
					$elem_id = $this->modules_model->save(array('active' => '0'));		
					break;
				case 'lesson':
					$elem_id = $this->lessons_model->save(array('active' => '0'));
					break;
				case 'content_page':
					$elem_id = $this->content_page_model->save(array('active' => '0'));
					break;
				case 'question':
					// created in /e3
					break;
				case 'assignment':
					$elem_id = $this->assignment_model->save(array('active' => '0'));
					break;
			}		
		}
		
		$this->resources_model->add_resource($type, $elem_id, $resource_id);
		
		redirect($this->getBackUrl($type, $elem_id, $subject_id, $module_id,  $lesson_id, $assessment_id), 'refresh');		
	}

	private function add_question_resource($resource_id, $type, $elem_id, $subject_id, $module_id, $lesson_id, $assessment_id) {
		
            $temp_data = unserialize($this->interactive_assessment_model->get_ia_temp_data($assessment_id));

		$temp_data[$elem_id]['question_resource_id'] = $resource_id;
		
		$db_data = array(
			'temp_data' => serialize($temp_data)
		);
		$this->interactive_assessment_model->save_temp_data($db_data, $assessment_id);

		redirect($this->getBackUrl($type, $elem_id, $subject_id, $module_id,  $lesson_id, $assessment_id), 'refresh');				
	}
}
