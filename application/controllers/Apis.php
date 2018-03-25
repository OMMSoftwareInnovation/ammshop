<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'libraries/REST_Controller.php';
class Apis extends REST_Controller {

public function __construct() {
parent::__construct();

// Load form validation library
$this->load->library('form_validation');
$this->load->helper('security','url');
// Load session library
$this->load->helper('url');

// Load database
$this->load->model('Apis_model');
}
	
	public function GetCategories_post()
	{
		$data['Data']=$this->Apis_model->GetCategories();
		$data['status'] = '1';
		$data['message'] = 'Categories';

		$this->response($data,REST_Controller::HTTP_OK);
	}

	public function GetSubCategories_post()
	{
		$catid=$this->post("cat_id");
		$data['Data']=$this->Apis_model->GetSubCategories($catid);
		$data['status'] = '1';
		$data['message'] = 'Sub Categories';

		$this->response($data,REST_Controller::HTTP_OK);
	}

	public function GetBanners_post()
	{
		$data['Data']=$this->Apis_model->GetBanners();
		$data['status'] = '1';
		$data['message'] = 'Banners';

		$this->response($data,REST_Controller::HTTP_OK);
	}

	public function RegisterUser_post()
	{
		$code = rand(100000, 999999);
		$user = array(
			"name" => $this->post("uname"),
			"mobile_no" => $this->post("mobileno"),
			"verno" => $code,
			"email" => $this->post("emailid"),
			"password" => $this->post("password"),
		);
		// "apikey" => $this->post("apikey"),
		// "token" => $this->post("token"),
		$message = $user['verno']." is your OTP for verify your account, Thank you for be a part of Available M!";
		$available = $this->Apis_model->GetUsersCheck($user);

		if($available)
		{
			if($this->Apis_model->UpdateUser($user))
			{
				$this->SendMessage($user['mobile_no'],$message);
				$data['Data']=$this->Apis_model->GetUserbyid($user);
				$data['status'] = '1';
				$data['message'] = 'User Added';		
			}
			else
			{
				$data['Data']="";
				$data['status'] = '0';
				$data['message'] = 'User Not Added';		
			}

		}
		else
		{
			if($this->Apis_model->AddUser($user))
			{
				$this->SendMessage($user['mobileno'],$message);
				$data['Data']=$this->Apis_model->GetUserbyid($user);
				$data['status'] = '1';
				$data['message'] = 'User Added';		
			}
			else
			{
				$data['Data']="";
				$data['status'] = '0';
				$data['message'] = 'User Not Added';		
			}
		}

		$this->response($data,REST_Controller::HTTP_OK);
	}

	public function VerifyOtp_post()
	{
		$OTP = array(
			"verno" => $this->post("verno"),
			"verified" => 1
		);

		// "uid" => $this->post("uid"),
		
		$available = $this->Apis_model->GetAccountCheck($OTP);

		if($available)
		{
			if($this->Apis_model->UpdateVerified($OTP))
			{
				$data['Data']=$this->Apis_model->GetUserdatabyId($OTP['uid']);
				$data['status'] = '1';
				$data['message'] = 'User Account Verified';		
			}
			else
			{
				$data['Data']=array();
				$data['status'] = '0';
				$data['message'] = 'User Account Not Verified';		
			}
		}
		else
		{
			$data['Data']=array();
			$data['status'] = '0';
			$data['message'] = 'User not avaliable with this verification code';
		}

		$this->response($data,REST_Controller::HTTP_OK);
	}
	
	public function SendMessage($mobile,$textmessage)
    {
        $arrContextOptions=array(
            "ssl"=>array(
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            ),
            );
        
            $api_key = '187936AsutxtZ0P9Yu5a324a15';
            $contacts = $mobile;
            $from = 'availableme';
            $sms_text = urlencode($textmessage);
    
        //    $api_url = "http://login.wishbysms.com/api/sendhttp.php?authkey=".$api_key."&mobiles=".$contacts."&message=".$sms_text."&sender=".$from."&route=4&country=91";
	
		   $api_url = "https://www.logonutility.in/app/smsapi/index.php?key=45996E8C8BB3CC&campaign=10169&routeid=20&type=text&contacts=".$contacts."&senderid=LOGUTL&msg=".$sms_text;

           $response = file_get_contents( $api_url, false, stream_context_create($arrContextOptions));
            
            if(!$response){ 
                return false;
            }
            else
            {
                return true;
            }
    }

}
