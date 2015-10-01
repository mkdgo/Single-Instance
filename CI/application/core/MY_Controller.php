<?php

class MY_Controller extends CI_Controller {

    public $_data = array(
        '_header' => array(),
        '_footer' => array(),
        '_title' => '',
        '_menu' => '',
        '_content' => '',
        '_description' => '',
        '_keywords' => '',
        '_message' => '',
        '_background' => '',
        '_data' => ''
    );
    public $_teachers_allowed = array(
        'a1',
        'b2',
        'c1', 'c2',
        'd1', 'd1a', 'd1b', 'd2_teacher', 'd3_teacher', 'd4_teacher', 'd5_teacher',
        'e1_teacher', 'e2', 'e3', 'e5_teacher',
        'f1_teacher', 'f2b_teacher', 'f2c_teacher', 'f3_teacher', 'f4_teacher', 'f5_teacher', 'f2_student',
        'g1_teacher', 'g1a_teacher',
        'g2',
        's1', 'search_admin',
        'interactive_lessons_ajax',
        'running_lesson_t',
        'online_students',
        'feedback',
        'logout',
        'work', 'w1'
    );
    public $_students_allowed = array(
        'a1',
        'b1',
        'c1', 'c2',
        'd1', 'd2_student', 'd3_student', 'd4_student', 'd5_student',
        'e1_student', 'e5_student',
        'f1_student', 'f2_student', 'f4_student', 'f4_teacher', 'f5_student',
        'g1_student', 
        's1', 'search_admin',
        'running_lesson',
        'feedback',
        'logout',
        'work', 'w1'
    );
    public $_notuser_allowed = array(
        'a1', 'login', 'search_admin'
    );
    public $_menu_selected;
    public $_user = array();
    public $tmp_data = array();
    public $_temp_id = '';
    protected $user_id = '';
    protected $user_full_name = '';
    protected $user_type = '';
    public $onelogin_allowed = false;
    public $defaultIDP = '';
    public $fallBackToDefaultIDP = false;

    function __construct() {
        parent::__construct();

        $this->load->model('settings_model');
        $this->defaultIDP = $this->settings_model->getDefaultIdentityDataProvider();
        $this->fallBackToDefaultIDP = $this->settings_model->getFallBackToDefaultIdentityDataProvider();
        $this->headTitle = $this->settings_model->getHeadTitle();
        
        $this->config->load('constants');
        $SCHOOL = $this->config->item('SCHOOL');

        if (isset($SCHOOL['custom'])) {
            if (in_array('onelogin', $SCHOOL['custom'])) {
                $this->onelogin_allowed = true;
            }
        }
        if( $this->session->userdata('user_type') == 'teacher' ) {
            $this->_data['_header']['tvl_creating_resources'] = $this->settings_model->getLessonLink('tvlesson_creating_resources');
            $this->_data['_header']['tvl_interactive_lessons'] = $this->settings_model->getLessonLink('tvlesson_interactive_lessons');
            $this->_data['_header']['tvl_setting_homework'] = $this->settings_model->getLessonLink('tvlesson_setting_homework');
            $this->_data['_header']['tvl_submitting_homework'] = $this->settings_model->getLessonLink('tvlesson_submitting_homework');
            $this->_data['_header']['tvl_marking_homework'] = $this->settings_model->getLessonLink('tvlesson_marking_homework');
        }
        if( $this->session->userdata('user_type') == 'student' ) {
            $this->_data['_header']['svl_creating_resources'] = $this->settings_model->getLessonLink('svlesson_creating_resources');
            $this->_data['_header']['svl_interactive_lessons'] = $this->settings_model->getLessonLink('svlesson_interactive_lessons');
            $this->_data['_header']['svl_setting_homework'] = $this->settings_model->getLessonLink('svlesson_setting_homework');
            $this->_data['_header']['svl_submitting_homework'] = $this->settings_model->getLessonLink('svlesson_submitting_homework');
            $this->_data['_header']['svl_marking_homework'] = $this->settings_model->getLessonLink('svlesson_marking_homework');
        }

/*        $this->_data['_header']['enable_feedback'] = $this->config->item('enable_feedback') && ($this->session->userdata('user_type') == 'teacher');*/
        $this->_data['_header']['enable_feedback'] = $this->config->item('enable_feedback');
        $this->_data['_header']['tagger_id'] = $this->session->userdata('id');
        $this->_data['_header']['tagger_type'] = strtolower($this->session->userdata('user_type'));
        $this->_data['_header']['tagger_name'] = $this->session->userdata('first_name') . ' ' . $this->session->userdata('last_name');
        $this->_data['_header']['tagger_class'] = strtolower($this->router->fetch_class());
        
        $this->load->database();
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
        $this->_data['_message'] = $this->session->flashdata('_message');
//echo '<pre>';var_dump( $this->session->userdata('first_name') );die;
//echo '<pre>';var_dump( $this->session->userdata );die;
        $this->user_id = $this->session->userdata('id');
        $this->user_email = $this->session->userdata('email');
        $this->user_full_name = $this->session->userdata('first_name')." ".$this->session->userdata('last_name');
        $this->user_type = $this->session->userdata('user_type');

        if (!$this->session->userdata('admin_logged')) {
            if( !$this->user_id  && !in_array( $this->router->fetch_class(), $this->_notuser_allowed ) ) {
                redirect('/a1', 'refresh');
            } elseif( $this->user_type == 'student' && !in_array( $this->router->fetch_class(), $this->_students_allowed) ) {
                redirect('/a1', 'refresh');
            } elseif( $this->user_type == 'teacher' && !in_array( $this->router->fetch_class(), $this->_teachers_allowed) ) {
                redirect('/a1', 'refresh');
            }
        }


        if(( $this->router->uri->segments[1] == "f4_student" && $this->user_type == "student" && $this->router->uri->segments[2] == "index" ) || ( $this->router->uri->segments[1] == "f4_teacher" && $this->user_type == "student" && $this->router->uri->segments[2] == "loaddata" )) {
            
        } else {
            if ($this->user_type == "student" and ( strpos(get_class($this), "teacher") !== false or in_array(get_class($this), array('B2', 'G2'))))
                show_404();
        }

        if( $this->input->post('temp_id') ) {
            $this->_temp_id = $this->input->post('temp_id');
        } else {
            $this->_temp_id = rand(0, 9999999);
        }
    }

