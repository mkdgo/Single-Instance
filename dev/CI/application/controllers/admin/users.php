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
        $this->_data['phone'] = form_input('phone', set_value('phone', isset($object->phone) ? $object->phone : ''));

        $this->_data['cell_phone_label'] = form_label('Cell phone', 'cell_phone');
        $this->_data['cell_phone'] = form_input('cell_phone', set_value('cell_phone', isset($object->cell_phone) ? $object->cell_phone : ''));

        $this->_data['cellphone_visible_label'] = form_label('Cell phone visible', 'cellphone_visible');
        $this->_data['cellphone_visible'] = form_checkbox('cellphone_visible', '1', (isset($object) && $object->cellphone_visible) ? true : false);

        $this->_data['website_label'] = form_label('Website', 'website');
        $this->_data['website'] = form_input('website', set_value('website', isset($object->website) ? $object->website : ''));

        $this->_data['skype_label'] = form_label('Skype', 'skype');
        $this->_data['skype'] = form_input('skype', set_value('skype', isset($object->skype) ? $object->skype : ''));

        $this->_data['birthdate_label'] = form_label('Birthdate *', 'birthdate');
        $this->_data['birthdate'] = form_input('birthdate', set_value('birthdate', isset($object->birthdate) ? date('d-m-Y', strtotime($object->birthdate)) : ''), 'class="calendar"');

        $this->_data['personal_message_label'] = form_label('Personal message', 'personal_message');
        $this->_data['personal_message'] = form_textarea('personal_message', set_value('personal_message', isset($object->personal_message) ? $object->personal_message : ''));

        $this->_data['moderator_label'] = form_label('Profile moderator', 'moderator');
        $this->_data['moderator'] = form_checkbox('moderator', '1', ( isset($object) && $object->moderator) ? true : false);

        $this->_data['suggested_label'] = form_label('Profile suggested', 'suggested');
        $this->_data['suggested'] = form_checkbox('suggested', '1', (isset($object) && $object->suggested) ? true : false);

        $this->_data['model_label'] = form_label('Model', 'model');
        $this->_data['model'] = form_checkbox('model', '1', (isset($object) && $object->model) ? true : false);

        $this->_data['live_girl_label'] = form_label('Live girl', 'live_girl');
        $this->_data['live_girl'] = form_checkbox('live_girl', '1', (isset($object) && $object->live_girl) ? true : false);

        if (isset($object->timestamp)) {
            $this->_data['registred_label'] = form_label('Registred: ' . date('d-m-Y', strtotime($object->timestamp)));
        } else {
            $this->_data['registred_label'] = form_label('Registred: ' . date('d-m-Y', time()));
        }
        if (isset($object->ip)) {
            $this->_data['ip_label'] = form_label('IP: ' . $object->ip);
        } else {
            $this->_data['ip_label'] = form_label('IP: ' . $_SERVER['REMOTE_ADDR']);
        }

        //generate select
        $this->interface_lib->generate_select_lang('user_types', 'name', 1, (isset($object->user_type_id) && !$this->input->post('user_types') ) ? $object->user_type_id : $this->input->post('user_types'));
        $this->interface_lib->generate_select_lang('profile_types', 'name', 1, (isset($object->profile_type_id) && !$this->input->post('profile_types') ) ? $object->profile_type_id : $this->input->post('profile_types'));
        $this->interface_lib->generate_select_lang('sex', 'name', 1, (isset($object->sex_id) && !$this->input->post('sex') ) ? $object->sex_id : $this->input->post('sex'));
        $this->interface_lib->generate_select_lang('cities', 'name', 1, (isset($object->city_id) && !$this->input->post('cities')) ? $object->city_id : $this->input->post('cities'));
        $this->interface_lib->generate_select_lang('regions', 'name', 1, (isset($object->region_id) && !$this->input->post('regions') ) ? $object->region_id : $this->input->post('regions'));
        $this->interface_lib->generate_select_lang('states', 'name', 1, (isset($object->state_id) && !$this->input->post('states') ) ? $object->state_id : $this->input->post('states'));
        $this->interface_lib->generate_select_lang('zodiacal_sign', 'name', 1, (isset($object->zodiacal_sign_id) && !$this->input->post('zodiacal_sign') ) ? $object->zodiacal_sign_id : $this->input->post('zodiacal_sign'));

        if ($this->_id != '') {
            $temp_object_id = $this->_id;
        }
        $this->_data['temp_object_id'] = form_hidden('temp_object_id', set_value('temp_object_id', isset($temp_object_id) ? $temp_object_id : ''));

        $this->load->library('pictures_lib');
        $this->_data['pictures'] = $this->pictures_lib->generate($temp_object_id, 'user',1);
        
        foreach ($this->_validation_array as $rule) {
            $this->_data[$rule['field'] . '_error'] = form_error($rule['field']);
        }

        
    }

    function delete($id) {
        try {
            $this->user_model->delete_user($id);
        } catch (Exception $e) {
            die('delete error');
        }
        redirect('admin/' . $this->_data['_controller_name'], 'refresh');
    }

    public function _sort() {
        $this->_data['filter_icon-id'] = 'list';
        $this->_data['filter_icon-nickname'] = 'list';
        $this->_data['filter_icon-last_name'] = 'list';
        $this->_data['filter_icon-user_type_id'] = 'list';
        $this->_data['filter_icon-ip'] = 'list';
        $this->_data['filter_icon-email'] = 'list';
        $sort_data = $this->input->get('sort', true);
        if ($sort_data) {
            foreach ($sort_data as $sort_key => $sort_value) {
                if ($sort_value == 'down') {
                    $sort_method = 'DESC';
                    $this->_data['filter_icon-' . str_replace('sort_', '', $sort_key)] = 'chevron-up';
                } else {
                    $sort_method = 'ASC';
                    $this->_data['filter_icon-' . str_replace('sort_', '', $sort_key)] = 'chevron-down';
                }
                $order_arr = array(
                    'field' => str_replace('sort_', '', $sort_key),
                    'method' => $sort_method
                );
            }
        } else {
            $order_arr = array(
                'field' => 'id',
                'method' => 'ASC'
            );
        }
        return $order_arr;
    }

    public function _filter() {
        $filter = array();
        if ($this->input->get('filter', true)) {
            foreach ($this->input->get('filter', true) as $field => $field_value) {

                if (!empty($field_value)) {

                    $filter[$field] = $field_value;
                }
            }
        }

        $this->_data['filter_id'] = (isset($filter['id'])) ? $filter['id'] : '';
        $this->_data['filter_nickname'] = (isset($filter['nickname'])) ? $filter['nickname'] : '';
        $this->_data['filter_email'] = (isset($filter['email'])) ? $filter['email'] : '';
        $this->_data['filter_last_name'] = (isset($filter['last_name'])) ? $filter['last_name'] : '';

        $this->_data['hide_table'] = 'hidden';
        $this->_data['message_filter'] = 'No results found.';

        return $filter;
    }

}