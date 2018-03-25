<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SubAdmin extends CI_Controller {
public $site_notification;
public function __construct() {
parent::__construct();

// Load form helper library
$this->load->helper('form');

// Load form validation library
$this->load->library('form_validation');
$this->load->helper('security','url');
// Load session library
$this->load->library('session');
$this->load->helper('url');
$this->load->library('excel');

$this->load->model('SubAdmin_model');
$this->site_notification=$this->SubAdmin_model->Getnoticount();
$this->load->vars($this->site_notification);


}	


	public function GenerateRandomOtp()
    {
		$string = 'abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$string_shuffled = str_shuffle($string);
		$password = substr($string_shuffled, 1, 6); 
		return $password;
    }	
	public function index()
	{
		if(isset($this->session->userdata['SAlogged_in'])){
			$data['getdashboard']=$this->SubAdmin_model->getdashboard();
			//print_r($data['getdashboard']);exit;
			$this->load->view('SubAdmin/Header');
			$this->load->view('SubAdmin/index',$data);
			$this->load->view('SubAdmin/Footer');
		}else{
			
		$this->Login();
		}
	}
	//Login
	public function Login()
    {
        $this->load->view('SubAdmin/loginheader');
        $this->load->view('SubAdmin/login');
        $this->load->view('SubAdmin/loginfooter');
	}
	 // Check for user login process
	public function SubAdmin_login_process()
	{

		$this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');

		if ($this->form_validation->run() == FALSE) {
		if(isset($this->session->userdata['SSAlogged_in'])){
			$this->index();

		}else{
		$this->Login();
		}
		} else {
			$data = array(
			'email' => $this->input->post('email'),
			'password' => $this->input->post('password')
			);
			$result = $this->SubAdmin_model->login($data);
			if ($result == TRUE) {

			$email = $this->input->post('email');
			$result = $this->SubAdmin_model->read_SubAdmin_information($email);
			if ($result != false) {
			$session_data = array(
			'S_aid' => $result[0]->sub_admin_id,
			'S_Email' => $result[0]->email,
			'S_Mobileno' => $result[0]->mobile_no,
			'S_Name' => $result[0]->sub_admin_name,
			);
			//print_r($session_data);exit;
			// Add user data in session
			$this->session->set_userdata('SAlogged_in' ,$session_data);
			$this->index();
		}
		} else {
			$data = array(
			'error_message' => 'Invalid Username or Password'
			);
			$this->load->view('SubAdmin/loginheader');
			$this->load->view('SubAdmin/login',$data);
			$this->load->view('SubAdmin/loginfooter');
			}
		}
	}
	//Forgot Password
	public function Forgot()
    {
        $this->load->view('SubAdmin/loginheader');
        $this->load->view('SubAdmin/Forgot');
        $this->load->view('SubAdmin/loginfooter');
    }
	public function ForgotPassword()
    {
        $email = $this->input->post("email");
		if ($this->SubAdmin_model->Checkemail($email))
		{
        	$password = $this->SubAdmin_model->getpassword($email);
            if($this->sendmail($email,$password))
            {
                echo '<script>';
                echo 'setTimeout(function () {swal("Registered!", "Please Check Your Registered mail For Password", "success");';
                echo '}, 1000);';
                echo 'setTimeout(function () {window.location.href="'.base_url()."SubAdmin/Login".'"';
                echo '}, 2000);</script>';
                $this->Forgot();
            }
            else
            {
                echo '<script>';
                echo 'setTimeout(function () {swal("Error!", "We are unable to send mail now.please try again after some time.", "error");';
                echo '}, 1000);</script>';
                $this->Forgot();        
            }
		} else {
			echo '<script>';
			echo 'setTimeout(function () {swal("Error!", "Please Enter Valid Email Id", "error");';
			echo '}, 1000);</script>';
			$this->Forgot();
		}
	}
	public function sendmail($email,$password) 
	{ 
         $config = Array(
        'protocol' => 'smtp',
        'smtp_host' => 'ssl://smtp.googlemail.com',//relay-hosting.secureserver.net
        'smtp_port' => 465,//25
        'smtp_user' => 'shahneet85@gmail.com',
        'smtp_pass' => 'shah.love87',
        'mailtype' => 'html',
        'charset' => 'iso-8859-1',
        'wordwrap' => TRUE
        );

      $message = 'Thanks For Being With us.<br/> Your Available M! Business Credentials are...<br/> Email Id : '.$email.'<br/> Password : '.$password;
      $this->load->library('email', $config);
      $this->email->set_newline("\r\n");
      $this->email->from('shahneet85@gmail.com');
      $this->email->to($email);
      $this->email->subject('Available M! Credentials');
      $this->email->message($message);
      if($this->email->send())
		{
			return 1;
		}
		else
		{
			return 0;
		}

	}     
	// Logout from SubAdmin page
	public function logout() 
	{

		// Removing session data
		$sess_array = array(
		'username' => ''
		);
		$this->session->unset_userdata('SAlogged_in', $sess_array);
		$data['message_display'] = 'Successfully Logout';
			$this->load->view('SubAdmin/loginheader');
			$this->load->view('SubAdmin/login',$data);
			$this->load->view('SubAdmin/loginfooter');
	}
	//ChangePassword
	public function ChangePassword()
	{
		if(isset($this->session->userdata['SAlogged_in'])){
			$this->load->view('SubAdmin/Header');
			$this->load->view('SubAdmin/ChangePassword');
			$this->load->view('SubAdmin/Footer');
		}else{
			
        $this->Login();
		}
	}
	public function Checkpassword()
    {
        $S_aid=$this->session->userdata['SAlogged_in']['S_aid'];
		$pwd=$this->input->post('oldpass');	
		$result=$this->SubAdmin_model->CheckPassword($S_aid,$pwd);
		 echo $result;
    }
	public function Updatepassword()
    {
        $S_aid=$this->session->userdata['SAlogged_in']['S_aid'];
        $Password = array(
            'password'=> $this->input->post('password'),
            );
            if ($this->SubAdmin_model->UpdatePassword($Password,$S_aid)) {
                echo '<script>';
                echo 'setTimeout(function () {swal("Updated!", "Your Password Succesfully Updated.", "success");';
                echo '}, 1000);';
                echo 'setTimeout(function () {window.location.href="'.base_url()."SubAdmin/ChangePassword".'"';
                echo '}, 2000);</script>';
                $this->ChangePassword();
            } else {
                echo '<script>';
                echo 'setTimeout(function () {swal("Opps!", "There is some problem please try again after some time", "error");';
                echo '}, 1000);</script>';
                $this->ChangePassword();
            }
	}  	
	//City
	public function City()
	{
		if(isset($this->session->userdata['SAlogged_in'])){
			$data['CityDetails']=$this->SubAdmin_model->GetCities();
			$this->load->view('SubAdmin/Header');
			$this->load->view('SubAdmin/City',$data);
			$this->load->view('SubAdmin/Footer');
		}else{
			
        $this->Login();
		}
	}
	public function CheckCityNameExist()
    {
        $city=$this->input->post('txtcityname');	
		$result=$this->SubAdmin_model->CheckCity($city);
		 echo $result;
	}
	public function AddCity()
    {
		if(isset($this->session->userdata['SAlogged_in']))
		{
			$data = array(
				'city_name'=> $this->input->post('txtcityname'),
			);
			if ($this->SubAdmin_model->AddCity($data)) {
                echo '<script>';
                echo 'setTimeout(function () {swal("Added!", "Your City Succesfully Added.", "success");';
                echo '}, 1000);';
                echo 'setTimeout(function () {window.location.href="'.base_url()."SubAdmin/City".'"';
                echo '}, 2000);</script>';
                $this->City();
            } else {
                echo '<script>';
                echo 'setTimeout(function () {swal("Opps!", "There is some problem please try again after some time", "error");';
                echo '}, 1000);</script>';
                $this->City();
            }
		}
		else
        {
			$this->Login();
		} 
	}
	public function EditCheckCityNameExist()
    {
        $cityid=$this->input->post('cityidval');			
		$city=$this->input->post('citynameval');	
		$result=$this->SubAdmin_model->EditCheckCity($cityid,$city);
		 echo $result;
	}
	public function EditCity()
    {
		if(isset($this->session->userdata['SAlogged_in']))
		{
			$cityid=$this->input->post('txtcityid');
			$data = array(
				'city_name'=> $this->input->post('edittxtcityname'),
			);
			if ($this->SubAdmin_model->UpdateCity($cityid,$data)) {
				echo '<script>';
				echo 'setTimeout(function () {swal("Updated!", "Your City Succesfully Updated.", "success");';
				echo '}, 1000);';
				echo 'setTimeout(function () {window.location.href="'.base_url()."SubAdmin/City".'"';
				echo '}, 2000);</script>';
				$this->City();
            } else {
                echo '<script>';
                echo 'setTimeout(function () {swal("Opps!", "There is some problem please try again after some time", "error");';
                echo '}, 1000);</script>';
                $this->City();
            }
		}
		else
        {
			$this->Login();
		} 
	}
	public function DeleteCity()
	{
		if(isset($this->session->userdata['SAlogged_in']))
		{
			$cityid = $this->input->post('cityid');
			$chkcitypresent = $this->SubAdmin_model->chkcitypresent($cityid);
			if($chkcitypresent==1)
			{
				$json_array=array(
					"success"=>'true',
					"chkcitypresent"=>1				 
				);				
			}
			else
			{
				if($this->SubAdmin_model->DeleteCity($cityid))
				{
					$json_array=array(
						"success"=>'true',
						"chkcitypresent"=>0				 
					);
				}
				else
				{
					$json_array=array(
						"success"=>'false',
						"chkcitypresent"=>0				 
					);
				}
			}
            echo json_encode($json_array);
		}
		else
		{			
        	$this->Login();
		}
	}
	//Area
	public function Area()
	{
		if(isset($this->session->userdata['SAlogged_in'])){
			$data['AreaDetails']=$this->SubAdmin_model->GetAreas();
			$data['CityDetails']=$this->SubAdmin_model->GetCities();
			$this->load->view('SubAdmin/Header');
			$this->load->view('SubAdmin/Area',$data);
			$this->load->view('SubAdmin/Footer');
		}else{
			
        $this->Login();
		}
	}	
	public function CheckAreaNameExist()
    {
		$cityid=$this->input->post('cityidval');			
		$area=$this->input->post('areanameval');	
		$result=$this->SubAdmin_model->CheckArea($cityid,$area);
		 echo $result;
	}
	public function AddArea()
    {
		if(isset($this->session->userdata['SAlogged_in']))
		{
			$area = array(
				'city_id'=> $this->input->post('txtcityid'),
				'area_name'=> $this->input->post('txtareaname'),
			);
			if ($this->SubAdmin_model->AddArea($area)) {
                echo '<script>';
                echo 'setTimeout(function () {swal("Added!", "Your Area Succesfully Added.", "success");';
                echo '}, 1000);';
                echo 'setTimeout(function () {window.location.href="'.base_url()."SubAdmin/Area".'"';
                echo '}, 2000);</script>';
                $this->Area();
            } else {
                echo '<script>';
                echo 'setTimeout(function () {swal("Opps!", "There is some problem please try again after some time", "error");';
                echo '}, 1000);</script>';
                $this->Area();
            }
		}
		else
        {
			$this->Login();
		} 
	}
	public function EditCheckAreaNameExist()
    {
		$areS_aid=$this->input->post('areS_aidval');
		$cityid=$this->input->post('cityidval');			
		$area=$this->input->post('areanameval');	
		$result=$this->SubAdmin_model->EditCheckArea($areS_aid,$cityid,$area);
		 echo $result;
	}
	public function EditArea()
    {
		if(isset($this->session->userdata['SAlogged_in']))
		{
			$areS_aid=$this->input->post('areS_aid');
			$area = array(
				'city_id'=> $this->input->post('edittxtcityid'),
				'area_name'=> $this->input->post('edittxtareaname'),
			);
			if ($this->SubAdmin_model->UpdateArea($areS_aid,$area)) {
                echo '<script>';
                echo 'setTimeout(function () {swal("Edited!", "Your Area Succesfully Updated.", "success");';
                echo '}, 1000);';
                echo 'setTimeout(function () {window.location.href="'.base_url()."SubAdmin/Area".'"';
                echo '}, 2000);</script>';
                $this->Area();
            } else {
                echo '<script>';
                echo 'setTimeout(function () {swal("Opps!", "There is some problem please try again after some time", "error");';
                echo '}, 1000);</script>';
                $this->Area();
            }
		}
		else
        {
			$this->Login();
		} 
	}
	public function DeleteArea()
	{
		if(isset($this->session->userdata['SAlogged_in']))
		{
			$areS_aid = $this->input->post('areS_aid');
			$chkareapresent = $this->SubAdmin_model->chkareapresent($areS_aid);
			if($chkareapresent==1)
			{
				$json_array=array(
					"success"=>'true',
					"chkareapresent"=>1				 
				);				
			}
			else
			{
				if($this->SubAdmin_model->DeleteArea($areS_aid))
				{
					$json_array=array(
						"success"=>'true',
						"chkareapresent"=>0				 
					);
				}
				else
				{
					$json_array=array(
						"success"=>'false',
						"chkareapresent"=>0				 
					);
				}
			}
            echo json_encode($json_array);
		}
		else
		{			
        	$this->Login();
		}
	}
	//Category
	public function Category()
	{
		if(isset($this->session->userdata['SAlogged_in'])){
			$data['CategoryDetails']=$this->SubAdmin_model->GetCategory();
			$this->load->view('SubAdmin/Header');
			$this->load->view('SubAdmin/Category',$data);
			$this->load->view('SubAdmin/Footer');
		}else{
			
        $this->Login();
		}
	}
	public function CheckCategoryNameExist()
    {
        $catname=$this->input->post('catnameval');	
		$result=$this->SubAdmin_model->CheckCategory($catname);
		 echo $result;
	}
	public function AddCategory()	
	{

		if (!is_dir('./assets/SubAdmin/Category/')) {
			mkdir('./assets/SubAdmin/Category/', 0777, TRUE);
		}
		$config['upload_path'] = './assets/SubAdmin/Category/';
		$config['allowed_types'] = 'jpg|png';
		$config['max_size'] = 100000;
		$new_name = time().$_FILES["txtcatimage"]['name'];	

		$config['file_name'] = $new_name;
		$this->load->library('upload', $config);	

		if(!$this->upload->do_upload('txtcatimage')) {			

				$error = array('error' => $this->upload->display_errors());
				echo '<script>';
				echo 'setTimeout(function () {swal("Please Select Jpeg or Png Document!", "'.$error['error'].'Max Height : 50px and Max Width : 50px", "error","10000");window.location.href="'.base_url()."SubAdmin/Category".'"';
				echo '}, 1000);</script>';
				$this->Category();
			}
			else 
			{
				$data = array($this->upload->data());
				$Category = array(
					'category_image' => '/assets/SubAdmin/Category/'.$data[0]['file_name'],
					'category_name'=> $this->input->post('txtcatname'),
				);

				if ($this->SubAdmin_model->AddCategory($Category)) {
					echo '<script>';
					echo 'setTimeout(function () {swal("Done!", "Category Added Succesfully.", "success");';
					echo '}, 1000);';
					echo 'setTimeout(function () {window.location.href="'.base_url()."SubAdmin/Category".'"';
					echo '}, 2000);</script>';
					$this->Category();

				} else {
					echo '<script>';
					echo 'setTimeout(function () {swal("Opps!", "There is some problem please try again after some time", "error");';
					echo '}, 1000);</script>';
					$this->Category();

				}

			

			}		

	}	
	public function EditChecCatNameExist()
    {
		$catid=$this->input->post('catidval');
		$catname=$this->input->post('catnameval');
		$result=$this->SubAdmin_model->EditCheckCategory($catid,$catname);
		 echo $result;
	}
	public function EditCategory()	
	{

		if (!is_dir('./assets/SubAdmin/Category/')) {
			mkdir('./assets/SubAdmin/Category/', 0777, TRUE);
		}
		$config['upload_path'] = './assets/SubAdmin/Category/';
		$config['allowed_types'] = 'jpg|png';
		$config['max_size'] = 100000;
		$new_name = time().$_FILES["edittxtcatimage"]['name'];	

		$config['file_name'] = $new_name;
		$this->load->library('upload', $config);	

		$catid = $this->input->post('catid');

		if(!empty($_FILES["edittxtcatimage"]['name']))
		{
			if(!$this->upload->do_upload('edittxtcatimage')) {				

				$error = array('error' => $this->upload->display_errors());
				echo '<script>';
				echo 'setTimeout(function () {swal("Please Select Jpeg or Png Document!", "'.$error['error'].'Max Height : 50px and Max Width : 50px", "error");';
				echo '}, 1000);</script>';
				$this->Category();

			}

			$data = array($this->upload->data());
			$Categoryimage = array(
				'category_image' => '/assets/SubAdmin/Category/'.$data[0]['file_name'],
			);
			$this->SubAdmin_model->UpdateCategory($catid,$Categoryimage);
		}
		$Category = array(
			'category_name'=> $this->input->post('edittxtcatname'),
		);	
		if ($this->SubAdmin_model->UpdateCategory($catid,$Category)) {
			echo '<script>';
			echo 'setTimeout(function () {swal("Done!", "Category Updated Succesfully.", "success");';
			echo '}, 1000);';
			echo 'setTimeout(function () {window.location.href="'.base_url()."SubAdmin/Category".'"';
			echo '}, 2000);</script>';
			$this->Category();
		} else {
			echo '<script>';
			echo 'setTimeout(function () {swal("Opps!", "There is some problem please try again after some time", "error");';
			echo '}, 1000);</script>';
			$this->Category();
		}	

	}
	public function DeleteCategory()
	{
		if(isset($this->session->userdata['SAlogged_in']))
		{
			$catid = $this->input->post('catid');
			$chkcatpresent = $this->SubAdmin_model->chkcategorypresent($catid);
			if($chkcatpresent==1)
			{
				$json_array=array(
					"success"=>'true',
					"chkcatpresent"=>1				 
				);				
			}
			else
			{
				if($this->SubAdmin_model->DeleteCategory($catid))
				{
					$json_array=array(
						"success"=>'true',
						"chkcatpresent"=>0				 
					);
				}
				else
				{
					$json_array=array(
						"success"=>'false',
						"chkcatpresent"=>0				 
					);
				}
			}
            echo json_encode($json_array);
		}
		else
		{			
        	$this->Login();
		}
	}
	//Sub Category
	public function SubCategory()
	{
		if(isset($this->session->userdata['SAlogged_in'])){
			$data['CategoryDetails']=$this->SubAdmin_model->GetCategory();
			$data['SubCategoryDetails']=$this->SubAdmin_model->GetSubCategory();
			$this->load->view('SubAdmin/Header');
			$this->load->view('SubAdmin/SubCategory',$data);
			$this->load->view('SubAdmin/Footer');
		}else{
			
        $this->Login();
		}
	}	
	public function CheckSubCategoryNameExist()
    {
		$catid=$this->input->post('catidval');
		$subcat=$this->input->post('subcatnameval');			
		$result=$this->SubAdmin_model->CheckSubCategory($catid,$subcat);
		 echo $result;
	}
	public function AddSubCategory()	
	{

		if (!is_dir('./assets/SubAdmin/SubCategory/')) {
			mkdir('./assets/SubAdmin/SubCategory/', 0777, TRUE);
		}
		$config['upload_path'] = './assets/SubAdmin/SubCategory /';
		$config['allowed_types'] = 'jpg|png';
		$config['max_size'] = 100000;
		$new_name = time().$_FILES["txtsubcatimage"]['name'];	

		$config['file_name'] = $new_name;
		$this->load->library('upload', $config);	

		if(!$this->upload->do_upload('txtsubcatimage')) {			

				$error = array('error' => $this->upload->display_errors());
				echo '<script>';
				echo 'setTimeout(function () {swal("Please Select Jpeg or Png Document!", "'.$error['error'].'Max Height : 50px and Max Width : 50px", "error");';
				echo '}, 1000);</script>';
				$this->SubCategory();
			}
			else 
			{
				$data = array($this->upload->data());
				$SubCategory = array(
					'sub_cat_image' => '/assets/SubAdmin/SubCategory/'.$data[0]['file_name'],
					'sub_cat_name'=> $this->input->post('txtsubcatname'),
					'cat_id'=> $this->input->post('txtcatid'),
				);

				if ($this->SubAdmin_model->AddSubCategory($SubCategory)) {
					echo '<script>';
					echo 'setTimeout(function () {swal("Done!", "Sub Category Added Succesfully.", "success");';
					echo '}, 1000);';
					echo 'setTimeout(function () {window.location.href="'.base_url()."SubAdmin/SubCategory".'"';
					echo '}, 2000);</script>';
					$this->SubCategory();

				} else {
					echo '<script>';
					echo 'setTimeout(function () {swal("Opps!", "There is some problem please try again after some time", "error");';
					echo '}, 1000);</script>';
					$this->SubCategory();

				}

			

			}		

	}
	public function EditCheckSubCatNameExist()
    {
		$subcatid=$this->input->post('subcatidval');
		$catid=$this->input->post('catidval');			
		$subcat=$this->input->post('subcatnameval');	
		$result=$this->SubAdmin_model->EditCheckSubCat($subcatid,$catid,$subcat);
		 echo $result;
	}
	public function EditSubCategory()	
	{

		if (!is_dir('./assets/SubAdmin/SubCategory/')) {
			mkdir('./assets/SubAdmin/SubCategory/', 0777, TRUE);
		}
		$config['upload_path'] = './assets/SubAdmin/SubCategory /';
		$config['allowed_types'] = 'jpg|png';
		$config['max_size'] = 100000;
		$new_name = time().$_FILES["edittxtsubcatimage"]['name'];	

		$config['file_name'] = $new_name;
		$this->load->library('upload', $config);	
		$config['file_name'] = $new_name;
		$this->load->library('upload', $config);	

		$subcatid = $this->input->post('subcatid');

		if(!empty($_FILES["edittxtsubcatimage"]['name']))
		{
			if(!$this->upload->do_upload('edittxtsubcatimage')) {				

				$error = array('error' => $this->upload->display_errors());
				echo '<script>';
				echo 'setTimeout(function () {swal("Please Select Jpeg or Png Document!", "'.$error['error'].'Max Height : 50px and Max Width : 50px", "error");';
				echo '}, 1000);</script>';
				$this->SubCategory();

			}

			$data = array($this->upload->data());
			$SubCategoryimage = array(
				'sub_cat_image' => '/assets/SubAdmin/SubCategory/'.$data[0]['file_name'],
			);
			$this->SubAdmin_model->UpdateSubCategory($subcatid,$SubCategoryimage);
		}
		$SubCategory = array(
			'sub_cat_name'=> $this->input->post('edittxtsubcatname'),
			'cat_id'=> $this->input->post('edittxtcatid'),
		);	
		if ($this->SubAdmin_model->UpdateSubCategory($subcatid,$SubCategory)) {
			echo '<script>';
			echo 'setTimeout(function () {swal("Updated!", "Sub Category Updated Succesfully.", "success");';
			echo '}, 1000);';
			echo 'setTimeout(function () {window.location.href="'.base_url()."SubAdmin/SubCategory".'"';
			echo '}, 2000);</script>';
			$this->SubCategory();
		} else {
			echo '<script>';
			echo 'setTimeout(function () {swal("Opps!", "There is some problem please try again after some time", "error");';
			echo '}, 1000);</script>';
			$this->SubCategory();
		}	

	}
	public function DeleteSubCategory()
	{
		if(isset($this->session->userdata['SAlogged_in']))
		{
			$subcatid = $this->input->post('subcatid');
			$chksubcatpresent = $this->SubAdmin_model->chksubcategorypresent($subcatid);
			if($chksubcatpresent==1)
			{
				$json_array=array(
					"success"=>'true',
					"chksubcatpresent"=>1				 
				);				
			}
			else
			{
				if($this->SubAdmin_model->DeleteSubCategory($subcatid))
				{
					$json_array=array(
						"success"=>'true',
						"chksubcatpresent"=>0				 
					);
				}
				else
				{
					$json_array=array(
						"success"=>'false',
						"chksubcatpresent"=>0				 
					);
				}
			}
            echo json_encode($json_array);
		}
		else
		{			
        	$this->Login();
		}
	}	
	//SubSubCategory
	public function SubSubCategory()
	{
		if(isset($this->session->userdata['SAlogged_in'])){
			$data['CategoryDetails']=$this->SubAdmin_model->GetCategory();
			$data['SubSubCategoryDetails']=$this->SubAdmin_model->GetSubSubCategory();
			
			$this->load->view('SubAdmin/Header');
			$this->load->view('SubAdmin/SubSubCategory',$data);
			$this->load->view('SubAdmin/Footer');
		}else{
			
        $this->Login();
		}
	}
	public function GetSubCategory()
	{
		if(isset($this->session->userdata['SAlogged_in'])){
			$catid = $this->input->post('catid');
			$data['SubCategoryDetails']=$this->SubAdmin_model->GetSubCategoryFromMainCategory($catid);
			$this->load->view('SubAdmin/fetchSubCategory',$data);		
		}
		else{	
        	$this->Login();
		}
	}
	public function CheckSubSubCategoryNameExist()
    {
		$subcatid=$this->input->post('subcatidval');
		$subsubcat=$this->input->post('subsubcatnameval');			
		$result=$this->SubAdmin_model->CheckSubSubCategory($subcatid,$subsubcat);
		 echo $result;
	}
	public function AddSubSubCategory()	
	{		
		if(isset($this->session->userdata['SAlogged_in']))
		{
			$SubSubCategory = array(
				'filt_name'=> $this->input->post('txtsubsubcatname'),
				'sub_cat_id'=> $this->input->post('txtsubcatid'),
				'vid'=> 0,
			);

			if ($this->SubAdmin_model->AddSubSubCategory($SubSubCategory)) {
				echo '<script>';
				echo 'setTimeout(function () {swal("Added!", "Sub Sub Category Added Succesfully.", "success");';
				echo '}, 1000);';
				echo 'setTimeout(function () {window.location.href="'.base_url()."SubAdmin/SubSubCategory".'"';
				echo '}, 2000);</script>';
				$this->SubSubCategory();

			} else {
				echo '<script>';
				echo 'setTimeout(function () {swal("Opps!", "There is some problem please try again after some time", "error");';
				echo '}, 1000);</script>';
				$this->SubSubCategory();

			}	
		}
		else
		{
			$this->Login();
		}

	}
	public function EditCheckSubSubCatNameExist()
    {
		$subsubcatid=$this->input->post('subsubcatidval');
		$subcatid=$this->input->post('subcatidval');			
		$subsubcat=$this->input->post('subsubcatnameval');	
		$result=$this->SubAdmin_model->EditCheckSubSubCat($subsubcatid,$subcatid,$subsubcat);
		 echo $result;
	}
	public function EditSubSubCategory()	
	{		
		if(isset($this->session->userdata['SAlogged_in']))
		{
			$subsubcatid=$this->input->post('subsubcatid');
			$SubSubCategory = array(
				'filt_name'=> $this->input->post('edittxtsubsubcatname'),
				'sub_cat_id'=> $this->input->post('txtsubcatid'),
				'vid'=> 0,
			);

			if ($this->SubAdmin_model->UpdateSubSubCategory($subsubcatid,$SubSubCategory)) {
				echo '<script>';
				echo 'setTimeout(function () {swal("Updated!", "Sub Sub Category Updated Succesfully.", "success");';
				echo '}, 1000);';
				echo 'setTimeout(function () {window.location.href="'.base_url()."SubAdmin/SubSubCategory".'"';
				echo '}, 2000);</script>';
				$this->SubSubCategory();

			} else {
				echo '<script>';
				echo 'setTimeout(function () {swal("Opps!", "There is some problem please try again after some time", "error");';
				echo '}, 1000);</script>';
				$this->SubSubCategory();

			}	
		}
		else
		{
			$this->Login();
		}
	}
	public function DeletesubSubCategory()
	{
		if(isset($this->session->userdata['SAlogged_in']))
		{
			$subsubcatid = $this->input->post('subsubcatid');
			$chksubsubcatpresent = $this->SubAdmin_model->chksubsubcategorypresent($subsubcatid);
			if($chksubsubcatpresent==1)
			{
				$json_array=array(
					"success"=>'true',
					"chksubsubcatpresent"=>1				 
				);				
			}
			else
			{
				if($this->SubAdmin_model->DeleteSubSubCategory($subsubcatid))
				{
					$json_array=array(
						"success"=>'true',
						"chksubsubcatpresent"=>0				 
					);
				}
				else
				{
					$json_array=array(
						"success"=>'false',
						"chksubsubcatpresent"=>0				 
					);
				}
			}
            echo json_encode($json_array);
		}
		else
		{			
        	$this->Login();
		}
	}
	//Quantity Type
	public function QuantityType()
	{
		if(isset($this->session->userdata['SAlogged_in'])){
			$data['QuantityTypeDetails']=$this->SubAdmin_model->GetQuantityType();
			$data['SubCategoryDetails']=$this->SubAdmin_model->GetSubCategory();
			$this->load->view('SubAdmin/Header');
			$this->load->view('SubAdmin/QuantityType',$data);
			$this->load->view('SubAdmin/Footer');
		}else{
			
        $this->Login();
		}
	}
	public function AddQuantityType()
    {
		if(isset($this->session->userdata['SAlogged_in']))
		{
			$qtytype = array(
				'sub_cat_id'=> $this->input->post('txtsubcatid'),
				'qty_type_name'=> $this->input->post('txtqtytype'),
			);
			if ($this->SubAdmin_model->AddQuantityType($qtytype)) {
                echo '<script>';
                echo 'setTimeout(function () {swal("Added!", "Your Quantity Type Succesfully Added.", "success");';
                echo '}, 1000);';
                echo 'setTimeout(function () {window.location.href="'.base_url()."SubAdmin/QuantityType".'"';
                echo '}, 2000);</script>';
                $this->QuantityType();
            } else {
                echo '<script>';
                echo 'setTimeout(function () {swal("Opps!", "There is some problem please try again after some time", "error");';
                echo '}, 1000);</script>';
                $this->QuantityType();
            }
		}
		else
        {
			$this->Login();
		} 
	}
	public function EditQuantityType()
    {
		if(isset($this->session->userdata['SAlogged_in']))
		{
			$qtytypeid = $this->input->post('qtytypeid');
			$qtytype = array(
				'sub_cat_id'=> $this->input->post('edittxtsubcatid'),
				'qty_type_name'=> $this->input->post('edittxtqtytype'),
			);
			if ($this->SubAdmin_model->UpdateQuantityType($qtytypeid,$qtytype)) {
                echo '<script>';
                echo 'setTimeout(function () {swal("Updated!", "Your Quantity Type Succesfully Updated.", "success");';
                echo '}, 1000);';
                echo 'setTimeout(function () {window.location.href="'.base_url()."SubAdmin/QuantityType".'"';
                echo '}, 2000);</script>';
                $this->QuantityType();
            } else {
                echo '<script>';
                echo 'setTimeout(function () {swal("Opps!", "There is some problem please try again after some time", "error");';
                echo '}, 1000);</script>';
                $this->QuantityType();
            }
		}
		else
        {
			$this->Login();
		} 
	}
	public function DeleteQuantityType()
	{
		if(isset($this->session->userdata['SAlogged_in']))
		{
			$qtytypeid = $this->input->post('qtytypeid');
			$chkqtytypepresent = $this->SubAdmin_model->chkqtytypepresent($qtytypeid);
			if($chkqtytypepresent==1)
			{
				$json_array=array(
					"success"=>'true',
					"chkqtytypepresent"=>1				 
				);				
			}
			else
			{
				if($this->SubAdmin_model->DeleteQuantityType($qtytypeid))
				{
					$json_array=array(
						"success"=>'true',
						"chkqtytypepresent"=>0				 
					);
				}
				else
				{
					$json_array=array(
						"success"=>'false',
						"chkqtytypepresent"=>0				 
					);
				}
			}
            echo json_encode($json_array);
		}
		else
		{			
        	$this->Login();
		}
	}
	//Quantity
	public function Quantity()
	{
		if(isset($this->session->userdata['SAlogged_in'])){
			$data['QuantityDetails']=$this->SubAdmin_model->GetQuantity();
			$data['SubCategoryDetails']=$this->SubAdmin_model->GetSubCategoryFromQtyType();
			$this->load->view('SubAdmin/Header');
			$this->load->view('SubAdmin/Quantity',$data);
			$this->load->view('SubAdmin/Footer');
		}else{
			
        $this->Login();
		}
	}
	public function GetQtyType()
	{
		if(isset($this->session->userdata['SAlogged_in'])){
			$subcatid=$this->input->post('subcatid');
			$data['QuantityTypeDetails']=$this->SubAdmin_model->GetQtyType($subcatid);
			//print_r($data['QuantityTypeDetails']);exit;
			$this->load->view('SubAdmin/fetchQuantitytype',$data);
		}else{
			
        $this->Login();
		}
	}
	public function AddQuantity()
    {
		if(isset($this->session->userdata['SAlogged_in']))
		{
			$qty = array(
				'qty_type_id'=> $this->input->post('qtytype'),
				'qty_name'=> $this->input->post('txtqtyname'),
			);
			if ($this->SubAdmin_model->AddQuantity($qty)) {
                echo '<script>';
                echo 'setTimeout(function () {swal("Added!", "Your Quantity Succesfully Added.", "success");';
                echo '}, 1000);';
                echo 'setTimeout(function () {window.location.href="'.base_url()."SubAdmin/Quantity".'"';
                echo '}, 2000);</script>';
                $this->Quantity();
            } else {
                echo '<script>';
                echo 'setTimeout(function () {swal("Opps!", "There is some problem please try again after some time", "error");';
                echo '}, 1000);</script>';
                $this->Quantity();
            }
		}
		else
        {
			$this->Login();
		} 
	}
	public function EditQuantity()
    {
		if(isset($this->session->userdata['SAlogged_in']))
		{
			$qtyid = $this->input->post('qtyid');
			$qty = array(
				'qty_type_id'=> $this->input->post('qtytype'),
				'qty_name'=> $this->input->post('edittxtqtyname'),
			);
			if ($this->SubAdmin_model->UpdateQuantity($qtyid,$qty)) {
                echo '<script>';
                echo 'setTimeout(function () {swal("Updated!", "Your Quantity Succesfully Updated.", "success");';
                echo '}, 1000);';
                echo 'setTimeout(function () {window.location.href="'.base_url()."SubAdmin/Quantity".'"';
                echo '}, 2000);</script>';
                $this->Quantity();
            } else {
                echo '<script>';
                echo 'setTimeout(function () {swal("Opps!", "There is some problem please try again after some time", "error");';
                echo '}, 1000);</script>';
                $this->Quantity();
            }
		}
		else
        {
			$this->Login();
		} 
	}
	public function DeleteQuantity()
	{
		if(isset($this->session->userdata['SAlogged_in']))
		{
			$qtyid = $this->input->post('qtyid');			
			if($this->SubAdmin_model->DeleteQuantity($qtyid))
			{
				$json_array=array(
					"success"=>'true'				 
				);
			}
			else
			{
				$json_array=array(
					"success"=>'false'				 
				);
			}
			echo json_encode($json_array);
		}       		
		else
		{			
        	$this->Login();
		}
	}
	//ItemsRequest
	public function ItemsRequest()
	{
		if(isset($this->session->userdata['SAlogged_in'])){
			$data['ItemsRequest']=$this->SubAdmin_model->GetItemsRequest();
			$this->load->view('SubAdmin/Header');
			$this->load->view('SubAdmin/ItemsRequest',$data);
			$this->load->view('SubAdmin/Footer');
		}else{
			
        $this->Login();
		}
	}
	//Items
	public function Items()
	{
		if(isset($this->session->userdata['SAlogged_in'])){
			$data['ItemsRequest']=$this->SubAdmin_model->GetItems();
			$this->load->view('SubAdmin/Header');
			$this->load->view('SubAdmin/items',$data);
			$this->load->view('SubAdmin/Footer');
		}else{
			
        $this->Login();
		}
	}
	//BlockUnblock Itemn
	public function BlokUnblockItem()
	{
		$block = $this->input->post('blockValue');
		$itemid = $this->input->post('itemid');		  
		$blockunblockvalue = array(
			'block' => $block
		);	 
		if(isset($this->session->userdata['SAlogged_in'])){
			$this->SubAdmin_model->BlockUnblockItem($itemid,$blockunblockvalue);
			$json_array=array(
				"success"=>'true',
				"blockval"=>$block				 
				);
				
			echo json_encode($json_array);

		}else{
			$this->Login();
		}
	}
	//Item Accept Reject Status
	public function ItemAcceptRejectStatus()
	{
		if(isset($this->session->userdata['SAlogged_in']))
		{
			$itemstatus = $this->input->post('itemstatus');
			$itemid = $this->input->post('itemid');	
			if($itemstatus == 'Accepted')	 
			{
				$itemstatusvalue = array(
					'verified' => 1
				);				
				$this->SubAdmin_model->BlockUnblockItem($itemid,$itemstatusvalue);					
			} 
			else{
				$this->SubAdmin_model->DeleteItem($itemid);
			}
			$json_array=array(
				"success"=>'true',
				"status"=>$itemstatus				 
			);
				
			echo json_encode($json_array);
		}
		else
		{
			$this->Login();
		}
	}
	//VendorRequest
	public function VendorRequest()
	{
		if(isset($this->session->userdata['SAlogged_in'])){
			$data['VendorRequest']=$this->SubAdmin_model->GetVendorRequest();
			$this->load->view('SubAdmin/Header');
			$this->load->view('SubAdmin/VendorRequest',$data);
			$this->load->view('SubAdmin/Footer');
		}else{
			
        $this->Login();
		}
	}	
	//Vendor Accept Reject Status
	public function VendorAcceptRejectStatus()
	{
		if(isset($this->session->userdata['SAlogged_in']))
		{
			$vendorstatus = $this->input->post('vendorstatus');
			$vendorid = $this->input->post('vendorid');	
			if($vendorstatus == 'Accepted')	 
			{
				$vendorstatusvalue = array(
					'verified' => 1
				);				
				$this->SubAdmin_model->BlockUnblockVendor($vendorid,$vendorstatusvalue);					
			} 
			else{
				$this->SubAdmin_model->DeleteVendor($vendorid);
			}
			$json_array=array(
				"success"=>'true',
				"status"=>$vendorstatus				 
			);
				
			echo json_encode($json_array);
		}
		else
		{
			$this->Login();
		}
	}
	//Delivery boy Request
	public function DeliveryBoyRequest()
	{
		if(isset($this->session->userdata['SAlogged_in'])){
			$data['DeliveryBoyRequest']=$this->SubAdmin_model->GetDeliveryBoyRequest();
			$this->load->view('SubAdmin/Header');
			$this->load->view('SubAdmin/DeliveryBoyRequest',$data);
			$this->load->view('SubAdmin/Footer');
		}else{
			
        $this->Login();
		}
	}	
	//DeliveryBoy Accept Reject Status
	public function DeliveryBoyAcceptRejectStatus()
	{
		if(isset($this->session->userdata['SAlogged_in']))
		{
			$deliveryboystatus = $this->input->post('deliveryboystatus');
			$deliveryboyid = $this->input->post('deliveryboyid');	
			if($deliveryboystatus == 'Accepted')	 
			{
				$deliveryboystatusvalue = array(
					'verified' => 1
				);				
				$this->SubAdmin_model->BlockUnblockDeliveryBoy($deliveryboyid,$deliveryboystatusvalue);					
			} 
			else{
				$this->SubAdmin_model->DeleteDeliveryBoy($deliveryboyid);
			}
			$json_array=array(
				"success"=>'true',
				"status"=>$deliveryboystatus				 
			);
				
			echo json_encode($json_array);
		}
		else
		{
			$this->Login();
		}
	}
	//Vendor Details
	public function Vendor()
	{
		if(isset($this->session->userdata['SAlogged_in'])){
			$data['VendorDetails']=$this->SubAdmin_model->GetVendor();
			$data['CityDetails']=$this->SubAdmin_model->GetCities();
			$data['CategoryDetails']=$this->SubAdmin_model->GetCategory();
			$this->load->view('SubAdmin/Header');
			$this->load->view('SubAdmin/Vendor',$data);
			$this->load->view('SubAdmin/Footer');
		}else{
			
        $this->Login();
		}
	}	
	//BlockUnblock Vendor
	public function BlokUnblockVendor()
	{
		$block = $this->input->post('blockValue');
		$vendorid = $this->input->post('vendorid');		  
		$blockunblockvalue = array(
			'block' => $block
		);	 
		if(isset($this->session->userdata['SAlogged_in'])){
			$this->SubAdmin_model->BlockUnblockVendor($vendorid,$blockunblockvalue);
			$json_array=array(
				"success"=>'true',
				"blockval"=>$block				 
				);
				
			echo json_encode($json_array);

		}else{
			$this->Login();
		}
	}
	//Getarea
	public function GetArea()
	{
		if(isset($this->session->userdata['SAlogged_in'])){
			$cityid = $this->input->post('cityid');
			$data['AreaDetails']=$this->SubAdmin_model->GetAreaFromCity($cityid);
			$this->load->view('SubAdmin/fetchArea',$data);		
		}
		else{	
        	$this->Login();
		}
	}
	//Check Category Exist For City   
	public function CheckCategoryExistForCity()
    {
		$cityid=$this->input->post('cityidval');
		$catid=$this->input->post('catidval');	
		$result=$this->SubAdmin_model->CheckCategoryExistForCity($cityid,$catid);
		 echo $result;
	}
	public function SendPasswordlogin($mobile,$textmessage)	
	{
		$arrContextOptions=array(
			"ssl"=>array(
				"verify_peer"=>false,
				"verify_peer_name"=>false,
			),
		);	
		$api_key = '167711A8eUIJ9g4h0597ec43d';
		$contacts = $mobile;
		$from = 'AdiAPP';
		$sms_text = urlencode($textmessage);
		
		$api_url = "http://login.wishbysms.com/api/sendhttp.php?authkey=".$api_key."&mobiles=".$contacts."&message=".$sms_text."&sender=".$from."&route=4&country=0";
		
		//Submit to server
		$response = file_get_contents( $api_url, false, stream_context_create($arrContextOptions));
		if(!$response){ 
			return false;
		}
		else
		{
			return true;
		}			
	}
	public function AddVendor()
    {
		if(isset($this->session->userdata['SAlogged_in']))
		{
			$BusinessCategory = $this->input->post('txtcatid');
           	$comma_separated = implode(',', $BusinessCategory);
			$vendor = array(
				'name'=> $this->input->post('txtvendorname'),
				'shop_name'=> $this->input->post('txtshopname'),
				'address'=> $this->input->post('txtaddress'),
				'city_id'=> $this->input->post('txtcityid'),
				'area_id'=> $this->input->post('txtareaid'),
				'mobile_no'=> $this->input->post('txtmobileno'),
				'open_time'=> $this->input->post('txtopentime'),
				'close_time'=> $this->input->post('txtclosetime'),
				'business_category'=> $comma_separated,
				'shop_type'=> $this->input->post('txtshoptype'),
				'password'=> $this->GenerateRandomOtp(),
				'verified'=> 0,
				'block'=> 0,
				'anoti'=> 0,
			);				
			if ($this->SubAdmin_model->AddVendor($vendor)) {

				$password=$this->GenerateRandomOtp();
				$mobile=$this->input->post('txtmobileno');
				$textmessage = $password." is a Password for Your Account.Thanks For Be a Part of AMM SHOP";				
				$this->SendPasswordlogin($mobile,$textmessage);
                echo '<script>';
                echo 'setTimeout(function () {swal("Added!", "Your Vendor Succesfully Added.", "success");';
                echo '}, 1000);';
                echo 'setTimeout(function () {window.location.href="'.base_url()."SubAdmin/Vendor".'"';
                echo '}, 2000);</script>';
                $this->Vendor();
            } else {
                echo '<script>';
                echo 'setTimeout(function () {swal("Opps!", "There is some problem please try again after some time", "error");';
                echo '}, 1000);</script>';
                $this->Vendor();
            }
		}
		else
        {
			$this->Login();
		} 
	}
	//Edit Check Category Exist For City
	public function EditCheckCategoryExistForCity()
    {
		$vid=$this->input->post('vendoridval');
		$cityid=$this->input->post('cityidval');			
		$catid=$this->input->post('catidval');	
		$result=$this->SubAdmin_model->EditCheckCategoryExistForCity($vid,$cityid,$catid);
		 echo $result;
	}
	public function EditVendor()
    {
		if(isset($this->session->userdata['SAlogged_in']))
		{
			$vid=$this->input->post('vid');
			$BusinessCategory = $this->input->post('edittxtcatid');		
			$comma_separated = implode(',', $BusinessCategory);			
			$vendor = array(
				'name'=> $this->input->post('edittxtvendorname'),
				'shop_name'=> $this->input->post('edittxtshopname'),
				'address'=> $this->input->post('edittxtaddress'),
				'city_id'=> $this->input->post('edittxtcityid'),
				'area_id'=> $this->input->post('txtareaid'),
				'mobile_no'=> $this->input->post('edittxtmobileno'),
				'open_time'=> $this->input->post('edittxtopentime'),
				'close_time'=> $this->input->post('edittxtclosetime'),
				'business_category'=> $comma_separated,
				'shop_type'=> $this->input->post('edittxtshoptype'),
				'verified'=> 0,
				'block'=> 0,
				'anoti'=> 0,
			);				
			if ($this->SubAdmin_model->UpdateVendor($vid,$vendor)) {

				$password=$this->GenerateRandomOtp();
				$mobile=$this->input->post('edittxtmobileno');
				$textmessage = $password." is a Password for Your Account.Thanks For Be a Part of AMM SHOP";				
				$this->SendPasswordlogin($mobile,$textmessage);
                echo '<script>';
                echo 'setTimeout(function () {swal("Updated!", "Your Vendor Succesfully Updated.", "success");';
                echo '}, 1000);';
                echo 'setTimeout(function () {window.location.href="'.base_url()."SubAdmin/Vendor".'"';
                echo '}, 2000);</script>';
                $this->Vendor();
            } else {
                echo '<script>';
                echo 'setTimeout(function () {swal("Opps!", "There is some problem please try again after some time", "error");';
                echo '}, 1000);</script>';
                $this->Vendor();
            }
		}
		else
        {
			$this->Login();
		} 
	}
	public function DeleteVendor()
	{
		if(isset($this->session->userdata['SAlogged_in']))
		{
			$vid = $this->input->post('vid');
			$chkvendorpresent = $this->SubAdmin_model->chkvendorpresent($vid);
			if($chkvendorpresent==1)
			{
				$json_array=array(
					"success"=>'true',
					"chkvendorpresent"=>1				 
				);				
			}
			else
			{
				if($this->SubAdmin_model->DeleteVendor($vid))
				{
					$json_array=array(
						"success"=>'true',
						"chkvendorpresent"=>0				 
					);
				}
				else
				{
					$json_array=array(
						"success"=>'false',
						"chkvendorpresent"=>0				 
					);
				}
			}
            echo json_encode($json_array);
		}
		else
		{			
        	$this->Login();
		}
	}
	//Delivery boy Details
	public function DeliveryBoy()
	{
		if(isset($this->session->userdata['SAlogged_in'])){
			$data['DeliveryBoyDetails']=$this->SubAdmin_model->GetDeliveryBoy();
			$this->load->view('SubAdmin/Header');
			$this->load->view('SubAdmin/DeliveryBoy',$data);
			$this->load->view('SubAdmin/Footer');
		}else{
			
        $this->Login();
		}
	}	
	//BlockUnblock DeliveryBoy
	public function BlokUnblockDeliveryBoy()
	{
		$block = $this->input->post('blockValue');
		$deliveryboyid = $this->input->post('deliveryboyid');		  
		$blockunblockvalue = array(
			'block' => $block
		);	 
		if(isset($this->session->userdata['SAlogged_in'])){
			$this->SubAdmin_model->BlockUnblockDeliveryBoy($deliveryboyid,$blockunblockvalue);
			$json_array=array(
				"success"=>'true',
				"blockval"=>$block				 
				);
				
			echo json_encode($json_array);

		}else{
			$this->Login();
		}
	}
	//Check Mobile no Exist For Delivery Boy   
	public function CheckMobileNoExist()
    {
		$mobileno=$this->input->post('mobilenoval');	
		$result=$this->SubAdmin_model->CheckMobileNoExistForDeliveryBoy($mobileno);
		 echo $result;
	}
	public function AddDeliveryBoy()
    {
		if(isset($this->session->userdata['SAlogged_in']))
		{
			$password=$this->GenerateRandomOtp();
			$mobile=$this->input->post('txtmobileno');
			$deliveryboy = array(
				'name'=> $this->input->post('txtdeliveryboyname'),
				'mobile_no'=> $this->input->post('txtmobileno'),
				'email'=> $this->input->post('txtemail'),
				'password'=> $password,
				'verified'=> 0,
				'block'=> 0
			);				
			if ($this->SubAdmin_model->AddDeliveryBoy($deliveryboy)) {

				$textmessage = $password." is a Password for Your Account.Thanks For Be a Part of AMM SHOP";				
				$this->SendPasswordlogin($mobile,$textmessage);
                echo '<script>';
                echo 'setTimeout(function () {swal("Added!", "Your Delivery Boy Succesfully Added.", "success");';
                echo '}, 1000);';
                echo 'setTimeout(function () {window.location.href="'.base_url()."SubAdmin/DeliveryBoy".'"';
                echo '}, 2000);</script>';
                $this->DeliveryBoy();
            } else {
                echo '<script>';
                echo 'setTimeout(function () {swal("Opps!", "There is some problem please try again after some time", "error");';
                echo '}, 1000);</script>';
                $this->DeliveryBoy();
            }
		}
		else
        {
			$this->Login();
		} 
	}
	public function EditCheckMobileNoExist()
    {
		$did=$this->input->post('delid');
		$mobileno=$this->input->post('mobilenoval');		
		$result=$this->SubAdmin_model->EditCheckCheckMobile($did,$mobileno);
		 echo $result;
	}
	public function EditDeliveryBoy()
    {
		if(isset($this->session->userdata['SAlogged_in']))
		{
			$did=$this->input->post('did');
			$password=$this->GenerateRandomOtp();
			$mobile=$this->input->post('txtmobileno');
			$deliveryboy = array(
				'name'=> $this->input->post('edittxtdeliveryboyname'),
				'mobile_no'=> $this->input->post('edittxtmobileno'),
				'email'=> $this->input->post('edittxtemail'),
				'password'=> $password,
				'verified'=> 0,
				'block'=> 0
			);				
			if ($this->SubAdmin_model->UpdateDeliveryBoy($did,$deliveryboy) ) {
				
				$textmessage = $password." is a Password for Your Account.Thanks For Be a Part of AMM SHOP";				
				$this->SendPasswordlogin($mobile,$textmessage);
                echo '<script>';
                echo 'setTimeout(function () {swal("Updated!", "Your Delivery Boy Succesfully Updated.", "success");';
                echo '}, 1000);';
                echo 'setTimeout(function () {window.location.href="'.base_url()."SubAdmin/DeliveryBoy".'"';
                echo '}, 2000);</script>';
                $this->DeliveryBoy();
            } else {
                echo '<script>';
                echo 'setTimeout(function () {swal("Opps!", "There is some problem please try again after some time", "error");';
                echo '}, 1000);</script>';
                $this->DeliveryBoy();
            }
		}
		else
        {
			$this->Login();
		} 
	}
	public function DeleteDeliveryBoy()
	{
		if(isset($this->session->userdata['SAlogged_in']))
		{
			$did = $this->input->post('did');
			$chkdeliveryboypresent = $this->SubAdmin_model->chkdeliveryboypresent($did);
			if($chkdeliveryboypresent==1)
			{
				$json_array=array(
					"success"=>'true',
					"chkdeliveryboypresent"=>1				 
				);				
			}
			else
			{
				if($this->SubAdmin_model->DeleteDeliveryBoy($did))
				{
					$json_array=array(
						"success"=>'true',
						"chkdeliveryboypresent"=>0				 
					);
				}
				else
				{
					$json_array=array(
						"success"=>'false',
						"chkdeliveryboypresent"=>0				 
					);
				}
			}
            echo json_encode($json_array);
		}
		else
		{			
        	$this->Login();
		}
	}
	//Sub SubAdmin
	public function SubAdmin()
	{
		if(isset($this->session->userdata['SAlogged_in'])){
			$data['SubAdminDetails']=$this->SubAdmin_model->GetSubAdmin();
			$this->load->view('SubAdmin/Header');
			$this->load->view('SubAdmin/SubAdmin',$data);
			$this->load->view('SubAdmin/Footer');
		}else{
			
        $this->Login();
		}
	}
	public function CheckMobileNoExistForSubSubAdmin()
    {
		$mobileno=$this->input->post('mobilenoval');	
		$result=$this->SubAdmin_model->CheckMobileNoExistForSubSubAdmin($mobileno);
		 echo $result;
	}
	public function AddSubSubAdmin()
    {
		if(isset($this->session->userdata['SAlogged_in']))
		{
			$password=$this->GenerateRandomOtp();
			$mobile=$this->input->post('txtmobileno');
			$subSubAdmin = array(
				'sub_SubAdmin_name'=> $this->input->post('txtsubSubAdminname'),
				'mobile_no'=> $this->input->post('txtmobileno'),
				'email'=> $this->input->post('txtemail'),
				'address'=> $this->input->post('txtaddress'),
				'password'=> $password,
				'verified'=> 1,
				'block'=> 0,
			);				
			if ($this->SubAdmin_model->AddSubSubAdmin($subSubAdmin)) {

				$textmessage = $password." is a Password for Your Account.Thanks For Be a Part of AMM SHOP";				
				$this->SendPasswordlogin($mobile,$textmessage);
                echo '<script>';
                echo 'setTimeout(function () {swal("Added!", "Your Sub SubAdmin Succesfully Added.", "success");';
                echo '}, 1000);';
                echo 'setTimeout(function () {window.location.href="'.base_url()."SubAdmin/SubSubAdmin".'"';
                echo '}, 2000);</script>';
                $this->SubSubAdmin();
            } else {
                echo '<script>';
                echo 'setTimeout(function () {swal("Opps!", "There is some problem please try again after some time", "error");';
                echo '}, 1000);</script>';
                $this->SubSubAdmin();
            }
		}
		else
        {
			$this->Login();
		} 
	}
	public function EditCheckMobileNoExistForSubSubAdmin()
    {
		$sS_aid=$this->input->post('sS_aid');
		$mobileno=$this->input->post('mobilenoval');		
		$result=$this->SubAdmin_model->EditCheckMobileNoExistForSubSubAdmin($sS_aid,$mobileno);
		 echo $result;
	}
	public function EditSubSubAdmin()
    {
		if(isset($this->session->userdata['SAlogged_in']))
		{
			$sS_aid=$this->input->post('sS_aid');
			$password=$this->GenerateRandomOtp();
			$mobile=$this->input->post('edittxtmobileno');
			$subSubAdmin = array(
				'sub_SubAdmin_name'=> $this->input->post('edittxtsubSubAdminname'),
				'mobile_no'=> $this->input->post('edittxtmobileno'),
				'email'=> $this->input->post('edittxtemail'),
				'address'=> $this->input->post('edittxtaddress'),
				'password'=> $password,
				'verified'=> 1,
				'block'=> 0,
			);				
			if ($this->SubAdmin_model->UpdateSubSubAdmin($sS_aid,$subSubAdmin)) {

				$textmessage = $password." is a Password for Your Account.Thanks For Be a Part of AMM SHOP";				
				//$this->SendPasswordlogin($mobile,$textmessage);
                echo '<script>';
                echo 'setTimeout(function () {swal("Updated!", "Your Sub SubAdmin Succesfully Updated.", "success");';
                echo '}, 1000);';
                echo 'setTimeout(function () {window.location.href="'.base_url()."SubAdmin/SubSubAdmin".'"';
                echo '}, 2000);</script>';
                $this->SubSubAdmin();
            } else {
                echo '<script>';
                echo 'setTimeout(function () {swal("Opps!", "There is some problem please try again after some time", "error");';
                echo '}, 1000);</script>';
                $this->SubSubAdmin();
            }
		}
		else
        {
			$this->Login();
		} 
	}
	public function DeleteSubSubAdmin()
	{
		if(isset($this->session->userdata['SAlogged_in']))
		{
			$sS_aid = $this->input->post('sS_aid');
			if($this->SubAdmin_model->DeleteSubSubAdmin($sS_aid))
			{
				$json_array=array(
					"success"=>'true',
					"chkssubSubAdminpresent"=>0				 
				);
			}
			else
			{
				$json_array=array(
					"success"=>'false',
					"chkssubSubAdminpresent"=>0				 
				);
			}		
            echo json_encode($json_array);
		}
		else
		{			
        	$this->Login();
		}
	}
	public function BlokUnblockSubSubAdmin()
	{
		$block = $this->input->post('blockValue');
		$sS_aid = $this->input->post('sS_aid');		  
		$blockunblockvalue = array(
			'block' => $block
		);	 
		if(isset($this->session->userdata['SAlogged_in'])){
			$this->SubAdmin_model->BlockUnblockSubSubAdmin($sS_aid,$blockunblockvalue);
			$json_array=array(
				"success"=>'true',
				"blockval"=>$block				 
				);
				
			echo json_encode($json_array);

		}else{
			$this->Login();
		}
	}
	private function getnotificationdata()
	{
		if(isset($this->session->userdata['SAlogged_in'])){       
			$data["ItemsDataNoti"]=$this->SubAdmin_model->GetNewItemsDataNoti();
			$data["VendorsDataNoti"]=$this->SubAdmin_model->GetNewVendorsDataNoti();        
			return $data;
		}else{		

			$this->Login();
		}
	}
	public function Notification()	
	{
		if(isset($this->session->userdata['SAlogged_in'])){
			$data=$this->getnotificationdata();
			// print_r($data);exit;
			$this->load->view('SubAdmin/Header');
			$this->load->view('SubAdmin/Notification',$data);
			$this->load->view('SubAdmin/Footer');
		}else{		
			$this->Login();
		}
	}
	//Notification
	/*public function setchecknoti()
	{
		$anoti = array(
			'anoti' => 1
		);
		if ( $this->SubAdmin_model->setcheckitemsnoti($anoti)) {		
			echo 1;	
		} else {
			echo 0;
		}
	}*/
	public function VendorPayments()	
	{
		if(isset($this->session->userdata['SAlogged_in'])){
			$data['VendorPaymentDetails']=$this->SubAdmin_model->GetVendorPaymentDetails();
			$data['CityDetails']=$this->SubAdmin_model->GetCities();
			$this->load->view('SubAdmin/Header');
			$this->load->view('SubAdmin/VendorPayments',$data);
			$this->load->view('SubAdmin/Footer');
		}else{
			$this->Login();
		}
	} 
	//Change Paymnent Status
	public function ChangePaymentStatus()
	{

		$vbid = $this->input->post('vbid');
		$status = $this->input->post('status');	
		if($status == 'Accepted')	
		{
			$statusvalue = array(
				'Status' => 'PS_aid'
			); 
		}
		else	 
		{
			$statusvalue = array(
				'Status' => 'NotPS_aid'
			); 
		}
		if(isset($this->session->userdata['SAlogged_in'])){
			$this->SubAdmin_model->ChangePaymentStatus($vbid,$statusvalue);
			$json_array=array(
				"success"=>'true',
				"paymentstatus"=>$statusvalue	 
				);
			echo json_encode($json_array);
		}else{
			$this->Login();

		}

	}
	//GetVendor
	public function GetVendor()
	{
		if(isset($this->session->userdata['SAlogged_in'])){
			$cityid = $this->input->post('cityid');
			$data['VendorDetails']=$this->SubAdmin_model->GetVendorFromCity($cityid);
			$this->load->view('SubAdmin/fetchVendor',$data);		
		}
		else{	
        	$this->Login();
		}
	}
	public function AddPayment()	
	{
		$vid=$this->input->post('txtvedorid');  
		$billdate=$this->input->post('billdate'); 
		$dbbilldate=date('Y-m-d',strtotime($billdate));
		$paymenttype=$this->input->post('paymenttype');
			$data = array(
				'Amount'=> $this->input->post('amount'),
				'Billdate'=> $dbbilldate,
				'Status'=> 'PS_aid',
				'Payment_type'=> $paymenttype,
				'Chequeno'=> $this->input->post('chequeno'),
				'Transactionid'=> $this->input->post('transactionid'),
				'Vid'=> $vid,
			); 
		if ($this->SubAdmin_model->AddVendorPayment($data)) {
			echo '<script>';
			echo 'setTimeout(function () {swal("Added!", "Payment Succesfully Added!", "success");';
			echo '}, 1000);';
			echo 'setTimeout(function () {window.location.href="'.base_url()."SubAdmin/VendorPayments".'"';
			echo '}, 2000);</script>';
			$this->VendorPayments();
		} else {
			echo '<script>';
			echo 'setTimeout(function () {swal("Opps!", "There is some problem please try again after some time", "error");';
			echo '}, 1000);</script>';
			$this->VendorPayments();
		} 
	}
	//Orders
	public function Orders()
	{
		if(isset($this->session->userdata['SAlogged_in'])){
			$S_aid=$this->session->userdata['SAlogged_in']['S_aid'];
			$s_cityid=$this->SubAdmin_model->GetSubAdminCity($S_aid);			
			$data['OrdersDetails']=$this->SubAdmin_model->GetOrders($s_cityid);		
			$this->load->view('SubAdmin/Header');
			$this->load->view('SubAdmin/Orders',$data);
			$this->load->view('SubAdmin/Footer');
		}else{
			
        $this->Login();
		}
	}
	/*public function GetOrderStatusResult()		
	{		
		$orderstatus=$this->input->post('orderstatus');		
			if(isset($this->session->userdata['SAlogged_in']))			
			{		
				if($orderstatus == '1')		
				{		
				$data['OrderDetails']=$this->EcomSubAdmin_model->GetNewOrders();				
				}		
				elseif($orderstatus == '2')		
				{		
				$data['OrderDetails']=$this->EcomSubAdmin_model->GetCompletedOrders();
				}		
				elseif($orderstatus == '3')		
				{		
				$data['OrderDetails']=$this->EcomSubAdmin_model->GetCriticalOrders();	
				}		
				elseif($orderstatus == '4')		
				{		
				$data['OrderDetails']=$this->EcomSubAdmin_model->GetFailedOrders();
				}
				elseif($orderstatus == '5')		
				{		
				$data['OrderDetails']=$this->EcomSubAdmin_model->GetFailedOrders();
				}
			
				$this->load->view('EcomSubAdmin/FetchOrderDetailsOnStatus',$data);
			}		
		}else{$this->Login();}
	}  */
	public function GenerateInvoice()
    {
        if(isset($this->session->userdata['SAlogged_in'])){
            //$viid=$this->input->post('viid');           
          //  $uid=$this->input->post('uid');
		  //  $uS_aid=$this->input->post('uS_aid');
		  	$orderid=$this->input->post('orderid');
            $data['OrderDetails']=$this->SubAdmin_model->GetUserDetails($orderid);
			 $this->load->view('SubAdmin/invoice',$data);
		}else{		
        $this->Login();
		}

	}
	public function ChangeOrderStatus()
    {
        $orderstatus=$this->input->post('status');
        $oid=$this->input->post('oid');
        if(isset($this->session->userdata['SAlogged_in'])){
            $statusvalue = array(
                'Status' => $orderstatus
            );
            $this->SubAdmin_model->ChangeOrderStatus($oid,$statusvalue);
            $json_array=array(
                "success"=>'true',
                "orderstatus"=>$orderstatus	  
			);
            echo json_encode($json_array);
                      
        }else{           
            $this->Login();
        }
	}
	public function DownloadInvoicePDF()    
    {

        if(isset($this->session->userdata['SAlogged_in']))

        {
            $this->load->library('Fpdf_gen');
            
            $orderid=$this->input->get('orderid');
			$OrderDetails=$this->SubAdmin_model->GetUserDetails($orderid);	
			
			$iname = explode("/",$OrderDetails[0]->iname);	
			$vname = explode("/",$OrderDetails[0]->vname);
			$iprice = explode("/",$OrderDetails[0]->iprice);		
			$qty =  explode(",",$OrderDetails[0]->qty);	
			//print_r($singlevname[$r]);echo "<br>";
			$invoiceheader='./assets/SubAdmin/images/logo/amshoplogo.png';

			$finalinvoiceheader=base_url().$invoiceheader;
			$unique_vname=array_unique($vname);
			//print_r(count($unique_vname));exit;
			//Logo

			$this->fpdf->Image($finalinvoiceheader,10,8,40);

				//PDF Header Content         

				$this->fpdf->SetFont('Arial','B',18);

				// Move to the right

				$this->fpdf->Cell(80);

				// Title

				$this->fpdf->Cell(30,18,'Invoice',0,0,'C');

				// Line break

				$this->fpdf->Ln(20);



				$this->fpdf->SetFont('Arial','B',14);

				$this->fpdf->Cell(130,5,'Shipped To',0,0);

				$this->fpdf->Cell(59,5,'Order Details',0,1);



				$this->fpdf->SetFont('Arial','',12);



				$this->fpdf->Cell(130,5,$OrderDetails[0]->uname,0,0);

				$this->fpdf->Cell(59,5,'',0,1);
				
				$this->fpdf->Cell(130,5,$OrderDetails[0]->uemail,0,0);

				$this->fpdf->Cell(30,5,'OrderId #:',0,0);

				$this->fpdf->Cell(29,5,$OrderDetails[0]->order_id,0,1);


				$orderDate = date('d-m-Y', strtotime($OrderDetails[0]->date));

				$this->fpdf->Cell(130,5,$OrderDetails[0]->umobile,0,0);

				$this->fpdf->Cell(30,5,'Order Date:',0,0);

				$this->fpdf->Cell(29,5,$orderDate,0,1);

				
				$deliveryDate = date('d-m-Y', strtotime($OrderDetails[0]->deliverydate));

				$this->fpdf->Cell(130,5,$OrderDetails[0]->uaddress,0,0);

				$this->fpdf->Cell(30,5,'Delivery Date:',0,0);

				$this->fpdf->Cell(29,5,$deliveryDate,0,1);

				//Dumy empty cell as vertical spacer

				$this->fpdf->Cell(189,10,'',0,1);//end of file
			
				$subtotal=0;
				if(count($unique_vname) == 1)
				{
					for($j=0;$j<count($unique_vname);$j++)
					{
						$singlevname=explode(":",$unique_vname[$j]);
						
						//Billing address
						$this->fpdf->SetFont('Arial','B',12);
						$this->fpdf->Cell(100,5,'Vendor Details',0,1);					
					
						for($r=0;$r<count($singlevname);$r++)
						{
							
								$this->fpdf->SetFont('Arial','',12);
								$this->fpdf->Cell(10,5,'',0,0);
								$this->fpdf->Cell(90,5,$singlevname[$r],0,1);									
						}
							//Invoice Content

							$this->fpdf->SetFont('Arial','B',12);


							$this->fpdf->Cell(61,5,'Item',1,0,'C');
							$this->fpdf->Cell(34,5,'Price',1,0,'C');
							$this->fpdf->Cell(15,5,'Qty',1,0,'C');
							$this->fpdf->Cell(15,5,'Ship',1,0,'C');
							$this->fpdf->Cell(15,5,'CGST',1,0,'C');
							$this->fpdf->Cell(15,5,'SGST',1,0,'C');
							$this->fpdf->Cell(34,5,'Total',1,1,'C');		
							if(count($iname)>0)
							{		
								for($k=0;$k<count($iname);$k++)
								{
									
									// Number of right aligned so we give R After new line parameter            
									$this->fpdf->SetFont('Arial','',12);
									//Invoice Content              
									$this->fpdf->Cell(61,5,$iname[$k],1,0);
									$this->fpdf->Cell(34,5,$iprice[$k],1,0,'R');
									$this->fpdf->Cell(15,5,$qty[$k],1,0,'R'); 
									$this->fpdf->Cell(15,5,'0',1,0,'R');
									$this->fpdf->Cell(15,5,'0',1,0,'R');                         
									$this->fpdf->Cell(15,5,'0',1,0,'R'); 
									$this->fpdf->Cell(34,5,$iprice[$k]*$qty[$k],1,1,'R');            
									$subtotal=$subtotal+($iprice[$k]*$qty[$k]);	
								
									$sellingprice=$iprice[$k]*$qty[$k];
									$grandtotal=($subtotal)-((($OrderDetails[0]->total)*($OrderDetails[0]->discount/100))+$OrderDetails[0]->walletpay);
										
								}
								//Summary
								$this->fpdf->SetFont('Arial','B',12);

								$this->fpdf->Cell(155,5,'SellingPrice Total',1,0,'R');
								//$this->fpdf->Cell(4,5,'$',1,0);
								$this->fpdf->Cell(34,5,$OrderDetails[0]->total,1,1,'R');

								$this->fpdf->Cell(155,5,'GST',1,0,'R');
								//$this->fpdf->Cell(4,5,'$',1,0);
								//$gst=($user->GstTotal)-($user->totalSubtotalSellingPrice);
								$this->fpdf->Cell(34,5,'0',1,1,'R');
					
								$this->fpdf->Cell(155,5,'Shipping',1,0,'R');
								//$this->fpdf->Cell(4,5,'$',1,0);
								$this->fpdf->Cell(34,5,'0',1,1,'R');
					
								
								//$this->fpdf->Cell(130,5,'',1,0);
								$this->fpdf->Cell(155,5,'SubTotal',1,0,'R');
								//$this->fpdf->Cell(4,5,'$',1,0);
								
								$this->fpdf->Cell(34,5,$OrderDetails[0]->total,1,1,'R');

								//$this->fpdf->Cell(130,5,'',1,0);
								$this->fpdf->Cell(155,5,'Discount',1,0,'R');
								//$this->fpdf->Cell(4,5,'$',1,0);
								$this->fpdf->Cell(34,5,$OrderDetails[0]->discount,1,1,'R');

								//$this->fpdf->Cell(130,5,'',1,0);
								$this->fpdf->Cell(155,5,'Wallet Pay',1,0,'R');
								//$this->fpdf->Cell(4,5,'$',1,0);
								$this->fpdf->Cell(34,5,$OrderDetails[0]->walletpay,1,1,'R');

								//$this->fpdf->Cell(130,5,'',1,0);
								
								$this->fpdf->Cell(155,5,'Grand Total',1,0,'R');
								//$this->fpdf->Cell(4,5,'$',1,0);
								$this->fpdf->Cell(34,5,$grandtotal,1,1,'R');
							
								//Dumy empty cell as vertical spacer
								$this->fpdf->Cell(189,10,'',0,1);//end of file
							}
					}
				}
				else{

					if(count($iname)>0)
					{
						$subtotal=0;
						for($k=0;$k<count($iname);$k++)
						{
							$singlevname=explode(":",$vname[$k]);
							if(count($singlevname)>0)
								{
									
										//Billing address
										$this->fpdf->SetFont('Arial','B',12);
										$this->fpdf->Cell(100,5,'Vendor Details',0,1);					
									
										for($r=0;$r<count($singlevname);$r++)
										{
											
												$this->fpdf->SetFont('Arial','',12);
												$this->fpdf->Cell(10,5,'',0,0);
												$this->fpdf->Cell(90,5,$singlevname[$r],0,1);									
												
		
										}
								}
										//Dumy empty cell as vertical spacer
										$this->fpdf->Cell(189,10,'',0,1);//end of file
												
										//Invoice Content
		
										$this->fpdf->SetFont('Arial','B',12);
		
		
										$this->fpdf->Cell(61,5,'Item',1,0,'C');
										$this->fpdf->Cell(34,5,'Price',1,0,'C');
										$this->fpdf->Cell(15,5,'Qty',1,0,'C');
										$this->fpdf->Cell(15,5,'Ship',1,0,'C');
										$this->fpdf->Cell(15,5,'CGST',1,0,'C');
										$this->fpdf->Cell(15,5,'SGST',1,0,'C');
										$this->fpdf->Cell(34,5,'Total',1,1,'C');
		
										// Number of right aligned so we give R After new line parameter            
										$this->fpdf->SetFont('Arial','',12);
										//Invoice Content              
										$this->fpdf->Cell(61,5,$iname[$k],1,0);
										$this->fpdf->Cell(34,5,$iprice[$k],1,0,'R');
										$this->fpdf->Cell(15,5,$qty[$k],1,0,'R'); 
										$this->fpdf->Cell(15,5,'0',1,0,'R');
										$this->fpdf->Cell(15,5,'0',1,0,'R');                         
										$this->fpdf->Cell(15,5,'0',1,0,'R'); 
										$this->fpdf->Cell(34,5,$iprice[$k]*$qty[$k],1,1,'R');            
										$subtotal=$subtotal+($iprice[$k]*$qty[$k]);	
									 //Summary
									 $this->fpdf->SetFont('Arial','B',12);
		 
									 $this->fpdf->Cell(155,5,'SellingPrice Total',1,0,'R');
									 //$this->fpdf->Cell(4,5,'$',1,0);
									 $this->fpdf->Cell(34,5,$iprice[$k]*$qty[$k],1,1,'R');
		 
									 $this->fpdf->Cell(155,5,'GST',1,0,'R');
									 //$this->fpdf->Cell(4,5,'$',1,0);
									 //$gst=($user->GstTotal)-($user->totalSubtotalSellingPrice);
									 $this->fpdf->Cell(34,5,'0',1,1,'R');
						
									 $this->fpdf->Cell(155,5,'Shipping',1,0,'R');
									 //$this->fpdf->Cell(4,5,'$',1,0);
									 $this->fpdf->Cell(34,5,'0',1,1,'R');
						
									 
									 //$this->fpdf->Cell(130,5,'',1,0);
									 $this->fpdf->Cell(155,5,'SubTotal',1,0,'R');
									 //$this->fpdf->Cell(4,5,'$',1,0);
									
									 $this->fpdf->Cell(34,5,$iprice[$k]*$qty[$k],1,1,'R');
		
									//Dumy empty cell as vertical spacer
									$this->fpdf->Cell(189,10,'',0,1);//end of file
									 
									 $grandtotal=($subtotal)-((($OrderDetails[0]->total)*($OrderDetails[0]->discount/100))+$OrderDetails[0]->walletpay);
								
						}
						
						 //$this->fpdf->Cell(130,5,'',1,0);
						 $this->fpdf->Cell(155,5,'FinalSubtotal',1,0,'R');
						 //$this->fpdf->Cell(4,5,'$',1,0);
						 $this->fpdf->Cell(34,5,$OrderDetails[0]->total,1,1,'R');

						 //$this->fpdf->Cell(130,5,'',1,0);
						 $this->fpdf->Cell(155,5,'Discount',1,0,'R');
						 //$this->fpdf->Cell(4,5,'$',1,0);
						 $this->fpdf->Cell(34,5,$OrderDetails[0]->discount,1,1,'R');
		
						  //$this->fpdf->Cell(130,5,'',1,0);
						$this->fpdf->Cell(155,5,'Wallet Pay',1,0,'R');
						//$this->fpdf->Cell(4,5,'$',1,0);
						$this->fpdf->Cell(34,5,$OrderDetails[0]->walletpay,1,1,'R');
		
						 //$this->fpdf->Cell(130,5,'',1,0);
						
						 $this->fpdf->Cell(155,5,'Grand Total',1,0,'R');
						 //$this->fpdf->Cell(4,5,'$',1,0);
						 $this->fpdf->Cell(34,5,$grandtotal,1,1,'R');
					
						//Dumy empty cell as vertical spacer
						  $this->fpdf->Cell(189,10,'',0,1);//end of file
					}
				}
				
				

			
				
			echo $this->fpdf->Output('Invoice.pdf','D');
        }
        else
        {

            $this->Login();

        }

	}
	public function WalletMoney()
    {
        if(isset($this->session->userdata['SAlogged_in'])){
			$data['AllUsers']=$this->SubAdmin_model->GetUsers();
            $data['UserWallet']=$this->SubAdmin_model->GetUserWallet();
			$this->load->view('SubAdmin/Header');
			$this->load->view('SubAdmin/UserWallet',$data);
			$this->load->view('SubAdmin/Footer');
		}else{		
        $this->Login();
		}

	}
	public function AddMoneyToUserWallet()	
	{
		if(isset($this->session->userdata['SAlogged_in']))
		{
			$uid=$this->input->post('txtuserid');
			$user_wallet_id=$this->input->post('user_wallet_id'); 
			
			$said=$this->session->userdata['SAlogged_in']['S_aid'];
			$walletmoney=$this->input->post('txtwalletmoney'); 
		/*	$result=$this->Admin_model->GetUserWalletDetails($uid);
			$sum_wallet=0;*/
			if($user_wallet_id)
			{		
				$data = array(
					'wallet'=> $walletmoney,
					'updated_by_subadmin'=> $said,
					'updated_at'=> date('Y-m-d H:i:s'),
				); 
				
				if ($this->SubAdmin_model->UpdateUserWallet($user_wallet_id,$data)) {
					$this->SubAdmin_model->UpdateUserWalletMoney($uid);
					echo '<script>';
					echo 'setTimeout(function () {swal("Updated!", "User Wallet Money Succesfully Updated!", "success");';
					echo '}, 1000);';
					echo 'setTimeout(function () {window.location.href="'.base_url()."SubAdmin/WalletMoney".'"';
					echo '}, 2000);</script>';
					$this->WalletMoney();
				} else {
					echo '<script>';
					echo 'setTimeout(function () {swal("Opps!", "There is some problem please try again after some time", "error");';
					echo '}, 1000);</script>';
					$this->WalletMoney();
				} 
			}
			else
			{
				$data = array(
					'uid'=> $uid,
					'wallet'=> $walletmoney,
					'created_at'=> date('Y-m-d H:i:s'),
					'updated_by_subadmin'=> $said,
				); 
				if ($this->SubAdmin_model->AddUserWallet($data)) {
					$this->SubAdmin_model->UpdateUserWalletMoney($uid);
					echo '<script>';
					echo 'setTimeout(function () {swal("Added!", "User Wallet Money Succesfully Added!", "success");';
					echo '}, 1000);';
					echo 'setTimeout(function () {window.location.href="'.base_url()."SubAdmin/WalletMoney".'"';
					echo '}, 2000);</script>';
					$this->WalletMoney();
				} else {
					echo '<script>';
					echo 'setTimeout(function () {swal("Opps!", "There is some problem please try again after some time", "error");';
					echo '}, 1000);</script>';
					$this->WalletMoney();
				} 
			}
		}
		else
		{		
			$this->Login();
		}		
		
	}
	public function DeleteUserWallet()
	{
		if(isset($this->session->userdata['SAlogged_in']))
		{
			$UserWalletid = $this->input->post('UserWalletid');
			if($this->SubAdmin_model->DeleteUserWallet($UserWalletid))
			{
				$json_array=array(
					"success"=>'true',
					"chkUserWalletpresent"=>0				 
				);
			}
			else
			{
				$json_array=array(
					"success"=>'false',
					"chkUserWalletpresent"=>0				 
				);
			}		
            echo json_encode($json_array);
		}
		else
		{			
        	$this->Login();
		}
	}
	//Autocomplete City Name
	public function CityNameAutocomplete()
	{
		$term = $this->input->get('term');
		$result = $this->SubAdmin_model->SelectCityName($term);
		echo json_encode($result);
	
	}
	public function CurrentOrders()
	{
		if(isset($this->session->userdata['SAlogged_in'])){	
			$data['DeliveryBoy']=$this->SubAdmin_model->GetDeliveryBoy();				
			$this->load->view('SubAdmin/Header');
			$this->load->view('SubAdmin/CurrentOrders',$data);
			$this->load->view('SubAdmin/Footer');
		}else{
			
        $this->Login();
		}
	}
	public function GetCityWiseOrders()
	{
		if(isset($this->session->userdata['SAlogged_in'])){
			$city = $this->input->post('cityname');			
			$data['OrdersDetails']=$this->SubAdmin_model->GetCityWiseOrders($city);		
			//print_r($data['OrdersDetails']);exit;
			$this->load->view('SubAdmin/FetchCityWiseCurrentOrders',$data);			
		}else{
			
        $this->Login();
		}
	}
	public function GetCityStatusWiseOrders()
	{
		if(isset($this->session->userdata['SAlogged_in'])){
			$city = $this->input->post('cityname');		
			$orderstatus = $this->input->post('orderstatus');		
			$data['OrdersDetails']=$this->SubAdmin_model->GetCityStatusWiseOrders($city,$orderstatus);
			//print_r($data['OrdersDetails']);exit;
			$this->load->view('SubAdmin/FetchCityStatusWiseCurrentOrders',$data);			
		}else{
			
        $this->Login();
		}
	}
	public function RejectedOrders()
	{
		if(isset($this->session->userdata['SAlogged_in'])){
			$data['OrdersDetails']=$this->SubAdmin_model->GetRejectedOrders();
			//print_r($data['OrdersDetails']);exit;
			$this->load->view('SubAdmin/Header');
			$this->load->view('SubAdmin/RejectedOrders',$data);
			$this->load->view('SubAdmin/Footer');
		}else{
			
        $this->Login();
		}
	}
	public function CouponCode()
	{
		if(isset($this->session->userdata['SAlogged_in'])){
			$data['CouponCodeDetails']=$this->SubAdmin_model->GetCouponCode();
			$data['NextCouponId']=$this->SubAdmin_model->GetNextCouponId();
			//print_r($data['NextCouponId']);exit;
			$this->load->view('SubAdmin/Header');
			$this->load->view('SubAdmin/CouponCode',$data);
			$this->load->view('SubAdmin/Footer');
		}else{
			
        $this->Login();
		}
	}
	public function AddCouponCode()	
	{
		$activa_date=$this->input->post('txtactivedate'); 
		$expired_date=$this->input->post('txtexpirydate'); 
		
			$data = array(
				'coupon_code'=> $this->input->post('txtCouponCodename'),
				'activate_date'=> date('Y-m-d H:i:s',strtotime($activa_date)),
				'expired_date'=> date('Y-m-d H:i:s',strtotime($expired_date)),
				'shopping_range'=> $this->input->post('txtshoppingrangeamt'),
				'discount_amt'=> $this->input->post('txtdiscountamt'),
				'discount_amt_type'=> $this->input->post('txtdiscounttype'),
				'terms'=> $this->input->post('txtterm'),
				'created_at'=> date('Y-m-d H:i:s'),
			); 
		if ($this->SubAdmin_model->AddCouponCodeAmount($data)) {
			echo '<script>';
			echo 'setTimeout(function () {swal("Added!", "Coupon Code Succesfully Added!", "success");';
			echo '}, 1000);';
			echo 'setTimeout(function () {window.location.href="'.base_url()."SubAdmin/CouponCode".'"';
			echo '}, 2000);</script>';
			$this->CouponCode();
		} else {
			echo '<script>';
			echo 'setTimeout(function () {swal("Opps!", "There is some problem please try again after some time", "error");';
			echo '}, 1000);</script>';
			$this->CouponCode();
		} 
	}
	public function EditCouponCode()	
	{
		$couponid=$this->input->post('couponid');
		$activa_date=$this->input->post('edittxtactivedate'); 
		$expired_date=$this->input->post('edittxtexpirydate'); 
		// $dbbilldate=date('Y-m-d',strtotime($billdate));
		
			$data = array(
				'coupon_code'=> $this->input->post('edittxtCouponCodename'),
				'activate_date'=> date('Y-m-d H:i:s',strtotime($activa_date)),
				'expired_date'=> date('Y-m-d H:i:s',strtotime($expired_date)),
				'shopping_range'=> $this->input->post('edittxtshoppingrangeamt'),
				'discount_amt'=> $this->input->post('edittxtdiscountamt'),
				'discount_amt_type'=> $this->input->post('edittxtdiscounttype'),
				'terms'=> $this->input->post('edittxtterm'),
				'updated_at'=> date('Y-m-d H:i:s'),
			); 
		if ($this->SubAdmin_model->UpdateCouponCodeAmount($couponid,$data)) {
			echo '<script>';
			echo 'setTimeout(function () {swal("Updated!", "Coupon Code Succesfully Updated!", "success");';
			echo '}, 1000);';
			echo 'setTimeout(function () {window.location.href="'.base_url()."SubAdmin/CouponCode".'"';
			echo '}, 2000);</script>';
			$this->CouponCode();
		} else {
			echo '<script>';
			echo 'setTimeout(function () {swal("Opps!", "There is some problem please try again after some time", "error");';
			echo '}, 1000);</script>';
			$this->CouponCode();
		} 
	}
	public function DeleteCouponCode()
	{
		if(isset($this->session->userdata['SAlogged_in']))
		{
			$couponid=$this->input->post('couponid');
			$chkCouponCodepresent = $this->SubAdmin_model->chkCouponCodepresent($couponid);
			if($chkCouponCodepresent==1)
			{
				$json_array=array(
					"success"=>'true',
					"chkCouponCodepresent"=>1				 
				);				
			}
			else
			{
				if($this->SubAdmin_model->DeleteCouponCode($couponid))
				{
					$json_array=array(
						"success"=>'true',
						"chkCouponCodepresent"=>0				 
					);
				}
				else
				{
					$json_array=array(
						"success"=>'false',
						"chkCouponCodepresent"=>0				 
					);
				}
			}
            echo json_encode($json_array);
		}
		else
		{			
        	$this->Login();
		}
	}
	public function AssignedCoupons()
	{
		if(isset($this->session->userdata['SAlogged_in'])){
			$data['AllUsers']=$this->SubAdmin_model->GetUsers();
			$data['CouponCodeDetails']=$this->SubAdmin_model->GetCouponCode();
			$data['AssignCouponDetails']=$this->SubAdmin_model->GetAssignedCoupons();
			//print_r($data['NextCouponId']);exit;
			$this->load->view('SubAdmin/Header');
			$this->load->view('SubAdmin/AssignedCouponCode',$data);
			$this->load->view('SubAdmin/Footer');
		}else{
			
        $this->Login();
		}
	}
	public function AlreadyUsedCoupen()
    {
		$uid=$this->input->post('useridval');
		$couponid=$this->input->post('couponidval');			
		$result=$this->SubAdmin_model->CheckAlreadyUsedCoupen($uid,$couponid);
		 echo $result;
	}
	
	public function AddAssinedCouponCode()	
	{
		$data = array(
			'uid'=> $this->input->post('txtuserid'),
			'coupon_id'=> $this->input->post('txtcoupencodeid'),
			'created_at'=> date('Y-m-d H:i:s'),
			'assign_by'=> 1,
		); 
		if ($this->SubAdmin_model->AddAssinedCouponCode($data)) {
			echo '<script>';
			echo 'setTimeout(function () {swal("Added!", "Coupon Code Assigned Succesfully!", "success");';
			echo '}, 1000);';
			echo 'setTimeout(function () {window.location.href="'.base_url()."SubAdmin/AssignedCoupons".'"';
			echo '}, 2000);</script>';
			$this->AssignedCoupons();
		} else {
			echo '<script>';
			echo 'setTimeout(function () {swal("Opps!", "There is some problem please try again after some time", "error");';
			echo '}, 1000);</script>';
			$this->AssignedCoupons();
		} 
	}
	public function EditAlreadyUsedCoupen()
    {
		$assignccid=$this->input->post('assignccidval');
		$uid=$this->input->post('useridval');
		$couponid=$this->input->post('couponidval');			
		$result=$this->SubAdmin_model->EditAlreadyUsedCoupen($assignccid,$uid,$couponid);
		 echo $result;
	}
	public function EditAssinedCouponCode()	
	{
		$assignccid=$this->input->post('assignccid');
		$data = array(
			'uid'=> $this->input->post('edittxtuserid'),
			'coupon_id'=> $this->input->post('edittxtcoupencodeid'),
			'created_at'=> date('Y-m-d H:i:s'),
		); 
		if ($this->SubAdmin_model->UpdateAssinedCouponCode($assignccid,$data)) {
			echo '<script>';
			echo 'setTimeout(function () {swal("Updated!", "Coupon Code Updated Succesfully!", "success");';
			echo '}, 1000);';
			echo 'setTimeout(function () {window.location.href="'.base_url()."SubAdmin/AssignedCoupons".'"';
			echo '}, 2000);</script>';
			$this->AssignedCoupons();
		} else {
			echo '<script>';
			echo 'setTimeout(function () {swal("Opps!", "There is some problem please try again after some time", "error");';
			echo '}, 1000);</script>';
			$this->AssignedCoupons();
		} 
	}
	public function DeleteAssignedCoupon()
	{
		if(isset($this->session->userdata['SAlogged_in']))
		{
			$assignccid=$this->input->post('assignid');	
			
			if($this->SubAdmin_model->DeleteAssignedCoupon($assignccid))
			{
				$json_array=array(
					"success"=>'true',
					"chkCouponCodepresent"=>0				 
				);
			}
			else
			{
				$json_array=array(
					"success"=>'false',
					"chkCouponCodepresent"=>0				 
				);
			}
		
            echo json_encode($json_array);
		}
		else
		{			
        	$this->Login();
		}
	}
	public function SlotsOfDelivery()
	{
		if(isset($this->session->userdata['SAlogged_in'])){
			$data['DeliverySlotsDetails']=$this->SubAdmin_model->GetDeliverySlots();		
			$data['VendorDetails']=$this->SubAdmin_model->GetVerifiedVendor();			
			$this->load->view('SubAdmin/Header');
			$this->load->view('SubAdmin/SlotsOfDelivery',$data);
			$this->load->view('SubAdmin/Footer');
		}else{
			
        $this->Login();
		}
	}
	public function AddDeliverySlot()	
	{
		$data = array(
			'vid'=> $this->input->post('txtvendorid'),
			'opentime'=> $this->input->post('txtopentime'),
			'closetime'=> $this->input->post('txtclosetime'),
			'created_at'=> date('Y-m-d H:i:s'),
		); 
		if ($this->SubAdmin_model->AddDeliverySlot($data)) {
			echo '<script>';
			echo 'setTimeout(function () {swal("Added!", "Delivery Slot Succesfully Added!", "success");';
			echo '}, 1000);';
			echo 'setTimeout(function () {window.location.href="'.base_url()."SubAdmin/SlotsOfDelivery".'"';
			echo '}, 2000);</script>';
			$this->SlotsOfDelivery();
		} else {
			echo '<script>';
			echo 'setTimeout(function () {swal("Opps!", "There is some problem please try again after some time", "error");';
			echo '}, 1000);</script>';
			$this->SlotsOfDelivery();
		} 
	}
	public function EditDeliverySlot()	
	{
		$deliveryslot_id=$this->input->post('deliveryslot_id');
		$data = array(
			'vid'=> $this->input->post('edittxtvendorid'),
			'opentime'=> $this->input->post('edittxtopentime'),
			'closetime'=> $this->input->post('edittxtclosetime'),
			'updated_at'=> date('Y-m-d H:i:s'),
		); 
		if ($this->SubAdmin_model->UpdateDeliverySlot($deliveryslot_id,$data)) {
			echo '<script>';
			echo 'setTimeout(function () {swal("Updated!", "Delivery Slot Succesfully Updated!", "success");';
			echo '}, 1000);';
			echo 'setTimeout(function () {window.location.href="'.base_url()."SubAdmin/SlotsOfDelivery".'"';
			echo '}, 2000);</script>';
			$this->SlotsOfDelivery();
		} else {
			echo '<script>';
			echo 'setTimeout(function () {swal("Opps!", "There is some problem please try again after some time", "error");';
			echo '}, 1000);</script>';
			$this->SlotsOfDelivery();
		} 
	}
	public function DeleteDeliverySlot()
	{
		if(isset($this->session->userdata['SAlogged_in']))
		{
			$deliveryslot_id=$this->input->post('deliveryslot_id');
			/*$chkDeliverySlotpresent = $this->SubAdmin_model->chkDeliverySlotpresent($deliveryslot_id);
			if($chkDeliverySlotpresent==1)
			{
				$json_array=array(
					"success"=>'true',
					"chkDeliverySlotpresent"=>1				 
				);				
			}
			else
			{*/
				if($this->SubAdmin_model->DeleteDeliverySlot($deliveryslot_id))
				{
					$json_array=array(
						"success"=>'true',
						"chkDeliverySlotpresent"=>0				 
					);
				}
				else
				{
					$json_array=array(
						"success"=>'false',
						"chkDeliverySlotpresent"=>0				 
					);
				}
			//}
            echo json_encode($json_array);
		}
		else
		{			
        	$this->Login();
		}
	}
	public function ItemDetails($item_id)	
	{
		if(isset($this->session->userdata['SAlogged_in'])){
			$data['ItemDetails']=$this->SubAdmin_model->GetItemDetails($item_id);
			$data['ItemInfo']=$this->SubAdmin_model->GetItem($item_id);
			//print_r($data);exit;
			$this->load->view('SubAdmin/Header');
			$this->load->view('SubAdmin/ItemDetails',$data);
			$this->load->view('SubAdmin/Footer');
		}else{
			
        $this->Login();
		}
	}
	public function SellReport()	
	{
		if(isset($this->session->userdata['SAlogged_in'])){
			$this->load->view('SubAdmin/Header');
			$this->load->view('SubAdmin/SellReport');
			$this->load->view('SubAdmin/Footer');
		}else{
			
        $this->Login();
		}
	}
	public function GetSellReport()
	{
		if(isset($this->session->userdata['SAlogged_in'])){
			$city = $this->input->post('cityname');	
			$startdate = $this->input->post('startdate');			
			$enddate = $this->input->post('enddate');			
			
			$db_startdate = date('Y-m-d 00:00:00',strtotime($startdate));
			$db_enddate = date('Y-m-d 23:59:59',strtotime($enddate));
				
			$data['SellReports']=$this->SubAdmin_model->GetSellReport($city,$db_startdate,$db_enddate);
			$data['SellTotalReports']=$this->SubAdmin_model->GetSellTotalReport($city,$db_startdate,$db_enddate);
			
			$this->load->view('SubAdmin/FetchSellReports',$data);			
		}else{
			$this->Login();
		}
	}
	public function CheckQtyStock()
	{
		if(isset($this->session->userdata['SAlogged_in'])){
			$qtyval = $this->input->post('qtyval');	
			$stockval = $this->input->post('stockval');			
			$qty=explode(',',$qtyval);
			$stock=explode(',',$stockval);
			for($i=0;$i<count($qty);$i++)
			{
				if ($qty[$i] > $stock[$i]){
					
					$result='false';
					print_r($result);exit;
				}
				else{
					$result='true';
					print_r($result);exit;
				}				
			}
			//echo $result;
			
		}else{
			$this->Login();
		}
	}
	public function UpdateQtyBySubAdmin()
	{
		if(isset($this->session->userdata['SAlogged_in'])){
			$orderid = $this->input->post('orderid');
			$updateattempt = $this->input->post('updateattempt');	
			$vitemid = $this->input->post('vitemid');			
			$qtyid = $this->input->post('txtitemqty');
			$stockval = $this->input->post('stock');
			$ipriceval = $this->input->post('iprice');			
			$viid=explode(',',$vitemid);
			$qty=explode(',',$qtyid);
			$stock=explode(',',$stockval);
			$iprice=explode(',',$ipriceval);
			$total=0;
			$updateattempt=$updateattempt+1;
			for($i=0;$i<count($qty);$i++)
			{
				$total=$total+($iprice[$i]*$qty[$i]);
				$result=$this->SubAdmin_model->UpdateVendorItemStock($viid[$i],$qty[$i],$stock[$i]);			
			}
			$result1=$this->SubAdmin_model->UpdateOrderQty($orderid,$qtyid,$total,$updateattempt);		
			if ($result1) {
				echo '<script>';
				echo 'setTimeout(function () {swal("Updated!", "Quantity Succesfully Updated!", "success");';
				echo '}, 1000);';
				echo 'setTimeout(function () {window.location.href="'.base_url()."SubAdmin/CurrentOrders".'"';
				echo '}, 2000);</script>';
				$this->CurrentOrders();
			} else {
				echo '<script>';
				echo 'setTimeout(function () {swal("Opps!", "There is some problem please try again after some time", "error");';
				echo '}, 1000);</script>';
				$this->CurrentOrders();
			} 
		}else{
			$this->Login();
		}
	}
	public function CancelOrderBySubAdmin()
	{
		if(isset($this->session->userdata['SAlogged_in']))
		{
			$oid = $this->input->post('oid');
			$data = array(
				'status'=> 6,
			); 
			if($this->SubAdmin_model->UpdateOrderBySubAdmin($oid,$data))
			{
				$json_array=array(
					"success"=>'true'				 
				);
			}
			else
			{
				$json_array=array(
					"success"=>'false'				 
				);
			}		
            echo json_encode($json_array);
		}
		else
		{			
        	$this->Login();
		}
	}
	public function CheckDelBoyAvailability()
	{
		if(isset($this->session->userdata['SAlogged_in']))
		{
			$delid = $this->input->post('delval');	
			$result = $this->SubAdmin_model->CheckDelBoyAvailability($delid);								
			echo $result;exit;
			
		}else{
			$this->Login();
		}
	}
	public function AssignDeliveryBoyBySubAdmin()
	{
		if(isset($this->session->userdata['SAlogged_in'])){
			$orderid = $this->input->post('orderid');	
			$delid = $this->input->post('txtdelid');	
			$data = array(
				'assigndeliveryboy'=> $delid,
			);		
			$result1=$this->SubAdmin_model->UpdateOrderBySubAdmin($orderid,$data);		
			if ($result1) {
				echo '<script>';
				echo 'setTimeout(function () {swal("Assigned Delivery Boy!", "Delivery Boy Succesfully Assigned!", "success");';
				echo '}, 1000);';
				echo 'setTimeout(function () {window.location.href="'.base_url()."SubAdmin/CurrentOrders".'"';
				echo '}, 2000);</script>';
				$this->CurrentOrders();
			} else {
				echo '<script>';
				echo 'setTimeout(function () {swal("Opps!", "There is some problem please try again after some time", "error");';
				echo '}, 1000);</script>';
				$this->CurrentOrders();
			} 
		}else{
			$this->Login();
		}
	}
	public function DeliveryMoneyReporting()
	{
		if(isset($this->session->userdata['SAlogged_in'])){
			$data['DeliveryMoneyDetails']=$this->SubAdmin_model->GetDeliveryMoneyDetails();
			//print_r($data['DeliveryMoneyDetails']);exit;
			$this->load->view('SubAdmin/Header');
			$this->load->view('SubAdmin/DeliveryMoneyReport',$data);
			$this->load->view('SubAdmin/Footer');
		}else{
			
        $this->Login();
		}
	}
}
