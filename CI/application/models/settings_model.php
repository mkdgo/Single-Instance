<?php

class Settings_model extends CI_Model {

    const SITE_SETTINGS_TABLE = 'site_settings';

    public function __construct() {
        parent::__construct();
        $this->load->model('resources_model');
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
        
        if( $query->num_rows() !== 1 ) {
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

    public function addSettingValue($setting_id, $setting_value) {
        $this->db->where('setting_id', $setting_id);
        $this->db->set('setting_value', $setting_value);
        $this->db->update(self::SITE_SETTINGS_TABLE);
    }

    public function getHeadTitle() {
        $this->db->where('setting_id', 'website_head_title');
        $row = $this->db->get(self::SITE_SETTINGS_TABLE)->row_array();
        if (!$row) {
            return '';
        }
        
        return $row['setting_value'];
    }

    public function getTeacherLessons() {
        $this->db->select('*');
        $this->db->like('setting_id', 'tvlesson_', 'after');
        $rows = $this->db->get(self::SITE_SETTINGS_TABLE)->result_array();
//echo '<pre>';var_dump( $row );die;
        if( !$rows ) {
            return '';
        }
        return $rows;
    }

    public function getSettingResource( $setting_id ) {
//echo '<pre>';var_dump( $setting_id );die;
        $this->db->select('setting_value');
        $this->db->where('setting_id', $setting_id);
        $this->db->from(self::SITE_SETTINGS_TABLE);
        $query = $this->db->get();

        if( $query->num_rows() !== 1 ) {
            return '';
        }
        
        $data = $query->result_array();
        $set_val = $data[0]['setting_value'];

        $res = array(
            'id' => 0,
            'type' => '',
            'is_remote' => 1,
            'link' => '',
            'name' => '',
            'resource_name' => '',
            'active' => 1
        );        
        if( $set_val ) {
            $this->db->where( 'id', $set_val );
            $row = $this->db->get('resources')->row_array();
            
            $res['id'] = $row['id'];
            $res['type'] = $row['type'];
            $res['is_remote'] = $row['is_remote'];
            $res['link'] = $row['link'];
            $res['resource_name'] = $row['resource_name'];
            return $res;
        } else {
            return $res;
        }
    }

    public function getLessonLink( $setting_id )  {
/*
        $this->db->select('setting_value');
        $this->db->where('setting_id', $setting_id);
        $this->db->from(self::SITE_SETTINGS_TABLE);
        $query = $this->db->get();
        $data = $query->row_array();
//*/
        if( $setting_id ) {
            $res = $this->resources_model->get_resource_by_id($setting_id);
        } else {
            $res = false;
        }
//        $res = $this->resources_model->get_resource_by_id($data['setting_value']);
        $title = array(
            'tvlesson_creating_resources' => 'Creating Resources',
            'tvlesson_interactive_lessons' => 'Interactive Lessons',
            'tvlesson_setting_homework' => 'Setting Homework',
            'tvlesson_submitting_homework' => 'Submitting Homework',
            'tvlesson_marking_homework' => 'Marking Homework'
        );

        if( !$res ) {
//        if( $query->num_rows() !== 1 || !$res ) {
            return '<a href="#" onclick="alert(\'Soon available\')" style="text-align: left;"><span class="glyphicon glyphicon-facetime-video"></span><span>'.$title[$setting_id].'</span></a>';
        } else {
            $link = $this->resoucePreview($res);
//            $vlink = str_replace('https:', '', $R->link);
//            $vlink = str_replace('http:', '', $vlink);
//            $vlink = str_replace('watch?v=', '', $link);
//            $vlink = str_replace('embed/', '', $link);
//            $vlink = str_replace('youtube.com/', 'youtube.com/embed/', $link);
//            $vlink = str_replace('youtu.be/', 'www.youtube.com/embed/', $link);


            return $link.'<span class="glyphicon glyphicon-facetime-video"></span><span>'.$title[$setting_id].'</span></a>';
//            return '<a href="#" style="text-align: left;"><span class="glyphicon glyphicon-facetime-video"></span><span>'.$title[$setting_id].'</span></a>';
        }
    }

    public function resoucePreview($R) {
        if( !isset($R->id) && isset($R->res_id) ) {
            $R->id = $R->res_id;
        }
        $TP = $this->getResourceType($R);
//        $preview = $TP;
        if ($R->is_remote == 1) {
            if ($TP == 'video') {
                $upload_path = ltrim($this->config->item('upload_path', 'upload'), '.');
                $vlink = str_replace('https:', '', $R->link);
                $vlink = str_replace('http:', '', $vlink);
                $vlink = str_replace('watch?v=', '', $vlink);
                $vlink = str_replace('embed/', '', $vlink);
                $vlink = str_replace('youtube.com/', 'youtube.com/embed/', $vlink);
                $vlink = str_replace('youtu.be/', 'www.youtube.com/embed/', $vlink);
//var_dump( $vlink );//die;

                $preview = '<a style="text-align: left;" onClick="$(this).colorbox({iframe:true, innerWidth:\'90%\', innerHeight:\'90%\', webkitallowfullscreen:true});" href="' . $vlink . '" title="' . $R->link . '">';
            } else {
                $upload_path = ltrim($this->config->item('upload_path', 'upload'), '.');
                $preview = '<a style="text-align: left;" onClick="$(this).colorbox({iframe:true, innerWidth:\'90%\', innerHeight:\'90%\', webkitallowfullscreen:true}); return false;" href="' . $R->link . '" title="' . $R->link . '" >';
            }
        } else {
            if ($TP == 'image') {
                $upload_path = ltrim($this->config->item('upload_path', 'upload'), '.');
                $preview = '<a style="text-align: left;" href="' . $loc . $R->id . '" title="' . $R->resource_name . '" >';
            } elseif( $TP == 'pdf' ) {
                $upload_config = $this->config->load('upload', TRUE);
                $upload_path = $this->config->item('upload_path', 'upload');
                $upload_path = ltrim($this->config->item('upload_path', 'upload'), '.');
                $path = "/uploads/resources/temp/";
                $preview = '<a style="text-align: left;" onClick="$(this).colorbox({iframe:true, innerWidth:\'90%\', innerHeight:\'90%\', webkitallowfullscreen:true});" href="/ViewerJS/index.html#' .  $path . $R->resource_name . '" title="' . $R->resource_name . '" >';
            } else {
                $upload_config = $this->config->load('upload', TRUE);
                $upload_path = $this->config->item('upload_path', 'upload');
                $upload_path = ltrim($this->config->item('upload_path', 'upload'), '.');
                $href = $loc . $R->id;
                $preview = '<a style="text-align: left;" onClick="$(this).colorbox({iframe:true, innerWidth:\'90%\', innerHeight:\'90%\'});" href="' . $href . '" title="' . $R->resource_name . '" >';
            }
        }

        return $preview;
    }

    public function getResourceType($R) {
        $imagetypes = array("jpg", "jpeg", "gif", "png");
        $videolinks = array("youtube.com", "youtu.be");
        $pdftypes = array('pdf', 'odp', 'ods');
        $TYPE = 'html';

        if( $R->is_remote == 1 ) {
            $RNM = $R->link;
        } else {
            $RNM = $R->resource_name;
        }
        $extension = strtolower(pathinfo($RNM, PATHINFO_EXTENSION));

        if( in_array($extension, $imagetypes) ) {
            $TYPE = 'image';
        }
        if( in_array($extension, $pdftypes) ) {
            $TYPE = 'pdf';
        }

        foreach( $videolinks as $V ) {
            if( strpos($R->link, $V) )
                $TYPE = 'video';
        }

        return $TYPE;
    }

}
