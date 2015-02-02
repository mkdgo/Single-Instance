<?php if (!defined('BASEPATH'))    exit('No direct script access allowed');
class Pages extends MY_Controller {


    private $_id = '';


    public function __construct() {
        parent::__construct();
        $this->load->model('pages_model');
        $this->load->model('langs_model');


        $this->load->library('langs_lib');
        $this->load->library('pictures_lib');



        $this->_data['_controller_name'] = strtolower(get_class($this));
        $this->_data['_controller_title'] = get_class($this);
        $this->_data['_menu_selected'] = '/admin/pages/';


        $this->_id = $this->input->post('id', true);
    }


    public function index() {
        $pages_list = $this->pages_model->get_pages();
        if (count($pages_list)) {
            $this->_data['message_filter'] = '';
            $this->_data['hide_table'] = '';


            foreach ($pages_list as $row) {
                $row_id = $row->id;
                $this->_data['objects'][$row_id]['id'] = $row->id;
                $this->_data['objects'][$row_id]['key'] = $row->key;
                $this->_data['objects'][$row_id]['title'] = $row->content;
            }
        }
        $this->_paste_admin('pages_list');
    }


    function detail($id = '') {
        $this->_id = $id;
        if ($id == '') {
            $temp_object_id = rand(0, 9999);
        } else {
            $temp_object_id = $id;
        }
        $this->_generate_form($id, $temp_object_id);
        $this->_paste_admin('pages_detail');
    }


    public function save() {
        if (!$this->pages_model->check_page($this->_id)) {
            $this->_id = '';
        }
        if ($this->input->post('temp_object_id')) {
            $temp_object_id = $this->input->post('temp_object_id');
        }


        if ($this->_validation($this->_id) == 'ok') {
            $lang_post_array = $this->input->post('lang',true);
            if (!$this->input->post('key', true)) {
                $key = $this->_url_convert($lang_post_array['title'][1]);
            } else {
                $key = $this->_url_convert($this->input->post('key', true));
            }
            $db_data = array(
                'key' => $key,
                'keywords' => trim($this->input->post('keywords', true)),
                'description' => trim($this->input->post('description', true)),
            );


            $this->pages_model->save_page($db_data, $this->_id);
            if (!$this->_id) {
                $this->_id = $this->db->insert_id();


                $this->load->model('admin/pictures_model');
                $this->pictures_model->update_temp_pics($temp_object_id, $this->_id);
            }


            $this->langs_model->save_lang_fields($lang_post_array, $this->_id, 'pages');
            if ($this->_id != null) {
                $this->_data['_message'] = $this->session->set_flashdata('_message', 'Record updated.');
            } else {
                $this->_data['_message'] = $this->session->set_flashdata('_message', 'Record saved.');
            }
            redirect('admin/' . $this->_data['_controller_name'], 'refresh');
        } else {


            $this->_generate_form($this->_id, $temp_object_id);
            $this->_paste_admin('pages_detail');
        }
    }


    private function _validation() {
        foreach ($this->_langs as $lang) {
            $this->form_validation->set_rules('lang[title][' . $lang->id . ']', $lang->name, 'required|trim');
            $this->form_validation->set_rules('lang[content][' . $lang->id . ']', $lang->name, 'xss_clean|trim');
        }


        if ($this->form_validation->run() == TRUE) {
            return 'ok';
        }
    }


    public function _generate_form($id = '', $temp_object_id = '') {
        if ($id != '') {
            $object = $this->pages_model->get_page($id);
        }


        $this->_data['form_open'] = form_open('/admin/' . $this->_data['_controller_name'] . '/save');
        $this->_data['form_close'] = form_close();
        $this->_data['form_submit'] = form_submit('', 'Save', 'class="btn btn-info"');
        $this->_data['id'] = form_hidden('id', $this->_id);


        $this->_data['key_label'] = form_label('Key', 'key');
        $this->_data['key'] = form_input('key', set_value('key', isset($object[0]->key) ? $object[0]->key : ''), 'class="span6"');


        $this->_data['keywords_label'] = form_label('META Keywords', 'keywords');
        $this->_data['keywords'] = form_input('keywords', set_value('keywords', isset($object[0]->keywords) ? $object[0]->keywords : ''), 'class="span6"');


        $this->_data['description_label'] = form_label('META description', 'description');
        $this->_data['description'] = form_textarea('description', set_value('description', isset($object[0]->description) ? $object[0]->description : ''), 'class="span6"');


        //Generate title language fields
        $title_lang_fields = array('title');
        $this->langs_lib->generate_fields($id, 'pages', '', $title_lang_fields);
        $this->langs_lib->fill_lang_fields($id, 'pages', $title_lang_fields);


        $this->_data['title_label'] = form_label('Title *');
        foreach ($this->_langs as $lang) {
            $this->_data['title_arr'][$lang->id]['title_field'] = form_input('lang[title][' . $lang->id . ']'
                    , set_value('lang[title][' . $lang->id . ']', isset($this->_data['title_arr'][$lang->id]['title']) ?
                                    $this->_data['title_arr'][$lang->id]['title'] : ''));
            $this->_data['title_arr'][$lang->id]['flag'] = $this->_data['title_arr'][$lang->id]['img'];
        }


        //Generate language  fields
        $cont_lang_fields = array('content');
        $this->langs_lib->generate_fields($id, 'pages', '', $cont_lang_fields);
        $this->langs_lib->fill_lang_fields($id, 'pages', $cont_lang_fields);


        $this->_data['content_label'] = form_label('Content');
        foreach ($this->_langs as $lang) {
            $this->_data['content_arr'][$lang->id]['content_field'] = form_textarea('lang[content][' . $lang->id . ']'
                    , set_value('lang[content][' . $lang->id . ']', isset($this->_data['content_arr'][$lang->id]['content']) ?
                                    $this->_data['content_arr'][$lang->id]['content'] : ''), 'class="span6 mceEditor"');
            $this->_data['content_arr'][$lang->id]['flag'] = $this->_data['content_arr'][$lang->id]['img'];
        }


        if ($this->_id != '') {
            $temp_object_id = $this->_id;
        }
        $this->_data['temp_object_id'] = form_hidden('temp_object_id', set_value('temp_object_id', isset($temp_object_id) ? $temp_object_id : ''));


        $this->_data['pictures'] = $this->pictures_lib->generate($temp_object_id, 'page');
        //generate langs field validation
        $this->langs_lib->generate_lang_fields_validation($title_lang_fields);
        $this->langs_lib->generate_lang_fields_validation($cont_lang_fields);
    }


    private function _url_convert($url) {
        # Prep string with some basic normalization
        $url = strtolower($url);
        $url = strip_tags($url);
        $url = stripslashes($url);
        $url = html_entity_decode($url);


        # Remove quotes (can't, etc.)
        $url = str_replace('\'', '', $url);


        # Replace non-alpha numeric with hyphens
        $match = '/[^a-z0-9-]+/';
        $replace = '_';
        $url = preg_replace($match, $replace, $url);


        $url = trim($url, '_');


        return $url;
    }


}
