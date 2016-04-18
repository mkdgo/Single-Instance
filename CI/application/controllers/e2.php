<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class E2 extends MY_Controller {
    public $_student_disabled = false;
	function __construct() {
		parent::__construct();

		$this->load->model('content_page_model');
		$this->load->model('interactive_content_model');
		$this->load->model('resources_model');
		$this->load->model('lessons_model');
		$this->load->model('modules_model');
		$this->load->model('subjects_model');
        $this->load->library( 'nativesession' );
        $this->load->library('breadcrumbs');

        if( $this->user_type == 'student' ) {
            $this->_student_disabled = true;
            $this->_data['student_disabled'] = $this->_student_disabled;
        }
	}

	function index($subject_id, $year_id, $module_id, $lesson_id, $cont_page_id = '0') {
		
//        $selected_year = $this->getSelectYearTeacher($this->nativesession, $this->subjects_model, $subject_id, '');
        $selected_year = $this->subjects_model->get_year($year_id);

        $this->_data['subject_id'] = $subject_id;
        $this->_data['year_id'] = $year_id;
		$this->_data['module_id'] = $module_id;
		$this->_data['lesson_id'] = $lesson_id;
		$this->_data['cont_page_id'] = $cont_page_id;

		$cont_title = "";
		if( $cont_page_id ) {
			$cont_page_obj = $this->content_page_model->get_cont_page($cont_page_id);
			$cont_title = (isset($cont_page_obj[0]->title) ? $cont_page_obj[0]->title : '');
		}
		
		$this->_data['cont_page_title'] = set_value('content_title', $cont_title);
		$this->_data['cont_page_text'] = set_value('content_text', isset($cont_page_obj[0]->text) ? $cont_page_obj[0]->text : '');
        $this->_data['cont_page_title'] = html_entity_decode ( $this->_data['cont_page_title'] );
        $this->_data['cont_page_text'] = html_entity_decode ( $this->_data['cont_page_text'] );
		$this->_data['cont_page_templ_id'] = set_value('template_id', isset($cont_page_obj[0]->template_id) ? $cont_page_obj[0]->template_id : '');

		$resources = $this->resources_model->get_cont_page_resources($cont_page_id);
		if (!empty($resources)) {
			$this->_data['resource_hidden'] = '';
			foreach ($resources as $k => $v) {
				$this->_data['resources'][$k]['resource_name'] = $v->name;
				$this->_data['resources'][$k]['resource_id'] = $v->res_id;
//                $this->_data['resources'][$k]['preview'] = $this->resoucePreviewFullscreen( $v, '/e2/resource/' );
                $this->_data['resources'][$k]['preview'] = $this->resoucePreview( $v, '/e2/resource/' );
				$this->_data['resources'][$k]['type'] = $v->type;
			}
		} else {
			$this->_data['resource_hidden'] = 'hidden';
		}
//die('hi');
		// Breadcrumb code
        $this->breadcrumbs->push('Home', base_url());
		$ut = $this->session->userdata('user_type');
		$this->breadcrumbs->push('Subjects', '/d1');

		$subject = $this->subjects_model->get_single_subject($subject_id);
		$this->breadcrumbs->push($subject->name, "/d1a/index/".$subject_id);

        $module = $this->modules_model->get_module($module_id);
        $lesson = $this->lessons_model->get_lesson($lesson_id);
        if($ut=='teacher') {
            $this->breadcrumbs->push('Year '.$selected_year->year, "/d2_teacher/index/".$subject_id."/".$year_id);
            $this->breadcrumbs->push($module[0]->name, "/d4_teacher/index/".$subject_id."/".$year_id."/".$module_id);
            $this->breadcrumbs->push($lesson->title, "/d5_teacher/index/".$subject_id."/".$year_id."/".$module_id."/".$lesson_id);
            $this->breadcrumbs->push("Slides", "/e1_teacher/index/".$subject_id."/".$year_id."/".$module_id."/".$lesson_id);
        } else {
            $this->breadcrumbs->push($module[0]->name, "/d4_student/index/".$subject_id."/".$module_id);
            $this->breadcrumbs->push($lesson->title, "/d5_student/index/".$subject_id."/".$module_id."/".$lesson_id);
            $this->breadcrumbs->push("Slides", "/e1_student/index/".$subject_id."/".$module_id."/".$lesson_id);
        }

		if( $cont_page_id == '0' ) {
			$cont_title = "Create New Slide";
		} elseif( $cont_page_id ) {
			if( empty($cont_title) ) {
                $cont_title = "Edit Slide";
            }
		}

		$this->breadcrumbs->push($cont_title, "/");
		$this->_data['breadcrumb'] = $this->breadcrumbs->show();

        $this->_data['head_title'] = $cont_title;

		$this->_paste_public();
	}

	public function save() {
        $subject_id = $this->input->post('subject_id');
        $year_id = $this->input->post('year_id');
		$module_id = $this->input->post('module_id');
		$lesson_id = $this->input->post('lesson_id');
		$cont_page_id = $this->input->post('cont_page_id');
		
		$db_data = array(
			'title' => $this->input->post('content_title'),
			'text' => $this->input->post('content_text'),
			'template_id' => $this->input->post('template_id'),
			'lesson_id' => $this->input->post('lesson_id'),
			'active' => '1',
		);

		//log_message('error', implode(",", array_keys($db_data))."-".implode(",", $db_data));
		$cont_page_id = $this->content_page_model->save($db_data, $cont_page_id);

		if ($this->input->post('is_preview') == 1)
			redirect("/e5_teacher/index/{$subject_id}/{$year_id}/{$module_id}/{$lesson_id}/1/view/{$cont_page_id}");
		elseif ($this->input->post('is_preview') == 2)
			redirect("/c1/index/content_page/{$subject_id}/{$year_id}/{$module_id}/{$lesson_id}/{$cont_page_id}");
		else { // 'save' action
			$this->session->set_flashdata('msg','Slide created successfully ');
			redirect("/e1_teacher/index/{$subject_id}/{$year_id}/{$module_id}/{$lesson_id}");
		}
	}

	public function delete($subject_id = '', $year_id = '', $module_id = '', $lesson_id = '', $cont_page_id = '') {
		$this->_data['module_id'] = $module_id;
		$this->_data['lesson_id'] = $lesson_id;

		$this->content_page_model->delete($cont_page_id);
		redirect('/e1_teacher/index/'. $subject_id . '/' . $module_id . '/' . $lesson_id);
	}

    public function removeResource() {
        $ass_id = $this->input->post('cont_page_id');
        $res_id = $this->input->post('resource_id');
        if( $ass_id && $res_id ) {
            $result = $this->resources_model->remove_resource( 'content_page', $ass_id, $res_id  );
            if( $result ) {
                echo 1;
            } else {
                echo 0;
            }
        } else {
            echo 0;
        }
        exit();
    }

}