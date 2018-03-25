<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vendor extends CI_Controller {
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

$this->load->model('Vendor_model');
if(isset($this->session->userdata['Vlogged_in']))
{
	$Vid=$this->session->userdata['Vlogged_in']['Vid'];
	$this->site_notification=$this->Vendor_model->Getnoticount($Vid);
	//print_r($this->site_notification);exit;
	$this->load->vars($this->site_notification);
}

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
		if(isset($this->session->userdata['Vlogged_in'])){
			$Vid=$this->session->userdata['Vlogged_in']['Vid'];
			$data['getdashboard']=$this->Vendor_model->getdashboard($Vid);
			//print_r($data['getdashboard']);exit;
			$this->load->view('Vendor/Header');
			$this->load->view('Vendor/index',$data);
			$this->load->view('Vendor/Footer');
		}else{
			
		$this->Login();
		}
	}
	//Login
	public function Login()
    {
        $this->load->view('Vendor/loginheader');
        $this->load->view('Vendor/login');
        $this->load->view('Vendor/loginfooter');
	}
	 // Check for user login process
	public function Vendor_login_process()
	{

		$this->form_validation->set_rules('mobile_no', 'Mobile no', 'trim|required|xss_clean');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');

		if ($this->form_validation->run() == FALSE) {
		if(isset($this->session->userdata['Vlogged_in'])){
			$this->index();

		}else{
		$this->Login();
		}
		} else {
			$data = array(
			'mobile_no' => $this->input->post('mobile_no'),
			'password' => $this->input->post('password')
			);
			$result = $this->Vendor_model->login($data);
			//print_r($result);exit;
			if ($result) {			
		
			$session_data = array(
			'Vid' => $result[0]->vid,
			'VShopName' => $result[0]->shop_name,
			'VMobileno' => $result[0]->mobile_no,
			'VName' => $result[0]->name,
			);
			//print_r($session_data);exit;
			// Add user data in session
			$this->session->set_userdata('Vlogged_in' ,$session_data);
			$this->index();
		
		} else {
			$data = array(
			'error_message' => 'Invalid Username or Password'
			);
			$this->load->view('Vendor/loginheader');
			$this->load->view('Vendor/login',$data);
			$this->load->view('Vendor/loginfooter');
			}
		}
	}
	//Forgot Password
	public function Forgot()
    {
        $this->load->view('Vendor/loginheader');
        $this->load->view('Vendor/Forgot');
        $this->load->view('Vendor/loginfooter');
    }
	public function ForgotPassword()
    {
        $email = $this->input->post("email");
		if ($this->Vendor_model->Checkemail($email))
		{
        	$password = $this->Vendor_model->getpassword($email);
            if($this->sendmail($email,$password))
            {
                echo '<script>';
                echo 'setTimeout(function () {swal("Registered!", "Please Check Your Registered mail For Password", "success");';
                echo '}, 1000);';
                echo 'setTimeout(function () {window.location.href="'.base_url()."Vendor/Login".'"';
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
	// Logout from Vendor page
	public function logout() 
	{

		// Removing session data
		$sess_array = array(
		'username' => ''
		);
		$this->session->unset_userdata('Vlogged_in', $sess_array);
		$data['message_display'] = 'Successfully Logout';
			$this->load->view('Vendor/loginheader');
			$this->load->view('Vendor/login',$data);
			$this->load->view('Vendor/loginfooter');
	}
	//ChangePassword
	public function ChangePassword()
	{
		if(isset($this->session->userdata['Vlogged_in'])){
			$this->load->view('Vendor/Header');
			$this->load->view('Vendor/ChangePassword');
			$this->load->view('Vendor/Footer');
		}else{
			
        $this->Login();
		}
	}
	public function Checkpassword()
    {
        $Vid=$this->session->userdata['Vlogged_in']['Vid'];
		$pwd=$this->input->post('oldpass');	
		$result=$this->Vendor_model->CheckPassword($Vid,$pwd);
		 echo $result;
    }
	public function Updatepassword()
    {
        $Vid=$this->session->userdata['Vlogged_in']['Vid'];
        $Password = array(
            'password'=> $this->input->post('password'),
            );
            if ($this->Vendor_model->UpdatePassword($Password,$Vid)) {
                echo '<script>';
                echo 'setTimeout(function () {swal("Updated!", "Your Password Succesfully Updated.", "success");';
                echo '}, 1000);';
                echo 'setTimeout(function () {window.location.href="'.base_url()."Vendor/ChangePassword".'"';
                echo '}, 2000);</script>';
                $this->ChangePassword();
            } else {
                echo '<script>';
                echo 'setTimeout(function () {swal("Opps!", "There is some problem please try again after some time", "error");';
                echo '}, 1000);</script>';
                $this->ChangePassword();
            }
	}  	
	
	public function Items()	
	{
		if(isset($this->session->userdata['Vlogged_in'])){
			$Vid=$this->session->userdata['Vlogged_in']['Vid'];
			$data['Items']=$this->Vendor_model->GetItems($Vid);
			$data['CategoryDetails']=$this->Vendor_model->GetCategory();
			//print_r($data);exit;
			$this->load->view('Vendor/Header');
			$this->load->view('Vendor/items',$data);
			$this->load->view('Vendor/Footer');
		}else{
			
        $this->Login();
		}
	}
	public function ItemDetails($item_id)	
	{
		if(isset($this->session->userdata['Vlogged_in'])){
			$data['ItemDetails']=$this->Vendor_model->GetItemDetails($item_id);
			$data['ItemInfo']=$this->Vendor_model->GetItemInfo($item_id);
			//print_r($data);exit;
			$this->load->view('Vendor/Header');
			$this->load->view('Vendor/ItemDetails',$data);
			$this->load->view('Vendor/Footer');
		}else{
			
        $this->Login();
		}
	}
	public function GetSubCategory()
	{
		if(isset($this->session->userdata['Vlogged_in'])){
			$catid = $this->input->post('catid');
			$data['SubCategoryDetails']=$this->Vendor_model->GetSubCategoryFromMainCategory($catid);
			$this->load->view('Vendor/fetchSubCategory',$data);		
		}
		else{	
        	$this->Login();
		}
	}
	public function GetSubSubCategory()
	{
		if(isset($this->session->userdata['Vlogged_in'])){
			$subcatid = $this->input->post('subcatid');
			$data['SubSubCategoryDetails']=$this->Vendor_model->GetSubSubCategoryFromSubCategory($subcatid);
			$this->load->view('Vendor/fetchSubSubCategory',$data);		
		}
		else{	
        	$this->Login();
		}
	}
	public function GetQtyType()
	{
		if(isset($this->session->userdata['Vlogged_in'])){
			$subcatid=$this->input->post('subcatid');
			$data['QuantityTypeDetails']=$this->Vendor_model->GetQtyType($subcatid);
			//print_r($data['QuantityTypeDetails']);exit;
			$this->load->view('Vendor/fetchQuantitytype',$data);
		}else{
			
        $this->Login();
		}
	}
	public function GetQty()
	{
		if(isset($this->session->userdata['Vlogged_in'])){
			$qtytypeid=$this->input->post('qtytypeid');
			$data['QuantityDetails']=$this->Vendor_model->GetQtyonQtyType($qtytypeid);
			//print_r($data['QuantityTypeDetails']);exit;
			$this->load->view('Vendor/fetchQuantity',$data);
		}else{
			
        $this->Login();
		}
	}
	public function AddItem()	
	{
		$Vid=$this->session->userdata['Vlogged_in']['Vid'];
		$item = array(			
			'vid'=> $Vid,
			'f_id'=> $this->input->post('txtsubsubsubcatid'),
			'item_name'=> $this->input->post('itemname'),
			'gst'=> $this->input->post('gstamt'),
			'description'=> $this->input->post('description'),
			//'verified'=> 0,
			);
		$item_id=$this->Vendor_model->AddItem($item);
		if($item_id)
		{
			if(isset($this->session->userdata['Vlogged_in']))
			{
				if (!is_dir('./assets/Admin/images/Items/'.$Vid)) {
					mkdir('./assets/Admin/images/Items/'.$Vid, 0777, TRUE);
				}			
				$data = array();
				if(!empty($_FILES['userFiles']['name']))
				{
					$filesCount = count($_FILES['userFiles']['name']);
					
					for($i = 0; $i < $filesCount; $i++)
					{
						$_FILES['userFile']['name'] = $_FILES['userFiles']['name'][$i];
						$_FILES['userFile']['type'] = $_FILES['userFiles']['type'][$i];
						$_FILES['userFile']['tmp_name'] = $_FILES['userFiles']['tmp_name'][$i];
						$_FILES['userFile']['error'] = $_FILES['userFiles']['error'][$i];
						$_FILES['userFile']['size'] = $_FILES['userFiles']['size'][$i];
	
						$uploadPath = './assets/Admin/images/Items/'.$Vid.'/';
						$config['upload_path'] = $uploadPath;
						$config['allowed_types'] = 'gif|jpg|png';
						
						$this->load->library('upload', $config);
						$this->upload->initialize($config);
						if($this->upload->do_upload('userFile'))
						{
							$fileData = $this->upload->data();
							$uploadData[$i]['item_id'] = $item_id;
							$uploadData[$i]['item_image'] = './assets/Admin/images/Items/'.$Vid.'/'.$fileData['file_name'];
							$uploadData[$i]['created_at'] = date("Y-m-d H:i:s");
						}
					}
					//print_r($uploadData);exit;
					if(!empty($uploadData))
					{
						//Insert file information into the database
						$insert_item_images = $this->Vendor_model->insert($uploadData);
						if($insert_item_images){
							$vendor_items = array(			
								'item_id'=> $item_id,
								'qtytype_id'=> $this->input->post('qtytype'),
								'qty_id'=> $this->input->post('qty'),
								'qtyprice'=> $this->input->post('itemprice'),
								'stock'=> $this->input->post('stock'),
								'discount'=> $this->input->post('discount'),
								);
								if ($this->Vendor_model->AddVendorItems($vendor_items)) {
									echo '<script>';
									echo 'setTimeout(function () {swal("Added!", "Your Item Details Succesfully Added.", "success");';
									echo '}, 1000);';
									echo 'setTimeout(function () {window.location.href="'.base_url()."Vendor/Items".'"';
									echo '}, 2000);</script>';
									$this->Items();
								} else {
									echo '<script>';
									echo 'setTimeout(function () {swal("Opps!", "There is some problem please try again after some time", "error");';
									echo '}, 1000);</script>';
									$this->Items();
								}
						}
						
					}
				}
			}
		}
		else
		{
			$this->Login();
		}
		
	}
	//Orders
	public function Orders()
	{
		if(isset($this->session->userdata['Vlogged_in'])){
			$Vid=$this->session->userdata['Vlogged_in']['Vid'];
			$s_cityid=$this->Vendor_model->GetVendorCity($Vid);			
			$data['OrdersDetails']=$this->Vendor_model->GetOrders($s_cityid);		
			$this->load->view('Vendor/Header');
			$this->load->view('Vendor/Orders',$data);
			$this->load->view('Vendor/Footer');
		}else{
			
        $this->Login();
		}
	}
	/*public function GetOrderStatusResult()		
	{		
		$orderstatus=$this->input->post('orderstatus');		
			if(isset($this->session->userdata['Vlogged_in']))			
			{		
				if($orderstatus == '1')		
				{		
				$data['OrderDetails']=$this->EcomVendor_model->GetNewOrders();				
				}		
				elseif($orderstatus == '2')		
				{		
				$data['OrderDetails']=$this->EcomVendor_model->GetCompletedOrders();
				}		
				elseif($orderstatus == '3')		
				{		
				$data['OrderDetails']=$this->EcomVendor_model->GetCriticalOrders();	
				}		
				elseif($orderstatus == '4')		
				{		
				$data['OrderDetails']=$this->EcomVendor_model->GetFailedOrders();
				}
				elseif($orderstatus == '5')		
				{		
				$data['OrderDetails']=$this->EcomVendor_model->GetFailedOrders();
				}
			
				$this->load->view('EcomVendor/FetchOrderDetailsOnStatus',$data);
			}		
		}else{$this->Login();}
	}  */
	public function GenerateInvoice()
    {
        if(isset($this->session->userdata['Vlogged_in'])){
            //$viid=$this->input->post('viid');           
          //  $uid=$this->input->post('uid');
		  //  $uVid=$this->input->post('uVid');
		  	$orderid=$this->input->post('orderid');
            $data['OrderDetails']=$this->Vendor_model->GetUserDetails($orderid);
			 $this->load->view('Vendor/invoice',$data);
		}else{		
        $this->Login();
		}

	}
	public function ChangeOrderStatus()
    {
        $orderstatus=$this->input->post('status');
        $oid=$this->input->post('oid');
        if(isset($this->session->userdata['Vlogged_in'])){
            $statusvalue = array(
                'Status' => $orderstatus
            );
            $this->Vendor_model->ChangeOrderStatus($oid,$statusvalue);
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

        if(isset($this->session->userdata['Vlogged_in']))

        {
            $this->load->library('Fpdf_gen');
            
            $orderid=$this->input->get('orderid');
			$OrderDetails=$this->Vendor_model->GetUserDetails($orderid);	
			
			$iname = explode("/",$OrderDetails[0]->iname);	
			$vname = explode("/",$OrderDetails[0]->vname);
			$iprice = explode("/",$OrderDetails[0]->iprice);		
			$qty =  explode(",",$OrderDetails[0]->qty);	
			//print_r($singlevname[$r]);echo "<br>";
			$invoiceheader='./assets/Vendor/images/logo/amshoplogo.png';

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
        if(isset($this->session->userdata['Vlogged_in'])){
			$data['AllUsers']=$this->Vendor_model->GetUsers();
            $data['UserWallet']=$this->Vendor_model->GetUserWallet();
			$this->load->view('Vendor/Header');
			$this->load->view('Vendor/UserWallet',$data);
			$this->load->view('Vendor/Footer');
		}else{		
        $this->Login();
		}

	}
	public function AddMoneyToUserWallet()	
	{
		if(isset($this->session->userdata['Vlogged_in']))
		{
			$uid=$this->input->post('txtuserid');
			$user_wallet_id=$this->input->post('user_wallet_id'); 
			
			$said=$this->session->userdata['Vlogged_in']['Vid'];
			$walletmoney=$this->input->post('txtwalletmoney'); 
		/*	$result=$this->Vendor_model->GetUserWalletDetails($uid);
			$sum_wallet=0;*/
			if($user_wallet_id)
			{		
				$data = array(
					'wallet'=> $walletmoney,
					'updated_by_Vendor'=> $said,
					'updated_at'=> date('Y-m-d H:i:s'),
				); 
				
				if ($this->Vendor_model->UpdateUserWallet($user_wallet_id,$data)) {
					$this->Vendor_model->UpdateUserWalletMoney($uid);
					echo '<script>';
					echo 'setTimeout(function () {swal("Updated!", "User Wallet Money Succesfully Updated!", "success");';
					echo '}, 1000);';
					echo 'setTimeout(function () {window.location.href="'.base_url()."Vendor/WalletMoney".'"';
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
					'updated_by_Vendor'=> $said,
				); 
				if ($this->Vendor_model->AddUserWallet($data)) {
					$this->Vendor_model->UpdateUserWalletMoney($uid);
					echo '<script>';
					echo 'setTimeout(function () {swal("Added!", "User Wallet Money Succesfully Added!", "success");';
					echo '}, 1000);';
					echo 'setTimeout(function () {window.location.href="'.base_url()."Vendor/WalletMoney".'"';
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
		if(isset($this->session->userdata['Vlogged_in']))
		{
			$UserWalletid = $this->input->post('UserWalletid');
			if($this->Vendor_model->DeleteUserWallet($UserWalletid))
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
		$result = $this->Vendor_model->SelectCityName($term);
		echo json_encode($result);
	
	}
	public function CurrentOrders()
	{
		if(isset($this->session->userdata['Vlogged_in'])){	
			$data['DeliveryBoy']=$this->Vendor_model->GetDeliveryBoy();				
			$this->load->view('Vendor/Header');
			$this->load->view('Vendor/CurrentOrders',$data);
			$this->load->view('Vendor/Footer');
		}else{
			
        $this->Login();
		}
	}
	public function GetCityWiseOrders()
	{
		if(isset($this->session->userdata['Vlogged_in'])){
			$city = $this->input->post('cityname');			
			$data['OrdersDetails']=$this->Vendor_model->GetCityWiseOrders($city);		
			//print_r($data['OrdersDetails']);exit;
			$this->load->view('Vendor/FetchCityWiseCurrentOrders',$data);			
		}else{
			
        $this->Login();
		}
	}
	public function GetCityStatusWiseOrders()
	{
		if(isset($this->session->userdata['Vlogged_in'])){
			$city = $this->input->post('cityname');		
			$orderstatus = $this->input->post('orderstatus');		
			$data['OrdersDetails']=$this->Vendor_model->GetCityStatusWiseOrders($city,$orderstatus);
			//print_r($data['OrdersDetails']);exit;
			$this->load->view('Vendor/FetchCityStatusWiseCurrentOrders',$data);			
		}else{
			
        $this->Login();
		}
	}
	public function RejectedOrders()
	{
		if(isset($this->session->userdata['Vlogged_in'])){
			$data['OrdersDetails']=$this->Vendor_model->GetRejectedOrders();
			//print_r($data['OrdersDetails']);exit;
			$this->load->view('Vendor/Header');
			$this->load->view('Vendor/RejectedOrders',$data);
			$this->load->view('Vendor/Footer');
		}else{
			
        $this->Login();
		}
	}
	public function CouponCode()
	{
		if(isset($this->session->userdata['Vlogged_in'])){
			$data['CouponCodeDetails']=$this->Vendor_model->GetCouponCode();
			$data['NextCouponId']=$this->Vendor_model->GetNextCouponId();
			//print_r($data['NextCouponId']);exit;
			$this->load->view('Vendor/Header');
			$this->load->view('Vendor/CouponCode',$data);
			$this->load->view('Vendor/Footer');
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
		if ($this->Vendor_model->AddCouponCodeAmount($data)) {
			echo '<script>';
			echo 'setTimeout(function () {swal("Added!", "Coupon Code Succesfully Added!", "success");';
			echo '}, 1000);';
			echo 'setTimeout(function () {window.location.href="'.base_url()."Vendor/CouponCode".'"';
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
		if ($this->Vendor_model->UpdateCouponCodeAmount($couponid,$data)) {
			echo '<script>';
			echo 'setTimeout(function () {swal("Updated!", "Coupon Code Succesfully Updated!", "success");';
			echo '}, 1000);';
			echo 'setTimeout(function () {window.location.href="'.base_url()."Vendor/CouponCode".'"';
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
		if(isset($this->session->userdata['Vlogged_in']))
		{
			$couponid=$this->input->post('couponid');
			$chkCouponCodepresent = $this->Vendor_model->chkCouponCodepresent($couponid);
			if($chkCouponCodepresent==1)
			{
				$json_array=array(
					"success"=>'true',
					"chkCouponCodepresent"=>1				 
				);				
			}
			else
			{
				if($this->Vendor_model->DeleteCouponCode($couponid))
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
		if(isset($this->session->userdata['Vlogged_in'])){
			$data['AllUsers']=$this->Vendor_model->GetUsers();
			$data['CouponCodeDetails']=$this->Vendor_model->GetCouponCode();
			$data['AssignCouponDetails']=$this->Vendor_model->GetAssignedCoupons();
			//print_r($data['NextCouponId']);exit;
			$this->load->view('Vendor/Header');
			$this->load->view('Vendor/AssignedCouponCode',$data);
			$this->load->view('Vendor/Footer');
		}else{
			
        $this->Login();
		}
	}
	public function AlreadyUsedCoupen()
    {
		$uid=$this->input->post('useridval');
		$couponid=$this->input->post('couponidval');			
		$result=$this->Vendor_model->CheckAlreadyUsedCoupen($uid,$couponid);
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
		if ($this->Vendor_model->AddAssinedCouponCode($data)) {
			echo '<script>';
			echo 'setTimeout(function () {swal("Added!", "Coupon Code Assigned Succesfully!", "success");';
			echo '}, 1000);';
			echo 'setTimeout(function () {window.location.href="'.base_url()."Vendor/AssignedCoupons".'"';
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
		$result=$this->Vendor_model->EditAlreadyUsedCoupen($assignccid,$uid,$couponid);
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
		if ($this->Vendor_model->UpdateAssinedCouponCode($assignccid,$data)) {
			echo '<script>';
			echo 'setTimeout(function () {swal("Updated!", "Coupon Code Updated Succesfully!", "success");';
			echo '}, 1000);';
			echo 'setTimeout(function () {window.location.href="'.base_url()."Vendor/AssignedCoupons".'"';
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
		if(isset($this->session->userdata['Vlogged_in']))
		{
			$assignccid=$this->input->post('assignid');	
			
			if($this->Vendor_model->DeleteAssignedCoupon($assignccid))
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
		if(isset($this->session->userdata['Vlogged_in'])){
			$data['DeliverySlotsDetails']=$this->Vendor_model->GetDeliverySlots();		
			$data['VendorDetails']=$this->Vendor_model->GetVerifiedVendor();			
			$this->load->view('Vendor/Header');
			$this->load->view('Vendor/SlotsOfDelivery',$data);
			$this->load->view('Vendor/Footer');
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
		if ($this->Vendor_model->AddDeliverySlot($data)) {
			echo '<script>';
			echo 'setTimeout(function () {swal("Added!", "Delivery Slot Succesfully Added!", "success");';
			echo '}, 1000);';
			echo 'setTimeout(function () {window.location.href="'.base_url()."Vendor/SlotsOfDelivery".'"';
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
		if ($this->Vendor_model->UpdateDeliverySlot($deliveryslot_id,$data)) {
			echo '<script>';
			echo 'setTimeout(function () {swal("Updated!", "Delivery Slot Succesfully Updated!", "success");';
			echo '}, 1000);';
			echo 'setTimeout(function () {window.location.href="'.base_url()."Vendor/SlotsOfDelivery".'"';
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
		if(isset($this->session->userdata['Vlogged_in']))
		{
			$deliveryslot_id=$this->input->post('deliveryslot_id');
			/*$chkDeliverySlotpresent = $this->Vendor_model->chkDeliverySlotpresent($deliveryslot_id);
			if($chkDeliverySlotpresent==1)
			{
				$json_array=array(
					"success"=>'true',
					"chkDeliverySlotpresent"=>1				 
				);				
			}
			else
			{*/
				if($this->Vendor_model->DeleteDeliverySlot($deliveryslot_id))
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
	
	public function SellReport()	
	{
		if(isset($this->session->userdata['Vlogged_in'])){
			$this->load->view('Vendor/Header');
			$this->load->view('Vendor/SellReport');
			$this->load->view('Vendor/Footer');
		}else{
			
        $this->Login();
		}
	}
	public function GetSellReport()
	{
		if(isset($this->session->userdata['Vlogged_in'])){
			$city = $this->input->post('cityname');	
			$startdate = $this->input->post('startdate');			
			$enddate = $this->input->post('enddate');			
			
			$db_startdate = date('Y-m-d 00:00:00',strtotime($startdate));
			$db_enddate = date('Y-m-d 23:59:59',strtotime($enddate));
				
			$data['SellReports']=$this->Vendor_model->GetSellReport($city,$db_startdate,$db_enddate);
			$data['SellTotalReports']=$this->Vendor_model->GetSellTotalReport($city,$db_startdate,$db_enddate);
			
			$this->load->view('Vendor/FetchSellReports',$data);			
		}else{
			$this->Login();
		}
	}
	public function CheckQtyStock()
	{
		if(isset($this->session->userdata['Vlogged_in'])){
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
	public function UpdateQtyByVendor()
	{
		if(isset($this->session->userdata['Vlogged_in'])){
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
				$result=$this->Vendor_model->UpdateVendorItemStock($viid[$i],$qty[$i],$stock[$i]);			
			}
			$result1=$this->Vendor_model->UpdateOrderQty($orderid,$qtyid,$total,$updateattempt);		
			if ($result1) {
				echo '<script>';
				echo 'setTimeout(function () {swal("Updated!", "Quantity Succesfully Updated!", "success");';
				echo '}, 1000);';
				echo 'setTimeout(function () {window.location.href="'.base_url()."Vendor/CurrentOrders".'"';
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
	public function CancelOrderByVendor()
	{
		if(isset($this->session->userdata['Vlogged_in']))
		{
			$oid = $this->input->post('oid');
			$data = array(
				'status'=> 6,
			); 
			if($this->Vendor_model->UpdateOrderByVendor($oid,$data))
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
		if(isset($this->session->userdata['Vlogged_in']))
		{
			$delid = $this->input->post('delval');	
			$result = $this->Vendor_model->CheckDelBoyAvailability($delid);								
			echo $result;exit;
			
		}else{
			$this->Login();
		}
	}
	public function AssignDeliveryBoyByVendor()
	{
		if(isset($this->session->userdata['Vlogged_in'])){
			$orderid = $this->input->post('orderid');	
			$delid = $this->input->post('txtdelid');	
			$data = array(
				'assigndeliveryboy'=> $delid,
			);		
			$result1=$this->Vendor_model->UpdateOrderByVendor($orderid,$data);		
			if ($result1) {
				echo '<script>';
				echo 'setTimeout(function () {swal("Assigned Delivery Boy!", "Delivery Boy Succesfully Assigned!", "success");';
				echo '}, 1000);';
				echo 'setTimeout(function () {window.location.href="'.base_url()."Vendor/CurrentOrders".'"';
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
		if(isset($this->session->userdata['Vlogged_in'])){
			$data['DeliveryMoneyDetails']=$this->Vendor_model->GetDeliveryMoneyDetails();
			//print_r($data['DeliveryMoneyDetails']);exit;
			$this->load->view('Vendor/Header');
			$this->load->view('Vendor/DeliveryMoneyReport',$data);
			$this->load->view('Vendor/Footer');
		}else{
			
        $this->Login();
		}
	}
}
