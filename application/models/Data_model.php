<?php
 
class Data_model extends CI_Model {
 
    /**
     * @desc load  db
     */
    function __construct() {
        parent::__Construct();
        $this->db = $this->load->database('default', TRUE, TRUE);
    }
 
    /**
     * @desc: Get data from company_performance table
     * @return: Array()
     */
    function getdata(){
        $this->db->select('*');
        $query = $this->db->get('company_performance');
        return $query->result_array();
 
    }
    
}