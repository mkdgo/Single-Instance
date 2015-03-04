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
        $allSettings = array_keys($this->settings_model->getAllSettingsAsAssocArray());
        
        foreach ($allSettings as $key) {
            $updateData[$key] = $this->input->post($key, TRUE);
        }
        
        $this->settings_model->updateSiteSettings($updateData);
                
        redirect(base_url() . 'admin/settings', 'refresh');
    }

}
