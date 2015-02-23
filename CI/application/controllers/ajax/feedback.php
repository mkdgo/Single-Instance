<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Feedback extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('parser');
        $this->load->library('email');
        $this->load->model('user_model');
    }

    public function save_feedback() {
        $this->email->initialize(array(
            'crlf' => '\r\n',
            'newline' => '\r\n',
            'protocol' => 'smtp',
            'mailtype' => 'html',
            'smtp_host' => 'smtp.123-reg.co.uk',
            'smtp_user' => 'spas@hoyya.net',
            'smtp_pass' => 'Steely.01'
        ));

        $data = array();

        $data['reporterName'] = trim($this->session->userdata['first_name'] . ' ' . $this->session->userdata['last_name']);
        $data['reporterEmail'] = $this->session->userdata['email'];
        $data['path'] = $this->input->post('path');
        $data['location'] = $this->input->post('location');
        $data['feedback'] = $this->input->post('feedback');

        $emailBody = $this->parser->parse('mail_templates/feedback', $data, true);

        $this->email->from('spas@hoyya.net', 'spas@hoyya.net');
        $this->email->to(array('feedback@ediface.org', 'peterphillips8+8y1hd4mqylp0ip3ishsc@boards.trello.com'));
        $this->email->cc('anton@hoyya.net');
        $this->email->cc('spas@hoyya.net');
        $this->email->subject($data['path']);
        $this->email->message($emailBody);
        $sent = $this->email->send();
        
//        echo $this->email->print_debugger();
        echo json_encode(array(
            'status' => $sent
        ));
    }

}
