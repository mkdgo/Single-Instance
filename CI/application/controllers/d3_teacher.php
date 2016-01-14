<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class D3_teacher extends MY_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('modules_model');
        $this->load->model('lessons_model');
        $this->load->model('subjects_model');
        $this->load->model('resources_model');
        $this->load->library('breadcrumbs');

        $this->load->library( 'nativesession' );
    }

//    function index($subject_id = '', $year_id='') {
    function index($subject_id, $year_id ) {
        $parent_publish = array();
        $this->_data['subject_id'] = $subject_id;
        $this->_data['year_id'] = $year_id;
        
        $selected_year = $this->subjects_model->get_year($year_id);

        $subject = $this->subjects_model->get_single_subject($subject_id);

        $subject_curriculum = $this->subjects_model->get_subject_curriculum($subject_id,$year_id);

        $this->_data['subject_curriculum_id'] = $subject_curriculum->id;
        $this->_data['subject_title'] = html_entity_decode ( $subject->name );
        $this->_data['subject_intro'] = html_entity_decode ( $subject_curriculum->intro );
        $this->_data['subject_objectives'] = html_entity_decode ( $subject_curriculum->objectives );
        $this->_data['subject_teaching_activities'] = html_entity_decode ( $subject_curriculum->teaching_activities );
        $this->_data['subject_assessment_opportunities'] = html_entity_decode ( $subject_curriculum->assessment_opportunities );
        $this->_data['subject_notes'] = html_entity_decode ( $subject_curriculum->notes );
        $this->_data['subject_publish'] = $subject_curriculum->publish;
        
        $this->_data['publish_active'] = '';
        $this->_data['publish_text'] = 'PUBLISH';
        if( $this->_data['subject_publish'] == 1 ) {
            $this->_data['publish_active'] = 'active';
            $this->_data['publish_text'] = 'PUBLISHED';
        } else {
            $this->_data['publish_active'] = '';
            $this->_data['publish_text'] = 'PUBLISH';
        }

//        $selected_year = $this->getSelectYearTeacher($this->nativesession, $this->subjects_model, $subject_id, '');

        if($subject_id){
            $modules = $this->modules_model->get_modules($subject_id, $selected_year->id);
//            $modules = $this->modules_model->get_modules($subject_id, $year_id);

            $subject_curriculum = $this->subjects_model->get_main_curriculum($subject_id);
            if( !$subject_curriculum->publish ) {
                $parent_publish[] = 'subject';
            }
        } else {
            $modules = 0;
        }

        $this->_data['parent_publish'] = implode( '/', $parent_publish );

        if(count($modules)==0){
            $this->_data['hide_modules'] = 'hidden';
            $this->_data['modules'] = array();
        } else {
            $this->_data['hide_modules'] = '';
        }
        $odd=0;
        foreach($modules as $module){
            $module_id = $module->id;
            $this->_data['modules'][$module_id]['module_id'] = $module_id;
            $this->_data['modules'][$module_id]['module_name'] = $module->name;
            if($odd%2==0){  
                $this->_data['modules'][$module_id]['float'] = 'moduleLeft';
                $this->_data['modules'][$module_id]['clear'] = '';
            }else{
                $this->_data['modules'][$module_id]['float'] = 'moduleRight';
                $this->_data['modules'][$module_id]['clear'] = '<div class="clear"></div>';
            }
            $odd++;

            $lessons = $this->lessons_model->get_lessons_by_module(array('module_id' => $module_id));
            if(empty($lessons)){
                $this->_data['modules'][$module_id]['hide_lessons'] = 'hidden';
            }else{
                $this->_data['modules'][$module_id]['hide_lessons'] = '';
            }
            foreach($lessons as $lesson){
                $lesson_id = $lesson->id;
                $this->_data['modules'][$module_id]['lessons'][$lesson_id]['lesson_id'] = $lesson_id;
                $this->_data['modules'][$module_id]['lessons'][$lesson_id]['lesson_title'] = $lesson->title;
            }
        }
        $this->breadcrumbs->push('Home', base_url());
        $this->breadcrumbs->push('Subjects', '/d1');
        $this->breadcrumbs->push($subject->name, "/d1a/index/".$subject_id);
        $this->breadcrumbs->push('Year '.$selected_year->year, "/d2_teacher/index/".$subject_id."/".$this->_data['year_id']);
//        $this->breadcrumbs->push('Year '.$selected_year->year, "/d2_teacher/index/".$subject_id);
        $this->breadcrumbs->push("Curriculum", "/");

        $this->_data['breadcrumb'] = $this->breadcrumbs->show();
        $this->_paste_public();
    }

    function save() {

        $subject_id = $this->input->post('subject_id', true);
        $year_id = $this->input->post('year_id', true);
        $curriculum_id = $this->input->post('subject_curriculum_id', true);
        $db_data = array(
            'intro' => trim($this->input->post('subject_intro', true)),
            'objectives' => trim($this->input->post('subject_objectives', true)),
            'teaching_activities' => trim($this->input->post('subject_teaching_activities', true)),
            'assessment_opportunities' => trim($this->input->post('subject_assessment_opportunities', true)),
            'notes' => trim($this->input->post('subject_notes', true)),
            'publish' => $this->input->post('publish')
        );

        $this->subjects_model->save_curriculum($db_data, $subject_id,$curriculum_id,$year_id);

        if( $this->input->post('new_module', true) ) {
            redirect("d4_teacher/index/{$subject_id}/{$year_id}", 'refresh'); 
        }  else {
            redirect("d3_teacher/index/{$subject_id}/{$year_id}", 'refresh');
        }
    }

    function saveajax() {
        $dt = $this->input->post('data');
        $dt_ = array();

        foreach( $dt as $k => $v ) {
            $dt_[$v['name']] = $v['value'];
        }
        if( $dt_ ) {
            $subject_id = $dt_['subject_id'];
            $curriculum_id = $dt_['subject_curriculum_id'];
            if( $dt_['publish'] ) {
                $dt_['publish'] = 0;
                Subjects_model::unpublish_modules( $subject_id, $dt_['year_id'] );
            } else {
                $dt_['publish'] = 1;
                if( $dt_['parent_publish'] != '' ) {
                    $parents = explode( '/', $dt_['parent_publish'] );
                    $p_data = array( 'publish' => 1);
                    foreach( $parents as $parent ) {
                        switch( $parent ) {
                            case 'subject' : 
                                $this->db->where('subject_id', $subject_id);
                                $this->db->where('year_id', 0);
                                $this->db->update('curriculum', $p_data); 
                                break;
                        }
                    }
                }
            }

            $db_data = array(
                'intro' => $dt_['subject_intro'],
                'objectives' => $dt_['subject_objectives'],
                'teaching_activities' => $dt_['subject_teaching_activities'],
                'assessment_opportunities' => $dt_['subject_assessment_opportunities'],
                'notes' => $dt_['subject_notes'],
                'publish' => $dt_['publish']
            );
            $this->subjects_model->save_curriculum($db_data, $subject_id,$curriculum_id, $dt_['year_id']);

            echo json_encode( $dt_['publish'] );
        }
    }
}

