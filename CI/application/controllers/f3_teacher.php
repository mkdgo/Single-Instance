<?php
    if (!defined('BASEPATH'))
        exit('No direct script access allowed');

    class F3_teacher extends MY_Controller {

        function __construct() {
            parent::__construct();
            $this->load->model('assignment_model');
            $this->load->model('user_model');
            $this->load->model('resources_model');
            $this->load->model('student_answers_model');
            $this->load->library('breadcrumbs');
        }

        function index($base_assignment_id, $assignment_id, $mode=1) {

            $all_assignments= $this->assignment_model->get_student_assignments($base_assignment_id);
            $prev = array(); $next = array();
            foreach($all_assignments as $k=>$v) {
                if($v->id == $assignment_id) {
                    if(!empty($all_assignments[$k-1]))$prev = $all_assignments[$k-1]; 
                    if(!empty($all_assignments[$k+1]))$next = $all_assignments[$k+1]; 
                }
            }

            $this->_data['prev_assignment'] = '';
            $this->_data['prev_assignment_visible'] = 'none';
            if( !empty($prev) ) {
                $this->_data['prev_assignment'] = '/f3_teacher/index/'.$base_assignment_id.'/'.$prev->id;
                $this->_data['prev_assignment_visible'] = 'block';
            }

            $this->_data['next_assignment'] = '';
            $this->_data['next_assignment_visible'] = 'none';
            if( !empty($next) ) {
                $this->_data['next_assignment'] = '/f3_teacher/index/'.$base_assignment_id.'/'.$next->id;
                $this->_data['next_assignment_visible'] = 'block';
            }

            $base_assignment = $this->assignment_model->get_assignment($base_assignment_id);
            $assignment = $this->assignment_model->get_assignment($assignment_id);
            $student = $this->user_model->get_user($assignment->student_id);

            $this->_data['student_first_name'] = $student->first_name;
            $this->_data['student_last_name'] = $student->last_name;

            $this->_data['base_assignment_name'] = $base_assignment->title;
            $this->_data['base_assignment_id'] = $base_assignment_id;
            $this->_data['assignment_id'] = $assignment_id;

            $this->_data['title'] = $assignment->title;

            $this->_data['submitted_date'] = date('d.m.Y', strtotime($assignment->submitted_date));
            $this->_data['submitted_time'] = date('H:i', strtotime($assignment->submitted_date));

            $details = $this->assignment_model->get_assignment_details($assignment_id, 1);
            $submission_info = '';
            if( $details[0]->assignment_detail_value ) {
                $submission_info = $details[0]->assignment_detail_value;
            }
            $this->_data['submission_info'] = $submission_info;

            $this->_data['list_hidden'] = 'block';

            $this->_data['assignment_categories'] = array();
            $assignment_categories = $this->assignment_model->get_assignment_categories($base_assignment_id);

            $marks_avail = 0;
            $category_marks = array();
            foreach( $assignment_categories as $ask => $asv ) {
                $marks_avail += (int) $asv->category_marks;
            $category_marks[$asv->id]=0;
        }

        if( $assignment->grade_type == 'test' ) {
            $assignmet_mark = $this->assignment_model->get_mark_submission($assignment_id);
            if( empty( $assignmet_mark ) ) {
                $json_visual_data = array();
                    $json_visual_data[] = array(
                    "items" => array(),
                    "picture" => $this->config->item('red_pen_download_image')
                );

                $data = array(
                    'screens_data'=>json_encode($json_visual_data),
                    'resource_id'=>0,
                    'assignment_id'=>$assignment_id,
                    'pagesnum'=>0,
                    'total_evaluation'=>0
                );
                $mark_id = $this->assignment_model->update_assignment_mark(-1, $data);
            } else {
                $mark_id = $assignmet_mark[0]->id;
                $marks_sub_cat = json_decode($assignmet_mark[0]->screens_data);
                foreach( $marks_sub_cat as $pagek => $pagev ) {
                    foreach( $pagev->items as $areak => $areav ) {
                        $category_marks[$areav->cat] += $areav->evaluation;
                    }
                }
            }
            $submission_mark = $assignmet_mark[0]->total_evaluation;

            $this->_data['resources'] = array();
            $resources = $this->resources_model->get_assignment_resources($base_assignment_id);
            $ma = 0;
            $sm = 0;
            if (!empty($resources)) {
                $this->_data['resource_hidden'] = '';
                $score = '';
                foreach ($resources as $k => $v) {
                    $this->_data['resources'][$k]['id'] = $v->res_id;
                    $this->_data['resources'][$k]['resource_name'] = $v->name;
                    $name = ( strlen( $v->name ) > 50 ) ? substr( $v->name,0,50 ).'...' : $v->name ;
                    $this->_data['resources'][$k]['span_name'] = '<span class="icon '.$v->type.'" style="margin-top: -2px;color: #c8c8c8"> </span> '.$name.'';
                    $this->_data['resources'][$k]['resource_id'] = $v->res_id;
                    $this->_data['resources'][$k]['preview'] = $this->resoucePreview($v, '/f3_teacher/resource/');
                    $this->_data['resources'][$k]['type'] = $v->type;
                    $this->_data['resources'][$k]['content'] = $v->content;
                    $this->_data['resources'][$k]['behavior'] = $v->behavior;
                    $this->_data['resources'][$k]['marks_available'] = $this->getAvailableMarks($v->content);
                    $this->_data['resources'][$k]['attained'] = $this->student_answers_model->getAttained( array( 'student_id' => $student->id, 'resource_id' => $v->id, 'slide_id' => $assignment_id ) );
                    $score = 0;
                    $this->_data['resources'][$k]['styled'] = '';
                    if( in_array( $this->_data['resources'][$k]['type'], array('single_choice','multiple_choice','fill_in_the_blank','mark_the_words') ) ) {
                        $this->_data['resources'][$k]['span_name'] = '<span class="glyphicon glyphicon-question-sign" style="color: #e7423c"> </span> '.$name.'';
                        if( $this->_data['resources'][$k]['marks_available'] ) {
                            $score = number_format( ( $this->_data['resources'][$k]['attained'] * 100 ) / $this->_data['resources'][$k]['marks_available'] );
                        }
                        if( $score > 74 ) {
                            $stl = '#55bb55';
                        } elseif( $score > 49 ) {
                            $stl = '#99ee99';
                        } elseif( $score > 24 ) {
                            $stl = '#ffff99';
                        } else {
                            $stl = '#ff8866';
                        }
                        $this->_data['resources'][$k]['styled'] = '<span class="attained" style="background: '.$stl.'">'.$this->_data['resources'][$k]['attained'].'/'.$this->_data['resources'][$k]['marks_available'].'</span>';
                    }

                    $sm = $sm + $this->_data['resources'][$k]['attained'];
                    $ma = $ma + $this->_data['resources'][$k]['marks_available'];
                }
            } else {
                $this->_data['resource_hidden'] = 'hidden';
            }
            $submission_mark = $sm;
            $marks_avail = $ma;
        } else {
            $assignmet_mark = $this->assignment_model->get_mark_submission($assignment_id);
            if( empty( $assignmet_mark ) ) {
                $json_visual_data = array();
                    $json_visual_data[] = array(
                    "items" => array(),
                    "picture" => $this->config->item('red_pen_download_image')
                );

                $data = array(
                    'screens_data'=>json_encode($json_visual_data),
                    'resource_id'=>0,
                    'assignment_id'=>$assignment_id,
                    'pagesnum'=>0,
                    'total_evaluation'=>0
                );
                $mark_id = $this->assignment_model->update_assignment_mark(-1, $data);
            } else {
                $mark_id = $assignmet_mark[0]->id;
                $marks_sub_cat = json_decode($assignmet_mark[0]->screens_data);
                foreach( $marks_sub_cat as $pagek => $pagev ) {
                    foreach( $pagev->items as $areak => $areav ) {
                        $category_marks[$areav->cat] += $areav->evaluation;
                    }
                }
            }
            $submission_mark = $assignmet_mark[0]->total_evaluation;
            $this->_data['student_resources'] = array();
            $student_resources = $this->resources_model->get_assignment_resources($assignment_id);
            if( !empty( $student_resources ) ) {
                foreach( $student_resources as $k => $v ) {
                    $marks_total = 0;
                    $mark_data = $this->assignment_model->get_resource_mark($v->res_id);
                    if($mark_data[0]) {
                        $marks_total = $mark_data[0]->total_evaluation;
                        $marks_cat = json_decode($mark_data[0]->screens_data);
                        foreach($marks_cat as $pagek=>$pagev) {
                            foreach($pagev->items as $areak=>$areav) {
                                $category_marks[$areav->cat] += $areav->evaluation;
                            }
                        }
                    } else {
                        $marks_total = 0;
                    }
                    $submission_mark += $marks_total;
                    $display = 'none';
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
                    if( $v->is_late == 1 ) { $display = 'block'; };
                    $this->_data['student_resources'][$k]['is_late_hide'] = $display;
                    if( $assignment->publish ) {
                        $this->_data['student_resources'][$k]['view'] = '<a href="/f4_teacher/index/'.$base_assignment_id.'/'.$assignment_id.'/'.$v->res_id.'" class="btn b1"><span>VIEW</span><i class="icon i1"></i></a>';
                    } else {
                        $this->_data['student_resources'][$k]['view'] = $this->resoucePreview($v, '/f3_teacher/resource/');
                    }
                    $this->_data['student_resources'][$k]['download'] = $hider;
                }
                $this->_data['no-submission'] = "";
            } else {
                $this->_data['no-submission'] = "<tr><td colspan=\"5\" style=\"text-align:center;\"><br />This student has not attached any files to this submission.<br /></td></tr>";
            }
        }

        $this->_data['avarage_mark'] = $submission_mark;
        $this->_data['marks_avail'] = $marks_avail;
        $this->_data['attainment'] = $this->assignment_model->calculateAttainment($this->_data['avarage_mark'], $this->_data['marks_avail'], $base_assignment);

        foreach($assignment_categories as $ask=>$asv) {
            $assignment_categories[$ask]->category_total = $category_marks[$asv->id];
            $assignment_categories[$ask]->category_avail = $asv->category_marks;
        }

        if(!empty($assignment_categories)) {
            $this->_data['assignment_categories'] = $assignment_categories;
            $this->_data['assignment_categories_json'] = json_encode($assignment_categories);
        } else {
            $this->_data['assignment_categories_json'] = '';
            if($mode==2) $this->_data['list_hidden'] = 'none';
        }

        $this->_data['pages_num'] = 0;
        $this->_data['assignment_name'] = $assignmet_data->title;
        $this->_data['student_name'] = $student->first_name.' '.$student->last_name;
        $this->_data['student_id'] = $student->id;
        $this->_data['mark_id'] = $mark_id;
        $this->_data['base_assignment_id'] = $base_assignment_id;
        $this->_data['assignment_id'] = $assignment_id;
        $this->_data['homeworks_html_path'] =  $this->config->item('homeworks_html_path');
        $this->_data['resource_id'] = $resource_id;
        $this->_data['resource_name'] = $resource->name;
        $this->_data['feedback'] = $assignment->feedback;
        $this->_data['grade_type'] = $assignment->grade_type;
        $this->_data['grade'] = $assignment->grade;
        $this->_data['selected_link_a']=$this->_data['selected_link_b']='';
        if( $mode == 1 ){ $this->_data['selected_link_a']='sel'; } else { $this->_data['selected_link_b'] = 'sel'; }
        if( $assignment->publish == 0 ) {
            $this->_data['submitted_date'] = 'not submited';
        }
        $this->_data['attainment'] = $this->assignment_model->calculateAttainment($this->_data['avarage_mark'], $this->_data['marks_avail'], $base_assignment);

        $this->breadcrumbs->push('Home', base_url());
        $this->breadcrumbs->push('Homework', '/f1_teacher');
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

    public function loaddata($mark_id) {
        $assignmet_mark = $this->assignment_model->get_mark($mark_id);
//echo '<pre>';var_dump( $assignmet_mark );die;
        echo $assignmet_mark[0]->screens_data;
        die();
    }      

    public function savedata($mark_id) {
        $dt = $this->input->post('data');
        $base_assignment_id = $this->input->post('bassignment_id');
        $total_total = $this->input->post('tt');
        $total_avail = $this->input->post('ta');
        if($dt) {
            $dt_ = json_decode($dt);
            $totalEvaluation = 0;
            foreach ($dt_ as $pageK=>$page) {
                foreach ($page->items as $markK=>$mark) {
                    $totalEvaluation += (int) $mark->evaluation;
                }
            }

            $data = array(
                'screens_data'=>  $dt,
                'total_evaluation'=>$totalEvaluation
            );

            $m_id = $this->assignment_model->update_assignment_mark($mark_id, $data);
            $assignment_mark = $this->assignment_model->get_mark($m_id);
            $this->assignment_model->refresh_assignment_marked_status($assignment_mark[0]->assignment_id, $base_assignment_id);

            $base_assignment = $this->assignment_model->get_assignment($base_assignment_id);
            $attainment = $this->assignment_model->calculateAttainment($total_total, $total_avail, $base_assignment);

        }
        header('Content-Type: application/json');
        echo json_encode(Array('ok' => 1, 'attainment' => $attainment ) );
//            echo json_encode(Array('ok'=>0, 'mess'=>$message));
        exit();
//echo '<pre>';var_dump( $attainment );die;
//        echo ($assignment_mark);
//        echo ($m_id);
//        die();
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
                $ans = explode(',',$answer['answers']);
                foreach($ans as $v) {
                    $output['answers'][] = $v;
                }
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
