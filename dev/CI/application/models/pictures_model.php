<?php
if (!defined('BASEPATH'))    exit('No direct script access allowed');
class Pictures_model extends CI_Model {
    private $_table = 'pictures';    private $_users_table = 'users';    private $_langs = 'langs';    private $_lang_content = 'lang_content';
    public function __construct() {        parent::__construct();    }
    public function get_pictures($object_id, $object_type) {        $where = array(            'object_id' => $object_id,            'object_type' => $object_type,        );        $this->db->where($where);        $query = $this->db->order_by('type', 'DESC')->get($this->_table);        return $query->result();    }
    public function get_all_pictures($object_type) {        $this->db->select(array($this->_table . '.id', $this->_table . '.name', $this->_table . '.hot', $this->_table . '.approved',            $this->_table . '.type', $this->_table . '.created',            $this->_users_table . '.nickname'));        $this->db->join($this->_users_table, $this->_table . '.object_id = ' . $this->_users_table . '.id');        $where = array(            $this->_table . '.object_type' => $object_type        );        $this->db->where($where);        $query = $this->db->order_by($this->_table . '.type', 'DESC')->get($this->_table);        return $query->result();    }
    public function get_picture_name($object_id, $picture_id) {        $this->db->select('name');        $where = array(            'id' => $picture_id,            'object_id' => $object_id        );        $this->db->where($where);        $query = $this->db->get($this->_table, 1);        return $query->row();    }
    public function get_picture_type($type_id) {        $where = array(            'type' => $type_id        );        $this->db->where($where);        $query = $this->db->get($this->_table);        return $query->result();    }
    public function save_picture($picture_data = array(), $picture_id = '') {        if ($picture_id != '') {            $this->db->where('id', $picture_id);            $this->db->update($this->_table, $picture_data);        } else {            $this->db->insert($this->_table, $picture_data);
						$picture_id = $this->db->insert_id();        }
				rethrn $picture_id;    }
    public function update_temp_pics($temp_object_id, $object_id) {        $picture_data = array(            'object_id' => $object_id        );        $this->db->where('object_id', $temp_object_id);        $this->db->update($this->_table, $picture_data);    }
    public function update_type($object_id, $picture_id, $picture_type = 1) {        $where = array(            'id' => $picture_id,            'object_id' => $object_id,        );        $this->db->where($where);        $this->db->update($this->_table, array('type' => $picture_type));    }
    public function get_approved($pic_id) {        $this->db->select('approved');        $where = array('id' => $pic_id);        $this->db->where($where);        $this->db->limit(1);        $query = $this->db->get($this->_table);        return $query->result();    }
    public function update_approve($approved, $pic_id) {        $where = array('id' => $pic_id);        $this->db->where($where);        $this->db->limit(1);        $this->db->update($this->_table, array('approved' => $approved));    }
    public function get_picture($picture_id) {        $query = $this->db->get($this->_table, array('id' => $picture_id));        return $query->row();    }
    public function get_object($object_id) {        $query = $this->db->get('users', array('id' => $object_id));        return $query->row();    }
    public function delete_picture($object_id, $picture_id) {        $this->db->delete($this->_table, array('id' => $picture_id, 'object_id' => $object_id));    }
}