    public function _paste_admin($main_layout = false, $template = false) {
        if (!$template) {
            $template = strtolower(get_class($this));
        }
        $data = array();
        $data['_data'] = '';
        $data['_header'] = '';
        $data['_footer'] = '';
        $data['_menu'] = $this->_data['_menu'];
        $data['_sidebar'] = $this->parser->parse('admin/_sidebar', array('template' => $template), true);
        $data['_content'] = $this->parser->parse($template, $this->_data, true);
        $data['_keywords'] = $this->_data['_keywords'];

        if ($this->_data['_title'] != '') {
            $data['_title'] = 'Ediface - ' . $this->_data['_title'];
        } else {
            $data['_title'] = 'Ediface';
        }
        if ($this->_data['_description'] != '') {
            $data['_description'] = $this->_data['_description'];
        } else {
            $data['_description'] = '';
        }
        $data['_background'] = $this->_data['_background'];

        $data['user_id'] = $this->user_id;
        $data['user_full_name'] = $this->user_full_name;
        $data['user_type'] = $this->user_type;

        $this->parser->parse($main_layout == FALSE ? 'admin/_default' : $main_layout, $data);
    }

    function _paste_public($template = '') {
        if ($template == '') {
            $template = strtolower(get_class($this));
        }

        $this->check_user($template);

        $data['_header'] = '';
        $data['_footer'] = '';
        $data['_header'] = $this->parser->parse('widgets/_header', $this->_data['_header'], true);
        $data['_footer'] = $this->parser->parse('widgets/_footer', $this->_data['_footer'], true);
        $data['_content'] = $this->parser->parse($template, $this->_data, true);
        //  $data['_menu_selected'] = $this->_data['_menu'];
        $data['_keywords'] = $this->_data['_keywords'];

        if ($this->_data['_title'] != '') {
            $data['_title'] = 'Ediface - ' . $this->_data['_title'];
        } else {
            $data['_title'] = 'Ediface';
        }
        if ($this->_data['_description'] != '') {
            $data['_description'] = $this->_data['_description'];
        } else {
            $data['_description'] = '';
        }
        $data['_background'] = $this->_data['_background'];

        $data['user_id'] = $this->user_id;
        $data['user_email'] = $this->user_email;
        $data['user_full_name'] = $this->user_full_name;
        $data['user_type'] = $this->user_type;


        $data['onelogin_allowed'] = '';
        if ($this->onelogin_allowed)
            $data['onelogin_allowed'] = 'onelogin_allowed';

        $this->parser->parse('_default', $data);
    }

    function check_user($template) {
        if (!$this->session->userdata('id') && substr($template, 0, 2) != 'a1') {
            redirect('a1', 'refresh');
        }
    }

    public function _logout($redirect_to = '/') {
        $this->session->unset_userdata('logged_in');
        redirect($redirect_to, 'refresh');
    }

    public function resource($id) {
//        $imagetypes = array("jpg", "jpeg", "gif", "png");
        $imagetypes = array("jpg", "jpeg", "gif", "png", "pdf");
        $videolinks = array("youtube.com");
//$this->load->helper('download');
        $upload_config = $this->config->load('upload', TRUE);
        $upload_path = $this->config->item('upload_path', 'upload');
        $default_image = $this->config->item('default_image', 'upload');
        $mime_type = $this->config->item('mimes');
        $this->load->model('resources_model');
        $resource = $this->resources_model->get_resource_by_id($id);
        if (!isset($resource)) {
            show_404();
        }
        if (!file_exists($upload_path . $resource->resource_name)) {
            $resource->resource_name = $default_image;
        }

        $extension = pathinfo($resource->resource_name, PATHINFO_EXTENSION);
//echo $upload_path . $resource->resource_name;die;
//*
        if( !in_array($extension, $imagetypes) ) {
            $href = $upload_path . $resource->resource_name;
//            $href = 'c1/resourceDownload/' . $resource->id;
            echo $echo1 = '<div id="editor_image" style=" font-family: Open Sans; height: 200px; width: 600px; margin: auto auto;padding-top: 20%; font-size: 20px;text-align: center;">
                <p>Please click "Download" to view the file</p>
                <a id="download_resource_link" style="font-family: Open Sans; text-align: center; margin:0px 70px; line-height:2; text-decoration: none; color: #fff; width:150px; height:36px; background: #ff0000;display: inline-block;" class="downloader" href="/' . $href . '">Download</a>
                </div>';
/*
            $this->load->helper('download');
            $data = file_get_contents($upload_path . $resource->resource_name); // Read the file's contents
            $name = $resource->name;
            force_download($name, $data);
//*/
//echo var_dump( $data );die('hi');
        } else {
            $this->output
                    ->set_content_type($mime_type[$extension]) // You could also use ".jpeg" which will have the full stop removed before looking in config/mimes.php
                    ->set_output(file_get_contents($upload_path . $resource->resource_name));
        }
    }
    
