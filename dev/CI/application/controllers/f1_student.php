<?php

    if (!defined('BASEPATH'))
        exit('No direct script access allowed');

    class F1_student extends MY_Controller {

        function __construct() {
            parent::__construct();
            $this->load->model('assignment_model');
            $this->load->model('resources_model');
            $this->load->library('breadcrumbs');
        }

        private function process_assignments($name, $data) {
            $this->_data[$name] = array();
            $this->_data[$name . '_hidden'] = count($data) == 0 ? 'hidden' : '';
            foreach($data as $key => $value){
                $this->_data[$name][$key]['id'] = $value->id;
                $this->_data[$name][$key]['name'] = $value->title;
                $this->_data[$name][$key]['subject_name'] = $value->subject_name;
                $this->_data[$name][$key]['date'] = date('d.m.Y', strtotime($value->deadline_date));

                $this->_data[$name][$key]['mark'] = $this->getMark($value);

                $this->_data[$name][$key]['marked'] = $value->marked;

                $this->_data[$name][$key]['grade'] = $value->grade;
            }	
        }	

        function index() {		
            $opened = $this->assignment_model->get_assignments_student($this->user_id, array('A.active = 1', 'A.publish = 0', 'A.deadline_date > NOW()'));
            $this->process_assignments('opened', $opened);

            $past = $this->assignment_model->get_assignments_student($this->user_id, array('A.active = 1', 'A.publish = 0',  'A.publish_marks = 0', 'A.deadline_date < NOW()'));
            $this->process_assignments('past', $past);

            $submitted = $this->assignment_model->get_assignments_student($this->user_id, array('A.active = 1', 'A.publish >= 1',  '(A.publish_marks=0 OR (A.publish_marks=1 AND (A.grade=0 OR A.grade="")) )'));
            $this->process_assignments('submitted', $submitted);

            $marked = $this->assignment_model->get_assignments_student($this->user_id, array('A.active = 1', 'A.publish >= 1',  'A.publish_marks=1', 'A.grade != 0 AND A.grade != ""' ));
            $this->process_assignments('marked', $marked);
            $this->breadcrumbs->push('Home', base_url());
            $this->breadcrumbs->push('My Homework', '/f1_student');
            $this->_data['breadcrumb'] = $this->breadcrumbs->show();

            $this->_paste_public();
        }

        private function getMark($assignment)
        {
            //SA
            $base_assignment = $this->assignment_model->get_assignment($assignment->base_assignment_id);
            $assignment_categories = $this->assignment_model->get_assignment_categories($assignment->base_assignment_id);

            $marks_avail = 0;

            foreach($assignment_categories as $ask=>$asv)
            {
                $marks_avail += (int) $asv->category_marks;
            }

            $submission_mark = 0;
            $student_resources = $this->resources_model->get_assignment_resources($assignment->id);
            foreach ($student_resources as $k => $v)
            {
                $mark_data = $this->assignment_model->get_resource_mark($v->res_id);
                if($mark_data[0])
                {
                    $marks_total=$mark_data[0]->total_evaluation;
                }else
                {
                    $marks_total=0;
                }

                $submission_mark += $marks_total;
            }

            if($assignment->publish_marks!=1)$submission_mark=0;

            return $this->assignment_model->calculateAttainment($submission_mark, $marks_avail*count($student_resources), $base_assignment);

        }

}