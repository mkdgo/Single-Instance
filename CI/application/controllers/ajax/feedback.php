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
//        $this->email->initialize(array(
//            'crlf' => '\r\n',
//            'newline' => '\r\n',
//            'protocol' => 'smtp',
//            'mailtype' => 'html',
//            'smtp_host' => 'smtp.123-reg.co.uk',
//            'smtp_user' => 'spas@hoyya.net',
//            'smtp_pass' => 'Steely.01'
//        ));

        $this->email->initialize(array(
            'crlf' => '\r\n',
            'newline' => '\r\n',
            'protocol' => 'mail',
            'mailtype' => 'html'
        ));
        $data = array();
        $data['reporterName'] = trim($this->session->userdata['first_name'] . ' ' . $this->session->userdata['last_name']);
        $data['reporterEmail'] = $this->session->userdata['email'];
        $data['user_type'] = $this->session->userdata['user_type'];
        $data['user_agent'] = $this->session->userdata['user_agent'];
//        $data['refferer'] = $_SERVER['HTTP_REFERER'];
        $data['path'] = $this->input->post('path');
        $data['location'] = $this->input->post('location');
        $data['feedback'] = $this->input->post('feedback');
//echo '<pre>';var_dump( $data );die;

        $emailBody = $this->parser->parse('mail_templates/feedback', $data, true);
        $subject = "FEEDBACK: ".$data['reporterName'].' - '.$data['path'].' - '.$data['feedback'];

        $this->email->from('feedback@ediface.org', 'feedback@ediface.org');
        $this->email->to(array('peterphillips8+8y1hd4mqylp0ip3ishsc@boards.trello.com'));
        $this->email->cc('anton@hoyya.net');
        $this->email->bcc('mitko@stoysolutions.com');
        $this->email->subject($subject);
        $this->email->message($emailBody);
        $sent = $this->email->send();

        $this->email->clear();
        
        $support_subject = date('d/m/Y').' - '.$data['path'];
        $this->email->initialize(array(
            'crlf' => '\r\n',
            'newline' => '\r\n',
            'protocol' => 'mail',
            'mailtype' => 'html'
        ));
        $this->email->from($data['reporterEmail'], $data['reporterName']);
        $this->email->to(array('support@ediface.org'));
        $this->email->reply_to($data['reporterEmail'], $data['reporterName']);
        $this->email->bcc('mitko@stoysolutions.com');
        $this->email->subject($support_subject);
        $this->email->message($emailBody);
        $sent = $this->email->send();


        echo json_encode(array(
            'status' => $sent
        ));
    }

}
