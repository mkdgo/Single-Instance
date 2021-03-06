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
        'a1', 'a1d',
        'b2',
        'c1', 'c2', 'c2n',
        'd1', 'd1a', 'd1b', 'd2_teacher', 'd3_teacher', 'd4_teacher', 'd5_teacher',
        'df',
        'e1_teacher', 'e2', 'e3', 'e5_teacher',
        'f1_teacher', 'f2b_teacher', 'f2c_teacher', 'f2d_teacher', 'f2p_teacher', 'f3_teacher', 'f4_teacher', 'f5_teacher', 'f2_student',
        'g1_teacher', 'g1a_teacher', 'g2',
        'r1_teacher', 'r2_teacher',
        's1', 'search_admin',
        'interactive_lessons_ajax',
        'running_lesson_t',
        'online_students',
        'feedback',
        'logout',
        'work', 'w1',
        'testing'
    );
    public $_students_allowed = array(
        'a1', 'a1d',
        'b1',
        'c1', 'c2',
        'd1', 'd2_student', 'd3_student', 'd4_student', 'd5_student',
        'df',
        'e1_student', 'e5_student',
        'f1_student', 'f2_student', 'f4_student', 'f4_teacher', 'f5_student',
        'g1_student', 
        's1', 'search_admin',
        'running_lesson',
        'feedback',
        'logout',
        'work', 'w1',
        'testing'
    );
    public $_notuser_allowed = array( 'a1', 'a1d', 'login', 'search_admin' );
    public $_site_settings = array();

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
    public $_school = '';
    public $_test_resources = array( 'single_choice', 'multiple_choice', 'fill_in_the_blank', 'mark_the_words' );
    public $_quiz_resources = array( 'single_choice', 'multiple_choice', 'fill_in_the_blank', 'mark_the_words' );
    public $_not_quiz_resources = array( 'local_image', 'local_file', 'remote_video', 'remote_url', 'remote_box' );

    function __construct() {
//echo '<pre>';var_dump( $this->config->item('db') );die;

        parent::__construct();
        $this->load->model('settings_model');
        $this->load->library('minify');
        $this->load->library('nativesession');
        $this->load->driver('cache', array('adapter' => 'file'));
//        $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
        if ( !$this->_site_settings = $this->cache->get('site_settings')) {
             $this->_site_settings = $this->settings_model->getAllSettingsAsAssocArray();
             // Save into the cache for 5 minutes
             $this->cache->save('site_settings', $this->_site_settings, 300);
        }

        $this->defaultIDP = $this->_site_settings['default_identity_data_provider'];
        $this->fallBackToDefaultIDP = $this->_site_settings['fall_back_to_default_identity_data_provider'];
        $this->headTitle = $this->_site_settings['website_head_title'];
        
        $this->config->load('constants');

//$this->load->library('school_vars');
//echo '<pre>';var_dump( $this->config->item('db') );die;


        $this->config->load('minify_css');
        $this->config->load('minify_js');
        $this->_school = $SCHOOL = $this->config->item('SCHOOL');
        $this->_elastic = $this->config->item('ELASTIC');

        if (isset($SCHOOL['custom'])) {
if(is_array($SCHOOL['custom'])) {
            if (in_array('onelogin', $SCHOOL['custom'])) {
                $this->onelogin_allowed = true;
            }
}
        }
        if( $this->session->userdata('user_type') == 'teacher' ) {
            $this->_data['_header']['tvl_creating_resources'] = $this->settings_model->getLessonLink($this->_site_settings['tvlesson_creating_resources']);
            $this->_data['_header']['tvl_interactive_lessons'] = $this->settings_model->getLessonLink($this->_site_settings['tvlesson_interactive_lessons']);
            $this->_data['_header']['tvl_setting_homework'] = $this->settings_model->getLessonLink($this->_site_settings['tvlesson_setting_homework']);
            $this->_data['_header']['tvl_submitting_homework'] = $this->settings_model->getLessonLink($this->_site_settings['tvlesson_submitting_homework']);
            $this->_data['_header']['tvl_marking_homework'] = $this->settings_model->getLessonLink($this->_site_settings['tvlesson_marking_homework']);
        }
        if( $this->session->userdata('user_type') == 'student' ) {
            $this->_data['_header']['svlesson_creating_resources'] = $this->settings_model->getLessonLink($this->_site_settings['svlesson_creating_resources']);
            $this->_data['_header']['svlesson_interactive_lessons'] = $this->settings_model->getLessonLink($this->_site_settings['svlesson_interactive_lessons']);
            $this->_data['_header']['svlesson_setting_homework'] = $this->settings_model->getLessonLink($this->_site_settings['svlesson_setting_homework']);
            $this->_data['_header']['svlesson_submitting_homework'] = $this->settings_model->getLessonLink($this->_site_settings['svlesson_submitting_homework']);
            $this->_data['_header']['svlesson_marking_homework'] = $this->settings_model->getLessonLink($this->_site_settings['svlesson_marking_homework']);
        }
        $this->_data['_header']['logout_custom'] = '';
        if( $this->_site_settings['logout_url'] == 'custom' ) {
            $this->_data['_header']['logout_custom'] = '';
//            $this->_data['_header']['logout_custom'] = '/info';
        }

/*        $this->_data['_header']['enable_feedback'] = $this->config->item('enable_feedback') && ($this->session->userdata('user_type') == 'teacher');*/
        $this->_data['_header']['onelogin_allowed'] = $this->onelogin_allowed;
        $this->_data['_header']['enable_feedback'] = $this->config->item('enable_feedback');
        $this->_data['_header']['tagger_id'] = $this->session->userdata('id');
        $this->_data['_header']['tagger_type'] = strtolower($this->session->userdata('user_type'));
        $this->_data['_header']['tagger_name'] = $this->session->userdata('first_name') . ' ' . $this->session->userdata('last_name');
        $this->_data['_header']['tagger_class'] = strtolower($this->router->fetch_class());

//echo '<pre>';var_dump( $this->config->item('db') );die;

/*  Load css and js  */
        $router_class = $this->router->fetch_class();
        $_css = $this->config->item('css');
        $this->_data['_css'] = array();
        $this->_data['css_name'] = 'default.css';
        $this->_data['css_group'] = 'default';

        $this->_data['_css'] = $_css['default'];
        if( array_key_exists($router_class,$_css) ) {
            $this->_data['_css'] = $_css[$router_class];
            $this->_data['css_name'] = $router_class.'.css';
            $this->_data['css_group'] = $router_class;
        }
        $_css_ext = $this->config->item('css_ext');
        $this->_data['_css_ext'] = '';
        if( array_key_exists($router_class,$_css_ext) ) {
            $this->_data['_css_ext'] = $_css_ext[$router_class];
        }

        $_js = $this->config->item('js');
        $this->_data['_js'] = array();
        $this->_data['js_name'] = 'default.js';
        $this->_data['js_group'] = 'default';

        $this->_data['_js'] = $_js['default'];
        if( array_key_exists($router_class,$_js) ) {
            $this->_data['_js'] = $_js[$router_class];
            $this->_data['js_name'] = $router_class.'.js';
            $this->_data['js_group'] = $router_class;
        }
        $_js_ext = $this->config->item('js_ext');
        $this->_data['_js_ext'] = '';
        if( array_key_exists($router_class,$_js_ext) ) {
            $this->_data['_js_ext'] = $_js_ext[$router_class];
        }
/* end css and js*/

//echo '<pre>';var_dump( $this->_data['js_group'] );die;
        $this->load->database();
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
        $this->_data['_message'] = $this->session->flashdata('_message');
        $this->user_id = $this->session->userdata('id');
        $this->user_email = $this->session->userdata('email');
        $this->user_full_name = $this->session->userdata('first_name')." ".$this->session->userdata('last_name');
        $this->user_type = $this->session->userdata('user_type');

        $this->_data['heap_identify'] = $this->user_email;
        
        if( !$this->session->userdata('admin_logged') ) {
            if( !$this->user_id  && !in_array( $this->router->fetch_class(), $this->_notuser_allowed ) ) {
                $this->nativesession->set('ediface_redirect_uri',$_SERVER['REQUEST_URI'] );
                redirect('/a1', 'refresh');
            } elseif( $this->user_type == 'student' && !in_array( $this->router->fetch_class(), $this->_students_allowed) ) {
                redirect('/a1', 'refresh');
            } elseif( $this->user_type == 'teacher' && !in_array( $this->router->fetch_class(), $this->_teachers_allowed) ) {
                redirect('/a1', 'refresh');
            }
        }

        if( isset($this->router->uri->segments[1]) &&
            ( ( $this->router->uri->segments[1] == "f4_student" && $this->user_type == "student" && $this->router->uri->segments[2] == "index" )
             || ( $this->router->uri->segments[1] == "f4_teacher" && $this->user_type == "student" && $this->router->uri->segments[2] == "loaddata" )) ) {
            
        } else {
            if( $this->user_type == "student" and ( strpos(get_class($this), "teacher") !== false or in_array(get_class($this), array('B2', 'G2'))))
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
//        $data['_header'] = $this->parser->parse('admin/_header', $this->_data['_header'], true);
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
        $data['onelogin_allowed'] = false;
        if ($this->onelogin_allowed) {
            $data['onelogin_allowed'] = 'onelogin_allowed';
        }

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
        $imagetypes = array("jpg", "jpeg", "gif", "png", "pdf");
        $videolinks = array("youtube.com");
//$this->load->helper('download');

//        $upload_config = $this->config->load('upload',true);
//        $upload_path = $this->config->item('upload_path', 'upload');
        $upload_config = $this->config->load('upload');
        $upload_path = $this->config->item('upload_path');
        $default_image = $this->config->item('default_image' );
        $errorfilenotfound = $this->config->item('errorfilenotfound' );
        $mime_type = $this->config->item('mimes');
        $this->load->model('resources_model');
        $resource = $this->resources_model->get_resource_by_id($id);
        if (!isset($resource)) {
            show_404();
        }
//var_dump( $upload_path );die;
        if( !file_exists( $upload_path . $resource->resource_name ) ) {
            $href = '/df/index/-1';
            echo '<p style="background: url('.$href.') no-repeat 0 0; background-size: contain; width:100%; height:98%;" />';
//            echo '<img src="'.$href.'" style="margin: auto auto; display: block;" />';
//            $resource->resource_name = $errorfilenotfound;
        } else {
            $extension = pathinfo($resource->resource_name, PATHINFO_EXTENSION);
            if( !in_array($extension, $imagetypes) ) {
                $href = 'df/index/' . $resource->id;
                echo $echo1 = '<div id="editor_image" style=" font-family: \'Open Sans\', sans-serif; height: 200px; width: 600px; margin: auto auto;padding-top: 20%; font-size: 20px;text-align: center;">
                    <p>Please click "Download" to view the file</p>
                    <a id="download_resource_link" style="font-family: \'Open Sans\', sans-serif; text-align: center; margin:0px 70px; line-height:2; text-decoration: none; color: #fff; width:150px; height:36px; background: #ff0000;display: inline-block;" class="downloader" href="/' . $href . '">Download</a>
                    </div>';
    /*
                $this->load->helper('download');
                $data = file_get_contents($upload_path . $resource->resource_name); // Read the file's contents
                $name = $resource->name;
                force_download($name, $data);
    //*/
            } else {
                $href = '/df/index/' . $resource->id;
                echo '<img src="'.$href.'" style="margin: auto auto; display: block;" />';
    //            $img = $this->output
    //                    ->set_content_type($mime_type[$extension]) // You could also use ".jpeg" which will have the full stop removed before looking in config/mimes.php
    //                    ->set_output(file_get_contents($upload_path . $resource->resource_name));
            }
        }
    }
    
    public function resourceDownload($id) {
        $upload_config = $this->config->load('upload', TRUE);
//        $upload_path = $this->config->item('upload_path', 'upload');
        $upload_path = $this->config->item('upload_path');
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
                $preview = '<a data-id="'.$P.'" class="group_'.$P.' preview colorbox cboxElement" href="/df/index/'.$R->id.'" title="'.$R->name.'">' . $R->name . '</a>';
//                $preview = '<a data-id="'.$P.'" class="group_'.$P.' preview colorbox cboxElement" href="/c1/resource/'.$R->id.'" title="'.$R->name.'">' . $R->name . '</a>';
            } else {
                $preview = '<a data-id="'.$P.'" class="clr_iframe_'.$P.' preview" href="/df/index/'.$R->id.'" title="'.$R->name.'">' . $R->name . '</a>';
//                $preview = '<a data-id="'.$P.'" class="clr_iframe_'.$P.' preview" href="/c1/resource/'.$R->id.'" title="'.$R->name.'">' . $R->name . '</a>';
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
//echo 'remote';
            if ($TP == 'video') {
                $preview = $this->getRemoteVideoDisplayer($loc, $R);
            } else {
                $preview = $this->getRemoteFrameDisplayer($loc, $R);
            }
        } elseif( in_array( $R->type, $this->_quiz_resources ) ) {
//die($R->type);
            $preview = $this->getHtml($loc, $R);
        } else {
//echo 'local';
            if ($TP == 'image') {
                $preview = $this->getLocalImageDisplayer($loc, $R);
            } elseif( $TP == 'pdf' ) {
                $preview = $this->getLocalFramePDFDisplayer($loc, $R);
            } else {
                $preview = $this->getLocalFrameDisplayer($loc, $R);
            }
        }
//echo '<pre>';var_dump( $R->type );
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
                $preview = '<a class="fullscreen" onClick="$(this).colorbox({iframe:true, innerWidth:\'90%\', innerHeight:\'90%\', webkitallowfullscreen:true});" href="' . $vlink . '" class="lesson_link colorbox" title="' . $R->link . '"></a>';
//                $preview = '<a style="text-decoration:none; color: #fff; padding: 5px; background: #099A4D; display: inline-block;" onClick="$(this).colorbox({iframe:true, innerWidth:\'90%\', innerHeight:\'90%\', webkitallowfullscreen:true});" href="' . $vlink . '" class="lesson_link colorbox" title="' . $R->link . '">View Fullscreen</a>';
            } else {
                $upload_path = ltrim($this->config->item('upload_path', 'upload'), '.');
                $preview = '<a class="fullscreen" onClick="$(this).colorbox({iframe:true, innerWidth:\'90%\', innerHeight:\'90%\', webkitallowfullscreen:true}); return false;" href="' . $R->link . '" class="lesson_link colorbox" title="' . $R->link . '" ></a>';
//                $preview = '<a style="text-decoration:none; color: #fff; padding: 5px; background: #099A4D; display: inline-block;" onClick="$(this).colorbox({iframe:true, innerWidth:\'90%\', innerHeight:\'90%\', webkitallowfullscreen:true}); return false;" href="' . $R->link . '" class="lesson_link colorbox" title="' . $R->link . '" style="display:inline;width:100%;overflow:hidden;font-family: \'Open Sans\', sans-serif"></a>';
            }
        } elseif( in_array( $R->type, array( 'single_choice', 'multiple_choice', 'fill_in_the_blank', 'mark_the_words' ) ) ) {
//            $this->load->library('resource');
//            $new_resource = new Resource();
//            $content = $new_resource->renderBody( 'show', $R->type, $R);
            $preview = '<a class="fullscreen" onClick="$(this).colorbox({inline:true, innerWidth:\'80%\', innerHeight:\'80%\'});" href="#' . $R->id  . '" title="' . $R->name . '" class="lesson_link colorbox"></a>';
        } else {
            if ($TP == 'image') {
                $upload_path = ltrim($this->config->item('upload_path', 'upload'), '.');
                $preview = '<a class="fullscreen" onClick="$(this).colorbox({iframe:true, innerWidth:\'90%\', innerHeight:\'90%\'});" href="/df/viewer/' . $R->id . '" title="' . $R->name . '" class="lesson_link colorbox"></a>';
/*                $preview = '<a class="fullscreen" href="/df/index/' . $R->id . '" title="' . $R->name . '" class="lesson_link colorbox"></a>';*/
//                $preview = '<a style="text-decoration:none; color: #fff; padding: 5px; background: #099A4D; display: inline-block;" href="' . $loc . $R->id . '" title="' . $R->resource_name . '" class="lesson_link colorbox" style="display:inline;width:90%; overflow:hidden;font-family:open sans">View Fullscreen</a>';
            } elseif( $TP == 'pdf' ) {
                $upload_config = $this->config->load('upload', TRUE);
                $upload_path = $this->config->item('upload_path', 'upload');
                $upload_path = ltrim($this->config->item('upload_path', 'upload'), '.');
                $path = "/uploads/resources/temp/";
                $preview = '<a class="fullscreen" onClick="$(this).colorbox({iframe:true, innerWidth:\'90%\', innerHeight:\'90%\', webkitallowfullscreen:true});" href="/ViewerJS/index.html#' .  $path . $R->resource_name . '" title="' . $R->name . '" class="lesson_link colorbox" ></a>';
//                $preview = '<a class="fullscreen" onClick="$(this).colorbox({iframe:true, innerWidth:\'90%\', innerHeight:\'90%\', webkitallowfullscreen:true});" href="/ViewerJS/index.html#' .  $path . $R->resource_name . '" title="' . $R->name . '" class="lesson_link colorbox" style="display:inline;width:90%;overflow:hidden;font-family:\'Open Sans\', sans-serif"></a>';
            } else {
                $upload_config = $this->config->load('upload', TRUE);
                $upload_path = $this->config->item('upload_path', 'upload');
                $upload_path = ltrim($this->config->item('upload_path', 'upload'), '.');
                $href = 'df/index/' . $R->id;
//                $href = $loc . $R->id;
                $preview = '<a class="fullscreen" onClick="$(this).colorbox({iframe:true, innerWidth:\'90%\', innerHeight:\'90%\'});" href="' . $href . '" title="' . $R->name . '" class="lesson_link colorbox"></a>';
/*                $preview = '<a class="fullscreen" onClick="$(this).colorbox({iframe:true, innerWidth:\'90%\', innerHeight:\'90%\'});" href="' . $href . '" title="' . $R->name . '" class="lesson_link colorbox" style="display:inline;width:90%;overflow:hidden;font-family:\'Open Sans\', sans-serif"></a>';*/
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
            $name = ( strlen( $R->name ) > 50 ) ? substr( $R->name,0,50 ).'...' : $R->name ;
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
        if( strstr( $R->link, 'box.com/' ) ) {
            $tmp = explode( '/', $R->link );
            $R->link = 'https://app.box.com/embed/preview/'.end($tmp).'?theme=dark';
        }

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
            $name = ( strlen( $R->name ) > 50 ) ? substr( $R->name,0,50 ).'...' : $R->name ;
            $return = '<a onClick="$(this).colorbox({iframe:true, innerWidth:\'80%\', innerHeight:\'80%\'});" href="' . $R->link . '" title="' . $R->link . '" class="lesson_link colorbox" style="display:inline;width:100%;overflow:hidden;font-family:\'Open Sans\', sans-serif">' . $name . '</a>';
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
            $name = ( strlen( $R->name ) > 50 ) ? substr( $R->name,0,50 ).'...' : $R->name ;
            $href = $loc . $R->id;
            $return = '<a onClick="$(this).colorbox({iframe:true, innerWidth:\'80%\', innerHeight:\'80%\'});" href="' . $href . '" title="' . $R->name . '" class="lesson_link colorbox" style="display:inline;width:90%;overflow:hidden;font-family:\'Open Sans\', sans-serif">' . $name . '</a>';
        }

        if (substr($loc, 0, 9) == '/c1/save/') {
            $return = '<a href="' . $loc . '" class="lesson_link" title="' . $R->link . '">' . $R->name . '</a>';
        }

        if ($loc == '/c2/resource/') {
/*
            $return = '<div id="editor_image" style=" font-family: Open Sans; height: 200px; width: 600px; margin: auto auto;padding-top: 20%; font-size: 20px;text-align: center;">
<p>Please click "Download" to view the file</p>
<a id="download_resource_link" class="downloader" href="'.base_url().'c2/download/'.$R->resource_name.'" style="font-family: Open Sans; text-align: center; margin:0px 70px; line-height:2; text-decoration: none; color: #fff; width:150px; height:36px; background: #ff0000;display: inline-block;">Download</a>
</div>';
                $href = 'df/index/' . $R->id;
                $return = '<div id="editor_image" style=" font-family: Open Sans; height: 200px; width: 600px; margin: auto auto;padding-top: 20%; font-size: 20px;text-align: center;">
                    <p>Please click "Download" to view the file</p>
                    <a id="download_resource_link" style="font-family: Open Sans; text-align: center; margin:0px 70px; line-height:2; text-decoration: none; color: #fff; width:150px; height:36px; background: #ff0000;display: inline-block;" class="downloader" href="/' . $href . '">Download</a>
                    </div>';
//*/
            $return = '<iframe id="iframe1" class="" src="' . $loc . $R->id . '"  scrolling="no" frameborder="0" width="100%" height="100%" ></iframe>';
//            $return = '<iframe id="iframe1" class="" src="' . $loc . $R->id . '"  scrolling="no" frameborder="0" width="100%" height="100%" onLoad="autoResize(\'iframe1\');" ></iframe>';
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
            $return = '<a onClick="$(this).colorbox({iframe:true, innerWidth:\'80%\', innerHeight:\'80%\',  webkitallowfullscreen:true, onComplete: addCButton('.$R->id.')});" href="/ViewerJS/index.html#' . $path . $R->resource_name . '" class="btn b1 colorbox" title="' . $R->name . '"><span>VIEW</span><i class="icon i1"></i></a>';
        }

        if ($loc == '/d4_teacher/resource/' || true) {
            $return = '<a onClick="$(this).colorbox({iframe:true, innerWidth:\'80%\', innerHeight:\'80%\',  webkitallowfullscreen:true, onComplete: addCButton('.$R->id.')});" href="/ViewerJS/index.html#' . $path . $R->resource_name . '" class="btn b1 colorbox" title="' . $R->name . '"><span>VIEW</span><i class="icon i1"></i></a>';
        }

        if ($loc == '/c1/resource/') {
            $name = ( strlen( $R->name ) > 50 ) ? substr( $R->name,0,50 ).'...' : $R->name ;
            $return = '<a onClick="$(this).colorbox({iframe:true, innerWidth:\'80%\', innerHeight:\'80%\', webkitallowfullscreen:true});" href="/ViewerJS/index.html#' .  $path . $R->resource_name . '" title="' . $R->name . '" class="lesson_link colorbox" style="display:inline;width:90%;overflow:hidden;font-family:\'Open Sans\', sans-serif">' . $name . '</a>';
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
            $return = '<a onClick="$(this).colorbox({iframe:true, innerWidth:\'80%\', innerHeight:\'80%\', webkitallowfullscreen:true}); " href="/ViewerJS/index.html#' . $path . $R->resource_name . '" class="view_res_butt colorbox" title="' . $R->name . '">View</a>';
        }

        if (substr($loc, 0, 10) == '/e3-thumb/') {
            $icon = '<img src="' . $upload_path . 'default_text.jpg"/>';
            $return = '<a onClick="$(this).colorbox({iframe:true, innerWidth:\'80%\', innerHeight:\'80%\'});" href="/e3/resource/' . $R->id . '" title="' . $R->name . '">' . $icon . '</a>';
        }

        return $return;
    }

    public function getLocalImageDisplayer($loc, $R) {
        $upload_path = ltrim($this->config->item('upload_path', 'upload'), '.');
//echo $loc;//die;
        if ($loc == '/d5_teacher/resource/' || true) {
            $return = '<a onclick="addCButton('.$R->id.')" href="/df/index/' . $R->id . '" class="btn b1 colorbox" title="' . $R->name . '"><span>VIEW</span><i class="icon i1"></i></a>';
//            $return = '<a href="' . $loc . $R->id . '" class="btn b1 colorbox " title="' . $R->name . '"><span>VIEW</span><i class="icon i1"></i></a>';
        }

        if ($loc == '/c2/resource/') {
            // $return = '<a href="' . $loc . $R->id . '" title="' . $R->resource_name . '" class="lesson_link colorbox cboxElement" style="display:inline;width:90%;overflow:hidden;font-family:open sans">' . $R->name . '</a>';
            $return = '<img style="width:800px;" src="/df/index/'.$R->id . '" >';
//            $return = '<img style="width:800px;" src="'.base_url().'uploads/resources/temp/'.$R->resource_name . '" >';
        }
        if ($loc == '/e5_teacher/resource/') {
            $return = '<img class="pic_e5" src="/df/index/' . $R->id . '" alt="' . $R->resource_name . '" title="' . $R->name . '" />';
//            $return = '<img class="pic_e5" src="' . $loc . $R->id . '" alt="' . $R->resource_name . '" title="' . $R->resource_name . '" />';
        }

        if ($loc == '/e5_student/resource/') {
            $return = '<img class="pic_e5" src="/df/index/' . $R->id . '" alt="' . $R->resource_name . '" title="' . $R->name . '" />';
//            $return = '<img class="pic_e5" src="' . $loc . $R->id . '" alt="' . $R->resource_name . '" title="' . $R->resource_name . '" />';
        }

        if ($loc == '/f2b_teacher/resource/') {
            $return = '<a href="/df/index/' . $R->id . '" class="view_res_butt colorbox" title="' . $R->name . '">View</a>';
//            $return = '<a href="' . $loc . $R->id . '" class="view_res_butt colorbox" title="' . $R->name . '">View</a>';
        }

        if ($loc == '/f2_student/resource/' || $loc == '/f2a_student/resource/' ) {
            $return = '<a onClick="$(this).colorbox({iframe:true, innerWidth:\'80%\', innerHeight:\'80%\'});" href="' . $loc . $R->id  . '" title="' . $R->resource_name . '">' . $name . '</a>';
//            $return = '<a href="/df/index/' . $R->id . '" class="view_res_butt colorbox" title="' . $R->name . '">View</a>';
//            $return = '<a href="/df/index/' . $R->id . '" class="btn b1 colorbox" data-role="button" data-inline="true" data-mini="true" title="' . $R->name . '"><span>VIEW</span><i class="icon i1"></i></a>';
//            $return = '<a href="' . $loc . $R->id . '" class="colorbox" data-role="button" data-inline="true" data-mini="true" title="' . $R->name . '">View</a>';
        }

        if ($loc == '/c1/resource/') {
            $name = ( strlen( $R->name ) > 50 ) ? substr( $R->name,0,50 ).'...' : $R->name ;
            $return = '<a onClick="$(this).colorbox({iframe:true, innerWidth:\'80%\', innerHeight:\'80%\'});" href="' . $loc . $R->id  . '" title="' . $R->resource_name . '">' . $name . '</a>';
        }

        if (substr($loc, 0, 9) == '/c1/save/') {
            $return = '<a href="' . $loc . '" class="lesson_link" title="' . $R->link . '">' . $R->name . '</a>';
        }

        if (substr($loc, 0, 10) == '/e3-thumb/') {
            $return = '<img src="' . str_replace('/e3-thumb/', '', $loc) . '" class="img_200x150" />';
        }
//echo '<pre>'; var_dump( $return );//die;
        return $return;
    }




    public function getHtml($loc, $R) {
        $this->load->library('resource');
        $new_resource = new Resource();
        $content = $new_resource->renderBody( 'show', $R );
//        $content = $new_resource->renderBody( 'show', $R->type, $R->content);
        $upload_path = ltrim($this->config->item('upload_path', 'upload'), '.');
//        $title = $R->resource_name;
        $title = $R->name;
//        $name = $R->name;
        $name = ( strlen( $R->name ) > 50 ) ? substr( $R->name,0,50 ).'...' : $R->name ;
        if ($loc == '/c1/resource/') {
            $return = '<a onClick="$(this).colorbox({inline:true, innerWidth:\'80%\', innerHeight:\'80%\'});" href="#' . $R->id  . '" title="' . $title . '" style="color: #db4646;">' . $name . '</a>';
            $return .= '<div style="display: none;">'.$new_resource->renderShowTeacherForm( $R, $this->session->userdata('id') ).'</div>';
        }

        if( $loc == '/e2/resource/' ) {
            $return = '<a onClick="$(this).colorbox({inline:true, innerWidth:\'80%\', innerHeight:\'80%\'});" href="#' . $R->id  . '" title="' . $title . '">' . $name . '</a>';
            $return .= $new_resource->renderShowTeacherForm( $R, $this->session->userdata('id') );
        }
        if( $loc == '/e5_teacher/resource/' ) {
            //$return = '<a onClick="$(this).colorbox({inline:true, innerWidth:\'80%\', innerHeight:\'80%\'});" href="#' . $R->id  . '" title="' . $title . '">' . $name . '</a>';
            $return = '';
            $return .= $new_resource->renderShowTeacherForm( $R, $this->session->userdata('id') );
        }
        if( $loc == '/e5_student/resource/' ) {
            //$return = '<a onClick="$(this).colorbox({inline:true, innerWidth:\'80%\', innerHeight:\'80%\'});" href="#' . $R->id  . '" title="' . $title . '">' . $name . '</a>';
            $return = '';
            $return .= $new_resource->renderShowStudentForm( $R, $this->session->userdata('id') );
        }
        if( $loc == '/e5a_student/resource/' ) {
            //$return = '<a onClick="$(this).colorbox({inline:true, innerWidth:\'80%\', innerHeight:\'80%\' });" href="#' . $R->id  . '" title="' . $title . '">' . $name . '</a>';
            $return = '';
            $return .= $new_resource->renderEditStudentForm( $R, $this->session->userdata('id') );
        }
        if( $loc == '/f2_student/resource/' ) {
            $return = '<a onClick="$(this).colorbox({inline:true, innerWidth:\'80%\', innerHeight:\'80%\'});" href="#' . $R->id  . '" title="' . $title . '">' . $name . '</a>';
            $return .= $new_resource->renderShowStudentForm( $R, $this->session->userdata('id') );
        }
        if( $loc == '/f2a_student/resource/' ) {
            $return = '<a onClick="$(this).colorbox({inline:true, innerWidth:\'80%\', innerHeight:\'80%\', onOpen: setResult(' . $R->id  . ') });" href="#' . $R->id  . '" title="' . $title . '">' . $name . '</a>';
            $return .= $new_resource->renderEditStudentForm( $R, $this->session->userdata('id') );
        }
        if( $loc == '/f2b_student/resource/' ) {
            $return = '<a onClick="$(this).colorbox({inline:true, innerWidth:\'80%\', innerHeight:\'80%\', onOpen: setResult(' . $R->id  . ') });" href="#' . $R->id  . '" title="' . $title . '">' . $name . '</a>';
            $return .= $new_resource->renderStudentResult( $R );
        }
        if( $loc == '/f2c_teacher/resource/' ) {
            $return = '<a onClick="$(this).colorbox({inline:true, innerWidth:\'80%\', innerHeight:\'80%\'});" href="#' . $R->id  . '" title="' . $title . '">' . $name . '</a>';
            $return .= $new_resource->renderShowTeacherForm( $R, $this->session->userdata('id') );
        }
        if( $loc == '/f2b_teacher/resource/' ) {
            $return = '<a onClick="$(this).colorbox({inline:true, innerWidth:\'80%\', innerHeight:\'80%\'});" href="#' . $R->id  . '" title="' . $title . '">' . $name . '</a>';
            $return .= $new_resource->renderShowTeacherForm( $R, $this->session->userdata('id') );
        }
        if( $loc == '/f3_teacher/resource/' ) {
            $return = '<a onClick="$(this).colorbox({inline:true, innerWidth:\'80%\', innerHeight:\'80%\', onComplete: setResult(' . $R->id  . ') });" href="#' . $R->id  . '" title="' . $title . '">' . $name . '</a>';
            $return .= $new_resource->renderStudentResult( $R );
        }
        if( $loc == '/r2_teacher/resource/' ) {
            $return = '<a onClick="$(this).colorbox({inline:true, innerWidth:\'80%\', innerHeight:\'80%\', onOpen: clearForm('.$R->id.') });" href="#' . $R->id  . '" title="' . $title . '">Q' . ($R->position + 1) . '</a>';
            $return .= $new_resource->renderStudentResult( $R );
        }

/*
        if ($loc == '/d5_teacher/resource/' || true) {
            $return = '<a onclick="addCButton('.$R->id.')" href="/df/index/' . $R->id . '" class="btn b1 colorbox" title="' . $R->name . '"><span>VIEW</span><i class="icon i1"></i></a>';
        }

        if ($loc == '/c2/resource/') {
            $return = '<img style="width:800px;" src="/df/index/'.$R->id . '" >';
        }
        if ($loc == '/e5_teacher/resource/') {
            $return = '<img class="pic_e5" src="/df/index/' . $R->id . '" alt="' . $R->resource_name . '" title="' . $R->name . '" />';
        }

        if ($loc == '/e5_student/resource/') {
            $return = '<img class="pic_e5" src="/df/index/' . $R->id . '" alt="' . $R->resource_name . '" title="' . $R->name . '" />';
        }

        if ($loc == '/f2b_teacher/resource/') {
            $return = '<a href="/df/index/' . $R->id . '" class="view_res_butt colorbox" title="' . $R->name . '">View</a>';
        }

        if ($loc == '/f2_student/resource/') {
            $return = '<a href="/df/index/' . $R->id . '" class="btn b1 colorbox" data-role="button" data-inline="true" data-mini="true" title="' . $R->name . '"><span>VIEW</span><i class="icon i1"></i></a>';
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
//*/
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
