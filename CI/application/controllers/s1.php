<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class S1 extends MY_Controller {

	function S1()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->model('classes_model');
		$this->load->model('resources_model');
		$this->load->model('keyword_model');
		$this->load->model('modules_model');
		$this->load->model('lessons_model');
		$this->load->model('content_page_model');
		$this->load->model('interactive_assessment_model');
		$this->load->model('assignment_model');
		$this->load->model('user_model');
		$this->load->model('subjects_model');
		$this->load->library('zend');
		$this->zend->load('Zend/Search/Lucene'); 
	}
 
	function index()
	{
		$this->_data['query'] = '';
		$this->_data['resources'] = array();
		$this->_data['results'] = '';
		$this->_paste_public();
	}

	function results($query=''){	

		$this->_data['query'] = strval($query);
		$this->_data['results'] = $this->query($query);
		$this->_paste_public();

	}
 
	public function query($query)
	{
		$index = Zend_Search_Lucene::open(APPPATH . 'search/index');

		try{
	        $hits = $index->find($query);
	    }
	    catch (Zend_Search_Lucene_Exception $ex) {
	        $hits = array();
	    }



		if(count($hits) > 0){

			foreach ($hits as $key => $hit) {
			    // return Zend_Search_Lucene_Document object for this hit
			    $document = $hit->getDocument();
			    // Get the ID for the resource stored in the DB and load it:
			    if($hit->score >= 0){

					// Determine Search Result Type:
					if($hit->search_type == 'user'){

						$this->_data['users'][$key]['name'] = $hit->name;
						$this->_data['users'][$key]['type'] = $hit->type;
						$this->_data['users'][$key]['id'] = $hit->name;

					}

					if($hit->search_type == 'resource'){

						if($hit->resource_id){
					 	    $resource = $this->resources_model->get_resource_by_id($hit->resource_id);
						}else{
						    $resource = NULL;
						}


					    $this->_data['resources'][$key] = array();
					 	$this->_data['resources'][$key]['title'] = $document->name;
					 	$this->_data['resources'][$key]['link'] = $document->link;
					 	$this->_data['resources'][$key]['description'] = $document->description;
					 	$this->_data['resources'][$key]['id'] = $hit->id;
					 	$this->_data['resources'][$key]['type'] = $resource->type;
					 	// Get Keywords:
					 	try{
					 	$this->_data['resources'][$key]['keyword'] = $hit->keyword;
					 	}catch(exception $e){}

						
						if($resource->teacher_id){
							$teacher = $this->user_model->get_user($resource->teacher_id);
						}else{
							$teacher = NULL;
						}
						if($teacher){
							$this->_data['resources'][$key]['user'] = $teacher->first_name . ' ' . $teacher->last_name;
						}else{
							$this->_data['resources'][$key]['user'] = $hit->resource_id;
						}

					 	$this->_data['resources'][$key]['resource_id'] = $hit->resource_id;
					 	$resource_object = $this->resources_model->get_resource_by_id($hit->resource_id);
						$this->_data['resources'][$key]['preview'] = $this->resoucePreview($resource_object, '/c1/resource/');

					}
					
					if($hit->search_type == 'module'){




						if($this->session->userdata('user_type')=='student') {
							$t = $this->subjects_model->get_student_subject_years($this->session->userdata('student_year'));

						$exp = explode(',',$t['subs']);
						if(!in_array($hit->year_id,$exp))
						{

							$this->_data['modules'][$key]['name'] = $hit->name;
							$this->_data['modules'][$key]['module_id'] = $hit->module_id;
							$this->_data['modules'][$key]['intro'] = $hit->intro;
							$this->_data['modules'][$key]['objectives'] = $hit->objectives;
							$this->_data['modules'][$key]['teaching_activities'] = $hit->teaching_activities;
							$this->_data['modules'][$key]['assessment_opportunities'] = $hit->assessment_opportunities;
							$this->_data['modules'][$key]['notes'] = $hit->notes;
							$this->_data['modules'][$key]['publish'] = $hit->publish;
							$this->_data['modules'][$key]['active'] = $hit->active;
							$this->_data['modules'][$key]['subject_id'] = $hit->subject_id;
							$this->_data['modules'][$key]['year_id'] = $hit->year_id;
							$this->_data['modules'][$key]['type'] = 'Module';

						}
						}
						else {



							$this->_data['modules'][$key]['name'] = $hit->name;
							$this->_data['modules'][$key]['module_id'] = $hit->module_id;
							$this->_data['modules'][$key]['intro'] = $hit->intro;
							$this->_data['modules'][$key]['objectives'] = $hit->objectives;
							$this->_data['modules'][$key]['teaching_activities'] = $hit->teaching_activities;
							$this->_data['modules'][$key]['assessment_opportunities'] = $hit->assessment_opportunities;
							$this->_data['modules'][$key]['notes'] = $hit->notes;
							$this->_data['modules'][$key]['publish'] = $hit->publish;
							$this->_data['modules'][$key]['active'] = $hit->active;
							$this->_data['modules'][$key]['subject_id'] = $hit->subject_id;
							$this->_data['modules'][$key]['year_id'] = $hit->year_id;
							$this->_data['modules'][$key]['type'] = 'Module';
						}
					}

					if($hit->search_type == 'lesson'){


						//get modules
						if($this->session->userdata('user_type')=='student') {

							$modules = $this->subjects_model->get_allowed_modules_for_student($this->session->userdata('student_year'));
							if($modules)
							{
								;
							$dump=	explode(',',$modules['l_id']);
							}

							if(!in_array($hit->lesson_id,$dump)) {
								$this->_data['lessons'][$key]['title'] = $hit->title;
								$this->_data['lessons'][$key]['module_id'] = $hit->module_id;
								$this->_data['lessons'][$key]['teacher_id'] = $hit->teacher_id;
								$this->_data['lessons'][$key]['lesson_id'] = $hit->lesson_id;
								$this->_data['lessons'][$key]['subject_id'] = $hit->subject_id;
								$this->_data['lessons'][$key]['intro'] = $hit->intro;
								$this->_data['lessons'][$key]['objectives'] = $hit->objectives;
								$this->_data['lessons'][$key]['teaching_activities'] = $hit->teaching_activities;
								$this->_data['lessons'][$key]['assessment_opportunities'] = $hit->assessment_opportunities;
								$this->_data['lessons'][$key]['type'] = 'Lesson';
							}
						}
						else {

							$this->_data['lessons'][$key]['title'] = $hit->title;
							$this->_data['lessons'][$key]['module_id'] = $hit->module_id;
							$this->_data['lessons'][$key]['teacher_id'] = $hit->teacher_id;
							$this->_data['lessons'][$key]['subject_id'] = $hit->subject_id;
							$this->_data['lessons'][$key]['lesson_id'] = $hit->lesson_id;
							$this->_data['lessons'][$key]['intro'] = $hit->intro;
							$this->_data['lessons'][$key]['objectives'] = $hit->objectives;
							$this->_data['lessons'][$key]['teaching_activities'] = $hit->teaching_activities;
							$this->_data['lessons'][$key]['assessment_opportunities'] = $hit->assessment_opportunities;
							$this->_data['lessons'][$key]['type'] = 'Lesson';
						}
					}

				}

			}

		}
		//print_r($modules);
		//die();
		return $this->_data;
	}


	// public function query($query){

	// 	$index = Zend_Search_Lucene::open(APPPATH . 'search/index');
	// 	$hits = $index->find($query);
	// 	if(count($hits) <= 0){
	// 		$this->_data['resources'] = array();
	// 		$this->_data['resources']['query'] = $query;
	// 		return $this->_data['resources'];
	// 	}

	// 	$this->_data['resources'] = array();

	// 	foreach ($hits as $key => $hit) {
	// 	    // return Zend_Search_Lucene_Document object for this hit
	// 	    $document = $hit->getDocument();
	// 	    // Get the ID for the resource stored in the DB and load it:
	// 	    if($hit->resource_id){
	// 	    	$resource = $this->resources_model->get_resource_by_id($hit->resource_id);
	// 		}else{
	// 			$resource = NULL;
	// 		}
	// 	    $this->_data['resources'][$key] = array();
	// 	 	$this->_data['resources'][$key]['title'] = $document->name;
	// 	 	$this->_data['resources'][$key]['link'] = $document->link;
	// 	 	$this->_data['resources'][$key]['description'] = $document->description;
	// 	 	$this->_data['resources'][$key]['id'] = $hit->id;
	// 	 	// Get Keywords:
	// 	 	try{
	// 	 	$this->_data['resources'][$key]['keyword'] = $hit->keyword;
	// 	 	}catch(exception $e){}
	// 	 	$offset = stripos($document->resource_name, '.');
	// 		if ( $offset === false ){
	// 		    //error, end of wasn't found
	// 		}else{
	// 			$offset += strlen('.');
	// 			$this->_data['resources'][$key]['filetype'] = substr($document->resource_name, $offset);
	// 		}
	// 		if($resource->teacher_id){
	// 			$teacher = $this->user_model->get_user($resource->teacher_id);
	// 		}else{
	// 			$teacher = NULL;
	// 		}
	// 		if($teacher){
	// 			$this->_data['resources'][$key]['user'] = $teacher->first_name . ' ' . $teacher->last_name;
	// 		}
	// 	 	$this->_data['resources'][$key]['score'] = $hit->score;
	// 	 	$this->_data['resources'][$key]['resource_id'] = $hit->resource_id;
	// 	 	$resource_object = $this->resources_model->get_resource_by_id($hit->resource_id);
	// 		$this->_data['resources'][$key]['preview'] = $this->resoucePreview($resource_object, '/c1/resource/');
			
	// 	}
	// 	return $this->_data;
	// }

	public function formquery($query = ''){

		if(empty($query)){
 			$data = $this->query($this->input->post('query'));
 			$this->parser->parse('s1-results', $data);
 		}else{
 			$data = $this->query($query);
 			return $this->parser->parse('s1-results', $data, TRUE);
 		}
	}

	public function delete_document(){

		$index = Zend_Search_Lucene::open(APPPATH . 'search/index');
		$id = $this->input->post('id');
		$hit = $index->getDocument($id);
		$this->resources_model->delete_resource($hit->resource_id);
 		$index->delete($id);
 		// $data = $this->query($this->input->post('query'));
 		// $this->parser->parse('search-results', $data);
	}

	private function getBackUrl($type, $elem_id, $subject_id, $module_id, $lesson_id, $assessment_id) {
		switch ($type) {
			case 'module':
				return "/d4_teacher/index/{$subject_id}/{$elem_id}";
			case 'lesson':
				return "/d5_teacher/index/{$subject_id}/{$module_id}/{$elem_id}";
			case 'content_page':
				return "/e2/index/{$subject_id}/{$module_id}/{$lesson_id}/{$elem_id}";
			case 'question':
				return "/e3/index/{$subject_id}/{$module_id}/{$lesson_id}/{$assessment_id}";
			case 'assignment':
				return "/f2b_teacher/index/{$elem_id}";
			default: // student resource library
				return '/c1';
				//return "/c2/index/resource/{$elem_id}";
		}	
	}

	public function save($resource_id, $type, $elem_id = '0', $subject_id = '', $module_id = '', $lesson_id = '', $assessment_id = '') {
		if ($type == 'question') {
			$this->add_question_resource($resource_id, $type, $elem_id, $subject_id, $module_id, $lesson_id, $assessment_id);
		}
		
		if (!$elem_id) {
			switch ($type) {
				case 'module':
					$elem_id = $this->modules_model->save(array('active' => '0'));		
					break;
				case 'lesson':
					$elem_id = $this->lessons_model->save(array('active' => '0'));
					break;
				case 'content_page':
					$elem_id = $this->content_page_model->save(array('active' => '0'));
					break;
				case 'question':
					// created in /e3
					break;
				case 'assignment':
					$elem_id = $this->assignment_model->save(array('active' => '0'));
					break;
			}		
		}
		
		$this->resources_model->add_resource($type, $elem_id, $resource_id);
		
		redirect($this->getBackUrl($type, $elem_id, $subject_id, $module_id,  $lesson_id, $assessment_id), 'refresh');		
	}

	private function add_question_resource($resource_id, $type, $elem_id, $subject_id, $module_id, $lesson_id, $assessment_id) {
		
        $temp_data = unserialize($this->interactive_assessment_model->get_ia_temp_data($assessment_id));

		$temp_data[$elem_id]['question_resource_id'] = $resource_id;
		
		$db_data = array(
			'temp_data' => serialize($temp_data)
		);
		$this->interactive_assessment_model->save_temp_data($db_data, $assessment_id);

		redirect($this->getBackUrl($type, $elem_id, $subject_id, $module_id,  $lesson_id, $assessment_id), 'refresh');	

	}

}

?>