<?php

class Modules_model extends CI_Model {

	private $_table = 'modules';
    private static $db;

	//private $_lessons_table = 'lessons';

	public function __construct() {
		parent::__construct();
        self::$db = &get_instance()->db;
	}

	public function get_modules($id='', $year) {
        if ($id == '') {
            $query = $this->db->order_by("order", "asc")->get_where($this->_table, array('active'=>'1', 'year_id'=>$year));
            return $query->result();
        } else {
            $where_arr = array('subject_id' => $id,'active'=>'1', 'year_id'=>$year);
            $this->db->where($where_arr);
            $this->db->order_by("order", "asc");
            $query = $this->db->get($this->_table);

            return $query->result();
        }
	}

	public function get_all_modules() {
        $query = $this->db->order_by("order", "asc")->get_where($this->_table, array('active'=>'1'));
        return $query->result();
	}

	public function get_published_modules($where = array()) {
		$where['active'] = '1';
		$this->db->select('*');
		$this->db->from('modules');
		$this->db->where($where);
		$this->db->order_by('order','asc');
		$query = $this->db->get();

		return $query->result();
	}

	public function get_module($id) {
		$query = $this->db->get_where($this->_table, array('id' => $id, 'active'=>'1'));
		return $query->result();
	}

	public function save($data, $id = '') {
		if ($id) {
			$this->db->update($this->_table, $data, array('id' => $id));
		} else {
			$this->db->insert($this->_table, $data);			
			$id = $this->db->insert_id();
		}
		
		return $id;
	}

	public function module_exist($id) {
		$query = $this->db->get_where($this->_table, array('id' => $id));
		
		return $query->num_rows();
	}

    public function delete($module_id) {
		$this->db->where('id', $module_id);
		$this->db->delete($this->_table);
	}
/*
    public function is_published($id) {
        $query = $this->db->get_where($this->_table, array('id' => $id));
        
        $module_obj = $query->result();
        return $module_obj[0]->publish;
    }
//*/

    static public function unpublish_module($module_id){
        $res = self::$db->update('modules', array( 'publish' => 0 ), array('id' => $module_id));
        
        return $res;
    }
    
    static public function get_module_year($subject_id = ''){
        self::$db->select( 'year' );
        self::$db->from( 'subject_years' );
        self::$db->where('subject_id', $subject_id);
        $query = self::$db->get();
//        return $query->result();
//var_dump( $query->row() );die;
        $return = $query->row();
        return $return->year;
    }
    


}