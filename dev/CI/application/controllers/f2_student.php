<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class F2_student extends MY_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('assignment_model');
		$this->load->model('resources_model');
	}

	function index($id) {
		$assignment = $this->assignment_model->get_assignment($id);
		
		$this->_data['assignment_id'] = $id;
		$this->_data['title'] = $assignment->title;
		$this->_data['intro'] = $assignment->intro;
		$this->_data['grade_type'] = $assignment->grade_type;
		if ($assignment->grade) {
			switch ($assignment->grade_type) {
				case 'percentage':
					$assignment->grade .= '%';
					break;
				case 'mark_out_of_10':
					$assignment->grade .= '/10';
					break;
			}
		}			
		$this->_data['grade'] = $assignment->grade;
		$this->_data['grade_hidden'] = $assignment->grade ? '' : 'hidden';
		$this->_data['final_grade_hidden'] = $assignment->grade ? '' : 'hidden';
		//$this->_data['deadline'] = date('d.m.Y H:i', strtotime($assignment->deadline_date));
		$this->_data['deadline'] = date('l jS F Y, H:i', strtotime($assignment->deadline_date));
		
		$this->_data['resources'] = array();
		$resources = $this->resources_model->get_assignment_resources($assignment->base_assignment_id);
		if (!empty($resources)) {
			$this->_data['resources_hidden'] = '';
			foreach ($resources as $k => $v) {
				$this->_data['resources'][$k]['resource_name'] = $v->name;
				$this->_data['resources'][$k]['resource_id'] = $v->res_id;
                                $this->_data['resources'][$k]['preview'] = $this->resoucePreview($v, '/f2_student/');
			
			}
		} else {
			$this->_data['resources_hidden'] = 'hidden';
		}		
		
                
                    $this->_data['label_editors_save'] = 'SAVE АS A DRAFT';
                
                    if( $assignment->publish==0 )
                    {
                        $this->_data['hide_editors_publish'] = 'block';
                        $this->_data['hide_editors_save'] = 'block';
                         
                    } else
                    {
                        $this->_data['hide_editors_publish'] = 'block';
                        $this->_data['hide_editors_save'] = 'none';
                        
                    }
                   //elseif( $assignment->publish==2 )
                    //{
                        //$this->_data['hide_editors_publish'] = 'none';
                       // $this->_data['hide_editors_save'] = 'none';
                    //}
                
                if( !$this->checkValidDate($id) )$del_enabled = false; else $del_enabled = true;
                    
                
                $details = $this->assignment_model->get_assignment_details($id, 1);
                $this->_data['submission_info'] = $details[0]->assignment_detail_value;
                
		$this->_data['student_resources'] = array();
		$student_resources = $this->resources_model->get_assignment_resources($id);
		if (!empty($student_resources)) {
			$this->_data['student_resources_hidden'] = '';
                        
			 foreach ($student_resources as $k => $v)
                         {
				$this->_data['student_resources'][$k]['resource_name'] = $v->name;
				$this->_data['student_resources'][$k]['resource_id'] = $v->res_id;
                                $this->_data['student_resources'][$k]['is_late'] = $v->is_late;
                                $this->_data['student_resources'][$k]['assignment_id'] = $id;
                                
                                if($v->is_late==1)$hider = '';else $hider = 'X';
                                $this->_data['student_resources'][$k]['is_late_hide'] = $hider;
                                
                                if($del_enabled)$hider = '';else $hider = 'X';
                                $this->_data['student_resources'][$k]['del_hide'] = $hider;
                         }
                          
		} else {
			$this->_data['student_resources_hidden'] = 'hidden';
		}		
		
                
		$this->_data['add_resources_hidden'] = $assignment->grade ? 'hidden' : '';
			
		$this->_paste_public();
	}
	
        private function checkValidDate($id)
        {
                    $assignment = $this->assignment_model->get_assignment($id);
                    if($assignment)
                    {
                         if( time() > strtotime($assignment->deadline_date) )return false;
                    }
                    
                    return true;
        }
        
        private function checkValidPublish($id)
        {
                    $assignment = $this->assignment_model->get_assignment($id);
                    if($assignment)
                    {
                         if( $assignment->publish>=2 )return false;
                    }
                    
                    return true;
        }
        
	public function save() {
		$this->config->load('upload');
		$this->load->library('upload');
		
		$assignment_id = $this->input->post('assignment_id');		
		
                //if( !$this->checkValidPublish($assignment_id) )die('Out of date, saving is not allowed!'); 
                
                $publish_status = $this->input->post('publish');
                
                $data = array('active'=>1);
                
                 if($publish_status>0)
                 {
                    $data['submitted_date'] = 'NOW()';
                    $data['publish']=$publish_status;
                 }
                
                if( !$this->checkValidDate($assignment_id) )$is_late = true; else $is_late = false;
                
                $new_id = $this->assignment_model->save($data, $assignment_id, FALSE);
                
                $this->assignment_model->save_assignment_details($new_id, 1, $this->input->post('submission_info'));

             
                        if (!$this->upload->do_multi_upload('userfile')) {
                                //echo 'error uploading files';
                                  //  exit();
                        } else {
                                
                        }
		
                        $upload_data = $this->upload->get_multi_upload_data();
                       
                         
                        foreach ($upload_data as $key => $value) {
                                $data = array(
                                        'teacher_id' => 0,
                                        'resource_name' => $value['file_name'],
                                        'name' => $value['orig_name'],
                                        'active' => 0 //hide from Resoruce Manager!
                                );

                                $resource_id = $this->resources_model->save($data);
                                
                                $resid = $this->resources_model->add_resource('assignment', $new_id, $resource_id);
                                if($is_late)$this->resources_model->assignment_resource_set_late($resid, 1);
                        }	
                
              
                
		redirect('/f1_student');
	}
        
        public function delfile()
        {
            $assignment_id = $this->input->post('assignment_id');
            $resource_id = $this->input->post('resource_id');
            
            if(!empty($assignment_id) || !empty($resource_id))
            {
                
                if( !$this->checkValidDate($assignment_id) )die('Out of date, delete is not allowed!'); 
                
                $this->config->load('upload');
            
                $resource = $this->resources_model->get_resource_by_id($resource_id);
                if($resource)
                {
                    $dir = $this->config->item('upload_path');
              
                    $file = $dir.$resource->resource_name;
                    if(is_file($file))unlink($file);
                
                    $this->resources_model->delete_resource($resource_id);
                }
                
            }
            
            redirect('/f2_student/index/'.$assignment_id);
        }
}