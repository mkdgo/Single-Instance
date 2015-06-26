<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class S1 extends MY_Controller {

    function S1() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('classes_model');
        $this->load->model('resources_model');
        $this->load->model('keyword_model');
        $this->load->model('modules_model');
        $this->load->model('lessons_model');
        $this->load->model('content_page_model');
        $this->load->model('interactive_assessment_model');
        $this->load->model('assignment_model');
        $this->load->model('user_model');
        $this->load->model('subjects_model');
        $this->load->library('zend');
        $this->zend->load('Zend/Search/Lucene');
    }

    function index() {
        $this->_data['query'] = '';
        $this->_data['resources'] = array();
        $this->_data['results'] = '';
        $this->_paste_public();
    }

    function results($query = '') {
        $this->_data['query'] = strval($query);
        $this->_data['results'] = $this->query($query);
        $this->_paste_public();
    }

    public function query($query) {
//        try {
//            $index = @Zend_Search_Lucene::open(APPPATH . 'search/index');
//            $hits = $index->find($query);
//        } catch (Zend_Search_Lucene_Exception $ex) {
//            $hits = array();
//        }
//
//        if (count($hits) > 0) {
//            foreach ($hits as $key => $hit) {
////echo "<pre>";var_dump($hit->subject_id);die;
//                // return Zend_Search_Lucene_Document object for this hit
//                $document = $hit->getDocument();
//                // Get the ID for the resource stored in the DB and load it:
//                if ($hit->score >= 0) {
//                    // Determine Search Result Type:
//                    if ($hit->search_type == 'user') {
////echo "<pre>";var_dump( $hit->year_id );die;
//                        if ($hit->type == 'student') {
//                            $this->_data['users'][$key]['name'] = $hit->name;
//                            $this->_data['users'][$key]['type'] = $hit->type;
//                            $this->_data['users'][$key]['id'] = $hit->user_id;
//                            $this->_data['users'][$key]['year'] = User_model::get_student_year($hit->user_id);
//                        }
//                    }
//
//                    if ($hit->search_type == 'resource') {
//                        if ($hit->resource_id) {
//                            $resource = $this->resources_model->get_resource_by_id($hit->resource_id);
//                        } else {
//                            $resource = NULL;
//                        }
//                        $this->_data['resources_count'] = count($resource);
//
//                        $this->_data['resources'][$key] = array();
//                        $this->_data['resources'][$key]['title'] = $document->name;
//                        $this->_data['resources'][$key]['link'] = $document->link;
//                        $this->_data['resources'][$key]['description'] = $document->description;
//                        $this->_data['resources'][$key]['id'] = $hit->id;
//                        $this->_data['resources'][$key]['type'] = $resource->type;
//                        // Get Keywords:
//                        try {
//                            $this->_data['resources'][$key]['keyword'] = $hit->keyword;
//                        } catch (exception $e) {
//                            
//                        }
//
//                        if ($resource->teacher_id) {
//                            $teacher = $this->user_model->get_user($resource->teacher_id);
//                        } else {
//                            $teacher = NULL;
//                        }
//                        if ($teacher) {
//                            $this->_data['resources'][$key]['user'] = $teacher->first_name . ' ' . $teacher->last_name;
//                        } else {
//                            $this->_data['resources'][$key]['user'] = $hit->resource_id;
//                        }
//
//                        $this->_data['resources'][$key]['resource_id'] = $hit->resource_id;
//                        $resource_object = $this->resources_model->get_resource_by_id($hit->resource_id);
//                        $this->_data['resources'][$key]['preview'] = $this->resoucePreview($resource_object, '/c1/resource/');
//                        $this->_data['resources_count'] = count($this->_data['resources']);
//                    }
//
//                    if ($hit->search_type == 'module') {
////echo "<pre>";var_dump($hit->subject_id);die;
//                        if ($this->session->userdata('user_type') == 'student') {
//                            $t = $this->subjects_model->get_student_subject_years($this->session->userdata('student_year'));
//
//                            $exp = explode(',', $t['subs']);
//                            if (!in_array($hit->year_id, $exp)) {
//                                $this->_data['modules'][$key]['name'] = $hit->name;
//                                $this->_data['modules'][$key]['module_id'] = $hit->module_id;
//                                $this->_data['modules'][$key]['intro'] = $hit->intro;
//                                $this->_data['modules'][$key]['objectives'] = $hit->objectives;
//                                $this->_data['modules'][$key]['teaching_activities'] = $hit->teaching_activities;
//                                $this->_data['modules'][$key]['assessment_opportunities'] = $hit->assessment_opportunities;
//                                $this->_data['modules'][$key]['notes'] = $hit->notes;
//                                $this->_data['modules'][$key]['publish'] = $hit->publish;
//                                $this->_data['modules'][$key]['active'] = $hit->active;
//                                $this->_data['modules'][$key]['subject_id'] = $hit->subject_id;
//                                $this->_data['modules'][$key]['subject_logo'] = Subjects_model::get_subject_logo($hit->subject_id);
//                                $this->_data['modules'][$key]['subject_title'] = substr(Subjects_model::get_subject_logo($hit->subject_id), 0, -4);
//                                $this->_data['modules'][$key]['year_id'] = $hit->year_id;
//                                $this->_data['modules'][$key]['type'] = 'Module';
//
//                                $this->_data['modules_count'] = count($this->_data['modules']);
//                            }
//                        } else {
//                            $this->_data['modules'][$key]['name'] = $hit->name;
//                            $this->_data['modules'][$key]['module_id'] = $hit->module_id;
//                            $this->_data['modules'][$key]['intro'] = $hit->intro;
//                            $this->_data['modules'][$key]['objectives'] = $hit->objectives;
//                            $this->_data['modules'][$key]['teaching_activities'] = $hit->teaching_activities;
//                            $this->_data['modules'][$key]['assessment_opportunities'] = $hit->assessment_opportunities;
//                            $this->_data['modules'][$key]['notes'] = $hit->notes;
//                            $this->_data['modules'][$key]['publish'] = $hit->publish;
//                            $this->_data['modules'][$key]['active'] = $hit->active;
//                            $this->_data['modules'][$key]['subject_id'] = $hit->subject_id;
//                            $this->_data['modules'][$key]['subject_logo'] = Subjects_model::get_subject_logo($hit->subject_id);
//                            $this->_data['modules'][$key]['subject_title'] = substr(Subjects_model::get_subject_logo($hit->subject_id), 0, -4);
//                            $this->_data['modules'][$key]['year_id'] = $hit->year_id;
//                            $this->_data['modules'][$key]['type'] = 'Module';
//                            $this->_data['modules_count'] = count($this->_data['modules']);
//                        }
//                    }
//
//                    if ($hit->search_type == 'lesson') {
//                        //get modules
//                        if ($this->session->userdata('user_type') == 'student') {
//                            $modules = $this->subjects_model->get_allowed_modules_for_student($this->session->userdata('student_year'));
//                            if ($modules) {
//                                $dump = explode(',', $modules['l_id']);
//                            }
//
//                            if (!in_array($hit->lesson_id, $dump)) {
//                                $this->_data['lessons'][$key]['title'] = $hit->title;
//                                $this->_data['lessons'][$key]['module_id'] = $hit->module_id;
//                                $this->_data['lessons'][$key]['teacher_id'] = $hit->teacher_id;
//                                $this->_data['lessons'][$key]['lesson_id'] = $hit->lesson_id;
//                                $this->_data['lessons'][$key]['subject_id'] = $hit->subject_id;
//                                $this->_data['lessons'][$key]['subject_logo'] = Subjects_model::get_subject_logo($hit->subject_id);
//                                $this->_data['lessons'][$key]['subject_title'] = substr(Subjects_model::get_subject_logo($hit->subject_id), 0, -4);
//                                $this->_data['lessons'][$key]['intro'] = $hit->intro;
//                                $this->_data['lessons'][$key]['objectives'] = $hit->objectives;
//                                $this->_data['lessons'][$key]['teaching_activities'] = $hit->teaching_activities;
//                                $this->_data['lessons'][$key]['assessment_opportunities'] = $hit->assessment_opportunities;
//                                $this->_data['lessons'][$key]['type'] = 'Lesson';
//                            }
//                        } else {
//                            $this->_data['lessons'][$key]['title'] = $hit->title;
//                            $this->_data['lessons'][$key]['module_id'] = $hit->module_id;
//                            $this->_data['lessons'][$key]['teacher_id'] = $hit->teacher_id;
//                            $this->_data['lessons'][$key]['subject_id'] = $hit->subject_id;
//                            $this->_data['lessons'][$key]['subject_logo'] = Subjects_model::get_subject_logo($hit->subject_id);
//                            $this->_data['lessons'][$key]['subject_title'] = substr(Subjects_model::get_subject_logo($hit->subject_id), 0, -4);
//                            $this->_data['lessons'][$key]['lesson_id'] = $hit->lesson_id;
//                            $this->_data['lessons'][$key]['intro'] = $hit->intro;
//                            $this->_data['lessons'][$key]['objectives'] = $hit->objectives;
//                            $this->_data['lessons'][$key]['teaching_activities'] = $hit->teaching_activities;
//                            $this->_data['lessons'][$key]['assessment_opportunities'] = $hit->assessment_opportunities;
//                            $this->_data['lessons'][$key]['type'] = 'Lesson';
//                        }
//                    }
//                }
//            }
//        }
//        //print_r($modules);
//        //die();

        $this->_data['resources'] = $this->findResourcesInElastic($query);
        $this->_data['resources_count'] = count($this->_data['resources']);
        $this->_data['modules'] = $this->findModulesInElastic($query);
        $this->_data['modules_count'] = count($this->_data['modules']);
        $this->_data['lessons'] = $this->findLessonsInElastic($query);
        $this->_data['lessons_count'] = count($this->_data['lessons']);

        return $this->_data;
    }

    public function formquery($query = '') {
        if (empty($query)) {
            $data = $this->query($this->input->post('query'));
            $this->parser->parse('s1-results', $data);
        } else {
            $data = $this->query($query);
            return $this->parser->parse('s1-results', $data, TRUE);
        }
    }

    public function delete_document() {
        $index = Zend_Search_Lucene::open(APPPATH . 'search/index');
        $id = $this->input->post('id');
        $hit = $index->getDocument($id);
        $this->resources_model->delete_resource($hit->resource_id);
        $index->delete($id);
    }

    private function getBackUrl($type, $elem_id, $subject_id, $module_id, $lesson_id, $assessment_id) {
        switch ($type) {
            case 'module':
                return "/d4_teacher/index/{$subject_id}/{$elem_id}";
            case 'lesson':
                return "/d5_teacher/index/{$subject_id}/{$module_id}/{$elem_id}";
            case 'content_page':
                return "/e2/index/{$subject_id}/{$module_id}/{$lesson_id}/{$elem_id}";
            case 'question':
                return "/e3/index/{$subject_id}/{$module_id}/{$lesson_id}/{$assessment_id}";
            case 'assignment':
                return "/f2b_teacher/index/{$elem_id}";
            default: // student resource library
                return '/c1';
            //return "/c2/index/resource/{$elem_id}";
        }
    }

    public function save($resource_id, $type, $elem_id = '0', $subject_id = '', $module_id = '', $lesson_id = '', $assessment_id = '') {
        if ($type == 'question') {
            $this->add_question_resource($resource_id, $type, $elem_id, $subject_id, $module_id, $lesson_id, $assessment_id);
        }

        if (!$elem_id) {
            switch ($type) {
                case 'module':
                    $elem_id = $this->modules_model->save(array('active' => '0'));
                    break;
                case 'lesson':
                    $elem_id = $this->lessons_model->save(array('active' => '0'));
                    break;
                case 'content_page':
                    $elem_id = $this->content_page_model->save(array('active' => '0'));
                    break;
                case 'question':
                    // created in /e3
                    break;
                case 'assignment':
                    $elem_id = $this->assignment_model->save(array('active' => '0'));
                    break;
            }
        }

        $this->resources_model->add_resource($type, $elem_id, $resource_id);

        redirect($this->getBackUrl($type, $elem_id, $subject_id, $module_id, $lesson_id, $assessment_id), 'refresh');
    }

    private function add_question_resource($resource_id, $type, $elem_id, $subject_id, $module_id, $lesson_id, $assessment_id) {
        $temp_data = unserialize($this->interactive_assessment_model->get_ia_temp_data($assessment_id));
        $temp_data[$elem_id]['question_resource_id'] = $resource_id;

        $db_data = array(
            'temp_data' => serialize($temp_data)
        );
        $this->interactive_assessment_model->save_temp_data($db_data, $assessment_id);

        redirect($this->getBackUrl($type, $elem_id, $subject_id, $module_id, $lesson_id, $assessment_id), 'refresh');
    }

    private function findModulesInElastic($query) {
        $this->load->model('settings_model');

        $host = $this->settings_model->getSetting('elastic_url');
        $client = new \Elastica\Client(array(
            'host' => $host
        ));

        $search = new \Elastica\Search($client);
        $search->addIndex($this->settings_model->getSetting('elastic_index'))->addType('modules');

        $yearsFilter = null;
        if ($this->session->userdata('user_type') == 'student') {
            $studentSubjectYears = $this->subjects_model->get_student_subject_years($this->session->userdata('student_year'));
            $tempArray = explode(',', $studentSubjectYears['subs']);

            if (count($tempArray) > 0) {
                $yearsFilter = new \Elastica\Filter\Bool();
                foreach ($tempArray as $v) {
                    $year = intval(trim($v));
                    $boolTerm = new \Elastica\Filter\Term(array('year_id' => $year));
                    $yearsFilter->addShould($boolTerm);
                }
            }
        }

        $nameQuery = new \Elastica\Query\Match();
        $nameQuery->setField('name', array(
            'query' => trim($query)
        ));

        $introQuery = new \Elastica\Query\Match();
        $introQuery->setField('intro', array(
            'query' => trim($query)
        ));

        $boolQuery = new \Elastica\Query\Bool();
        $boolQuery->addShould($nameQuery);
        $boolQuery->addShould($introQuery);

        $filteredQuery = new \Elastica\Query\Filtered($boolQuery, $yearsFilter);

        $elasticQuery = new \Elastica\Query();
        $elasticQuery->setQuery($filteredQuery);
        $elasticQuery->setFields(array('_id'));

        $search->setQuery($elasticQuery);

        $results = $search->search();

        $modules = array();

        foreach ($results->getResults() as $result) {
            $module_id = $result->getParam('_id');
            $oModule = $this->modules_model->get_module($module_id);
            $module = $oModule[0];

            if ($module) {
                $modules[$module_id] = array();
                $modules[$module_id]['name'] = $module->name;
                $modules[$module_id]['module_id'] = $module->id;
                $modules[$module_id]['intro'] = $module->intro;
                $modules[$module_id]['objectives'] = $module->objectives;
                $modules[$module_id]['teaching_activities'] = $module->teaching_activities;
                $modules[$module_id]['assessment_opportunities'] = $module->assessment_opportunities;
                $modules[$module_id]['notes'] = $module->notes;
                $modules[$module_id]['publish'] = $module->publish;
                $modules[$module_id]['active'] = $module->active;
                $modules[$module_id]['subject_id'] = $module->subject_id;
                $modules[$module_id]['subject_logo'] = Subjects_model::get_subject_logo($module->subject_id);
                $modules[$module_id]['subject_title'] = substr(Subjects_model::get_subject_logo($module->subject_id), 0, -4);
                $modules[$module_id]['year_id'] = $module->year_id;
                $modules[$module_id]['type'] = 'Module';
            }
        }

        return $modules;
    }

    private function findLessonsInElastic($query) {
        $this->load->model('settings_model');

        $host = $this->settings_model->getSetting('elastic_url');
        $client = new \Elastica\Client(array(
            'host' => $host
        ));

        $search = new \Elastica\Search($client);
        $search->addIndex($this->settings_model->getSetting('elastic_index'))->addType('lessons');

        $modulesFilter = null;
        if ($this->session->userdata('user_type') == 'student') {
            $studentModules = $this->subjects_model->get_allowed_modules_for_student($this->session->userdata('student_year'));
            $tempArray = explode(',', $studentModules['l_id']);

            if (count($tempArray) > 0) {
                $yearsFilter = new \Elastica\Filter\Bool();
                foreach ($tempArray as $v) {
                    $module = intval(trim($v));
                    $boolTerm = new \Elastica\Filter\Term(array('module_id' => $module));
                    $modulesFilter->addShould($boolTerm);
                }
            }
        }

        $titleQuery = new \Elastica\Query\Match();
        $titleQuery->setField('title', array(
            'query' => trim($query)
        ));

        $introQuery = new \Elastica\Query\Match();
        $introQuery->setField('intro', array(
            'query' => trim($query)
        ));

        $boolQuery = new \Elastica\Query\Bool();
        $boolQuery->addShould($titleQuery);
        $boolQuery->addShould($introQuery);

        $filteredQuery = new \Elastica\Query\Filtered($boolQuery, $yearsFilter);

        $elasticQuery = new \Elastica\Query();
        $elasticQuery->setQuery($filteredQuery);
        $elasticQuery->setFields(array('_id'));

        $search->setQuery($elasticQuery);

        $results = $search->search();

        $lessons = array();

        foreach ($results->getResults() as $result) {
            $lesson_id = $result->getParam('_id');
            $lesson = $this->lessons_model->get_lesson($lesson_id);
            $subject_id = $this->modules_model->get_module_subject($lesson->module_id);
            
            if ($lesson) {
                $lessons[$lesson_id] = array();
                $lessons[$lesson_id]['title'] = $lesson->title;
                $lessons[$lesson_id]['module_id'] = $lesson->module_id;
                $lessons[$lesson_id]['teacher_id'] = $lesson->teacher_id;
                $lessons[$lesson_id]['lesson_id'] = $lesson_id;
                $lessons[$lesson_id]['subject_id'] = $subject_id;
                $lessons[$lesson_id]['subject_logo'] = Subjects_model::get_subject_logo($subject_id);
                $lessons[$lesson_id]['subject_title'] = substr(Subjects_model::get_subject_logo($subject_id), 0, -4);
                $lessons[$lesson_id]['intro'] = $lesson->intro;
                $lessons[$lesson_id]['objectives'] = $lesson->objectives;
                $lessons[$lesson_id]['teaching_activities'] = $lesson->teaching_activities;
                $lessons[$lesson_id]['assessment_opportunities'] = $lesson->assessment_opportunities;
                $lessons[$lesson_id]['type'] = 'Lesson';
            }
        }

        return $lessons;
    }

    private function findResourcesInElastic($query) {
        $this->load->model('settings_model');

        $host = $this->settings_model->getSetting('elastic_url');
        $client = new \Elastica\Client(array(
            'host' => $host
        ));

        $search = new \Elastica\Search($client);
        $search->addIndex($this->settings_model->getSetting('elastic_index'))->addType('resources');

        $yearFilter = null;
        if ($this->session->userdata('user_type') == 'student') {
            $yearFilter = new \Elastica\Filter\Term(array('restriction_year' => intval($this->session->userdata('student_year'))));
        }

        $keywordsQuery = new \Elastica\Query\Match();
        $keywordsQuery->setField('keywords', array(
            'query' => trim($query),
            'boost' => 2
        ));

        $nameQuery = new \Elastica\Query\Match();
        $nameQuery->setField('name', array(
            'query' => trim($query),
            'boost' => 1.5
        ));

        $descriptionQuery = new \Elastica\Query\Match();
        $descriptionQuery->setField('description', array(
            'query' => trim($query),
            'boost' => 1
        ));

        $boolQuery = new \Elastica\Query\Bool();
        $boolQuery->addShould($keywordsQuery);
        $boolQuery->addShould($nameQuery);
        $boolQuery->addShould($descriptionQuery);

        $filteredQuery = new \Elastica\Query\Filtered($boolQuery, $yearFilter);

        $elasticQuery = new \Elastica\Query();
        $elasticQuery->setQuery($filteredQuery);
        $elasticQuery->setFields(array('_id'));

        $search->setQuery($elasticQuery);

        $results = $search->search();

        $resources = array();
        foreach ($results->getResults() as $result) {
            $resource_id = $result->getParam('_id');
            $resource = $this->resources_model->get_resource_by_id($resource_id);

            if ($resource) {
                $resources[$resource_id] = array();
                $resources[$resource_id]['title'] = $resource->name;
                $resources[$resource_id]['link'] = $resource->link;
                $resources[$resource_id]['description'] = $resource->description;
                $resources[$resource_id]['id'] = $resource_id;
                $resources[$resource_id]['type'] = $resource->type;
                $resources[$resource_id]['resource_id'] = $resource_id;
                $resources[$resource_id]['preview'] = $this->resoucePreview($resource, '/c1/resource/');

                if ($resource->teacher_id) {
                    $teacher = $this->user_model->get_user($resource->teacher_id);
                } else {
                    $teacher = NULL;
                }
                if ($teacher) {
                    $resources[$resource_id]['user'] = $teacher->first_name . ' ' . $teacher->last_name;
                } else {
                    $resources[$resource_id]['user'] = $resource_id;
                }
            }
        }

        return $resources;
    }

}

?>