<?php
/*
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class D3_teacher extends MY_Controller {

    function __construct() {
        parent::__construct();
    }

    function index() {
        
        $this->_paste_public();
    }

}
*/


if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class D1B extends MY_Controller {

    function __construct() {
        parent::__construct();
        
        $this->load->model('modules_model');
        $this->load->model('lessons_model');
        $this->load->model('subjects_model');
		$this->load->model('resources_model');
        $this->load->library('breadcrumbs');
        
        $this->load->library( 'nativesession' );
    }

    function index($subject_id = '') {
		$this->_data['subject_id'] = $subject_id;
		$subject = $this->subjects_model->get_single_subject($subject_id);
                $subject_curriculum = $this->subjects_model->get_main_curriculum($subject_id);
                
		$this->_data['subject_title'] = $subject->name;
		$this->_data['subject_intro'] = $subject_curriculum->intro;
		$this->_data['subject_objectives'] = $subject_curriculum->objectives;
		$this->_data['subject_teaching_activities'] = $subject_curriculum->teaching_activities;
		$this->_data['subject_assessment_opportunities'] = $subject_curriculum->assessment_opportunities;
		$this->_data['subject_notes'] = $subject_curriculum->notes;
                
                $this->_data['subject_curriculum_id'] = $subject_curriculum->id;
		
                
                $selected_year = $this->getSelectYearTeacher($this->nativesession, $this->subjects_model, $subject_id, '');
                
		if($subject_id){
                    $years = $this->subjects_model->get_subject_years($subject_id);			
		}else{
			$years = 0;
		}
        
	    if(count($years)==0){
				$this->_data['hide_years'] = 'hidden';
				$this->_data['years'] = array();
			} else {
				$this->_data['hide_years'] = '';
			}
			$odd=0;
	    foreach($years as $year){
				$year_id = $year->id;
				$this->_data['years'][$year_id]['year_id'] = $year_id;
				$this->_data['years'][$year_id]['year_name'] = $year->year;
	            if($odd%2==0){  
	                $this->_data['years'][$year_id]['float'] = 'moduleLeft';
	                   $this->_data['years'][$year_id]['clear'] = '';
	            }else{
	                $this->_data['years'][$year_id]['float'] = 'moduleRight';
	                $this->_data['years'][$year_id]['clear'] = '<div class="clear"></div>';
	            }
	            $odd++;
			

	    }
                $this->breadcrumbs->push('Home', base_url());
		$this->breadcrumbs->push('Subjects', '/d1');
		$this->breadcrumbs->push($subject->name, "/d1a/index/".$subject_id);
                //$this->breadcrumbs->push('Year '.$selected_year->year, "/d2_teacher/index/".$subject_id);
		$this->breadcrumbs->push("Curriculum", "/");
              
                
		$this->_data['breadcrumb'] = $this->breadcrumbs->show();

        $this->_paste_public();
        
    }

	function save() {
            
            
		$subject_id = $this->input->post('subject_id', true);
                $curriculum_id = $this->input->post('curriculum_id', true);
		//$module_id = $this->input->post('module_id', true);
		$db_data = array(
			'intro' => trim($this->input->post('subject_intro', true)),
			'objectives' => trim($this->input->post('subject_objectives', true)),
			'teaching_activities' => trim($this->input->post('subject_teaching_activities', true)),
			'assessment_opportunities' => trim($this->input->post('subject_assessment_opportunities', true)),
			'notes' => trim($this->input->post('subject_notes', true))
		);

		$this->subjects_model->save_curriculum($db_data, $subject_id,$curriculum_id);
                redirect("d1b/index/{$subject_id}/{$curriculum_id}", 'refresh');
	}
        
        
        
        function saveajax() {
        $dt = $this->input->post('data');

        $dt_ = array();
        foreach( $dt as $k => $v ) $dt_[$v['name']] = $v['value'];

        if( $dt_ ) {
            $subject_id = $dt_['subject_id'];
            $curriculum_id = $dt_['curriculum_id'];
            if( $dt_['publish'] ) {
                $dt_['publish'] = 0;
            } else {
                $dt_['publish'] = 1;
            }

            $db_data = array(
                'intro' => $dt_['subject_intro'],
                'objectives' => $dt_['subject_objectives'],
                'teaching_activities' => $dt_['subject_teaching_activities'],
                'assessment_opportunities' => $dt_['subject_assessment_opportunities'],
                'notes' => $dt_['subject_notes'],
                'publish' => $dt_['publish']
            );
            $this->subjects_model->save_curriculum($db_data, $subject_id,$curriculum_id);

            echo json_encode( $dt_['publish'] );
        }


    }
        
        
        
        public function curriculum($subject_id = '',$curriculum_id='') {
            
            
        $this->_data['subject_id'] = $subject_id;
        $this->_data['curriculum_id'] = $curriculum_id;
        $subject = $this->subjects_model->get_single_subject($subject_id);
       
        //$subject = $this->subjects_model->get_single_subject($subject_id);
        $subject_curriculum = $this->subjects_model->get_main_curriculum($subject_id);
        
        
        $this->_data['subject_title'] = $subject->name;
        $this->_data['subject_intro'] = $subject_curriculum->intro;
        $this->_data['subject_objectives'] = $subject_curriculum->objectives;
        $this->_data['subject_teaching_activities'] = $subject_curriculum->teaching_activities;
        $this->_data['subject_assessment_opportunities'] = $subject_curriculum->assessment_opportunities;
        $this->_data['subject_notes'] = $subject_curriculum->notes;
        $this->_data['subject_publish'] = $subject_curriculum->publish;

        $this->_data['publish_active'] = '';
        $this->_data['publish_text'] = 'PUBLISH';
        if( $this->_data['subject_publish'] == 1 ) {
            $this->_data['publish_active'] = 'active';
            $this->_data['publish_text'] = 'PUBLISHED';
        } else {
            $this->_data['publish_active'] = '';
            $this->_data['publish_text'] = 'PUBLISH';
        }

         $selected_year = $this->getSelectYearTeacher($this->nativesession, $this->subjects_model, $subject_id, '');
                
		if($subject_id){
                    $years = $this->subjects_model->get_subject_years($subject_id);			
		}else{
			$years = 0;
		}
        
	    if(count($years)==0){
				$this->_data['hide_years'] = 'hidden';
				$this->_data['years'] = array();
			} else {
				$this->_data['hide_years'] = '';
			}
			$odd=0;
	    foreach($years as $year){
				$year_id = $year->id;
				$this->_data['years'][$year_id]['year_id'] = $year_id;
				$this->_data['years'][$year_id]['year_name'] = $year->year;
	            if($odd%2==0){  
	                $this->_data['years'][$year_id]['float'] = 'moduleLeft';
	                   $this->_data['years'][$year_id]['clear'] = '';
	            }else{
	                $this->_data['years'][$year_id]['float'] = 'moduleRight';
	                $this->_data['years'][$year_id]['clear'] = '<div class="clear"></div>';
	            }
	            $odd++;
			

	    }
        $this->breadcrumbs->push('Home', base_url());
        $this->breadcrumbs->push('Subjects', '/d1');
        $this->breadcrumbs->push($subject->name, "/d1a/index/".$subject_id);
        //$this->breadcrumbs->push('Year '.$selected_year->year, "/d2_teacher/index/".$subject_id);
        $this->breadcrumbs->push("Curriculum", "/");


        $this->_data['breadcrumb'] = $this->breadcrumbs->show();

        $this->_paste_public('d1b_curriculum');

    }

        
        
}

