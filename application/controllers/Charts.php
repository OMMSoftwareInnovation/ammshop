<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Charts extends CI_Controller {
 
    function __Construct() {
        parent::__Construct();
 
        $this->load->helper(array('form', 'url'));
        $this->load->model('data_model');
       
    }
    /**
     * @desc: This method is used to load view
     */
    public function index()
    {
 
        $this->load->view('piechart');
    }
    /**
     * @desc: This method is used to get data to call model and print it into Json
     * This method called by Ajax
     */
    function getdata(){
        $data  = $this->data_model->getdata();
        print_r(json_encode($data, true));
    }
}