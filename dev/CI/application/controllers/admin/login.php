<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Login extends MY_Controller {

	function __construct(){
		  parent::__construct();
	}

	function index(){
		$data = array();		$this->_paste_admin('login');
	}

	function check(){
		if($this->input->post('login_pass') == '2013el'){			$newdata['admin'] = '2013el';			$this->session->set_userdata($newdata);			redirect('/admin', 'refresh');
		}else{
			redirect('/admin/login', 'refresh');
		}
	}

	function logout(){
		$newdata['admin'] = '';		$this->session->unset_userdata($newdata);		redirect('/admin/login', 'refresh');
	}
}