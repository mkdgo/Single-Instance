<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class B1 extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('assignment_model');
    }

    function index()
    {
        $student_assignments = $this->assignment_model->get_student_assignments_active($this->user_id);
        $this->_data['student_assignments'] = count($student_assignments);
//       echo '<pre>';
//        print_r($student_assignments);
//        echo '</pre>';
        $this->_data['dot_hidden'] = 'block';
        if(count($student_assignments)==0)$this->_data['dot_hidden'] = 'none';
        
        
        
        $this->_paste_public();
    }

}
