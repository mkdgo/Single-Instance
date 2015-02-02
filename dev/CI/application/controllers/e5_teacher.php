<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class E5_teacher extends MY_Controller {

    function __construct() {
       parent::__construct();
				
			$this->load->model('lessons_model');
			$this->load->model('user_model');
			$this->load->model('interactive_content_model');
			$this->load->model('interactive_assessment_model');			
			$this->load->model('resources_model');
    }

    function index($subject_id = '', $module_id = '', $lesson_id = '', $page_num = 1, $type = 'view', $cont_page_id = '') {
			$this->_data['subject_id'] = $subject_id;
			$this->_data['module_id'] = $module_id;
			$this->_data['lesson_id'] = $lesson_id;
			$this->_data['page_num'] = $page_num;
			$this->_data['type'] = $type;
						
			if (!$this->lessons_model->lesson_exist($lesson_id)) {
				show_404();
			}
			
			if ($type == 'running') {
				$data = array(
					'running_page' => $page_num,
				);			
				$this->lessons_model->save($data, $lesson_id);			
			}
						
			$content_pages = $this->interactive_content_model->get_il_content_pages($lesson_id);

			$curr_cpage = 0;
			//$this->_data['count_res'] = 0;
			$this->_data['content_pages'] = array();
			foreach ($content_pages as $key => $val) {
				if (empty($val->title))
					$val->title = "No title added";

				$this->_data['content_pages'][$key]['cont_page_id'] = $val->id;
				$this->_data['content_pages'][$key]['cont_page_title'] = $val->title;
				$this->_data['content_pages'][$key]['cont_page_text'] = $val->text;
				$this->_data['content_pages'][$key]['cont_page_template_id'] = $val->template_id;
				if ($val->id == $cont_page_id)
					$curr_cpage = $key;
				
				$this->_data['content_pages'][$key]['resources'] = array();
				$resources = $this->resources_model->get_cont_page_resources($val->id);					
				foreach ($resources as $k => $v) {
					$this->_data['content_pages'][$key]['resources'][$k]['resource_name'] = $v->name;
					$this->_data['content_pages'][$key]['resources'][$k]['resource_id'] = $v->res_id;
                                        
                                        $this->_data['content_pages'][$key]['resources'][$k]['preview'] = $this->resoucePreview($v, '/e5_teacher/resource/');
                                        
                                        
                                        
                                }

				//log_message('error', $val->id."-".$cont_page_id);
				if ($val->id == $cont_page_id and $type == 'view')
				{
					$this->_data['count_res'] = count($resources);
					//log_message('error', $this->_data['count_res']);
				}
			}

			if ($type != 'view') // if running page mode
			{
				// if current content is assesment
				if ($page_num > count($this->_data['content_pages']))
				{	
					$int_assessments = $this->interactive_content_model->get_il_int_assesments($lesson_id);
					$this->_data['int_assessments'] = array();

					foreach ($int_assessments as $key => $val) {
						$this->_data['int_assessments'][$key]['assessment_id'] = $val->id;
						$this->unserialize_assessment($val->id, $type);
						$this->_data['int_assessments'][$key] = $this->tmp_data;
						//log_message('error', $val->id."-".$this->_data['int_assessments'][$key]['no_questions']);
					}
				}
				else // we need only count
				{
					$int_assessments = $this->interactive_content_model->get_il_int_assesments($lesson_id);
					$this->_data['int_assessments'] = array();
				}

				$cnt_assesments = count($int_assessments); // count($this->_data['int_assessments'])
			}

			//log_message('error', "cont: ".self::str($this->_data['int_assessments']));
			
			$this->_data['students'] = array();
			if ($type != 'view') {
				$students = $this->user_model->get_students_for_lesson($lesson_id);
				foreach ($students as $key => $value) {
					$this->_data['students'][$key]['id'] = $value->id;
					$this->_data['students'][$key]['first_name'] = $value->first_name;
					$this->_data['students'][$key]['last_name'] = $value->last_name;
					$this->_data['students'][$key]['online'] = $value->online;
				}
			}
			
			// 'conclude lesson'/'close preview' button
			if ($type == 'view') {
				$this->_data['close'] = "/e2/index/{$subject_id}/{$module_id}/{$lesson_id}/{$cont_page_id}";
				$this->_data['close_text'] = 'Close Preview';
			} else {
				$this->_data['close'] = "/e5_teacher/close/{$subject_id}/{$module_id}/{$lesson_id}";
				$this->_data['close_text'] = 'Conclude Lesson';
			}

			$this->_data['prev'] = "/e5_teacher/index/{$subject_id}/{$module_id}/{$lesson_id}/" . ($page_num - 1) . ($type != 'view' ? '/' . $type : '');
			$this->_data['next'] = "/e5_teacher/index/{$subject_id}/{$module_id}/{$lesson_id}/" . ($page_num + 1) . ($type != 'view' ? '/' . $type : '');
			$this->_data['prev_hidden'] = ($type == 'view' || $page_num == 1) ? 'hidden' : '';
			$this->_data['next_hidden'] = ($type == 'view' || $page_num >= count($this->_data['content_pages']) + $cnt_assesments) ? 'hidden' : '';
			
			if ($type == 'view') // preview slide
			{
				$this->_data['content_pages'] = array($this->_data['content_pages'][$curr_cpage]);
				$this->_data['int_assessments'] = array();
			}
			else // launch lesson action
			{
				if ($page_num <= count($this->_data['content_pages'])) {
					// print 'content page slide'
					$this->_data['content_pages'] = array($this->_data['content_pages'][$page_num - 1]);
					$this->_data['int_assessments'] = array();
				} elseif ($page_num <= count($this->_data['content_pages']) + $cnt_assesments) {
					// print 'interactive assessment'
					$assess_index = $page_num - count($this->_data['content_pages']) - 1;

					$this->_data['no_questions'] = $this->_data['int_assessments'][$assess_index]['no_questions']; // set as global flag !
					$this->_data['int_assessments'] = array($this->_data['int_assessments'][$assess_index]);
					$this->_data['content_pages'] = array();
				} else {
					$this->_data['content_pages'] = array();
					$this->_data['int_assessments'] = array();
				}
			}
		        
    		$this->_paste_public();
    }
		
	function close($subject_id = '', $module_id = '', $lesson_id = '') {
		$data = array(
			'running_page' => 0,
			'teacher_led' => 1
		);			
		$this->lessons_model->save($data, $lesson_id);

		redirect("/e1_teacher/index/{$subject_id}/{$module_id}/{$lesson_id}");
	}

}