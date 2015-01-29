<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class SEARCH_ADMIN extends MY_Controller {

	function __construct() {
            
		parent::__construct();
		$this->load->model('resources_model');
		$this->load->model('modules_model');
		$this->load->model('lessons_model');
		$this->load->model('content_page_model');
		$this->load->model('interactive_assessment_model');
		$this->load->model('assignment_model');
		$this->load->model('user_model');
		$this->load->library('zend');
		$this->zend->load('Zend/Search/Lucene'); 
	}
 
	function index() {	
		
		$this->_paste_public();
	}

}
