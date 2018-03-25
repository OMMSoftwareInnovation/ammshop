<?php

Class SubAdmin_model extends CI_Model {

    public function login($data) 
    {
        $condition = "email =" . "'" . $data['email'] . "' AND " . "password =" . "'" . $data['password'] . "'";
        $this->db->select('*');
        $this->db->from('sub_admin');
        $this->db->where($condition);
        $this->db->limit(1);
        $query = $this->db->get();

        if ($query->num_rows() == 1) {
            return true;
        } else {
            return false;
        }
    }  
    // Read data from database to show data in sub_admin page
    public function read_SubAdmin_information($email) {

        $condition = "email =" . "'" . $email . "'";
        $this->db->select('*');
        $this->db->from('sub_admin');
        $this->db->where($condition);
        $this->db->limit(1);
        $query = $this->db->get();

        if ($query->num_rows() == 1) {
        return $query->result();
        } else {
        return false;
        }
    }
    public function CheckPassword($S_aid,$pwd)
    {
        $condition = "sub_admin_id =". $S_aid . " AND " . "password =" . "'" . $pwd . "'";
        $this->db->where($condition);
        $query = $this->db->get('sub_admin');
        if ($query->num_rows() > 0){
            return 'true';
        }
        else{
            return 'false';
        }
    }
    //Update password
    public function UpdatePassword($password,$S_aid)
    {
        $this->db->where('sub_admin_id', $S_aid);
            if($this->db->update('sub_admin',$password))
            {
                return 1;
            }
            else
            {
                return 0;
            }
    }
    public function Checkemail($email)
    {
        $this->db->where('email', $email);
        $query = $this->db->get('sub_admin');
        if ($query->num_rows() > 0){
            return 1;
        }
        else{
            return 0;
        }
    }
    public function getpassword($email) 
    {
        
        $condition = "email =" . "'" . $email . "'";
        $this->db->select('password');
        $this->db->from('sub_admin');
        $this->db->where($condition);
        $this->db->limit(1);
        $query = $this->db->get();

        if ($query->num_rows() == 1) {
        return $query->result();
        } else {
        return false;
        }
    }
    public function GetCities() 
    {
        $this->db->select('*');
        $this->db->from('city');
        $query = $this->db->get();
        return $query->result();       
    }
    public function CheckCity($city)
    {
        $condition = "city_name =" . "'" . $city . "'";
        $this->db->where($condition);
        $query = $this->db->get('city');
        if ($query->num_rows() > 0){
            return 'false';
        }
        else{
            return 'true';
        }
    }
    public function AddCity($city)
    {
        if($this->db->insert('city',$city))
        {
            return 1;
        }
        else
        {
            return 0;
        }
    }
    public function EditCheckCity($cityid,$city)
    {
        $condition = "city_id !=". $cityid . " AND " . "city_name =" . "'" . $city . "'";
        $this->db->where($condition);
        $query = $this->db->get('city');
        if ($query->num_rows() > 0){
            return 'false';
        }
        else{
            return 'true';
        }
    }
    public function UpdateCity($cityid,$data)
    {
        $this->db->where('city_id', $cityid);
            if($this->db->update('city',$data))
            {
                return 1;
            }
            else
            {
                return 0;
            }
    }
    public function chkcitypresent($cityid)
    {
        $condition = "city_id =" . "'" . $cityid . "'";
        $this->db->where($condition);
        $query = $this->db->get('vendor');

        $this->db->where($condition);
        $query1 = $this->db->get('area');

        $this->db->where($condition);
        $query2 = $this->db->get('user_address');

        if ($query->num_rows() > 0 || $query1 ->num_rows() > 0 || $query2 ->num_rows() > 0){
            return 1;
        }
        else{
            return 0;
        }
    }
    public function DeleteCity($cityid)
	{
		$this->db->where("city_id",$cityid);
        if($this->db->delete("city"))
        {
            return 1;
        }
        else{
            return 0;
        }
    }
    public function GetAreas() 
    {
        $this->db->select('area.area_id,area.city_id,area.area_name,city.city_name');
        $this->db->from('area');
        $this->db->join('city','city.city_id = area.city_id');
        $query = $this->db->get();
        return $query->result();       
    }
    public function CheckArea($cityid,$area)
    {
        $condition = "city_id =". $cityid . " AND " . "area_name =" . "'" . $area . "'";
        $this->db->where($condition);
        $query = $this->db->get('area');
        if ($query->num_rows() > 0){
            return 'false';
        }
        else{
            return 'true';
        }
    }    
    public function AddArea($area)
    {
        if($this->db->insert('area',$area))
        {
            return 1;
        }
        else
        {
            return 0;
        }
    }
    //Dashboard
    public function getdashboard()    
    {
        $data= array(
            'VendorCount' => $this->GetVendorCount(),
            'UserCount' => $this->GeUserCount(),
            'DeliveryBoyCount' => $this->GeDeliveryBoyCount()
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
    private function GeUserCount()
    {
        $this->db->select('count(*) as UserCount');
        $this->db->from('user');
        //$this->db->where('verified','1');
        $query = $this->db->get();
        $tmpArray = $query->result_array();
        $this->data = array_shift($tmpArray);

        return $this->data["UserCount"];

    }
    private function GeDeliveryBoyCount()
    {
        $this->db->select('count(*) as DeliveryBoyCount');
        $this->db->from('delivery_boy');
        //$this->db->where('verified','1');
        $query = $this->db->get();
        $tmpArray = $query->result_array();
        $this->data = array_shift($tmpArray);

        return $this->data["DeliveryBoyCount"];

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
    public function CheckCategory($catname)
    {
        $condition = "category_name =" . "'" . $catname . "'";
        $this->db->where($condition);
        $query = $this->db->get('category');

        if ($query->num_rows() > 0){
            return 'false';
        }
        else{
            return 'true';
        }
    }
    public function AddCategory($Category)
    {
        if($this->db->insert('category',$Category))
        {
            return 1;
        }
        else
        {
            return 0;
        }
    }    
    public function EditCheckCategory($catid,$catname)
    {
        $condition = "cat_id !=". $catid . " AND " . "category_name =" . "'" . $catname . "'";
        $this->db->where($condition);
        $query = $this->db->get('category');
        if ($query->num_rows() > 0){
            return 'false';
        }
        else{
            return 'true';
        }
    }
    public function UpdateCategory($catid,$Category)
    {
        $this->db->where('cat_id', $catid);
        if($this->db->update('category',$Category))
        {
            return 1;
        }
        else
        {
            return 0;
        }
    } 
    public function chkcategorypresent($catid)
    {
        $condition = "cat_id =" . "'" . $catid . "'";
        $this->db->where($condition);
        $query = $this->db->get('sub_category');   

        if ($query->num_rows() > 0){
            return 1;
        }
        else{
            return 0;
        }
    }
    public function DeleteCategory($catid)
	{
		$this->db->where("cat_id",$catid);
        if($this->db->delete("category"))
        {
            return 1;
        }
        else{
            return 0;
        }
    } 
    public function GetSubCategory() 
    {
        $this->db->select('*,category.category_name');
        $this->db->from('sub_category');
        $this->db->join('category','category.cat_id = sub_category.cat_id');
        $query = $this->db->get();
        return $query->result();       
    }
    public function CheckSubCategory($catid,$subcat)
    {
        $condition = "cat_id =". $catid . " AND " . "sub_cat_name =" . "'" . $subcat . "'";
        $this->db->where($condition);
        $query = $this->db->get('sub_category');
        if ($query->num_rows() > 0){
            return 'false';
        }
        else{
            return 'true';
        }
    }
    public function AddSubCategory($SubCategory)
    {
        if($this->db->insert('sub_category',$SubCategory))
        {
            return 1;
        }
        else
        {
            return 0;
        }
    } 
    public function EditCheckSubCat($subcatid,$catid,$subcat)
    {
        $condition = "sub_cat_id !=". $subcatid . " AND " ."cat_id =". $catid . " AND " . "sub_cat_name =" . "'" . $subcat . "'";
        $this->db->where($condition);
        $query = $this->db->get('sub_category');
        if ($query->num_rows() > 0){
            return 'false';
        }
        else{
            return 'true';
        }
    }
    public function UpdateSubCategory($subcatid,$SubCategory)
    {
        $this->db->where('sub_cat_id', $subcatid);
        if($this->db->update('sub_category',$SubCategory))
        {
            return 1;
        }
        else
        {
            return 0;
        }
    } 
    public function chksubcategorypresent($subcatid)
    {
        $condition = "sub_cat_id =" . "'" . $subcatid . "'";
        $this->db->where($condition);
        $query = $this->db->get('filters');  
        
        $this->db->where($condition);
        $query1 = $this->db->get('qty_type');  

        if ($query->num_rows() > 0 || $query1->num_rows() > 0){
            return 1;
        }
        else{
            return 0;
        }
    }
    public function DeleteSubCategory($subcatid)
	{
		$this->db->where("sub_cat_id",$subcatid);
        if($this->db->delete("sub_category"))
        {
            return 1;
        }
        else{
            return 0;
        }
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
    public function GetSubCategoryFromMainCategory($catid) 
    {
        $this->db->select('*');
        $this->db->from('sub_category');
        $this->db->where('cat_id',$catid);
        $query = $this->db->get();
        return $query->result();       
    }
    public function CheckSubSubCategory($subcatid,$subsubcat)
    {
        $condition = "sub_cat_id =". $subcatid . " AND " . "filt_name =" . "'" . $subsubcat . "'";
        $this->db->where($condition);
        $query = $this->db->get('filters');
        if ($query->num_rows() > 0){
            return 'false';
        }
        else{
            return 'true';
        }
    }
    public function AddSubSubCategory($SubSubCategory)
    {
        if($this->db->insert('filters',$SubSubCategory))
        {
            return 1;
        }
        else
        {
            return 0;
        }
    }    
    public function  EditCheckSubSubCat($subsubcatid,$subcatid,$subsubcat)
    {
        $condition = "filt_id !=". $subsubcatid . " AND " ."sub_cat_id =". $subcatid . " AND " . "filt_name =" . "'" . $subsubcat . "'";
        $this->db->where($condition);
        $query = $this->db->get('filters');
        if ($query->num_rows() > 0){
            return 'false';
        }
        else{
            return 'true';
        }
    }
    public function UpdateSubSubCategory($subsubcatid,$SubSubCategory)
    {
        $this->db->where('filt_id', $subsubcatid);
        if($this->db->update('filters',$SubSubCategory))
        {
            return 1;
        }
        else
        {
            return 0;
        }
    }
    public function chksubsubcategorypresent($subsubcatid)
    {
        $condition = "f_id =" . "'" . $subsubcatid . "'";
        $this->db->where($condition);
        $query = $this->db->get('items'); 

        if ($query->num_rows() > 0){
            return 1;
        }
        else{
            return 0;
        }
    }
    public function DeleteSubSubCategory($subsubcatid)
	{
		$this->db->where("filt_id",$subsubcatid);
        if($this->db->delete("filters"))
        {
            return 1;
        }
        else{
            return 0;
        }
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
    public function AddQuantityType($qtytype)
    {
        if($this->db->insert('qty_type',$qtytype))
        {
            return 1;
        }
        else
        {
            return 0;
        }
    } 
    public function UpdateQuantityType($qtytypeid,$qtytype)   
    {
        $this->db->where('qty_type_id', $qtytypeid);
        if($this->db->update('qty_type',$qtytype))
        {
            return 1;
        }
        else
        {
            return 0;
        }
    } 
    public function chkqtytypepresent($qtytypeid)
    {
        $condition = "qty_type_id =" . "'" . $qtytypeid . "'";
        $this->db->where($condition);
        $query = $this->db->get('qty');  
        
        $condition1 = "qtytype_id =" . "'" . $qtytypeid . "'";
        $this->db->where($condition1);
        $query1 = $this->db->get('vendor_items');  

        if ($query->num_rows() > 0 || $query1->num_rows() > 0){
            return 1;
        }
        else{
            return 0;
        }
    }
    public function DeleteQuantityType($qtytypeid)
	{
		$this->db->where("qty_type_id",$qtytypeid);
        if($this->db->delete("qty_type"))
        {
            return 1;
        }
        else{
            return 0;
        }
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
    public function AddQuantity($qty)
    {
        if($this->db->insert('qty',$qty))
        {
            return 1;
        }
        else
        {
            return 0;
        }
    } 
    public function UpdateQuantity($qtyid,$qty)  
    {
        $this->db->where('qty_id', $qtyid);
        if($this->db->update('qty',$qty))
        {
            return 1;
        }
        else
        {
            return 0;
        }
    }
    public function DeleteQuantity($qtyid) 
	{
		$this->db->where("qty_id",$qtyid);
        if($this->db->delete("qty"))
        {
            return 1;
        }
        else{
            return 0;
        }
    } 
    public function GetItems()
    {
        $this->db->select('items.item_id,items.gst,items.item_name,items.description,items.verified,items.block,vendor.name,vendor.shop_name,vendor.address,vendor.mobile_no,sub_category.sub_cat_name,category.category_name,filters.filt_name');
        $this->db->from('items');
        $this->db->join('vendor','vendor.vid = items.vid');
        $this->db->join('filters','filters.filt_id = items.f_id');
        $this->db->join('sub_category','sub_category.sub_cat_id = filters.sub_cat_id');
        $this->db->join('category','category.cat_id = sub_category.cat_id');
        $this->db->where('items.verified',1);
        $query = $this->db->get();
        return $query->result();       
    } 
    public function GetItemsRequest() 
    {
        $this->db->select('items.item_id,items.gst,items.item_name,items.description,items.verified,items.block,vendor.name,vendor.shop_name,vendor.address,vendor.mobile_no,sub_category.sub_cat_name,category.category_name,filters.filt_name');
        $this->db->from('items');
        $this->db->join('vendor','vendor.vid = items.vid');
        $this->db->join('filters','filters.filt_id = items.f_id');
        $this->db->join('sub_category','sub_category.sub_cat_id = filters.sub_cat_id');
        $this->db->join('category','category.cat_id = sub_category.cat_id');
        $this->db->where('items.verified',0);
        $query = $this->db->get();
        return $query->result();       
    }    
    public function BlockUnblockItem($itemid,$blockunblockvalue)
    {
        $this->db->where('item_id', $itemid);
        if($this->db->update('items', $blockunblockvalue))
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
    public function GetVendorRequest()
    {
        $this->db->select('*,city.city_name,area.area_name');
        $this->db->from('vendor');
        $this->db->join('city','city.city_id=vendor.city_id');
        $this->db->join('area','area.area_id=vendor.area_id');
        $this->db->where('vendor.verified',0);
        $query = $this->db->get();
        return $query->result();       
    }
    public function GetDeliveryBoyRequest()
    {
        $this->db->select('*');
        $this->db->from('delivery_boy');
        $this->db->where('verified',0);
        $query = $this->db->get();
        return $query->result();       
    }     
    public function GetVendor()
    {
        /*$this->db->select('*,group_concat(category.category_name) as cname ,city.city_name,area.area_name From vendor Join city on city.city_id = vendor.city_id Join area on area.area_id = vendor.area_id Join category on find_in_set(category.cat_id,vendor.business_category) where vendor.verified = 1 group by vendor.vid');
        $query = $this->db->get();
        return $query->result();   */
        $this->db->select('*,group_concat(category.category_name) as cname ,city.city_name,area.area_name');
        $this->db->from('vendor');     
         $this->db->join('city','city.city_id=vendor.city_id');
        $this->db->join('area','area.area_id=vendor.area_id');
        $this->db->join('category','find_in_set(category.cat_id, vendor.business_category)');
        $this->db->group_by('vendor.vid');
        $this->db->order_by('vendor.vid','desc');
        //$this->db->where('vendor.verified',1);
        $query = $this->db->get();
        return $query->result();    
    }
    public function BlockUnblockVendor($vendorid,$blockunblockvalue)
    {
        $this->db->where('vid', $vendorid);
        if($this->db->update('vendor', $blockunblockvalue))
        {
            return 1;
        }
        else
        {
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
    public function CheckCategoryExistForCity($cityid,$catid)
    {
        $condition = "city_id =". $cityid . " AND " . "business_category =" . "'" . $catid . "'";
        $this->db->where($condition);
        $query = $this->db->get('vendor');
        if ($query->num_rows() > 0){
            return 'false';
        }
        else{
            return 'true';
        }
    }
    public function AddVendor($vendor)
    {
        if($this->db->insert('vendor',$vendor))
        {
            return 1;
        }
        else
        {
            return 0;
        }
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
    public function UpdateVendor($vid,$vendor)  
    {
        $this->db->where('vid', $vid);
        if($this->db->update('vendor',$vendor))
        {
            return 1;
        }
        else
        {
            return 0;
        }
    }
    public function chkvendorpresent($vid)
    {
        $condition = "vid =" . "'" . $vid . "'";
        $this->db->where($condition);
        $query = $this->db->get('filters');  
        
        $this->db->where($condition);
        $query1 = $this->db->get('items');  

        $this->db->where($condition);
        $query2 = $this->db->get('vendor_rating'); 
         
        $this->db->where($condition);
        $query3 = $this->db->get('venflashoffers'); 

        if ($query->num_rows() > 0 || $query1->num_rows() > 0 || $query2->num_rows() > 0 || $query3->num_rows() > 0){
            return 1;
        }
        else{
            return 0;
        }
    }
    public function DeleteVendor($vendorid)
	{
		$this->db->where("vid",$vendorid);
        if($this->db->delete("vendor"))
        {
            return 1;
        }
        else{
            return 0;
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
    public function CheckMobileNoExistForDeliveryBoy($mobileno)
    {
        $condition = "mobile_no =" . "'" . $mobileno . "'";
        $this->db->where($condition);
        $query = $this->db->get('delivery_boy');  
         if ($query->num_rows() > 0){
            return 'false';
        }
        else{
            return 'true';
        }
    }
    public function AddDeliveryBoy($deliveryboy)
    {
        if($this->db->insert('delivery_boy',$deliveryboy))
        {
            return 1;
        }
        else
        {
            return 0;
        }
    }
    public function EditCheckCheckMobile($did,$mobileno)
    {
        $condition = "del_id !=". $did . " AND " . "mobile_no =" . "'" . $mobileno . "'";
        $this->db->where($condition);
        $query = $this->db->get('delivery_boy');
        if ($query->num_rows() > 0){
            return 'false';
        }
        else{
            return 'true';
        }
    }
    public function UpdateDeliveryBoy($did,$deliveryboy)  
    {
        $this->db->where('del_id', $did);
        if($this->db->update('delivery_boy',$deliveryboy))
        {
            return 1;
        }
        else
        {
            return 0;
        }
    }
    public function BlockUnblockDeliveryBoy($deliveryboyid,$blockunblockvalue)
    {
        $this->db->where('del_id', $deliveryboyid);
        if($this->db->update('delivery_boy', $blockunblockvalue))
        {
            return 1;
        }
        else
        {
            return 0;
        }
    }
    public function chkdeliveryboypresent($did)
    {
        $condition = "did =" . "'" . $did . "'";
        $this->db->where($condition);
        $query = $this->db->get('deliveryboydeliveries');  
        
        $condition = "assigndeliveryboy =" . "'" . $did . "'"; 
        $this->db->where($condition);
        $query1 = $this->db->get('orders');  

        if ($query->num_rows() > 0 || $query1->num_rows() > 0){
            return 1;
        }
        else{
            return 0;
        }
    }
    public function DeleteDeliveryBoy($did)
	{
		$this->db->where("del_id",$did);
        if($this->db->delete("delivery_boy"))
        {
            return 1;
        }
        else{
            return 0;
        }
    }
    public function GetSubsub_admin()
    {
        $this->db->select('*');
        $this->db->from('sub_admin');
        $this->db->where('verified',1);
        $query = $this->db->get();
        return $query->result();       
    }
    public function CheckMobileNoExistForSubsub_admin($mobileno)
    {
        $condition = "mobile_no =" . "'" . $mobileno . "'";
        $this->db->where($condition);
        $query = $this->db->get('sub_admin');  
         if ($query->num_rows() > 0){
            return 'false';
        }
        else{
            return 'true';
        }
    }
    public function AddSubsub_admin($subsub_admin)
    {
        if($this->db->insert('sub_admin',$subsub_admin))
        {
            return 1;
        }
        else
        {
            return 0;
        }
    }
    public function EditCheckMobileNoExistForSubsub_admin($sS_aid,$mobileno)
    {
        $condition = "sub_admin_id !=". $sS_aid . " AND " . "mobile_no =" . "'" . $mobileno . "'";
        $this->db->where($condition);
        $query = $this->db->get('sub_admin');
        if ($query->num_rows() > 0){
            return 'false';
        }
        else{
            return 'true';
        }
    }
    public function UpdateSubsub_admin($sS_aid,$subsub_admin)
    {
        $this->db->where('sub_admin_id', $sS_aid);
        if($this->db->update('sub_admin',$subsub_admin))
        {
            return 1;
        }
        else
        {
            return 0;
        }
    }
    public function DeleteSubsub_admin($sS_aid)
	{
		$this->db->where("sub_admin_id",$sS_aid);
        if($this->db->delete("sub_admin"))
        {
            return 1;
        }
        else{
            return 0;
        }
    }
    public function BlockUnblockSubsub_admin($sS_aid,$blockunblockvalue)
    {
        $this->db->where('sub_admin_id', $sS_aid);
        if($this->db->update('sub_admin', $blockunblockvalue))
        {
            return 1;
        }
        else
        {
            return 0;
        }
    }
    //Notification
    public function Getnoticount()    {

        $data= array(
            'NewOrdersNoti' => $this->GetNewOrderCountNoti(),
            'NewVendorsNoti' => $this->GetNewVendorCountNoti(),
            'NewItemsNoti' => $this->GetNewItemsCountNoti(),
            'RejectedOrderNoti' => $this->GetRejectedOrderNoti(),
            'CompletedOrderNoti' => $this->GetCompletedOrderNoti()                 
        ); 
        return $data;
    }  
    private function GetNewOrderCountNoti()
    {
        $condition = "sanoti = 0";
        $this->db->select('count(*) as NewOrdersNoti');
        $this->db->from('orders');
        $this->db->where('orders.Status =', 1);
        $this->db->where($condition);
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
    private function GetCompletedOrderNoti()
    {
        $this->db->select('count(*) as CompletedOrderNoti');
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
    public function GetVendorFromCity($cityid)
    {
        $this->db->select('vendor.vid,vendor.name,vendor.mobile_no');
        $this->db->from('vendor');
        $this->db->join('city','city.city_id=vendor.city_id');
        $this->db->where('vendor.verified',1);
        $this->db->where('vendor.city_id',$cityid);
        $query = $this->db->get();
        return $query->result();       
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
    public function GetCityWiseOrders($city)
    {
        $condition = "orders.status >0 and orders.status <3";
       /* $this->db->select('orders.order_id,orders.user_add_id,orders.uid,orders.vi_id,orders.qty,orders.total,orders.discount,orders.status,orders.date,orders.timeslot,orders.deliverydate,paymentmode.Paymentname,orders.invoiceno,orders.walletpay,
        user_address.address,area.area_name,city.city_name,user.mobile_no,delivery_boy.name as dname,delivery_boy.mobile_no as dmobile_no');
        $this->db->from('orders');  
        $this->db->join('user_address','user_address.user_add_id=orders.user_add_id');
        $this->db->join('city','city.city_id=user_address.city_id','left');
        $this->db->join('area','area.area_id=user_address.area_id','left');
        $this->db->join('user','user.uid =orders.uid ');
        $this->db->join('delivery_boy','delivery_boy.del_id=orders.assigndeliveryboy','left'); 
        $this->db->join('paymentmode','paymentmode.pmid=orders.paymentmodeid','left'); 
        $this->db->where('city.city_name',$city);
        $this->db->where($condition); */
        
        $this->db->select('orders.updateattempt,orders.order_id,orders.user_add_id,orders.uid,orders.vi_id,orders.qty,orders.total,orders.discount,orders.status,orders.date,orders.timeslot,orders.deliverydate,paymentmode.Paymentname,orders.invoiceno,orders.walletpay,
        user_address.address,area.area_name,city.city_name,user.mobile_no,delivery_boy.name as dname,delivery_boy.mobile_no as dmobile_no,
        group_concat(vendor_items.stock) as istock, group_concat(items.item_name) as iname, group_concat(vendor_items.qtyprice) as iprice');
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
        $this->db->group_by('orders.order_id');
       $this->db->where('city.city_name',$city);
       $this->db->where($condition);
        $query = $this->db->get();
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
    public function GetCouponCode()
    {
        $this->db->select('*');
        $this->db->from('coupon_code');
        $query = $this->db->get();
        return $query->result();
    } 
    public function GetNextCouponId()
    {
        $this->db->select('MAX(coupon_id) as max_id');
        $this->db->from('coupon_code');
        //$this->db->limit(1);
        $query = $this->db->get();
        return $query->result();
    }
    public function AddCouponCodeAmount($data)
    {
        if($this->db->insert("coupon_code",$data))
        {
            return 1;
        }
        else{
            return 0;
        }
    }
    public function UpdateCouponCodeAmount($couponid,$data)
    {
        $this->db->where('coupon_id', $couponid);
        if($this->db->update("coupon_code",$data))
        {
            return 1;
        }
        else{
            return 0;
        }
    }
    public function  chkCouponCodepresent($couponid)
    {
        $condition = "coupon_id =" . "'" . $couponid . "'";
        $this->db->where($condition);
        $query = $this->db->get('orders');        
        if ($query->num_rows() > 0){
            return 1;
        }
        else{
            return 0;
        }
    }
    public function DeleteCouponCode($couponid)
	{
		$this->db->where("coupon_id",$couponid);
        if($this->db->delete("coupon_code"))
        {
            return 1;
        }
        else{
            return 0;
        }
    } 
    public function GetAssignedCoupons()   
    {
        $this->db->select('coupon_code_assigned.ccassign_id,coupon_code_assigned.uid,user.name,user.mobile_no,coupon_code.coupon_id,coupon_code.coupon_code,coupon_code.activate_date,coupon_code.expired_date,coupon_code.shopping_range,coupon_code.discount_amt,coupon_code.discount_amt_type');
        $this->db->from('coupon_code_assigned');
        $this->db->join('coupon_code','coupon_code.coupon_id=coupon_code_assigned.coupon_id');
        $this->db->join('user','user.uid =coupon_code_assigned.uid ');
        $query = $this->db->get();
        return $query->result();
    }
    public function CheckAlreadyUsedCoupen($uid,$couponid)
    {
        $condition = "uid =". $uid . " AND " . "coupon_id =" . "'" . $couponid . "'";
        $this->db->where($condition);
        $query = $this->db->get('coupon_code_assigned');  
         if ($query->num_rows() > 0){
            return 'false';
        }
        else{
            return 'true';
        }
    }
    public function AddAssinedCouponCode($data)
    {
        if($this->db->insert("coupon_code_assigned",$data))
        {
            return 1;
        }
        else{
            return 0;
        }
    }
    public function EditAlreadyUsedCoupen($assignccid,$uid,$couponid)
    {
        $condition = "ccassign_id !=". $assignccid . " AND " ."uid =". $uid . " AND " . "coupon_id =" . "'" . $couponid . "'";
        $this->db->where($condition);
        $query = $this->db->get('coupon_code_assigned');  
         if ($query->num_rows() > 0){
            return 'false';
        }
        else{
            return 'true';
        }
    }   
    public function UpdateAssinedCouponCode($assignccid,$data)
    {
        $this->db->where('ccassign_id', $assignccid);
        if($this->db->update("coupon_code_assigned",$data))
        {
            return 1;
        }
        else{
            return 0;
        }
    }
    public function DeleteAssignedCoupon($assignccid)
	{
		$this->db->where("ccassign_id",$assignccid);
        if($this->db->delete("coupon_code_assigned"))
        {
            return 1;
        }
        else{
            return 0;
        }
    } 
    public function GetVerifiedVendor()
    {
        $this->db->select('*');
        $this->db->from('vendor');
        $this->db->where('verified',1);
        $query = $this->db->get();
        return $query->result();
    }
    public function GetDeliverySlots()   
    {
        $this->db->select('slots_of_delivery.delivery_slot_id,slots_of_delivery.vid,slots_of_delivery.opentime,slots_of_delivery.closetime,slots_of_delivery.created_at,slots_of_delivery.updated_at,slots_of_delivery.status,
        vendor.name,vendor.shop_name,vendor.mobile_no,vendor.address,city.city_name,area.area_name');
        $this->db->from('slots_of_delivery');
        $this->db->join('vendor','vendor.vid=slots_of_delivery.vid');
        $this->db->join('city','city.city_id=vendor.city_id','left');
        $this->db->join('area','area.area_id=vendor.area_id','left');
        $query = $this->db->get();
        return $query->result();
    } 
    public function AddDeliverySlot($data)
    {
        if($this->db->insert("slots_of_delivery",$data))
        {
            return 1;
        }
        else{
            return 0;
        }
    }
    public function UpdateDeliverySlot($deliveryslot_id,$data)
    {
        $this->db->where('delivery_slot_id', $deliveryslot_id);
        if($this->db->update("slots_of_delivery",$data))
        {
            return 1;
        }
        else{
            return 0;
        }
    }
    public function DeleteDeliverySlot($deliveryslot_id)
	{
		$this->db->where("delivery_slot_id",$deliveryslot_id);
        if($this->db->delete("slots_of_delivery"))
        {
            return 1;
        }
        else{
            return 0;
        }
    } 
    public function GetItemDetails($item_id)
    {
        $this->db->select('vendor_items.item_id,vendor_items.qtyprice,vendor_items.stock,vendor_items.discount,items.gst,items.item_name,qty_type.qty_type_name,qty.qty_name');
        $this->db->from('vendor_items');
        $this->db->join('items','items.item_id=vendor_items.item_id');
        $this->db->join('qty_type','qty_type.qty_type_id=vendor_items.qtytype_id','left');
        $this->db->join('qty','qty.qty_id=vendor_items.qty_id','left');
        $this->db->where('vendor_items.item_id',$item_id);
        $query = $this->db->get();
        return $query->result();
    }
    public function GetItem($item_id)
    {
        $this->db->select('*');
        $this->db->from('items');
        $this->db->where('item_id',$item_id);
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->result();
    }
    public function GetSellReport($city,$db_startdate,$db_enddate)
    {     
        $this->db->select('*');
        $this->db->from('orders');
        $this->db->join('user_address','user_address.user_add_id=orders.user_add_id');
        $this->db->join('city','city.city_id=user_address.city_id');
        $this->db->where('city.city_name',$city);
        $this->db->where('orders.status',5);    
        $this->db->where('orders.date>=', $db_startdate);
       $this->db->where('orders.date<=', $db_enddate);
        $query = $this->db->get();
        return $query->result();
    }
    public function GetSellTotalReport($city,$db_startdate,$db_enddate)
    {     
        $this->db->select('SUM(total) as selltotal');
        $this->db->from('orders');
        $this->db->join('user_address','user_address.user_add_id=orders.user_add_id');
        $this->db->join('city','city.city_id=user_address.city_id');
        $this->db->where('city.city_name',$city);
        $this->db->where('orders.status',5);    
        $this->db->where('orders.date>=', $db_startdate);
       $this->db->where('orders.date<=', $db_enddate);
        $query = $this->db->get();
        return $query->result();
    }
    public function UpdateVendorItemStock($viid,$qty,$stock)
    {
        $result = $stock-$qty;
        $data = array(
			'stock'=> $result,
		); 
        
            $this->db->where('vi_id', $viid);
            if($this->db->update("vendor_items",$data))
            {
                return 1;
            }
            else{
                return 0;
            }
    }
    public function UpdateOrderQty($orderid,$qtyid,$total,$updateattempt)
    {
        $data = array(
            'qty'=> $qtyid,
            'total'=> $total,
            'updateattempt'=> $updateattempt,
		); 
        
            $this->db->where('order_id', $orderid);
            if($this->db->update("orders",$data))
            {
                return 1;
            }
            else{
                return 0;
            }
    } 
    public function UpdateOrderBySubAdmin($oid,$data)
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
    public function GetDeliveryMoneyDetails()
    {     
        $this->db->select('*,paymentmode.Paymentname,deliveryboydeliveries.delivered_date,delivery_boy.name,delivery_boy.mobile_no');
        $this->db->from('orders');
        $this->db->join('deliveryboydeliveries','deliveryboydeliveries.orderid=orders.order_id');
        $this->db->join('delivery_boy','delivery_boy.del_id=orders.assigndeliveryboy');
        $this->db->join('paymentmode','paymentmode.pmid=orders.paymentmodeid'); 
        $this->db->where('orders.status',5);
        $query = $this->db->get();
        return $query->result();
    }
}

?>
