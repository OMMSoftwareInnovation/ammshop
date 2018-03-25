<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
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

// Load database
$this->load->model('data_model');

$this->load->model('Admin_model');
$this->site_notification=$this->Admin_model->Getnoticount();
$this->load->vars($this->site_notification);


}	

 /**
     * @desc: This method is used to load view
     */
    public function piechart()
    {
 
		$this->load->view('Admin/Header');
		$this->load->view('piechart');
		$this->load->view('Admin/Footer');
        
	}
	public function linechart()
    {
 
		$this->load->view('Admin/Header');
		$this->load->view('linechart');
		$this->load->view('Admin/Footer');
        
    }
    /**
     * @desc: This method is used to get data to call model and print it into Json
     * This method called by Ajax
     */
    function getdata(){
        $data  = $this->data_model->getdata();
        print_r(json_encode($data, true));
	}
	

	public function GenerateRandomOtp()
    {
		$string = 'abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$string_shuffled = str_shuffle($string);
		$password = substr($string_shuffled, 1, 6); 
		return $password;
    }
	public function demologin()
	{
		$this->load->view('Admin/loginheader');
        $this->load->view('Admin/demologin');
        $this->load->view('Admin/loginfooter');
	}
	public function index()
	{
		if(isset($this->session->userdata['Alogged_in'])){
			$data['getdashboard']=$this->Admin_model->getdashboard();
			//print_r($data['getdashboard']);exit;
			$this->load->view('Admin/Header');
			$this->load->view('Admin/index',$data);
			$this->load->view('Admin/Footer');
		}else{
			
		$this->Login();
		}
	}
	//Login
	public function Login()
    {
        $this->load->view('Admin/loginheader');
        $this->load->view('Admin/login');
        $this->load->view('Admin/loginfooter');
	}
	 // Check for user login process
	public function Admin_login_process()
	{

		$this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');

		if ($this->form_validation->run() == FALSE) {
		if(isset($this->session->userdata['Alogged_in'])){
			$this->index();

		}else{
		$this->load->view('Admin/loginheader');
		$this->load->view('Admin/login');
		$this->load->view('Admin/loginfooter');
		}
		} else {
			$data = array(
			'email' => $this->input->post('email'),
			'password' => $this->input->post('password')
			);
			$result = $this->Admin_model->login($data);
			if ($result == TRUE) {

			$email = $this->input->post('email');
			$result = $this->Admin_model->read_Admin_information($email);
			if ($result != false) {
			$session_data = array(
			'aid' => $result[0]->a_id,
			'Email' => $result[0]->email,
			'Mobileno' => $result[0]->mobile_no,
			'Name' => $result[0]->name,
			);
			//print_r($session_data);exit;
			// Add user data in session
			$this->session->set_userdata('Alogged_in' ,$session_data);
			$this->index();
		}
		} else {
			$data = array(
			'error_message' => 'Invalid Username or Password'
			);
			$this->load->view('Admin/loginheader');
			$this->load->view('Admin/login',$data);
			$this->load->view('Admin/loginfooter');
			}
		}
	}
	//Forgot Password
	public function Forgot()
    {
        $this->load->view('Admin/loginheader');
        $this->load->view('Admin/Forgot');
        $this->load->view('Admin/loginfooter');
    }
	public function ForgotPassword()
    {
        $email = $this->input->post("email");
		if ($this->Admin_model->Checkemail($email))
		{
        	$password = $this->Admin_model->getpassword($email);
            if($this->sendmail($email,$password))
            {
                echo '<script>';
                echo 'setTimeout(function () {swal("Registered!", "Please Check Your Registered mail For Password", "success");';
                echo '}, 1000);';
                echo 'setTimeout(function () {window.location.href="'.base_url()."Admin/Login".'"';
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
	// Logout from admin page
	public function logout() 
	{

		// Removing session data
		$sess_array = array(
		'username' => ''
		);
		$this->session->unset_userdata('Alogged_in', $sess_array);
		$data['message_display'] = 'Successfully Logout';
			$this->load->view('Admin/loginheader');
			$this->load->view('Admin/login',$data);
			$this->load->view('Admin/loginfooter');
	}
	//ChangePassword
	public function ChangePassword()
	{
		if(isset($this->session->userdata['Alogged_in'])){
			$this->load->view('Admin/Header');
			$this->load->view('Admin/ChangePassword');
			$this->load->view('Admin/Footer');
		}else{
			
        $this->Login();
		}
	}
	public function Checkpassword()
    {
        $aid=$this->session->userdata['Alogged_in']['aid'];
		$pwd=$this->input->post('oldpass');	
		$result=$this->Admin_model->CheckPassword($aid,$pwd);
		 echo $result;
    }
	public function Updatepassword()
    {
        $aid=$this->session->userdata['Alogged_in']['aid'];
        $Password = array(
            'password'=> $this->input->post('password'),
            );
            if ($this->Admin_model->UpdatePassword($Password,$aid)) {
                echo '<script>';
                echo 'setTimeout(function () {swal("Updated!", "Your Password Succesfully Updated.", "success");';
                echo '}, 1000);';
                echo 'setTimeout(function () {window.location.href="'.base_url()."Admin/ChangePassword".'"';
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
		if(isset($this->session->userdata['Alogged_in'])){
			$data['CityDetails']=$this->Admin_model->GetCities();
			$this->load->view('Admin/Header');
			$this->load->view('Admin/City',$data);
			$this->load->view('Admin/Footer');
		}else{
			
        $this->Login();
		}
	}
	public function CheckCityNameExist()
    {
        $city=$this->input->post('txtcityname');	
		$result=$this->Admin_model->CheckCity($city);
		 echo $result;
	}
	public function AddCity()
    {
		if(isset($this->session->userdata['Alogged_in']))
		{
			$data = array(
				'city_name'=> $this->input->post('txtcityname'),
			);
			if ($this->Admin_model->AddCity($data)) {
                echo '<script>';
                echo 'setTimeout(function () {swal("Added!", "Your City Succesfully Added.", "success");';
                echo '}, 1000);';
                echo 'setTimeout(function () {window.location.href="'.base_url()."Admin/City".'"';
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
		$result=$this->Admin_model->EditCheckCity($cityid,$city);
		 echo $result;
	}
	public function EditCity()
    {
		if(isset($this->session->userdata['Alogged_in']))
		{
			$cityid=$this->input->post('txtcityid');
			$data = array(
				'city_name'=> $this->input->post('edittxtcityname'),
			);
			if ($this->Admin_model->UpdateCity($cityid,$data)) {
				echo '<script>';
				echo 'setTimeout(function () {swal("Updated!", "Your City Succesfully Updated.", "success");';
				echo '}, 1000);';
				echo 'setTimeout(function () {window.location.href="'.base_url()."Admin/City".'"';
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
		if(isset($this->session->userdata['Alogged_in']))
		{
			$cityid = $this->input->post('cityid');
			$chkcitypresent = $this->Admin_model->chkcitypresent($cityid);
			if($chkcitypresent==1)
			{
				$json_array=array(
					"success"=>'true',
					"chkcitypresent"=>1				 
				);				
			}
			else
			{
				if($this->Admin_model->DeleteCity($cityid))
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
		if(isset($this->session->userdata['Alogged_in'])){
			$data['AreaDetails']=$this->Admin_model->GetAreas();
			$data['CityDetails']=$this->Admin_model->GetCities();
			$this->load->view('Admin/Header');
			$this->load->view('Admin/Area',$data);
			$this->load->view('Admin/Footer');
		}else{
			
        $this->Login();
		}
	}	
	public function CheckAreaNameExist()
    {
		$cityid=$this->input->post('cityidval');			
		$area=$this->input->post('areanameval');	
		$result=$this->Admin_model->CheckArea($cityid,$area);
		 echo $result;
	}
	public function AddArea()
    {
		if(isset($this->session->userdata['Alogged_in']))
		{
			$area = array(
				'city_id'=> $this->input->post('txtcityid'),
				'area_name'=> $this->input->post('txtareaname'),
			);
			if ($this->Admin_model->AddArea($area)) {
                echo '<script>';
                echo 'setTimeout(function () {swal("Added!", "Your Area Succesfully Added.", "success");';
                echo '}, 1000);';
                echo 'setTimeout(function () {window.location.href="'.base_url()."Admin/Area".'"';
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
		$areaid=$this->input->post('areaidval');
		$cityid=$this->input->post('cityidval');			
		$area=$this->input->post('areanameval');	
		$result=$this->Admin_model->EditCheckArea($areaid,$cityid,$area);
		 echo $result;
	}
	public function EditArea()
    {
		if(isset($this->session->userdata['Alogged_in']))
		{
			$areaid=$this->input->post('areaid');
			$area = array(
				'city_id'=> $this->input->post('edittxtcityid'),
				'area_name'=> $this->input->post('edittxtareaname'),
			);
			if ($this->Admin_model->UpdateArea($areaid,$area)) {
                echo '<script>';
                echo 'setTimeout(function () {swal("Edited!", "Your Area Succesfully Updated.", "success");';
                echo '}, 1000);';
                echo 'setTimeout(function () {window.location.href="'.base_url()."Admin/Area".'"';
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
		if(isset($this->session->userdata['Alogged_in']))
		{
			$areaid = $this->input->post('areaid');
			$chkareapresent = $this->Admin_model->chkareapresent($areaid);
			if($chkareapresent==1)
			{
				$json_array=array(
					"success"=>'true',
					"chkareapresent"=>1				 
				);				
			}
			else
			{
				if($this->Admin_model->DeleteArea($areaid))
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
		if(isset($this->session->userdata['Alogged_in'])){
			$data['CategoryDetails']=$this->Admin_model->GetCategory();
			$this->load->view('Admin/Header');
			$this->load->view('Admin/Category',$data);
			$this->load->view('Admin/Footer');
		}else{
			
        $this->Login();
		}
	}
	public function CheckCategoryNameExist()
    {
        $catname=$this->input->post('catnameval');	
		$result=$this->Admin_model->CheckCategory($catname);
		 echo $result;
	}
	public function AddCategory()	
	{

		if (!is_dir('./assets/Admin/Category/')) {
			mkdir('./assets/Admin/Category/', 0777, TRUE);
		}
		$config['upload_path'] = './assets/Admin/Category/';
		$config['allowed_types'] = 'jpg|png';
		$config['max_size'] = 100000;
		$new_name = time().$_FILES["txtcatimage"]['name'];	

		$config['file_name'] = $new_name;
		$this->load->library('upload', $config);	

		if(!$this->upload->do_upload('txtcatimage')) {			

				$error = array('error' => $this->upload->display_errors());
				echo '<script>';
				echo 'setTimeout(function () {swal("Please Select Jpeg or Png Document!", "'.$error['error'].'Max Height : 50px and Max Width : 50px", "error","10000");window.location.href="'.base_url()."Admin/Category".'"';
				echo '}, 1000);</script>';
				$this->Category();
			}
			else 
			{
				$data = array($this->upload->data());
				$Category = array(
					'category_image' => '/assets/Admin/Category/'.$data[0]['file_name'],
					'category_name'=> $this->input->post('txtcatname'),
				);

				if ($this->Admin_model->AddCategory($Category)) {
					echo '<script>';
					echo 'setTimeout(function () {swal("Done!", "Category Added Succesfully.", "success");';
					echo '}, 1000);';
					echo 'setTimeout(function () {window.location.href="'.base_url()."Admin/Category".'"';
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
		$result=$this->Admin_model->EditCheckCategory($catid,$catname);
		 echo $result;
	}
	public function EditCategory()	
	{

		if (!is_dir('./assets/Admin/Category/')) {
			mkdir('./assets/Admin/Category/', 0777, TRUE);
		}
		$config['upload_path'] = './assets/Admin/Category/';
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
				'category_image' => '/assets/Admin/Category/'.$data[0]['file_name'],
			);
			$this->Admin_model->UpdateCategory($catid,$Categoryimage);
		}
		$Category = array(
			'category_name'=> $this->input->post('edittxtcatname'),
		);	
		if ($this->Admin_model->UpdateCategory($catid,$Category)) {
			echo '<script>';
			echo 'setTimeout(function () {swal("Done!", "Category Updated Succesfully.", "success");';
			echo '}, 1000);';
			echo 'setTimeout(function () {window.location.href="'.base_url()."Admin/Category".'"';
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
		if(isset($this->session->userdata['Alogged_in']))
		{
			$catid = $this->input->post('catid');
			$chkcatpresent = $this->Admin_model->chkcategorypresent($catid);
			if($chkcatpresent==1)
			{
				$json_array=array(
					"success"=>'true',
					"chkcatpresent"=>1				 
				);				
			}
			else
			{
				if($this->Admin_model->DeleteCategory($catid))
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
		if(isset($this->session->userdata['Alogged_in'])){
			$data['CategoryDetails']=$this->Admin_model->GetCategory();
			$data['SubCategoryDetails']=$this->Admin_model->GetSubCategory();
			$this->load->view('Admin/Header');
			$this->load->view('Admin/SubCategory',$data);
			$this->load->view('Admin/Footer');
		}else{
			
        $this->Login();
		}
	}	
	public function CheckSubCategoryNameExist()
    {
		$catid=$this->input->post('catidval');
		$subcat=$this->input->post('subcatnameval');			
		$result=$this->Admin_model->CheckSubCategory($catid,$subcat);
		 echo $result;
	}
	public function AddSubCategory()	
	{

		if (!is_dir('./assets/Admin/SubCategory/')) {
			mkdir('./assets/Admin/SubCategory/', 0777, TRUE);
		}
		$config['upload_path'] = './assets/Admin/SubCategory /';
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
					'sub_cat_image' => '/assets/Admin/SubCategory/'.$data[0]['file_name'],
					'sub_cat_name'=> $this->input->post('txtsubcatname'),
					'cat_id'=> $this->input->post('txtcatid'),
				);

				if ($this->Admin_model->AddSubCategory($SubCategory)) {
					echo '<script>';
					echo 'setTimeout(function () {swal("Done!", "Sub Category Added Succesfully.", "success");';
					echo '}, 1000);';
					echo 'setTimeout(function () {window.location.href="'.base_url()."Admin/SubCategory".'"';
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
		$result=$this->Admin_model->EditCheckSubCat($subcatid,$catid,$subcat);
		 echo $result;
	}
	public function EditSubCategory()	
	{

		if (!is_dir('./assets/Admin/SubCategory/')) {
			mkdir('./assets/Admin/SubCategory/', 0777, TRUE);
		}
		$config['upload_path'] = './assets/Admin/SubCategory /';
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
				'sub_cat_image' => '/assets/Admin/SubCategory/'.$data[0]['file_name'],
			);
			$this->Admin_model->UpdateSubCategory($subcatid,$SubCategoryimage);
		}
		$SubCategory = array(
			'sub_cat_name'=> $this->input->post('edittxtsubcatname'),
			'cat_id'=> $this->input->post('edittxtcatid'),
		);	
		if ($this->Admin_model->UpdateSubCategory($subcatid,$SubCategory)) {
			echo '<script>';
			echo 'setTimeout(function () {swal("Updated!", "Sub Category Updated Succesfully.", "success");';
			echo '}, 1000);';
			echo 'setTimeout(function () {window.location.href="'.base_url()."Admin/SubCategory".'"';
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
		if(isset($this->session->userdata['Alogged_in']))
		{
			$subcatid = $this->input->post('subcatid');
			$chksubcatpresent = $this->Admin_model->chksubcategorypresent($subcatid);
			if($chksubcatpresent==1)
			{
				$json_array=array(
					"success"=>'true',
					"chksubcatpresent"=>1				 
				);				
			}
			else
			{
				if($this->Admin_model->DeleteSubCategory($subcatid))
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
		if(isset($this->session->userdata['Alogged_in'])){
			$data['CategoryDetails']=$this->Admin_model->GetCategory();
			$data['SubSubCategoryDetails']=$this->Admin_model->GetSubSubCategory();
			
			$this->load->view('Admin/Header');
			$this->load->view('Admin/SubSubCategory',$data);
			$this->load->view('Admin/Footer');
		}else{
			
        $this->Login();
		}
	}
	public function GetSubCategory()
	{
		if(isset($this->session->userdata['Alogged_in'])){
			$catid = $this->input->post('catid');
			$data['SubCategoryDetails']=$this->Admin_model->GetSubCategoryFromMainCategory($catid);
			$this->load->view('Admin/fetchSubCategory',$data);		
		}
		else{	
        	$this->Login();
		}
	}
	public function CheckSubSubCategoryNameExist()
    {
		$subcatid=$this->input->post('subcatidval');
		$subsubcat=$this->input->post('subsubcatnameval');			
		$result=$this->Admin_model->CheckSubSubCategory($subcatid,$subsubcat);
		 echo $result;
	}
	public function AddSubSubCategory()	
	{		
		if(isset($this->session->userdata['Alogged_in']))
		{
			$SubSubCategory = array(
				'filt_name'=> $this->input->post('txtsubsubcatname'),
				'sub_cat_id'=> $this->input->post('txtsubcatid'),
				'vid'=> 0,
			);

			if ($this->Admin_model->AddSubSubCategory($SubSubCategory)) {
				echo '<script>';
				echo 'setTimeout(function () {swal("Added!", "Sub Sub Category Added Succesfully.", "success");';
				echo '}, 1000);';
				echo 'setTimeout(function () {window.location.href="'.base_url()."Admin/SubSubCategory".'"';
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
		$result=$this->Admin_model->EditCheckSubSubCat($subsubcatid,$subcatid,$subsubcat);
		 echo $result;
	}
	public function EditSubSubCategory()	
	{		
		if(isset($this->session->userdata['Alogged_in']))
		{
			$subsubcatid=$this->input->post('subsubcatid');
			$SubSubCategory = array(
				'filt_name'=> $this->input->post('edittxtsubsubcatname'),
				'sub_cat_id'=> $this->input->post('txtsubcatid'),
				'vid'=> 0,
			);

			if ($this->Admin_model->UpdateSubSubCategory($subsubcatid,$SubSubCategory)) {
				echo '<script>';
				echo 'setTimeout(function () {swal("Updated!", "Sub Sub Category Updated Succesfully.", "success");';
				echo '}, 1000);';
				echo 'setTimeout(function () {window.location.href="'.base_url()."Admin/SubSubCategory".'"';
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
		if(isset($this->session->userdata['Alogged_in']))
		{
			$subsubcatid = $this->input->post('subsubcatid');
			$chksubsubcatpresent = $this->Admin_model->chksubsubcategorypresent($subsubcatid);
			if($chksubsubcatpresent==1)
			{
				$json_array=array(
					"success"=>'true',
					"chksubsubcatpresent"=>1				 
				);				
			}
			else
			{
				if($this->Admin_model->DeleteSubSubCategory($subsubcatid))
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
		if(isset($this->session->userdata['Alogged_in'])){
			$data['QuantityTypeDetails']=$this->Admin_model->GetQuantityType();
			$data['SubCategoryDetails']=$this->Admin_model->GetSubCategory();
			$this->load->view('Admin/Header');
			$this->load->view('Admin/QuantityType',$data);
			$this->load->view('Admin/Footer');
		}else{
			
        $this->Login();
		}
	}
	public function AddQuantityType()
    {
		if(isset($this->session->userdata['Alogged_in']))
		{
			$qtytype = array(
				'sub_cat_id'=> $this->input->post('txtsubcatid'),
				'qty_type_name'=> $this->input->post('txtqtytype'),
			);
			if ($this->Admin_model->AddQuantityType($qtytype)) {
                echo '<script>';
                echo 'setTimeout(function () {swal("Added!", "Your Quantity Type Succesfully Added.", "success");';
                echo '}, 1000);';
                echo 'setTimeout(function () {window.location.href="'.base_url()."Admin/QuantityType".'"';
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
		if(isset($this->session->userdata['Alogged_in']))
		{
			$qtytypeid = $this->input->post('qtytypeid');
			$qtytype = array(
				'sub_cat_id'=> $this->input->post('edittxtsubcatid'),
				'qty_type_name'=> $this->input->post('edittxtqtytype'),
			);
			if ($this->Admin_model->UpdateQuantityType($qtytypeid,$qtytype)) {
                echo '<script>';
                echo 'setTimeout(function () {swal("Updated!", "Your Quantity Type Succesfully Updated.", "success");';
                echo '}, 1000);';
                echo 'setTimeout(function () {window.location.href="'.base_url()."Admin/QuantityType".'"';
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
		if(isset($this->session->userdata['Alogged_in']))
		{
			$qtytypeid = $this->input->post('qtytypeid');
			$chkqtytypepresent = $this->Admin_model->chkqtytypepresent($qtytypeid);
			if($chkqtytypepresent==1)
			{
				$json_array=array(
					"success"=>'true',
					"chkqtytypepresent"=>1				 
				);				
			}
			else
			{
				if($this->Admin_model->DeleteQuantityType($qtytypeid))
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
		if(isset($this->session->userdata['Alogged_in'])){
			$data['QuantityDetails']=$this->Admin_model->GetQuantity();
			$data['SubCategoryDetails']=$this->Admin_model->GetSubCategoryFromQtyType();
			$this->load->view('Admin/Header');
			$this->load->view('Admin/Quantity',$data);
			$this->load->view('Admin/Footer');
		}else{
			
        $this->Login();
		}
	}
	public function GetQtyType()
	{
		if(isset($this->session->userdata['Alogged_in'])){
			$subcatid=$this->input->post('subcatid');
			$data['QuantityTypeDetails']=$this->Admin_model->GetQtyType($subcatid);
			//print_r($data['QuantityTypeDetails']);exit;
			$this->load->view('Admin/fetchQuantitytype',$data);
		}else{
			
        $this->Login();
		}
	}
	public function AddQuantity()
    {
		if(isset($this->session->userdata['Alogged_in']))
		{
			$qty = array(
				'qty_type_id'=> $this->input->post('qtytype'),
				'qty_name'=> $this->input->post('txtqtyname'),
			);
			if ($this->Admin_model->AddQuantity($qty)) {
                echo '<script>';
                echo 'setTimeout(function () {swal("Added!", "Your Quantity Succesfully Added.", "success");';
                echo '}, 1000);';
                echo 'setTimeout(function () {window.location.href="'.base_url()."Admin/Quantity".'"';
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
		if(isset($this->session->userdata['Alogged_in']))
		{
			$qtyid = $this->input->post('qtyid');
			$qty = array(
				'qty_type_id'=> $this->input->post('qtytype'),
				'qty_name'=> $this->input->post('edittxtqtyname'),
			);
			if ($this->Admin_model->UpdateQuantity($qtyid,$qty)) {
                echo '<script>';
                echo 'setTimeout(function () {swal("Updated!", "Your Quantity Succesfully Updated.", "success");';
                echo '}, 1000);';
                echo 'setTimeout(function () {window.location.href="'.base_url()."Admin/Quantity".'"';
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
		if(isset($this->session->userdata['Alogged_in']))
		{
			$qtyid = $this->input->post('qtyid');			
			if($this->Admin_model->DeleteQuantity($qtyid))
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
		if(isset($this->session->userdata['Alogged_in'])){
			$data['ItemsRequest']=$this->Admin_model->GetItemsRequest();
			$this->load->view('Admin/Header');
			$this->load->view('Admin/ItemsRequest',$data);
			$this->load->view('Admin/Footer');
		}else{
			
        $this->Login();
		}
	}
	//Items
	public function Items()
	{
		if(isset($this->session->userdata['Alogged_in'])){
			$data['ItemsRequest']=$this->Admin_model->GetItems();
			$this->load->view('Admin/Header');
			$this->load->view('Admin/items',$data);
			$this->load->view('Admin/Footer');
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
		if(isset($this->session->userdata['Alogged_in'])){
			$this->Admin_model->BlockUnblockItem($itemid,$blockunblockvalue);
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
		if(isset($this->session->userdata['Alogged_in']))
		{
			$itemstatus = $this->input->post('itemstatus');
			$itemid = $this->input->post('itemid');	
			if($itemstatus == 'Accepted')	 
			{
				$itemstatusvalue = array(
					'verified' => 1
				);				
				$this->Admin_model->BlockUnblockItem($itemid,$itemstatusvalue);					
			} 
			else{
				$this->Admin_model->DeleteItem($itemid);
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
		if(isset($this->session->userdata['Alogged_in'])){
			$data['VendorRequest']=$this->Admin_model->GetVendorRequest();
			$this->load->view('Admin/Header');
			$this->load->view('Admin/VendorRequest',$data);
			$this->load->view('Admin/Footer');
		}else{
			
        $this->Login();
		}
	}	
	//Vendor Accept Reject Status
	public function VendorAcceptRejectStatus()
	{
		if(isset($this->session->userdata['Alogged_in']))
		{
			$vendorstatus = $this->input->post('vendorstatus');
			$vendorid = $this->input->post('vendorid');	
			if($vendorstatus == 'Accepted')	 
			{
				$vendorstatusvalue = array(
					'verified' => 1
				);				
				$this->Admin_model->BlockUnblockVendor($vendorid,$vendorstatusvalue);					
			} 
			else{
				$this->Admin_model->DeleteVendor($vendorid);
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
		if(isset($this->session->userdata['Alogged_in'])){
			$data['DeliveryBoyRequest']=$this->Admin_model->GetDeliveryBoyRequest();
			$this->load->view('Admin/Header');
			$this->load->view('Admin/DeliveryBoyRequest',$data);
			$this->load->view('Admin/Footer');
		}else{
			
        $this->Login();
		}
	}	
	//DeliveryBoy Accept Reject Status
	public function DeliveryBoyAcceptRejectStatus()
	{
		if(isset($this->session->userdata['Alogged_in']))
		{
			$deliveryboystatus = $this->input->post('deliveryboystatus');
			$deliveryboyid = $this->input->post('deliveryboyid');	
			if($deliveryboystatus == 'Accepted')	 
			{
				$deliveryboystatusvalue = array(
					'verified' => 1
				);				
				$this->Admin_model->BlockUnblockDeliveryBoy($deliveryboyid,$deliveryboystatusvalue);					
			} 
			else{
				$this->Admin_model->DeleteDeliveryBoy($deliveryboyid);
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
		if(isset($this->session->userdata['Alogged_in'])){
			$data['VendorDetails']=$this->Admin_model->GetVendor();
			$data['CityDetails']=$this->Admin_model->GetCities();
			$data['CategoryDetails']=$this->Admin_model->GetCategory();
			$this->load->view('Admin/Header');
			$this->load->view('Admin/Vendor',$data);
			$this->load->view('Admin/Footer');
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
		if(isset($this->session->userdata['Alogged_in'])){
			$this->Admin_model->BlockUnblockVendor($vendorid,$blockunblockvalue);
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
		if(isset($this->session->userdata['Alogged_in'])){
			$cityid = $this->input->post('cityid');
			$data['AreaDetails']=$this->Admin_model->GetAreaFromCity($cityid);
			$this->load->view('Admin/fetchArea',$data);		
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
		$result=$this->Admin_model->CheckCategoryExistForCity($cityid,$catid);
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
		if(isset($this->session->userdata['Alogged_in']))
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
				'verified'=> 1,
				'block'=> 0,
				'anoti'=> 1,
			);				
			if ($this->Admin_model->AddVendor($vendor)) {

				$password=$this->GenerateRandomOtp();
				$mobile=$this->input->post('txtmobileno');
				$textmessage = $password." is a Password for Your Account.Thanks For Be a Part of AMM SHOP";				
				$this->SendPasswordlogin($mobile,$textmessage);
                echo '<script>';
                echo 'setTimeout(function () {swal("Added!", "Your Vendor Succesfully Added.", "success");';
                echo '}, 1000);';
                echo 'setTimeout(function () {window.location.href="'.base_url()."Admin/Vendor".'"';
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
		$result=$this->Admin_model->EditCheckCategoryExistForCity($vid,$cityid,$catid);
		 echo $result;
	}
	public function EditVendor()
    {
		if(isset($this->session->userdata['Alogged_in']))
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
			);				
			if ($this->Admin_model->UpdateVendor($vid,$vendor)) {

				$password=$this->GenerateRandomOtp();
				$mobile=$this->input->post('edittxtmobileno');
				$textmessage = $password." is a Password for Your Account.Thanks For Be a Part of AMM SHOP";				
				$this->SendPasswordlogin($mobile,$textmessage);
                echo '<script>';
                echo 'setTimeout(function () {swal("Updated!", "Your Vendor Succesfully Updated.", "success");';
                echo '}, 1000);';
                echo 'setTimeout(function () {window.location.href="'.base_url()."Admin/Vendor".'"';
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
		if(isset($this->session->userdata['Alogged_in']))
		{
			$vid = $this->input->post('vid');
			$chkvendorpresent = $this->Admin_model->chkvendorpresent($vid);
			if($chkvendorpresent==1)
			{
				$json_array=array(
					"success"=>'true',
					"chkvendorpresent"=>1				 
				);				
			}
			else
			{
				if($this->Admin_model->DeleteVendor($vid))
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
		if(isset($this->session->userdata['Alogged_in'])){
			$data['DeliveryBoyDetails']=$this->Admin_model->GetDeliveryBoy();
			$this->load->view('Admin/Header');
			$this->load->view('Admin/DeliveryBoy',$data);
			$this->load->view('Admin/Footer');
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
		if(isset($this->session->userdata['Alogged_in'])){
			$this->Admin_model->BlockUnblockDeliveryBoy($deliveryboyid,$blockunblockvalue);
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
		$result=$this->Admin_model->CheckMobileNoExistForDeliveryBoy($mobileno);
		 echo $result;
	}
	public function AddDeliveryBoy()
    {
		if(isset($this->session->userdata['Alogged_in']))
		{
			$password=$this->GenerateRandomOtp();
			$mobile=$this->input->post('txtmobileno');
			$deliveryboy = array(
				'name'=> $this->input->post('txtdeliveryboyname'),
				'mobile_no'=> $this->input->post('txtmobileno'),
				'email'=> $this->input->post('txtemail'),
				'password'=> $password,
				'verified'=> 1,
				'block'=> 0,
			);				
			if ($this->Admin_model->AddDeliveryBoy($deliveryboy)) {

				$textmessage = $password." is a Password for Your Account.Thanks For Be a Part of AMM SHOP";				
				$this->SendPasswordlogin($mobile,$textmessage);
                echo '<script>';
                echo 'setTimeout(function () {swal("Added!", "Your Delivery Boy Succesfully Added.", "success");';
                echo '}, 1000);';
                echo 'setTimeout(function () {window.location.href="'.base_url()."Admin/DeliveryBoy".'"';
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
		$result=$this->Admin_model->EditCheckCheckMobile($did,$mobileno);
		 echo $result;
	}
	public function EditDeliveryBoy()
    {
		if(isset($this->session->userdata['Alogged_in']))
		{
			$did=$this->input->post('did');
			$password=$this->GenerateRandomOtp();
			$mobile=$this->input->post('txtmobileno');
			$deliveryboy = array(
				'name'=> $this->input->post('edittxtdeliveryboyname'),
				'mobile_no'=> $this->input->post('edittxtmobileno'),
				'email'=> $this->input->post('edittxtemail'),
				'password'=> $password,
				'verified'=> 1,
				'block'=> 0,
			);				
			if ($this->Admin_model->UpdateDeliveryBoy($did,$deliveryboy) ) {
				
				$textmessage = $password." is a Password for Your Account.Thanks For Be a Part of AMM SHOP";				
				$this->SendPasswordlogin($mobile,$textmessage);
                echo '<script>';
                echo 'setTimeout(function () {swal("Updated!", "Your Delivery Boy Succesfully Updated.", "success");';
                echo '}, 1000);';
                echo 'setTimeout(function () {window.location.href="'.base_url()."Admin/DeliveryBoy".'"';
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
		if(isset($this->session->userdata['Alogged_in']))
		{
			$did = $this->input->post('did');
			$chkdeliveryboypresent = $this->Admin_model->chkdeliveryboypresent($did);
			if($chkdeliveryboypresent==1)
			{
				$json_array=array(
					"success"=>'true',
					"chkdeliveryboypresent"=>1				 
				);				
			}
			else
			{
				if($this->Admin_model->DeleteDeliveryBoy($did))
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
	//Sub Admin
	public function SubAdmin()
	{
		if(isset($this->session->userdata['Alogged_in'])){
			$data['SubAdminDetails']=$this->Admin_model->GetSubAdmin();
			$data['CityDetails']=$this->Admin_model->GetCities();
			$this->load->view('Admin/Header');
			$this->load->view('Admin/SubAdmin',$data);
			$this->load->view('Admin/Footer');
		}else{
			
        $this->Login();
		}
	}
	public function CheckMobileNoExistForSubAdmin()
    {
		$mobileno=$this->input->post('mobilenoval');	
		$result=$this->Admin_model->CheckMobileNoExistForSubAdmin($mobileno);
		 echo $result;
	}
	public function AddSubAdmin()
    {
		if(isset($this->session->userdata['Alogged_in']))
		{
			$password=$this->GenerateRandomOtp();
			$mobile=$this->input->post('txtmobileno');
			$subadmin = array(
				'sub_admin_name'=> $this->input->post('txtsubadminname'),
				'mobile_no'=> $this->input->post('txtmobileno'),
				'email'=> $this->input->post('txtemail'),
				'username'=> $this->input->post('txtemail'),
				'address'=> $this->input->post('txtaddress'),
				'city_id'=> $this->input->post('txtcityid'),
				'area_id'=> $this->input->post('txtareaid'),
				'password'=> $password,
				'verified'=> 1,
				'block'=> 0,
			);				
			if ($this->Admin_model->AddSubAdmin($subadmin)) {

				$textmessage = $password." is a Password for Your Account.Thanks For Be a Part of AMM SHOP";				
				$this->SendPasswordlogin($mobile,$textmessage);
                echo '<script>';
                echo 'setTimeout(function () {swal("Added!", "Your Sub Admin Succesfully Added.", "success");';
                echo '}, 1000);';
                echo 'setTimeout(function () {window.location.href="'.base_url()."Admin/SubAdmin".'"';
                echo '}, 2000);</script>';
                $this->SubAdmin();
            } else {
                echo '<script>';
                echo 'setTimeout(function () {swal("Opps!", "There is some problem please try again after some time", "error");';
                echo '}, 1000);</script>';
                $this->SubAdmin();
            }
		}
		else
        {
			$this->Login();
		} 
	}
	public function EditCheckMobileNoExistForSubAdmin()
    {
		$said=$this->input->post('said');
		$mobileno=$this->input->post('mobilenoval');		
		$result=$this->Admin_model->EditCheckMobileNoExistForSubAdmin($said,$mobileno);
		 echo $result;
	}
	public function EditSubAdmin()
    {
		if(isset($this->session->userdata['Alogged_in']))
		{
			$said=$this->input->post('said');
			$password=$this->GenerateRandomOtp();
			$mobile=$this->input->post('edittxtmobileno');
			$subadmin = array(
				'sub_admin_name'=> $this->input->post('edittxtsubadminname'),
				'mobile_no'=> $this->input->post('edittxtmobileno'),
				'email'=> $this->input->post('edittxtemail'),
				'address'=> $this->input->post('edittxtaddress'),
				'city_id'=> $this->input->post('edittxtcityid'),
				'area_id'=> $this->input->post('txtareaid'),
				'password'=> $password,
				'verified'=> 1,
				'block'=> 0,
			);				
			if ($this->Admin_model->UpdateSubAdmin($said,$subadmin)) {

				$textmessage = $password." is a Password for Your Account.Thanks For Be a Part of AMM SHOP";				
				//$this->SendPasswordlogin($mobile,$textmessage);
                echo '<script>';
                echo 'setTimeout(function () {swal("Updated!", "Your Sub Admin Succesfully Updated.", "success");';
                echo '}, 1000);';
                echo 'setTimeout(function () {window.location.href="'.base_url()."Admin/SubAdmin".'"';
                echo '}, 2000);</script>';
                $this->SubAdmin();
            } else {
                echo '<script>';
                echo 'setTimeout(function () {swal("Opps!", "There is some problem please try again after some time", "error");';
                echo '}, 1000);</script>';
                $this->SubAdmin();
            }
		}
		else
        {
			$this->Login();
		} 
	}
	public function DeleteSubAdmin()
	{
		if(isset($this->session->userdata['Alogged_in']))
		{
			$said = $this->input->post('said');
			if($this->Admin_model->DeleteSubAdmin($said))
			{
				$json_array=array(
					"success"=>'true',
					"chkssubadminpresent"=>0				 
				);
			}
			else
			{
				$json_array=array(
					"success"=>'false',
					"chkssubadminpresent"=>0				 
				);
			}		
            echo json_encode($json_array);
		}
		else
		{			
        	$this->Login();
		}
	}
	public function BlokUnblockSubAdmin()
	{
		$block = $this->input->post('blockValue');
		$said = $this->input->post('said');		  
		$blockunblockvalue = array(
			'block' => $block
		);	 
		if(isset($this->session->userdata['Alogged_in'])){
			$this->Admin_model->BlockUnblockSubAdmin($said,$blockunblockvalue);
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
		if(isset($this->session->userdata['Alogged_in'])){       
			$data["ItemsDataNoti"]=$this->Admin_model->GetNewItemsDataNoti();
			$data["VendorsDataNoti"]=$this->Admin_model->GetNewVendorsDataNoti();        
			return $data;
		}else{		

			$this->Login();
		}
	}
	public function Notification()	
	{
		if(isset($this->session->userdata['Alogged_in'])){
			$data=$this->getnotificationdata();
			// print_r($data);exit;
			$this->load->view('Admin/Header');
			$this->load->view('Admin/Notification',$data);
			$this->load->view('Admin/Footer');
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
		if ( $this->Admin_model->setcheckitemsnoti($anoti)) {		
			echo 1;	
		} else {
			echo 0;
		}
	}*/
	public function VendorPayments()	
	{
		if(isset($this->session->userdata['Alogged_in'])){
			$data['VendorPaymentDetails']=$this->Admin_model->GetVendorPaymentDetails();
			$data['CityDetails']=$this->Admin_model->GetCities();
			$this->load->view('Admin/Header');
			$this->load->view('Admin/VendorPayments',$data);
			$this->load->view('Admin/Footer');
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
				'Status' => 'Paid'
			); 
		}
		else	 
		{
			$statusvalue = array(
				'Status' => 'NotPaid'
			); 
		}
		if(isset($this->session->userdata['Alogged_in'])){
			$this->Admin_model->ChangePaymentStatus($vbid,$statusvalue);
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
		if(isset($this->session->userdata['Alogged_in'])){
			$cityid = $this->input->post('cityid');
			$data['VendorDetails']=$this->Admin_model->GetVendorFromCity($cityid);
			$this->load->view('Admin/fetchVendor',$data);		
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
				'Status'=> 'Paid',
				'Payment_type'=> $paymenttype,
				'Chequeno'=> $this->input->post('chequeno'),
				'Transactionid'=> $this->input->post('transactionid'),
				'Vid'=> $vid,
			); 
		if ($this->Admin_model->AddVendorPayment($data)) {
			echo '<script>';
			echo 'setTimeout(function () {swal("Added!", "Payment Succesfully Added!", "success");';
			echo '}, 1000);';
			echo 'setTimeout(function () {window.location.href="'.base_url()."Admin/VendorPayments".'"';
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
		if(isset($this->session->userdata['Alogged_in'])){
			$data['OrdersDetails']=$this->Admin_model->GetOrders();
			//print_r($data['OrdersDetails']);exit;
			$this->load->view('Admin/Header');
			$this->load->view('Admin/Orders',$data);
			$this->load->view('Admin/Footer');
		}else{
			
        $this->Login();
		}
	}
	/*public function GetOrderStatusResult()		
	{		
		$orderstatus=$this->input->post('orderstatus');		
			if(isset($this->session->userdata['Alogged_in']))			
			{		
				if($orderstatus == '1')		
				{		
				$data['OrderDetails']=$this->EcomAdmin_model->GetNewOrders();				
				}		
				elseif($orderstatus == '2')		
				{		
				$data['OrderDetails']=$this->EcomAdmin_model->GetCompletedOrders();
				}		
				elseif($orderstatus == '3')		
				{		
				$data['OrderDetails']=$this->EcomAdmin_model->GetCriticalOrders();	
				}		
				elseif($orderstatus == '4')		
				{		
				$data['OrderDetails']=$this->EcomAdmin_model->GetFailedOrders();
				}
				elseif($orderstatus == '5')		
				{		
				$data['OrderDetails']=$this->EcomAdmin_model->GetFailedOrders();
				}
			
				$this->load->view('EcomAdmin/FetchOrderDetailsOnStatus',$data);
			}		
		}else{$this->Login();}
	}  */
	public function GenerateInvoice()
    {
        if(isset($this->session->userdata['Alogged_in'])){
            //$viid=$this->input->post('viid');           
          //  $uid=$this->input->post('uid');
		  //  $uaid=$this->input->post('uaid');
		  	$orderid=$this->input->post('orderid');
			$data['OrderDetails']=$this->Admin_model->GetUserDetails($orderid);
			//print_r($data['OrderDetails']);exit;
			 $this->load->view('Admin/invoice',$data);
		}else{		
        $this->Login();
		}

	}
	public function ChangeOrderStatus()
    {
        $orderstatus=$this->input->post('status');
        $oid=$this->input->post('oid');
        if(isset($this->session->userdata['Alogged_in'])){
            $statusvalue = array(
                'Status' => $orderstatus
            );
            $this->Admin_model->ChangeOrderStatus($oid,$statusvalue);
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

        if(isset($this->session->userdata['Alogged_in']))

        {
            $this->load->library('Fpdf_gen');
            
            $orderid=$this->input->get('orderid');
			$OrderDetails=$this->Admin_model->GetUserDetails($orderid);	
			
			$iname = explode("/",$OrderDetails[0]->iname);	
			$vname = explode("/",$OrderDetails[0]->vname);
			$iprice = explode("/",$OrderDetails[0]->iprice);		
			$qty =  explode(",",$OrderDetails[0]->qty);	
			//print_r($singlevname[$r]);echo "<br>";
			$invoiceheader='./assets/Admin/images/logo/amshoplogo.png';

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
        if(isset($this->session->userdata['Alogged_in'])){
			$data['AllUsers']=$this->Admin_model->GetUsers();
			$data['UserWallet']=$this->Admin_model->GetUserWallet();
			//print_r($data['UserWallet']);exit;
			$this->load->view('Admin/Header');
			$this->load->view('Admin/UserWallet',$data);
			$this->load->view('Admin/Footer');
		}else{		
        $this->Login();
		}

	}
	public function AddMoneyToUserWallet()	
	{
		if(isset($this->session->userdata['Alogged_in']))
		{
			$uid=$this->input->post('txtuserid');
			$user_wallet_id=$this->input->post('user_wallet_id'); 
			
			$aid=$this->session->userdata['Alogged_in']['aid'];
			$walletmoney=$this->input->post('txtwalletmoney'); 
		/*	$result=$this->Admin_model->GetUserWalletDetails($uid);
			$sum_wallet=0;*/
			if($user_wallet_id)
			{		
				$data = array(
					'wallet'=> $walletmoney,
					'updated_by_admin'=> $aid,
					'updated_at'=> date('Y-m-d H:i:s'),
				); 
				if ($this->Admin_model->UpdateUserWallet($user_wallet_id,$data)) {
					$this->Admin_model->UpdateUserWalletMoney($uid);
					echo '<script>';
					echo 'setTimeout(function () {swal("Updated!", "User Wallet Money Succesfully Updated!", "success");';
					echo '}, 1000);';
					echo 'setTimeout(function () {window.location.href="'.base_url()."Admin/WalletMoney".'"';
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
					'updated_by_admin'=> $aid,
				); 
				if ($this->Admin_model->AddUserWallet($data)) {
					$this->Admin_model->UpdateUserWalletMoney($uid);
					echo '<script>';
					echo 'setTimeout(function () {swal("Added!", "User Wallet Money Succesfully Added!", "success");';
					echo '}, 1000);';
					echo 'setTimeout(function () {window.location.href="'.base_url()."Admin/WalletMoney".'"';
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
		if(isset($this->session->userdata['Alogged_in']))
		{
			$UserWalletid = $this->input->post('UserWalletid');
			if($this->Admin_model->DeleteUserWallet($UserWalletid))
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
		$result = $this->Admin_model->SelectCityName($term);
		echo json_encode($result);
	
	}
	public function CurrentOrders()
	{
		if(isset($this->session->userdata['Alogged_in'])){		
			$this->load->view('Admin/Header');
			$this->load->view('Admin/CurrentOrders');
			$this->load->view('Admin/Footer');
		}else{
			
        $this->Login();
		}
	}
	public function GetCityWiseOrders()
	{
		if(isset($this->session->userdata['Alogged_in'])){
			$city = $this->input->post('cityname');			
			$data['OrdersDetails']=$this->Admin_model->GetCityWiseOrders($city);
			//print_r($data['OrdersDetails']);exit;
			$this->load->view('Admin/FetchCityWiseCurrentOrders',$data);			
		}else{
			
        $this->Login();
		}
	}
	public function RejectedOrders()
	{
		if(isset($this->session->userdata['Alogged_in'])){
			$data['OrdersDetails']=$this->Admin_model->GetRejectedOrders();
			//print_r($data['OrdersDetails']);exit;
			$this->load->view('Admin/Header');
			$this->load->view('Admin/RejectedOrders',$data);
			$this->load->view('Admin/Footer');
		}else{
			
        $this->Login();
		}
	}
	public function CouponCode()
	{
		if(isset($this->session->userdata['Alogged_in'])){
			$data['CouponCodeDetails']=$this->Admin_model->GetCouponCode();
			$data['NextCouponId']=$this->Admin_model->GetNextCouponId();
			//print_r($data['NextCouponId']);exit;
			$this->load->view('Admin/Header');
			$this->load->view('Admin/CouponCode',$data);
			$this->load->view('Admin/Footer');
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
		if ($this->Admin_model->AddCouponCodeAmount($data)) {
			echo '<script>';
			echo 'setTimeout(function () {swal("Added!", "Coupon Code Succesfully Added!", "success");';
			echo '}, 1000);';
			echo 'setTimeout(function () {window.location.href="'.base_url()."Admin/CouponCode".'"';
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
		if ($this->Admin_model->UpdateCouponCodeAmount($couponid,$data)) {
			echo '<script>';
			echo 'setTimeout(function () {swal("Updated!", "Coupon Code Succesfully Updated!", "success");';
			echo '}, 1000);';
			echo 'setTimeout(function () {window.location.href="'.base_url()."Admin/CouponCode".'"';
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
		if(isset($this->session->userdata['Alogged_in']))
		{
			$couponid=$this->input->post('couponid');
			$chkCouponCodepresent = $this->Admin_model->chkCouponCodepresent($couponid);
			if($chkCouponCodepresent==1)
			{
				$json_array=array(
					"success"=>'true',
					"chkCouponCodepresent"=>1				 
				);				
			}
			else
			{
				if($this->Admin_model->DeleteCouponCode($couponid))
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
		if(isset($this->session->userdata['Alogged_in'])){
			$data['AllUsers']=$this->Admin_model->GetUsers();
			$data['CouponCodeDetails']=$this->Admin_model->GetCouponCode();
			$data['AssignCouponDetails']=$this->Admin_model->GetAssignedCoupons();
			//print_r($data['NextCouponId']);exit;
			$this->load->view('Admin/Header');
			$this->load->view('Admin/AssignedCouponCode',$data);
			$this->load->view('Admin/Footer');
		}else{
			
        $this->Login();
		}
	}
	public function AlreadyUsedCoupen()
    {
		$uid=$this->input->post('useridval');
		$couponid=$this->input->post('couponidval');			
		$result=$this->Admin_model->CheckAlreadyUsedCoupen($uid,$couponid);
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
		if ($this->Admin_model->AddAssinedCouponCode($data)) {
			echo '<script>';
			echo 'setTimeout(function () {swal("Added!", "Coupon Code Assigned Succesfully!", "success");';
			echo '}, 1000);';
			echo 'setTimeout(function () {window.location.href="'.base_url()."Admin/AssignedCoupons".'"';
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
		$result=$this->Admin_model->EditAlreadyUsedCoupen($assignccid,$uid,$couponid);
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
		if ($this->Admin_model->UpdateAssinedCouponCode($assignccid,$data)) {
			echo '<script>';
			echo 'setTimeout(function () {swal("Updated!", "Coupon Code Updated Succesfully!", "success");';
			echo '}, 1000);';
			echo 'setTimeout(function () {window.location.href="'.base_url()."Admin/AssignedCoupons".'"';
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
		if(isset($this->session->userdata['Alogged_in']))
		{
			$assignccid=$this->input->post('assignid');	
			
			if($this->Admin_model->DeleteAssignedCoupon($assignccid))
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
		if(isset($this->session->userdata['Alogged_in'])){
			$data['DeliverySlotsDetails']=$this->Admin_model->GetDeliverySlots();		
			$data['VendorDetails']=$this->Admin_model->GetVerifiedVendor();			
			$this->load->view('Admin/Header');
			$this->load->view('Admin/SlotsOfDelivery',$data);
			$this->load->view('Admin/Footer');
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
		if ($this->Admin_model->AddDeliverySlot($data)) {
			echo '<script>';
			echo 'setTimeout(function () {swal("Added!", "Delivery Slot Succesfully Added!", "success");';
			echo '}, 1000);';
			echo 'setTimeout(function () {window.location.href="'.base_url()."Admin/SlotsOfDelivery".'"';
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
		if(isset($this->session->userdata['Alogged_in']))
		{
			$deliveryslot_id=$this->input->post('deliveryslot_id');
			$data = array(
				'vid'=> $this->input->post('edittxtvendorid'),
				'opentime'=> $this->input->post('edittxtopentime'),
				'closetime'=> $this->input->post('edittxtclosetime'),
				'updated_at'=> date('Y-m-d H:i:s'),
			); 
			if ($this->Admin_model->UpdateDeliverySlot($deliveryslot_id,$data)) {
				echo '<script>';
				echo 'setTimeout(function () {swal("Updated!", "Delivery Slot Succesfully Updated!", "success");';
				echo '}, 1000);';
				echo 'setTimeout(function () {window.location.href="'.base_url()."Admin/SlotsOfDelivery".'"';
				echo '}, 2000);</script>';
				$this->SlotsOfDelivery();
			} else {
				echo '<script>';
				echo 'setTimeout(function () {swal("Opps!", "There is some problem please try again after some time", "error");';
				echo '}, 1000);</script>';
				$this->SlotsOfDelivery();
			} 
		}
		else{
			
			$this->Login();
			}
	}
	public function DeleteDeliverySlot()
	{
		if(isset($this->session->userdata['Alogged_in']))
		{
			$deliveryslot_id=$this->input->post('deliveryslot_id');
			/*$chkDeliverySlotpresent = $this->Admin_model->chkDeliverySlotpresent($deliveryslot_id);
			if($chkDeliverySlotpresent==1)
			{
				$json_array=array(
					"success"=>'true',
					"chkDeliverySlotpresent"=>1				 
				);				
			}
			else
			{*/
				if($this->Admin_model->DeleteDeliverySlot($deliveryslot_id))
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
		if(isset($this->session->userdata['Alogged_in'])){
			$data['ItemDetails']=$this->Admin_model->GetItemDetails($item_id);
			$data['ItemInfo']=$this->Admin_model->GetItem($item_id);
			//print_r($data);exit;
			$this->load->view('Admin/Header');
			$this->load->view('Admin/ItemDetails',$data);
			$this->load->view('Admin/Footer');
		}else{
			
        $this->Login();
		}
	}
	public function SellReport()	
	{
		if(isset($this->session->userdata['Alogged_in'])){
			$this->load->view('Admin/Header');
			$this->load->view('Admin/SellReport');
			$this->load->view('Admin/Footer');
		}else{
			
        $this->Login();
		}
	}
	public function GetSellReport()
	{
		if(isset($this->session->userdata['Alogged_in'])){
			$city = $this->input->post('cityname');	
			$startdate = $this->input->post('startdate');			
			$enddate = $this->input->post('enddate');			
			
			$db_startdate = date('Y-m-d 00:00:00',strtotime($startdate));
			$db_enddate = date('Y-m-d 23:59:59',strtotime($enddate));
				
			$data['SellReports']=$this->Admin_model->GetSellReport($city,$db_startdate,$db_enddate);
			$data['SellTotalReports']=$this->Admin_model->GetSellTotalReport($city,$db_startdate,$db_enddate);
			
			$this->load->view('Admin/FetchSellReports',$data);			
		}else{
			$this->Login();
		}
	}
	public function ShippingCharges()	
	{
		if(isset($this->session->userdata['Alogged_in'])){
			$data['ShippingCharges']=$this->Admin_model->GetShippingCharges();
			$this->load->view('Admin/Header');
			$this->load->view('Admin/ShippingCharges',$data);
			$this->load->view('Admin/Footer');
		}else{
			
        $this->Login();
		}
	}
	public function CheckShippingChargePresent()
    {
		$startval=$this->input->post('startval');	
		$endval=$this->input->post('endval');	
		$a = array($startval);
        $b = array($endval); 
		// merge both
		$merge = array_merge($a,$b);
		// for ASC order
		sort($merge);
		$range = implode(",",$merge); 	
		//echo $range; exit;
		$charges=$this->input->post('chargesval');	
		$result=$this->Admin_model->CheckShippingChargePresent($range);
		 echo $result;
	}
	public function AddShipping()	
	{
		if(isset($this->session->userdata['Alogged_in']))
		{	
			$startval=$this->input->post('txtstartrange');	
			$endval=$this->input->post('txtendrange');	
			$a = array($startval);
			$b = array($endval); 
			// merge both
			$merge = array_merge($a,$b);
			// for ASC order
			sort($merge);
			$range = implode(",",$merge); 

			$data = array(					
					'range'=> $range,
					'chanrges'=> $this->input->post('txtcharges'),
					'created_at'=> date('Y-m-d H:i:s'),
				); 
				if ($this->Admin_model->AddShippingCharges($data)) {
					echo '<script>';
					echo 'setTimeout(function () {swal("Added!", "Shipping Charges Succesfully Added!", "success");';
					echo '}, 1000);';
					echo 'setTimeout(function () {window.location.href="'.base_url()."Admin/ShippingCharges".'"';
					echo '}, 2000);</script>';
					$this->ShippingCharges();
				} else {
					echo '<script>';
					echo 'setTimeout(function () {swal("Opps!", "There is some problem please try again after some time", "error");';
					echo '}, 1000);</script>';
					$this->ShippingCharges();
				} 
		}
		else
		{
			$this->Login();
		}
	}
	public function EditCheckShippingChargePresent()
    {
		$shippingid=$this->input->post('id');
		$startval=$this->input->post('startval');	
		$endval=$this->input->post('endval');	
		$a = array($startval);
        $b = array($endval); 
		// merge both
		$merge = array_merge($a,$b);
		// for ASC order
		sort($merge);
		$range = implode(",",$merge); 	
		//echo $range; exit;
		$charges=$this->input->post('chargesval');	
		$result=$this->Admin_model->EditCheckShippingChargePresent($shippingid,$range);
		 echo $result;
	}
	public function EditShipping()	
	{
		if(isset($this->session->userdata['Alogged_in']))
		{	
			$shippingid=$this->input->post('shippingid');
			$startval=$this->input->post('edittxtstartrange');	
			$endval=$this->input->post('edittxtendrange');	
			$a = array($startval);
			$b = array($endval); 
			// merge both
			$merge = array_merge($a,$b);
			// for ASC order
			sort($merge);
			$range = implode(",",$merge); 

			$data = array(					
					'range'=> $range,
					'chanrges'=> $this->input->post('edittxtcharges'),
					'updated_at'=> date('Y-m-d H:i:s'),
				); 
				if ($this->Admin_model->UpdateShippingCharges($shippingid,$data)) {
					echo '<script>';
					echo 'setTimeout(function () {swal("Added!", "Shipping Charges Succesfully Added!", "success");';
					echo '}, 1000);';
					echo 'setTimeout(function () {window.location.href="'.base_url()."Admin/ShippingCharges".'"';
					echo '}, 2000);</script>';
					$this->ShippingCharges();
				} else {
					echo '<script>';
					echo 'setTimeout(function () {swal("Opps!", "There is some problem please try again after some time", "error");';
					echo '}, 1000);</script>';
					$this->ShippingCharges();
				} 
		}
		else
		{
			$this->Login();
		}
	}
}
