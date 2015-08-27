<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class G1_student extends MY_Controller {

    private $student_id;
    private $student_name;

    function __construct() {
        parent::__construct();

        $this->load->model('user_model');
        $this->load->model('assignment_model');
        $this->load->model('work_model');
        $this->load->model('classes_model');


        $this->load->library('breadcrumbs');

        $this->student_id = intval($this->session->userdata['id']);
        $this->student_name = trim(ucfirst($this->session->userdata['first_name']) . ' ' . ucfirst($this->session->userdata['last_name']));
    }

    function index($subject_id = 0, $work_id = 0) {
        $subjects = array();

        $classCnt = 0;
        $classes = $this->user_model->get_student_classes($this->student_id);
        foreach ($classes as $class) {
            $worksCnt = 0;
            $works = $this->work_model->get_student_works_by_subject($this->student_id, $class->subject_id);
            foreach ($works as $work) {
                $work->items = $this->work_model->get_work_items_by_work_id($work->id);
                $work->offset = $worksCnt;
                $worksCnt++;
            }
            $teachers = array();
            $classTeachers = $this->classes_model->get_class_teachers($class->id);
            foreach ($classTeachers as $teacher) {
                $teachers[] = strtoupper(substr($teacher->first_name, 0, 1)) . '. ' . $teacher->last_name;
            }
            $subjects[$class->subject_id] = array(
                'id' => $class->subject_id,
                'name' => $class->subject_name,
                'classID' => $class->id,
                'offset' => $classCnt,
                'works' => $works,
                'teachers' => implode(', ', $teachers),
                'group_name' => $class->group_name,
                'logo_pic'=> is_file('uploads/subject_icons/'.$class->logo_pic)?' <img src="'.base_url().'uploads/subject_icons/'.$class->logo_pic.'"  style="position: absolute;left: 15px; width: 40px;height: 40px;top:12px;"/> ':''
            );

            $classCnt++;
        }

        $this->_data['subject_id'] = intval($subject_id);
        $this->_data['work_id'] = intval($work_id);
        $this->_data['subjects'] = $subjects;
        $this->_data['student_fullname'] = $this->student_name;

        $this->breadcrumbs->push('Home', base_url());
        $this->breadcrumbs->push('My Work', '/g1_student');
        $this->_data['breadcrumb'] = $this->breadcrumbs->show();

        $this->_paste_public();
    }

    function index_old($subject_id = 0, $work_id = 0) {
        $selectedSubject = $subject_id;
        $subjects = array();

        $firstKey = 0;
        $classes = $this->user_model->get_student_classes($this->student_id);
        foreach ($classes as $class) {
            $subjects[$class->subject_id] = array(
                'id' => $class->subject_id,
                'name' => $class->subject_name,
                'classID' => $class->id,
                'next' => $class->subject_id,
                'primary' => false
            );
            if ($firstKey === 0) {
                $firstKey = $class->subject_id;
            }
        }

        if (!array_key_exists($selectedSubject, $subjects)) {
            $selectedSubject = $firstKey;
        }

        $selectedSubjectPosition = array_search($selectedSubject, array_keys($subjects));
        $reorderedSubjects = array_merge(array_slice($subjects, $selectedSubjectPosition, null, true), array_slice($subjects, 0, $selectedSubjectPosition, true));

        $numSubjects = count($reorderedSubjects);
        if ($numSubjects > 1) {
            $reorderedSubjects[0]['next'] = $reorderedSubjects[1]['next'];
            $reorderedSubjects[0]['primary'] = true;
        }

        $assignments = $this->assignment_model->get_assignments_student($this->student_id, array(
            'A.active = 1',
            'A.publish = 0',
            'A.class_id = ' . $reorderedSubjects[0]['classID']
        ));

        $cnt = 1;
        $works = $this->work_model->get_student_works_by_subject($this->student_id, $selectedSubject);
        foreach ($works as $work) {
            $work->items = $this->work_model->get_work_items_by_work_id($work->id);
            $work->offset = $cnt;
            $cnt++;
        }

        $this->_data['subject_id'] = $selectedSubject;
        $this->_data['work_id'] = $work_id;
        $this->_data['class_id'] = $reorderedSubjects[0]['classID'];
        $this->_data['subjects'] = $reorderedSubjects;
        $this->_data['assignments'] = $assignments;
        $this->_data['works'] = $works;

        $this->_data['student_fullname'] = $this->student_name;

        $this->breadcrumbs->push('Home', base_url());
        $this->breadcrumbs->push('My Work', '/g1_student');
        $this->_data['breadcrumb'] = $this->breadcrumbs->show();

        $this->_paste_public();
    }

}
