<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
* @author : Harshal Borse <harshal.borse9@gmail.com>
* @date   : 25 March 18
* @description : webservice controller
*/
class WebServices extends CI_Controller
{	
	public function __construct() {
		parent::__construct();

		// Load form helper library
		$this->load->helper('form', 'url', 'security');

		// Load session library
		$this->load->library('session','excel');

		// Load database
		$this->load->model('data_model');
	}	

	/**
	* @author : Harshal Borse <harshal.borse9@gmail.com>
	* @date   : 25 March 18
	* @description : webservice for android device to get the coupon code list
	*/
	public function getCouponCodes()
	{
		$this->data = null;

		try {
			
			// get the llist of coupon codes
			$this->data['CouponCodeDetails'] = $this->Admin_model->GetCouponCode();
			
			// set the response message
            $this->output->set_header('Content-Type: application/json; charset=utf-8');
            echo json_encode(array('status' => '1', 'message' => 'success', 'response' => $this->data)); exit;
 
		} catch (Exception $e) {

			// set the response message
            $this->output->set_header('Content-Type: application/json; charset=utf-8');
            echo json_encode(array('status' => '1', 'message' => $e, 'response' => $this->data)); exit;
		}
	}
}