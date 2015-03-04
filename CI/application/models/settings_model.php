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

    public function updateSiteSettings($updateData) {
        foreach ($updateData as $k => $v) {
            $this->db->set('setting_value', $v);
            $this->db->where('setting_id', $k);
            $this->db->update(self::SITE_SETTINGS_TABLE);
        }
    }

}
