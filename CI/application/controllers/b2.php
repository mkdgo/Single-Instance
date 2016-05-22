<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class B2 extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->lang->load('b2', 'english');
        $this->_data['lang'] = $this->lang->language;
    }

    function index() {
        $this->_paste_public();
    }

}
