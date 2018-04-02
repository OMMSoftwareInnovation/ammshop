<?php

Class Vendor_model extends CI_Model {

    public function login($data) 
    {
        $condition = "mobile_no =" . "'" . $data['mobile_no'] . "' AND " . "password =" . "'" . $data['password'] . "'". " AND " . "verified =1";
        $this->db->select('*');
        $this->db->from('vendor');
        $this->db->where($condition);
        $this->db->limit(1);
        $query = $this->db->get();

        if ($query->num_rows() == 1) {
            return $query->result();
        } else {
            return 0;
        }
    }  
    // Read data from database to show data in sub_admin page
    public function read_Vendor_information($mobile_no) {

        $condition = "mobile_no =" . "'" . $mobile_no . "'";
        $this->db->select('*');
        $this->db->from('vendor');
        $this->db->where($condition);
        $this->db->limit(1);
        $query = $this->db->get();

        if ($query->num_rows() == 1) {
        return $query->result();
        } else {
        return false;
        }
    }
    public function CheckPassword($Vid,$pwd)
    {
        $condition = "vid =". $Vid . " AND " . "password =" . "'" . $pwd . "'";
        $this->db->where($condition);
        $query = $this->db->get('vendor');
        if ($query->num_rows() > 0){
            return 'true';
        }
        else{
            return 'false';
        }
    }
    //Update password
    public function UpdatePassword($password,$Vid)
    {
        $this->db->where('vid', $Vid);
            if($this->db->update('vendor',$password))
            {
                return 1;
            }
            else
            {
                return 0;
            }
    }    
    //Dashboard
    public function getdashboard($Vid)    
    {
        $data= array(
            'CurrentOrders' => $this->GetCurrentOrdersCount($Vid),
            'UserCount' => $this->GetUserCount($Vid),
            'CompletedOrders' => $this->GetCompletedOrdersCount($Vid)
        );
        return $data;

    }     
    private function GetVendorCount()
    {
        $this->db->select('count(*) as VendorCount');
        $this->db->from('vendor');
        //$this->db->where('block',1);
         $query = $this->db->get();
        $tmpArray = $query->result_array();
        $this->data = array_shift($tmpArray);

        return $this->data["VendorCount"];

    }
    private function GetUserCount($Vid)
    {
        
        $this->db->select('count(*) as UserCount');
        $this->db->from('orders');     
        $this->db->join('user','user.uid =orders.uid');
        $this->db->join('vendor_items','find_in_set(vendor_items.vi_id, orders.vi_id)'); 
        $this->db->join('items','items.item_id=vendor_items.item_id'); 
        $this->db->where('items.vid',$Vid); 
        $this->db->group_by('orders.order_id');
        $query = $this->db->get();
        $tmpArray = $query->result_array();
        $this->data = array_shift($tmpArray);
       
        return $this->data["UserCount"];

    }
    private function GetCurrentOrdersCount($Vid)
    {
        $condition = "orders.status >0 and orders.status <3 AND items.vid=$Vid";
        $this->db->select('count(*) as CurrentOrders');
        $this->db->from('orders');     
        $this->db->join('user','user.uid =orders.uid');
        $this->db->join('vendor_items','find_in_set(vendor_items.vi_id, orders.vi_id)'); 
        $this->db->join('items','items.item_id=vendor_items.item_id'); 
        //$this->db->where('items.vid',$Vid); 
        $this->db->where($condition); 
        $this->db->group_by('orders.order_id');
        $query = $this->db->get();
        $tmpArray = $query->result_array();
        $this->data = array_shift($tmpArray);
       
        return $this->data["CurrentOrders"];

    }
    private function GetCompletedOrdersCount($Vid)
    {
        $condition = "orders.status=5 AND items.vid=$Vid";
        $this->db->select('count(*) as CompletedOrders');
        $this->db->from('orders');     
        $this->db->join('user','user.uid =orders.uid');
        $this->db->join('vendor_items','find_in_set(vendor_items.vi_id, orders.vi_id)'); 
        $this->db->join('items','items.item_id=vendor_items.item_id'); 
        //$this->db->where('items.vid',$Vid); 
        $this->db->where($condition); 
        $this->db->group_by('orders.order_id');
        $query = $this->db->get();
        $tmpArray = $query->result_array();
        $this->data = array_shift($tmpArray);
      
        return $this->data["CompletedOrders"];

    }
    public function EditCheckArea($areS_aid,$cityid,$area)
    {
        $condition = "area_id !=". $areS_aid . " AND " ."city_id =". $cityid . " AND " . "area_name =" . "'" . $area . "'";
        $this->db->where($condition);
        $query = $this->db->get('area');
        if ($query->num_rows() > 0){
            return 'false';
        }
        else{
            return 'true';
        }
    }
    public function UpdateArea($areS_aid,$area)
    {
        $this->db->where('area_id', $areS_aid);
        if($this->db->update('area',$area))
        {
            return 1;
        }
        else
        {
            return 0;
        }
    }    
    public function chkareapresent($areS_aid)
    {
        $condition = "area_id =" . "'" . $areS_aid . "'";
        $this->db->where($condition);
        $query = $this->db->get('vendor');   
        
        $this->db->where($condition);
        $query1 = $this->db->get('user_address');

        if ($query->num_rows() > 0 || $query1->num_rows() > 0){
            return 1;
        }
        else{
            return 0;
        }
    }
    public function DeleteArea($areS_aid)
	{
		$this->db->where("area_id",$areS_aid);
        if($this->db->delete("area"))
        {
            return 1;
        }
        else{
            return 0;
        }
    }
    public function GetCategory() 
    {
        $this->db->select('*');
        $this->db->from('category');
        $query = $this->db->get();
        return $query->result();       
    }
    public function GetSubCategoryFromMainCategory($catid) 
    {
        $this->db->select('*');
        $this->db->from('sub_category');
        $this->db->where('cat_id',$catid);
        $query = $this->db->get();
        return $query->result();       
    }
    public function GetSubSubCategoryFromSubCategory($subcatid) 
    {
        $this->db->select('*');
        $this->db->from('filters');
        $this->db->where('sub_cat_id',$subcatid);
        $query = $this->db->get();
        return $query->result();       
    }
    public function GetSubCategory() 
    {
        $this->db->select('*,category.category_name');
        $this->db->from('sub_category');
        $this->db->join('category','category.cat_id = sub_category.cat_id');
        $query = $this->db->get();
        return $query->result();       
    }   
    public function GetSubSubCategory()
    {
        $this->db->select('*,category.cat_id,category.category_name,sub_category.sub_cat_name,vendor.name,vendor.mobile_no');
        $this->db->from('filters');
        $this->db->join('vendor','vendor.vid = filters.vid','left');
        $this->db->join('sub_category','sub_category.sub_cat_id = filters.sub_cat_id');
        $this->db->join('category','category.cat_id = sub_category.cat_id');
        $query = $this->db->get();
        return $query->result();       
    }  
    public function GetQuantityType() 
    {
        $this->db->select('qty_type.qty_type_id,qty_type.sub_cat_id,qty_type.qty_type_name,sub_category.sub_cat_name,category.category_name');
        $this->db->from('qty_type');
        $this->db->join('sub_category','sub_category.sub_cat_id = qty_type.sub_cat_id');
        $this->db->join('category','category.cat_id = sub_category.cat_id');
        $query = $this->db->get();
        return $query->result();       
    }   
    public function GetQuantity() 
    {
        $this->db->select('qty.qty_id,qty.qty_name,qty_type.qty_type_id,qty_type.sub_cat_id,qty_type.qty_type_name,sub_category.sub_cat_name,category.category_name');
        $this->db->from('qty_type');
        $this->db->join('qty','qty.qty_type_id = qty_type.qty_type_id');
        $this->db->join('sub_category','sub_category.sub_cat_id = qty_type.sub_cat_id');
        $this->db->join('category','category.cat_id = sub_category.cat_id');
        $query = $this->db->get();
        return $query->result();       
    }
    public function GetSubCategoryFromQtyType() 
    {
        $this->db->select('sub_category.sub_cat_id,sub_category.sub_cat_name');
        $this->db->from('sub_category');
        $this->db->join('qty_type','qty_type.sub_cat_id = sub_category.sub_cat_id');
        $this->db->group_by('qty_type.sub_cat_id');
        $query = $this->db->get();
        return $query->result();       
    }
    public function GetQtyType($subcatid) 
    {
        $this->db->select('*');
        $this->db->from('qty_type');
        $this->db->where('sub_cat_id',$subcatid);
        $query = $this->db->get();
        return $query->result();       
    }   
    public function GetQtyonQtyType($qtytypeid)
    {
        $this->db->select('*');
        $this->db->from('qty');
        $this->db->where('qty_type_id',$qtytypeid);
        $query = $this->db->get();
        return $query->result();       
    }
    public function GetItems($Vid)
    {
        $this->db->select('sub_category.sub_cat_id,items.item_id,items.gst,items.item_name,items.description,items.verified,items.block,vendor.name,vendor.shop_name,vendor.address,vendor.mobile_no,sub_category.sub_cat_name,category.category_name,filters.filt_name');
        $this->db->from('items');
        $this->db->join('vendor','vendor.vid = items.vid');
        $this->db->join('filters','filters.filt_id = items.f_id');
        $this->db->join('sub_category','sub_category.sub_cat_id = filters.sub_cat_id');
        $this->db->join('category','category.cat_id = sub_category.cat_id');
        $this->db->where('items.vid',$Vid);
        $this->db->order_by('items.item_id','desc');
        $query = $this->db->get();
        return $query->result();        
    }      
    public function GetItemDetails($item_id)
    {
        $this->db->select('vendor_items.vi_id,vendor_items.verified,vendor_items.created_at,vendor_items.item_id,vendor_items.qtyprice,vendor_items.stock,vendor_items.discount,items.gst,items.item_name,qty_type.qty_type_name,qty.qty_name');
        $this->db->from('vendor_items');
        $this->db->join('items','items.item_id=vendor_items.item_id');
        $this->db->join('qty_type','qty_type.qty_type_id=vendor_items.qtytype_id','left');
        $this->db->join('qty','qty.qty_id=vendor_items.qty_id','left');
        $this->db->where('vendor_items.item_id',$item_id);
        $query = $this->db->get();
        return $query->result();
    }
    public function GetItemInfo($item_id)
    {
        $this->db->select('*');
        $this->db->from('items');
        $this->db->where('item_id',$item_id);
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->result();
    }
    public function CheckItemAvailability($itemnameval,$gstamtval,$fiteridval,$Vid)
    {
        $this->db->select('*');
        $this->db->from('items');
        $this->db->where('item_name',$itemnameval);
        $this->db->where('gst',$gstamtval);
        $this->db->where('f_id',$fiteridval);
        $this->db->where('vid',$Vid);
        $query = $this->db->get();
        if ($query->num_rows() > 0){
            return 'false';
        }
        else{
            return 'true';
        }
    }	
    public function CheckQtytypeAvailabilityForItem($itemidval,$qtytypeval)
    {
        $this->db->select('*');
        $this->db->from('vendor_items');
         $this->db->where('item_id',$itemidval);
        $this->db->where('qtytype_id',$qtytypeval);
        $query = $this->db->get();
        if ($query->num_rows() > 0){
            return 'false';
        }
        else{
            return 'true';
        }
    }							
    public function AddItem($item) 
    {
        if($this->db->insert('items',$item))    
        {   
            $insert_id = $this->db->insert_id(); 
            return $insert_id;    
        }    
        else    
        {    
            return 0;    
        }
    }
    public function AddQtyTypeForItem($qtytype)
    {
        if($this->db->insert('vendor_items',$qtytype))    
        {   
            return 1;    
        }    
        else    
        {    
            return 0;    
        }
    }
    public function UpdateItemStock($viid,$stock)  
    { 
        $this->db->where('vi_id', $viid);   
        if($this->db->update('vendor_items', $stock))    
        {    
            return 1;    
        }    
        else    
        {
        return 0;    
        }  
    }   
    public function insert($data = array()){
        //$insert = $this->db->insert_batch('item_images',$data);
        //return $insert?true:false;
        if($this->db->insert_batch('item_images',$data))   
        {   
            return 1;    
        }    
        else    
        {    
            return 0;    
        }
    }
    public function AddVendorItems($vendor_items)
    {
        if($this->db->insert('vendor_items',$vendor_items))    
        {   
             return 1;    
        }    
        else    
        {    
            return 0;    
        }
    }
    public function DeleteItem($itemid)
	{
		$this->db->where("item_id",$itemid);
        if($this->db->delete("items"))
        {
            return 1;
        }
        else{
            return 0;
        }
    }
   
    public function GetAreaFromCity($cityid)
    {
        $this->db->select('*');
        $this->db->from('area');
        $this->db->where('city_id',$cityid);
        $query = $this->db->get();
        return $query->result();      
    }
    
    public function EditCheckCategoryExistForCity($vid,$cityid,$catid)
    {
        $condition = "vid !=". $vid . " AND " ."city_id =". $cityid . " AND " . "business_category =" . "'" . $catid . "'";
        $this->db->where($condition);
        $query = $this->db->get('vendor');
        if ($query->num_rows() > 0){
            return 'false';
        }
        else{
            return 'true';
        }
    } 
   
   
    public function GetDeliveryBoy()
    {
        $this->db->select('*');
        $this->db->from('delivery_boy');
        //$this->db->where('verified',1);
        $this->db->order_by('del_id','desc');
        $query = $this->db->get();
        return $query->result();       
    }
   
    //Notification
    public function Getnoticount($Vid)    {

        $data= array(
            'NewOrdersNoti' => $this->GetNewOrderCountNoti($Vid),
            'NewVendorsNoti' => $this->GetNewVendorCountNoti(),
            'NewItemsNoti' => $this->GetNewItemsCountNoti(),
            'RejectedOrderNoti' => $this->GetRejectedOrderNoti(),
            'CompletedOrderNoti' => $this->GetCompletedOrderNoti($Vid)                 
        ); 
        return $data;
    }  
    private function GetNewOrderCountNoti($Vid)
    {
        $condition = "orders.status=1 AND items.vid=$Vid";
        $this->db->select('count(*) as NewOrdersNoti');
        $this->db->from('orders');     
        $this->db->join('user','user.uid =orders.uid');
        $this->db->join('vendor_items','find_in_set(vendor_items.vi_id, orders.vi_id)'); 
        $this->db->join('items','items.item_id=vendor_items.item_id'); 
        //$this->db->where('items.vid',$Vid); 
        $this->db->where($condition); 
        $this->db->group_by('orders.order_id');
        $query = $this->db->get();
        $tmpArray = $query->result_array();
        $this->data = array_shift($tmpArray);
        return $this->data["NewOrdersNoti"]; 
    }
   /* public function   GetNewOrderDataNoti()    
    {    
        $condition = "orders.Evnoti = 0";     
        $this->db->select('products.Name as pname,products.SKU_Code,products.Mrp,products.Shiptime,products.Brand_Name,products.Mainimage,products.Selling_Price,products.Color,orders.Oid,orders.Uid,orders.US_aid,orders.Orderid,orders.Status,orders.Date,orders.Payment_type,orders.Total,orders.Qty,orders.Shipping,products.Selling_Price,products.Shipping_charges,    
        user.Name,user.Mob_no,useraddress.Address,useraddress.Name as shipname,useraddress.Email as shipemail,useraddress.mobile as shipmob,vendor.Name as VName,vendor.Emailid as VEmailid,vendor.Mobileno as VMobileno,vendor.BusinessName as VBusinessName,orders.DeliveredDate');    
        $this->db->from('orders');    
        $this->db->join('products','products.Pid = orders.Pid');    
        $this->db->join('vendor','vendor.Veid = products.vid');    
        $this->db->join('user','user.Uid = orders.Uid');    
        $this->db->join('useraddress','useraddress.US_aid = orders.US_aid');    
        $this->db->join('return_order','return_order.Oid <> orders.Oid');        
        $this->db->where('orders.Status !=', 'Completed');        
        $this->db->where('orders.Status !=', 'Failed');    
        $this->db->where('orders.Status !=', 'PS_aid');    
        $this->db->where($condition);    
        $query = $this->db->get();    
        return $query->result();
    
    }   */
    private function GetNewVendorCountNoti()
    {
        //$condition = "vendor.anoti = 0";
        $this->db->select('count(*) as NewVendorsNoti');
        $this->db->from('vendor');
        $this->db->join('city','city.city_id=vendor.city_id');
        $this->db->join('area','area.area_id=vendor.area_id');
        //$this->db->where($condition);
        $this->db->where('vendor.verified',0);
        $query = $this->db->get();
        $tmpArray = $query->result_array();
        $this->data = array_shift($tmpArray);
        return $this->data["NewVendorsNoti"];
    }     
    public function GetNewVendorsDataNoti()
    {
       // $condition = "vendor.anoti = 0";
        $this->db->select('*,city.city_name,area.area_name');
        $this->db->from('vendor');
        $this->db->join('city','city.city_id=vendor.city_id','left');
        $this->db->join('area','area.area_id=vendor.area_id','left');
        $this->db->where('vendor.verified',0);
          //$this->db->where($condition);
        $query = $this->db->get();
        return $query->result();       
    }
    private function GetNewItemsCountNoti()
    {
       // $condition = "items.anoti = 0";
        $this->db->select('count(*) as NewItemsNoti');
        $this->db->from('items');
        $this->db->join('vendor','vendor.vid = items.vid','left');
        $this->db->join('filters','filters.filt_id = items.f_id','left');
        $this->db->join('sub_category','sub_category.sub_cat_id = filters.sub_cat_id','left');
        $this->db->join('category','category.cat_id = sub_category.cat_id','left');
        $this->db->where('items.verified',0);
        //$this->db->where($condition);
        $query = $this->db->get();
        $tmpArray = $query->result_array();
        $this->data = array_shift($tmpArray);
        return $this->data["NewItemsNoti"];
    }
    public function GetNewItemsDataNoti()
    {
        //$condition = "items.anoti = 0";
        $this->db->select('items.item_id,items.item_name,items.description,items.verified,items.block,vendor.name,vendor.shop_name,vendor.address,vendor.mobile_no,sub_category.sub_cat_name,category.category_name,filters.filt_name');
        $this->db->from('items');
        $this->db->join('vendor','vendor.vid = items.vid','left');
        $this->db->join('filters','filters.filt_id = items.f_id','left');
        $this->db->join('sub_category','sub_category.sub_cat_id = filters.sub_cat_id','left');
        $this->db->join('category','category.cat_id = sub_category.cat_id','left');
        $this->db->where('items.verified',0);
       // $this->db->where($condition);
        $query = $this->db->get();
        return $query->result();
    }
    private function GetRejectedOrderNoti()
    {
        $this->db->select('count(*) as RejectedOrderNoti');
        $this->db->from('orders');     
        $this->db->join('user_address','user_address.user_add_id=orders.user_add_id');
        $this->db->join('city','city.city_id=user_address.city_id');
        $this->db->join('area','area.area_id=user_address.area_id');
        $this->db->join('user','user.uid =orders.uid ');
        $this->db->join('delivery_boy','delivery_boy.del_id=orders.assigndeliveryboy','left'); 
        $this->db->join('paymentmode','paymentmode.pmid=orders.paymentmodeid'); 
        $this->db->where('orders.status',6);
        $query = $this->db->get();
        $tmpArray = $query->result_array();
        $this->data = array_shift($tmpArray);
        return $this->data["RejectedOrderNoti"];      
    }
    private function GetCompletedOrderNoti($Vid)
    {
       /* $this->db->select('count(*) as CompletedOrderNoti');
        $this->db->from('orders');     
        $this->db->join('user_address','user_address.user_add_id=orders.user_add_id');
        $this->db->join('city','city.city_id=user_address.city_id');
        $this->db->join('area','area.area_id=user_address.area_id');
        $this->db->join('user','user.uid =orders.uid ');
        $this->db->join('delivery_boy','delivery_boy.del_id=orders.assigndeliveryboy','left'); 
        $this->db->join('paymentmode','paymentmode.pmid=orders.paymentmodeid'); 
        $this->db->where('orders.status',5);
        $query = $this->db->get();
        $tmpArray = $query->result_array();
        $this->data = array_shift($tmpArray);
        return $this->data["CompletedOrderNoti"];  */
        
        $condition = "orders.status=5 AND items.vid=$Vid";
        $this->db->select('*');
        $this->db->from('orders');     
        $this->db->join('user','user.uid =orders.uid');
        $this->db->join('vendor_items','find_in_set(vendor_items.vi_id, orders.vi_id)'); 
        $this->db->join('items','items.item_id=vendor_items.item_id'); 
        //$this->db->where('items.vid',$Vid); 
        $this->db->where($condition); 
        $this->db->group_by('orders.order_id');
        $query = $this->db->get();
        $tmpArray = $query->result_array();
        $this->data["CompletedOrderNoti"] = count($tmpArray);
        return $this->data["CompletedOrderNoti"]; 
    }
   /* public function setcheckitemsnoti($anoti)    
    {    
        if($this->db->update('items', $anoti))    
        {    
            return 1;    
        }    
        else    
        {
        return 0;    
        }  
    }    */
    public function GetVendorPaymentDetails()    
    {    
       $this->db->select('vendor.name as VName,vendor.mobile_no as VMobileno,vendor_bill.Vbid,vendor_bill.Amount,vendor_bill.Billdate,,vendor_bill.Status');    
       $this->db->from('vendor_bill');    
       $this->db->join('vendor','vendor.vid = vendor_bill.Vid');    
       $query = $this->db->get();    
       return $query->result();
    
    }
    public function ChangePaymentStatus($vbid,$statusvalue)    
    {   
        $this->db->where('Vbid', $vbid);    
        if($this->db->update('vendor_bill',$statusvalue))    
        {
            return 1;    
        }    
        else    
        {    
            return 0;    
        }    
    }
   
    public function AddVendorPayment($data)   
    {
        if($this->db->insert('vendor_bill',$data))    
        {    
            return 1;    
        }    
        else    
        {    
            return 0;    
        }
    }
    public function GetSubAdminCity($S_aid)
    {
        $this->db->select('*');
        $this->db->from('sub_admin');
        $this->db->where('sub_admin.sub_admin_id',$S_aid);
        $query = $this->db->get();
        $result = $query->result(); 
        $scityid = $result[0]->city_id;  
        return $scityid;   
    }
    public function GetOrders($s_cityid)
    {
        $this->db->select('orders.reject_reson,orders.order_id,orders.user_add_id,orders.uid,orders.vi_id,orders.qty,orders.total,orders.discount,orders.status,orders.date,orders.timeslot,orders.deliverydate,paymentmode.Paymentname,orders.invoiceno,orders.walletpay,
        user_address.address,area.area_name,city.city_name,user.mobile_no,delivery_boy.name as dname,delivery_boy.mobile_no as dmobile_no');
        $this->db->from('orders');            
        $this->db->join('user_address','user_address.user_add_id=orders.user_add_id','left');
        $this->db->join('city','city.city_id=user_address.city_id','left');              
        $this->db->join('area','area.area_id=user_address.area_id','left');
        $this->db->join('user','user.uid =orders.uid ');
        //$this->db->join('vendor_items','vendor_items.vi_id=orders.vi_id'); 
        //$this->db->join('items','items.item_id=vendor_items.item_id'); 
        //$this->db->join('vendor','vendor.vid=items.vid'); 
        $this->db->join('delivery_boy','delivery_boy.del_id=orders.assigndeliveryboy','left'); 
        $this->db->join('paymentmode','paymentmode.pmid=orders.paymentmodeid','left'); 
        $this->db->where('orders.status',5); 
        $this->db->where('city.city_id',$s_cityid);         
        $this->db->order_by('orders.order_id','desc'); 
        $query = $this->db->get();
        return $query->result();       
    }
    public function GetUserDetails($orderid)
    {
        $this->db->select('orders.order_id,orders.user_add_id,orders.uid,orders.vi_id,orders.qty,orders.total,orders.discount,orders.status,orders.date,orders.deliverydate,orders.timeslot,orders.deliverydate,paymentmode.Paymentname,orders.invoiceno,orders.walletpay,
        user_address.address as uaddress,area.area_name,city.city_name,user.mobile_no as umobile,user.email as uemail,user.name as uname,delivery_boy.name as dname,delivery_boy.mobile_no as dmobile_no,group_concat(items.item_name  SEPARATOR "/") as iname,group_concat(vendor_items.qtyprice SEPARATOR "/") as iprice,group_concat(concat(vendor.name, ":", vendor.shop_name, ":", vendor.address, ":", vendor.mobile_no) SEPARATOR "/") as vname');
        $this->db->from('orders');     
        $this->db->join('user_address','user_address.user_add_id=orders.user_add_id','left');
        $this->db->join('city','city.city_id=user_address.city_id','left');
        $this->db->join('area','area.area_id=user_address.area_id','left');
        $this->db->join('user','user.uid =orders.uid');
        $this->db->join('vendor_items','find_in_set(vendor_items.vi_id, orders.vi_id)'); 
        $this->db->join('items','items.item_id=vendor_items.item_id'); 
        $this->db->join('vendor','vendor.vid=items.vid'); 
        $this->db->join('delivery_boy','delivery_boy.del_id=orders.assigndeliveryboy','left'); 
        $this->db->join('paymentmode','paymentmode.pmid=orders.paymentmodeid','left'); 
        $this->db->where('orders.order_id', $orderid);
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->result();

    }
    public function ChangeOrderStatus($oid,$statusvalue)
    {
        $this->db->where('order_id', $oid);
        if($this->db->update("orders",$statusvalue))
        {
            return 1;
        }
        else{
            return 0;
        }
    }
    public function GetUsers()
    {
        $this->db->select('*');
        $this->db->from('user');
        $this->db->where('verified','1');
        $query = $this->db->get();
        return $query->result();
    }
    public function GetUserWallet()
    {
        $this->db->select('user_wallet.user_wallet_id,user_wallet.uid,user_wallet.wallet,user_wallet.created_at,user_wallet.created_at,user_wallet.updated_at,user_wallet.updated_by_admin,user_wallet.updated_by_subadmin,user_wallet.updated_by_vendor,
        user.name as uname,user.wallet_money,user.mobile_no,user.email,
        admin.name as aname,sub_admin.sub_admin_name as sname');
        $this->db->from('user');
        $this->db->join('user_wallet','user_wallet.uid=user.uid'); 
        $this->db->join('admin','admin.a_id=user_wallet.updated_by_admin','left'); 
        $this->db->join('sub_admin','sub_admin.sub_admin_id=user_wallet.updated_by_subadmin','left'); 
        $this->db->where('user.verified','1');
        $this->db->order_by('user_wallet.user_wallet_id','desc');        
        $query = $this->db->get();
        return $query->result();
    }
    public function UpdateUserWalletMoney($uid)
	{
        $this->db->select('SUM(wallet) as total_wallet_money');
        $this->db->from('user_wallet');
        $this->db->where('uid',$uid);
        $query = $this->db->get();
        $result = $query->result();
        //print_r($result[0]->total_wallet_money);exit;
        $data = array(
            'wallet_money'=> $result[0]->total_wallet_money,
        ); 
        $this->db->where('uid', $uid);
        if($this->db->update("user",$data))
        {
            return 1;
        }
        else{
            return 0;
        }
    }
    public function GetUserWalletDetails($uid)
    {
        $this->db->select('*');
        $this->db->from('user_wallet');
        $this->db->where('uid',$uid);
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->result();
    }  
    public function AddUserWallet($data)
    {
        if($this->db->insert("user_wallet",$data))
        {
            return 1;
        }
        else{
            return 0;
        }
    }
    public function UpdateUserWallet($user_wallet_id,$data)
    {
        $this->db->where('user_wallet_id', $user_wallet_id);
        if($this->db->update("user_wallet",$data))
        {
            return 1;
        }
        else{
            return 0;
        }
    }
    public function DeleteUserWallet($UserWalletid)
	{
		$this->db->where("user_wallet_id",$UserWalletid);
        if($this->db->delete("user_wallet"))
        {
            return 1;
        }
        else{
            return 0;
        }
    }
    //Autocomplete City Name
    public function SelectCityName($term)
    {
        $this->db->select('city_name as value');
        $this->db->from('city');
        $this->db->like('city_name', $term);
        $this->db->limit(10);
        $query = $this->db->get();

        return $query->result();
    }   
    public function GetCurrentOrderDetails($vid)
    {
        $condition = "orders.status >0 and orders.status <3 AND items.vid=$vid";
         $this->db->select('group_concat(vendor_items.vi_id) as vendoritem,orders.updateattempt,orders.order_id,orders.user_add_id,orders.uid,orders.vi_id,orders.qty,orders.total,orders.discount,orders.status,orders.date,orders.timeslot,orders.deliverydate,paymentmode.Paymentname,orders.invoiceno,orders.walletpay,
        user_address.address,area.area_name,city.city_name,user.mobile_no,delivery_boy.name as dname,delivery_boy.mobile_no as dmobile_no,
        group_concat(vendor_items.stock) as istock, group_concat(items.item_name) as iname, group_concat(vendor_items.qtyprice) as iprice');
        $this->db->from('orders');     
        $this->db->join('user_address','user_address.user_add_id=orders.user_add_id','left');
        $this->db->join('city','city.city_id=user_address.city_id','left');
        $this->db->join('area','area.area_id=user_address.area_id','left');
        $this->db->join('user','user.uid =orders.uid');
        $this->db->join('vendor_items','find_in_set(vendor_items.vi_id, orders.vi_id)','left'); 
        $this->db->join('items','items.item_id=vendor_items.item_id'); 
       $this->db->join('vendor','vendor.vid=items.vid'); 
        $this->db->join('delivery_boy','delivery_boy.del_id=orders.assigndeliveryboy','left'); 
        $this->db->join('paymentmode','paymentmode.pmid=orders.paymentmodeid','left'); 
        $this->db->group_by('orders.order_id');
        $this->db->where($condition);       
        $query = $this->db->get();
      // print_r($this->db->last_query());exit;
        return $query->result();       
    }
    
    public function GetCityStatusWiseOrders($city,$orderstatus)
    {
        $condition = "orders.status =". $orderstatus . " AND " . "city.city_name =" . "'" . $city . "'";
        $this->db->select('orders.order_id,orders.user_add_id,orders.uid,orders.vi_id,orders.qty,orders.total,orders.discount,orders.status,orders.date,orders.timeslot,orders.deliverydate,paymentmode.Paymentname,orders.invoiceno,orders.walletpay,
        user_address.address,area.area_name,city.city_name,user.mobile_no,delivery_boy.name as dname,delivery_boy.mobile_no as dmobile_no');
        $this->db->from('orders');     
        $this->db->join('user_address','user_address.user_add_id=orders.user_add_id');
        $this->db->join('city','city.city_id=user_address.city_id','left');
        $this->db->join('area','area.area_id=user_address.area_id','left');
        $this->db->join('user','user.uid =orders.uid ','left');
        $this->db->join('delivery_boy','delivery_boy.del_id=orders.assigndeliveryboy','left'); 
        $this->db->join('paymentmode','paymentmode.pmid=orders.paymentmodeid','left'); 
        $this->db->where($condition);
        $query = $this->db->get();
        return $query->result();       
    }
    public function GetRejectedOrders()
    {
        $this->db->select('orders.reject_reson,orders.order_id,orders.user_add_id,orders.uid,orders.vi_id,orders.qty,orders.total,orders.discount,orders.status,orders.date,orders.timeslot,orders.deliverydate,paymentmode.Paymentname,orders.invoiceno,orders.walletpay,
        user_address.address,area.area_name,city.city_name,user.mobile_no,delivery_boy.name as dname,delivery_boy.mobile_no as dmobile_no');
        $this->db->from('orders');     
        $this->db->join('user_address','user_address.user_add_id=orders.user_add_id');
        $this->db->join('city','city.city_id=user_address.city_id');
        $this->db->join('area','area.area_id=user_address.area_id');
        $this->db->join('user','user.uid =orders.uid ');
        $this->db->join('delivery_boy','delivery_boy.del_id=orders.assigndeliveryboy','left'); 
        $this->db->join('paymentmode','paymentmode.pmid=orders.paymentmodeid'); 
        $this->db->where('orders.status',6);
        $query = $this->db->get();
        return $query->result();       
    }
    public function CheckDelBoyAvailability($delid)
    {
        $condition = "assigndeliveryboy =". $delid . " AND " ."status >0  AND status <3";
        $this->db->where($condition);
        $query = $this->db->get('orders');  
       
         if ($query->num_rows() > 0){
            return 'false';
        }
        else{
            return 'true';
        }
    }
    public function UpdateOrderByVendor($oid,$data)
    {
        $this->db->where('order_id', $oid);
        if($this->db->update("orders",$data))
        {
            return 1;
        }
        else{
            return 0;
        }
    }
}

?>
