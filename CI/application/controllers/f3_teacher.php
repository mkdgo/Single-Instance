<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class F3_teacher extends MY_Controller {

  function __construct() {
    parent::__construct();
		$this->load->model('assignment_model');
		$this->load->model('user_model');
		$this->load->model('resources_model');
                $this->load->library('breadcrumbs');
  }

  function index($base_assignment_id, $assignment_id, $mode=1) {
      
                $all_assignments= $this->assignment_model->get_student_assignments($base_assignment_id);
                $prev = array(); $next = array();
                foreach($all_assignments as $k=>$v)
                {
                    if($v->id == $assignment_id)
                    {
                        if(!empty($all_assignments[$k-1]))$prev = $all_assignments[$k-1]; 
                        if(!empty($all_assignments[$k+1]))$next = $all_assignments[$k+1]; 
                    }
                }
                
                
                $this->_data['prev_assignment'] = '';
                $this->_data['prev_assignment_visible'] = 'none';
                if(!empty($prev))
                {
                    $this->_data['prev_assignment'] = '/f3_teacher/index/'.$base_assignment_id.'/'.$prev->id;
                    $this->_data['prev_assignment_visible'] = 'block';
                }
                
                $this->_data['next_assignment'] = '';
                $this->_data['next_assignment_visible'] = 'none';
                if(!empty($next))
                {
                    $this->_data['next_assignment'] = '/f3_teacher/index/'.$base_assignment_id.'/'.$next->id;
                    $this->_data['next_assignment_visible'] = 'block';
                }
                
                $base_assignment = $this->assignment_model->get_assignment($base_assignment_id);
		$assignment = $this->assignment_model->get_assignment($assignment_id);
		$student = $this->user_model->get_user($assignment->student_id);
                
                $this->_data['base_assignment_name'] = $base_assignment->title;
		$this->_data['base_assignment_id'] = $base_assignment_id;
		$this->_data['assignment_id'] = $assignment_id;
		
		$this->_data['title'] = $assignment->title;
		//$this->_data['submitted_date'] = $assignment->submitted_date ? date('d.m.Y H:i', strtotime($assignment->submitted_date)) : '-';
		
                $this->_data['submitted_date'] = date('d.m.Y', strtotime($assignment->submitted_date));
                $this->_data['submitted_time'] = date('H:i', strtotime($assignment->submitted_date));
                        
                $this->_data['student_first_name'] = $student->first_name;
		$this->_data['student_last_name'] = $student->last_name;
                
                $details = $this->assignment_model->get_assignment_details($assignment_id, 1);
                $this->_data['submission_info'] = $details[0]->assignment_detail_value;
                
                $this->_data['list_hidden'] = 'block';
		
                $this->_data['assignment_categories'] = array();
		$assignment_categories = $this->assignment_model->get_assignment_categories($base_assignment_id);
		
                $marks_avail = 0;
                $category_marks = array();
                foreach($assignment_categories as $ask=>$asv)
                {
                    $marks_avail += (int) $asv->category_marks;
                    $category_marks[$asv->id]=0;
                }
                
                         
                $this->_data['student_resources'] = array();
		$student_resources = $this->resources_model->get_assignment_resources($assignment_id);
		if(!empty($student_resources)) {
                    $submission_mark = 0;
                    
			foreach ($student_resources as $k => $v)
                        {
                                $mark_data = $this->assignment_model->get_resource_mark($v->res_id);
                                if($mark_data[0])
                                {
                                    $marks_total=$mark_data[0]->total_evaluation;
                                    $marks_cat = json_decode($mark_data[0]->screens_data);
                                    foreach($marks_cat as $pagek=>$pagev)
                                    {
                                        foreach($pagev->items as $areak=>$areav)
                                        {
                                            $category_marks[$areav->cat]+=$areav->evaluation;
                                        }
                                    }
                                    
                                }else
                                {
                                    $marks_total=0;
                                }
                                
                                $submission_mark += $marks_total;
                                
                                $this->_data['student_resources'][$k]['marks_total'] = $marks_total;
                                $this->_data['student_resources'][$k]['marks_avail'] = $marks_avail;
				$this->_data['student_resources'][$k]['resource_name'] = $v->name;
				$this->_data['student_resources'][$k]['resource_id'] = $v->res_id;
                                $this->_data['student_resources'][$k]['is_late'] = $v->is_late;
                                if($v->is_late==1)$hider = '';else $hider = 'x';
                                $this->_data['student_resources'][$k]['is_late_hide'] = $hider;
			}
                        
                        $this->_data['avarage_mark'] = $submission_mark;
                        $this->_data['marks_avail'] = $marks_avail*count($student_resources);
                        
                        $this->_data['attainment'] = $this->assignment_model->calculateAttainment($this->_data['avarage_mark'], $this->_data['marks_avail'], $base_assignment);
                        
                        
		} else {
			if($mode==1)$this->_data['list_hidden'] = 'none';
		}
                
                
                foreach($assignment_categories as $ask=>$asv)
                {
                    //$assignment_categories[$ask]->category_total=$category_marks[$asv->id]/count($student_resources);
                    $assignment_categories[$ask]->category_total=$category_marks[$asv->id];
                    $assignment_categories[$ask]->category_avail=$asv->category_marks*count($student_resources);
                }
                
                if(!empty($assignment_categories)) {
			$this->_data['assignment_categories'] = $assignment_categories;
		} else {
			if($mode==2)$this->_data['list_hidden'] = 'none';
		}
                
              
		
		
                //prev_assignment_visible
                
		$this->_data['feedback'] = $assignment->feedback;
		
		$this->_data['grade_type'] = $assignment->grade_type;
		$this->_data['grade'] = $assignment->grade;
                
                $this->_data['selected_link_a']=$this->_data['selected_link_b']='';
                
                if($mode==1)$this->_data['selected_link_a']='sel';else $this->_data['selected_link_b']='sel';
		
                if($assignment->publish==0)
                {
                    $this->_data['submitted_date'] = 'not submited';
                    $this->_data['list_hidden'] = 'none';
                }
                $this->breadcrumbs->push('Home', base_url());
                $this->breadcrumbs->push('Homework Centre', '/f1_teacher');
                //$this->breadcrumbs->push('Assesment Centre', '/f1_teacher');
                $this->breadcrumbs->push($base_assignment->title, '/f2b_teacher/index/'.$base_assignment_id);
		$this->breadcrumbs->push($student->first_name.' '.$student->last_name, "/");
		$this->_data['breadcrumb'] = $this->breadcrumbs->show();
                
                // 
    $this->_paste_public();
  }
	
	public function save() {		
		$base_assignment_id = $this->input->post('base_assignment_id');		
		$assignment_id = $this->input->post('assignment_id');		
		
		$this->assignment_model->save(array('grade' => $this->input->post('grade'), 'feedback' => $this->input->post('feedback')), $assignment_id);		
		
		redirect('/f2b_teacher/index/' . $base_assignment_id);
	}
}