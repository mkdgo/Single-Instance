<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class D4_teacher extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('modules_model');
        $this->load->model('lessons_model');
        $this->load->model('resources_model');
        $this->load->model('lessons_model');
        $this->load->model('subjects_model');

        $this->load->library('nativesession');
        $this->load->library('breadcrumbs');
    }

    function index($subject_id, $year_id, $module_id = false) {
        $parent_publish = array();
//        $selected_year = $this->getSelectYearTeacher($this->nativesession, $this->subjects_model, $subject_id, '');
        $selected_year = $this->subjects_model->get_year($year_id);

        $this->_data['subject_id'] = $subject_id;
        $this->_data['subject_curriculum_id'] = 0;
        $this->_data['year_id'] = $selected_year->id;
        $this->_data['module_id'] = $module_id;

        $mod_name = "New module";
        if($module_id) {
            $module_obj = $this->modules_model->get_module($module_id);
            $mod_name = $module_obj[0]->name;
            $mod_name = mb_strlen($mod_name) > 90 ? mb_substr($mod_name, 0, 90) . '...' : $mod_name;
        }

        if( $subject_id ) {
            $subject = $this->subjects_model->get_single_subject($subject_id);
//            if(!empty($subject))
//                $this->breadcrumbs->push($subject->name, "/d1a/index/" . $subject_id);

            $subject_curriculum = $this->subjects_model->get_main_curriculum($subject_id);
            if(!$subject_curriculum->publish) {
                $parent_publish[] = 'subject';
            }

            $subject_curriculum_year = $this->subjects_model->get_subject_curriculum($subject_id, $selected_year->year);
            if (!$subject_curriculum_year->publish) {
                $parent_publish[] = 'year';
                $this->_data['subject_curriculum_id'] = $subject_curriculum_year->id;
                $this->_data['year_id'] = $selected_year->id;
            }
        }

        $this->_data['module_name'] = set_value('module_name', isset($module_obj[0]->name) ? $module_obj[0]->name : '');

        $this->_data['module_intro'] = set_value('module_intro', isset($module_obj[0]->intro) ? $module_obj[0]->intro : '');
        $this->_data['module_objectives'] = set_value('module_objectives', isset($module_obj[0]->objectives) ? $module_obj[0]->objectives : '');
        $this->_data['module_teaching_activities'] = set_value('module_teaching_activities', isset($module_obj[0]->teaching_activities) ? $module_obj[0]->teaching_activities : '');
        $this->_data['module_assessment_opportunities'] = set_value('module_assessment_opportunities', isset($module_obj[0]->assessment_opportunities) ? $module_obj[0]->assessment_opportunities : '');
        $this->_data['module_notes'] = set_value('module_notes', isset($module_obj[0]->notes) ? $module_obj[0]->notes : '');
        $this->_data['module_intro'] = html_entity_decode($this->_data['module_intro']);
        $this->_data['module_objectives'] = html_entity_decode($this->_data['module_objectives']);
        $this->_data['module_assessment_opportunities'] = html_entity_decode($this->_data['module_assessment_opportunities']);
        $this->_data['module_notes'] = html_entity_decode($this->_data['module_notes']);
        $this->_data['module_teaching_activities'] = html_entity_decode($this->_data['module_teaching_activities']);
//echo '<pre>';var_dump( $this->_data['module_objectives'] );die;

        $this->_data['parent_publish'] = implode('/', $parent_publish);
        $this->_data['publish_active'] = '';
        $this->_data['publish_text'] = 'PUBLISH';
        if(isset($module_obj[0]->publish) && $module_obj[0]->publish == 1) {
            $this->_data['publish_active'] = 'active';
            $this->_data['publish_text'] = 'PUBLISHED';
        } else {
            $this->_data['publish_active'] = '';
            $this->_data['publish_text'] = 'PUBLISH';
        }

        $this->_data['module_publish'] = $module_obj[0]->publish;

        $resources = $this->resources_model->get_module_resources($module_id);

        if(!empty($resources)) {
            $arr_download = array( 'pdf', 'png', 'jpg', 'jpeg', 'gif' );
            $this->_data['resource_hidden'] = '';
            foreach ($resources as $k => $v) {
                $download = '';
                $ext = end( explode('.', $v->resource_name) );
                if( in_array($ext, $arr_download) ) {
//                    $download = '<div class="r" style="float: right;margin: -6px 6px;"><a href="/df/index/'.$v->res_id.'" class="" style="font-size: 24px; color: #e74c3c;"><span class="fa fa-download"></span></a></div>';
                }
                $this->_data['resources'][$k]['resource_name'] = ( strlen( $v->name ) > 50 ) ? substr( $v->name,0,50 ).'...' : $v->name;
                $this->_data['resources'][$k]['resource_id'] = $v->res_id;
                $this->_data['resources'][$k]['preview'] = $this->resoucePreview($v, '/d4_teacher/resource/');
                $this->_data['resources'][$k]['type'] = $v->type;
                $this->_data['resources'][$k]['download'] = $download;
            }
        } else {
            $this->_data['resource_hidden'] = 'hidden';
        }
        if(!$subject_id) {
            $this->_data['module_subject_id'] = set_value('module_subject_id', isset($module_obj[0]->subject_id) ? $module_obj[0]->subject_id : '');
        } else {
            $this->_data['module_subject_id'] = $subject_id;
        }

        if($module_id) {
            $lessons = $this->lessons_model->get_lessons_by_module(array('module_id' => $module_id));
        } else {
            $lessons = '';
        }

        if(empty($lessons)) {
            $this->_data['hide_lessons'] = 'hidden';
        } else {
            $this->_data['hide_lessons'] = '';
        }

        if($module_id) {
            $this->_data['add_new_lesson'] = ' <button type="submit" class="btn b1 right" onclick=" $(\'#new_lesson\').val(1);">ADD NEW LESSON<span class="icon i3"></span></button>';
            $this->_data['hide2_lessons'] = '';
        } else {
            $this->_data['add_new_lesson'] = '';
            $this->_data['hide2_lessons'] = 'hidden';
        }

        $this->_data['hide_add_lesson'] = $module_id ? '' : 'hidden';
        if(!empty($lessons)) {
            foreach ($lessons as $lesson) {
                $lesson_id = $lesson->id;
                $this->_data['lessons'][$lesson_id]['lesson_id'] = $lesson_id;
                $this->_data['lessons'][$lesson_id]['lesson_title'] = $lesson->title;
            }
        }
        // breadcrumb code
        $this->breadcrumbs->push('Home', base_url());
        $this->breadcrumbs->push('Subjects', '/d1');
        $this->breadcrumbs->push($subject->name, "/d1a/index/" . $subject_id);
        $this->breadcrumbs->push('Year ' . $selected_year->year, "/d2_teacher/index/" . $subject_id."/".$year_id);
        $this->breadcrumbs->push($mod_name, "/");
        $this->_data['breadcrumb'] = $this->breadcrumbs->show();
        // end breadcrumb code

        $this->_paste_public();
    }

    function save() {
//echo '<pre>';var_dump( $_POST );die;
        $subject_id = $this->input->post('subject_id', true);
        $module_id = $this->input->post('module_id', true);
        $year_id = $this->input->post('year_id', true);

//        $selected_year = $this->getSelectYearTeacher($this->nativesession, $this->subjects_model, $subject_id, '');
        $selected_year = $this->subjects_model->get_year($year_id);

        $db_data = array(
            'name' => trim($this->input->post('module_name', true)),
            'intro' => trim($this->input->post('module_intro', true)),
            'objectives' => trim($this->input->post('module_objectives', true)),
            'teaching_activities' => trim($this->input->post('module_teaching_activities', true)),
            'assessment_opportunities' => trim($this->input->post('module_assessment_opportunities', true)),
            'notes' => trim($this->input->post('module_notes', true)),
            'publish' => trim($this->input->post('publish', true)),
            'active' => '1',
            'subject_id' => trim($this->input->post('subject_id', true)),
            'year_id' => $selected_year->id
        );

        $module_id = $this->modules_model->save($db_data, $module_id);

        $this->indexModuleInElastic($module_id, $db_data);
        
        if ($this->input->post('new_lesson', true)) {
            redirect("d5_teacher/index/{$subject_id}/{$year_id}/{$module_id}", 'refresh');
        } elseif ($this->input->post('new_resource', true)) {
            redirect("c1/index/module/{$subject_id}/{$year_id}/{$module_id}", 'refresh');
        } else {
            redirect("d4_teacher/index/{$subject_id}/{$year_id}/{$module_id}", 'refresh');
        }
    }

    function saveajax() {
        $dt = $this->input->post('data');

        $dt_ = array();

        foreach ($dt as $k => $v)
            $dt_[$v['name']] = $v['value'];

        if( $dt_ ) {
            $subject_id = $dt_['subject_id'];
            $curriculum_id = $dt_['subject_curriculum_id'];
            $year_id = $dt_['year_id'];
            $module_id = $dt_['module_id'];

//            $selected_year = $this->getSelectYearTeacher($this->nativesession, $this->subjects_model, $subject_id, '');
            $selected_year = $this->subjects_model->get_year($year_id);

            if ($dt_['publish']) {
                $dt_['publish'] = 0;
                Lessons_model::unpublish_module_lessons($module_id);
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
                        }
                    }
                }
            }
            $db_data = array(
                'name' => $dt_['module_name'],
                'intro' => $dt_['module_intro'],
                'objectives' => $dt_['module_objectives'],
                'teaching_activities' => $dt_['module_teaching_activities'],
                'assessment_opportunities' => $dt_['module_assessment_opportunities'],
                'notes' => $dt_['module_notes'],
                'publish' => $dt_['publish'],
                'active' => '1',
                'subject_id' => $dt_['subject_id'],
                'year_id' => $selected_year->id
            );

            $module_id = $this->modules_model->save($db_data, $module_id);
        }
        $json['module_id'] = $module_id;
        $json['publish'] = $dt_['publish'];

        echo json_encode($json);
    }

    public function deleteModule($subject_id = '', $module_id = '') {

        //$this->_data['lesson_id'] = $lesson_id;

        $content_pages = $this->interactive_content_model->get_il_content_pages($lesson_id);
        foreach ($content_pages as $kay => $val)
            $this->content_page_model->delete($val->id);

        $int_assessments = $this->interactive_content_model->get_il_int_assesments($lesson_id);
        foreach ($int_assessments as $assessment_key => $assessment) {
            $questions = $this->interactive_assessment_model->get_ia_questions($assessment->id);
            foreach ($questions as $question)
                $this->interactive_assessment_model->delete_answers($question->id);

            $this->interactive_assessment_model->delete_questions($assessment->id);

            $this->interactive_assessment_model->delete_int_assessment($assessment->id);
        }
        $this->lessons_model->delete($lesson_id);


        redirect('/d2_teacher/index/' . $subject_id."/".$year_id);
    }

    public function removeResource() {
        $ass_id = $this->input->post('module_id');
        $res_id = $this->input->post('resource_id');
        if ($ass_id && $res_id) {
            $result = $this->resources_model->remove_resource('module', $ass_id, $res_id);
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

    public function indexModuleInElastic($module_id, $module_data) {
//return false;
        $this->load->library('storage'); // needs for elastica
        $this->load->model('settings_model');

        $host = $this->_elastic['url'];
//        $host = 'oupsh8jetr:nvvy1krdnu@ediface-5711837249.eu-west-1.bonsai.io';
//        $host = 'search-edifacedev-67ohmfcpr7ig7x5tc3ybdygs2m.eu-central-1.es.amazonaws.com';
        $client = new \Elastica\Client(array(
            'host' => $host,
            'port' => '80',
            'transport' => 'AwsAuthV4',
            'aws_region' => 'eu-central-1',
            'aws_access_key_id' => 'AKIAIRMCG6PRQHYH2RDA',
            'aws_secret_access_key' => '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',
        ));

//        $index = $client->getIndex( $this->_elastic['index'] );
        $index = $client->getIndex($this->settings_model->getSetting('elastic_index'));
        $type = $index->getType('modules');

        $document = new \Elastica\Document(intval($module_id), array(
            'id' => intval($module_id),
            'name' => $module_data['name'],
            'intro' => $module_data['intro'],
            'publish' => (bool) $module_data['publish'],
            'active' => (bool) $module_data['active'],
            'subject_id' => intval($module_data['subject_id']),
            'year_id' => intval($module_data['year_id'])
        ));

        $type->addDocument($document);
        $type->getIndex()->refresh();
    }

    function saveorder() {
        $order_data = json_decode($this->input->post('data'));
        $module_id = $this->input->post('module_id');
        foreach( $order_data as $k => $res ) {
            $tmp = explode( '_', $res );
            $this->db->update('modules_resources', array('sorted' => $k+1), array('resource_id' => $tmp[1], 'module_id' => $module_id));
        }
    }

}
