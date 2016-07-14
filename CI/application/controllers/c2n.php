<?php

if (!function_exists('redirect_back')) {

    function redirect_back() {
        if (isset($_SERVER['HTTP_REFERER'])) {
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        } else {
            header('Location: http://' . $_SERVER['SERVER_NAME']);
        }
        exit;
    }

}

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once APPPATH . 'libraries/AES/aes.class.php';
require_once APPPATH . 'libraries/AES/aesctr.class.php';

class C2n extends MY_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->load->library('session');
        $this->load->model('classes_model');
        $this->load->model('resources_model');
        $this->load->model('keyword_model');
        $this->load->model('search_model');
        $this->load->model('modules_model');
        $this->load->model('lessons_model');
        $this->load->model('content_page_model');
        $this->load->model('subjects_model');
        $this->load->library('nativesession');
        $this->load->library('breadcrumbs');
        $this->load->library('zend');
        $this->load->library('resource');
        $this->zend->load('Zend/Search/Lucene');
    }

    public function index( $resource_id = '0', $type = '', $subject_id = '', $year_id = '', $module_id = '', $lesson_id = '', $content_id = '')
    {
        $this->_data['type'] = $type;
        $this->_data['elem_id'] = $resource_id;
        $this->_data['subject_id'] = $subject_id;
        $this->_data['year_id'] = $year_id;
        $this->_data['module_id'] = $module_id;
        $this->_data['lesson_id'] = $lesson_id;
        $this->_data['content_id'] = $content_id;
        $this->_data['_header']['firstBack'] = 'saveform';
        $this->_data['_header']['secondback'] = '0';
        $this->_data['btn_cancel'] = '';

        $new_resource = new Resource();
        $resource = $this->resources_model->get_resource_by_id($resource_id);

        if( !$resource && (int)$resource_id > 0 ) {
            $this->session->set_flashdata('error_msg', "Resource doesn't exists!");
            redirect(base_url('/c1'));
        }

        if( $resource && ($this->session->userdata('user_type') == 'student')) {
            $r_years = explode(',', $resource->restriction_year);

            if( in_array($this->session->userdata('student_year'), $r_years) ) {
                $this->session->set_flashdata('error_msg', "You don't have permission to view this resource!");
                redirect(base_url('/c1'));
            }
        }

        if( !empty($resource) ) {
            $resource_keywords_ = $this->keyword_model->getResourceKeyword($resource->id);
            $resource_keywords = array();

            foreach ($resource_keywords_ as $kk => $vv) {
                $resource_keywords[] = $vv->word;
            }

            $content = json_decode( $resource->content );
            $rtype = $resource->type;
            if( !in_array( $rtype, $this->_quiz_resources ) && !in_array( $rtype, $this->_not_quiz_resources ) ) {
                if( $rtype == 'url' && strpos( $resource->link, 'box' ) ) {
                    $rtype = 'remote_box';        
                } else {
                    $rtype = str_replace(array('img', 'doc', 'video', 'url', 'box'), array( 'local_image', 'local_file', 'remote_video', 'remote_url', 'remote_box' ), $resource->type );
                }
            }
            $this->_data['resource_type'] = $resource->type;
            $this->_data['header']['type'] = $resource->type;

            $this->_data['header']['type'] = $rtype;
            $this->_data['search_query'] = $this->input->get('q', TRUE);
            $this->_data['new_res'] = 0;
            $this->_data['saved'] = 1;
            $this->_data['resource_type'] = $rtype;
            $this->_data['resource_exists'] = $resource->resource_name;
            $this->_data['resource_file'] = $resource->resource_name;
            $this->_data['resource_title'] = $resource->name;
            $this->_data['resource_keywords'] = str_replace('"', "", json_encode($resource_keywords));
            $this->_data['resource_keywords_a'] = str_replace('"', "", json_encode($resource_keywords));
            $this->_data['resource_link'] = $resource->link;
            $this->_data['is_remote'] = $resource->is_remote;
            $this->_data['is_remote_0'] = $this->_data['is_remote_1'] = '';
            if ($resource->is_remote == 0)
                $this->_data['is_remote_0'] = 'checked';
            else
                $this->_data['is_remote_1'] = 'checked';
            $this->_data['resource_desc'] = $resource->description;

            $this->_data['year_restriction'] = $this->classes_model->getAllYears();
            $this->_data['restricted_to'] = explode(',', $resource->restriction_year);
            $this->_data['preview'] = $this->resoucePreviewInline($resource, '/c2/resource/');
            $this->_data['container'] = '';
        } else {
            $this->_data['search_query'] = $this->input->get('q', TRUE);
            $this->_data['new_res'] = 1;
            $this->_data['saved'] = 0;
            $this->_data['resource_exists'] = '';
            $this->_data['resource_title'] = '';
            $this->_data['resource_keywords'] = '';
            $this->_data['resource_link'] = '';
            $this->_data['resource_file'] = '';
            $this->_data['is_remote'] = 1;
            $this->_data['is_remote_1'] = 'checked';
            $this->_data['is_remote_0'] = '';
            $this->_data['resource_keywords_a'] = json_encode(explode(', ', ''));
            $this->_data['resource_desc'] = '';
            $this->_data['year_restriction'] = array();
            $this->_data['preview'] = '';
            $this->_data['year_restriction'] = $this->classes_model->getAllYears();
            $this->_data['restricted_to'] = array();
            $this->_data['container'] = '';
            $this->_data['resource_type'] = '';
            $this->_data['header']['type'] = '';
        }

        $this->_data['new_resource'] = $new_resource;
        $btn_cancel = '';
        $this->breadcrumbs->push('Home', base_url());
        if( !empty($type) ) {
            $selected_year = $this->subjects_model->get_year($year_id);
            switch ($type) {
                case 'module' :
                    $this->breadcrumbs->push('Subjects', '/d1');
                    $subject = $this->subjects_model->get_single_subject($subject_id);
                    $this->breadcrumbs->push($subject->name, "/d1a/index/" . $subject_id);
                    $this->breadcrumbs->push('Year ' . $selected_year->year, "/d2_teacher/index/" .$subject_id."/" . $year_id);

                    $module_obj = $this->modules_model->get_module($module_id);
                    $mod_name = $module_obj[0]->name;
                    if (strlen($mod_name) > 40) {
                        $mod_name = substr($mod_name, 0, 40) . '...';
                    }
                    $this->breadcrumbs->push($mod_name, "/d4_teacher/index/" . $subject_id ."/". $year_id ."/". $module_id);
                    $this->breadcrumbs->push('Resources', '/c1/index/' . $type . '/' . $subject_id .'/'. $year_id . '/' . $module_id);
                    $btn_cancel = "/d4_teacher/index/" . $subject_id ."/". $year_id ."/". $module_id;
                    break;
                case 'lesson' :
                    $this->breadcrumbs->push('Subjects', '/d1');
                    $subject = $this->subjects_model->get_single_subject($subject_id);
                    $this->breadcrumbs->push($subject->name, "/d1a/index/" . $subject_id);
                    $this->breadcrumbs->push('Year ' . $selected_year->year, "/d2_teacher/index/" .$subject_id."/" . $year_id);

                    $module_obj = $this->modules_model->get_module($module_id);
                    $mod_name = $module_obj[0]->name;
                    if (strlen($mod_name) > 25) {
                        $mod_name = substr($mod_name, 0, 25) . '...';
                    }
                    $this->breadcrumbs->push($mod_name, "/d4_teacher/index/" . $subject_id ."/". $year_id ."/". $module_id);

                    $lesson = $this->lessons_model->get_lesson($lesson_id);
                    $lesson_name = $lesson->title;
                    if (strlen($lesson->title) > 25) {
                        $lesson_name = substr($lesson->title, 0, 25) . '...';
                    }
                    $this->breadcrumbs->push($lesson_name, "/d5_teacher/index/" . $subject_id . '/' . $year_id . '/' . $module_id . "/" . $lesson_id);

                    $this->breadcrumbs->push('Resources', '/c1/index/' . $type . '/' . $subject_id . '/' . $year_id . '/' . $module_id . "/" . $lesson_id);
                    $btn_cancel = "/d5_teacher/index/" . $subject_id . '/' . $year_id . '/' . $module_id . "/" . $lesson_id;
                    break;
                case 'content_page' :
                    $this->breadcrumbs->push('Subjects', '/d1');
                    $subject = $this->subjects_model->get_single_subject($subject_id);
                    $this->breadcrumbs->push($subject->name, "/d1a/index/" . $subject_id);
                    $this->breadcrumbs->push('Year ' . $selected_year->year, "/d2_teacher/index/" .$subject_id."/" . $year_id);

                    $module_obj = $this->modules_model->get_module($module_id);
                    $mod_name = $module_obj[0]->name;
                    if (strlen($mod_name) > 15) {
                        $mod_name = substr($mod_name, 0, 15) . '...';
                    }
                    $this->breadcrumbs->push($mod_name, "/d4_teacher/index/" . $subject_id ."/". $year_id ."/". $module_id);

                    $lesson = $this->lessons_model->get_lesson($lesson_id);
                    $lesson_name = $lesson->title;
                    if (strlen($lesson->title) > 15) {
                        $lesson_name = substr($lesson->title, 0, 15) . '...';
                    }
                    $this->breadcrumbs->push($lesson_name, "/d5_teacher/index/" . $subject_id ."/". $year_id. '/' . $module_id . "/" . $lesson_id );

                    $ut = $this->session->userdata('user_type');
                    $this->breadcrumbs->push("Slides", "/e1_" . $ut . "/index/" . $subject_id ."/". $year_id . '/' . $module_id . "/" . $lesson_id . "/" . $content_id);

                    $cont_page_obj = $this->content_page_model->get_cont_page($content_id);
                    $cont_title = (isset($cont_page_obj[0]->title) ? $cont_page_obj[0]->title : '');
                    if (!count($cont_page_obj))
                        $cont_title = "Create New Slide";
                    elseif (empty($cont_title)) {
                        $cont_title = "Edit Slide";
                    }
                    if (strlen($cont_title) > 16) {
                        $cont_title = substr($cont_title, 0, 16) . '...';
                    }
                    $this->breadcrumbs->push($cont_title, "/e2/index/" . $subject_id ."/". $year_id. '/' . $module_id . "/" . $lesson_id . "/" . $content_id);
                    $this->breadcrumbs->push('Resources', '/c1/index/' . $type . '/' . $subject_id . '/' . $year_id  . '/' . $module_id . "/" . $lesson_id . "/" . $content_id);
                    $btn_cancel = "/e2/index/" . $subject_id ."/". $year_id. '/' . $module_id . "/" . $lesson_id . "/" . $content_id;
                    break;
                case 'assignment' :
                    $this->breadcrumbs->push('Homework', '/f1_teacher');
                    $assignment = $this->assignment_model->get_assignment($subject_id);
                    $ut = $this->session->userdata('user_type');
                    $this->breadcrumbs->push($assignment->title, '/f2c_' . $ut . '/index/' . $subject_id);
                    $this->breadcrumbs->push('Resources', '/c1/index/' . $type . '/' . $subject_id);
                    $btn_cancel = '/f2c_' . $ut . '/index/' . $subject_id;
                    break;
                case 'resource' :
                    $this->breadcrumbs->push('Resources', '/c1');
                    break;
            }
        } else {
            $this->breadcrumbs->push('Resources', '/c1');
            $btn_cancel = '/c1';
        }
        if (!empty($this->_data['resource_title'])) {
            $this->breadcrumbs->push($this->_data['resource_title'], '/');
        } else {
            $this->breadcrumbs->push('Add Resource', '/');
        }

        $this->_data['breadcrumb'] = $this->breadcrumbs->show();
        $this->_data['btn_cancel'] = $btn_cancel;
        $this->_paste_public();
    }

    public function suggestKeywords()
    {
        $kwq = $this->input->get('q');
        $kwd = Array();

        if (strlen($kwq) > 1) {
            $kws = $this->keyword_model->suggestKeywords($kwq);
            foreach ($kws as $kk => $vv) {
                $kwd[] = $vv->word;
            }

            array_unshift($kwd, $kwq);
        }

        echo json_encode($kwd);
        die();
    }

    public function save() {
        $data = $this->input->post();
        $data['info']['author'] = $this->session->userdata('id');

        $type = $this->input->post('type');
        $elem_id = $this->input->post('elem_id');
        $subject_id = $this->input->post('subject_id');
        $year_id = $this->input->post('year_id');
        $module_id = $this->input->post('module_id');
        $lesson_id = $this->input->post('lesson_id');
        $content_id = $this->input->post('content_id');
        $assessment_id = $this->input->post('assessment_id');
        $link = '';
        $res_name = '';
        $is_remote = $this->input->post('is_remote') ? 1 : 0;
        if( in_array($data['header']['type'], array('local_file', 'local_image')) ) {
            $is_remote = 0;
            if( $this->input->post('resource_exists') && $data['content']['intro']['file'] == '' ) {
                $res_name = $this->input->post('resource_exists');
                $data['content']['intro']['file'] = $this->input->post('resource_exists');
            } elseif( $data['content']['intro']['file'] != "" ) {
                $res_name = $data['content']['intro']['file'];
            } else {
                $res_name = $data['content']['intro']['file'];
            }
//echo '<pre>';var_dump( $res_name );die;
            if( !$res_name ) {
                redirect_back();
                return;
            }

            $site_url = str_replace('www.', '', str_replace('http://', '', $_SERVER['HTTP_HOST']));
            $domain = explode('.', $site_url);
            if (substr($res_name, -4) == '.ppt') {
                $doc_type = substr($res_name, -3);
                $this->load->helper('my_helper', false);
                if( is_file('./uploads/resources/temp/' . $res_name ) ) {
                    $params = array($res_name, $domain[0], $doc_type);
                    $resp = My_helpers::doc_to_pdf($params);
                }
                $res_name = str_replace('.' . $doc_type, '.pdf', $res_name);
            }

            if (substr($res_name, -4) == '.xls') {
                $doc_type = substr($res_name, -3);
                $this->load->helper('my_helper', false);
                if (is_file('./uploads/resources/temp/' . $res_name)) {
                    $params = array($res_name, $domain[0], $doc_type);
                    $resp = My_helpers::doc_to_pdf($params);
                }
                $res_name = str_replace('.' . $doc_type, '.xlsx', $res_name);
            }

            if (substr($res_name, -4) == '.doc') {
                $doc_type = substr($res_name, -3);
                $this->load->helper('my_helper', false);
                if (is_file('./uploads/resources/temp/' . $res_name)) {
                    $params = array($res_name, $domain[0], $doc_type);
                    $resp = My_helpers::doc_to_pdf($params);
//log_message('info', $resp);
                }
                $res_name = str_replace('.' . $doc_type, '.doc', $res_name);
//                $res_name = str_replace('.' . $doc_type, '.docx', $res_name);
            }
/*
            if( $this->_school['site_type'] == 'demo' ) {
                if( is_file('./uploads/resources/temp/' . $res_name ) ) {
                    $this->load->helper('my_helper', false);
//                    $resp = $this->synchronizeFiles($res_name);
                }
            }
//*/
            $uploaded_file = $this->config->item('upload_path') . $res_name;
            $resource_type = $this->search_model->getFileResourceType($res_name);
        } elseif( in_array( $data['header']['type'], array('remote_video', 'remote_url', 'remote_box') ) ) {
            $link = $data['content']['intro']['text'];

            if ((substr($link, 0, 7) == 'http://')) {
                $prefix = 'http://';
                $url = explode($prefix, $link);
                $link = $prefix . $url[1];
            } else if ((substr($link, 0, 8) == 'https://')) {
                $prefix = 'https://';
                $url = explode($prefix, $link);
                $link = $prefix . $url[1];
            } else if ((substr($link, 0, 4) == 'www.')) {
                $prefix = 'www.';
                $url = explode($prefix, $link);
                $link = 'http://' . $prefix . $url[1];
            } else {
                $redirect_url = $type . '/' . $elem_id . '/' . $subject_id . '/' . $year_id  . '/' . $module_id . '/' . $lesson_id . '/' . $content_id;
                $this->session->set_flashdata('error_msg', 'Resource URL is not valid!');
            }

            $resource_type = $this->search_model->getURLResourceType($link);
            $is_remote = 1;
        } elseif( in_array( $data['header']['type'], array('single_choice', 'multiple_choice', 'fill_in_the_blank', 'mark_the_words') ) ) {
            if( count( $data['content']['answer'] ) ) {
                $i = 0;
                foreach( $data['content']['answer'] as $ans ) {
                    if( isset( $ans['true'] ) && $ans['true'] == 1 && empty( $ans['feedback'] ) ) {
                        $data['content']['answer'][$i]['feedback'] = 'Well done';
                    }
                    $i++;
                }
            }
            if( $this->_school['site_type'] == 'demo' && $res_name = $data['content']['intro']['file'] ) {
                if( is_file('./uploads/resources/temp/' . $res_name ) ) {
                    $this->load->helper('my_helper', false);
//                    $resp = $this->synchronizeFiles($res_name);
                }
            }
        }

        if (count($data['info']) > 1) {
            $restr = rtrim(implode(',', $data['info']['access']), ',');
        } elseif( isset( $data['info']['access'] ) && $data['info']['access'] != false ) {
            $restr = $data['info']['access'];
            $restr = $restr[0];
        } else {
            $restr = '';
        }

        $info['access'] = $restr;
        $resource['header'] = $data['header'];
        $resource['content'] = $data['content'];
        $resource['content']['intro']['text'] = $data['header']['description'];
        $resource['content']['question'] = $data['header']['title'];
        $resource['info'] = $data['info'];

        $content = json_encode($resource);
//echo '<pre>';var_dump( $data['header'] );die;
        $db_data = array(
            'is_remote' => $is_remote,
            'link' => $link,
            'resource_name' => $res_name,
            'name' => $data['header']['title'],
            'description' => $data['header']['description'],
            'behavior' => '',//$data['header']['behavior'],
            'type' => $data['header']['type'],
            'content' => $content,
            'keywords' => "",
            'teacher_id' => $data['info']['author'],
            'restriction_year' => $restr,
        );
//echo '<pre>';var_dump( $db_data );die;

        if( $elem_id > 0 ) {
            $resource_id = $this->resources_model->save($db_data, $this->input->post('elem_id'));
        } else {
            $resource_id = $this->resources_model->save($db_data);
        }

        // Keywords - re-enable here:
        $keywords = trim($this->input->post('resource_keywords'), '[],');
        $keywords = trim($keywords, ",");
        $keywords = str_replace("[,", "", $keywords);
        $keywords = str_replace("]", "", $keywords);

        $db_data['id'] = $resource_id;
        $db_data['uploaded_file'] = $uploaded_file;
        $db_data['keywords'] = $keywords;

        $this->keyword_model->updateResourceKeywords($keywords, $resource_id);
        $this->indexFileInElastic($resource_id, $db_data);

        if( $data['add_another'] == 1 ) {
            switch ($type) {
                case 'module':
                    $elem_id = $module_id;
                    break;
                case 'lesson':
                    $elem_id = $lesson_id;
                    break;
                case 'content_page':
                    $elem_id = $content_id;
                    break;
                case 'question':
                    break;
                case 'assignment':
                    $elem_id = $subject_id;
                    break;
            }
            $res = $this->resources_model->add_resource($type, $elem_id, $resource_id);
            redirect("/c2n/index/0/" . $type . '/' . $subject_id . '/' . $year_id . '/' . $module_id . '/' . $lesson_id . '/' . $content_id . '/?q='.$this->input->post('search_query'));
        } else {
            if( $type != '' ) {
                if( $elem_id > 0 ) {
                    redirect("/c1/index/" . $type . '/' . $subject_id . '/' . $year_id . '/' . $module_id . '/' . $lesson_id . '/' . $content_id . '/?q='.$this->input->post('search_query'));
                } else {
                    redirect("/c1/save/" . $resource_id . '/' . $type . '/' . $subject_id . '/' . $year_id . '/' . $module_id . '/' . $lesson_id . '/' . $content_id);
                }
            } else {
                redirect("/c1" . '/?q='.$this->input->post('search_query'), 'refresh');
            }
        }
    }

    public function resourceUpload() {
        $key = 'dcrptky@)!$2014dcrpt';

        $this->config->load('upload');
        $this->load->library('upload');
        $this->load->library('storage');
        $this->load->model('resources_model');
        $res_id = $this->input->get('res_id');
/*
        $CPT_POST = AesCtr::decrypt($this->input->post('qqfile'), $key, 256);
        $CPT_DATA = explode("::", $CPT_POST);

        $dir = $this->config->item('upload_path');

        $funm = explode('.', $_FILES['qqfile']['name']);
        $ext = $funm[count($funm) - 1];
        array_pop($funm);
        $NAME = md5(implode('.', $funm)) . time() . '.' . $ext;
        $uploadfile = $dir . $NAME;
//*/
//echo '<pre>';var_dump( $_FILES['qqfile'] );die;
        $funm = explode('.', $_FILES['qqfile']['name']);
        $ext = end($funm);
        $bucket = $this->config->item('bucket');
        $file_path = $this->config->item('resources');
        $storage = new Storage($bucket);
        $source = $_FILES['qqfile']['tmp_name'];
        $NAME = md5( $_FILES['qqfile']['name'].time() ).'.'.$ext;
        $target = $file_path . $NAME;
        $meta = array(
            'name' => $_FILES['qqfile']['name'],
            'type' => $_FILES['qqfile']['type'],
            'size' => $_FILES['qqfile']['size'],
            'ext' => $ext,
        );

        $upload_file = $storage->uploadFile( $source, $target, $meta );
        $file_link = $storage->showFile( $target );


            $json['status'] = 'success';
            $json['success'] = 'true';
            $json['name'] = $NAME;
            if( $ext == 'pdf' ) {
                $json['preview'] = '<a onClick="$(this).colorbox({iframe: true, innerWidth:\'80%\', innerHeight:\'80%\'});" href="/ViewerJS/index.html#'.$file_link.'" style="color: #fff;">'.$_FILES['qqfile']['name'].'</a>';
//                $json['preview'] = '<a onClick="$(this).colorbox({iframe: true, innerWidth:\'80%\', innerHeight:\'80%\'});" href="/ViewerJS/index.html#/uploads/resources/temp/'.$NAME.'" style="color: #fff;">';
            } elseif( in_array( $ext, array('png','jpg','jpeg','gif') ) ) {
                $json['preview'] = '<a onClick="$(this).colorbox();" href="'.$file_link.'" style="color: #fff;" >'.$_FILES['qqfile']['name'].'</a>';
            } else {
//                $file_link = 
                $json['preview'] = '<a onClick="$(this).colorbox({iframe: true, innerWidth:\'80%\', innerHeight:\'80%\'});" href="'.$file_link.'" style="color: #fff;" >'.$_FILES['qqfile']['name'].'</a>';
//                $json['name'] = '/c2/resource/'.$this->resource->id;
            }
            echo json_encode($json);
/*
echo '<pre>';var_dump( $upload_file );die;

        if( move_uploaded_file($_FILES['qqfile']['tmp_name'], $uploadfile) ) {
            $NF_NAME = $dir . $NAME . '_tmp';
            rename($uploadfile, $NF_NAME);
            $img_dataurl = base64_encode(file_get_contents($NF_NAME));

            if ($CPT_DATA[0] == 1) {
                $decrypt = AesCtr::decrypt($img_dataurl, $key, 256);
            } else {
                $half = $CPT_DATA[1];
                $SZ = $CPT_DATA[2];
                $CPT_l = $CPT_DATA[3];
                $crypter_middle = substr($img_dataurl, $half - $SZ, $CPT_l);
                $crypter_middle_decr = AesCtr::decrypt($crypter_middle, $key, 256);
                $decrypt = str_replace($crypter_middle, $crypter_middle_decr, $img_dataurl);
            }

            file_put_contents($uploadfile, base64_decode($decrypt));
            if( is_file($uploadfile) ) { unlink($NF_NAME); }
            $json['status'] = 'success';
            $json['success'] = 'true';
            $ext = end( explode( '.', $NAME ) );
            $json['name'] = $NAME;

            if( $ext == 'pdf' ) {
                $json['preview'] = '<a onClick="$(this).colorbox({iframe: true, innerWidth:\'80%\', innerHeight:\'80%\'});" href="/ViewerJS/index.html#/uploads/resources/temp/'.$NAME.'" style="color: #fff;">';
            } elseif( in_array( $ext, array('png','jpg','jpeg','gif') ) ) {
                $json['preview'] = '<a onClick="$(this).colorbox();" href="/uploads/resources/temp/'.$NAME.'" style="color: #fff;" >';
            } else {
                $file_link = 
                $json['preview'] = '<a onClick="$(this).colorbox({iframe: true, innerWidth:\'80%\', innerHeight:\'80%\'});" href="/uploads/resources/temp/'.$NAME.'" style="color: #fff;" >';
//                $json['name'] = '/c2/resource/'.$this->resource->id;
            }

            if( $res_id ) {
                $res = $this->resources_model->get_resource_by_id($res_id);
                $content = json_decode($res->content, true);
                $content['content']['intro']['file'] = $NAME;
    //            $content
//    echo '<pre>';var_dump( $content['content']['intro']['file'] );die;
                $db_data = array(
                    'is_remote' => $res->is_remote,
                    'link' => $res->link,
                    'resource_name' => $res->resource_name,
                    'name' => $res->name,
                    'description' => $res->description,
                    'behavior' => $res->behavior,
                    'type' => $res->type,
                    'content' => json_encode( $content ),
                    'keywords' => $res->keywords,
                    'teacher_id' => $res->teacher_id,
                    'restriction_year' => $res->restriction_year,
                    'active' => $res->active
                );

                $this->resources_model->save($db_data, $res_id );

            }

//            $json['name'] = $NAME;
            echo json_encode($json);
        } else {
            return false;
        }
//*/
    }

    public function resourceBoxUpload( $name, $url ) {
        $key = 'dcrptky@)!$2014dcrpt';

        $this->config->load('upload');
        $this->load->library('upload');

//        $CPT_POST = AesCtr::decrypt($this->input->post('qqfile'), $key, 256);
//        $CPT_DATA = explode("::", $CPT_POST);
        $dir = $this->config->item('upload_path');
        $funm = explode('.', $name);
        $ext = $funm[count($funm) - 1];
        array_pop($funm);
        $NAME = md5(implode('.', $funm)) . time() . '.' . $ext;
        $uploadfile = $dir . $NAME;

            
        if( file_put_contents($uploadfile, file_get_contents( $this->input->post('resource_link') ) ) ) {
//            $NF_NAME = $dir . $NAME . '_tmp';
//            rename($uploadfile, $NF_NAME);
//            $img_dataurl = base64_encode(file_get_contents($NF_NAME));
/*
            if ($CPT_DATA[0] == 1) {
                $decrypt = AesCtr::decrypt($img_dataurl, $key, 256);
            } else {
                $half = $CPT_DATA[1];
                $SZ = $CPT_DATA[2];
                $CPT_l = $CPT_DATA[3];
                $crypter_middle = substr($img_dataurl, $half - $SZ, $CPT_l);
                $crypter_middle_decr = AesCtr::decrypt($crypter_middle, $key, 256);
                $decrypt = str_replace($crypter_middle, $crypter_middle_decr, $img_dataurl);
            }
*/
//            file_put_contents($uploadfile, base64_decode($decrypt));
            if( is_file($uploadfile) ) {
                return $NAME;
            } else {
                return $NAME;
            }
//            $json['status'] = 'success';
//            $json['success'] = 'true';
//            $json['name'] = $NAME;
//            echo json_encode($json);
        } else {
            return false;
        }
    }

    public function delete_document($id) {
        $index = Zend_Search_Lucene::open(APPPATH . 'search/index');
        //$hit = $index->getDocument($id);
        //$rid    = $hit->getDocument()->id;
        $index->delete($id);
    }

    public function indexFileInElastic($resource_id, $resource) {
        $keywords = $this->keyword_model->getResourceKeyword($resource_id);
        $keywordsArray = array();
        foreach ($keywords as $keyword) {
            $keywordsArray[] = $keyword->word;
        }

        $years = explode(',', $resource['restriction_year']);
        $yearsArray = array();
        foreach ($years as $year) {
            $yearsArray[] = intval($year);
        }

        $this->load->model('settings_model');
        $this->load->library('storage');

        $host = $this->settings_model->getSetting('elastic_url');
        $client = new \Elastica\Client(array(
            'host' => $host,
            'port' => '80',
            'transport' => 'AwsAuthV4',
            'aws_region' => 'eu-central-1',
            'aws_access_key_id' => 'AKIAIRMCG6PRQHYH2RDA',
            'aws_secret_access_key' => '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',
//'aws_session_token'
        ));

        $index = $client->getIndex($this->settings_model->getSetting('elastic_index'));
        $type = $index->getType('resources');

        $document = new \Elastica\Document($resource_id, array(
            'id' => $resource_id,
            'teacher_id' => $resource['teacher_id'],
            'resource_name' => $resource['resource_name'],
            'type' => $resource['type'],
            'name' => $resource['name'],
            'keywords' => $keywordsArray,
            'description' => $resource['description'],
            'restriction_year' => $yearsArray,
            'active' => true,
            'is_remote' => $resource['is_remote'],
            'link' => $resource['link']
        ));
        
        $type->addDocument($document);
        $type->getIndex()->refresh();
    }

    public function indexFile($resource) {
        $this->search_model->add_resource($resource);
        return;
    }

    public function delete($resource_id) {
        if ($this->session->userdata('user_type') == 'teacher') {
            $this->config->load('upload');
            $resource = $this->resources_model->get_resource_by_id($resource_id);
            if ($resource) {
                $dir = $this->config->item('upload_path');
                $file = $dir . $resource->resource_name;
                if (is_file($file))
                    unlink($file);
                $this->resources_model->delete_resource($resource_id);
            }
        }
        redirect("/c1");
    }

    public function delete_file() {
        $file = $this->input->post('filename');
        $path = realpath('uploads/resources/temp/');
        if (is_file($path . '/' . $file)) {
            unlink($path . '/' . $file);
        }
        echo json_encode('true');
    }

    public function download($file_name) {
        redirect(base_url('/c1'));

        $this->load->helper('file');
        $path = 'uploads/resources/temp/';

        if (is_file('uploads/resources/temp/'.$file_name)) {
            // required for IE
            if (ini_get('zlib.output_compression')) {
                ini_set('zlib.output_compression', 'Off');
            }
        }

        // get the file mime type using the file extension
        if (file_exists($path.$file_name)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename='.basename($file_name));
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($path.$file_name));
            readfile($path.$file_name);
            exit;
        }
    }

    public function getContent() {
        $key = $this->input->get('res_type');
//        $key = str_replace(array('img', 'doc', 'video', 'url', 'box'), array( 'local_image', 'local_file', 'remote_video', 'remote_url', 'remote_box' ), $key );

        $res_id = $this->input->get('res_id');

        $resource = $this->resources_model->get_resource_by_id($res_id);
        $new_resource = new Resource();
        if( $resource ) {
            $res_content = $resource;
            $content = $new_resource->renderBody( 'update', $key, $res_content );
//echo '<pre>';var_dump( $content );die;
        } else {
            $content = $new_resource->renderBody( 'create', $key );
        }
//var_dump( $content );die;
        echo $content;
    }



    public function synchronizeFiles( $res_name ) {

        $this->load->library('ftp');
        $this->config->load('upload');
        $dir = $this->config->item('upload_path');
        $upload_path = $this->config->item('upload_path');

        //FTP configuration
        $demo_sites = $this->config->item('sinc_demo');

        foreach( $demo_sites as $site ) {
            $ftp_config = $site['ftp_config'];
            $subdomain = $site['subdomain'];
            if( $subdomain != $this->_school['demo_type'] ) {
                //Connect to the remote server
                $this->ftp->connect($ftp_config);

                $local_file = $upload_path . $res_name;
                //File upload path of remote server
//                $remote_file = '/subdomains/'.$subdomain.'/uploads/resources/temp/'.$res_name;
                $remote_file = $site['upload_resource'] . $res_name;
                            
                //Upload file to the remote server
                $this->ftp->upload( $local_file, $remote_file );
                            
                //Close FTP connection
                $this->ftp->close();
            }
        }
    }
}

?>
