<?php

class Settings_model extends CI_Model {

    const SITE_SETTINGS_TABLE = 'site_settings';

    public function __construct() {
        parent::__construct();
    }

    public function getAllSettings() {
        return $this->db->get(self::SITE_SETTINGS_TABLE)->result_array();
    }

    public function getAllSettingsAsAssocArray() {
        $settings = array();

        $dbSettings = $this->db->get(self::SITE_SETTINGS_TABLE)->result_array();
        foreach ($dbSettings as $dbSetting) {
            $settings[$dbSetting['setting_id']] = $dbSetting['setting_value'];
        }

        return $settings;
    }

    public function getDefaultIdentityDataProvider() {
        $this->db->where('setting_id', 'default_identity_data_provider');
        $row = $this->db->get(self::SITE_SETTINGS_TABLE)->row_array();
        if (!$row) {
            return '';
        }

        return $row['setting_value'];
    }

    public function getFallBackToDefaultIdentityDataProvider() {
        $this->db->where('setting_id', 'fall_back_to_default_identity_data_provider');
        $row = $this->db->get(self::SITE_SETTINGS_TABLE)->row_array();
        if (!$row) {
            return false;
        }

        return $row['setting_value'];
    }

    public function getSetting($setting_id) {
        $this->db->select('setting_value');
        $this->db->where('setting_id', $setting_id);
        $this->db->from(self::SITE_SETTINGS_TABLE);
        
        $query = $this->db->get();
        
        if ($query->num_rows() !== 1) {
            return '';
        }
        
        $data = $query->result_array();
        return $data[0]['setting_value'];
    }
    
    public function updateAllSettings($updateData) {
        foreach ($updateData as $k => $v) {
            $this->db->select('id');
            $this->db->from(self::SITE_SETTINGS_TABLE);
            $this->db->where('setting_id', $k);
            
            $query = $this->db->get();
            
            if ($query->num_rows() == 0) {
                $this->createSetting($k, $v);
            } else {
                $this->updateSetting($k, $v);
            }
        }
    }

    private function createSetting($setting_id, $setting_value) {
        $this->db->set('setting_id', $setting_id);
        $this->db->set('setting_value', $setting_value);
        $this->db->insert(self::SITE_SETTINGS_TABLE);
    }

    private function updateSetting($setting_id, $setting_value) {
        $this->db->where('setting_id', $setting_id);
        $this->db->set('setting_value', $setting_value);
        $this->db->update(self::SITE_SETTINGS_TABLE);
    }

}