    public function resourceDownload($id) {
        $upload_config = $this->config->load('upload', TRUE);
        $upload_path = $this->config->item('upload_path', 'upload');
        $default_image = $this->config->item('default_image', 'upload');
        $this->load->model('resources_model');
        $resource = $this->resources_model->get_resource_by_id($id);
        if (!isset($resource)) {
            show_404();
        }
        if (!file_exists($upload_path . $resource->resource_name)) {
            $resource->resource_name = $default_image;
        }

        $this->load->helper('download');
        $data = file_get_contents($upload_path . $resource->resource_name); // Read the file's contents
        $name = $resource->name;
//echo var_dump( $data );die('hi');
        force_download($name, $data);
    }

    public function resouceContentPreview($R, $P) {
        if (!isset($R->id) && isset($R->res_id)) {
            $R->id = $R->res_id;
        }
        $TP = $this->getResourceType($R);
        $preview = $TP;
        if ($R->is_remote == 1) {
            if ($TP == 'video') {
                $vlink = str_replace('https:', '', $R->link);
                $vlink = str_replace('http:', '', $vlink);
                $vlink = str_replace('watch?v=', '', $vlink);
                $vlink = str_replace('embed/', '', $vlink);
                $vlink = str_replace('youtube.com/', 'youtube.com/embed/', $vlink);
                $vlink = str_replace('youtu.be/', 'www.youtube.com/embed/', $vlink);
                $preview = '<a data-id="'.$P.'" class="clr_iframe_'.$P.' preview" href="' . $vlink . '" title="' . $R->resource_name . '">' . $R->name . '</a>';
            } else {
                $preview = '<a data-id="'.$P.'" class="clr_iframe_'.$P.' preview" href="' . $R->link . '" title="' . $R->link . '" >' . $R->name . '</a>';
            }
        } else {
            if ($TP == 'image') {
                $preview = '<a data-id="'.$P.'" class="group_'.$P.' preview colorbox cboxElement" href="/c1/resource/'.$R->id.'" title="'.$R->name.'">' . $R->name . '</a>';
            } else {
                $preview = '<a data-id="'.$P.'" class="clr_iframe_'.$P.' preview" href="/c1/resource/'.$R->id.'" title="'.$R->name.'">' . $R->name . '</a>';
            }
        }

        return $preview;
    }

    public function resoucePreview($R, $loc) {
        if (!isset($R->id) && isset($R->res_id)) {
            $R->id = $R->res_id;
        }
        $TP = $this->getResourceType($R);
        $preview = $TP;
        if ($R->is_remote == 1) {
            if ($TP == 'video') {
                $preview = $this->getRemoteVideoDisplayer($loc, $R);
            } else {
                $preview = $this->getRemoteFrameDisplayer($loc, $R);
            }
        } else {
            if ($TP == 'image') {
                $preview = $this->getLocalImageDisplayer($loc, $R);
            } elseif( $TP == 'pdf' ) {
                $preview = $this->getLocalFramePDFDisplayer($loc, $R);
            } else {
                $preview = $this->getLocalFrameDisplayer($loc, $R);
            }
        }

        return $preview;
    }

    public function resoucePreviewInline($R, $loc) {
        if (!isset($R->id) && isset($R->res_id)) {
            $R->id = $R->res_id;
        }

        $TP = $this->getResourceType($R);
        $preview = $TP;
        if ($R->is_remote == 1) {
            if ($TP == 'video') {
                $preview = $this->getRemoteVideoDisplayer($loc, $R);
            } else {
                $preview = $this->getRemoteFrameDisplayer($loc, $R);
            }
        } else {
            if ($TP == 'image') {
                $preview = $this->getLocalImageDisplayer($loc, $R);
            } elseif( $TP == 'pdf' ) {
                $preview = $this->getLocalFramePDFDisplayer($loc, $R);
            } else {
                $preview = $this->getLocalFrameDisplayer($loc, $R);
            }
        }

        return $preview;
    }

