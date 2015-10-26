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

class C2 extends MY_Controller
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
        $this->zend->load('Zend/Search/Lucene');
    }

    public function index($type = '', $resource_id = '0', $subject_id = '', $module_id = '', $lesson_id = '', $assessment_id = '')
    {
        $this->_data['type'] = $type;
        $this->_data['elem_id'] = $resource_id;
        $this->_data['subject_id'] = $subject_id;
        $this->_data['module_id'] = $module_id;
        $this->_data['lesson_id'] = $lesson_id;
        $this->_data['assessment_id'] = $assessment_id;
        $this->_data['_header']['firstBack'] = 'saveform';
        $this->_data['_header']['secondback'] = '0';

        $resource = $this->resources_model->get_resource_by_id($resource_id);

        if (!$resource && (int)$resource_id > 0) {
            $this->session->set_flashdata('error_msg', "Resource doesn't exists!");
            redirect(base_url('/c1'));
        }

        $r_years = explode(',', $resource->restriction_year);

        if ($resource && ($this->session->userdata('user_type') == 'student')) {
            if (in_array($this->session->userdata('student_year'), $r_years)) {
                $this->session->set_flashdata('error_msg', "You don't have permission to view this resource!");
                redirect(base_url('/c1'));
            }
        }

        if (!empty($resource)) {
            $resource_keywords_ = $this->keyword_model->getResourceKeyword($resource->id);
            $resource_keywords = array();

            foreach ($resource_keywords_ as $kk => $vv) {
                $resource_keywords[] = $vv->word;
            }

            $this->_data['new_resource'] = 0;
            $this->_data['saved'] = TRUE;
            $this->_data['resource_exists'] = '<input type="hidden" name="resource_exists" value="' . $resource->resource_name . '" />';
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
        } else {
            $this->_data['new_resource'] = 1;
            $this->_data['saved'] = FALSE;
            $this->_data['resource_exists'] = '';
            $this->_data['resource_title'] = '';
            $this->_data['resource_keywords'] = '';
            $this->_data['resource_link'] = '';
            $this->_data['is_remote'] = 1;
            $this->_data['is_remote_1'] = 'checked';
            $this->_data['is_remote_0'] = '';
            $this->_data['resource_keywords_a'] = json_encode(explode(', ', ''));
            $this->_data['resource_desc'] = '';
            $this->_data['year_restriction'] = array();
            $this->_data['preview'] = '';
            $this->_data['year_restriction'] = $this->classes_model->getAllYears();
            $this->_data['restricted_to'] = explode(',', $resource->restriction_year);
        }

        $this->_data['classes'] = array();

        $this->breadcrumbs->push('Home', base_url());
        if (!empty($type)) {
            $selected_year = $this->getSelectYearTeacher($this->nativesession, $this->subjects_model, $module_id, '');
            switch ($type) {
                case 'module' :
                    $this->breadcrumbs->push('Subjects', '/d1');
                    $subject = $this->subjects_model->get_single_subject($module_id);
                    $this->breadcrumbs->push($subject->name, "/d1a/index/" . $module_id);
                    $this->breadcrumbs->push('Year ' . $selected_year->year, "/d2_teacher/index/" . $module_id);

                    $module_obj = $this->modules_model->get_module($module_id);
                    $mod_name = $module_obj[0]->name;
                    if (strlen($mod_name) > 40) {
                        $mod_name = substr($mod_name, 0, 40) . '...';
                    }
                    $this->breadcrumbs->push($mod_name, "/d4_teacher/index/" . $module_id . "/" . $subject_id);

                    $this->breadcrumbs->push('Resources', '/c1/index/' . $type . '/' . $subject_id . '/' . $module_id);
                    break;
                case 'lesson' :
                    $this->breadcrumbs->push('Subjects', '/d1');
                    $subject = $this->subjects_model->get_single_subject($module_id);
                    $this->breadcrumbs->push($subject->name, "/d1a/index/" . $module_id);
                    $this->breadcrumbs->push('Year ' . $selected_year->year, "/d2_teacher/index/" . $module_id);

                    $module_obj = $this->modules_model->get_module($module_id);
                    $mod_name = $module_obj[0]->name;
                    if (strlen($mod_name) > 25) {
                        $mod_name = substr($mod_name, 0, 25) . '...';
                    }
                    $this->breadcrumbs->push($mod_name, "/d4_teacher/index/" . $module_id . "/" . $lesson_id);

                    $lesson = $this->lessons_model->get_lesson($subject_id);
                    $lesson_name = $lesson->title;
                    if (strlen($lesson->title) > 25) {
                        $lesson_name = substr($lesson->title, 0, 25) . '...';
                    }
                    $this->breadcrumbs->push($lesson_name, "/d5_teacher/index/" . $module_id . "/" . $lesson_id . '/' . $subject_id);

                    $this->breadcrumbs->push('Resources', '/c1/index/' . $type . '/' . $subject_id . '/' . $module_id . "/" . $lesson_id);
                    break;
                case 'content_page' :
                    $this->breadcrumbs->push('Subjects', '/d1');
                    $subject = $this->subjects_model->get_single_subject($module_id);
                    $this->breadcrumbs->push($subject->name, "/d1a/index/" . $module_id);
                    $this->breadcrumbs->push('Year ' . $selected_year->year, "/d2_teacher/index/" . $module_id);

                    $module_obj = $this->modules_model->get_module($lesson_id);
                    $mod_name = $module_obj[0]->name;
                    if (strlen($mod_name) > 15) {
                        $mod_name = substr($mod_name, 0, 15) . '...';
                    }
                    $this->breadcrumbs->push($mod_name, "/d4_teacher/index/" . $module_id . "/" . $lesson_id);

                    $lesson = $this->lessons_model->get_lesson($assessment_id);
                    $lesson_name = $lesson->title;
                    if (strlen($lesson->title) > 15) {
                        $lesson_name = substr($lesson->title, 0, 15) . '...';
                    }
                    $this->breadcrumbs->push($lesson_name, "/d5_teacher/index/" . $module_id . "/" . $lesson_id . "/" . $assessment_id);

                    $ut = $this->session->userdata('user_type');
                    $this->breadcrumbs->push("Slides", "/e1_" . $ut . "/index/" . $module_id . "/" . $lesson_id . "/" . $assessment_id);

                    $cont_page_obj = $this->content_page_model->get_cont_page($subject_id);
                    $cont_title = (isset($cont_page_obj[0]->title) ? $cont_page_obj[0]->title : '');
                    if (!count($cont_page_obj))
                        $cont_title = "Create New Slide";
                    elseif (empty($cont_title)) {
                        $cont_title = "Edit Slide";
                    }
                    if (strlen($cont_title) > 16) {
                        $cont_title = substr($cont_title, 0, 16) . '...';
                    }
                    $this->breadcrumbs->push($cont_title, "/e2/index/" . $module_id . "/" . $lesson_id . "/" . $assessment_id . "/" . $subject_id);
                    $this->breadcrumbs->push('Resources', '/c1/index/' . $type . '/' . $subject_id . '/' . $module_id . "/" . $lesson_id . "/" . $assessment_id);
                    break;
                case 'assignment' :
                    $this->breadcrumbs->push('Homework', '/f1_teacher');
                    $assignment = $this->assignment_model->get_assignment($subject_id);
                    $ut = $this->session->userdata('user_type');
                    $this->breadcrumbs->push($assignment->title, '/f2c_' . $ut . '/index/' . $subject_id);
                    $this->breadcrumbs->push('Resources', '/c1/index/' . $type . '/' . $subject_id);
                    break;
                case 'resource' :
                    $this->breadcrumbs->push('Resources', '/c1');
                    break;
            }
        } else {
            $this->breadcrumbs->push('Resources', '/c1');
        }
        if (!empty($this->_data['resource_title'])) {
            $this->breadcrumbs->push($this->_data['resource_title'], '/');
        } else {
            $this->breadcrumbs->push('Add Resource', '/');
        }
        $this->_data['breadcrumb'] = $this->breadcrumbs->show();
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

    public function save()
    {
        $type = $this->input->post('type');
        $elem_id = $this->input->post('elem_id');
        if ($type != 'resource' && $type != '')
            $elem_id = 0;
        $subject_id = $this->input->post('subject_id');
        $module_id = $this->input->post('module_id');
        $lesson_id = $this->input->post('lesson_id');
        $assessment_id = $this->input->post('assessment_id');
        $link = '';

        if ($this->input->post('is_remote') != 1) {
            if ($this->input->post('resource_exists') && $this->input->post('file_uploaded') == '') {
                $res_name = $this->input->post('resource_exists');
            } elseif (($this->input->post('file_uploaded') != "")) {
                $res_name = $this->input->post('file_uploaded');
            } else {
                $res_name = $this->input->post('file_uploaded');
            }

            if (!$res_name) {
                redirect_back();
                return;
            }

            $site_url = str_replace('www.', '', str_replace('http://', '', $_SERVER['HTTP_HOST']));

            $domain = explode('.', $site_url);

            if (substr($res_name, -4) == '.ppt') {
                $doc_type = substr($res_name, -3);
                $this->load->helper('my_helper', false);
                if (is_file('./uploads/resources/temp/' . $res_name)) {
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
                }
                $res_name = str_replace('.' . $doc_type, '.docx', $res_name);
            }

            $uploaded_file = $this->config->item('upload_path') . $res_name;
            $resource_type = $this->search_model->getFileResourceType($res_name);
        } else {
            $link = $this->input->post('resource_link');

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
                $redirect_url = $type . '/' . $elem_id . '/' . $subject_id . '/' . $module_id . '/' . $lesson_id . '/' . $assessment_id;
                $this->session->set_flashdata('error_msg', 'Resource URL is not valid!');
                redirect(base_url('c2/index/' . $redirect_url));
            }

            $resource_type = $this->search_model->getURLResourceType($link);
            $res_name = '';
        }

        if (count($this->input->post('year_restriction')) > 1) {
            $restr = rtrim(implode(',', $this->input->post('year_restriction')), ',');
        } else if ($this->input->post('year_restriction') !== false) {
            $restr = $this->input->post('year_restriction');
            $restr = $restr[0];
        } else {
            $restr = '';
        }

        $db_data = array(
            'teacher_id' => $this->session->userdata('id'),
            'is_remote' => $this->input->post('is_remote'),
            'link' => $link,
            'resource_name' => $res_name,
            'name' => $this->input->post('resource_title'),
            'keywords' => "",
            'description' => $this->input->post('resource_desc'),
            'type' => $resource_type[0],
            'restriction_year' => $restr,
        );

        if ($elem_id > 0) {
            $resource_id = $this->resources_model->save($db_data, $this->input->post('elem_id'));
//            $this->delete_document($subject_id);
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

//        $this->indexFile($db_data);
        if ($type != '') {
            redirect("/c1/save/" . $resource_id . '/' . $type . '/' . '/' . $subject_id . '/' . $module_id . '/' . $lesson_id . '/' . $assessment_id);
        } else {
            redirect("/c1", 'refresh');
        }
    }

    public function resourceUpload() {
        $key = 'dcrptky@)!$2014dcrpt';

        $this->config->load('upload');
        $this->load->library('upload');

        $CPT_POST = AesCtr::decrypt($this->input->post('qqfile'), $key, 256);
        $CPT_DATA = explode("::", $CPT_POST);
        $dir = $this->config->item('upload_path');
        $funm = explode('.', $_FILES['qqfile']['name']);
        $ext = $funm[count($funm) - 1];
        array_pop($funm);
        $NAME = md5(implode('.', $funm)) . time() . '.' . $ext;
        $uploadfile = $dir . $NAME;

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
            $json['name'] = $NAME;
            echo json_encode($json);
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

        $host = $this->settings_model->getSetting('elastic_url');
        $client = new \Elastica\Client(array(
            'host' => $host
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
}

?>
