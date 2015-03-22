<?php
if (!defined('BASEPATH'))exit('No direct script access allowed');

class Widgets extends MY_Controller {
    private $widget;
    private $method;
  public  function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('classes_model');
        $this->load->model('resources_model');
        $this->load->model('keyword_model');
        $this->load->model('modules_model');
        $this->load->model('lessons_model');
        $this->load->model('content_page_model');
        $this->load->model('interactive_assessment_model');
        $this->load->model('assignment_model');
        $this->load->model('user_model');


        $widget = $this->uri->segment(2);
        $method=$this->uri->segment(3);

        if(file_exists(APPPATH.'libraries/widgets/'.$widget.EXT))
        {
        $this->load->library('widgets/'.$widget,$widget);
        $this->widget = $this->$widget;

        }
        else
        {
            $this->widget = FALSE;
            //must add error msg later
           // die("widget doesn't exist");
        }

        $this->method=$method;



    }
    public function _remap($method)
    {



        $method = $this->method;



        $params = array();

        if (method_exists($this->widget, $method))
        {
            return call_user_func_array(array($this->widget, $method), $params);
        }
        else if($method=='')
        {
            $this->index();
        }
        else {
            show_404();
        }
    }

    public function index()
    {
        show_404();

    }




}



?>