    public function resoucePreviewFullscreen($R, $loc) {
        if (!isset($R->id) && isset($R->res_id)) {
            $R->id = $R->res_id;
        }
        $TP = $this->getResourceType($R);
        $preview = $TP;
        if ($R->is_remote == 1) {
            if ($TP == 'video') {
                $upload_path = ltrim($this->config->item('upload_path', 'upload'), '.');
                $vlink = str_replace('https:', '', $R->link);
                $vlink = str_replace('http:', '', $vlink);
                $vlink = str_replace('watch?v=', '', $vlink);
                $vlink = str_replace('embed/', '', $vlink);
                $vlink = str_replace('youtube.com/', 'youtube.com/embed/', $vlink);
                $vlink = str_replace('youtu.be/', 'www.youtube.com/embed/', $vlink);
                $preview = '<a style="text-decoration:none; color: #fff; padding: 5px; background: #099A4D; display: inline-block;" onClick="$(this).colorbox({iframe:true, innerWidth:\'90%\', innerHeight:\'90%\', webkitallowfullscreen:true});" href="' . $vlink . '" class="lesson_link colorbox" title="' . $R->link . '">View Fullscreen</a>';
            } else {
                $upload_path = ltrim($this->config->item('upload_path', 'upload'), '.');
                $preview = '<a style="text-decoration:none; color: #fff; padding: 5px; background: #099A4D; display: inline-block;" onClick="$(this).colorbox({iframe:true, innerWidth:\'90%\', innerHeight:\'90%\', webkitallowfullscreen:true}); return false;" href="' . $R->link . '" class="lesson_link colorbox" title="' . $R->link . '" style="display:inline;width:100%;overflow:hidden;font-family:open sans">View Fullscreen</a>';
            }
        } else {
            if ($TP == 'image') {
                $upload_path = ltrim($this->config->item('upload_path', 'upload'), '.');
                $preview = '<a style="text-decoration:none; color: #fff; padding: 5px; background: #099A4D; display: inline-block;" href="' . $loc . $R->id . '" title="' . $R->resource_name . '" class="lesson_link colorbox" style="display:inline;width:90%; overflow:hidden;font-family:open sans">View Fullscreen</a>';
            } elseif( $TP == 'pdf' ) {
                $upload_config = $this->config->load('upload', TRUE);
                $upload_path = $this->config->item('upload_path', 'upload');
                $upload_path = ltrim($this->config->item('upload_path', 'upload'), '.');
                $path = "/uploads/resources/temp/";
                $preview = '<a style="text-decoration:none; color: #fff; padding: 5px; background: #099A4D; display: inline-block;" onClick="$(this).colorbox({iframe:true, innerWidth:\'90%\', innerHeight:\'90%\', webkitallowfullscreen:true});" href="/ViewerJS/index.html#' .  $path . $R->resource_name . '" title="' . $R->resource_name . '" class="lesson_link colorbox" style="display:inline;width:90%;overflow:hidden;font-family:open sans">View Fullscreen</a>';
            } else {
                $upload_config = $this->config->load('upload', TRUE);
                $upload_path = $this->config->item('upload_path', 'upload');
                $upload_path = ltrim($this->config->item('upload_path', 'upload'), '.');
                $href = $loc . $R->id;
                $preview = '<a style="text-decoration:none; color: #fff; padding: 5px; background: #099A4D; display: inline-block;" onClick="$(this).colorbox({iframe:true, innerWidth:\'90%\', innerHeight:\'90%\'});" href="' . $href . '" title="' . $R->resource_name . '" class="lesson_link colorbox" style="display:inline;width:90%;overflow:hidden;font-family:open sans">View Fullscreen</a>';
            }
        }

        return $preview;
    }

    public function getResourceType($R) {
        $imagetypes = array("jpg", "jpeg", "gif", "png");
        $videolinks = array("youtube.com", "youtu.be");
        $pdftypes = array('pdf', 'odp', 'ods');
        $TYPE = 'html';

        if ($R->is_remote == 1) {
            $RNM = $R->link;
        } else {
            $RNM = $R->resource_name;
        }
        $extension = strtolower(pathinfo($RNM, PATHINFO_EXTENSION));

        if (in_array($extension, $imagetypes)) {
            $TYPE = 'image';
        }
        if (in_array($extension, $pdftypes)) {
            $TYPE = 'pdf';
        }

        foreach ($videolinks as $V) {
            if (strpos($R->link, $V))
                $TYPE = 'video';
        }

        return $TYPE;
    }

    public function getRemoteVideoDisplayer($loc, $R) {
        $upload_path = ltrim($this->config->item('upload_path', 'upload'), '.');

        $vlink = str_replace('https:', '', $R->link);
        $vlink = str_replace('http:', '', $vlink);
        $vlink = str_replace('watch?v=', '', $vlink);
        $vlink = str_replace('embed/', '', $vlink);
        $vlink = str_replace('youtube.com/', 'youtube.com/embed/', $vlink);
        $vlink = str_replace('youtu.be/', 'www.youtube.com/embed/', $vlink);

        if ($loc == '/d5_teacher/resource/' || true) {
            $return = '<a onClick="$(this).colorbox({iframe:true, innerWidth:\'80%\', innerHeight:\'80%\'});" href="' . $vlink . '" class="btn b1 colorbox" title="' . $R->resource_name . '"><span>VIEW</span><i class="icon i1"></i></a>';
        }

        if ($loc == '/c2/resource/') {
            $return = '<iframe width="80%" height="80%" src="' . $vlink . '" frameborder="0" allowfullscreen></iframe>';
        }

        if ($loc == '/e5_teacher/resource/') {
            $return = '<iframe wmode="transparent" width="80%" height="80%" src="' . $vlink . '" frameborder="0" allowfullscreen></iframe>';
        }

        if ($loc == '/e5_student/resource/') {
            $return = '<iframe wmode="transparent" width="80%" height="80%" src="' . $vlink . '" frameborder="0" allowfullscreen></iframe>';
        }

        if ($loc == '/f2b_teacher/') {
            $return = '<a onClick="$(this).colorbox({iframe:true, innerWidth:\'80%\', innerHeight:\'80%\'});" href="' . $vlink . '" class="view_res_butt colorbox" title="' . $R->resource_name . '">View</a>';
        }

        if ($loc == '/f2_student/') {
            $return = '<a onClick="$(this).colorbox({iframe:true, innerWidth:\'80%\', innerHeight:\'80%\'});" href="' . $vlink . '" data-role="button" data-inline="true" data-mini="true" class="colorbox" title="' . $R->resource_name . '">View</a>';
        }

        if ($loc == '/c1/resource/') {
            $name = ( strlen( $R->name ) > 30 ) ? substr( $R->name,0,30 ).'...' : $R->name ;
            $return = '<a onClick="$(this).colorbox({iframe:true, innerWidth:\'80%\', innerHeight:\'80%\'});" href="' . $vlink . '" class="lesson_link colorbox" title="' . $R->link . '">' . $name . '</a>';
        }
        if ($loc == '/c2/resource/') {
            //$return = '<a onClick="$(this).colorbox({iframe:true, innerWidth:\'80%\', innerHeight:\'80%\'});" href="' . $vlink . '" class="lesson_link colorbox" title="' . $R->link . '">' . $R->name . '</a>';
            $return = '<iframe width="100%" height="100%" src="'.$vlink.'" frameborder="0" allowfullscreen></iframe>';
        }

        if (substr($loc, 0, 9) == '/c1/save/') {
            $return = '<a href="' . $loc . '" class="lesson_link" title="' . $R->link . '">' . $R->name . '</a>';
        }

        if (substr($loc, 0, 10) == '/e3-thumb/') {
            $icon = '<img src="' . $upload_path . 'default_video.jpg"/>';
            $return = '<a onClick="$(this).colorbox({iframe:true, innerWidth:\'80%\', innerHeight:\'80%\'});" href="' . $vlink . '" title="' . $R->resource_name . '">' . $icon . '</a>';
        }

        return $return;
    }

