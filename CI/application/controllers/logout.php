<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Logout extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('onelogin');
        $this->config->load('onelogin');
        $this->load->model('lessons_model');

    }

    function index($logout = '') {
        if( $this->session->userdata('user_type') == 'teacher' ) {
            $this->lessons_model->close_running_lesson_for_teacher($this->session->userdata('id'));
        }

        $this->session->unset_userdata('user_type');
        $this->session->sess_destroy();
        $OL_settingsInfo = $this->config->item('onelogininfo');
        $OlAuth = $this->onelogin->OlAuth($OL_settingsInfo);
        $OlAuth->logout();

        $this->_logout();
    }
}
