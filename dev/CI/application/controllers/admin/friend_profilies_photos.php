<?php

if (!defined('BASEPATH'))

	exit('No direct script access allowed');

class Friend_profilies_photos extends MY_Controller {
    
    public $_id = '';

    private $_validation_array = array();
    
    function __construct() {

        parent::__construct();



        $this->load->model('admin/pictures_model');

        $this->load->library('langs_lib');

        $this->load->library('interface_lib');
        
        $this->load->library('pictures_lib');

        $this->_data['_controller_name'] = strtolower(get_class($this));

        $this->_data['_controller_title'] = str_replace('_',' ',get_class($this));

        $this->_data['_menu_selected'] = '/admin/friend_photo_profilies/';



        $this->_id = $this->input->post('id', true);

//        $this->_validation_array = $this->config->item('user_validation');
    }
    
    public function index() {
        
        $filter_data = $this->_filter();

        $order_arr = $this->_sort();
        
        $pictures_list = $this->pictures_model->get_all_pictures('user');
        
//        die('<pre>' . print_r($pictures_list,true) . '</pre>');
        
        $this->_data['objects'] = array();
        
        if(count($pictures_list)) {
            
            $this->_data['message_filter'] = '';

            $this->_data['hide_table'] = '';
            
            foreach ($pictures_list as $row) {
                
//                die('<pre>' . print_r($row,true) . '</pre>');

                $row_id = $row->id;

                $this->_data['objects'][$row_id]['id'] = $row->id;
//
                $this->_data['objects'][$row_id]['name'] = $this->pictures_lib->resize($row->name, $this->constants->prof_width, $this->constants->prof_height);
//
                $this->_data['objects'][$row_id]['nickname'] = $row->nickname;
                
                if($row->approved == 0) {
                    $this->_data['objects'][$row_id]['approved'] = '<i class="icon-thumbs-down"></i>';
                } else {
                    $this->_data['objects'][$row_id]['approved'] = '<i class="icon-thumbs-up"></i>';
                }
                
                $this->_data['objects'][$row_id]['created'] = $row->created;
                
                $this->_data['objects'][$row_id]['type'] = $row->type;

            }
            
            $this->_paste_admin('pictures_list');
            
        }
    }
    
    public function approve() {
        $pic_id = $this->input->post('pic_id',true);
        $approve = $this->input->post('approve',true);
        
        $this->pictures_model->update_approve($approve,$pic_id);
        
        $result = $this->pictures_model->get_approved($pic_id);
        
        if($result[0]->approved == 0) {
            $data = '<i class="icon-thumbs-down"></i>';
        } else {
            $data = '<i class="icon-thumbs-up"></i>';
        }
        
        echo $data;
//        die('<pre>' . print_r($result,true) . '</pre>');
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

?>