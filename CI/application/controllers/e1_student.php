<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class E1_student extends MY_Controller {

    function __construct() {
        parent::__construct();
                $this->load->model('interactive_content_model');
		$this->load->model('lessons_model');
		$this->load->model('classes_model');
                $this->load->model('resources_model');
		$this->load->model('modules_model');
		$this->load->model('subjects_model');
                $this->load->library('breadcrumbs');
    }

    function index($subject_id = '',$module_id = '', $lesson_id = '')
    {
        
                $this->_data['subject_id'] = $subject_id;
		$this->_data['module_id'] = $module_id;
		$this->_data['lesson_id'] = $lesson_id;
		$lesson = $this->lessons_model->get_lesson($lesson_id);

		if (empty($lesson))
			show_404();

                
                $interactive_content_exists = $this->interactive_content_model->if_has_assesments($lesson_id);

        if( $interactive_content_exists > 0 ) {
            $this->_data['view_interactive_lesson'] = '<a class="red_btn" href="/e5_student/index/'.$subject_id.'/'.$module_id.'/'.$lesson_id.'">VIEW INTERACTIVE LESSON</a>';
             } else {
            $this->_data['view_interactive_lesson'] = '';
           
        }
                
                
		// breadcrumb code
		$this->breadcrumbs->push('Subjects', '/d1');

		if($subject_id)
		{	
			$subject = $this->subjects_model->get_single_subject($subject_id);
			$this->breadcrumbs->push($subject->name, "/d2_student/index/".$subject_id);
		}

		$module = $this->modules_model->get_module($module_id);
		$this->breadcrumbs->push($module[0]->name, "/d4_student/index/".$subject_id."/".$module_id);
		$this->breadcrumbs->push($lesson->title, "/d5_student/index/".$subject_id."/".$module_id."/".$lesson_id);
		// end breadcrumb code
		$this->_data['lesson_title'] = $lesson->title;
		/*
                if (!$lesson->interactive_lesson_exists) {
			$data = array(
				'interactive_lesson_exists' => 1,
			);
			$this->lessons_model->save($data, $lesson_id);		
		}
                */
                 	

		//get content pages slides
		$ITEMS = Array();
                $ITEMS_serialized = Array();
                
                $content_pages = $this->interactive_content_model->get_il_content_pages($lesson_id);
                
		if(!empty($content_pages)){
			foreach ($content_pages as $kay => $val) {
				if (strlen($val->title) > 17)
					$val->title = substr($val->title, 0, 17)." ...";

				$this->_data['content_pages'][$kay]['cont_page_title'] = $val->title;
				$this->_data['content_pages'][$kay]['cont_page_id'] = $val->id;
                                
                                $resources = $this->resources_model->get_cont_page_resources($val->id);
                                if(count($resources)==0)$R_label='No Resources';elseif(count($resources)==1)$R_label='1 Resource';else $R_label=count($resources).' Resources';
                                
                                $ITEMS[]=Array('resources_label'=>$R_label, 'item_id'=>$val->id, 'item_type'=>"e2", 'item_type_delete'=>"delete", 'item_title'=>$val->title, 'item_order'=>$val->order, 'item_iconindex'=>'2');
			}
		}else{
			$this->_data['content_pages'] = array();
		}
		
		$int_assessments = $this->interactive_content_model->get_il_int_assesments($lesson_id);
		if(!empty($int_assessments)){
		foreach($int_assessments as $assessment_key =>$assessment){
			$this->_data['int_assessments'][$assessment_key]['assessment_id'] =$assessment->id;
                        
                       
                        $this->unserialize_assessment($assessment->id);
                        $questions = $this->tmp_data['questions'];
                        
                        
                        if(count($questions)==0)$R_label='No Questions';elseif(count($questions)==1)$R_label='1 Question';else $R_label=count($questions).' Questions';
                                
                        
                        $ITEMS[]=Array('resources_label'=>$R_label, 'item_id'=>$assessment->id, 'item_type'=>"e3", 'item_type_delete'=>"delete_assessment", 'item_title'=>"Questions", 'item_order'=>$assessment->order, 'item_iconindex'=>'1');
		}
		}else{
			$this->_data['int_assessments'] = array();
		}

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
                

		if ($lesson->teacher_led) {
			$this->_data['teacher_led'] = 'checked="checked"';
			$this->_data['student_led'] = '';
		} else {
			$this->_data['teacher_led'] = '';
			$this->_data['student_led'] = 'checked="checked"';
		}		
		
		if ($lesson->published_interactive_lesson) {
			$this->_data['il_publish_1'] = 'selected="selected"';
		} else {
			$this->_data['il_publish_0'] = 'selected="selected"';
		}
		
                
                
		//$this->_data['launch_disabled'] = count($content_pages) + count($int_assessments) > 0 ? '' : 'disabled="disabled"';
		
		$this->breadcrumbs->push("Slides", "/");
		$this->_data['breadcrumb'] = $this->breadcrumbs->show();
		$this->_paste_public();
       
        
    }

}
