<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Settings extends MY_Controller {

    function __construct() {
        parent::__construct();

        $this->load->library('session');
        if ($this->session->userdata('admin_logged') != true) {
            redirect(base_url() . 'admin/login');
        }

        $this->load->model('settings_model');
    }

    function index() {
        $this->_data['settings'] = $this->settings_model->getAllSettingsAsAssocArray();
        $this->_paste_admin(false, 'admin/settings');
    }

    function save() {
        $updateData = array();
        
        foreach($this->input->post() as $k => $v) {
            if (trim(strtolower($k)) !== 'save') {
                if (trim(strtolower($k)) === 'elastic_url') {
                    if (substr($v, 0, 7) === 'http://') {
                        $v = substr($v, 7);
                    } else if (substr($v, 0, 8) === 'https://') {
                        $v = substr($v, 8);
                    }
                }
                
                $updateData[$k] = $v;
            }
        }
        
        $this->settings_model->updateAllSettings($updateData);
                
        redirect(base_url() . 'admin/settings', 'refresh');
    }

}
