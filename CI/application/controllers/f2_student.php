<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once APPPATH . 'libraries/AES/aes.class.php';
require_once APPPATH . 'libraries/AES/aesctr.class.php';

class F2_student extends MY_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('assignment_model');
        $this->load->model('user_model');
		$this->load->model('resources_model');
        $this->load->model('student_answers_model');
        $this->load->library('breadcrumbs');
	}
        
	function index($id, $mode=1) {
            
        $this->_data['flashmessage_pastmark'] = 0;
        $this->load->library( 'nativesession' );
        if( $this->nativesession->get('markmessage')==1 ) {
            $this->nativesession->set('markmessage', '');
            $this->_data['flashmessage_pastmark'] = 1;
        }

        if( isset( $this->_data['pastmark'] ) && $this->_data['pastmark'] != 1 ) {
            $this->_data['selected_link_a'] = $this->_data['selected_link_b']='';
        }
        if( $mode == 1 ) { $this->_data['selected_link_a'] = 'sel'; } else { $this->_data['selected_link_b'] = 'sel'; }

		$assignment = $this->assignment_model->get_assignment($id);
        $this->_data['set_by'] = $this->user_model->getUserName( $assignment->teacher_id );
        $this->_data['base_assignment_id'] = $assignment->base_assignment_id;
		$this->_data['assignment_id'] = $id;
		$this->_data['title'] = html_entity_decode( $assignment->title );
		$this->_data['intro'] = html_entity_decode( $assignment->intro );
                
        $this->_data['grade_type_label'] = $this->assignment_model->labelsAssigmnetType($assignment->grade_type);
		$this->_data['grade_type'] = $assignment->grade_type;
//echo '<pre>'; var_dump( $this->_data['grade_type'] );die;
		$this->_data['grade_hidden'] = $assignment->grade ? '' : 'hidden';
		$this->_data['final_grade_hidden'] = $assignment->grade ? '' : 'hidden';
		//$this->_data['deadline'] = date('d.m.Y H:i', strtotime($assignment->deadline_date));
		$this->_data['deadline'] = date('l jS M Y, H:i', strtotime($assignment->deadline_date));
		
        $this->_data['deadline_date'] = date('D jS F Y', strtotime($assignment->deadline_date));
        $this->_data['deadline_time'] = date('H:i', strtotime($assignment->deadline_date));
                  
		$this->_data['resources'] = array();
		$resources = $this->resources_model->get_assignment_resources($assignment->base_assignment_id);
		if( !empty($resources) ) {
			$this->_data['resources_hidden'] = '';
			foreach ($resources as $k => $v) {
				$this->_data['resources'][$k]['resource_name'] = $v->name;
				$this->_data['resources'][$k]['resource_id'] = $v->res_id;
                $this->_data['resources'][$k]['type'] = $v->type;
                $this->_data['resources'][$k]['content'] = $v->content;
                $this->_data['resources'][$k]['behavior'] = $v->behavior;
                $this->_data['resources'][$k]['marks_available'] = $this->getAvailableMarks($v->content);
                $this->_data['resources'][$k]['attained'] = $this->student_answers_model->getAttained( array( 'student_id' => $student->id, 'resource_id' => $v->res_id, 'slide_id' => $assignment_id ) );

                $action_required = '';
                $this->_data['resources'][$k]['li_style'] = '';
                if( in_array($v->type, $this->_test_resources ) ) {
                    if( !$this->student_answers_model->isExist( $this->session->userdata('id'), $v->res_id, false, $assignment->id, 'homework' ) ) {
                        $this->_data['resources'][$k]['preview'] = $this->resoucePreview($v, '/f2_student/resource/');
                        $action_required = 'Action Required';
                        $this->_data['resources'][$k]['li_style'] = 'style="background: #ffe6e6;"'; 
                    } else {
                        $this->_data['resources'][$k]['preview'] = $this->resoucePreview($v, '/f2a_student/resource/');
                        $action_required = 'Question Answered';
                        $this->_data['resources'][$k]['li_style'] = 'style="background: #e6ffe6;"'; 
                    }
                }
                $this->_data['resources'][$k]['required'] = $action_required;
            }
		} else {
			$this->_data['resources_hidden'] = 'hidden';
		}

        if( !$this->checkValidDate($id) ) { $del_enabled = false; } else { $del_enabled = true; }
        if( !$this->checkValidMarked($id) ) { $this->_data['marked'] = 1; } else { $this->_data['marked'] = 0; }
                
        $this->_data['label_editors_save'] = 'SAVE АS A DRAFT';
        $this->_data['label_editors_publish'] = 'SUBMIT HOMEWORK';
        $this->_data['publish_marks'] = 0;

        if( $assignment->publish_marks == 1 ) {
//        } elseif( $this->_data['marked'] == 1 ) {
            $this->_data['hide_editors_publish'] = 'none';
            $this->_data['hide_editors_save'] = 'none';
            $this->_data['label_editors_publish'] = 'SAVE';
            $this->_data['publish_marks'] = 1;
        } elseif( $assignment->publish == 0 ) {
            $this->_data['hide_editors_publish'] = '';
            $this->_data['hide_editors_save'] = '';
        } else {
            $this->_data['hide_editors_publish'] = '';
            $this->_data['hide_editors_save'] = 'none';
            $this->_data['label_editors_publish'] = 'SAVE';
        }
       
        $base_assignment = $this->assignment_model->get_assignment($assignment->base_assignment_id);

        $this->_data['submission_info'] = "";
        $details = $this->assignment_model->get_assignment_details($id, 1);
        if( $details ) {
            $this->_data['submission_info'] = $details[0]->assignment_detail_value;
        }
        if( $this->_data['submission_info'] == "" ) {
            $this->_data['submission_info_isempty'] = "<i>---Empty Notes---</i>";
        } else {
            $this->_data['submission_info_isempty'] = $this->_data['submission_info'];
        }
        $this->_data['assignment_categories'] = array();
		$assignment_categories = $this->assignment_model->get_assignment_categories($assignment->base_assignment_id);
		
        $marks_avail = 0;
        $category_marks = array();
        foreach($assignment_categories as $ask=>$asv) {
            $marks_avail += (int) $asv->category_marks;
            $category_marks[$asv->id] = 0;
        }
        $this->_data['marks_avail'] = $marks_avail;

//        $assignmet_mark = $this->assignment_model->get_mark_submission($id);
//        $submission_mark = $assignmet_mark[0]->total_evaluation;
		$this->_data['student_resources'] = array();
		$student_resources = $this->resources_model->get_assignment_resources($id);
		if (!empty($student_resources)) {
			$this->_data['student_resources_hidden'] = '';

            foreach ($student_resources as $k => $v) {
                $mark_data = $this->assignment_model->get_resource_mark($v->res_id);
                if($mark_data[0]) {
                    $marks_total = $mark_data[0]->total_evaluation;
                    $marks_cat = json_decode($mark_data[0]->screens_data);
                    foreach( $marks_cat as $pagek => $pagev ) {
                        foreach( $pagev->items as $areak => $areav ) {
                            $category_marks[$areav->cat] += $areav->evaluation;
                        }
                    }
                } else {
                    $marks_total = 0;
                }
                                    
                $submission_mark += $marks_total;
                                    
                $this->_data['student_resources'][$k]['marks_total'] = $marks_total;
                $this->_data['student_resources'][$k]['marks_avail'] = $marks_avail;
                if( strlen( $v->name ) > 20 ) {
                    if( $v->is_late == 1 ) {
                        $v->name = substr( $v->name,0,14 ).'...';
                    } else {
                        $v->name = substr( $v->name,0,19 ).'...';
                    }
                }
		        $this->_data['student_resources'][$k]['resource_name'] = $v->name;
			    $this->_data['student_resources'][$k]['resource_id'] = $v->res_id;
                $this->_data['student_resources'][$k]['is_late'] = $v->is_late ? 'inline-block' : 'none';
                $this->_data['student_resources'][$k]['assignment_id'] = $id;
                $this->_data['student_resources'][$k]['base_assignment_id'] = $base_assignment->id;
                $this->_data['student_resources'][$k]['preview'] = $this->resoucePreview($v, '/f2_student/resource/');
//                $this->_data['student_resources'][$k]['preview'] = $this->resoucePreview($v, '/d5_student/resource/');
                                    
                if($v->is_late==1)$hider = '';else $hider = 'X';
                $this->_data['student_resources'][$k]['is_late_hide'] = $hider;
                                    
                if($del_enabled)$hider = '';else $hider = 'X';
                $this->_data['student_resources'][$k]['del_hide'] = $hider;
            }
//echo '<pre>'; var_dump( $this->_data['student_resources'] );die;

            $this->_data['avarage_mark'] = $submission_mark;
            $this->_data['marks_avail'] = $marks_avail;
//            $this->_data['marks_avail'] = $marks_avail*count($student_resources);

            $this->_data['attainment'] = $this->assignment_model->calculateAttainment($this->_data['avarage_mark'], $this->_data['marks_avail'], $base_assignment);
        } else {
			$this->_data['student_resources_hidden'] = 'none';
		}		

        foreach($assignment_categories as $ask => $asv ) {
            $assignment_categories[$ask]->category_total = $category_marks[$asv->id];
            $assignment_categories[$ask]->category_avail = $asv->category_marks;
//            $assignment_categories[$ask]->category_avail = $asv->category_marks * count($student_resources);
            $cat_mark[$asv->id] = $asv->category_name;
        }

        $overall_marks = $this->assignment_model->get_overall_marks( $id );
        $student_overall_marks = '';
        if( $overall_marks ) {
            $temp = json_decode($overall_marks[0]->screens_data);
            foreach( $temp[0]->items as $k1 => $item ) {
                $student_overall_marks[]['cat'] = $cat_mark[$item->cat];
                $student_overall_marks[count( $student_overall_marks )-1]['comment'] = $item->comment;
                $student_overall_marks[count( $student_overall_marks )-1]['evaluation'] = $item->evaluation;
                $student_overall_marks[count( $student_overall_marks )-1]['unique_n'] = $item->unique_n;

                $this->_data['avarage_mark'] += $item->evaluation;
                $this->_data['attainment'] = $this->assignment_model->calculateAttainment($this->_data['avarage_mark'], $this->_data['marks_avail'], $base_assignment);
                foreach( $assignment_categories as $ask => $asv ) {
                    if( $asv->id == $item->cat ) {
                        $assignment_categories[$ask]->category_total += $item->evaluation;
                    }
                }
            }
        } else {
            $this->_data['avarage_mark'] = 0;
            $this->_data['attainment'] = '-';
            $student_overall_marks = null;
        }

/*
        foreach( $student_resources as $k => $res ) {
            $stud_res = $this->assignment_model->get_resource_mark($res->res_id);
            $temp = json_decode($stud_res[0]->screens_data);
            foreach( $temp[0]->items as $k1 => $item ) {
                $student_resources_marks[]['cat'] = $cat_mark[$item->cat];
                $student_resources_marks[count( $student_resources_marks )-1]['comment'] = $item->comment;
                $student_resources_marks[count( $student_resources_marks )-1]['evaluation'] = $item->evaluation;
                $student_resources_marks[count( $student_resources_marks )-1]['unique_n'] = $item->unique_n;
            }
        }
//*/
        $this->_data['student_overall_marks'] = $student_overall_marks;

        if(!empty($assignment_categories)) {
			$this->_data['assignment_categories'] = $assignment_categories;
			$this->_data['assignment_categories1'] = $assignment_categories;
			$this->_data['assignment_categories2'] = $assignment_categories;
			$this->_data['assignment_categories3'] = $assignment_categories;
			$this->_data['assignment_categories4'] = $assignment_categories;
		} else {
			if($mode==2)$this->_data['student_resources_hidden'] = 'none';
		}
//echo '<pre>'; var_dump( $assignment_categories );die;

//echo '<pre>'; var_dump( $temp );die;
        $this->_data['identity'] = time();

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
            if( $assignment->publish_marks == 0 ) return true;

            $assignmet_mark = $this->assignment_model->get_mark_submission($assignment->id);
            $submission_mark = $assignmet_mark[0]->total_evaluation;
//            $submission_mark = 0;
            $student_resources = $this->resources_model->get_assignment_resources($assignment->id);
            foreach( $student_resources as $k => $v ) {
                $mark_data = $this->assignment_model->get_resource_mark($v->res_id);
                if($mark_data[0]) {
                    $marks_total=$mark_data[0]->total_evaluation;
                } else {
                    $marks_total=0;
                }

                $submission_mark += $marks_total;
            } 
                        
            if( $submission_mark != 0 ) return false;
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

    public function submissionUpload() {
        $key = 'dcrptky@)!$2014dcrpt';
        $FILE = $_FILES['qqfile'];
        $assignment_id = $this->input->post('assignment_id');
        $this->config->load('upload');
        $this->load->library('upload');
        $this->load->helper('my_helper', false);

        $CPT_POST = AesCtr::decrypt($this->input->post('qqfile'), $key, 256);
        $CPT_DATA = explode("::", $CPT_POST);
        $dir = $this->config->item('upload_path');
        $funm = explode('.', $FILE['name']);
        $ext = $funm[count($funm) - 1];
        array_pop($funm);
        $NAME = md5(implode('.', $funm)) . time() . '.' . $ext;
        $uploadfile = $dir . $NAME;

        if( move_uploaded_file($FILE['tmp_name'], $uploadfile) ) {
            $NF_NAME = $dir . $NAME . '_tmp';
            rename($uploadfile, $NF_NAME);
            $img_dataurl = base64_encode(file_get_contents($NF_NAME));

            if ($CPT_DATA[0] == 1) {
                $decrypt = AesCtr::decrypt($img_dataurl, $key, 256);
            } else {
                $half = $CPT_DATA[1];
                $SZ = $CPT_DATA[2];
                $CPT_l = $CPT_DATA[3];
                $crypter_middle = substr($img_dataurl, $half - $SZ, $CPT_l);
                $crypter_middle_decr = AesCtr::decrypt($crypter_middle, $key, 256);
                $decrypt = str_replace($crypter_middle, $crypter_middle_decr, $img_dataurl);
            }

            file_put_contents($uploadfile, base64_decode($decrypt));
            if( is_file($uploadfile) ) { unlink($NF_NAME); }

            $data = array(
                'teacher_id' => 0,
                'resource_name' => $NAME,
                'name' => $FILE['name'],
                'is_remote' => 0,
                'active' => 0 //hide from Resoruce Manager!
            );

            $resource_id = $this->resources_model->save($data);
                                
            $resid = $this->resources_model->add_resource('assignment', $assignment_id, $resource_id);
            if( !$this->checkValidDate($assignment_id) ) { 
                $is_late = true;
            } else {
                $is_late = false;
            }
            if( $is_late ) { $this->resources_model->assignment_resource_set_late($resid, 1); }
            
            $params = array( $NAME, $assignment_id, $resource_id, $_SERVER['HTTP_HOST'] );
            $resp = My_helpers::homeworkGenerate( $params );

            $resource = $this->resources_model->get_resource_by_id( $resource_id );

            $json['status'] = 'success';
            $json['success'] = 'true';
            $json['preview'] = $this->resoucePreview($resource, '/f2_student/resource/');
            $json['resource_id'] = $resource_id;
            if( strlen( $FILE['name'] ) < 20 ) {
                $json['name'] = $FILE['name'];
            } else {
                $json['name'] = substr( $FILE['name'],0,19 ).'...';
            }
            if( $is_late ) {
                $json['is_late'] = 'inline-block';
            } else {
                $json['is_late'] = 'none';
            }
            echo json_encode($json);
        } else {
            return false;
        }
    }

    public function delete_file() {
        $file = $this->input->post('filename');
        $path = realpath('uploads/resources/temp/');
        if (is_file($path . '/' . $file)) {
            unlink($path . '/' . $file);
        }
        echo json_encode('true');
    }

    function saveAnswer() {
        $data = $this->input->post();
        parse_str($data['post_data'], $post_data);
        $this->load->model('filter_assignment_model');
        $this->load->model('student_answers_model');
        $this->load->model('classes_model');
        $this->load->model('resources_model');
        $this->load->library('resource');

        $assignment = $this->assignment_model->get_assignment($post_data['slide_id']);
        $base_assignment = $this->filter_assignment_model->get_assignment($assignment->base_assignment_id);
        $resource = $this->resources_model->get_resource_by_id( $post_data['resource_id'] );
        $content = json_decode( $resource->content, true );
//echo '<pre>';var_dump( $content['content']['answer'] );die;

        $post_data['teacher_id'] = $base_assignment['teacher_id'];
        $post_data['teacher_name'] = $base_assignment['teacher_name'];
        $post_data['student_name'] = $this->session->userdata('first_name') . ' ' . $this->session->userdata('last_name');
        $post_data['subject_id'] = $base_assignment['subject_id'];
        $post_data['subject_name'] = $base_assignment['subject_name'];
        $post_data['year_id'] = $base_assignment['year_id'];
        $post_data['year'] = $base_assignment['year'];
        $post_data['class_id'] = $assignment->class_id;
        $post_data['class_name'] = $this->classes_model->get_class_name( $assignment->class_id );
        $post_data['lesson_title'] = $base_assignment['title'];
        $post_data['lesson_id'] = $assignment->base_assignment_id;
        $new_resource = new Resource();
        $post_data['marks_available'] = $new_resource->getAvailableMarks($content);
        $post_data['attained'] = $new_resource->setAttained( $post_data['resource_id'], $content, $post_data['answer'] );

        $save_data = $new_resource->saveAnswer($post_data);
//        $html = $new_resource->renderCheckAnswer( $post_data['resource_id'], $content, $post_data['answer'] );
        $html = '';
//echo '<pre>';var_dump( $html );die;

        echo $html;
    }

    public function getAvailableMarks( $resource_content ) {
        $content = json_decode( $resource_content, true );
        $this->load->library('resource');
        $new_resource = new Resource();
        $available_marks = $new_resource->getAvailableMarks($content);
        return $available_marks;
    }

    public function getStudentAnswers(){
        $data = $this->input->get();
        $answers = $this->student_answers_model->getStudentAnswer($data);
        $answer = $answers[0];
        $output = array();
        switch( $answer['type'] ) {
            case 'single_choice' : 
                $output['type'] = $answer['type'];
                $output['answers'][0] = $answer['answers'];
                break;
            case 'multiple_choice' : 
                $output['type'] = $answer['type'];
                $output['answers'][] = $answer['answers'];
                break;
            case 'fill_in_the_blank' : 
                $output['type'] = $answer['type'];
                $ans = explode(',',$answer['answers']);
                $i = 0;
                foreach($ans as $v) {
                    $an = explode('=:',$v);
                    $output['answers'][$i]['key'] = $an[0];
                    $output['answers'][$i]['val'] = $an[1];
                    $i++;
                }
//                $output['answers'] = $ans;
                break;
            case 'mark_the_words' : 
                $output['type'] = $answer['type'];
                $output['answers'] = explode(',',$answer['answers']);
                break;
        }
        echo json_encode( $output );
//echo '<pre>';var_dump( $answers );die;
    }
}
?>