    public function getRemoteFrameDisplayer($loc, $R) {
        $upload_path = ltrim($this->config->item('upload_path', 'upload'), '.');

        if ($loc == '/d5_teacher/resource/' || true) {
            $return = '<a onClick="$(this).colorbox({iframe:true, innerWidth:\'80%\', innerHeight:\'80%\'});" href="' . $R->link . '" class="btn b1 colorbox" title="' . $R->resource_name . '"><span>VIEW</span><i class="icon i1"></i></a>';
        }

        if ($loc == '/c2/resource/') {
            
            $return = '<iframe width="760" height="600" src="' . $R->link . '" frameborder="0" allowfullscreen></iframe>';
        }

        if ($loc == '/e5_teacher/resource/') {
            $return = '<iframe allowtransparency="true" wmode="transparent" width="80%" height="80%" src="' . $R->link . '" frameborder="0" allowfullscreen></iframe>';
        }

        if ($loc == '/e5_student/resource/') {
            $return = '<iframe allowtransparency="true" wmode="transparent" width="80%" height="80%" src="' . $R->link . '" frameborder="0" allowfullscreen></iframe>';
        }

        if ($loc == '/f2b_teacher/') {
            $return = '<a onClick="$(this).colorbox({iframe:true, innerWidth:\'80%\', innerHeight:\'80%\'});" href="' . $R->link . '" class="view_res_butt colorbox" title="' . $R->resource_name . '">View</a>';
        }

        if ($loc == '/f2_student/') {
            $return = '<a onClick="$(this).colorbox({iframe:true, innerWidth:\'80%\', innerHeight:\'80%\'});" href="' . $R->link . '" class="colorbox" data-role="button" data-inline="true" data-mini="true" title="' . $R->resource_name . '">View</a>';
        }

        if ($loc == '/c1/resource/') {
            $name = ( strlen( $R->name ) > 30 ) ? substr( $R->name,0,30 ).'...' : $R->name ;
            $return = '<a onClick="$(this).colorbox({iframe:true, innerWidth:\'80%\', innerHeight:\'80%\'});" href="' . $R->link . '" title="' . $R->link . '" class="lesson_link colorbox" style="display:inline;width:100%;overflow:hidden;font-family:open sans">' . $name . '</a>';
        }

        if (substr($loc, 0, 9) == '/c1/save/') {
            $return = '<a href="' . $loc . '" class="lesson_link" title="' . $R->link . '">' . $R->name . '</a>';
        }

        if (substr($loc, 0, 10) == '/e3-thumb/') {
            $icon = '<img src="' . $upload_path . 'default_text.jpg"/>';
            $return = '<a onClick="$(this).colorbox({iframe:true, innerWidth:\'80%\', innerHeight:\'80%\'});" href="' . $R->link . '" title="' . $R->resource_name . '">' . $icon . '</a>';
        }

        return $return;
    }

