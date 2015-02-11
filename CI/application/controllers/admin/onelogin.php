<?php if (!defined('BASEPATH'))exit('No direct script access allowed');

class Onelogin extends MY_Controller {

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
                
                $this->_paste_admin(false,'admin/onelogin');
                
               
                
	}

    public function create_user()
    {

        if($this->input->post('submit')) {

            $firstname = $this->input->post("first_name");
            $surname=$this->input->post('surname');
            $email=$this->input->post('email');
            $password = $this->input->post('password');

            $url = "https://app.onelogin.com/api/v1/users.xml";
            $request = "<user><firstname>$firstname</firstname><lastname>$surname</lastname>" .
                "<email>$email</email></user>";
            $headers = array('Content-type: application/xml', 'Content-Length: ' . strlen($request));
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_USERPWD, 'df7b85e8e748ceed57195ca8d03592635ade165c');
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
            curl_setopt($ch, CURLOPT_HEADER, true);

            $http_result = curl_exec($ch);
            $error = curl_error($ch);
            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            curl_close($ch);

            if ($error) {
                print $error;
            } else {
                preg_match("/Location:.*\/users\/(\d*)\.xml/", $http_result, $matches);
                $id = $matches[1];
                print "ID: $id\n";
                print_r($http_result);
                echo'..end create user.....';

               $this->set_user_password($id,$password);

            }
        }
    }


    public function set_user_password($user_id,$password)
    {





    $url = "https://app.onelogin.com/api/v2/users/$user_id/set_password.xml";


        $request = "<user><password>$password</password>".
  "<password_confirmation>$password</password_confirmation>".
  "<password_salt></password_salt>".
  "<password_algorithm>salt+sha256</password_algorithm></user>";
        $headers = array('Content-type: application/xml','Content-Length: ' . strlen($request));
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_USERPWD, 'df7b85e8e748ceed57195ca8d03592635ade165c');
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
        curl_setopt($ch, CURLOPT_HEADER, true);

        $http_result = curl_exec($ch);
        $error       = curl_error($ch);
        $http_code   = curl_getinfo($ch ,CURLINFO_HTTP_CODE);

        curl_close($ch);

        if ($error) {
            print $error;
        } else {
            preg_match("/Location:.*\/users\/(\d*)\.xml/", $http_result, $matches);
            $id = $matches[1];


            print_r($http_result);
        }
    }


}
?>
