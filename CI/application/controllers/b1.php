<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class B1 extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('assignment_model');
    }

    function index() {
        //$student_assignments = $this->assignment_model->get_student_assignments_active($this->user_id);
        $opened = $this->assignment_model->get_assignments_student($this->user_id, array( 'A.active != -1', 'A.publish = 0', 'A.deadline_date > NOW()'));
        $past = $this->assignment_model->get_assignments_student($this->user_id, array( 'A.active != -1', 'A.publish = 0',  'A.publish_marks = 0', 'A.deadline_date < NOW()'));
        
        $this->_data['student_assignments'] = count($past)+count($opened);
        $this->_data['late'] = count($past);
        $this->_data['dot_hidden'] = 'block';
        if( count($student_assignments) == 0 ) $this->_data['dot_hidden'] = 'none';
        $this->_paste_public();
    }

}
