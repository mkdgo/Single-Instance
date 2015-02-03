<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
ini_set('memory_limit', '-1');


class Uploading extends CI_Controller {

    private $upload_excel_dir;
    private $upload_subjects_logos;
    
    
    function __construct()
	{
		parent::__construct();
                
                $this->upload_excel_dir = './uploads_excel/';
                $this->upload_subjects_logos = './uploads/subject_icons';
                
	}
       
	
        
        public function upload_excel()
        {
                $config['upload_path'] = $this->upload_excel_dir;
		$config['allowed_types'] = 'xls|xlsx|csv';
		$config['max_size']	= '50000000';
		
                $config['encrypt_name']=false;
		$this->load->library('upload', $config);
                
		// Output json as response
		if ( ! $this->upload->do_upload('qqfile'))
		{
			$json['status'] = 'error';
			$json['issue'] = $this->upload->display_errors('','');
			
                        
		}
		else
		{
			
                        
               $json['status'] = 'success';
               $json['success'] = 'true';        

                       
                       
		foreach($this->upload->data() as $k => $v)
		{
		$json[$k] = $v;
                              
		}
		}
                
               
                
                
                echo json_encode($json);
        }
                
        public function upload_subject_image()
        {
                $config['upload_path'] = $this->upload_subjects_logos;
		$config['allowed_types'] = 'png';
		$config['max_size']	= '50000000';
		
                $config['encrypt_name']=false;
		$this->load->library('upload', $config);
                
		// Output json as response
		if ( ! $this->upload->do_upload('qqfile'))
		{
			$json['status'] = 'error';
			$json['issue'] = $this->upload->display_errors('','');
			
                        
		}
		else
		{
			
                        
               $json['status'] = 'success';
               $json['success'] = 'true';        

                       
                       
		foreach($this->upload->data() as $k => $v)
		{
		$json[$k] = $v;
                              
		}
		}
                
               
                
                
                echo json_encode($json);
        }
          
        
        
        
    
}



/* End of file uploading_.php */
