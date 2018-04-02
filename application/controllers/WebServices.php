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

		// Load database
		$this->load->model('Admin_model');
		// Load database
		$this->load->model('Addresses_model');
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
            echo json_encode(array('status' => '1', 'message' => 'success', 'couponcodedetails' => $this->Admin_model->GetCouponCode())); exit;
 
		} catch (Exception $e) {

			// set the response message
            $this->output->set_header('Content-Type: application/json; charset=utf-8');
            echo json_encode(array('status' => '1', 'message' => $e, 'couponcodedetails' => $this->Admin_model->GetCouponCode())); exit;
		}
	}
	/**
	* @author : Harshal Borse <harshal.borse9@gmail.com>
	* @date   : 27 March 18
	* @description : webservice for android device to get all addresses
	*/
	public function getAllAddresses() {

		$this->data = null;

		try {
			
			$this->data['all_addresses'] = $this->Addresses_model->getAllAddresses();

			if(!empty($this->data['all_addresses'])) {
							
				// set the response message
				$this->output->set_header('Content-Type: application/json; charset=utf-8');
				echo json_encode(array('status' => '1', 'message' => 'success', 'response' => $this->data)); exit;
			} else {
				// set the response message
				$this->output->set_header('Content-Type: application/json; charset=utf-8');
				echo json_encode(array('status' => '0', 'message' => 'Failed to get the response', 'response' => '')); exit;	
			}
 
		} catch (Exception $e) {

			// set the response message
            $this->output->set_header('Content-Type: application/json; charset=utf-8');
            echo json_encode(array('status' => '0', 'message' => $e, 'response' => '')); exit;
		}
	}

		/**
	* @author : Harshal Borse <harshal.borse9@gmail.com>
	* @date   : 27 March 18
	* @param  : int $user_id - user id of registered user
	* @description : webservice for android device to get addresses basedon the user id
	*/
	public function getAddressById($user_id = NULL) {

		$this->data = null;

		try {
			
			$this->data['address_by_id'] = $this->Addresses_model->getAddressByUserId($user_id);
			
			if(!empty($this->data['address_by_id'])) {
							
				// set the response message
				$this->output->set_header('Content-Type: application/json; charset=utf-8');
				echo json_encode(array('status' => '1', 'message' => 'success', 'response' => $this->data)); exit;
			} else {
				// set the response message
				$this->output->set_header('Content-Type: application/json; charset=utf-8');
				echo json_encode(array('status' => '0', 'message' => 'Failed to get the response', 'response' => '')); exit;	
			}
 
		} catch (Exception $e) {

			// set the response message
            $this->output->set_header('Content-Type: application/json; charset=utf-8');
            echo json_encode(array('status' => '0', 'message' => $e, 'response' => $this->data)); exit;
		}
	}
		/**
	* @author : Vishakha Kadam 
	* @date   : 31 March 18
	* @param  : int $user_id - user id of registered user
	* @description : webservice for android device to get addresses basedon the user id
	*/
	public function getCartDetails($user_id = NULL) {

		$this->data = null;

	
		try {

			$cart_result = $this->Addresses_model->getCartByUserId($user_id);
			$address_result = $this->Addresses_model->getAddressByUserId($user_id);
			
			//echo "<pre>";
			print_r($cart_result); die;

			if(!empty($address_result)) {
							
				echo json_encode(array('status' => '1', 'message' => 'success', 'address_response' => $address_result, 'cart_response' => $cart_result)); exit;
			} else {
				// set the response message
				$this->output->set_header('Content-Type: application/json; charset=utf-8');
				echo json_encode(array('status' => '0', 'message' => 'Failed to get the response', 'response' => '')); exit;	
			}		
		} catch (Exception $e) {

			// set the response message
            $this->output->set_header('Content-Type: application/json; charset=utf-8');
            echo json_encode(array('status' => '1', 'message' => $e, 'response' => $this->data)); exit;
		}
	}
}