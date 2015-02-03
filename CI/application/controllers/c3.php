<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class C3 extends MY_Controller {

    function __construct() {
        parent::__construct();
    }

    function index() {
        
        $this->_paste_public();
    }

}
