<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Browse_Classes extends MY_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('admin_model');
        $this->load->library('session');

        if ($this->session->userdata('admin_logged') != true) {
            redirect(base_url() . 'admin/login');
        }
    }

    function index($teacher_id = 0) {
        $subjects = array();
        if (intval($teacher_id) > 0) {
            $db_subjects = $this->admin_model->getTeacherSubjects($teacher_id);
        } else {
            $db_subjects = $this->admin_model->get_all_published_subjects();
        }
        foreach ($db_subjects as $subject) {
            $subjects[$subject['id']] = $subject['name'];
        }

        $teachers = array();
        if (intval($teacher_id) > 0) {
            $db_teachers = $this->admin_model->browseSingleUser($teacher_id, 'teacher');
            if (count($db_teachers) !== 1) {
                redirect('admin/browse_classes', 'refresh');
            }
            $teacher = $db_teachers[0];
            $this->_data['teacher_name'] = $teacher['name'];
            $this->_data['teacher_id'] = $teacher['id'];
            
            $this->_data['all_teachers'] = $this->admin_model->browseUsers('teacher');
        } else {
            $db_teachers = $this->admin_model->browseUsers('teacher');
        }
        foreach ($db_teachers as $teacher) {
            $teacher_subjects = array();
            foreach ($subjects as $subject_id => $subject_name) {
                $teacher_subjects[$subject_id] = array(
                    'subject_name' => $subject_name,
                    'classes' => array()
                );
            }

            $teacher_classes = $this->admin_model->getTeacherClasses($teacher['id']);
            foreach ($teacher_classes as $class) {
                $teacher_subjects[$class['subject_id']]['classes'][] = $class;
            }

            $teachers[] = array(
                'id' => $teacher['id'],
                'email' => $teacher['email'],
                'name' => $teacher['name'],
                'subjects' => $teacher_subjects
            );
        }

        $this->_data['subjects'] = $subjects;
        $this->_data['teachers'] = $teachers;

        if (intval($teacher_id) > 0) {
            $this->_paste_admin(false, 'admin/browse_classes_single_teacher');
        } else {
            $this->_paste_admin(false, 'admin/browse_classes');
        }
    }

}
