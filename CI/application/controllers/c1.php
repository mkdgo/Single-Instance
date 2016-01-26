<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class C1 extends MY_Controller {

    function __construct() {

        parent::__construct();
        $this->load->model('resources_model');
        $this->load->model('modules_model');
        $this->load->model('lessons_model');
        $this->load->model('content_page_model');
        $this->load->model('subjects_model');
        $this->load->model('interactive_assessment_model');
        $this->load->model('assignment_model');
        $this->load->model('user_model');
        $this->load->library('breadcrumbs');
        $this->load->library('nativesession');
        $this->load->library('zend');
        $this->zend->load('Zend/Search/Lucene');
    }

    function index($type = '', $subject_id = '', $year_id = '', $module_id = '', $lesson_id = '', $content_id = '', $elem_id = '0') {
        $this->_data['back'] = $this->getBackUrl($type, $subject_id, $year_id, $module_id, $lesson_id, $content_id);

        $this->_data['save_resource'] = '';
        $this->_data['type'] = $type;

        $this->breadcrumbs->push('Home', base_url());
        if( !empty($type) ) {
//            $selected_year = $this->getSelectYearTeacher($this->nativesession, $this->subjects_model, $subject_id, '');
            $selected_year = $this->subjects_model->get_year($year_id);
            switch ($type) {
                case 'module' :
                    $this->breadcrumbs->push('Subjects', '/d1');
                    $subject = $this->subjects_model->get_single_subject($subject_id);
                    $this->breadcrumbs->push($subject->name, "/d1a/index/" . $subject_id);
                    $this->breadcrumbs->push('Year ' . $selected_year->year, "/d2_teacher/index/" . $subject_id . "/" . $year_id );

                    $module_obj = $this->modules_model->get_module($module_id);
                    $mod_name = $module_obj[0]->name;
                    if (strlen($mod_name) > 40) {
                        $mod_name = substr($mod_name, 0, 40) . '...';
                    }
                    $resources_array = array();
                    $resources = $this->resources_model->get_module_resources($elem_id);
                    if( $resources ) {
                        foreach( $resources as $res ) {
                            $resources_array[] = $res->res_id;
                        }
                    }
                    $this->breadcrumbs->push($mod_name, "/d4_teacher/index/" . $subject_id . "/" . $year_id  . "/" . $module_id);
                    $this->_data['add_resource'] = base_url() . "c2/index/$type/0" . '/' . $subject_id . '/' . $year_id . '/' . $module_id ;
                    $this->_data['save_resource'] = "{$type}/" . $subject_id . '/' . $year_id . '/' . $module_id;
                    break;
                case 'lesson' :
                    $this->breadcrumbs->push('Subjects', '/d1');
                    $subject = $this->subjects_model->get_single_subject($subject_id);
                    $this->breadcrumbs->push($subject->name, "/d1a/index/" . $subject_id);
                    $this->breadcrumbs->push('Year ' . $selected_year->year, "/d2_teacher/index/" . $subject_id . "/" . $year_id);

                    $module_obj = $this->modules_model->get_module($module_id);
                    $mod_name = $module_obj[0]->name;
                    if (strlen($mod_name) > 25) {
                        $mod_name = substr($mod_name, 0, 25) . '...';
                    }
                    $this->breadcrumbs->push($mod_name, "/d4_teacher/index/" . $subject_id . "/" . $year_id  . "/" . $module_id);

                    $lesson = $this->lessons_model->get_lesson($lesson_id);
                    $lesson_name = $lesson->title;

                    $resources_array = array();
                    $resources = $this->resources_model->get_lesson_resources($elem_id);
                    if( $resources ) {
                        foreach( $resources as $res ) {
                            $resources_array[] = $res->res_id;
                        }
                    }

                    if (strlen($lesson->title) > 25) {
                        $lesson_name = substr($lesson->title, 0, 25) . '...';
                    }
                    $this->breadcrumbs->push($lesson_name, "/d5_teacher/index/" . $subject_id . "/" . $year_id  . "/" . $module_id . "/" . $lesson_id);
                    $this->_data['add_resource'] = base_url() . "c2/index/$type/0" . '/' . $subject_id . '/' . $year_id . '/' . $module_id . '/' . $lesson_id;
                    $this->_data['save_resource'] = "{$type}/" . $subject_id . '/' . $year_id . '/' . $module_id . '/' . $lesson_id ;
                    break;
                case 'content_page' :
                    $this->breadcrumbs->push('Subjects', '/d1');
                    $subject = $this->subjects_model->get_single_subject($subject_id);
                    $this->breadcrumbs->push($subject->name, "/d1a/index/" . $subject_id);
                    $this->breadcrumbs->push('Year ' . $selected_year->year, "/d2_teacher/index/" . $subject_id . "/" . $year_id );

                    $module_obj = $this->modules_model->get_module($module_id);
                    $mod_name = $module_obj[0]->name;
                    if (strlen($mod_name) > 20) {
                        $mod_name = substr($mod_name, 0, 20) . '...';
                    }
                    $this->breadcrumbs->push($mod_name, "/d4_teacher/index/" . $subject_id . "/" . $year_id  . "/" . $module_id);

                    $lesson = $this->lessons_model->get_lesson($lesson_id);
                    $lesson_name = $lesson->title;
                    if (strlen($lesson->title) > 20) {
                        $lesson_name = substr($lesson->title, 0, 20) . '...';
                    }
                    $this->breadcrumbs->push($lesson_name, "/d5_teacher/index/" . $subject_id . "/" . $year_id  . "/" . $module_id . "/" . $lesson_id);

                    $ut = $this->session->userdata('user_type');
                    $this->breadcrumbs->push("Slides", "/e1_" . $ut . "/index/" . $subject_id . "/" . $year_id  . "/" . $module_id . "/" . $lesson_id);

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
                    $resources_array = array();
                    $resources = $this->resources_model->get_cont_page_resources($elem_id);
                    if( $resources ) {
                        foreach( $resources as $res ) {
                            $resources_array[] = $res->res_id;
                        }
                    }
                    $this->breadcrumbs->push($cont_title, "/e2/index/" . $subject_id . "/" . $year_id . "/" . $module_id . "/" . $lesson_id . "/" . $content_id);
                    $this->_data['add_resource'] = base_url() . "c2/index/$type/0" . '/' . $subject_id . '/' . $year_id . '/' . $module_id . '/' . $lesson_id . "/" . $content_id;
                    $this->_data['save_resource'] = "{$type}/" . $subject_id . "/" . $year_id . "/" . $module_id . "/" . $lesson_id . "/" . $content_id ;
                    break;
                case 'assignment' :
                    $this->breadcrumbs->push('Homework', '/f1_teacher');
                    $assignment = $this->assignment_model->get_assignment($subject_id);
                    $ut = $this->session->userdata('user_type');
                    $resources_array = array();
                    $resources = $this->resources_model->get_assignment_resources($subject_id);
                    if( $resources ) {
                        foreach( $resources as $res ) {
                            $resources_array[] = $res->res_id;
                        }
                    }
                    $this->breadcrumbs->push($assignment->title, '/f2c_' . $ut . '/index/' . $subject_id);
                    $this->_data['add_resource'] = base_url() . "c2/index/$type/0" . '/' . $subject_id;
                    $this->_data['save_resource'] = "{$type}/" . $subject_id;
//var_dump( $this->_data['save_resource'] );die;
                    break;
            }

//            $this->_data['add_resource'] = base_url() . "c2/index/$type/0/$elem_id" . ($subject_id ? '/' . $subject_id : '') . ($year_id ? '/' . $year_id : '') . ($module_id ? '/' . $module_id : '') . ($lesson_id ? '/' . $lesson_id : '') . ($assessment_id ? '/' . $assessment_id : '');
        } else {
            $this->_data['add_resource'] = "/c2/index//0";
            $resources_array = null;
        }

        $this->_data['exist_resources'] = $resources_array ? implode( ',', $resources_array ) : null;
        $this->_data['query'] = '';
        $this->_data['resources'] = array();
        $this->_data['results'] = '';

        $this->breadcrumbs->push('Resources', '/');
        $this->_data['breadcrumb'] = $this->breadcrumbs->show();
        $this->_paste_public();
    }

    function assignment($type, $assignment_id = '', $elem_id = '0') {
        $this->_data['back'] = "{$type}/index/{$assignment_id}" ;//$this->getBackUrl($type, $subject_id, $year_id, $module_id, $lesson_id, $content_id);
        $assignment = $this->assignment_model->get_assignment($assignment_id);

        $this->_data['save_resource'] = '';

        $this->breadcrumbs->push('Home', base_url());
        $this->breadcrumbs->push('Homework', '/f1_teacher');
        if( !empty($type) ) {
            switch ($type) {
                case 'f2c_teacher' :
                    $this->breadcrumbs->push($assignment->title, "/f2c_teacher/index/" . $assignment_id);
                    break;
                case 'f2b_teacher' :
                    $this->breadcrumbs->push($assignment->title, "/f2b_teacher/index/" . $assignment_id);
                    break;
                case 'f2d_teacher' :
                    $this->breadcrumbs->push($assignment->title, "/f2d_teacher/index/" . $assignment_id);
                case 'f2p_teacher' :
                    $this->breadcrumbs->push($assignment->title, "/f2p_teacher/index/" . $assignment_id);
                    break;
            }

            $this->_data['add_resource'] = base_url() . "c2/assignment/$type/0" . '/' . $assignment_id ;
            $this->_data['save_resource'] = "{$type}/" . $assignment_id;
//            $this->_data['add_resource'] = base_url() . "c2/index/$type/0/$elem_id" . ($subject_id ? '/' . $subject_id : '') . ($year_id ? '/' . $year_id : '') . ($module_id ? '/' . $module_id : '') . ($lesson_id ? '/' . $lesson_id : '') . ($assessment_id ? '/' . $assessment_id : '');
        } else {
            $this->_data['add_resource'] = "/c2/index//0";
            $resources_array = null;
            $this->_data['save_resource'] = "{$type}/{$elem_id}" . ($subject_id ? '/' . $subject_id : '') . ($year_id ? '/' . $year_id : '') . ($module_id ? '/' . $module_id : '') . ($lesson_id ? '/' . $lesson_id : '') . ($assessment_id ? '/' . $assessment_id : '');
        }

        $this->_data['exist_resources'] = $resources_array ? implode( ',', $resources_array ) : null;
        $this->_data['query'] = '';
        $this->_data['resources'] = array();
        $this->_data['results'] = '';

        $this->breadcrumbs->push('Resources', '/');
        $this->_data['breadcrumb'] = $this->breadcrumbs->show();
        $this->_paste_public();
    }

    function results($query = '') {
        $this->_data['query'] = strval($query);
        $this->_data['results'] = $this->formquery($query);
        $this->_paste_public();
    }

    public function elasticQuery($query, $exist_list = null) {
        $this->load->model('settings_model');
        $q = trim( $query );

        $host = $this->settings_model->getSetting('elastic_url');
        $client = new \Elastica\Client(array(
            'host' => $host,
            'escape' => true
        ));

        $search = new \Elastica\Search($client);
        $search->addIndex($this->settings_model->getSetting('elastic_index'))->addType('resources');

        $yearFilter = null;
        if ($this->session->userdata('user_type') == 'student') {
            $yearFilter = new \Elastica\Filter\Term(array('restriction_year' => intval($this->session->userdata('student_year'))));
        }

        $keywordsQuery = new \Elastica\Query\Match();
        $keywordsQuery->setField('keywords', array(
            'query' => $q,
            'boost' => 2,
            'fuzziness' => 3
        ));
        $keywordsPartQuery = new \Elastica\Query\Wildcard();
        $keywordsPartQuery->setValue('keywords', "*$q*", 1.5 );

        $nameQuery = new \Elastica\Query\Match();
        $nameQuery->setField('name', array(
            'query' => $q,
            'boost' => 1.5,
            'fuzziness' => 3
        ));

        $namePartQuery = new \Elastica\Query\Wildcard();
        $namePartQuery->setValue('name', "*$q*", 1.5 );

        $descriptionQuery = new \Elastica\Query\Match();
        $descriptionQuery->setField('description', array(
            'query' => $q,
            'boost' => 1,
            'fuzziness' => 3
        ));

        $boolQuery = new \Elastica\Query\Bool();
        $boolQuery->addShould($keywordsQuery);
        $boolQuery->addShould($keywordsPartQuery);
        $boolQuery->addShould($nameQuery);
        $boolQuery->addShould($namePartQuery);
        $boolQuery->addShould($descriptionQuery);

        $filteredQuery = new \Elastica\Query\Filtered($boolQuery, $yearFilter);

        $elasticQuery = new \Elastica\Query();
        $elasticQuery->setQuery($filteredQuery);
        $elasticQuery->setFields(array('_id'));

        $search->setQuery($elasticQuery);

        $results = $search->search();
        $exist_array = explode( ',', $exist_list );
        foreach ($results->getResults() as $result) {
            $resource_id = $result->getParam('_id');
            $resource = $this->resources_model->get_resource_by_id($resource_id);

            if( $resource ) {
                $this->_data['resources'][$resource_id] = array();
                $this->_data['resources'][$resource_id]['title'] = $resource->name;
                $this->_data['resources'][$resource_id]['link'] = $resource->link;
                $this->_data['resources'][$resource_id]['description'] = $resource->description;
                $this->_data['resources'][$resource_id]['id'] = $resource_id;
                $this->_data['resources'][$resource_id]['type'] = $resource->type;
                $this->_data['resources'][$resource_id]['resource_id'] = $resource_id;
                $this->_data['resources'][$resource_id]['preview'] = $this->resoucePreview($resource, '/c1/resource/');
                $this->_data['resources'][$resource_id]['exist_resource'] = in_array( $resource_id, $exist_array) ? 1 : 0;
/*
                if ($resource->teacher_id) {
                    $teacher = $this->user_model->get_user($resource->teacher_id);
                } else {
                    $teacher = NULL;
                }
                if ($teacher) {
                    $this->_data['resources'][$resource_id]['user'] = $teacher->first_name . ' ' . $teacher->last_name;
                } else {
                    $this->_data['resources'][$resource_id]['user'] = $resource_id;
                }
//*/
                $this->_data['resources'][$resource_id]['user'] = User_model::getUserName( $resource->teacher_id );

            }
        }

        return $this->_data;
    }

    public function query($query) {
        try {
            $index = Zend_Search_Lucene::open(APPPATH . 'search/index');
            $hits = $index->find($query);
//echo '<pre>';var_dump( $hits );die;
        } catch (Zend_Search_Lucene_Exception $ex) {
            $hits = array();
        }
        $this->_data['resources'] = array();
        if (count($hits) > 0) {
            foreach ($hits as $key => $hit) {
                if ($hit->search_type != 'resource') {
                    continue;
                }
                // return Zend_Search_Lucene_Document object for this hit
                $document = $hit->getDocument();

                // Get the ID for the resource stored in the DB and load it:
                if ($hit->score >= 0) {
                    if ($hit->resource_id) {
                        $resource = $this->resources_model->get_resource_by_id($hit->resource_id);
                    } else {
                        $resource = NULL;
                    }

                    $findme = ',';
                    $pos = strpos($resource->restriction_year, $findme);

                    if ($pos === false) {
                        $r_years = array($resource->restriction_year);
                    } else {
                        $r_years = explode(',', $resource->restriction_year);
                    }

                    if ($resource && ($this->session->userdata('user_type') == 'student')) {
                        if (!in_array($this->session->userdata('student_year'), $r_years)) {
                            $resource = NULL;
                            $this->_data = NULL;
                            return $this->_data;
                        }
                    }

                    $this->_data['resources'][$key] = array();
                    $this->_data['resources'][$key]['title'] = $document->name;
                    $this->_data['resources'][$key]['link'] = $document->link;
                    $this->_data['resources'][$key]['description'] = mb_strlen($document->description)>30?mb_substr($document->description,0,30).'..':$document->description;
                    $this->_data['resources'][$key]['id'] = $hit->id;
                    $this->_data['resources'][$key]['type'] = $resource->type;

                    // Get Keywords:
                    try {
                        $this->_data['resources'][$key]['keyword'] = $hit->keyword;
                    } catch (exception $e) {
                        //echo $e->getMessage();
                    }

                    if ($resource->teacher_id) {
                        $teacher = $this->user_model->get_user($resource->teacher_id);
                    } else {
                        $teacher = NULL;
                    }
                    if ($teacher) {
                        $this->_data['resources'][$key]['user'] = $teacher->first_name . ' ' . $teacher->last_name;
                    } else {
                        $this->_data['resources'][$key]['user'] = '';
                    }
                    if ($hit->score >= 0 && $hit->score <= 0.3) {
                        $this->_data['resources'][$key]['score'] = 'low';
                    } elseif ($hit->score > 0.3 && $hit->score < 0.7) {
                        $this->_data['resources'][$key]['score'] = 'med';
                    } else {
                        $this->_data['resources'][$key]['score'] = 'high';
                    }
                    $this->_data['resources'][$key]['resource_id'] = $hit->resource_id;
                    $resource_object = $this->resources_model->get_resource_by_id($hit->resource_id);
                    $this->_data['resources'][$key]['preview'] = $this->resoucePreview($resource_object, '/c1/resource/');
                }
            }
        }

        return $this->_data;
    }

    public function formquery($query = '', $source = '') {
        if (empty($query)) {
            $data = $this->query($this->input->post('query'));
            return $this->parser->parse('search-results', $data, TRUE);
        } else {
            $data = $this->query($query);
            return $this->parser->parse('search-results', $data, TRUE);
        }
    }

    public function ajaxquery() {
        $data = $this->elasticQuery($this->input->post('query'),$this->input->post('exist_resources'));
        $data['user_type'] = $this->input->post('user_type');
        $data['save_resource'] = $this->input->post('save_resource');
        $data['exist_resource'] = $this->input->post('exist_resource');
        return $this->parser->parse('search-results', $data);
    }

    public function delete_document() {
        $id = $this->input->post('id');

        if ($this->session->userdata('user_type') == 'teacher') {
            $this->config->load('upload');

            $resource = $this->resources_model->get_resource_by_id($id);
            if ($resource) {
                $dir = $this->config->item('upload_path');

                $file = $dir . $resource->resource_name;
                if (is_file($file))
                    unlink($file);

                $this->resources_model->delete_resource($id);
            }
        }

        $this->load->model('settings_model');

        $host = $this->settings_model->getSetting('elastic_url');
        $client = new \Elastica\Client(array(
            'host' => $host
        ));

        $index = $client->getIndex($this->settings_model->getSetting('elastic_index'));
        $type = $index->getType('resources');

        $client->deleteIds(array($id), $index, $type);

        $json['result'] = 'true';
        echo json_encode($json);
    }

    private function getBackUrl($type, $subject_id, $year_id, $module_id, $lesson_id, $assessment_id) {
        switch ($type) {
            case 'module':
                return "/d4_teacher/index/{$subject_id}/{$year_id}/{$module_id}";
            case 'lesson':
                return "/d5_teacher/index/{$subject_id}/{$year_id}/{$module_id}/{$lesson_id}";
            case 'content_page':
                return "/e2/index/{$subject_id}/{$year_id}/{$module_id}/{$lesson_id}/{$assessment_id}";
            case 'question':
                return "/e3/index/{$subject_id}/{$year_id}/{$module_id}/{$lesson_id}/{$assessment_id}";
            case 'assignment':
                return "/f2c_teacher/index/{$subject_id}";
            default: // student resource library
                return '/c1';
            //return "/c2/index/resource/{$elem_id}";
        }
    }

    public function save($resource_id, $type, $subject_id = '', $year_id = '', $module_id = '', $lesson_id = '', $content_page_id = '') {
        if ($type == 'question') {
            $this->add_question_resource($resource_id, $type, $elem_id, $subject_id, $year_id, $module_id, $lesson_id, $content_page_id);
        }

        if (!$elem_id) {
            switch ($type) {
                case 'module':
//                    $elem_id = $this->modules_model->save(array('active' => '0'));
                    $elem_id = $module_id ? $module_id : $this->modules_model->save(array('active' => '0'));
                    break;
                case 'lesson':
//                    $elem_id = $this->lessons_model->save(array('active' => '0'));
                    $elem_id = $lesson_id ? $lesson_id : $this->lessons_model->save(array('active' => '0'));
                    break;
                case 'content_page':
//                    $elem_id = $this->content_page_model->save(array('active' => '0'));
                    $elem_id = $content_page_id ? $content_page_id : $this->content_page_model->save(array('active' => '0'));
                    break;
                case 'question':
                    // created in /e3
                    break;
                case 'assignment':
//                    $elem_id = $this->assignment_model->save(array('active' => '0'));
                    $elem_id = $subject_id ? $subject_id : $this->assignment_model->save(array('active' => '0'));
                    break;
            }
        }

        $res = $this->resources_model->add_resource($type, $elem_id, $resource_id);
        redirect($this->getBackUrl($type, $subject_id, $year_id, $module_id, $lesson_id, $content_page_id), 'refresh');
    }

    public function linkResource($resource_id, $type, $subject_id = '', $year_id = '', $module_id = '', $lesson_id = '', $content_page_id = '') {
        if ($type == 'question') {
            $this->add_question_resource($resource_id, $type, $elem_id, $subject_id, $year_id, $module_id, $lesson_id, $content_page_id);
        }
        if (!$elem_id) {
            switch ($type) {
                case 'module':
//                    $elem_id = $this->modules_model->save(array('active' => '0'));
                    $elem_id = $module_id ? $module_id : $this->modules_model->save(array('active' => '0'));
                    break;
                case 'lesson':
//                    $elem_id = $this->lessons_model->save(array('active' => '0'));
                    $elem_id = $lesson_id ? $lesson_id : $this->lessons_model->save(array('active' => '0'));
                    break;
                case 'content_page':
//                    $elem_id = $this->content_page_model->save(array('active' => '0'));
                    $elem_id = $content_page_id ? $content_page_id : $this->content_page_model->save(array('active' => '0'));
                    break;
                case 'question':
                    // created in /e3
                    break;
                case 'assignment':
//                    $elem_id = $this->assignment_model->save(array('active' => '0'));
                    $elem_id = $subject_id ? $subject_id : $this->assignment_model->save(array('active' => '0'));
                    break;
            }
        }
        $res = $this->resources_model->add_resource($type, $elem_id, $resource_id);
        if( $res ) {
            header('Content-Type: application/json');
            echo json_encode(array('status'=>1, 'id'=>$id));
            exit();
        } else {
            header('Content-Type: application/json');
            echo json_encode(array('status'=>0, 'mess'=>'not linked'));
            exit();
        }
    }

    public function unlinkResource($resource_id, $type, $elem_id = '0', $subject_id = '', $year_id = '', $module_id = '', $lesson_id = '', $assessment_id = '') {
        $result = $this->resources_model->remove_resource($type, $elem_id, $resource_id);
        if ($result) {
            header('Content-Type: application/json');
            echo json_encode(array('status'=>1, 'id'=>$id));
            exit();
        } else {
            header('Content-Type: application/json');
            echo json_encode(array('status'=>0, 'mess'=>'not linked'));
            exit();
        }
    }

    private function add_question_resource($resource_id, $type, $elem_id, $subject_id, $year_id, $module_id, $lesson_id, $assessment_id) {
        $temp_data = unserialize($this->interactive_assessment_model->get_ia_temp_data($assessment_id));

        $temp_data[$elem_id]['question_resource_id'] = $resource_id;

        $db_data = array(
            'temp_data' => serialize($temp_data)
        );
        $this->interactive_assessment_model->save_temp_data($db_data, $assessment_id);

        redirect($this->getBackUrl($type, $elem_id, $subject_id, $year_id, $module_id, $lesson_id, $assessment_id), 'refresh');
    }

    public function get_resource_usage() {
        $res = $this->resources_model->get_resource_usage($this->input->post('resource_id'));
        echo json_encode($res);
    }

}
