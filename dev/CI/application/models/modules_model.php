<?php

class Modules_model extends CI_Model {

	private $_table = 'modules';
        
	//private $_lessons_table = 'lessons';

	public function __construct() {
		parent::__construct();
	}

	public function get_modules($id='', $year)
    {
        if ($id == '') {
            
            
            $query = $this->db->order_by("order", "asc")->get_where($this->_table, array('active'=>'1', 'year_id'=>$year));
            
            return $query->result();

        }
        else
        {
            $where_arr = array('subject_id' => $id,'active'=>'1', 'year_id'=>$year);
            $this->db->where($where_arr);
            $this->db->order_by("order", "asc");
            $query = $this->db->get($this->_table);

            return $query->result();
        }
	}

	public function get_all_modules()
    {
        $query = $this->db->order_by("order", "asc")->get_where($this->_table, array('active'=>'1'));
        return $query->result();
	}
        
	public function get_published_modules($where = array()) {
		$where['active'] = '1';
		$query = $this->db->get_where($this->_table, $where);
                //die($this->db->last_query());
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
        
       

}