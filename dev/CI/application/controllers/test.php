<?php
if (!defined('BASEPATH'))    exit('No direct script access allowed');
class Test extends MY_Controller {
    function __construct() {       
        
        parent::__construct(); 
    
        $this->lang->load('openid', 'english');
        $this->load->library('openid');
        $this->load->helper('url');
        //$this->output->enable_profiler(TRUE);
    
    
    }
   
    function Test()
    {
        //parent::Controller();

        
    }

    // Index
    function index()
    {
    if ($this->input->post('action') == 'verify')
    {
        $user_id = $this->input->post('openid_identifier');
        //$pape_policy_uris = $this->input->post('policies');

        //if (!$pape_policy_uris)
        //{
        //  $pape_policy_uris = array();
        //}

        
        $this->config->load('openid');      
        $req = $this->config->item('openid_required');
        $opt = $this->config->item('openid_optional');
        $policy = site_url($this->config->item('openid_policy'));
        $request_to = site_url($this->config->item('openid_request_to'));

        $this->openid->set_request_to($request_to);
        $this->openid->set_trust_root(base_url());
        $this->openid->set_args(null);
        //$this->openid->set_sreg(true, $req, $opt, $policy);
        //$this->openid->set_pape(true, $pape_policy_uris);
        $this->openid->authenticate($user_id);
    } 
/*
    $data['pape_policy_uris'] = array(
        PAPE_AUTH_MULTI_FACTOR_PHYSICAL,
        PAPE_AUTH_MULTI_FACTOR,
        PAPE_AUTH_PHISHING_RESISTANT
        );
*/
    $this->load->view('view_openid', $data);

    }

    // Policy
    function policy()
    {
      $this->load->view('view_policy');
    }

    // set message
    function _set_message($msg, $val = '', $sub = '%s')
    {
        return str_replace($sub, $val, $this->lang->line($msg));
    }

    // Check
    function check()
    {    
      $this->config->load('openid');
      $request_to = site_url($this->config->item('openid_request_to'));

      $this->openid->set_request_to($request_to);
    $response = $this->openid->getResponse();

    switch ($response->status)
    {
        case Auth_OpenID_CANCEL:
            $data['msg'] = $this->lang->line('openid_cancel');
            break;
        case Auth_OpenID_FAILURE:
            $data['error'] = $this->_set_message('openid_failure', $response->message);
            break;
        case Auth_OpenID_SUCCESS:
            $openid = $response->getDisplayIdentifier();
            $esc_identity = htmlspecialchars($openid, ENT_QUOTES);

            $data['success'] = $this->_set_message('openid_success', array($esc_identity, $esc_identity), array('%s','%t'));

            if ($response->endpoint->canonicalID) {
                $data['success'] .= $this->_set_message('openid_canonical', $response->endpoint->canonicalID);
            }

            $sreg_resp = Auth_OpenID_SRegResponse::fromSuccessResponse($response);
            $sreg = $sreg_resp->contents();

            foreach ($sreg as $key => $value)
            {
                $data['success'] .= $this->_set_message('openid_content', array($key, $value), array('%s','%t'));
            }
            
            break;
     }


    $this->load->view('view_openid', $data);   
    }

}