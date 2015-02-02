<?php
class Interface_model extends CI_Model {
    private $_prefix = 'nc_';    private $_lang_table = 'lang_content';
    public function __construct() {        parent::__construct();    }
    public function get_lang_data($table_name, $field_name, $lang_id) {        $where = array(            'object_table' => $this->_prefix . $table_name,            'field_name' => $field_name,            'lang_id' => $lang_id        );        $this->db->where($where);        $query = $this->db->get($this->_lang_table);        return $query->result();    }
}