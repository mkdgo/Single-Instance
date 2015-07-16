<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class A1 extends MY_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('user_model');
        $this->lang->load('openid', 'english');
        $this->load->library('openid');
        $this->load->library('parser');
        $this->load->library('email');

        $this->load->helper('url');
    }

    function index() {

        $this->_data['login_error'] = '';
        $this->_data['openid_msg'] = '';
        $this->_data['openid_error'] = '';
        $this->_data['openid_success'] = '';
        $this->_data['profile_missing_data'] = '';
        $this->_data['esc_identity'] = '';
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
        } else if ($this->input->post('action') == 'verify') {
            $user_id = $this->input->post('openid_identifier');

            //$pape_policy_uris = $this->input->post('policies');
            //if (!$pape_policy_uris)
            //{check
            //  $pape_policy_uris = array();
            //}
            $ac_prm = '';
            $openID_message = 'Checking Openid URL ...';
            if ($this->input->post('account_type')) {
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
            $screen_message = "<html><head><title></title></head><body style='background-color: #c72d2d;' onload='$(\"#container\").hide();document.getElementById(\"%FID%\").submit()'><div style=\"display: none;\">%FHTML%</div>" . $openID_message . "</body></html>";

            $this->openid->authenticate($user_id, $screen_message);
        }

        //var_dump($this->session->all_userdata());   
        $this->_checkIfLoged();
        $this->_paste_public();
    }

    private function _index_onelogin($ACT) {
        $this->load->library('onelogin');
        $this->config->load('onelogin');
        $OL_settingsInfo = $this->config->item('onelogininfo');
        $OlAuth = $this->onelogin->OlAuth($OL_settingsInfo);

        $this->_data['login_error'] = '';

        if ($ACT == 'sso') {
            $OlAuth->login();
        } elseif ($ACT == 'acs') {

            $OlAuth->processResponse();
            if (!$OlAuth->isAuthenticated()) {
                $this->_data['login_error'] = 'Onelogin - Not authenticated!';
            } else {
                $esc_identity_data = $OlAuth->getAttributes();
                $esc_identity = $esc_identity_data['User.email'][0];
                $users = $this->user_model->get_user_by_oneloginid($esc_identity);

                if (!$users) {
                    $pass = $this->user_model->generatePassword(8);

                    $U_type = 'student';
                    if ($esc_identity_data['department'][0] == 'teacher')
                        $U_type = 'teacher';

                    $new_user = array(
                        'email' => $esc_identity,
                        'password' => md5($pass),
                        'first_name' => $esc_identity_data['User.FirstName'][0],
                        'last_name' => $esc_identity_data['User.LastName'][0],
                        'user_type' => $U_type,
                        //birthdate!!!
                        'birthdate' => '',
                        //student_year!!!
                        'student_year' => 4
                    );

                    $register_user_id = $this->user_model->save_user($new_user);
                    $this->user_model->assign_user_oneloginid($esc_identity, $register_user_id, $pass);
                    $users = $this->user_model->get_user_by_oneloginid($esc_identity);
                    $user = $users[0];
                } else {
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

                $this->load->library('nativesession');
                $this->nativesession->set('onelogin_id', $session_array);
                redirect('/a1/index/rl', 'refresh');
            }
        } elseif ($ACT == 'slo') {
            $OlAuth->logout();
        } elseif ($ACT == 'sls') {
            redirect('/logout', 'refresh');
        } elseif ($ACT == 'rl') {
            $this->load->library('nativesession');
            if (is_array($this->nativesession->get('onelogin_id'))) {
                $temp_storage = $this->nativesession->get('onelogin_id');
                $this->nativesession->set('onelogin_id', '');
                $this->session->set_userdata($temp_storage);
            }
        } elseif ($ACT == 'sco') {
            if (ini_get("session.use_cookies")) {
                $params = session_get_cookie_params();
                setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
            }
            session_destroy();
            redirect('/', 'refresh');
        }

        $this->_checkIfLoged();
        $this->_paste_public('a1_onelogin');
    }

    function check() {
        $this->_data['login_error'] = '';
        $this->_data['openid_msg'] = '';
        $this->_data['openid_error'] = '';
        $this->_data['openid_success'] = '';
        $this->_data['profile_missing_data'] = '';
        $this->_data['esc_identity'] = '';

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

        switch ($response->status) {
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

                if (!$users) {
                    $pass = $this->user_model->generatePassword(8);
                    $mail = 'system_user_' . time() . '@ediface.org';

                    $new_user = array(
                        'email' => $mail,
                        'password' => md5($pass),
                        'first_name' => '',
                        'last_name' => '',
                        'birthdate' => '',
                        'user_type' => ""
                    );

                    $register_user_id = $this->user_model->save_user($new_user);
                    $this->user_model->assign_user_openid($esc_identity, $register_user_id, $pass);
                    $users = $this->user_model->get_user_by_openid($esc_identity);
                    $user = $users[0];
                } else {
                    $user = $users[0];
                }

                $account_type = $this->session->flashdata('account_type');
                if ($account_type && $user->user_type == "") {
                    $user->user_type = $account_type;
                    $this->user_model->save_user(array('user_type' => $account_type), $user->id);
                }

                $session_array = array(
                    'id' => $user->id,
                    'email' => $user->email,
                    'first_name' => $user->first_name,
                    'last_name' => $user->last_name,
                    'birthdate' => $user->birthdate,
                    'user_type' => $user->user_type,
                );

                if ($session_array['user_type'] == '') {
                    $this->_data['profile_missing_data'] = 1;
                    $this->_data['esc_identity'] = $esc_identity;
                } else {
                    $this->session->set_userdata($session_array);
                }
                break;
        }
        $this->_checkIfLoged();
        $this->_paste_public();
    }

    function _checkIfLoged() {
        if ($this->session->userdata('user_type') == "teacher") {
            redirect('/b2');
//            redirect('/b2', 'refresh');
        } elseif ($this->session->userdata('user_type') == "student") {
            redirect('/b1');
//            redirect('/b1', 'refresh');
        }
    }

    function _set_message($msg, $val = '', $sub = '%s') {
        return str_replace($sub, $val, $this->lang->line($msg));
    }

    public function _remap($method, $params) {
        if ($this->onelogin_allowed) {
            if ($method == 'index') {
                if ($this->defaultIDP == 'onelogin') {
                    $this->_index_onelogin($params[0]);
                } else {
                    $this->index();
                }
            } else {
                $this->$method();
            }
        } else {
            $this->$method();
        }
    }

    public function passwordrecovery() {
        $method = strval($this->input->server('REQUEST_METHOD'));

        if ($method === 'GET') {
            $this->_data['status'] = $this->session->flashdata('password_recovery_status');
            $this->_data['email_used'] = $this->session->flashdata('password_recovery_email_used');

            $this->_checkIfLoged();
            $this->_paste_public('a1_passwordrecovery');
        } else {
            $emailUsed = trim($this->input->post('email', true));
            $this->session->set_flashdata('password_recovery_email_used', $emailUsed);

            if ($emailUsed === '') {
                $this->session->set_flashdata('password_recovery_status', 'Please enter a valid email address.');
                redirect(base_url() . 'a1/passwordrecovery', 'refresh');
            }

            $user = $this->user_model->get_user_by_email($emailUsed);
            if (!$user) {
                $this->session->set_flashdata('password_recovery_status', 'This email address does not exist in our database.');
                redirect(base_url() . 'a1/passwordrecovery', 'refresh');
            }

            $cryptToken = preg_replace("/[^a-zA-Z0-9]+/", "", base64_encode(crypt($this->user_model->generatePassword(6) . $emailUsed . $user['id'], $this->user_model->generatePassword(15))));

            if ($this->_sendPasswordRecoveryEmail($emailUsed, $user['first_name'], $cryptToken)) {
                $this->user_model->setPasswordRecoveryToken($user['id'], $cryptToken);
                $this->session->set_flashdata('password_recovery_status', 'Password recovery instructions have been sent to your email address.');
            } else {
                $this->session->set_flashdata('password_recovery_status', 'An error occurred while trying to send password recovery instructions to your email address.');
            }
            redirect(base_url() . 'a1/passwordrecovery', 'refresh');
        }
    }

    private function _sendPasswordRecoveryEmail($recepient, $firstName, $token) {
        $this->email->initialize(array(
            'crlf' => '\r\n',
            'newline' => '\r\n',
            'protocol' => 'mail',
            'mailtype' => 'html'
        ));

        $data = array();
        $data['firstName'] = $firstName;
        $data['token'] = $token;
        $data['baseURL'] = base_url();

        $emailBody = $this->parser->parse('mail_templates/password_reset', $data, true);

        $this->email->from('support@ediface.org', 'support@ediface.org');
        $this->email->to($recepient);
        $this->email->subject('User Account password reset');
        $this->email->message($emailBody);
        $sent = $this->email->send();

        return $sent;
    }

    public function passwordreset() {
        $method = strval($this->input->server('REQUEST_METHOD'));

        if ($method === 'GET') {
            $token = trim($this->input->get('token'));
            $user = $this->user_model->get_user_by_password_recovery_token($token);

            if (!$user) {
                $this->_data['passwordreset_status'] = false;
            } else {
                $this->_data['passwordreset_status'] = true;
                $this->_data['passwordreset_token'] = $token;
                $success = $this->session->flashdata('passwordreset_success');
                if ($success) {
                    $this->user_model->setPasswordRecoveryToken($user['id'], '');
                    $this->_data['passwordreset_success'] = true;
                }
            }

            $serverError = $this->session->flashdata('passwordreset_server_error');
            if ($serverError) {
                $this->_data['passwordreset_server_error'] = true;
            }

            $this->_checkIfLoged();
            $this->_paste_public('a1_passwordreset');
        } else {
            $token = trim($this->input->post('token'));
            $user = $this->user_model->get_user_by_password_recovery_token($token);

            if (!$user) {
                redirect(base_url() . 'a1/passwordreset?token=' . $token, 'refresh');
            }

            $password = trim($this->input->post('password', TRUE));
            $confirmPassword = trim($this->input->post('confirmPassword', TRUE));

            if ($password === '' || $confirmPassword === '' || $password !== $confirmPassword) {
                $this->session->set_flashdata('passwordreset_server_error', true);
                redirect(base_url() . 'a1/passwordreset?token=' . $token, 'refresh');
            }

            $this->user_model->update_user_password($user['id'], md5($password));
            $this->session->set_flashdata('passwordreset_success', true);

            redirect(base_url() . 'a1/passwordreset?token=' . $token, 'refresh');
        }
    }

}
