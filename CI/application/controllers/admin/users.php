<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Users extends MY_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('admin_model');
        $this->load->library('session');

        if ($this->session->userdata('admin_logged') != true) {
            redirect(base_url() . 'admin/login');
        }
    }

    function index() {
        $this->_paste_admin(false, 'admin/users');
    }

    function doSearch($firstName, $lastName, $emailAddress, $userType, $page, $count) {
        $users = $this->admin_model->searchUsers($firstName, $lastName, $emailAddress, $userType, 10, ($page - 1) * 10);
        echo json_encode(array(
            'status' => true,
            'page' => $page,
            'totalPages' => intval(round($count / 10)),
            'count' => $count,
            'data' => $users
        ));
    }

    function delete() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = intval($this->input->post('id', true));
            $data = $this->admin_model->getUser($id);
            if ($data) {
                $user_type = strtolower($data->user_type);
                if ($user_type === 'teacher') {
                    $data = $this->admin_model->deleteTeacher($id);
                } else if ($user_type === 'student') {
                    $data = $this->admin_model->deleteStudent($id);
                }
                echo json_encode(array('status' => true));
            } else {
                echo json_encode(array('status' => false));
            }
        } else {
            echo json_encode(array('status' => false));
        }
    }

    function search_navigate() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $firstName = trim($this->session->userdata('user_search_firstName'));
            $lastName = trim($this->session->userdata('user_search_lastName'));
            $emailAddress = trim($this->session->userdata('user_search_emailAddress'));
            $userType = trim($this->session->userdata('user_search_userType'));
            $page = intval($this->input->post('page', true));
            if ($page === 0) {
                $page = 1;
            }

            $count = $this->admin_model->countUsers($firstName, $lastName, $emailAddress, $userType);
            if ($count > 0) {
                $this->doSearch($firstName, $lastName, $emailAddress, $userType, $page, $count);
            } else {
                echo json_encode(array(
                    'status' => true,
                    'data' => null
                ));
            }
        } else {
            echo json_encode(array('status' => false));
        }
    }

    function search() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $firstName = trim($this->input->post('firstName', true));
            $lastName = trim($this->input->post('lastName', true));
            $emailAddress = trim($this->input->post('emailAddress', true));
            $userType = trim($this->input->post('userType', true));
            $page = intval($this->input->post('page', true));
            if ($page === 0) {
                $page = 1;
            }

            $this->session->set_userdata('user_search_firstName', $firstName);
            $this->session->set_userdata('user_search_lastName', $lastName);
            $this->session->set_userdata('user_search_emailAddress', $emailAddress);
            $this->session->set_userdata('user_search_userType', $userType);

            $count = $this->admin_model->countUsers($firstName, $lastName, $emailAddress, $userType);
            if ($count > 0) {
                $this->doSearch($firstName, $lastName, $emailAddress, $userType, $page, $count);
            } else {
                echo json_encode(array(
                    'status' => true,
                    'data' => null
                ));
            }
        } else {
            echo json_encode(array('status' => false));
        }
    }

    public function browse_teachers() {
        $this->_data['teachers'] = $this->admin_model->browseUsers('teacher');
        $this->_paste_admin(false, 'admin/browse_teachers');
    }

    function browse_students() {
        $subjects = array();
        $db_subjects = $this->admin_model->get_all_published_subjects();
        foreach ($db_subjects as $subject) {
            $subjects[$subject['id']] = $subject['name'];
        }

        $students = array();
        $db_students = $this->admin_model->browseUsers('student');
        foreach ($db_students as $student) {
            $student_subjects = array();
            foreach ($subjects as $subject_id => $subject_name) {
                $student_subjects[$subject_id] = array(
                    'subject_name' => $subject_name,
                    'class_year' => '',
                    'class_name' => ''
                );
            }

            $student_classes = $this->admin_model->getUserClasses($student['id']);
            foreach ($student_classes as $class) {
                if (array_key_exists($class['subject_id'], $student_subjects)) {
                    $student_subjects[$class['subject_id']] = array(
                        'subject_name' => $class['subject_name'],
                        'class_year' => $class['class_year'],
                        'class_name' => $class['class_name']
                    );
                }
            }

            $students[] = array(
                'id' => $student['id'],
                'email' => $student['email'],
                'name' => $student['name'],
                'year' => $student['year'],
                'classes' => $student_subjects
            );
        }

        $this->_data['subjects'] = $subjects;
        $this->_data['students'] = $students;

        $this->_paste_admin(false, 'admin/browse_students');
    }

}