    public function getLocalFrameDisplayer($loc, $R) {
        $upload_config = $this->config->load('upload', TRUE);
        $upload_path = $this->config->item('upload_path', 'upload');

        $upload_path = ltrim($this->config->item('upload_path', 'upload'), '.');

        if ($loc == '/d5_teacher/resource/' || true) {
            $return = '<a onClick="$(this).colorbox({iframe:true, innerWidth:\'80%\', innerHeight:\'80%\'});" href="' . $loc . $R->id . '" class="btn b1 colorbox" title="' . $R->name . '"><span>VIEW</span><i class="icon i1"></i></a>';
        }

        if ($loc == '/c1/resource/') {
//            $href = '/c1/resourceDownload/' . $R->id;
//            $return = '<a onClick="mdl(\''.$href.'\')" title="' .$R->name . '" class="mdl">' . $R->name . '</a>';
            $name = ( strlen( $R->name ) > 30 ) ? substr( $R->name,0,30 ).'...' : $R->name ;
            $href = $loc . $R->id;
            $return = '<a onClick="$(this).colorbox({iframe:true, innerWidth:\'80%\', innerHeight:\'80%\'});" href="' . $href . '" title="' . $R->resource_name . '" class="lesson_link colorbox" style="display:inline;width:90%;overflow:hidden;font-family:open sans">' . $name . '</a>';
        }

        if (substr($loc, 0, 9) == '/c1/save/') {
            $return = '<a href="' . $loc . '" class="lesson_link" title="' . $R->link . '">' . $R->name . '</a>';
        }

        if ($loc == '/c2/resource/') {

            $return = '<div id="editor_image" style=" font-family: Open Sans; height: 200px; width: 600px; margin: auto auto;padding-top: 20%; font-size: 20px;text-align: center;">
<p>Please click "Download" to view the file</p>
<a id="download_resource_link" class="downloader" href="'.base_url().'c2/download/'.$R->resource_name.'" style="font-family: Open Sans; text-align: center; margin:0px 70px; line-height:2; text-decoration: none; color: #fff; width:150px; height:36px; background: #ff0000;display: inline-block;">Download</a>
</div>';

            //$return = '<iframe width="80%" height="80%" src="' . $loc . $R->id . '" frameborder="0" allowfullscreen></iframe>';
        }
        if ($loc == '/e5_teacher/resource/') {
            $return = '<iframe allowtransparency="true" wmode="transparent" width="80%" height="80%" src="' . $loc . $R->id . '" frameborder="0" allowfullscreen></iframe>';
        }

        if ($loc == '/e5_student/resource/') {

            $return = '<iframe allowtransparency="true" wmode="transparent" width="80%" height="80%" src="' . $loc . $R->id . '" frameborder="0" allowfullscreen></iframe>';
        }

        if ($loc == '/f2b_teacher/resource/') {
            $return = '<a onClick="$(this).colorbox({iframe:true, innerWidth:\'80%\', innerHeight:\'80%\'});" href="' . $loc . $R->id . '" class="view_res_butt colorbox" title="' . $R->name . '">View</a>';
        }

        if ($loc == '/f2_student/resource/') {
            $return = '<a onClick="$(this).colorbox({iframe:true, innerWidth:\'80%\', innerHeight:\'80%\'});" href="' . $loc . $R->id . '" class="btn b1 colorbox" data-role="button" data-inline="true" data-mini="true" title="' . $R->name . '"><span>View</span><i class="icon i1"></i></a>';
        }

        if (substr($loc, 0, 10) == '/e3-thumb/') {
            $icon = '<img src="' . $upload_path . 'default_text.jpg"/>';
            $return = '<a onClick="$(this).colorbox({iframe:true, innerWidth:\'80%\', innerHeight:\'80%\'});" href="/e3/resource/' . $R->id . '" title="' . $R->name . '">' . $icon . '</a>';
        }

        return $return;
    }

    public function getLocalFramePDFDisplayer($loc, $R) {
        $upload_config = $this->config->load('upload', TRUE);
        $upload_path = $this->config->item('upload_path', 'upload');

        $upload_path = ltrim($this->config->item('upload_path', 'upload'), '.');
        $path = "/uploads/resources/temp/";
//        $href = $loc . $R->id;

        if ($loc == '/d5_teacher/resource/' || true) {
            $return = '<a onClick="$(this).colorbox({iframe:true, innerWidth:\'80%\', innerHeight:\'80%\',  webkitallowfullscreen:true});" href="/ViewerJS/index.html#' . $path . $R->resource_name . '" class="btn b1 colorbox" title="' . $R->name . '"><span>VIEW</span><i class="icon i1"></i></a>';
        }

        if ($loc == '/c1/resource/') {
            $name = ( strlen( $R->name ) > 30 ) ? substr( $R->name,0,30 ).'...' : $R->name ;
            $return = '<a onClick="$(this).colorbox({iframe:true, innerWidth:\'80%\', innerHeight:\'80%\', webkitallowfullscreen:true});" href="/ViewerJS/index.html#' .  $path . $R->resource_name . '" title="' . $R->resource_name . '" class="lesson_link colorbox" style="display:inline;width:90%;overflow:hidden;font-family:open sans">' . $name . '</a>';
        }

        if (substr($loc, 0, 9) == '/c1/save/') {
            $return = '<a href="' . $loc . '" class="lesson_link" title="' . $R->link . '">' . $R->name . '</a>';
        }

        if ($loc == '/c2/resource/')
            $return = '<iframe width="80%" height="80%" src="/ViewerJS/index.html#' . $path . $R->resource_name . '" frameborder="0" allowfullscreen webkitallowfullscreen></iframe>';

        if ($loc == '/e5_teacher/resource/') {
            $return = '<iframe width="960" height="600" src="/ViewerJS/index.html#' . $path . $R->resource_name . '" fullscreen="true" frameborder="0" allowfullscreen webkitallowfullscreen></iframe>';
        }

        if ($loc == '/e5_student/resource/') {
            $return = '<iframe allowtransparency="true" allowfullscreen webkitallowfullscreen wmode="transparent" width="80%" height="80%" src="/ViewerJS/index.html#' . $path . $R->resource_name . '" frameborder="0" allowfullscreen ,  webkitallowfullscreen></iframe>';
        }

        if ($loc == '/f2b_teacher/resource/') {
            $return = '<a onClick="$(this).colorbox({iframe:true, innerWidth:\'80%\', innerHeight:\'80%\', webkitallowfullscreen:true}); " href="/ViewerJS/index.html#' . $path . $R->resource_name . '" class="view_res_butt colorbox" title="' . $R->name . '">View</a>';
        }

        if ($loc == '/f2_student/resource/') {
            $return = '<a onClick="$(this).colorbox({iframe:true, innerWidth:\'80%\', innerHeight:\'80%\'});" href="' . $path . $R->resource_name . '" class="btn b1 colorbox" data-role="button" data-inline="true" data-mini="true" title="' . $R->name . '"><span>VIEW</span><i class="icon i1"></i></a>';
        }

        if (substr($loc, 0, 10) == '/e3-thumb/') {
            $icon = '<img src="' . $upload_path . 'default_text.jpg"/>';
            $return = '<a onClick="$(this).colorbox({iframe:true, innerWidth:\'80%\', innerHeight:\'80%\'});" href="/e3/resource/' . $R->id . '" title="' . $R->name . '">' . $icon . '</a>';
        }

        return $return;
    }

