<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class F5_teacher extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('assignment_model');
        $this->load->model('user_model');
        $this->load->model('work_model');
        $this->load->model('subjects_model');
        $this->load->model('classes_model');
        $this->load->model('resources_model');
        $this->load->library('breadcrumbs');
    }

    public function index($subject_id, $year_id, $class_id, $student_id, $work_id, $work_item_id) {
        $workItem = $this->work_model->get_work_item_by_work_id_and_student_id($work_item_id, $work_id, $student_id);

        if (!$workItem) {
            redirect('g1_teacher/student/' . $subject_id . '/' . $year_id . '/' . $class_id . '/' . $student_id, 'refresh');
        }

        $previous = 0;
        $next = 0;
        $allWorkItems = $this->work_model->get_work_items_by_work_id($work_id);
        foreach ($allWorkItems as $wi) {
            if (intval($work_item_id) > intval($wi->work_item_id)) {
                $previous = intval($wi->work_item_id);
            } else if (intval($work_item_id) < intval($wi->work_item_id)) {
                if ($next === 0) {
                    $next = intval($wi->work_item_id);
                }
            }
        }
        $this->_data['prev_work_item'] = $previous;
        $this->_data['prev_work_item_visible'] = ($previous > 0) ? 'block' : 'none';
        $this->_data['next_work_item'] = $next;
        $this->_data['next_work_item_visible'] = ($next > 0) ? 'block' : 'none';
        
        $resource_id = $workItem->resource_id;

        $assignment_marks = $this->assignment_model->get_resource_mark($resource_id);

        $resource = $this->resources_model->get_resource_by_id($resource_id);

        $subjectYear = $this->subjects_model->get_year($year_id);
        $year = $subjectYear->year;

        $studentClass = $this->classes_model->get_single_class_by_subject_and_year($subject_id, $year, $class_id);
        
        $this->config->load('upload');
        $homeworks_dir = $this->config->item('homeworks_path');

        $cntr = 1;
        $generated_pages = array();
        while (is_file($homeworks_dir . 'work_' . $work_id . '/' . $resource_id . '_' . ($cntr - 1) . '.jpg')) {
            $generated_pages[] = 'work_' . $work_id . '/' . $resource_id . '_' . ($cntr - 1) . '.jpg';
            $cntr++;
        }

        if (empty($assignment_marks)) {
            $json_visual_data = array();
            foreach ($generated_pages as $k => $v) {
                $json_visual_data[] = array(
                    "items" => array(),
                    "picture" => $v
                );
            }

            $pages_num = count($json_visual_data);

            if ($pages_num == 0) {
                $json_visual_data[] = array(
                    "items" => array(),
                    "picture" => $this->config->item('red_pen_download_image')
                );
            }

            $data = array(
                'screens_data' => json_encode($json_visual_data),
                'resource_id' => $resource_id,
                'assignment_id' => 0,
                'pagesnum' => $pages_num,
                'total_evaluation' => 0
            );

            $mark_id = $this->assignment_model->update_assignment_mark(-1, $data);
        } else {
            $mark_id = $assignment_marks[0]->id;
            $pages_num = $assignment_marks[0]->pagesnum;
        }

        $this->_data['pages_num'] = $pages_num;
        $this->_data['work_name'] = $workItem->work_title;
        $this->_data['student_name'] = $workItem->student_first_name . ' ' . $workItem->student_last_name;
        $this->_data['mark_id'] = $mark_id;
        $this->_data['homeworks_html_path'] = $this->config->item('homeworks_html_path');
        $this->_data['resource_id'] = $resource_id;
        $this->_data['resource_name'] = $resource->name;

        if ($this->user_type == 'student') {
//            $this->breadcrumbs->push('My Homework', '/f1_student');
//            $this->breadcrumbs->push($workItem->work_title, '/f2_student/index/' . $assignment_id);
        } else {
            $this->breadcrumbs->push('Home', base_url());
            $this->breadcrumbs->push('Students', '/g1_teacher');
            $this->breadcrumbs->push('Subjects', '/g1_teacher/subjects');
            $this->breadcrumbs->push($workItem->subject_name, '/g1_teacher/subjects/' . $subject_id);
            $this->breadcrumbs->push($this->_ordinal($year) . ' grade', '/g1_teacher/years/' . $subject_id . '/' . $year_id);
            $this->breadcrumbs->push('Class ' . $studentClass['year'] . str_replace($studentClass['year'], '', $studentClass['group_name']), '/g1_teacher/studentclass/' . $subject_id . '/' . $year_id . '/' . $class_id);
            $this->breadcrumbs->push($workItem->student_first_name . ' ' . $workItem->student_last_name, '/g1_teacher/student/' . $subject_id . '/' . $year_id . '/' . $class_id . '/' . $student_id . '/' . $work_id . '/' . $work_item_id);
            $this->breadcrumbs->push($workItem->work_title, '/g1_teacher/student/' . $subject_id . '/' . $year_id . '/' . $class_id . '/' . $student_id . '/' . $work_id . '/' . $work_item_id);
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

        if ($dt) {
            $dt_ = json_decode($dt);
            $totalEvaluation = 0;
            foreach ($dt_ as $pageK => $page) {
                foreach ($page->items as $markK => $mark) {
                    $totalEvaluation += (int) $mark->evaluation;
                }
            }

            $data = array(
                'screens_data' => $dt,
                'total_evaluation' => $totalEvaluation
            );

            $m_id = $this->assignment_model->update_assignment_mark($mark_id, $data);
            $assignment_mark = $this->assignment_model->get_mark($m_id);
            $this->assignment_model->refresh_assignment_marked_status($assignment_mark[0]->assignment_id);
        }
        echo ($m_id);
        die();
    }

    private function _ordinal($number) {
        $ones = $number % 10;
        $tens = floor($number / 10) % 10;
        if ($tens == 1) {
            $suffix = "th";
        } else {
            switch ($ones) {
                case 1 : $suffix = "st";
                    break;
                case 2 : $suffix = "nd";
                    break;
                case 3 : $suffix = "rd";
                    break;
                default : $suffix = "th";
            }
        }
        return $number . $suffix;
    }

}
