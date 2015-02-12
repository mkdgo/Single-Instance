<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class E1_teacher extends MY_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('interactive_content_model');
        $this->load->model('resources_model');
		$this->load->model('lessons_model');
		$this->load->model('classes_model');
		$this->load->model('modules_model');
		$this->load->model('subjects_model');
        $this->load->library('breadcrumbs');
        $this->load->library( 'nativesession' );
	}

	function index($subject_id = '',$module_id = '', $lesson_id = '') {

        $selected_year = $this->getSelectYearTeacher($this->nativesession, $this->subjects_model, $subject_id, '');

		$this->_data['subject_id'] = $subject_id;
		$this->_data['module_id'] = $module_id;
		$this->_data['lesson_id'] = $lesson_id;
		$lesson = $this->lessons_model->get_lesson($lesson_id);

		if (empty($lesson))
			show_404();

		// breadcrumb code
        $this->breadcrumbs->push('Home', base_url());
		$this->breadcrumbs->push('Subjects', '/d1');
 
		if($subject_id) {
			$subject = $this->subjects_model->get_single_subject($subject_id);
			$this->breadcrumbs->push($subject->name, "/d1a/index/".$subject_id);
		}
                
        $this->breadcrumbs->push('Year '.$selected_year->year, "/d2_teacher/index/".$subject_id);
		
        $module = $this->modules_model->get_module($module_id);
		$this->breadcrumbs->push($module[0]->name, "/d4_teacher/index/".$subject_id."/".$module_id);

		$this->breadcrumbs->push($lesson->title, "/d5_teacher/index/".$subject_id."/".$module_id."/".$lesson_id);
		// end breadcrumb code

		if (!$lesson->interactive_lesson_exists) {
			$data = array(
				'interactive_lesson_exists' => 1,
			);
			$this->lessons_model->save($data, $lesson_id);		
		}		

		//get content pages slides
		$ITEMS = Array();
        $ITEMS_serialized = Array();
                
        $content_pages = $this->interactive_content_model->get_il_content_pages($lesson_id);
                
		if(!empty($content_pages)){
			foreach ($content_pages as $kay => $val) {
				if (strlen($val->title) > 17) {
					$val->title = substr($val->title, 0, 17)." ...";
                }
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

        foreach($ITEMS as $k=>$v) {
            $tmp_key = (int) $v['item_order'];
            while( !empty($ITEMS_serialized[$tmp_key]) ) {
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
		
        $this->_data['publish_active'] = '';
        $this->_data['publish_text'] = 'PUBLISH';
		if ($lesson->published_interactive_lesson) {
            $this->_data['publish_active'] = 'active';
            $this->_data['publish_text'] = 'PUBLISHED';
		}
		
        $this->_data['publish'] = $lesson->published_interactive_lesson;
                
		// get classes
		$classes = $this->classes_model->get_classes_for_teacher($this->session->userdata('id'), $subject_id);
		$this->_data['classes'] = array();

		foreach( $classes as $key => $value ){
			//log_message('error', $value->group_name);
			$this->_data['classes'][$value['id']]['id'] = $value['id'];
			$this->_data['classes'][$value['id']]['year'] = $value['year'];
			$this->_data['classes'][$value['id']]['group_name'] = $value['group_name'];
			$this->_data['classes'][$value['id']]['checked'] = '';
		}
		
		$lesson_classes = $this->lessons_model->get_classes_for_lesson($lesson_id);
		
		foreach($lesson_classes as $key => $value) {
			if (isset($this->_data['classes'][$value->class_id])) {
				$this->_data['classes'][$value->class_id]['checked'] = 'checked';
            }
		}
		
		$this->_data['launch_disabled'] = count($content_pages) + count($int_assessments) > 0 ? '' : 'disabled="disabled"';
		
		$this->breadcrumbs->push("Slides", "/");
		$this->_data['breadcrumb'] = $this->breadcrumbs->show();
		$this->_paste_public();
	}
	
	function launch() {
		$this->db->update('lessons', array('teacher_led' => 0), array('teacher_id' => $this->session->userdata('id')));
        $this->db->update('lessons', array('running_page' => 0), array('teacher_id' => $this->session->userdata('id')));

        $token = ( file_get_contents( 'http://77.72.3.90:1948/token' ) );
//        log_message('error', "cont: ".self::str( $token ));

		$data = array(
			//'teacher_led' => $this->input->post('teacher_led'),
			'published_interactive_lesson' => $this->input->post('publish'),
            'token' => $token
		);			
		$this->lessons_model->save($data, $this->input->post('lesson_id'));
//var_dump( $token );die;

        $this->saveSlides($this->input->post('resources_order'));
                
		$classes = $this->input->post('classes');
		if (!$classes) {
			$classes = array();
		}
		$this->lessons_model->set_classes_for_lesson($this->input->post('lesson_id'), $classes);
		redirect('/e5_teacher/index/' . $this->input->post('subject_id') . '/' . $this->input->post('module_id') . '/' . $this->input->post('lesson_id') . '/1/running');
	}
	
	function save() {		
		$data = array(
			'teacher_led' => 0, //$this->input->post('teacher_led'),
			'published_interactive_lesson' => $this->input->post('publish'),
		);			
		$this->lessons_model->save($data, $this->input->post('lesson_id'));

        $this->saveSlides($this->input->post('resources_order'));
		
		$classes = $this->input->post('classes');
		if (!$classes) {
			$classes = array();
		}
		$this->lessons_model->set_classes_for_lesson($this->input->post('lesson_id'), $classes);

		redirect('/e1_teacher/index/' . $this->input->post('subject_id') . '/' . $this->input->post('module_id') . '/' . $this->input->post('lesson_id') . '');
	}

    function saveajax() {
            
        $dt = $this->input->post('data');
             
        $dt_=array();
        $classes_ = array(); 
            
        foreach($dt as $k=>$v) {
            $dt_[$v['name']]=$v['value'];
            if($v['name']=='classes[]')$classes_[]=$v['value'];
        }

        if( $dt_['publish'] ) {
            $dt_['publish'] = 0;
        } else {
            $dt_['publish'] = 1;
        }

		$data = array(
			'teacher_led' => 0, //$this->input->post('teacher_led'),
			'published_interactive_lesson' => $dt_['publish'],
		);			
		$this->lessons_model->save($data, $dt_['lesson_id']);
                
        $this->saveSlides($dt_['resources_order']);
                
		
		$this->lessons_model->set_classes_for_lesson($dt_['lesson_id'], $classes_);

        echo json_encode( $dt_['publish'] );
	}
        
    private function saveSlides($slide_order_data) {

        $slide_order = explode(',', $slide_order_data);
        $ord=0;
        foreach($slide_order as $k=>$v) {
            $slide_type = substr($v, 0, 2);
            $slide_id   = substr($v, 2);
                
            if($slide_type=='e2') {
                $this->db->update('content_page_slides', array('order' => $ord), array('id' => $slide_id));
            } elseif($slide_type=='e3') {
                $this->db->update('interactive_assessments_slides', array('order' => $ord), array('id' => $slide_id));
            }
                
            $ord++;
        }
            //$cont_page_id = $this->content_page_model->save(array('order'=>1), $cont_page_id);
    }

}