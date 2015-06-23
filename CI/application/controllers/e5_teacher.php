<?php

    if (!defined('BASEPATH'))
        exit('No direct script access allowed');

    class e5_teacher extends MY_Controller {

        function __construct() {
            parent::__construct();

            $this->load->model('lessons_model');
            $this->load->model('user_model');
            $this->load->model('interactive_content_model');
            $this->load->model('interactive_assessment_model');			
            $this->load->model('resources_model');
        }

        function index($subject_id = '', $module_id = '', $lesson_id = '', $page_num = 1, $type = 'view', $cont_page_id = '') {
            $this->_data['subject_id'] = $subject_id;
            $this->_data['module_id'] = $module_id;
            $this->_data['lesson_id'] = $lesson_id;
            $this->_data['lesson'] = $lesson_id;
            $this->_data['teacher_id'] = $this->session->userdata('id');
            $this->_data['page_num'] = $page_num;
            $this->_data['type'] = $type;
            $token = json_decode( $this->lessons_model->get_lesson_token($lesson_id)->token );
            $this->_data['secret'] = $token->secret;
            $this->_data['socketId'] = $token->socketId;
//            $lesson->token;
//var_dump( $this->_data['socketId'] );die;

            if (!$this->lessons_model->lesson_exist($lesson_id)) {
                show_404();
            }

            if ($type == 'running') {
                $data = array(
                    'running_page' => $page_num,
                );			
//                $this->lessons_model->save($data, $lesson_id);
            }

            $content_pages = $this->interactive_content_model->get_il_content_pages($lesson_id);
            if( !$content_pages ) {
                $this->session->set_flashdata('msg',"There are no slides available to play lesson!");
                redirect('/e1_teacher/index/' . $subject_id . '/' . $module_id . '/' . $lesson_id . '');
            }
            $curr_cpage = 0;
            $this->_data['count_pages'] = count($content_pages);
            $this->_data['content_pages'] = array();
            foreach ($content_pages as $key => $val) {
                if (empty($val->title))
                    $val->title = "";
                $this->_data['content_pages'][$key]['cont_page_id'] = $val->id;
                $this->_data['content_pages'][$key]['cont_page_title'] = $val->title;
                $this->_data['content_pages'][$key]['cont_page_text'] = $val->text;
                $this->_data['content_pages'][$key]['cont_page_template_id'] = $val->template_id;
                if ($val->id == $cont_page_id)
                    $curr_cpage = $key;

                $this->_data['content_pages'][$key]['resources'] = array();
                $resources = $this->resources_model->get_cont_page_resources($val->id);					
                foreach ($resources as $k => $v) {
                    $this->_data['content_pages'][$key]['resources'][$k]['resource_name'] = $v->name;
                    $this->_data['content_pages'][$key]['resources'][$k]['resource_id'] = $v->res_id;

                    $this->_data['content_pages'][$key]['resources'][$k]['preview'] = $this->resoucePreview($v, '/e5_teacher/resource/');
                    $this->_data['content_pages'][$key]['resources'][$k]['res_img'] = '';
                    $this->_data['content_pages'][$key]['resources'][$k]['res_vid'] = '';
                    $this->_data['content_pages'][$key]['resources'][$k]['res_frame'] = '/e5_teacher/resource/'.$v->res_id;
                }

                //log_message('error', $val->id."-".$cont_page_id);
                if ($val->id == $cont_page_id and $type == 'view') {
                    $this->_data['count_res'] = count($resources);
                    //log_message('error', $this->_data['count_res']);
                }
                //SLides into the ITEM array in the right order
                $ITEMS[]=Array(
                    'cont_page_id'=>$val->id,
                    'cont_page_title'=>$val->title,
                    'cont_page_text'=>$val->text,
                    'cont_page_template_id'=>$val->template_id,
                    'resources'=>$this->_data['content_pages'][$key]['resources'],
                    'questions'=>array(),
                    'item_order'=>$val->order);
            }

            // if running page mode
            if ($type != 'view') {
                // if current content is assesment
                if ($page_num > count($this->_data['content_pages'])) {	
                    $int_assessments = $this->interactive_content_model->get_il_int_assesments($lesson_id);
                    $this->_data['int_assessments'] = array();

                    foreach ($int_assessments as $key => $val) {
                        $this->_data['int_assessments'][$key]['assessment_id'] = $val->id;
                        $this->unserialize_assessment($val->id, $type);
                        $this->_data['int_assessments'][$key] = $this->tmp_data;
                        //log_message('error', $val->id."-".$this->_data['int_assessments'][$key]['no_questions']);
                    }
                    $ITEMS[]=Array(
                        'cont_page_id'=>'',
                        'cont_page_title'=>''.print_r($this->_data['int_assessments'][$key][0],false),
                        'cont_page_text'=>'',
                        'cont_page_template_id'=>'',
                        'preview'=>'',
                        'resources'=>array(),
                        'questions'=>$this->_data['int_assessments'][$key][0],
                        'item_order'=>$val->order);
                } else {
                    // we need only count
                    $int_assessments = $this->interactive_content_model->get_il_int_assesments($lesson_id);
                    $this->_data['int_assessments'] = array();
                }

                $cnt_assesments = count($int_assessments); // count($this->_data['int_assessments'])
            }

            //log_message('error', "cont: ".self::str($this->_data['int_assessments']));

            $this->_data['students'] = array();
            if ($type != 'view') {
                $students = $this->user_model->get_students_for_lesson($lesson_id);
                foreach ($students as $key => $value) {
                    $this->_data['students'][$key]['id'] = $value->id;
                    $this->_data['students'][$key]['first_name'] = $value->first_name;
                    $this->_data['students'][$key]['last_name'] = $value->last_name;
                    $this->_data['students'][$key]['online'] = $value->online;
                }
            }

            // 'conclude lesson'/'close preview' button
            if ($type == 'view') {
                $this->_data['close'] = "/e1_teacher/index/{$subject_id}/{$module_id}/{$lesson_id}";
//                $this->_data['close'] = "/e2/index/{$subject_id}/{$module_id}/{$lesson_id}/{$cont_page_id}";
                $this->_data['close_text'] = 'Close Preview';
            } else {
                $this->_data['close'] = "/e5_teacher/close/{$subject_id}/{$module_id}/{$lesson_id}";
                $this->_data['close_text'] = 'Conclude Lesson';
            }

            $this->_data['prev'] = "/e5_teacher/index/{$subject_id}/{$module_id}/{$lesson_id}/" . ($page_num - 1) . ($type != 'view' ? '/' . $type : '');
            $this->_data['next'] = "/e5_teacher/index/{$subject_id}/{$module_id}/{$lesson_id}/" . ($page_num + 1) . ($type != 'view' ? '/' . $type : '');
            //$this->_data['prev_hidden'] = ($type == 'view' || $page_num == 1) ? 'hidden' : '';
            //$this->_data['next_hidden'] = ($type == 'view' || $page_num >= count($this->_data['content_pages']) + $cnt_assesments) ? 'hidden' : '';
            $this->_data['prev_hidden'] = "";
            $this->_data['next_hidden'] = "";

            if ($type == 'view') { 
                // preview slide
                //$this->_data['content_pages'] = array($this->_data['content_pages'][$curr_cpage]);
                $this->_data['int_assessments'] = array();
            } else {
                // launch lesson action
                if ($page_num <= count($this->_data['content_pages'])) {
                    // print 'content page slide'
                    //$this->_data['content_pages'] = array($this->_data['content_pages'][$page_num - 1]);
                    $this->_data['int_assessments'] = array();
                } elseif ($page_num <= count($this->_data['content_pages']) + $cnt_assesments) {
                    // print 'interactive assessment'
                    $assess_index = $page_num - count($this->_data['content_pages']) - 1;

                    $this->_data['no_questions'] = $this->_data['int_assessments'][$assess_index]['no_questions']; // set as global flag !
                    $this->_data['int_assessments'] = array($this->_data['int_assessments'][$assess_index]);
                    //$this->_data['int_assessments'] = array($this->_data['int_assessments']);
                    $this->_data['content_pages'] = array();
                } else {
                    $this->_data['content_pages'] = array();
                    $this->_data['int_assessments'] = array();
                }
            }
            foreach($ITEMS as $k=>$v) {
                $tmp_key = (int) $v['item_order'];
                while( !empty($ITEMS_serialized[$tmp_key]) ) {
                    $tmp_key++;
                }
                $ITEMS_serialized[$tmp_key]=$v;
            }
            ksort($ITEMS_serialized);
            $this->_data['items']=$ITEMS_serialized;
            $this->_paste_public();

        }

        function close($subject_id = '', $module_id = '', $lesson_id = '') {
            $data = array(
                'running_page' => 0,
                'teacher_led' => 1,
                'token' => NULL
            );			
            $this->lessons_model->save($data, $lesson_id);

            redirect("/e1_teacher/index/{$subject_id}/{$module_id}/{$lesson_id}");
        }

        function t1() {
            $this->load->view('e5a_teacher', $data);
        }
    }
