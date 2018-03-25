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

	}
}