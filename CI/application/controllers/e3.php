<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class E3 extends MY_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('interactive_assessment_model');
        $this->load->model('resources_model');
        $this->load->model('lessons_model');
        $this->load->model('modules_model');
        $this->load->model('subjects_model');
        $this->load->library( 'nativesession' );
        $this->load->library('breadcrumbs');
        $this->load->library('resource');
    }

    function index($subject_id = '', $year_id = '',$module_id = '', $lesson_id = '', $int_assessment_id = '0') {
//	function index($subject_id = '', $year_id = '',$module_id = '', $lesson_id = '', $cont_page_id = '0' ) {

        $resource = new Resource();

		$this->_data['subject_id'] = $subject_id;
        $this->_data['year_id'] = $year_id;
		$this->_data['module_id'] = $module_id;
        $this->_data['lesson_id'] = $lesson_id;
                
/*        $selected_year = $this->getSelectYearTeacher($this->nativesession, $this->subjects_model, $subject_id, '');*/
        $selected_year = $this->subjects_model->get_year($year_id);
            
                
		if( !$int_assessment_id ) {
			$int_assessment_data = array(
				'lesson_id' => $lesson_id
			);
//			$this->interactive_assessment_model->create_int_assessment($int_assessment_data);
//            $this->_data['int_assessment_id'] = $this->db->insert_id();
			$this->_data['int_assessment_id'] = $this->db->insert_id();
		} else {
			$this->_data['int_assessment_id'] = $int_assessment_id;
		}
		
		$this->unserialize_assessment($int_assessment_id);
		$this->_data['questions'] = $this->tmp_data['questions'];
		
		// breadcrumb code
        $this->breadcrumbs->push('Home', base_url());

		$ut = $this->session->userdata('user_type');
		$this->breadcrumbs->push('Subjects', '/d1');

		$subject = $this->subjects_model->get_single_subject($subject_id);
		$this->breadcrumbs->push($subject->name, "/d1a/index/".$subject_id);

        if($ut=='teacher') {
            $this->breadcrumbs->push('Year '.$selected_year->year, "/d2_teacher/index/".$subject_id."/".$year_id);
        }
                
		$module = $this->modules_model->get_module($module_id);
		$this->breadcrumbs->push($module[0]->name, "/d4_".$ut."/index/".$subject_id."/".$year_id."/".$module_id);

		$lesson = $this->lessons_model->get_lesson($lesson_id);
		$this->breadcrumbs->push($lesson->title, "/d5_".$ut."/index/".$subject_id."/".$year_id."/".$module_id."/".$lesson_id);

		$this->breadcrumbs->push("Slides", "/e1_".$ut."/index/".$subject_id."/".$year_id."/".$module_id."/".$lesson_id);

		$ass_title = "";
		if ($int_assessment_id == '0') {
            $ass_title = "New interactive assessment";
        } elseif ($int_assessment_id) {
			if (empty($ass_title))
				$ass_title = "Edit interactive assessment";
		}

        if( $int_assessment_id == '0' ) {
            $cont_title = "Create New Interactive Quiz";
        } elseif( $int_assessment_id ) {
            if( empty($cont_title) ) {
                $cont_title = "Edit Interactive Quiz";
            }
        }

		$this->breadcrumbs->push($ass_title, "/");
		$this->_data['breadcrumb'] = $this->breadcrumbs->show();
		// end breadcrumb code
        $this->_data['head_title'] = $cont_title;

		$this->_paste_public();
	}

	public function save() {
        $subject_id = $this->input->post('subject_id');
		$year_id = $this->input->post('year_id');
		$module_id = $this->input->post('module_id');
		$lesson_id = $this->input->post('lesson_id');
		$int_assessment_id = $this->input->post('int_assessment_id');
		$form_questions = $this->input->post('questions');

		// delete questions + answers
		$this->interactive_assessment_model->delete_questions($int_assessment_id);

		foreach ($form_questions as $question) {
			if (!empty($question['question_resource_id'])) {
				$res_id = $question['question_resource_id'];
			} else {
				$res_id = NULL;
			}

			$question_arr = array(
				'int_assessment_id' => $int_assessment_id,
				'question_text' => $question['question_text'],
				'resource_id' => $res_id
			);

			$this->interactive_assessment_model->save_question($question_arr);
			$qestion_id = $this->db->insert_id();

			foreach ($question['answers'] as $answer) {
				$answer_arr = array(
					'question_id' => $qestion_id,
					'answer_text' => $answer['answer_text'],
					'answer_true' => $answer['answer_true']
				);

				$this->interactive_assessment_model->save_answer($answer_arr);
			}
		}

		$db_data = array(
			'temp_data' => ''
		);

		$this->interactive_assessment_model->save_temp_data($db_data, $int_assessment_id);

		redirect('/e1_teacher/index/' . $subject_id . '/' . $year_id . '/' . $module_id . '/' . $lesson_id);
	}

	public function delete_assessment($subject_id = '', $year_id = '', $module_id = '', $lesson_id = '', $assessment_id = '') {
        $this->_data['subject_id'] = $subject_id;
		$this->_data['year_id'] = $year_id;
		$this->_data['module_id'] = $module_id;
		$this->_data['lesson_id'] = $lesson_id;

		$this->interactive_assessment_model->delete_int_assessment($assessment_id);
		redirect('/e1_teacher/index/' . $subject_id . '/' . $year_id . '/' . $module_id . '/' . $lesson_id);
	}

}