<?phpif (!defined('BASEPATH'))    exit('No direct script access allowed');
class Nomenclatures extends MY_Controller {


    private $_id = '';


    public function __construct() {
        parent::__construct();


        $this->_data['_controller_name'] = strtolower(get_class($this));
        $this->_data['_controller_title'] = get_class($this);
        $this->_data['_menu_selected'] = '/admin/nomenclatures/nomenclature_list/user_types/';


        $this->load->model('admin/nomenclatures_model');
        $this->load->model('admin/langs_model');


        $this->load->library('langs_lib');


        $this->_id = $this->input->post('id', true);
    }


    public function nomenclature_list($table = '') {


        $this->_data['_nomenclature_title'] = $this->_parse_title($table);
        $this->_data['_table_name'] = $table;


        $list = $this->nomenclatures_model->get_list($table);
        foreach ($list as $row) {
            $row_id = $row->id;
            $nomenclature_name = $this->langs_model->get_lang_content($row_id, $table);
            $this->_data['objects'][$row_id]['id'] = $row->id;
            $this->_data['objects'][$row_id]['name'] = $nomenclature_name[0]->content;
        }
        $this->_paste_admin('nomenclatures_list');
    }


    public function detail($table, $id = '') {
        $this->_id = $id;
        $this->_generate_form($table, $id);
        $this->_paste_admin('nomenclatures_detail');
    }


    public function save($table) {
        if (!$this->nomenclatures_model->check_nomenclature($table, $this->_id)) {
            $this->_id = '';
        }
        if ($this->_validation() == 'ok') {
            $db_data = array(
                'id' => $this->_id,
                'option' => trim($this->input->post('option'))
            );
            $this->nomenclatures_model->save_nomenclature($db_data, $table, $this->_id);
            if (!$this->_id) {
                $this->_id = $this->db->insert_id();
            }
            $lang_post_array = $this->input->post('lang');
            $this->langs_model->save_lang_fields($lang_post_array, $this->_id, 'nc_' . $table);


            if ($this->_id != null) {
                $this->_data['_message'] = $this->session->set_flashdata('_message', 'Record updated.');
            } else {
                $this->_data['_message'] = $this->session->set_flashdata('_message', 'Record saved.');
            }





            redirect('admin/' . $this->_data['_controller_name'] . '/nomenclature_list/' . $table, 'refresh');
        } else {
            $this->_generate_form($table, $this->_id);
            $this->_paste_admin('nomenclatures_detail');
        }
    }


    private function _validation() {
        foreach ($this->_langs as $lang) {
            $this->form_validation->set_rules('lang[name][' . $lang->id . ']', $lang->name, 'required');
        }
        if ($this->form_validation->run() == true) {
            return 'ok';
        }
    }


    private function _generate_form($table, $id = '') {
        $this->_data['_nomenclature_title'] = $this->_parse_title($table);
        if ($id != '') {
            $object = $this->nomenclatures_model->get_detail($table, $id);
        }


        $lang_fields = array('name');
        $this->langs_lib->generate_fields($id, 'nc_' . $table, '', $lang_fields);


        $this->langs_lib->fill_lang_fields($id, 'nc_' . $table, $lang_fields);


        $this->_data['name_label'] = form_label('Name *');
        foreach ($this->_langs as $lang) {
            $this->_data['name_arr'][$lang->id]['name_field'] = form_input('lang[name][' . $lang->id . ']', set_value('lang[name][' . $lang->id . ']', isset($this->_data['name_arr'][$lang->id]['name']) ? $this->_data['name_arr'][$lang->id]['name'] : ''));
            $this->_data['name_arr'][$lang->id]['flag'] = $this->_data['name_arr'][$lang->id]['img'];
        }


        $this->_data['option_label'] = form_label('Option', 'option');
        $this->_data['option'] = form_input('option', set_value('option', isset($object[0]->option) ? $object[0]->option : ''));


        $this->langs_lib->generate_lang_fields_validation($lang_fields);


        $this->_data['form_open'] = form_open('/admin/' . $this->_data['_controller_name'] . '/save/' . $table);
        $this->_data['form_close'] = form_close();
        $this->_data['form_submit'] = form_submit('', 'Save', 'class="btn btn-info"');


        $this->_data['id'] = form_hidden('id', $this->_id);
    }


    function delete($table_name, $id) {
        try {
            $this->nomenclatures_model->delete_nomenclature($table_name, $id);
        } catch (Exception $e) {
            die('delete error');
        }
        redirect('admin/' . $this->_data['_controller_name'] . '/nomenclature_list/' . $table_name, 'refresh');
    }


}