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

//echo '<pre>';var_dump( $assignment );die;
            $this->_data['student_first_name'] = $student->first_name;
            $this->_data['student_last_name'] = $student->last_name;

            $base_assignment = $this->assignment_model->get_assignment($base_assignment_id);
            $assignment = $this->assignment_model->get_assignment($assignment_id);
            $student = $this->user_model->get_user($assignment->student_id);
//echo '<pre>';var_dump( $assignment );die;

            $this->_data['base_assignment_name'] = $base_assignment->title;
            $this->_data['base_assignment_id'] = $base_assignment_id;
            $this->_data['assignment_id'] = $assignment_id;

            $this->_data['title'] = $assignment->title;

            $this->_data['submitted_date'] = date('d.m.Y', strtotime($assignment->submitted_date));
            $this->_data['submitted_time'] = date('H:i', strtotime($assignment->submitted_date));

            $details = $this->assignment_model->get_assignment_details($assignment_id, 1);
            $this->_data['submission_info'] = $details[0]->assignment_detail_value;

            $this->_data['list_hidden'] = 'block';

            $this->_data['assignment_categories'] = array();
            $assignment_categories = $this->assignment_model->get_assignment_categories($base_assignment_id);

            $marks_avail = 0;
            $category_marks = array();
            foreach( $assignment_categories as $ask => $asv ) {
                $marks_avail += (int) $asv->category_marks;
                $category_marks[$asv->id]=0;
            }

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
//echo '<pre>';var_dump( $assignment_categories );die;

            $submission_mark = $assignmet_mark[0]->total_evaluation;

            $this->_data['student_resources'] = array();
            $student_resources = $this->resources_model->get_assignment_resources($assignment_id);
            if( !empty( $student_resources ) ) {
//echo '<pre>';var_dump( $student_resources );die;
                foreach( $student_resources as $k => $v ) {
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
                    $this->_data['student_resources'][$k]['marks_total'] = $marks_total;
                    $this->_data['student_resources'][$k]['marks_avail'] = $marks_avail;
                    $this->_data['student_resources'][$k]['resource_name'] = $v->name;
                    $this->_data['student_resources'][$k]['resource_id'] = $v->res_id;
                    if( $v->is_late == 1 ) { $hider = ''; } else { $hider = 'x'; }
                    $this->_data['student_resources'][$k]['is_late_hide'] = $hider;
//echo '<pre>';var_dump( $assignment->publish );die;
                    if( $assignment->publish ) {
                        $this->_data['student_resources'][$k]['view'] = '<a href="/f4_teacher/index/'.$base_assignment_id.'/'.$assignment_id.'/'.$v->res_id.'" class="btn b1"><span>VIEW</span><i class="icon i1"></i></a>';
                    } else {
                        $this->_data['student_resources'][$k]['view'] = $this->resoucePreview($v, '/f3_teacher/resource/');
                    }
                    $this->_data['student_resources'][$k]['download'] = $hider;
                }
//echo '<pre>';var_dump( $this->_data['student_resources'] );die;

                $this->_data['no-submission'] = "";

            } else {
                $this->_data['no-submission'] = "<tr><td colspan=\"5\" style=\"text-align:center;\"><br />This student has not yet submitted their work.<br /></td></tr>";

//                if( $mode == 1 ) { $this->_data['list_hidden'] = 'none'; }
            }
            $this->_data['avarage_mark'] = $submission_mark;
            $this->_data['marks_avail'] = $marks_avail;
            $this->_data['attainment'] = $this->assignment_model->calculateAttainment($this->_data['avarage_mark'], $this->_data['marks_avail'], $base_assignment);
//echo '<pre>';var_dump( $this->_data['attainment'] );die;


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

//echo '<pre>';var_dump( $student->first_name );die;
            $this->_data['pages_num'] = 0;
            $this->_data['assignment_name'] = $assignmet_data->title;
            $this->_data['student_name'] = $student->first_name.' '.$student->last_name;
            $this->_data['mark_id'] = $mark_id;
            $this->_data['base_assignment_id'] = $base_assignment_id;
            $this->_data['assignment_id'] = $assignment_id;
            $this->_data['homeworks_html_path'] =  $this->config->item('homeworks_html_path');
            $this->_data['resource_id'] = $resource_id;
            $this->_data['resource_name'] = $resource->name;

//echo '<pre>'; var_dump( $assignment_categories );die;

            //prev_assignment_visible

            $this->_data['feedback'] = $assignment->feedback;
            $this->_data['grade_type'] = $assignment->grade_type;
            $this->_data['grade'] = $assignment->grade;
            $this->_data['selected_link_a']=$this->_data['selected_link_b']='';
            if($mode==1)$this->_data['selected_link_a']='sel';else $this->_data['selected_link_b']='sel';

//            $this->_data['publish'] = $assignment->publish;
            if( $assignment->publish == 0 ) {
                $this->_data['submitted_date'] = 'not submited';
//                $this->_data['list_hidden'] = 'none';
            }
//echo '<pre>';var_dump( $assignment->publish );die;
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
            $this->assignment_model->refresh_assignment_marked_status($assignment_mark[0]->assignment_id);

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
}
