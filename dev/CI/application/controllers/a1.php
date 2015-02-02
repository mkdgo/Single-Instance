<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class A1 extends MY_Controller {


    
    
    function __construct() {
        parent::__construct();
        
        $this->load->model('user_model');
        $this->lang->load('openid', 'english');
        $this->load->library('openid');
        
        
        $this->load->helper('url');
        
    }

    function index()
    {
       
        
        $this->_data['login_error'] = '';
        $this->_data['openid_msg']='';
        $this->_data['openid_error']='';
        $this->_data['openid_success']='';
        $this->_data['profile_missing_data']='';
        $this->_data['esc_identity']='';
        

        if ($this->input->post('login_email')) {
            $user = $this->user_model->check_user_exist(
                    $this->input->post('login_email'), $this->input->post('login_password')
            );
 
            if (!empty($user)) {
                $session_array = array(
                    'id' => $user[0]->id,
                    'email' => $user[0]->email,
                    'first_name' => $user[0]->first_name,
                    'last_name' => $user[0]->last_name,
                    'birthdate' => $user[0]->birthdate,
                    'user_type' => $user[0]->user_type,
                    'student_year' => $user[0]->student_year
                );
              $this->session->set_userdata($session_array);
            } else {
                $this->_data['login_error'] = 'Login incorrect.';
            }
        }
        else if ($this->input->post('action')=='verify')
        {
            $user_id = $this->input->post('openid_identifier');
             
            //$pape_policy_uris = $this->input->post('policies');

            //if (!$pape_policy_uris)
            //{check
            //  $pape_policy_uris = array();
            //}
            $ac_prm = '';
            $openID_message = 'Checking Openid URL ...';
            
            
            if ($this->input->post('account_type'))
            {
                $openID_message = 'Setting the account ...';
                $this->session->set_flashdata('account_type', $this->input->post('account_type'));
            }
                
            $this->config->load('openid');      
            $req = $this->config->item('openid_required');
            $opt = $this->config->item('openid_optional');
            $policy = site_url($this->config->item('openid_policy'));
            $request_to = site_url($this->config->item('openid_request_to'));

            $this->openid->set_request_to($request_to);
            $this->openid->set_trust_root(base_url());
            $this->openid->set_args(null);
            $this->openid->set_sreg(true, $req, $opt, $policy);
            //$this->openid->set_pape(true, $pape_policy_uris);
            $screen_message = "<html><head><title></title></head><body style='background-color: #c72d2d;' onload='$(\"#container\").hide();document.getElementById(\"%FID%\").submit()'><div style=\"display: none;\">%FHTML%</div>".$openID_message."</body></html>";

            $this->openid->authenticate($user_id, $screen_message);
        }
           
         
        //var_dump($this->session->all_userdata());   
        $this->_checkIfLoged();
        $this->_paste_public();
        
    }
    
    private function _index_onelogin($ACT)
    {
        $this->load->library('onelogin');
        $this->config->load('onelogin');
        $OL_settingsInfo = $this->config->item('onelogininfo');
        $OlAuth = $this->onelogin->OlAuth($OL_settingsInfo);
        
        $this->_data['login_error'] = '';
        
        if($ACT == 'sso')
        {
            $OlAuth->login();
        }
        elseif($ACT == 'acs')
        {
            
            $OlAuth->processResponse();
            if (!$OlAuth->isAuthenticated())
            {
                    $this->_data['login_error'] = 'Onelogin - Not authenticated!';
            }else
            {
                $esc_identity_data = $OlAuth->getAttributes();
                $esc_identity = $esc_identity_data['User.email'][0];
                $users = $this->user_model->get_user_by_oneloginid($esc_identity);
                    
                    if(!$users)
                    {
                        $pass = $this->user_model->generatePassword(8);
                   
                        $U_type = 'student';
                        if($esc_identity_data['department'][0]=='teacher')$U_type = 'teacher';
                        
                        $new_user = array(
                            'email'=>$esc_identity,
                            'password'=>md5($pass),
                            'first_name'=>$esc_identity_data['User.FirstName'][0],
                            'last_name'=>$esc_identity_data['User.LastName'][0],
                            'user_type'=>$U_type,
                            //birthdate!!!
                            'birthdate'=>'',
                            //student_year!!!
                            'student_year'=>4,
                          
                            
                        );
                        
                        $register_user_id=$this->user_model->save_user($new_user);
                        $this->user_model->assign_user_oneloginid($esc_identity, $register_user_id, $pass);
                        $users = $this->user_model->get_user_by_oneloginid($esc_identity);
                        $user = $users[0];
                        
                    }else
                    {
                        $user = $users[0];
                    }
                    
                        
                        $session_array = array(
                            'id' => $user->id,
                            'email' => $user->email,
                            'first_name' => $user->first_name,
                            'last_name' => $user->last_name,
                            'birthdate' => $user->birthdate,
                            'user_type' => $user->user_type,
                            'student_year' => $user->student_year
                            
                        );
                       // $this->session->set_userdata($session_array);
                        
                    
                        $this->load->library( 'nativesession' );
                        $this->nativesession->set('onelogin_id', $session_array);
                        redirect('/a1/index/rl', 'refresh');
                        
            }
        }elseif($ACT == 'slo')
        {
            $OlAuth->logout();
            
        }elseif($ACT == 'sls')
        {
             redirect('/logout', 'refresh');
            
        }
        elseif($ACT == 'rl')
        {
            $this->load->library( 'nativesession' );
            if( is_array( $this->nativesession->get('onelogin_id') ) )
            {
                $temp_storage = $this->nativesession->get('onelogin_id');
                $this->nativesession->set('onelogin_id', '');
                $this->session->set_userdata($temp_storage);
            }
        }
        
        
        
        
        $this->_checkIfLoged();
        $this->_paste_public('a1_onelogin');
    }
            
    
    function check()
    {  
        $this->_data['login_error'] = '';
        $this->_data['openid_msg']='';
        $this->_data['openid_error']='';
        $this->_data['openid_success']='';
        $this->_data['profile_missing_data']='';
        $this->_data['esc_identity']='';
        
        
        $this->config->load('openid');
        $request_to = site_url($this->config->item('openid_request_to'));
        $req = $this->config->item('openid_required');
        $opt = $this->config->item('openid_optional');
        $policy = site_url($this->config->item('openid_policy'));
        

            $this->openid->set_request_to($request_to);
            $this->openid->set_trust_root(base_url());
           // $this->openid->set_args(null);
           // $this->openid->set_sreg(true, $req, $opt, $policy);
            
        $this->openid->set_request_to($request_to);
       
        
        $response = $this->openid->getResponse();
        
        $this->_data['openid_success'] = $response->status;
        
        
        
            switch ($response->status)
            {
                case Auth_OpenID_CANCEL:
                    $this->_data['openid_msg'] = $this->lang->line('openid_cancel');
                    break;
                case Auth_OpenID_FAILURE:
                    $this->_data['openid_error'] = $this->_set_message('openid_failure', $response->message);
                    break;
                case Auth_OpenID_SUCCESS:
                    $openid = $response->getDisplayIdentifier();
                    $esc_identity = htmlspecialchars($openid, ENT_QUOTES);
                    //$this->_data['openid_success'] = $this->_set_message('openid_success', array($esc_identity, $esc_identity), array('%s','%t'));
                    $this->_data['openid_success'] = '';
                    /*
                    if ($response->endpoint->canonicalID) {
                        $this->_data['openid_success'] .= $this->_set_message('openid_canonical', $response->endpoint->canonicalID);
                    }
                    
                   // $sreg_resp = Auth_OpenID_SRegResponse::fromSuccessResponse($response);
                    //$sreg = $sreg_resp->contents();

                    foreach ($response->endpoint as $key => $value)
                    {
                      print($value);
                      
                    }
                    die( var_dump('$sreg') );
                    */
                    
                    
                    $users = $this->user_model->get_user_by_openid($esc_identity);
                    
                    
                    
                    if(!$users)
                    {
                        $pass=$this->user_model->generatePassword(8);
                        $mail = 'system_user_'.time().'@ediface.org';
                        
                        $new_user = array(
                            'email'=>$mail,
                            'password'=>md5($pass),
                            'first_name'=>'',
                            'last_name'=>'',
                            'birthdate'=>'',
                            'user_type'=>""
                        );
                        
                        $register_user_id=$this->user_model->save_user($new_user);
                        $this->user_model->assign_user_openid($esc_identity, $register_user_id, $pass);
                        $users = $this->user_model->get_user_by_openid($esc_identity);
                        $user = $users[0];
                    }else
                    {
                        $user = $users[0];
                    }
                    
                    $account_type= $this->session->flashdata('account_type');
                    if($account_type  && $user->user_type=="")
                    {
                      
                        $user->user_type = $account_type;
                        $this->user_model->save_user(array('user_type'=>$account_type), $user->id);
                    }
                   
                    
                    
                    $session_array = array(
                        'id' => $user->id,
                        'email' => $user->email,
                        'first_name' => $user->first_name,
                        'last_name' => $user->last_name,
                        'birthdate' => $user->birthdate,
                        'user_type' => $user->user_type
                    );
                    
                    
                   if($session_array['user_type']=='')
                   {
                        $this->_data['profile_missing_data'] = 1;
                        $this->_data['esc_identity'] = $esc_identity;
                   }
                   else
                   {
                        $this->session->set_userdata($session_array);
                   }
                    
                   break;
             }
             
             $this->_checkIfLoged();
             
             $this->_paste_public();
             
    }
    
    
    function _checkIfLoged()
    {
           
           if ($this->session->userdata('user_type') == "teacher") {
                redirect('/b2', 'refresh');
            } elseif ($this->session->userdata('user_type') == "student") {
                redirect('/b1', 'refresh');
            }
    }
    
    function _set_message($msg, $val = '', $sub = '%s')
    {
        return str_replace($sub, $val, $this->lang->line($msg));
    }

    public function _remap($method, $params)
    {
        
        if($this->onelogin_allowed)
        {
            if($method=='index')
            {
               
               $this->_index_onelogin($params[0]);
            }
            
        }else
        {
            $this->$method();
        }    
    }
}
