<?php if (!defined('BASEPATH'))exit('No direct script access allowed');

class Subjects extends MY_Controller {

	function __construct(){
		  parent::__construct();
                  
                   $this->load->model('admin_model');
                  
                  if($this->session->userdata('admin_logged')!=true)
                  {
                      redirect(base_url().'admin/login');
                  }
                  
                  
	}

	function index(){
		
                
                $this->_data['_menu']='<li>Admin</li>';
                //$this->_data['content']='HELLO';
                
                
                $this->_data['subjects']  = $this->admin_model->get_all_subjects();
                
                
                
                
                $this->_paste_admin(false,'admin/subjects');
                
               
                
	}
        
        public function add()
        {
            $this->load->library('form_validation');
            $this->load->helper('directory');
            $this->_data['subject_icons'] = directory_map('./uploads/subject_icons');
            
           // print_r($map);
            $this->_data['subject_years']= $this->admin_model->get_all_subject_years();
            
            if($this->input->post('submit'))
            {
               
            $this->form_validation->set_rules('name', 'Subject name', 'trim|required');
            $this->form_validation->set_rules('icon', 'Subject Icon', 'required');
            $this->form_validation->set_rules('year[]', 'Affected Years', 'trim|required');
            $this->form_validation->set_error_delimiters('<p style="text-align:center;"><em style="color:red;">','</em></p>');
		
                    if($this->form_validation->run()===FALSE)
                    {
                        $this->_paste_admin(false,'admin/subjects_add');
                    }
                    else
                    {
                        //update records
                       
                       $s_data = array(
                           'name'=>$this->input->post('name'),
                           'publish'=>$this->input->post('publish'),
                           'icon'=>$this->input->post('icon'));
                        
                        
                    $id =$this->admin_model->add_subject($s_data);    
                        
                    $res = $this->admin_model->update_subject_years($this->input->post('year'),$id);
                    if($res)
                    {
                        redirect(base_url().'admin/subjects');
                    }
                    }
            }
            else
            {
            
            $this->_paste_admin(false,'admin/subjects_add');
            }
        }
        
        
        
        


                        public function view($id)
        {
            $this->_data['single_subject']= $this->admin_model->get_subject_by_id($id);
            
            $this->_data['subject_years']= $this->admin_model->get_subject_years($id);
            
            $this->_paste_admin(false,'admin/subjects_view');
        }
        
        
        public function edit_subject($id)
        {
            $this->output->enable_profiler(TRUE);
             $this->load->helper('directory');
             $this->_data['subject_icons'] = directory_map('./uploads/subject_icons');
             $this->_data['single_subject']= $this->admin_model->get_subject_by_id($id);
             $this->_data['subject_id']= $id;
             $this->load->library('form_validation');
             $this->_data['all_subject_years']= $this->admin_model->get_all_subject_years();
            
             $this->_data['published_subject_years']= $this->admin_model->get_published_subject_years($id);
             
             //$this->_data['subject_years_name']= $this->admin_model-> get_subject_years_name($id);
            
            
            
            if($this->input->post('submit'))
            {
               
            $this->form_validation->set_rules('name', 'Subject name', 'trim|required');
            $this->form_validation->set_rules('year[]', 'Affected Years', 'trim|required');
            $this->form_validation->set_rules('icon', 'Subject Icon', 'required');
            $this->form_validation->set_error_delimiters('<p style="text-align:center;"><em style="color:red;">','</em></p>');
		
           
            
                    if($this->form_validation->run()===FALSE)
                    {
                        $this->_paste_admin(false,'admin/subjects_edit');
                    }
                    else
                    {
                        //update records
                       $s_data = array(
                           'name'=>$this->input->post('name'),
                           'publish'=>$this->input->post('publish'),
                           'icon'=>$this->input->post('icon'));
                    $this->admin_model->update_subject($id, $s_data);    
                        
                    $res = $this->admin_model->update_subject_years($this->input->post('year'),$id);
                    if($res)
                    {
                        redirect(base_url().'admin/subjects');
                    }
                    }
                    
                    
            }
            else
            {
            
            $this->_paste_admin(false,'admin/subjects_edit');
            }
             
             
        }
}
?>
