<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class F2_student extends MY_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('assignment_model');
		$this->load->model('resources_model');
        $this->load->library('breadcrumbs');
	}
        
	function index($id, $mode=1) {
            
        $this->_data['flashmessage_pastmark'] = 0;
            
        $this->load->library( 'nativesession' );
        if( $this->nativesession->get('markmessage')==1 ) {
            $this->nativesession->set('markmessage', '');
            $this->_data['flashmessage_pastmark'] = 1;
        }

        if($this->_data['pastmark']!=1)

        $this->_data['selected_link_a']=$this->_data['selected_link_b']='';

        if($mode==1)$this->_data['selected_link_a']='sel';else $this->_data['selected_link_b']='sel';
                
		$assignment = $this->assignment_model->get_assignment($id);
		
		$this->_data['assignment_id'] = $id;
		$this->_data['title'] = html_entity_decode( $assignment->title );
		$this->_data['intro'] = html_entity_decode( $assignment->intro );
                
		$this->_data['grade_type'] = $this->assignment_model->labelsAssigmnetType($assignment->grade_type);
		
		$this->_data['grade_hidden'] = $assignment->grade ? '' : 'hidden';
		$this->_data['final_grade_hidden'] = $assignment->grade ? '' : 'hidden';
		//$this->_data['deadline'] = date('d.m.Y H:i', strtotime($assignment->deadline_date));
		$this->_data['deadline'] = date('l jS M Y, H:i', strtotime($assignment->deadline_date));
		
        $this->_data['deadline_date'] = date('D jS F Y', strtotime($assignment->deadline_date));
        $this->_data['deadline_time'] = date('H:i', strtotime($assignment->deadline_date));
                  
		$this->_data['resources'] = array();
		$resources = $this->resources_model->get_assignment_resources($assignment->base_assignment_id);
		if (!empty($resources)) {
			$this->_data['resources_hidden'] = '';
			foreach ($resources as $k => $v) {
				$this->_data['resources'][$k]['resource_name'] = $v->name;
				$this->_data['resources'][$k]['resource_id'] = $v->res_id;
                $this->_data['resources'][$k]['preview'] = $this->resoucePreview($v, '/f2_student/resource/');
                $this->_data['resources'][$k]['type'] = $v->type;
            }
		} else {
			$this->_data['resources_hidden'] = 'hidden';
		}

        if( !$this->checkValidDate($id) )$del_enabled = false; else $del_enabled = true;
        if( !$this->checkValidMarked($id) )$this->_data['marked'] = 1;else $this->_data['marked'] = 0;
                
        $this->_data['label_editors_save'] = 'SAVE АS A DRAFT';
        $this->_data['label_editors_publish'] = 'SUBMIT HOMEWORK';
                
        if( $assignment->publish==0 ) {
            $this->_data['hide_editors_publish'] = '';
            $this->_data['hide_editors_save'] = '';
        }elseif($this->_data['marked']==1) {
            $this->_data['hide_editors_publish'] = 'none';
            $this->_data['hide_editors_save'] = 'none';
            $this->_data['label_editors_publish'] = 'SAVE';
        }else {
            $this->_data['hide_editors_publish'] = '';
            $this->_data['hide_editors_save'] = 'none';
            $this->_data['label_editors_publish'] = 'SAVE';
        }
       
        $base_assignment = $this->assignment_model->get_assignment($assignment->base_assignment_id);
                
        $details = $this->assignment_model->get_assignment_details($id, 1);
        $this->_data['submission_info'] = $details[0]->assignment_detail_value;
        if($this->_data['submission_info']=="")$this->_data['submission_info_isempty'] = "<i>---Empty Notes---</i>";else $this->_data['submission_info_isempty'] = $this->_data['submission_info'];
        $this->_data['assignment_categories'] = array();
		$assignment_categories = $this->assignment_model->get_assignment_categories($assignment->base_assignment_id);
		
        $marks_avail = 0;
        $category_marks = array();
        foreach($assignment_categories as $ask=>$asv) {
            $marks_avail += (int) $asv->category_marks;
            $category_marks[$asv->id]=0;
        }
                
		$this->_data['student_resources'] = array();
		$student_resources = $this->resources_model->get_assignment_resources($id);
		if (!empty($student_resources)) {
			$this->_data['student_resources_hidden'] = '';

            foreach ($student_resources as $k => $v) {
                $mark_data = $this->assignment_model->get_resource_mark($v->res_id);
                if($mark_data[0]) {
                    $marks_total=$mark_data[0]->total_evaluation;
                    $marks_cat = json_decode($mark_data[0]->screens_data);
                    foreach($marks_cat as $pagek=>$pagev) {
                        foreach($pagev->items as $areak=>$areav) {
                            $category_marks[$areav->cat]+=$areav->evaluation;
                        }
                    }
                }else {
                    $marks_total=0;
                }
                                    
                $submission_mark += $marks_total;
                                    
                $this->_data['student_resources'][$k]['marks_total'] = $marks_total;
                $this->_data['student_resources'][$k]['marks_avail'] = $marks_avail;
		        $this->_data['student_resources'][$k]['resource_name'] = $v->name;
			    $this->_data['student_resources'][$k]['resource_id'] = $v->res_id;
                $this->_data['student_resources'][$k]['is_late'] = $v->is_late;
                $this->_data['student_resources'][$k]['assignment_id'] = $id;
                $this->_data['student_resources'][$k]['base_assignment_id'] = $base_assignment->id;
                $this->_data['student_resources'][$k]['preview'] = $this->resoucePreview($v, '/d5_student/resource/');
                                    
                if($v->is_late==1)$hider = '';else $hider = 'X';
                $this->_data['student_resources'][$k]['is_late_hide'] = $hider;
                                    
                if($del_enabled)$hider = '';else $hider = 'X';
                $this->_data['student_resources'][$k]['del_hide'] = $hider;
            }
//echo '<pre>'; var_dump( $this->_data['student_resources'] );die;

            $this->_data['avarage_mark'] = $submission_mark;
            $this->_data['marks_avail'] = $marks_avail*count($student_resources);
                            
            $this->_data['attainment'] = $this->assignment_model->calculateAttainment($this->_data['avarage_mark'], $this->_data['marks_avail'], $base_assignment);
        } else {
			$this->_data['student_resources_hidden'] = 'none';
		}		
		
        foreach($assignment_categories as $ask => $asv ) {
                    //$assignment_categories[$ask]->category_total=$category_marks[$asv->id]/count($student_resources);
            $assignment_categories[$ask]->category_total = $category_marks[$asv->id];
            $assignment_categories[$ask]->category_avail = $asv->category_marks * count($student_resources);
            $cat_mark[$asv->id] = $asv->category_name;
//echo '<pre>'; var_dump( $student_resources );die;
//echo '<pre>'; var_dump( $student_resources );die;
        }

        foreach( $student_resources as $k => $res ) {
//            $stud_res[$k]['res_id'] = $res->res_id;
            $stud_res = $this->assignment_model->get_resource_mark($res->res_id);
//echo '<pre>'; var_dump( $stud_res );die;
            $temp = json_decode($stud_res[0]->screens_data);
            foreach( $temp[0]->items as $k1 => $item ) {
                $student_resources_marks[]['cat'] = $cat_mark[$item->cat];
                $student_resources_marks[count( $student_resources_marks )-1]['comment'] = $item->comment;
                $student_resources_marks[count( $student_resources_marks )-1]['evaluation'] = $item->evaluation;
                $student_resources_marks[count( $student_resources_marks )-1]['unique_n'] = $item->unique_n;
            }
        }
        $this->_data['student_resources_marks'] = $student_resources_marks;
//echo '<pre>'; var_dump( $assignment_categories );die;
//echo '<pre>'; var_dump( $student_resources_marks );die;

        if(!empty($assignment_categories)) {
			$this->_data['assignment_categories'] = $assignment_categories;
			$this->_data['assignment_categories1'] = $assignment_categories;
		} else {
			if($mode==2)$this->_data['student_resources_hidden'] = 'none';
		}

//echo '<pre>'; var_dump( $temp );die;
		$this->_data['add_resources_hidden'] = $assignment->grade ? 'hidden' : '';
		$this->breadcrumbs->push('Home', base_url());	
        $this->breadcrumbs->push('My Homework', '/f1_student');
        $this->breadcrumbs->push($assignment->title, '/');
        $this->_data['breadcrumb'] = $this->breadcrumbs->show();
                    
		$this->_paste_public();
	}
	
    private function checkValidDate($id) {
        $assignment = $this->assignment_model->get_assignment($id);
        if($assignment) {
            if( time() > strtotime($assignment->deadline_date) )return false;
        }
                    
        return true;
    }
        
    private function checkValidPublish($id) {
        $assignment = $this->assignment_model->get_assignment($id);
        if($assignment) {
            if( $assignment->publish >= 2 )return false;
        }
                    
        return true;
    }
        
    private function checkValidMarked($id) {
        $assignment = $this->assignment_model->get_assignment($id);
                    
        if($assignment) {
            if($assignment->publish_marks==0)return true;
                        
            $submission_mark = 0;
            $student_resources = $this->resources_model->get_assignment_resources($assignment->id);
            foreach ($student_resources as $k => $v) {
                $mark_data = $this->assignment_model->get_resource_mark($v->res_id);
                if($mark_data[0]) {
                    $marks_total=$mark_data[0]->total_evaluation;
                }else {
                    $marks_total=0;
                }

                $submission_mark += $marks_total;
            } 
                        
            if( $submission_mark!=0 )return false;
        }
                    
        return true;
    }
        
	public function save() {
		$this->config->load('upload');
		$this->load->library('upload');

		$assignment_id = $this->input->post('assignment_id');		
		
        if( !$this->checkValidMarked($assignment_id) ) {
            $this->load->library( 'nativesession' );
            $this->nativesession->set('markmessage', 1);
            redirect('/f2_student/index/'.$assignment_id);
            die();
                   //die('It is already marked!'); 
        }

        $publish_status = $this->input->post('publish');
                
        $data = array( 'active' => 1 );
                
        if( $publish_status > 0 ) {
            $data['submitted_date'] = 'NOW()';
            $data['publish'] = $publish_status;
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

        $this->load->helper('my_helper', false);

        foreach( $upload_data as $key => $value) {
            $data = array(
                'teacher_id' => 0,
                'resource_name' => $value['file_name'],
                'name' => $value['orig_name'],
                'is_remote' => 0,
                'active' => 0 //hide from Resoruce Manager!
            );

            $resource_id = $this->resources_model->save($data);
                                
            $resid = $this->resources_model->add_resource('assignment', $new_id, $resource_id);
            if($is_late)$this->resources_model->assignment_resource_set_late($resid, 1);
            
            $params = array( $value['file_name'], $assignment_id, $resource_id, $_SERVER['HTTP_HOST'] );
            $resp = My_helpers::homeworkGenerate( $params );
        }
       	redirect('/f1_student');
	}

    public function delfile() {
        $assignment_id = $this->input->post('assignment_id');
        $resource_id = $this->input->post('resource_id');
            
        if(!empty($assignment_id) || !empty($resource_id)) {
            if( !$this->checkValidMarked($assignment_id) )die('It is already marked!'); 
            if( !$this->checkValidDate($assignment_id) )die('Out of date, delete is not allowed!'); 
                
            $this->config->load('upload');
            
            $resource = $this->resources_model->get_resource_by_id($resource_id);
            if($resource) {
                $dir = $this->config->item('upload_path');
              
                $file = $dir.$resource->resource_name;
                if(is_file($file))unlink($file);
                
                $this->resources_model->delete_resource($resource_id);
            }
        }
            
        redirect('/f2_student/index/'.$assignment_id);
    }
}
?>
