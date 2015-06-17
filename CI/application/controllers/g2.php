<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class G2 extends MY_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('lessons_model');
	}

	function index($student_id = '', $student_year = '0', $subject_id = '', $module_id = '', $lesson_id = '', $lesson_page = '', $lesson_type = '') {
		$this->_data['student_id'] = $student_id;
		$this->_data['student_year'] = $student_year;
		$this->_data['subject_id'] = $subject_id;
		$this->_data['module_id'] = $module_id;
		$this->_data['lesson_id'] = $lesson_id;
		$this->_data['lesson_page'] = $lesson_page;
		$this->_data['lesson_type'] = $lesson_type;		
		if ($lesson_id == '') {
			$this->_data['back'] = '/b2';
		} else {
			$this->_data['back'] = "/e5_teacher/index/{$subject_id}/{$module_id}/{$lesson_id}/{$lesson_page}/{$lesson_type}";
		}		
		
		if ($lesson_id == '') {
			$students = $this->user_model->get_students_for_teacher($this->user_id);
		} else {
			$students = $this->user_model->get_students_for_lesson($lesson_id);
		}
		
		$this->_data['students'] = array();
		foreach ($students as $key => $student) {
			$this->_data['students'][$student->id]['student_id'] = $student->id;
			$this->_data['students'][$student->id]['first_name'] = $student->first_name;
			$this->_data['students'][$student->id]['last_name'] = $student->last_name;
			$this->_data['students'][$student->id]['url'] = "/g2/index/{$student->id}" . ($lesson_id != '' ? "/0/{$subject_id}/{$module_id}/{$lesson_id}/{$lesson_page}/{$lesson_type}" : '');
		}		
		
		$this->_data['student'] = array();
		if($student_id != '') {
			$student_ids = array_keys($this->_data['students']); 
			$index = array_search($student_id, $student_ids);
			if ($index !== FALSE) { // student IS from teacher/lesson class
		
				$student = $this->user_model->get_user($student_id);
				$this->_data['student'][0]['first_name'] = $student->first_name;
				$this->_data['student'][0]['last_name'] = $student->last_name;

				if ($index > 0) {
					$this->_data['prev'] = "/g2/index/" . ($student_ids[$index - 1]) . ($lesson_id != '' ? "/0/{$subject_id}/{$module_id}/{$lesson_id}/{$lesson_page}/{$lesson_type}" : '');
				} else {
					$this->_data['prev'] = '';
				}
				
				if ($index < count($student_ids) - 1) {
					$this->_data['next'] = "/g2/index/" . ($student_ids[$index + 1]) . ($lesson_id != '' ? "/0/{$subject_id}/{$module_id}/{$lesson_id}/{$lesson_page}/{$lesson_type}" : '');
				} else {
					$this->_data['next'] = '';
				}
								
				reset($student_ids);
				$this->_data['prev_hidden'] = $student_id == current($student_ids) ? 'hidden' : '';
				end($student_ids);
				$this->_data['next_hidden'] = $student_id == current($student_ids) ? 'hidden' : '';			
				
				if ($student_year == '0') {
					$student_year = $student->student_year;
				}
				
				$this->_data['student'][0]['year'] = $student_year;
				
				$student_years = array();
				$classes = $this->user_model->get_student_classes($student_id); 
				$this->_data['student'][0]['classes'] = array();
				foreach ($classes as $key => $value) {
					$student_years[$value->year] = $value->year;					
					if ($value->year == $student_year) {
						$this->_data['student'][0]['classes'][$key]['subject_name'] = $value->subject_name;
						$this->_data['student'][0]['classes'][$key]['year'] = $value->year;
						$this->_data['student'][0]['classes'][$key]['group_name'] = str_replace( $value->year, '', $value->group_name );
					}
				} 
				
				$this->_data['prev_year'] = "/g2/index/{$student_id}/" . (isset($student_years[$student_year - 1]) ? $student_year - 1 : '') . ($lesson_id != '' ? "/{$subject_id}/{$module_id}/{$lesson_id}/{$lesson_page}/{$lesson_type}" : '');
				$this->_data['prev_year_hidden'] = isset($student_years[$student_year - 1]) ? '' : 'hidden';
				$this->_data['next_year'] = "/g2/index/{$student_id}/" . (isset($student_years[$student_year + 1]) ? $student_year + 1 : '') . ($lesson_id != '' ? "/{$subject_id}/{$module_id}/{$lesson_id}/{$lesson_page}/{$lesson_type}" : '');
				$this->_data['next_year_hidden'] = isset($student_years[$student_year + 1]) ? '' : 'hidden';
			}
		}
		
		$this->_paste_public();
	}

}