<?php
class Nomenclatures_model extends CI_Model {
    private $_table = '';    private $_prefix = 'nc_';
    public function __construct() {        parent::__construct();    }
    public function get_list($table_name, $fields = array('id')) {        $this->_table = $table_name;        $query = $this->db->select($fields)->order_by('id')->get($this->_prefix . $table_name);        return $query->result();    }
    public function get_detail($table_name, $id) {        $query = $this->db->get_where($this->_prefix . $table_name, array('id' => $id));        return $query->result();    }
    public function check_nomenclature($table_name, $id) {        $this->db->where('id', $id);        $query = $this->db->get($this->_prefix . $table_name);        if ($query->num_rows() === 1) {            return true;        }        return false;    }
    public function save_nomenclature($data = array(), $table_name, $id = '') {        if ($id) {            $this->db->update($this->_prefix . $table_name, $data, array('id' => $id));        } else {            $this->db->insert($this->_prefix . $table_name, $data);
						$id = $this->db->insert_id();        }
				return $id;    }
    public function delete_nomenclature($table_name, $id) {        $this->db->delete($this->_prefix . $table_name, array('id' => $id));        $this->load->model('admin/langs_model');        $this->langs_model->delete_lang_cont($id);    }
}