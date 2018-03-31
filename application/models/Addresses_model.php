<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

Class Addresses_model extends CI_Model {

	public function getAllAddresses() {

		try {
			
			$this->db->select('addr.*, ar.*, ct.*');
            $this->db->from('user_address addr');
            $this->db->join('area ar', 'ar.area_id = addr.area_id', 'LEFT');
            $this->db->join('city ct', 'ct.city_id = addr.city_id', 'LEFT');
			
			$query = $this->db->get();
			return $query->result_array();

		} catch (Exception $e) {
			return $e;
		}
	}


	public function getAddressByUserId($user_id) {

		try {
			
			if(isset($user_id) && !empty($user_id)) {

				$this->db->select('addr.*, ar.*, ct.*');
	            $this->db->from('user_address addr');
	            $this->db->join('area ar', 'ar.area_id = addr.area_id', 'LEFT');
				$this->db->join('city ct', 'ct.city_id = addr.city_id', 'LEFT');
				// $this->db->join('user_cart uc', 'uc.uid = addr.uid', 'LEFT');
				$this->db->where('addr.uid', $user_id);
				$this->db->where('addr.user_add_id', 1);			
				$this->db->group_by('addr.uid');
				$query = $this->db->get();


				// echo  $this->db->last_query(); die;
				return $query->result_array();

			} else {
				return false;
			}

		} catch (Exception $e) {
			return $e;
		}
	}

	public function getCartByUserId($user_id) {

		try {
			
			if(isset($user_id) && !empty($user_id)) {
				$this->db->select('SUM(user_cart.total) as pricetotal,COUNT(user_cart.user_cart_id) as itemcount');
				$this->db->from('user_cart');
				$this->db->where('user_cart.uid', $user_id);
				$query = $this->db->get();
				//$result = $query->result(); 
				//$cart_data = $result[0]->cart_data_array; 
				// echo  $this->db->last_query(); die;
				return $query->result_array();
				//return $cart_data;
			}
		} catch (Exception $e) {
			return $e;
		}
	}


}
