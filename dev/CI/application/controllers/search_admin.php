<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class SEARCH_ADMIN extends MY_Controller {

	function __construct() {
            
		parent::__construct();
		$this->load->model('resources_model');
		$this->load->model('modules_model');
		$this->load->model('lessons_model');
		$this->load->model('content_page_model');
		$this->load->model('interactive_assessment_model');
		$this->load->model('assignment_model');
		$this->load->model('user_model');
		$this->load->model('search_model');
		$this->load->library('zend');
		$this->zend->load('Zend/Search/Lucene'); 
	}
 
	function index() {	
		
		$this->_paste_public();
	}

	function rebuild(){

		// Delete
		$this->delete();
		// Create
		$this->create();
		// Index:
		// Resources
		$this->index_resources();
		// Lessons
		$this->index_lessons();
		// Modules
		$this->index_modules();
		// Students
		$this->index_students();

		echo 'Search Index Rebuilt';

	}

	function delete(){

		$files = glob(APPPATH . 'search/index/*'); // get all file names
		foreach($files as $file){ // iterate files
			if(is_file($file)){
				unlink($file); // delete file
			}
		}

	}

	function create(){
		$index = new Zend_Search_Lucene(APPPATH . 'search/index', true);
	}

	public function delete_document(){

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
	}

	function index_resources(){


		$resources = $this->resources_model->get_all_resources();
		// $this->_data['resources'] = array();
		
		foreach ($resources as $key => $resource) {
			// if($resource->resource_name){
				// echo $resource->name . ' <br/>';
				// if(!file_get_contents("/uploads/resources/temp/".$resource->resource_name, "r")){
				// 	$this->resources_model->delete_resource($resource->id);
				// }
				$resource = json_decode(json_encode($resource), true);
				$this->search_model->add_resource($resource);
			// }
		}
		return;

	}

	function index_students(){


		$users = $this->user_model->get_users();

		foreach ($users as $key => $user) {
			echo $user->first_name.'</br>';
			$user = json_decode(json_encode($user), true);
			$this->search_model->add_user($user);
		}

		return;

	}

	function index_modules(){

		$modules = $this->modules_model->get_all_modules();

		foreach ($modules as $key => $module) {
			// echo $module->name.' '.$module->intro.'</br>';
			$module = json_decode(json_encode($module), true);
			$this->search_model->add_module($module);

		}
		
		return;

	}

	function index_lessons(){

		$lessons = $this->lessons_model->get_all_lessons();

		foreach ($lessons as $key => $lesson) {
			// echo $lesson->name.' '.$lesson->intro.'</br>';
			$lesson = json_decode(json_encode($lesson), true);
			$this->search_model->add_lesson($lesson);
		}

		return;

	}

}