    public function getLocalImageDisplayer($loc, $R) {
        $upload_path = ltrim($this->config->item('upload_path', 'upload'), '.');

        if ($loc == '/d5_teacher/resource/' || true) {
            $return = '<a href="' . $loc . $R->id . '" class="btn b1 colorbox " title="' . $R->resource_name . '"><span>VIEW</span><i class="icon i1"></i></a>';
        }

        if ($loc == '/c2/resource/') {
            //die(print_r($R));
            // $return = '<a href="' . $loc . $R->id . '" title="' . $R->resource_name . '" class="lesson_link colorbox cboxElement" style="display:inline;width:90%;overflow:hidden;font-family:open sans">' . $R->name . '</a>';
            $return = '<img style="width:800px;" src="'.base_url().'uploads/resources/temp/'.$R->resource_name . '" >';
        }
        if ($loc == '/e5_teacher/resource/') {
            $return = '<img class="pic_e5" src="' . $loc . $R->id . '" alt="' . $R->resource_name . '" title="' . $R->resource_name . '" />';
        }

        if ($loc == '/e5_student/resource/') {
            $return = '<img class="pic_e5" src="' . $loc . $R->id . '" alt="' . $R->resource_name . '" title="' . $R->resource_name . '" />';
        }

        if ($loc == '/f2b_teacher/resource/') {
            $return = '<a href="' . $loc . $R->id . '" class="view_res_butt colorbox" title="' . $R->resource_name . '">View</a>';
        }

        if ($loc == '/f2_student/') {
            $return = '<a href="' . $loc . $R->id . '" class="colorbox" data-role="button" data-inline="true" data-mini="true" title="' . $R->resource_name . '">View</a>';
        }

        if ($loc == '/c1/resource/') {
            $name = ( strlen( $R->name ) > 30 ) ? substr( $R->name,0,30 ).'...' : $R->name ;
            $return = '<a onClick="$(this).colorbox({iframe:true, innerWidth:\'80%\', innerHeight:\'80%\'});" href="' . $loc . $R->id  . '" title="' . $R->resource_name . '">' . $name . '</a>';
        }

        if (substr($loc, 0, 9) == '/c1/save/') {
            $return = '<a href="' . $loc . '" class="lesson_link" title="' . $R->link . '">' . $R->name . '</a>';
        }

        if (substr($loc, 0, 10) == '/e3-thumb/') {
            $return = '<img src="' . str_replace('/e3-thumb/', '', $loc) . '" class="img_200x150" />';
        }
//var_dump( $return );die;
        return $return;
    }

