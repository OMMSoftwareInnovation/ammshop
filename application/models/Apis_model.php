<?php

Class Apis_model extends CI_Model {
    
    public function GetCategories()
    {
        $this->db->select('*');
        $this->db->from('category');
        $this->db->limit(20);
        $query = $this->db->get();

        $return = array();
        $i = 0;
        foreach($query->result() as $row)
        {
            $return[$i] = $row;
            $return[$i]->category_image	 = Base_url().$return[$i]->category_image; 
            $i++;
        }
        return $return;
    }

    public function GetSubCategories($catid)
    {
        $condition = "cat_id = ".$catid;
        
        $this->db->select('*');
        $this->db->from('subcategory');
        $this->db->where($condition);
        $query = $this->db->get();

        $return = array();
        $i = 0;
        foreach($query->result() as $row)
        {
            $return[$i] = $row;
            $return[$i]->subcat_image = Base_url().$return[$i]->subcat_image; 
            $i++;
        }
        return $return;
    }
    
    public function GetBanners()
    {   
        $this->db->select('banimage,vid');
        $this->db->from('banners');
        $query = $this->db->get();

        $return = array();
        $i = 0;
        foreach($query->result() as $row)
        {
            $return[$i] = $row;
            $return[$i]->banimage = Base_url().$return[$i]->banimage; 
            $i++;
        }
        return $return;
    }

    public function GetUsersCheck($user)
    {
        $condition = "mobile_no = '".$user['mobile_no']."' and email='".$user['email']."'";

        $this->db->where($condition);
        $query = $this->db->get('user');
        if ($query->num_rows() > 0){
            return true;
        }
        else{
            return false;
        }
    }

    public function UpdateUser($user)
    {
        $condition = "mobile_no = '".$user['mobile_no']."' and email='".$user['email']."'";
        $this->db->where($condition);
        if($this->db->update('user',$user))
        {
            return 1;
        }
        else
        {
            return 0;
        }
    }

    public function AddUser($user)
    {
        if($this->db->insert("user",$user))
        {
            return 1;
        }
        else{
            return 0;
        }
    }

    public function GetUserbyid($user)
    {
        $condition = "mobile_no = '".$user['mobile_no']."' and email='".$user['email']."'";
        $this->db->select('uid');
        $this->db->from('user');
        $this->db->where($condition);
        $query = $this->db->get();

        return $query->row()->uid;
    }

    public function GetAccountCheck($OTP)
    {
        $condition = "verno='".$OTP['verno']."'";

        $this->db->where($condition);
        $query = $this->db->get('user');
        if ($query->num_rows() > 0){
            return true;
        }
        else{
            return false;
        }
    }

    public function UpdateVerified($OTP)
    {
        $condition = "uid = ".$OTP['uid']." and verno='".$OTP['verno']."'";
        $this->db->where($condition);
        if($this->db->update('user',$OTP))
        {
            return 1;
        }
        else
        {
            return 0;
        }
    }

    public function GetUserdatabyId($uid)
    {
        $condition = "uid = ".$uid;
        $this->db->select('*');
        $this->db->from('user');
        $this->db->where($condition);
        $query = $this->db->get();
        return $query->result();
    }
}

?>