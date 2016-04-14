<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class E5_student extends MY_Controller {

	function __construct() {
		parent::__construct();

		$this -> load -> model('lessons_model');
		$this -> load -> model('interactive_content_model');
		$this -> load -> model('interactive_assessment_model');
		$this -> load -> model('resources_model');
	}

	function index($subject_id = '', $module_id = '', $lesson_id = '', $page_num = 1, $type = 'view') {
		$this -> _data['subject_id'] = $subject_id;
		$this -> _data['module_id'] = $module_id;
		$this -> _data['lesson_id'] = $lesson_id;

		$lesson = $this->lessons_model->get_lesson($lesson_id);
        $token = json_decode( $lesson->token, true );
//echo '<pre>';var_dump($token);die;
        if( is_null($token) ) {
            $token['secret'] = '';
            $token['socketId'] = time();
        }
        $this->_data['secret'] = $token['secret'];
        $this->_data['socketId'] = $token['socketId'];
		if (empty($lesson)) {
			show_404();
		}

		$content_pages = $this -> interactive_content_model -> get_il_content_pages($lesson_id);
		$this -> _data['content_pages'] = array();
		foreach ($content_pages as $key => $val) {
//echo $val -> id;
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
				} else {
					$this -> _data['content_pages'][$key]['resources'][$k]['preview'] = $this -> resoucePreview($v, '/e5_student/resource/');
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
//die;
		$int_assessments = $this -> interactive_content_model -> get_il_int_assesments($lesson_id);
		$this -> _data['int_assessments'] = array();

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
		foreach($ITEMS as $k=>$v)
		{
			$tmp_key = (int) $v['item_order'];
			while( !empty($ITEMS_serialized[$tmp_key]) )
			{
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


//        $assignment = $this->assignment_model->get_assignment($post_data['slide_id']);
//        $base_assignment = $this->filter_assignment_model->get_assignment($assignment->base_assignment_id);

/*  TO DO
        $post_data['teacher_id'] = $base_assignment['teacher_id'];
        $post_data['teacher_name'] = $base_assignment['teacher_name'];
        $post_data['student_name'] = $this->session->userdata('first_name') . ' ' . $this->session->userdata('last_name');
        $post_data['subject_id'] = $base_assignment['subject_id'];
        $post_data['subject_name'] = $base_assignment['subject_name'];
        $post_data['year_id'] = $base_assignment['year_id'];
        $post_data['year'] = $base_assignment['year'];
        $post_data['class_id'] = $assignment->class_id;
        $post_data['class_name'] = $this->classes_model->get_class_name( $assignment->class_id );
        $post_data['lesson_title'] = $base_assignment['title'];
        $post_data['lesson_id'] = $assignment->base_assignment_id;
*/

        $post_data['marks_available'] = $new_resource->getAvailableMarks($content);
        $post_data['attained'] = $new_resource->setAttained( $post_data['resource_id'], $content, $post_data['answer'] );

        $save_data = $new_resource->saveAnswer($post_data);
        $new_resource = new Resource();
        $html = $new_resource->renderCheckAnswer($post_data['resource_id'], $content, $post_data['answer']);
//echo '<pre>';var_dump( $html );die;


        echo $html;

    }
}
