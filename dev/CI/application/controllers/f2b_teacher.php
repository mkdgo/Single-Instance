<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class F2b_teacher extends MY_Controller {

	function __construct()
        {
		parent::__construct();
		$this->load->model('assignment_model');
		$this->load->model('subjects_model');
		$this->load->model('resources_model');
		$this->load->model('user_model');
                $this->load->helper('url');
	}

	function index($id = '-1') {
            
            
		$this->_data['assignment_id'] = $id;
                
                if( strpos(current_url(), 'f2c') )$mode=1;else $mode=2;
                $this->_data['mode'] = $mode;
                
               
                
		$assignment = $this->assignment_model->get_assignment($id);			

		$this->_data['assignment_title'] = isset($assignment->title) ? $assignment->title : '';
		$this->_data['assignment_intro'] = isset($assignment->intro) ? $assignment->intro : '';
		if (isset($assignment->deadline_date) && $assignment->deadline_date != '0000-00-00 00:00:00') {
			$date_time = strtotime($assignment->deadline_date);
			$date = date('Y-m-d', $date_time);
			$time = date('H:i', $date_time);
		} else {
			$date = '';
			$time = '';
		}
		$this->_data['assignment_date'] = $date;
		$this->_data['assignment_time'] = $time;

		$this->_data['selected_grade_type_pers'] = '';
		$this->_data['selected_grade_type_mark_out'] = '';
		$this->_data['selected_grade_type_grade'] = '';
		$this->_data['selected_grade_type_free_text'] = '';
		if (isset($assignment->grade_type)) {
			switch ($assignment->grade_type) {
				case 'percentage':
					$this->_data['selected_grade_type_pers'] = 'selected="selected"';
					break;
				case 'mark_out_of_10':
					$this->_data['selected_grade_type_mark_out'] = 'selected="selected"';
					break;
				case 'grade':
					$this->_data['selected_grade_type_grade'] = 'selected="selected"';
					break;
				case 'free_text':
					$this->_data['selected_grade_type_free_text'] = 'selected="selected"';
					break;
			}
		}
		
		$this->_data['published'] = $assignment->publish;
		$this->_data['class_id'] = isset($assignment->class_id) ? $assignment->class_id : '';
		
                
		$subjects = $this->subjects_model->get_subjects();
		foreach ($subjects as $key => $subject) {
			if (isset($assignment->assigned_to)) {
				if (($key + 1) == $assignment->assigned_to) {
					$this->_data['subjects'][$key]['sel_selected_subjects'] = set_select('subjects', isset($assignment->assigned_to) ? $assignment->assigned_to : '', TRUE);
				} else {
					$this->_data['subjects'][$key]['sel_selected_subjects'] = set_select('subjects', isset($assignment->assigned_to) ? $assignment->assigned_to : '');
				}
			} else {
				$this->_data['subjects'][$key]['sel_selected_subjects'] = '';
			}
			$this->_data['subjects'][$key]['subject_id'] = $subject->id;
			$this->_data['subjects'][$key]['subject_name'] = $subject->name;
		}
		
		$this->_data['resources'] = array();
		$resources = $this->resources_model->get_assignment_resources($id);
		if (!empty($resources)) {
			$this->_data['resource_hidden'] = '';
			foreach ($resources as $k => $v) {
				$this->_data['resources'][$k]['resource_name'] = $v->name;
				$this->_data['resources'][$k]['resource_id'] = $v->res_id;
                                $this->_data['resources'][$k]['preview'] = $this->resoucePreview($v, '/f2b_teacher/');
			}
		} else {
			$this->_data['resource_hidden'] = 'hidden';
		}
               
                $classes_years = $this->assignment_model->get_teacher_years_assigment($this->user_id);
		foreach($classes_years as $k=>$CY)
                {
                    $classes_year_subjects = $this->assignment_model->get_teacher_subjects_assigment($this->user_id, $CY->year);
                    
                    foreach($classes_year_subjects as $ck=>$CS)
                    {
                        $classes_year_subject_slasses =  $this->assignment_model->get_teacher_classes_assigment($this->user_id, $CS->subject_id, $CY->year);
                        $classes_year_subjects[$ck]->classes = $classes_year_subject_slasses;
                     }
                    
                    $classes_years[$k]->subjects = $classes_year_subjects;
                }
                
                $this->_data['classes_years']=$classes_years;
                $this->_data['classes_years_json']=json_encode($classes_years);
               
                $assignment_categories = $this->assignment_model->get_assignment_categories($id);
                $this->_data['assignment_categories'] = $assignment_categories;
                $this->_data['assignment_categories_json'] = json_encode($assignment_categories);
                
                $assignment_attributes = $this->assignment_model->get_assignment_attributes($id);
                $this->_data['assignment_attributes'] = $assignment_attributes;
                $this->_data['assignment_attributes_json'] = json_encode($assignment_attributes);
                
                
                
		$student_assignments = $this->assignment_model->get_student_assignments($id);
		$this->_data['student_assignments'] = array();
		foreach ($student_assignments as $key => $value) {			
			$this->_data['student_assignments'][$key]['id'] = $value->id;
			$this->_data['student_assignments'][$key]['submitted'] = $value->submitted;
			$this->_data['student_assignments'][$key]['submitted_on_time'] = $value->submitted_on_time;						
			if ($value->grade) {
				switch ($value->grade_type) {
					case 'percentage':
						$value->grade .= '%';
						break;
					case 'mark_out_of_10':
						$value->grade .= '/10';
						break;
				}
			}
			$this->_data['student_assignments'][$key]['grade'] = $value->grade;
			$this->_data['student_assignments'][$key]['first_name'] = $value->first_name;
			$this->_data['student_assignments'][$key]['last_name'] = $value->last_name;
			
			$this->_data['student_assignments'][$key]['data_icon'] = $value->submitted_on_time ? 'check' : 'delete';
                        
			$this->_data['student_assignments'][$key]['data_icon_hidden'] = $value->submitted ? '' : 'hidden';
			$this->_data['student_assignments'][$key]['submission_status'] = $value->publish ? '<div class="yesdot">YES</div>' : '<div class="nodot">NO</div>';
		}
		$this->_data['student_subbmission_hidden'] = count($student_assignments) > 0 ? '' : 'hidden';

		$this->_paste_public();
	}

	public function save()
        {
		$id = $this->doSave(0);
                
                header('Content-Type: application/json');
                echo json_encode(Array('ok'=>1, 'id'=>$id));
                exit();
	}
        
        public function saveaddresource($publish)
        {
		if($publish==1)$this->savepublish();else $this->save(); 
	}
        
        public function savepublish()
        {
            $message = Array();
            if($this->input->post('class_id')=='')$message[]='You must choose at least one class !';
            if($this->input->post('assignment_title')=='')$message[]='You must fill the title of the assignment !';
            if($this->input->post('assignment_intro')=='')$message[]='You must add the summary information for the assignment !';
            if($this->input->post('deadline_date')=='' || $this->input->post('deadline_time')=='')$message[]='You must specify the deadlines!';           

            if(empty($message))
            {
                $id = $this->doSave(1);
                
                header('Content-Type: application/json');
                echo json_encode(Array('ok'=>1, 'id'=>$id ));
                exit();
            }
            else
            {
                header('Content-Type: application/json');
                echo json_encode(Array('ok'=>0, 'mess'=>$message));
                exit();
            }    
		
	}

        private function doSave($publish)
        { 
                $id = $this->input->post('assignment_id');
		if($id==-1)$id='';
                
                if($this->input->post('class_id')=='')$class_id=0;else $class_id=$this->input->post('class_id');
                $deadline_date = strtotime($this->input->post('deadline_date') . ' ' . $this->input->post('deadline_time'));
		$db_data = array(
			'base_assignment_id' => 0,
			'teacher_id' => $this->user_id,
			'student_id' => 0,
			'class_id' => $class_id,
			'title' => $this->input->post('assignment_title'),
			'intro' => $this->input->post('assignment_intro'),
			'grade_type' => $this->input->post('grade_type'),
			'deadline_date' => date('Y-m-d H:i:s', $deadline_date),
			'active' => '1',
                        'publish' => $publish
		);

                
               
               
                
		$new_id = $this->assignment_model->save($db_data, $id);
                
                
                
                $this->assignment_model->update_assignment_categories($new_id, json_decode($this->input->post('categories')), $this->input->post('grade_type'));
                $this->assignment_model->update_assignment_attributes($new_id, json_decode($this->input->post('attributes')), $this->input->post('grade_type'));
               
                return $new_id;
        }
        
        public function getClasses($subject_id, $year)
        {
           $teacher_classes = $this->assignment_model->get_teacher_classes_assigment($this->user_id, $subject_id, $year);
           header('Content-Type: application/json');
           echo json_encode($teacher_classes);
           exit();
	}
        
        
	/* P2
	public function copy($id = '') {
		if ($id != '') {
			$assignment = $this->assignment_model->get_single_assignment($id);

			$data = array(
				'title' => $assignment->title,
				'intro' => $assignment->intro,
				'grade_type' => '',
				'deadline_date' => '',
				'assigned_to' => $assignment->assigned_to,
				'depending_classes' => '',
				'active' => '0',
			);
			$this->assignment_model->save($data);
			$last_inserted_id = $this->db->insert_id();
			$resources = $this->resources_model->get_assignment_resources($assignment->id);
			foreach ($resources as $resource) {
				$this->resources_model->add_resource('assignment', $last_inserted_id, $resource->resource_id);
			}
		}
		redirect('/f2b_teacher/index/' . $last_inserted_id . '/copy');
	}*/

}