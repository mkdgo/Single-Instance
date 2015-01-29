<?php if (!defined('BASEPATH'))exit('No direct script access allowed');

class Dashboard extends MY_Controller {

	function __construct(){
		  parent::__construct();
                  
                  
                  
                  if($this->session->userdata('admin_logged')!=true)
                  {
                      redirect(base_url().'admin/login');
                  }
                  
                  
	}

	function index(){
		$data = array();
                
                $this->_data['_menu']='<li>Admin</li>';
                //$this->_data['content']='HELLO';
                
                $this->_paste_admin(false,'admin/dashboard');
                
               
                
	}
}
?>
