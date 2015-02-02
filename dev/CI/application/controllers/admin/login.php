<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Login extends MY_Controller {

	function __construct(){
		  parent::__construct();
                  $this->load->model('admin_model');
                  if($this->session->userdata('admin_logged')==true)
        {
            redirect(base_url().'admin/dashboard');
        }
	}

	function index(){
		$data = array();
                
               
               //$login_errors='Wrong username/password';
                if($this->input->post('csfr'))
                {
                   
                $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|xss_clean');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|max_length[32]|xss_clean|sha1');
		$this->form_validation->set_error_delimiters('<p style="text-align:center;"><em style="color:red;">','</em></p>');
		
                    if($this->form_validation->run()===FALSE)
                    {
                        
                    }
                    else
                    {
                        $admin = $this->admin_model->login($this->input->post('email'),  $this->input->post('password'));
                        if(!$admin)
                        {
                        $this->_data['login_errors']='<p style="text-align:center;"><em style=" color:red;">Wrong username/password</em></p>';
                        }
                        else
                        {
                            
                            
                            $admin_data = array('admin_id'=>$admin['id'],'admin_logged'=>'true');
                            $this->session->set_userdata($admin_data);
                            redirect(base_url().'admin/dashboard');
                            
                        }
                    }
                }
                
                
                $this->_paste_admin('admin/_login','admin/login');
                
               
                
	}

	function check(){
		if($this->input->post('login_pass') == '2013el'){			$newdata['admin'] = '2013el';			$this->session->set_userdata($newdata);			redirect('/admin', 'refresh');
		}else{
			redirect('/admin/login', 'refresh');
		}
	}

	function logout(){
		$newdata['admin'] = '';		$this->session->unset_userdata($newdata);		redirect('/admin/login', 'refresh');
	}
}