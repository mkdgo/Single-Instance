<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
ini_set('memory_limit', '-1');

class Uploading extends CI_Controller {

    private $upload_excel_dir;
    private $upload_subjects_logos;
    public $storage;

    function __construct() {
        parent::__construct();

        $this->config->load('upload');
        $this->load->library('storage');

        $bucket = $this->config->item('bucket');
        $this->storage = new Storage($bucket);

        $this->upload_excel_dir = './tmp/';
//        $this->upload_excel_dir = './uploads_excel/';
        $this->upload_subjects_logos = './uploads/subject_icons';
    }

    public function upload_excel() {
        $config['upload_path'] = $this->upload_excel_dir;
        $config['allowed_types'] = 'xls|xlsx|csv';
        $config['max_size'] = '50000000';
        $config['encrypt_name'] = false;
        $this->load->library('upload', $config);

        // Output json as response
        if (!$this->upload->do_upload('qqfile')) {
            echo json_encode(array(
                'valid' => false,
                'errors' => $this->upload->display_errors('', '')
            ));
        } else {
            $fileData = array();
            foreach ($this->upload->data() as $k => $v) {
                $fileData[$k] = $v;
            }

            /* Upload in Amazon Storage */
            $upload_file = $this->storage->uploadFile( $fileData['full_path'], $this->config->item('imports') . $fileData['orig_name'] );

            require_once(APPPATH . 'libraries/phpexcel/PHPExcel.php');
            require_once(APPPATH . 'libraries/phpexcel/PHPExcel/IOFactory.php');

            $file_name = './tmp/' . $fileData['file_name'];

            $objPHPExcel = PHPExcel_IOFactory::load($file_name);
            $objWorksheet = $objPHPExcel->getActiveSheet();
            $highestColumn = $objWorksheet->getHighestColumn();

            $header = array();
            $validate = array();

            $num_columns = PHPExcel_Cell::columnIndexFromString($highestColumn);
            $offset = 0;
            $multiplier = 0;
            for( $i = 1; $i <= $num_columns; $i++ ) {
                $column = '';
                if( $multiplier > 0 ) {
                    $column .= chr( 64 + $multiplier );
                }
                $column .= chr(64 + $i - ( $offset * $multiplier ) );
                if( $i % 26 == 0 ) {
                    $offset = 26;
                    $multiplier++;
                }

                $val = trim($objWorksheet->getCell($column . '1')->getValue());

                if ($val) {
                    $header[$column] = array(
                        'value' => $val,
                        'lc_value' => strtolower($val)
                    );

                    $validate[$column] = strtolower($val);
                }
            }

            $valid = $this->_validateHeaderRow($validate);
            if ($valid !== true) {
                echo json_encode(array(
                    'valid' => false,
                    'errors' => $valid
                ));

                return;
            }

            echo json_encode(array(
                'valid' => true,
                'file_name' => $fileData['file_name'],
                'mapped' => $this->_mapFields($header)
            ));
        }
    }

    private function _mapFields($header) {
        $this->load->model('subjects_model');

        $subjects = array();
        $mapped = array();

        $subjectsResult = $this->subjects_model->get_subjects();
        foreach ($subjectsResult as $subject) {
            $subjects[$subject->id] = strtolower(trim($subject->name));
        }

        $emailFields = array('email', 'email address', 'emailaddress');
        $firstNameFields = array('first', 'first name', 'firstname');
        $lastNameFields = array('last', 'last name', 'lastname');

        foreach ($header as $column => $headerField) {
            $mappedTo = null;
            if ($headerField['lc_value'] == 'type') {
                $mappedTo = 'profile Type';
            } else if (in_array($headerField['lc_value'], $emailFields)) {
                $mappedTo = 'profile field Email Address';
            } else if (in_array($headerField['lc_value'], $firstNameFields)) {
                $mappedTo = 'profile field First Name';
            } else if (in_array($headerField['lc_value'], $lastNameFields)) {
                $mappedTo = 'profile field Last Name';
            } else if ($headerField['lc_value'] == 'password') {
                $mappedTo = 'profile field Password';
            } else if ($headerField['lc_value'] == 'year') {
                $mappedTo = 'profile field Year';
            } else if (in_array($headerField['lc_value'], $subjects)) {
                $mappedTo = 'subject ' . $headerField['value'];
            }

            $mapped[] = array(
                'column' => $column,
                'label' => $headerField['value'],
                'mappedTo' => $mappedTo
            );
        }

        return $mapped;
    }

    private function _validateHeaderRow($haystack) {
        $errors = array();

        if (!in_array('type', $haystack)) {
            $errors[] = 'Your file does not contain a Type column.';
        }
        if (!in_array('email', $haystack) && !in_array('email address', $haystack) && !in_array('emailaddress', $haystack)) {
            $errors[] = 'Your file does not contain an Email Address column.';
        }
        if (!in_array('password', $haystack)) {
            $errors[] = 'Your file does not contain a Password column.';
        }
        if (!in_array('first', $haystack) && !in_array('first name', $haystack) && !in_array('firstname', $haystack)) {
            $errors[] = 'Your file does not contain a First Name column.';
        }
        if (!in_array('last', $haystack) && !in_array('last name', $haystack) && !in_array('lastname', $haystack)) {
            $errors[] = 'Your file does not contain a Last Name column.';
        }
        if (!in_array('year', $haystack)) {
            $errors[] = 'Your file does not contain a Year column.';
        }

        if (count($errors) > 0) {
            return $errors;
        } else {
            return true;
        }
    }

    public function upload_subject_image() {
        $config['upload_path'] = $this->upload_subjects_logos;
        $config['allowed_types'] = 'png';
        $config['max_size'] = '50000000';
        $config['encrypt_name'] = false;
        $this->load->library('upload', $config);

        // Output json as response
        if (!$this->upload->do_upload('qqfile')) {
            $json['status'] = 'error';
            $json['issue'] = $this->upload->display_errors('', '');
        } else {
            $json['status'] = 'success';
            $json['success'] = 'true';

            foreach ($this->upload->data() as $k => $v) {
                $json[$k] = $v;
            }
        }

        echo json_encode($json);
    }

}

/* End of file uploading_.php */
