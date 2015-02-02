<?phpif (!defined('BASEPATH'))    exit('No direct script access allowed');
class Users extends MY_Controller {

    public $_id = '';
    private $_validation_array = array();

    function __construct() {
        parent::__construct();

        $this->load->model('admin/user_model');
        $this->load->library('langs_lib');
        $this->load->library('interface_lib');

        $this->_data['_controller_name'] = strtolower(get_class($this));
        $this->_data['_controller_title'] = get_class($this);
        $this->_data['_menu_selected'] = '/admin/users/';

        $this->_id = $this->input->post('id', true);
        $this->_validation_array = $this->config->item('user_validation');
    }

    function index() {
        $filter_data = $this->_filter();
        $order_arr = $this->_sort();

        $users_list = $this->user_model->get_users_list($filter_data, $order_arr);
        $this->_data['objects'] = array();
        if (count($users_list)) {
            $this->_data['message_filter'] = '';
            $this->_data['hide_table'] = '';

            foreach ($users_list as $row) {
                $row_id = $row->id;
                $this->_data['objects'][$row_id]['id'] = $row->id;
                $this->_data['objects'][$row_id]['email'] = $row->email;
                $this->_data['objects'][$row_id]['nickname'] = $row->nickname;
                $this->_data['objects'][$row_id]['last_name'] = $row->last_name;
                $this->_data['objects'][$row_id]['user_type'] = $this->langs_lib->get_lang_content($row->user_type_id, 'user_types', 1, 'name');
                $this->_data['objects'][$row_id]['ip'] = $row->ip;
            }
        }
        $this->_paste_admin('users_list');
    }

    function detail($id = '') {
        $this->_id = $id;
        if ($id == '') {
            $temp_object_id = rand(0, 9999);
        } else {
            $temp_object_id = $id;
        }

        $this->_generate_form($id, $temp_object_id);
        $this->_paste_admin('users_detail');
    }

    function save() {
        if (!$this->user_model->check_user($this->_id)) {
            $this->_id = '';
        }
        if ($this->input->post('temp_object_id')) {
            $temp_object_id = $this->input->post('temp_object_id');
        }

        if ($this->_validation($this->_id) == 'ok') {
            $db_data = array(
                'id' => trim($this->_id),
                'email' => trim($this->input->post('email', true)),
                'nickname' => trim($this->input->post('nickname', true)),
                'name' => trim($this->input->post('name', true)),
                'last_name' => trim($this->input->post('last_name', true)),
                'zip' => trim($this->input->post('zip', true)),
                'address' => trim($this->input->post('address', true)),
                'phone' => trim($this->input->post('phone', true)),
                'cell_phone' => trim($this->input->post('cell_phone', true)),
                'website' => trim($this->input->post('website', true)),
                'skype' => trim($this->input->post('skype', true)),
                'personal_message' => trim($this->input->post('personal_message', true)),
                'moderator' => trim($this->input->post('moderator', true)),
                'suggested' => trim($this->input->post('suggested', true)),
                'model' => trim($this->input->post('model', true)),
                'live_girl' => trim($this->input->post('live_girl', true)),
                'email_visible' => trim($this->input->post('email_visible', true)),
                'cellphone_visible' => trim($this->input->post('cellphone_visible', true)),
                'birthdate' => date('Y-m-d', strtotime($this->input->post('birthdate'))),
                'ip' => $_SERVER['REMOTE_ADDR'],
                'user_type_id' => trim($this->input->post('user_types', true)),
                'profile_type_id' => trim($this->input->post('profile_types', true)),
                'sex_id' => trim($this->input->post('sex', true)),
                'city_id' => trim($this->input->post('cities', true)),
                'region_id' => trim($this->input->post('regions', true)),
                'state_id' => trim($this->input->post('states', true)),
                'zodiacal_sign_id' => trim($this->input->post('zodiacal_sign', true)),
            );
            if ($this->input->post('password')) {
                $db_data['password'] = md5(trim($this->input->post('password', true)));
            }

            $this->user_model->save_user($db_data, $this->_id);

            if (!$this->_id) {
                $this->_id = $this->db->insert_id();

                $this->load->model('admin/pictures_model');
                $this->pictures_model->update_temp_pics($temp_object_id, $this->_id);
            }

            if ($this->_id != null) {
                $this->_data['_message'] = $this->session->set_flashdata('_message', 'Record updated.');
            } else {
                $this->_data['_message'] = $this->session->set_flashdata('_message', 'Record saved.');
            }

            redirect('admin/' . $this->_data['_controller_name'], 'refresh');
        } else {
            $this->_generate_form($this->_id, $temp_object_id);
            $this->_paste_admin('users_detail');
        }
    }

    private function _validation($id) {
        $this->form_validation->set_rules($this->_validation_array);
        if ($id != '') {
            $this->form_validation->set_rules('password', 'Password', 'min_length[4]|max_length[30]|xss_clean');
        }

        if ($this->form_validation->run('user_validation') == TRUE) {
            return 'ok';
        }
    }

    function _generate_form($id = '', $temp_object_id = '') {
        $this->_data['password_alert'] = '';
        if ($id != '') {
            $object = $this->user_model->get_user($id);
            $this->_data['password_alert'] = $this->interface_lib->alert('If you leave password empty, password will not be changed.');
        }

        $this->_data['form_open'] = form_open('/admin/' . $this->_data['_controller_name'] . '/save');
        $this->_data['form_close'] = form_close();
        $this->_data['form_submit'] = form_submit('', 'Save', 'class="btn btn-info"');

        $this->_data['id'] = form_hidden('id', $this->_id);

        $this->_data['email_label'] = form_label('Email *', 'email');
        $this->_data['email'] = form_input('email', set_value('email', isset($object->email) ? $object->email : ''));
        $this->_data['email_visible_label'] = form_label('Email visible', 'email_visible');
        $this->_data['email_visible'] = form_checkbox('email_visible', '1', (isset($object) && $object->email_visible) ? true : false);

        $this->_data['nickname_label'] = form_label('Nickname *', 'nickname');
        $this->_data['nickname'] = form_input('nickname', set_value('nickname', isset($object->nickname) ? $object->nickname : ''));

        $this->_data['password_label'] = form_label('Password *', 'password');
        $this->_data['password'] = form_password('password');

        $this->_data['name_label'] = form_label('Name *', 'name');
        $this->_data['name'] = form_input('name', set_value('name', isset($object->name) ? $object->name : ''));

        $this->_data['last_name_label'] = form_label('Last Name *', 'last_name');
        $this->_data['last_name'] = form_input('last_name', set_value('last_name', isset($object->last_name) ? $object->last_name : ''));

        $this->_data['zip_label'] = form_label('ZIP Code', 'zip');
        $this->_data['zip'] = form_input('zip', set_value('zip', isset($object->zip) ? $object->zip : ''));

        $this->_data['address_label'] = form_label('Address', 'address');
        $this->_data['address'] = form_input('address', set_value('address', isset($object->address) ? $object->address : ''));

        $this->_data['phone_label'] = form_label('Phone', 'phone');
        $this->_data['phone'] = form_input('phone', set_value('p