<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class F4_teacher extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('assignment_model');
        $this->load->model('user_model');
        $this->load->model('resources_model');
        $this->load->library('breadcrumbs');
    }

    public function index($base_assignment_id='', $assignment_id='', $resource_id='') {
        $base_assignment = $this->assignment_model->get_assignment($base_assignment_id);

        $assignmet_data = $this->assignment_model->get_assignment($assignment_id);
        $assignmet_student = $this->user_model->get_user($assignmet_data->student_id);

        $assignmet_mark = $this->assignment_model->get_resource_mark($resource_id);
//echo '<pre>';var_dump( $assignmet_mark );die;

        $resource = $this->resources_model->get_resource_by_id($resource_id);

        $this->config->load('upload');
        $homeworks_dir = $this->config->item('homeworks_path');

        $cntr = 1;
        $generated_pages = array();
        while( is_file($homeworks_dir.$assignment_id.'/'.$resource_id.'_'.($cntr-1).'.jpg')) {
            $generated_pages[] = $assignment_id.'/'.$resource_id.'_'.($cntr-1).'.jpg';
            $cntr++;
        }

        if(empty($assignmet_mark)) {
            $json_visual_data = array();
            foreach($generated_pages as $k=>$v) {
                $json_visual_data[] = array(
                "items"=> array(),
                "picture"=>$v
                );
            }
            $pages_num = count($json_visual_data);

            if($pages_num==0) {
                $json_visual_data[] = array(
                "items" => array(),
                "picture" => $this->config->item('red_pen_download_image')
                );
            }

            $data = array(
            'screens_data'=>json_encode($json_visual_data),
            'resource_id'=>$resource_id,
            'assignment_id'=>$assignment_id,
            'pagesnum'=>$pages_num,
            'total_evaluation'=>0
            );

            $mark_id = $this->assignment_model->update_assignment_mark(-1, $data);
        } else {
            $mark_id = $assignmet_mark[0]->id;
            $pages_num = $assignmet_mark[0]->pagesnum;
        }

        $this->_data['pages_num'] = $pages_num;
        $this->_data['assignment_name'] = $assignmet_data->title;
        $this->_data['student_name'] = $assignmet_student->first_name.' '.$assignmet_student->last_name;
        $this->_data['mark_id'] = $mark_id;
        $this->_data['base_assignment_id'] = $base_assignment_id;
        $this->_data['assignment_id'] = $assignment_id;
        $this->_data['homeworks_html_path'] =  $this->config->item('homeworks_html_path');
        $this->_data['resource_id'] = $resource_id;
        $this->_data['resource_name'] = $resource->name;

        $assignment_categories = $this->assignment_model->get_assignment_categories($base_assignment_id);



        foreach($assignment_categories as $ask=>$asv) {
//            $marks_avail += (int) $asv->category_marks;
            $category_marks[$asv->id]=0;
        }
        $student_resources = $this->resources_model->get_assignment_resources($assignment_id);
        foreach ($student_resources as $k => $v) {
            $mark_data = $this->assignment_model->get_resource_mark($v->res_id);
            if($mark_data[0]) {
//                $marks_total=$mark_data[0]->total_evaluation;
                $marks_cat = json_decode($mark_data[0]->screens_data);
                foreach($marks_cat as $pagek=>$pagev) {
                    foreach($pagev->items as $areak=>$areav) {
                        $category_marks[$areav->cat]+=$areav->evaluation;
                    }
                }
            }
        }

        foreach( $assignment_categories as $ask => $asv ) {
            $assignment_categories[$ask]->category_total = $category_marks[$asv->id];
//            $assignment_categories[$ask]->category_avail = $asv->category_marks;
        }






        $this->_data['assignment_categories'] = $assignment_categories;
        $this->_data['assignment_categories_json'] = json_encode($assignment_categories);

        if($this->user_type=='student') {
            $this->breadcrumbs->push('My Homework', '/f1_student');
            $this->breadcrumbs->push($assignmet_data->title, '/f2_student/index/'.$assignment_id);
        } else {
            $this->breadcrumbs->push('Home', base_url());
            $this->breadcrumbs->push('Homework', '/f1_teacher');
            $this->breadcrumbs->push($base_assignment->title, '/f2b_teacher/index/'.$base_assignment_id);
            $this->breadcrumbs->push($assignmet_student->first_name.' '.$assignmet_student->last_name, "/f3_teacher/index/".$base_assignment_id."/".$assignment_id);
        }

        $this->breadcrumbs->push($resource->name, '/');
        $this->_data['breadcrumb'] = $this->breadcrumbs->show();
        $this->_paste_public();

    }

    public function loaddata($mark_id) {
        $assignmet_mark = $this->assignment_model->get_mark($mark_id);

        echo $assignmet_mark[0]->screens_data;

        die();
    }      

    public function savedata($mark_id) {
        $dt = $this->input->post('data');

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
        }

        echo ($m_id);
        die();
    }

}