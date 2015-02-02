<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class A1 extends MY_Controller {

    function __construct() {
        parent::__construct();
    }

    function index() {
        $this->load->model('user_model');
        $this->_data['login_error'] = '';

        if ($this->input->post('login_email')) {
            $user = $this->user_model->check_user_exist(
                    $this->input->post('login_email'), $this->input->post('login_password')
            );

            if (!empty($user)) {
                $session_array = array(
                    'id' => $user[0]->id,
                    'email' => $user[0]->email,
                    'first_name' => $user[0]->first_name,
                    'last_name' => $user[0]->last_name,
                    'birthdate' => $user[0]->birthdate,
                    'user_type' => $user[0]->user_type
                );
                $this->session->set_userdata($session_array);
            } else {
                $this->_data['login_error'] = 'Login incorrect.';
            }
        }

        if ($this->session->userdata('user_type') == "teacher") {
            redirect('/b2', 'refresh');
        } elseif ($this->session->userdata('user_type') == "student") {
            redirect('/b1', 'refresh');
        }


        $this->_paste_public();
    }

}
