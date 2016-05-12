<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class D5_teacher extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('lessons_model');

        $this->load->model('content_page_model');
        $this->load->model('interactive_assessment_model');

        $this->load->model('modules_model');
        $this->load->model('interactive_content_model');
        $this->load->model('resources_model');
        $this->load->model('subjects_model');
        $this->load->library('breadcrumbs');

        $this->load->library('nativesession');
    }

    public function index($subject_id, $year_id, $module_id, $lesson_id = '0') {
        $parent_publish = array();
//        $selected_year = $this->getSelectYearTeacher($this->nativesession, $this->subjects_model, $subject_id, '');
        $selected_year = $this->subjects_model->get_year($year_id);

        $user_type = $this->session->userdata('user_type');
        if ($user_type == 'teacher') {
            $this->_data['curriculum_link'] = 'd5_teacher';
            $this->_data['_header']['firstBack'] = 'saveform';
            $this->_data['_header']['secondback'] = '0';
        } else {
            $this->_data['curriculum_link'] = 'd5_student';
            $this->_data['_header']['back'] = '/d4_student/index/' . $subject_id . '/' . $module_id;
        }

        $this->_data['subject_id'] = $subject_id;
        $this->_data['subject_curriculum_id'] = 0;
        $this->_data['year_id'] = $selected_year->id;
        $this->_data['module_id'] = $module_id;
        $this->_data['lesson_id'] = $lesson_id;

        if ($subject_id) {
            $subject = $this->subjects_model->get_single_subject($subject_id);
            $subject_curriculum = $this->subjects_model->get_main_curriculum($subject_id);
            if (!$subject_curriculum->publish) {
                $parent_publish[] = 'subject';
            }
            $subject_curriculum_year = $this->subjects_model->get_subject_curriculum($subject_id, $selected_year->year);
            if (!$subject_curriculum_year->publish) {
                $parent_publish[] = 'year';
                $this->_data['subject_curriculum_id'] = $subject_curriculum_year->id;
                $this->_data['year_id'] = $selected_year->id;
            }
        }
//echo '<pre>';var_dump( $subject_curriculum_year );die;

        $module = $this->modules_model->get_module($module_id);
        if (!$module[0]->publish) {
            $parent_publish[] = 'module';
        }

        $mod_name = $module[0]->name;
        $mod_name = mb_strlen($mod_name) > 45 ? mb_substr($mod_name, 0, 45) . '...' : $mod_name;

        $interactive_content_exists = $this->interactive_content_model->if_has_assesments($lesson_id);

        if ($lesson_id != 0) {
            if ($interactive_content_exists > 0) {
                $this->_data['create_edit_interactive_lesson'] = '<a href="/e1_teacher/index/' . $subject_id . '/' . $year_id . '/' . $module_id . '/' . $lesson_id . '" class="red_btn">INTERACTIVE SLIDES</a>';
            } else {
                $this->_data['create_edit_interactive_lesson'] = '<a href="/e1_teacher/index/' . $subject_id . '/' . $year_id . '/' . $module_id . '/' . $lesson_id . '" class="red_btn">CREATE INTERACTIVE SLIDES</a>';
            }
        } else {
            $this->_data['create_edit_interactive_lesson'] = '';
        }
        $lesson = $this->lessons_model->get_lesson($lesson_id);

        $this->_data['lesson_title'] = isset($lesson->title) ? $lesson->title : '';
        $this->_data['lesson_intro'] = isset($lesson->intro) ? $lesson->intro : '';
        $this->_data['lesson_objectives'] = isset($lesson->objectives) ? $lesson->objectives : '';
        $this->_data['lesson_teaching_activities'] = isset($lesson->teaching_activities) ? $lesson->teaching_activities : '';
        $this->_data['lesson_assessment_opportunities'] = isset($lesson->assessment_opportunities) ? $lesson->assessment_opportunities : '';
        $this->_data['lesson_notes'] = isset($lesson->notes) ? $lesson->notes : '';
        $this->_data['lesson_intro'] = html_entity_decode($this->_data['lesson_intro']);
        $this->_data['lesson_objectives'] = html_entity_decode($this->_data['lesson_objectives']);
        $this->_data['lesson_teaching_activities'] = html_entity_decode($this->_data['lesson_teaching_activities']);
        $this->_data['lesson_assessment_opportunities'] = html_entity_decode($this->_data['lesson_assessment_opportunities']);
        $this->_data['lesson_notes'] = html_entity_decode($this->_data['lesson_notes']);
        $this->_data['publish'] = isset($lesson->published_lesson_plan) ? $lesson->published_lesson_plan : '0';
        $this->_data['parent_publish'] = implode('/', $parent_publish);

        $this->_data['publish_active'] = '';
        $this->_data['publish_text'] = 'PUBLISH';
        if ($this->_data['publish'] == 1) {
            $this->_data['publish_active'] = 'active';
            $this->_data['publish_text'] = 'PUBLISHED';
        } else {
            $this->_data['publish_active'] = '';
            $this->_data['publish_text'] = 'PUBLISH';
        }

        if (isset($lesson->published_lesson_plan) && $lesson->published_lesson_plan == 1) {
            $this->_data['lesson_publish_0'] = '';
            $this->_data['lesson_publish_1'] = 'selected="selected"';
        } else {
            $this->_data['lesson_publish_0'] = 'selected="selected"';
            $this->_data['lesson_publish_1'] = '';
        }

        if (isset($lesson->interactive_lesson_exists) && $lesson->interactive_lesson_exists) {
            $this->_data['int_lesson_text'] = 'Interactive Lesson';
            $this->_data['int_les_id'] = (isset($int_less_exist->interactive_lesson_id)) ? $int_less_exist->interactive_lesson_id : '';
        } else {
            $this->_data['int_lesson_text'] = 'Create interactive lesson';
            $this->_data['int_les_id'] = '';
        }

        $this->_data['resource_hidden'] = 'hidden';
        if ($lesson_id != 0) { // show resources only for existing lesson
            $resources = $this->resources_model->get_lesson_resources($lesson_id);
            if (!empty($resources)) {
                $arr_download = array( 'pdf', 'png', 'jpg', 'jpeg', 'gif' );
                $this->_data['resource_hidden'] = '';
                foreach ($resources as $k => $v) {
                    $download = '';
                    $ext = end( explode('.', $v->resource_name) );
                    if( in_array($ext, $arr_download) ) {
//                        $download = '<div class="r" style="float: right;margin: -6px 6px;"><a href="/df/index/'.$v->res_id.'" class="" style="font-size: 24px; color: #e74c3c;"><span class="fa fa-download"></span></a></div>';
                    }
                    $this->_data['resources'][$k]['resource_name'] = ( strlen( $v->name ) > 50 ) ? substr( $v->name,0,50 ).'...' : $v->name;
                    $this->_data['resources'][$k]['resource_id'] = $v->res_id;
                    $this->_data['resources'][$k]['preview'] = $this->resoucePreview($v, '/d5_teacher/resource/');
                    $this->_data['resources'][$k]['type'] = $v->type;
                    $this->_data['resources'][$k]['download'] = $download;
                }
            }
            $this->_data['resource2_hidden'] = '';
        } else {
            $this->_data['resource2_hidden'] = 'hidden';
            $this->_data['resource_hidden'] = 'hidden';
        }
        $lesson_title = mb_strlen($lesson->title) > 45 ? mb_substr($lesson->title, 0, 45) . '...' : $lesson->title;

        $less_name = (isset($lesson->title) ? $lesson_title : 'Lesson');
        // breadcrumb code
        $this->breadcrumbs->push('Home', base_url());
        $this->breadcrumbs->push('Subjects', '/d1');
        $this->breadcrumbs->push($subject->name, "/d1a/index/" . $subject_id);
        $this->breadcrumbs->push('Year ' . $selected_year->year, "/d2_teacher/index/" . $subject_id."/".$year_id);
        $this->breadcrumbs->push($mod_name, "/d4_teacher/index/" . $subject_id . "/" . $year_id . "/" . $module_id);
        $this->breadcrumbs->push($less_name, "/");
        $this->_data['breadcrumb'] = $this->breadcrumbs->show();

        $this->_paste_public();
    }

    public function save() {
        $subject_id = $this->input->post('subject_id', true);
        $year_id = $this->input->post('year_id', true);
        $module_id = $this->input->post('module_id', true);
        $lesson_id = $this->input->post('lesson_id', true);

        $db_data = array(
            'title' => trim($this->input->post('lesson_title', true)),
            'intro' => trim($this->input->post('lesson_intro', true)),
            'objectives' => trim($this->input->post('lesson_objectives', true)),
            'teaching_activities' => trim($this->input->post('lesson_teaching_activities', true)),
            'assessment_opportunities' => trim($this->input->post('lesson_assessment_opportunities', true)),
            'notes' => trim($this->input->post('lesson_notes', true)),
            'module_id' => trim($this->input->post('module_id', true)),
            'published_lesson_plan' => trim($this->input->post('publish', true)),
            'active' => '1'
        );

        $lesson_id = $this->lessons_model->save($db_data, $lesson_id);

        $this->indexLessonInElastic($lesson_id);
        
        if ($this->input->post('new_resource', true)) {
            redirect("c1/index/lesson/{$subject_id}/{$year_id}/{$module_id}/{$lesson_id}", 'refresh');
        } else {
            redirect("d5_teacher/index/{$subject_id}/{$year_id}/{$module_id}/{$lesson_id}", 'refresh');
        }
    }

    function saveajax() {
        $dt = $this->input->post('data');

        $dt_ = array();
        foreach ($dt as $k => $v)
            $dt_[$v['name']] = $v['value'];

        if ($dt_) {
            $subject_id = $dt_['subject_id'];
            $curriculum_id = $dt_['subject_curriculum_id'];
            $year_id = $dt_['year_id'];
            $module_id = $dt_['module_id'];
            $lesson_id = $dt_['lesson_id'];
            if ($dt_['publish']) {
                $dt_['publish'] = 0;
                Lessons_model::unpublish_lesson_slides($lesson_id);
            } else {
                $dt_['publish'] = 1;
                if ($dt_['parent_publish'] != '') {
                    $parents = explode('/', $dt_['parent_publish']);
                    $p_data = array('publish' => 1);
                    foreach ($parents as $parent) {
                        switch ($parent) {
                            case 'subject' :
                                $this->db->where('subject_id', $subject_id);
                                $this->db->where('year_id', 0);
                                $this->db->update('curriculum', $p_data);
                                break;
                            case 'year' :
                                $this->subjects_model->save_curriculum($p_data, $subject_id, $curriculum_id, $year_id);
                                break;
                            case 'module' :
                                $module_obj = $this->modules_model->save($p_data, $module_id);
                                break;
                        }
                    }
                }
            }

            $db_data = array(
                'title' => $dt_['lesson_title'],
                'intro' => $dt_['lesson_intro'],
                'objectives' => $dt_['lesson_objectives'],
                'teaching_activities' => $dt_['lesson_teaching_activities'],
                'assessment_opportunities' => $dt_['lesson_assessment_opportunities'],
                'notes' => $dt_['lesson_notes'],
                'module_id' => $dt_['module_id'],
                'published_lesson_plan' => $dt_['publish'],
                'active' => '1'
            );

            $lesson_id = $this->lessons_model->save($db_data, $lesson_id);

            $json['lesson_id'] = $lesson_id;
            $json['publish'] = $dt_['publish'];
            echo json_encode($json);
        }
    }

    public function removeResource() {
        $ass_id = $this->input->post('lesson_id');
        $res_id = $this->input->post('resource_id');
        if ($ass_id && $res_id) {
            $result = $this->resources_model->remove_resource('lesson', $ass_id, $res_id);
            if ($result) {
                echo 1;
            } else {
                echo 0;
            }
        } else {
            echo 0;
        }
        exit();
    }

    public function indexLessonInElastic($lesson_id) {
        $lesson_data = $this->lessons_model->get_lesson(intval($lesson_id));
        if (!$lesson_data) {
            return;
        }
        
        $this->load->model('settings_model');

        $host = $this->settings_model->getSetting('elastic_url');
        $client = new \Elastica\Client(array(
            'host' => $host
        ));

        $index = $client->getIndex($this->settings_model->getSetting('elastic_index'));
        $type = $index->getType('lessons');

        $document = new \Elastica\Document(intval($lesson_id), array(
            'id' => intval($lesson_id),
            'title' => $lesson_data->title,
            'intro' => $lesson_data->intro,
            'teacher_id' => intval($lesson_data->teacher_id),
            'module_id' => intval($lesson_data->module_id),
            'active' => (bool) $lesson_data->active
        ));

        $type->addDocument($document);
        $type->getIndex()->refresh();
    }

    function saveorder() {
        $order_data = json_decode($this->input->post('data'));
        $lesson_id = $this->input->post('lesson_id');
        foreach( $order_data as $k => $res ) {
            $tmp = explode( '_', $res );
            $this->db->update('lessons_resources', array('sorted' => $k+1), array('resource_id' => $tmp[1], 'lesson_id' => $lesson_id));
        }
    }

}
