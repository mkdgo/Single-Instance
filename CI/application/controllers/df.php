<?php
    if (!defined('BASEPATH'))   exit('No direct script access allowed');

class Df extends MY_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('resources_model');
        $this->load->library( 'nativesession' );
        $this->load->helper('url');
        $this->load->helper('download');

    }

    function index( $id = '0' ) {
        $resource_id = $id;

        $upload_config = $this->config->load('upload', TRUE);
        $upload_path = $this->config->item('upload_path');
        $upload_path = $this->config->item('upload_path', 'upload');

        if( $resource_id == '-1' ) {
            $errorfilenotfound = $this->config->item('errorfilenotfound', 'upload' );
            $file = $upload_path . $errorfilenotfound;
            $name = $errorfilenotfound;
        } else {
            $resource = $this->resources_model->get_resource_by_id( $resource_id );
            $file = $upload_path . $resource->resource_name;
            $file_ext = pathinfo($resource->resource_name, PATHINFO_EXTENSION);
            $name = $resource->name.'.'.$file_ext;
        }

        if( !file_exists( $file ) ) {
            $resource->resource_name = $default_image;
            show_404();
        }

        $data = file_get_contents($file);

        force_download($name, $data);
    }

    function subject_icons( $logo = '' ) {
        $upload_config = $this->config->load('upload', TRUE);
        $upload_path = $this->config->item('upload_path');
        $subjects_icon_path = $this->config->item('subjects_icon_path', 'upload');
        $default_image = $this->config->item('default_image', 'upload');

        if( $logo == '' ) {
            $file = $upload_path . $default_image;
            $name = $default_image;
        } else {
            $file = $subjects_icon_path . $logo;
            $name = $logo;
        }
        if( !file_exists( $file ) ) {
            $file = $upload_path . $default_image;
        }
        $data = file_get_contents($file);
        force_download($name, $data);
    }

}
