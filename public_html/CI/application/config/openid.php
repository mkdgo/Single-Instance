<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['openid_storepath'] = 'tmp';
$config['openid_policy'] = '';
$config['openid_required'] = array('nickname');
$config['openid_optional'] = array('fullname', 'email');
$config['openid_request_to'] = 'a1/check';

?>