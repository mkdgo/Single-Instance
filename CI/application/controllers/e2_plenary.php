<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class E2_plenary extends MY_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('content_page_model');
        $this->load->model('interactive_content_model');
        $this->load->model('resources_model');
        $this->load->model('lessons_model');
        $this->load->model('modules_model');
        $this->load->model('subjects_model');
        $this->load->model('plenary_model');
        $this->load->library('nativesession');
        $this->load->library('breadcrumbs');
    }

    function index($subject_id, $module_id, $lesson_id, $cont_page_id = '0') {
        $selected_year = $this->getSelectYearTeacher($this->nativesession, $this->subjects_model, $subject_id, '');

        $this->_data['subject_id'] = $subject_id;
        $this->_data['module_id'] = $module_id;
        $this->_data['lesson_id'] = $lesson_id;
        $this->_data['cont_page_id'] = $cont_page_id;

        $cont_title = "";
        if ($cont_page_id) {
            $cont_page_obj = $this->content_page_model->get_cont_page($cont_page_id);
            $cont_title = (isset($cont_page_obj[0]->title) ? $cont_page_obj[0]->title : '');
        }

        $this->_data['cont_page_title'] = set_value('content_title', $cont_title);
        $this->_data['cont_page_text'] = set_value('content_text', isset($cont_page_obj[0]->text) ? $cont_page_obj[0]->text : '');
        $this->_data['cont_page_templ_id'] = set_value('template_id', isset($cont_page_obj[0]->template_id) ? $cont_page_obj[0]->template_id : '');

        $availablePlenaries = $this->plenary_model->getPlenariesAsResources($module_id, $lesson_id);
        $this->_data['available_plenaries_hidden'] = 'hidden';
        if (!empty($availablePlenaries)) {
            $this->_data['available_plenaries_hidden'] = '';
            foreach ($availablePlenaries as $key => $val) {
                $this->_data['available_plenaries'][$key]['id'] = $val->id;
                $this->_data['available_plenaries'][$key]['label'] = ucfirst($val->plenary_type);
                $this->_data['available_plenaries'][$key]['checked'] = $this->plenary_model->contentPagePlenaryExists($cont_page_id, $val->id) ? ' checked' : '';
            }
        }

        // breadcrumb code
        $this->breadcrumbs->push('Home', base_url());
        $ut = $this->session->userdata('user_type');
        $this->breadcrumbs->push('Subjects', '/d1');
        $subject = $this->subjects_model->get_single_subject($subject_id);
        $this->breadcrumbs->push($subject->name, "/d1a/index/" . $subject_id);
        if ($ut == 'teacher')
            $this->breadcrumbs->push('Year ' . $selected_year->year, "/d2_teacher/index/" . $subject_id);
        $module = $this->modules_model->get_module($module_id);
        $this->breadcrumbs->push($module[0]->name, "/d4_" . $ut . "/index/" . $subject_id . "/" . $module_id);
        $lesson = $this->lessons_model->get_lesson($lesson_id);
        $this->breadcrumbs->push($lesson->title, "/d5_" . $ut . "/index/" . $subject_id . "/" . $module_id . "/" . $lesson_id);
        $this->breadcrumbs->push("Slides", "/e1_" . $ut . "/index/" . $subject_id . "/" . $module_id . "/" . $lesson_id);
        if ($cont_page_id == '0')
            $cont_title = "Create New Slide";
        elseif ($cont_page_id) {
            if (empty($cont_title))
                $cont_title = "Edit Slide";
        }
        $this->breadcrumbs->push($cont_title, "/");
        $this->_data['breadcrumb'] = $this->breadcrumbs->show();

        $this->_data['head_title'] = $cont_title;

        $this->_paste_public();
    }

    public function save() {
        $module_id = $this->input->post('module_id');
        $subject_id = $this->input->post('subject_id');
        $lesson_id = $this->input->post('lesson_id');
        $content_page_id = $this->input->post('cont_page_id');

        $db_data = array(
            'title' => $this->input->post('content_title'),
            'text' => $this->input->post('content_text'),
            'template_id' => 0,
            'lesson_id' => $this->input->post('lesson_id'),
            'active' => '1',
            'slide_type' => 'plenary'
        );

        $db_content_page_id = $this->content_page_model->save($db_data, $content_page_id);
        $this->plenary_model->deleteContentPagePlenary($db_content_page_id);
        if (is_array($this->input->post('available_plenaries'))) {
            foreach ($this->input->post('available_plenaries') as $submittedPlenary) {
                $this->plenary_model->insertContentPagePlenary($db_content_page_id, $submittedPlenary);
            }
        }
        redirect("/e2_plenary/index/{$subject_id}/{$module_id}/{$lesson_id}/{$db_content_page_id}");
    }

    public function delete($subject_id = '', $module_id = '', $lesson_id = '', $cont_page_id = '') {
        $this->_data['module_id'] = $module_id;
        $this->_data['lesson_id'] = $lesson_id;

        $this->plenary_model->deleteContentPagePlenary($cont_page_id);
        $this->content_page_model->delete($cont_page_id);
        redirect('/e1_teacher/index/' . $subject_id . '/' . $module_id . '/' . $lesson_id);
    }

}
