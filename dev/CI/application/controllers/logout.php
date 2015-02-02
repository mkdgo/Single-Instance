<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Logout extends MY_Controller {

	function __construct() {
		parent::__construct();
	}

	function index($logout = '') {
	   $this->session->unset_userdata('user_type');
	   $this->session->sess_destroy();
	   $this->_logout();
	}	
}