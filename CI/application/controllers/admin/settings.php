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

    function clearTables() {
        $data = $_POST;
        $responce = false;

        if( empty( $data ) ) {
            $responce = false;
        } else {
            if( isset( $data['all'] ) && $data['all'] ) {
                $result = $this->db->query("call clear_tables()");
            } else {
                if( isset( $data['users'] ) && $data['users'] ) {
                    $result = $this->db->query("call clear_users()");
                }
                if( isset( $data['classes'] ) && $data['classes'] ) {
                    $result = $this->db->query("call clear_classes()");
                }
                if( isset( $data['assignments'] ) && $data['assignments'] ) {
                    $result = $this->db->query("call clear_assignments()");
                }
                if( isset( $data['resources'] ) && $data['resources'] ) {
                    $result = $this->db->query("call clear_resources()");
                }
            }
            if( $result ) {
                $responce = true;
            }
        }
        echo json_encode( $responce = array( 'status' => $responce ));
        exit();
    }
}
