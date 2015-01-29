<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Search extends MY_Controller {

	function Search()
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
		$this->load->library('zend');
		$this->zend->load('Zend/Search/Lucene'); 
	}
 
	function create($url)
	{
		// This method should be authenticated, or removed once the index is created.
		// TODO: Some sort of site spidering process to add the entire site to the index.
 
		$index = new Zend_Search_Lucene(APPPATH . 'search/index', true);
    	$doc = Zend_Search_Lucene_Document_Html::loadHTMLFile($url);
    	$doc->addField(Zend_Search_Lucene_Field::Text('url', $url));
    	$index->addDocument($doc);
 
	}
 
	function index()
	{
		$this->_data['query'] = '';
		$this->_data['resources'] = [];
		$this->_paste_public();
	}

	function results($query='')
	{	
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
 
	public function query($query)
	{
		$index = Zend_Search_Lucene::open(APPPATH . 'search/index');
		$hits = $index->find($query);
		if(count($hits) <= 0){
			$this->_data['resources'] = [];
			$this->_data['resources']['query'] = $query;
			return $this->_data['resources'];
		}

		$this->_data['resources'] = [];

		foreach ($hits as $key => $hit) {
		    // return Zend_Search_Lucene_Document object for this hit
		    $document = $hit->getDocument();
		    // Get the ID for the resource stored in the DB and load it:
		    if($hit->resource_id){
		    	$resource = $this->resources_model->get_resource_by_id($hit->resource_id);
			}else{
				$resource = NULL;
			}
		    $this->_data['resources'][$key] = [];
		 	$this->_data['resources'][$key]['title'] = $document->name;
		 	$this->_data['resources'][$key]['link'] = $document->link;
		 	$this->_data['resources'][$key]['description'] = $document->description;
		 	$this->_data['resources'][$key]['id'] = $hit->id;
		 	// Get Keywords:
		 	try{
		 	$this->_data['resources'][$key]['keyword'] = $hit->keyword;
		 	}catch(exception $e){}
		 	$offset = stripos($document->resource_name, '.');
			if ( $offset === false ){
			    //error, end of wasn't found
			}else{
				$offset += strlen('.');
				$this->_data['resources'][$key]['filetype'] = substr($document->resource_name, $offset);
			}
			if($resource->teacher_id){
				$teacher = $this->user_model->get_user($resource->teacher_id);
			}else{
				$teacher = NULL;
			}
			if($teacher){
				$this->_data['resources'][$key]['user'] = $teacher->first_name . ' ' . $teacher->last_name;
			}
		 	$this->_data['resources'][$key]['score'] = $hit->score;
		 	$this->_data['resources'][$key]['resource_id'] = $hit->resource_id;
		 	$resource_object = $this->resources_model->get_resource_by_id($hit->resource_id);
			$this->_data['resources'][$key]['preview'] = $this->resoucePreview($resource_object, '/c1/resource/');
			
		}
		return $this->_data;
	}

	public function formquery($query = '')
	{
		if(empty($query)){
 			$data = $this->query($this->input->post('query'));
 			$this->parser->parse('search-results', $data);
 		}else{
 			$data = $this->query($query);
 			return $this->parser->parse('search-results', $data, TRUE);
 		}
	}

	public function delete_document()
	{
		$index = Zend_Search_Lucene::open(APPPATH . 'search