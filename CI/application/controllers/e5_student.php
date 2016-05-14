<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class E5_student extends MY_Controller {

	function __construct() {
		parent::__construct();

        $this->load->model('user_model');
        $this->load->model('subjects_model');
		$this->load->model('lessons_model');
		$this->load->model('interactive_content_model');
		$this->load->model('interactive_assessment_model');
        $this->load->model('student_answers_model');
		$this->load->model('resources_model');
	}

	function index($subject_id = '', $module_id = '', $lesson_id = '', $page_num = 1, $type = 'view') {
		$this ->_data['subject_id'] = $subject_id;
		$this ->_data['module_id'] = $module_id;
		$this ->_data['lesson_id'] = $lesson_id;

        $lesson = $this->lessons_model->get_lesson($lesson_id);
        $token = json_decode( $lesson->token, true );
        $this->_data['teacher_id'] = $lesson->teacher_id;
        $this->_data['lesson_title'] = $lesson->title;
        $this->_data['teacher_name'] = User_model::getUserName($lesson->teacher_id);
        $this->_data['subject_name'] = Subjects_model::get_subject_title( $subject_id );
        $student_class = $this->user_model->get_student_class_by_subject($this->session->userdata('id'), $subject_id);
        $this->_data['year'] = $student_class->year;
        $this->_data['class_id'] = $student_class->class_id;
        $this->_data['class_name'] = $student_class->class_name;

        if( is_null($token) ) {
            $token['secret'] = '';
            $token['socketId'] = time();
        }
        $this->_data['secret'] = $token['secret'];
        $this->_data['socketId'] = $token['socketId'];
		if (empty($lesson)) {
			show_404();
		}

		$content_pages = $this->interactive_content_model->get_il_content_pages($lesson_id);
		$this -> _data['content_pages'] = array();
		foreach ($content_pages as $key => $val) {
			$this -> _data['content_pages'][$key]['cont_page_id'] = $val -> id;
			$this -> _data['content_pages'][$key]['cont_page_title'] = $val -> title;
			$this -> _data['content_pages'][$key]['cont_page_text'] = $val -> text;
			$this -> _data['content_pages'][$key]['cont_page_template_id'] = $val -> template_id;
			$this -> _data['content_pages'][$key]['resources'] = array();
			$resources = $this -> resources_model -> get_cont_page_resources($val -> id);
			foreach ($resources as $k => $v) {
				$this->_data['content_pages'][$key]['resources'][$k]['resource_name'] = $v -> name;
				$this->_data['content_pages'][$key]['resources'][$k]['resource_id'] = $v -> res_id;
                $this->_data['content_pages'][$key]['resources'][$k]['fullscreen'] = $this->resoucePreviewFullscreen($v, '/e5_student/resource/');
//                $this->_data['content_pages'][$key]['resources'][$k]['fullscreen'] = $this->resoucePreviewFullscreen($v, '/c1/resource/');
				if ($v->type =="video" && !$lesson -> teacher_led) {
					$this -> _data['content_pages'][$key]['resources'][$k]['preview'] = "<div class='teacherledvideo'>This video is being played on your teacher's screen.</div>";
                    $this->_data['content_pages'][$key]['resources'][$k]['slide_click'] = "return false;";
				} else {
                    if( !$this->student_answers_model->isExist( $this->session->userdata('id'), $v->res_id, $lesson_id, $val->id, 'online' ) ) {
                        $this ->_data['content_pages'][$key]['resources'][$k]['preview'] = $this -> resoucePreview($v, '/e5_student/resource/');
                        $this->_data['content_pages'][$key]['resources'][$k]['slide_click'] = "return false;";
//                    } elseif( $this->_data['marked'] == 0 ) {
//                        $this ->_data['content_pages'][$key]['resources'][$k]['preview'] = $this -> resoucePreview($v, '/e5a_student/resource/');
                    } else {
                        $this ->_data['content_pages'][$key]['resources'][$k]['preview'] = $this -> resoucePreview($v, '/e5a_student/resource/');
                        $this->_data['content_pages'][$key]['resources'][$k]['slide_click'] = "setResult(".$v->res_id.")";
                    }


				}
			}
			$ITEMS[]=Array(
			'cont_page_id'=>$val->id,
			'cont_page_title'=>$val->title,
			'cont_page_text'=>$val->text,
			'cont_page_template_id'=>$val->template_id,
			'resources'=>$this->_data['content_pages'][$key]['resources'],
			'questions'=>array(),
			'item_order'=>$val->order);
		}
		$int_assessments = $this -> interactive_content_model -> get_il_int_assesments($lesson_id);
		$this ->_data['int_assessments'] = array();

		foreach ($int_assessments as $key => $val) {
			$this -> _data['int_assessments'][$key]['assessment_id'] = $val -> id;
			$this -> unserialize_assessment($val -> id);
			$this -> _data['int_assessments'][$key] = $this -> tmp_data;
			$ITEMS[]=Array(
			'cont_page_id'=>'',
			'cont_page_title'=>''.print_r($this->_data['int_assessments'][$key][0],false),
			'cont_page_text'=>'',
			'cont_page_template_id'=>'',
			'preview'=>'',
			'resources'=>array(),
			//'questions'=>$this->_data['int_assessments'][$key][0],
			'questions'=>array(),
			'item_order'=>$val->order);
		}

		$teacher_led = !$lesson -> teacher_led;
		$this->_data['close'] = "/e1_student/index/{$subject_id}/{$module_id}/{$lesson_id}";
		$this->_data['close_text'] = 'Close Lesson';
		$this->_data['running'] = !$lesson->teacher_led;
		// $type == 'running' &&
		/*
		 $this->_data['prev'] = "/e5_student/index/{$subject_id}/{$module_id}/{$lesson_id}/" . ($page_num - 1) . ($type != 'view' ? '/' . $type : '');
		 $this->_data['next'] = "/e5_student/index/{$subject_id}/{$module_id}/{$lesson_id}/" . ($page_num + 1) . ($type != 'view' ? '/' . $type : '');
		 $this->_data['prev_hidden'] = ($page_num == 1 || $teacher_led) ? 'hidden' : '';
		 $this->_data['next_hidden'] = ($page_num >= count($this->_data['content_pages']) + count($this->_data['int_assessments']) || $teacher_led) ? 'hidden' : '';
		 $this->_data['close_hidden'] = $teacher_led ? 'hidden' : '';
		 $this->_data['call_active'] = $teacher_led ? 'true' : 'false';

		 if ($page_num <= count($this -> _data['content_pages'])) {
		 $this -> _data['content_pages'] = array($this -> _data['content_pages'][$page_num - 1]);
		 $this -> _data['int_assessments'] = array();
		 } elseif ($page_num <= (count($this -> _data['content_pages']) + count($this -> _data['int_assessments']))) {
		 //log_message('error', "ci = ".($page_num - count($this->_data['content_pages']) - 1)."; all cnt = ".count($this->_data['int_assessments']));
		 $this -> _data['int_assessments'] = array($this -> _data['int_assessments'][$page_num - count($this -> _data['content_pages']) - 1]);
		 $this -> _data['content_pages'] = array();
		 *
		if ($page_num <= count($this -> _data['content_pages'])) {
			// print 'content page slide'
			//$this->_data['content_pages'] = array($this->_data['content_pages'][$page_num - 1]);
			$this -> _data['int_assessments'] = array();
		} elseif ($page_num <= count($this -> _data['content_pages']) + $cnt_assesments) {
			$assess_index = $page_num - count($this -> _data['content_pages']) - 1;
			$this -> _data['no_questions'] = $this -> _data['int_assessments'][$assess_index]['no_questions'];
			// set as global flag !
			$this -> _data['int_assessments'] = array($this -> _data['int_assessments'][$assess_index]);
			//$this->_data['int_assessments'] = array($this->_data['int_assessments']);
			$this -> _data['content_pages'] = array();
		} else {
			$this -> _data['content_pages'] = array();
			$this -> _data['int_assessments'] = array();
		}
		 * */
		foreach($ITEMS as $k=>$v) {
			$tmp_key = (int) $v['item_order'];
			while( !empty($ITEMS_serialized[$tmp_key]) ) {
				$tmp_key++;
			}
			$ITEMS_serialized[$tmp_key]=$v;
		}

		ksort($ITEMS_serialized);
		$this->_data['items']=$ITEMS_serialized; 

		$this -> _paste_public();
	}

    function saveAnswer() {
        $data = $this->input->post();
        parse_str($data['post_data'], $post_data);
        $this->load->model('filter_assignment_model');
        $this->load->model('student_answers_model');
        $this->load->model('classes_model');
        $this->load->model('resources_model');
        $this->load->library('resource');

        $resource = $this->resources_model->get_resource_by_id( $post_data['resource_id'] );
        $content = json_decode( $resource->content, true );

        $post_data['student_name'] = $this->session->userdata('first_name') . ' ' . $this->session->userdata('last_name');
//echo '<pre>';var_dump( $post_data );die;

        $new_resource = new Resource();
        $post_data['marks_available'] = $new_resource->getAvailableMarks($content);
        $post_data['attained'] = $new_resource->setAttained( $post_data['resource_id'], $content, $post_data['answer'] );
echo '<pre>';var_dump( $post_data );die;
        $save_data = $new_resource->saveAnswer($post_data);
        $html = $new_resource->renderCheckAnswer($post_data['resource_id'], $content, $post_data['answer']);
//echo '<pre>';var_dump( $html );die;

        echo $html;

    }

    public function getStudentAnswers(){
        $this->load->library('resource');
        $new_resource = new Resource();

        $data = $this->input->get();
        $marked = $data['marked'];
        unset($data['marked']);
        $answers = $this->student_answers_model->getStudentAnswer($data);

        $answer = $answers[0];
        $output = array();
        switch( $answer['type'] ) {
            case 'single_choice' : 
                $output['type'] = $answer['type'];
                $output['answers'][0] = $answer['answers'];
                break;
            case 'multiple_choice' : 
                $output['type'] = $answer['type'];
                $ans = explode(',',$answer['answers']);
                foreach($ans as $v) {
                    $output['answers'][] = $v;
                }
                break;
            case 'fill_in_the_blank' : 
                $output['type'] = $answer['type'];
                $ans = explode(',',$answer['answers']);
                $i = 0;
                foreach($ans as $v) {
                    $an = explode('=:',$v);
                    $output['answers'][$i]['key'] = $an[0];
                    $output['answers'][$i]['val'] = $an[1];
                    $i++;
                }
                break;
            case 'mark_the_words' : 
                $output['type'] = $answer['type'];
                $output['answers'] = explode(',',$answer['answers']);
                break;
        }
        $output['html'] = '';
        if( $marked == 1 ) {
            $resource = $this->resources_model->get_resource_by_id( $data['resource_id'] );
            $content = json_decode( $resource->content, true );
            $output['html'] =  $new_resource->renderCheckAnswer( $data['resource_id'], $content, $output['answers'] );

        }
        
        echo json_encode( $output );
//echo '<pre>';var_dump( $answers );die;
    }

    public function checkStudentAnswers(){
        $this->load->library('resource');
        $new_resource = new Resource();

        $data = $this->input->get();
        $answers = $this->student_answers_model->getStudentAnswer($data);

        $answer = $answers[0];
        $output = array();
        switch( $answer['type'] ) {
            case 'single_choice' : 
                $output['type'] = $answer['type'];
                $output['answers'][0] = $answer['answers'];
                break;
            case 'multiple_choice' : 
                $output['type'] = $answer['type'];
                $ans = explode(',',$answer['answers']);
                foreach($ans as $v) {
                    $output['answers'][] = $v;
                }
                break;
            case 'fill_in_the_blank' : 
                $output['type'] = $answer['type'];
                $ans = explode(',',$answer['answers']);
                $i = 0;
                foreach($ans as $v) {
                    $an = explode('=:',$v);
                    $output['answers'][$i]['key'] = $an[0];
                    $output['answers'][$i]['val'] = $an[1];
                    $i++;
                }
                break;
            case 'mark_the_words' : 
                $output['type'] = $answer['type'];
                $output['answers'] = explode(',',$answer['answers']);
                break;
        }
        $output['html'] = '';
        $resource = $this->resources_model->get_resource_by_id( $data['resource_id'] );
        $content = json_decode( $resource->content, true );
        $output['html'] =  $new_resource->renderCheckAnswer( $data['resource_id'], $content, $output['answers'] );

        echo json_encode( $output );
    }

}
