<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class C1 extends MY_Controller {

	function __construct() {
            
		parent::__construct();
		$this->load->model('resources_model');
		$this->load->model('modules_model');
		$this->load->model('lessons_model');
		$this->load->model('content_page_model');
		$this->load->model('interactive_assessment_model');
		$this->load->model('assignment_model');
		$this->load->model('user_model');
                $this->load->library('breadcrumbs');
		$this->load->library('zend');
		$this->zend->load('Zend/Search/Lucene'); 
	}
 
	function index($type = '', $elem_id = '0', $subject_id = '', $module_id = '',  $lesson_id = '', $assessment_id = '') {	

        $this->_data['back'] = $this->getBackUrl($type, $elem_id, $subject_id, $module_id,  $lesson_id, $assessment_id);

		$this->_data['save_resource'] = '';
        
        if(!empty($type)){
			$this->_data['save_resource'] = "{$type}/{$elem_id}" . ($subject_id ? '/' . $subject_id : '') . ($module_id ? '/' . $module_id : '') . ($lesson_id ? '/' . $lesson_id : '') . ($assessment_id ? '/' . $assessment_id : '');
			$this->_data['add_resource'] = base_url()."c2/index/$type/0/$elem_id".($subject_id ? '/' . $subject_id : '') . ($module_id ? '/' . $module_id : '') . ($lesson_id ? '/' . $lesson_id : '') . ($assessment_id ? '/' . $assessment_id : '');

		} else{
			$this->_data['add_resource'] = base_url()."/c2/index//0";
		}

		$this->_data['query'] = '';
		$this->_data['resources'] = array();
		$this->_data['results'] = '';

        $this->breadcrumbs->push('Home', base_url());
        $this->breadcrumbs->push('Resources', '/c1');
       $this->_data['breadcrumb'] = $this->breadcrumbs->show();
		$this->_paste_public();
	}

	function results($query='')	{	
		// $this->_data['query'] = strval($this->input->post('query'));
		$this->_data['query'] = strval($query);
		// if(strlen($this->_data['query'])<=0){
		// 	$this->index();
		// 	return;
		// }
		// $this->query($this->_data['query']);
		// if(!$this->_data['resources']){
		// 	$this->index();
		// 	return;
		// }
		$this->_data['results'] = $this->formquery($query);
		$this->_paste_public();
	}
 
	public function query($query) {

		$index = Zend_Search_Lucene::open(APPPATH . 'search/index');

		try{
	        $hits = $index->find($query);
                
	    }
	    catch (Zend_Search_Lucene_Exception $ex) {
	        $hits = array();
			//$ex->getMessage();
	    }

//           foreach ($hits as $hit) {
//    printf("%d  %s\n", $hit->id, $hit->name);
//}

           // die();
            
		if(count($hits) > 0){

			foreach ($hits as $key => $hit) {

				if($hit->search_type != 'resource'){
					continue;
				}
			    // return Zend_Search_Lucene_Document object for this hit
			 $document = $hit->getDocument();
//                           print_r($document->year_restriction);
//                die();
                            
			    // Get the ID for the resource stored in the DB and load it:
			    if($hit->score >= 0){
				    if($hit->resource_id){
				    	$resource = $this->resources_model->get_resource_by_id($hit->resource_id);
					}else{
						$resource = NULL;
					}
                                        
                                       
                                        $findme   = ',';
                                        $pos = strpos($resource->restriction_year, $findme);


                                        if ($pos === false) {
                                            $r_years= array($resource->restriction_year);

                                        } else {
                                            $r_years= explode(',', $resource->restriction_year);
                                        }
                                        //var_dump($r_years);
                                        
                                         //[user_type] => student [student_year] => 5
                                        if($resource && ($this->session->userdata('user_type')=='student'))
                                        {
                                            
                                            if(in_array( $this->session->userdata('student_year'),$r_years))
                                            {
                                                $resource = NULL;
                                            }
                                            
                                        }
                                        
                                        
				    $this->_data['resources'][$key] = array();
				 	$this->_data['resources'][$key]['title'] = $document->name;
				 	$this->_data['resources'][$key]['link'] = $document->link;
				 	$this->_data['resources'][$key]['description'] = $document->description;
				 	$this->_data['resources'][$key]['id'] = $hit->id;
				 	$this->_data['resources'][$key]['type'] = $resource->type;
                                        //echo $resource->type.'<br />';
				 	// Get Keywords:
				 	try{
				 	    $this->_data['resources'][$key]['keyword'] = $hit->keyword;
				 	}catch(exception $e){
					//echo $e->getMessage();
					}

				 // 	$offset = stripos($document->resource_name, '.');
					// if ( $offset === false ){
					//     //error, end of wasn't found
					// }else{
					// 	$offset += strlen('.');
					// 	$this->_data['resources'][$key]['type'] = substr($document->resource_name, $offset);
					// }
					
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
					if($hit->score >= 0 && $hit->score <= 0.3){
						$this->_data['resources'][$key]['score'] = 'low';
					}
					elseif($hit->score > 0.3 && $hit->score < 0.7){
						$this->_data['resources'][$key]['score'] = 'med';
					}
					else{
						$this->_data['resources'][$key]['score'] = 'high';
					}
				 	$this->_data['resources'][$key]['resource_id'] = $hit->resource_id;
				 	$resource_object = $this->resources_model->get_resource_by_id($hit->resource_id);
					$this->_data['resources'][$key]['preview'] = $this->resoucePreview($resource_object, '/c1/resource/');
				}

			}

		}

		// $users = $this->resources_model->search_users($query);

		// echo count($users);
		// die();

		// foreach ($users as $key => $user) {
		// 	$this->_data['resources'][$key] = array();
		// 	$this->_data['resources'][$key]['user'] = $user->first_name;
		// 	$this->_data['resources'][$key]['preview'] = '';
		// 	$this->_data['resources'][$key]['type'] = 'user';
		// 	$this->_data['resources'][$key]['score'] = '';
		// 	$this->_data['resources'][$key]['title'] = '';
		// }

		return $this->_data;
	}

	public function formquery($query = '', $source = '')
	{

		if(empty($query)){
 			$data = $this->query($this->input->post('query'));
 			return $this->parser->parse('search-results', $data, TRUE);
 		}else{
 			$data = $this->query($query);
 			return $this->parser->parse('search-results', $data, TRUE);
 		}
	}

	public function ajaxquery() {
            
		$data = $this->query($this->input->post('query'));

		$data['user_type'] = $this->input->post('user_type');
		$data['save_resource'] = $this->input->post('save_resource');
//echo '<pre>'; var_dump( $data );die;
		return $this->parser->parse('search-results', $data);
	}

	public function delete_document()
	{
            
		$index = Zend_Search_Lucene::open(APPPATH . 'search/index');
		$id = $this->input->post('id');
		$hit = $index->getDocument($id);
 		// $data = $this->query($this->input->post('query'));
 		// $this->parser->parse('search-results', $data);

 		if($this->session->userdata('user_type') == 'teacher')
            {
                $this->config->load('upload');
            	
            	$resource_id = $hit->resource_id;
                $resource = $this->resources_model->get_resource_by_id($resource_id);
                if($resource)
                {
                    $dir = $this->config->item('upload_path');
              
                    $file = $dir.$resource->resource_name;
                    if(is_file($file))unlink($file);
                
                    $this->resources_model->delete_resource($resource_id);
                }

            } 

            $index->delete($id);
            
            $json['result']='true';
            echo json_encode($json);
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

	// public function index2($type = '', $elem_id = '0', $subject_id = '', $module_id = '',  $lesson_id = '', $assessment_id = '') {	
		
 //        $this->_data['back'] = $this->getBackUrl($type, $elem_id, $subject_id, $module_id,  $lesson_id, $assessment_id);
                
	// 	$this->_data['add'] = "/c2/index/{$type}/{$elem_id}" . ($subject_id ? '/' . $subject_id : '') . ($module_id ? '/' . $module_id : '') . ($lesson_id ? '/' . $lesson_id : '') . ($assessment_id ? '/' . $assessment_id : '');
	// 	//$this->_data['hide_my_resources'] = $this->session->userdata('user_type') == 'teacher' ? '' : 'hidden';
	// 	$this->_data['hide_my_resources'] = $this->session->userdata('user_type') == 'teacher' ? '' : 'hidden';
				
	// 	$resources = $this->resources_model->get_all_resources();
	// 	$this->_data['resources'] = array();
	// 	foreach ($resources as $key => $resource) {
	// 		$this->_data['resources'][$key]['resource_name'] = $resource->name;
	// 		$this->_data['resources'][$key]['resource_id'] = $resource->id;
	// 		if ($type != '') {
	// 			$this->_data['resources'][$key]['resource_link'] = "/c1/save/{$resource->id}/{$type}/{$elem_id}" . ($subject_id ? '/' . $subject_id : '') . ($module_id ? '/' . $module_id : '') . ($lesson_id ? '/' . $lesson_id : '') . ($assessment_id ? '/' . $assessment_id : '');
	// 			$this->_data['resources'][$key]['resource_class'] = '';
                                
 //                                $save_link = "/c1/save/{$resource->id}/{$type}/{$elem_id}" . ($subject_id ? '/' . $subject_id : '') . ($module_id ? '/' . $module_id : '') . ($lesson_id ? '/' . $lesson_id : '') . ($assessment_id ? '/' . $assessment_id : '');
 //                                $this->_data['resources'][$key]['preview'] = $this->resoucePreview($resource, $save_link);
	// 		} else { // student resource library
	// 			$this->_data['resources'][$key]['resource_link'] = "/c1/resource/{$resource->id}";
	// 			$this->_data['resources'][$key]['resource_class'] = 'colorbox';
 //                                $this->_data['resources'][$key]['preview'] = $this->resoucePreview($resource, '/c1/resource/');
	// 		}
	// 	}
		
	// 	$my_resources = $this->resources_model->get_teacher_resources($this->session->userdata('id'));
	// 	$this->_data['my_resources'] = array();
	// 	foreach ($my_resources as $key => $resource) {
	// 		$this->_data['my_resources'][$key]['resource_name'] = $resource->name;
	// 		$this->_data['my_resources'][$key]['resource_id'] = $resource->id;
	// 		if ($type != '') {
	// 			$this->_data['my_resources'][$key]['resource_link'] = "/c1/save/{$resource->id}/{$type}/{$elem_id}" . ($subject_id ? '/' . $subject_id : '') . ($module_id ? '/' . $module_id : '') . ($lesson_id ? '/' . $lesson_id : '') . ($assessment_id ? '/' . $assessment_id : '');
	// 			$this->_data['my_resources'][$key]['resource_class'] = '';
                                 
 //                                $save_link = "/c1/save/{$resource->id}/{$type}/{$elem_id}" . ($subject_id ? '/' . $subject_id : '') . ($module_id ? '/' . $module_id : '') . ($lesson_id ? '/' . $lesson_id : '') . ($assessment_id ? '/' . $assessment_id : '');
 //                                $this->_data['my_resources'][$key]['preview'] = $this->resoucePreview($resource, $save_link);
	// 		} else { // student resource library
	// 			$this->_data['my_resources'][$key]['resource_link'] = "/c1/resource/{$resource->id}";
	// 			$this->_data['my_resources'][$key]['resource_class'] = 'colorbox';
 //                                $this->_data['my_resources'][$key]['preview'] = $this->resoucePreview($resource, '/c1/resource/');
	// 		}
	// 	}		

	// 	$this->_paste_public();
	// }
	
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


	public function get_resource_usage()
	{
		$resource_id = $this->input->post('resource_id');

		$res = $this->resources_model->get_resource_usage($resource_id);
		echo json_encode($res);



	}

}
