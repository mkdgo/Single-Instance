<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class automations extends MY_Controller {

    private $result = '';
    
	function __construct() {
		parent::__construct();
		$this->load->model('assignment_model');
                $this->load->model('resources_model');
                
	}

	public function updateDraftSubmissions()
        {
		$assignments = $this->assignment_model->get_draftSubmissions();
                
                foreach($assignments as $sk=>$sv)
                {
                    $Adtl = $this->assignment_model->get_assignment_details($sv->id, 1);
                    $Ares = $this->resources_model->get_assignment_resources($sv->id);
                    
                    if(!empty($Adtl) || !empty($Ares))
                    {
                        $this->result.='Assignment submited: '.$sv->id.'<br>';
                        $this->assignment_model->save(array('publish'=>1), $sv->id, FALSE);
                    }
                }
                
                $this->automationDone();
             
	}
	
        private function automationDone()
        {
            echo $this->result;
            $this->result = '';
        }
}