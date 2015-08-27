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
        $this->load->model('resources_model');
    }

    function index() {
        $this->_data['settings'] = $this->settings_model->getAllSettingsAsAssocArray();
        $tvls = $this->settings_model->getTeacherLessons();
//echo '<pre>';var_dump( $tvls );die;
        foreach( $tvls as $tvl ) {
            $res = $this->resources_model->get_resource_by_id( $tvl['setting_value'] );
            $rew[$tvl['setting_id']]['resource_view'] = $res ? $this->resoucePreview($res, '/f3_teacher/resource/') : '';
            $rew[$tvl['setting_id']]['value'] = $tvl['setting_value'];
        }

//echo '<pre>';var_dump( $rew );die;
        $this->_data['tvls'] = $rew;
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

    function loadResource() {
        $setting_id = trim($this->input->get( 'setting_id', false ));
//echo '<pre>';var_dump( $setting_id );die;
        $setting_id_resource = $this->settings_model->getSettingResource( $setting_id );
        $setting_id_resource['setting_id'] = $setting_id;
//echo '<pre>';var_dump( $setting_id_resource );die;
        echo json_encode( $setting_id_resource );
    }

    function saveVideoLesson() {
        $data = $this->input->post();
//echo '<pre>';var_dump( $data );die;
        $setting_id = $this->input->post('setting_id');
        $setting_id_resource = $this->settings_model->getSettingResource( $setting_id );
//echo '<pre>';var_dump( $setting_id_resource );die;
//        $setting_id_resource['id'] = $data['id'];
        $data_edit = array();
        $data_edit['type'] = $data['type'];
        $data_edit['is_remote'] = $data['is_remote'];
        $data_edit['link'] = $data['link'];
        $data_edit['name'] = $data['name'];
        $data_edit['resource_name'] = $data['resource_name'];
        $data_edit['active'] = 1;
//        $resource = $this
        if( $data['res_id'] ) {
            $setting_value = $this->resources_model->save($data_edit, $data['res_id']);
        } else {
            $data['res_id'] = $this->resources_model->save($data_edit);
            $this->settings_model->addSettingValue($setting_id, $data['res_id']);
        }
//        $setting_id_resource['setting_id'] = $setting_id;
//echo '<pre>';var_dump( $data );die;
        echo json_encode( $data );
    }

}