    protected function unserialize_assessment($int_assessment_id, $mode = "view", $type = 'q_resource') {
        $this->load->model('interactive_assessment_model');
        $this->load->model('resources_model');

        $upload_config = $this->config->load('upload', TRUE);
        $upload_path = ltrim($this->config->item('upload_path', 'upload'), '.');
        $default_image = $this->config->item('default_image', 'upload');

        $temp_data = unserialize($this->interactive_assessment_model->get_ia_temp_data($int_assessment_id));
        //if (is_array($temp_data))
        //	log_message('error', $int_assessment_id." - ".self::str($temp_data));
        //else
        //	log_message('error', $int_assessment_id." - ".$temp_data);

        if (!empty($type) && $type == 'q_resource' && !empty($temp_data)) {
            foreach ($temp_data as $q_key => $question) {
                $this->tmp_data['questions'][$q_key]['question_num'] = $q_key;
                $this->tmp_data['questions'][$q_key]['question_text'] = $question['question_text'];
                $this->tmp_data['questions'][$q_key]['question_resource_id'] = $question['question_resource_id'];


                if (!empty($question['question_resource_id'])) {
                    $resource = $this->resources_model->get_resource_by_id($question['question_resource_id']);
                    $resized_img = $this->pictures_lib->resize($resource->resource_name, 150, 200, 'inside');

                    $this->tmp_data['questions'][$q_key]['question_resource_img'] = $resized_img;
                    $this->tmp_data['questions'][$q_key]['question_resource_img_preview'] = $this->resoucePreview($resource, '/e3-thumb/' . $resized_img);
                } else {
                    $img_default = $upload_path . $default_image; //$this->constants->default_image;
                    $this->tmp_data['questions'][$q_key]['question_resource_img'] = $img_default;
                    $this->tmp_data['questions'][$q_key]['question_resource_img_preview'] = '<img src="' . $upload_path . $default_image . '"/>';
                }

                $this->tmp_data['questions'][$q_key]['answers'] = array();
                if (isset($question['answers'])) {
                    foreach ($question['answers'] as $a_key => $answer) {
                        $this->tmp_data['questions'][$q_key]['answers'][$a_key]['answer_num'] = $a_key;
                        $this->tmp_data['questions'][$q_key]['answers'][$a_key]['answer_text'] = $answer['answer_text'];

                        if ($answer['answer_true']) {
                            $this->tmp_data['questions'][$q_key]['answers'][$a_key]['answer_true_0'] = '';
                            $this->tmp_data['questions'][$q_key]['answers'][$a_key]['answer_true_1'] = 'selected="selected"';
                        } else {
                            $this->tmp_data['questions'][$q_key]['answers'][$a_key]['answer_true_0'] = 'selected="selected"';
                            $this->tmp_data['questions'][$q_key]['answers'][$a_key]['answer_true_1'] = '';
                        }
                    }
                }
            }
        } else {
            $questions = $this->interactive_assessment_model->get_ia_questions($int_assessment_id);
            //log_message('error', $this->db->last_query());
            $question_num = 0;
            //log_message('error', $int_assessment_id." - ".self::str($questions));

            $this->tmp_data['questions'] = array();
            $this->tmp_data['no_questions'] = 0;

            if (count($questions)) {
                foreach ($questions as $question) {
                    $this->tmp_data['questions'][$question_num]['question_num'] = $question_num;
                    $this->tmp_data['questions'][$question_num]['question_text'] = $question->question_text;
                    $this->tmp_data['questions'][$question_num]['question_resource_id'] = $question->resource_id;

                    if (!empty($question->resource_id)) {
                        //log_message('error', $question->resource_id);
                        $resource = $this->resources_model->get_resource_by_id($question->resource_id);

                        if (!is_null($resource)) {
                            $resized_img = $this->pictures_lib->resize($resource->resource_name, 150, 200, 'inside');
                            $this->tmp_data['questions'][$question_num]['question_resource_img'] = $resized_img;
                            $this->tmp_data['questions'][$question_num]['res_style'] = "";

                            $this->tmp_data['questions'][$question_num]['question_resource_img_preview'] = $this->resoucePreview($resource, '/e3-thumb/' . $resized_img);
                            //$this->tmp_data['resource_img_not_found'] = 0;
                        } else {
                            $this->tmp_data['questions'][$question_num]['question_resource_img'] = "/uploads/resources/temp/default.jpg";
                            $this->tmp_data['questions'][$question_num]['res_style'] = "style='border: 2px solid red;'";

                            $this->tmp_data['questions'][$question_num]['question_resource_img_preview'] = '<img style="border: 2px solid red;" src="' . $upload_path . $default_image . '"/>';
                            //$this->tmp_data['resource_img_not_found'] = 1;
                        }
                    } else {
                        $img_default = $upload_path . $default_image;
                        $this->tmp_data['questions'][$question_num]['question_resource_img'] = $img_default;
                        $this->tmp_data['questions'][$question_num]['question_resource_img_preview'] = '<img style="border: 2px solid red;" src="' . $upload_path . $default_image . '"/>';
                    }

                    //log_message('error', $this->tmp_data['questions'][$question_num]['question_resource_img']);

                    $answers = $this->interactive_assessment_model->get_ia_answers($question->id);
                    $answer_num = 0;
                    $this->tmp_data['questions'][$question_num]['answers'] = array();

                    foreach ($answers as $answer) {
                        $this->tmp_data['questions'][$question_num]['answers'][$answer_num]['answer_num'] = $answer_num;
                        $this->tmp_data['questions'][$question_num]['answers'][$answer_num]['answer_text'] = $answer->answer_text;
                        $this->tmp_data['questions'][$question_num]['answers'][$answer_num]['answer_is_checked'] = '';

                        //log_message('error', $answer->answer_true);
                        if ($answer->answer_true) //{
                            $this->tmp_data['questions'][$question_num]['answers'][$answer_num]['answer_is_checked'] = 'checked';
                        //$this->tmp_data['questions'][$question_num]['answers'][$answer_num]['answer_true_0'] = '';
                        //$this->tmp_data['questions'][$question_num]['answers'][$answer_num]['answer_true_1'] = 'selected="selected"';
                        //} else {
                        //	$this->tmp_data['questions'][$question_num]['answers'][$answer_num]['answer_true_0'] = 'selected="selected"';
                        //	$this->tmp_data['questions'][$question_num]['answers'][$answer_num]['answer_true_1'] = '';
                        //}

                        $answer_num++;
                    }

                    $question_num++;
                }
            } else {
                $this->tmp_data['questions'][0]['question_num'] = 0;
                $this->tmp_data['questions'][0]['question_text'] = '';
                $this->tmp_data['questions'][0]['question_resource_img'] = '';
                $this->tmp_data['questions'][0]['question_resource_img_preview'] = '';
                $this->tmp_data['questions'][0]['question_resource_id'] = '';
                $this->tmp_data['questions'][0]['answers'] = array();
                $this->tmp_data['no_questions'] = 1;
            }
        }
    }

    public static function str($ar_source, $del = " | ", $trim = true) {
        $ret = "";

        foreach ($ar_source as $k => $v) {
            if (is_array($v)) {
                $v = self::str($v);
                if ($trim)
                    $v = trim($v, " |");

                $v = "[" . $v . "]";
            }

            if (is_int($k)) {
                $ret .= $v . $del;
            } else {
                if (is_bool($v)) {
                    if ($v)
                        $v = "true";
                    else
                        $v = "false";
                }

                if (is_object($v))
                    continue;

                $ret .= $k . " => " . $v . $del;
            }
        }

        if ($trim) {
            $ret = trim($ret, $trim);
        }
        return $ret;
    }

    function getSelectYearTeacher($NativeSession, $SubjectsModel, $subject_id, $year_id) {
        $session_key = 'teacher_year_' . $subject_id;

        if ($year_id != '')
            $NativeSession->set($session_key, $year_id);

        if (is_null($NativeSession->get($session_key))) {
            $available_years = $SubjectsModel->get_subject_years($subject_id);
            $first_year = $available_years[0];
            if (!empty($first_year))
                $NativeSession->set($session_key, $first_year->id);
        }
        $YID = $NativeSession->get($session_key);
        $current_year = $SubjectsModel->get_year($YID);

        if (empty($current_year)) {
            return (object) Array('id' => 0, 'year' => 0);
        } else {
            return $current_year;
        }
    }

    function getSelectYearStudent($SubjectsModel, $subject_id, $student_year) {

        $current_year = $SubjectsModel->get_subject_year($subject_id, $student_year);
        if (empty($current_year)) {
            return (object) Array('id' => 0, 'year' => 0);
        } else {
            return $current_year;
        }
    }

}
