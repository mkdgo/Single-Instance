<?phpif (!defined('BASEPATH'))    exit('No direct script access allowed');
class Chat_groups extends MY_Controller {

    private $_id = '';
    private $_validation_array = array();

    public function __construct() {
        parent::__construct();
        $this->load->model('chat_groups_model');
        $this->load->model('admin/pictures_model');
        $this->load->library('pictures_lib');

        $this->_data['_controller_name'] = strtolower(get_class($this));
        $this->_data['_controller_title'] = $this->_parse_title(get_class($this));
        $this->_data['_menu_selected'] = '/admin/chat_groups/';

        $this->_id = $this->input->post('id', true);
        $this->_validation_array = $this->config->item('chat_groups_validation');
    }

    public function index() {
        $chat_groups = $this->chat_groups_model->get_list_groups();
        foreach ($chat_groups as $row) {
            $row_id = $row->id;
            $this->_data['objects'][$row_id]['id'] = $row->id;
            $this->_data['objects'][$row_id]['title'] = $row->title;
            $this->_data['objects'][$row_id]['message'] = $row->message;
            $this->_data['objects'][$row_id]['time'] = $row->time;
        }
        $this->_paste_admin('chat_groups/chat_groups_list');
    }

    public function detail($id = '') {
        $this->_id = $id;
        if ($id == '') {
            $temp_object_id = rand(0, 9999);
        } else {
            $temp_object_id = $id;
        }

        $this->_generate_form($id, $temp_object_id);
        $this->_paste_admin('chat_groups/chat_groups_detail');
    }

    public function save() {
        if (!$this->chat_groups_model->check_chat_group($this->_id)) {
            $this->_id = '';
        }
        if ($this->input->post('temp_object_id')) {
            $temp_object_id = $this->input->post('temp_object_id');
        }
        if ($this->_validation() == 'ok' && $this->chat_groups_model->check_picture($temp_object_id)) {
			$slug = url_title($this->input->post('title'),'dash',true);
            $db_data = array(
                'title' => $this->input->post('title', true),
                'message' => $this->input->post('message', true),								'slug' => $slug
            );
            //  var_dump();die;
            $this->chat_groups_model->save_chat_group($db_data, $this->_id);
            if (!$this->_id) {
                $this->_id = $this->db->insert_id();

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
            $this->_data['picture_error'] = 'Uploading chat group picture is required!';
            $this->_data['picture_error_class'] = '';
            $this->_paste_admin('chat_groups/chat_groups_detail');
        }
    }

    private function _validation() {
        $this->form_validation->set_rules($this->_validation_array);

        if ($this->form_validation->run('pages_validation') == TRUE) {
            return 'ok';
        }
    }

    public function _generate_form($id = '', $temp_object_id = '') {
        if ($id != '') {
            $object = $this->chat_groups_model->get_chat_group($id);
        }
        $this->_data['picture_error'] = '';
        $this->_data['picture_error_class'] = 'hidden';

        $this->_data['form_open'] = form_open('/admin/' . $this->_data['_controller_name'] . '/save');
        $this->_data['form_close'] = form_close();
        $this->_data['form_submit'] = form_submit('', 'Save', 'class="btn btn-info"');

        $this->_data['message_label'] = form_label('Message', 'message');
        $this->_data['message'] = form_input('message', set_value('message', (isset($object[0]->message) && $object[0]->message) ? $object[0]->message : '' ));

        $this->_data['title_label'] = form_label('Title', 'title');
        $this->_data['title'] = form_textarea('title', set_value('title', set_value('title', (isset($object[0]->title) && $object[0]->title) ? $object[0]->title : '' )));

        $this->_data['id'] = form_hidden('id', $this->_id);
        $this->_data['temp_object_id'] = form_hidden('temp_object_id', set_value('temp_object_id', isset($temp_object_id) ? $temp_object_id : ''));

        $this->_data['pictures'] = $this->pictures_lib->generate($temp_object_id, 'chat_group', 1);

        foreach ($this->_validation_array as $rule) {
            $this->_data[$rule['field'] . '_error'] = form_error($rule['field']);
        }
    }

    function delete($object_id) {
        $this->chat_groups_model->delete_group($object_id);
        $picture = $this->chat_groups_model->get_group_picture($object_id);
        if (!$picture){
            die('Picture not found');
        }

        $picture_name = $picture[0]->name;


        $target_path = realpath(FCPATH) . '/img/temp';
        $target_img_path = realpath(FCPATH) . '/img/';
        $target_file = rtrim($target_path, '/') . '/' . $picture[0]->name;

        $this->pictures_model->delete_picture($object_id, $picture[0]->id);
        unlink($target_file);
        $handle = opendir($target_img_path);
        if ($handle) {
            while (false !== ($file = readdir($handle))) {
                if (preg_match("/$picture_name$/", $file)) {
                    unlink($target_img_path . $file);
                }
            }
            closedir($handle);
        }

        redirect('admin/' . $this->_data['_controller_name'], 'refresh');
    }

}
