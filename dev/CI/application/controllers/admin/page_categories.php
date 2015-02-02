<?phpif (!defined('BASEPATH'))    exit('No direct script access allowed');

class Page_categories extends MY_Controller {

	function __construct() {
		parent::__construct();
	}

	function index() {
		$query = $this->db->get('page_categories');
		foreach ($query->result() as $row) {
			$row_id = $row->id;
			$this->_data['objects'][$row_id]['id'] = $row->id;
			$this->_data['objects'][$row_id]['page_category_title'] = $row->title;
		}

		$this->paste_admin('admin/page_categories_list');
	}

	function detail($id = '') {
		$this->_data['id'] = $id;

		$this->_data['title'] = '';
		$this->_data['validation_title'] = '';

		if ($id != '') {
			$this->_data['id'] = $id;
			try {
				$query = $this->db->get_where('page_categories', array('id' => $id));
				$object = $query->result();
				$this->_data['title'] = $object[0]->title;
			} catch (Exception $e) {
				die($e->getMessage());
			}
		}

		$this->paste_admin('admin/page_categories_detail');
	}

	function save($id = null) {
		if ($this->validation($id) == 'ok') {
			$db_data = array(
				'title' => $this->input->post('title')
			);

			if ($id != null) {
				try {
					$this->db->update('page_categories', $db_data, array('id' => $id));
				} catch (Exception $e) {
					$this->db->insert('site_objects', array('type' => 'page_category'));
					$db_data['id'] =  $this->db->insert_id();
					$this->db->insert('page_categories', $db_data);
				}
			} else {
				$this->db->insert('site_objects', array('type' => 'page_category'));
				$db_data['id'] =  $this->db->insert_id();
				$this->db->insert('page_categories', $db_data);
			}

			redirect('admin/page_categories', 'refresh');
		} else {
			$this->paste_admin('admin/page_categories_detail');
		}
	}

	function validation($id) {
		$this->form_validation->set_rules('title', 'Име', 'required');

		if ($this->form_validation->run() == TRUE) {
			return 'ok';
		} else {
			$this->_data['id'] = $id;
			$this->_data['title'] = $this->input->post('title');
			$this->_data['validation_title'] = form_error('title');
		}
	}

	function delete($id) {
		try {
			$this->db->delete('page_categories', array('id' => $id));
		} catch (Exception $e) {
			die('delete error');
//			die($e->getMessage());
		}
		redirect('admin/page_categories', 'refresh');
	}


}