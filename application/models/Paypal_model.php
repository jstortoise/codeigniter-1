<?php  if(!defined('BASEPATH')) exit('No direct script access allowed');
class Paypal_model extends CI_Model
{


    public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
        $this->load->database();
    }
    Public function get_setting(){
        $this->db->select('*');
        $query=$this->db->get_where('paypal_setting',['id'=>1]);
        return $query->result_array();
    }
    Public function get_point_price(){
        $this->db->select('*');
       $this->db->order_by('price','ASC');
        $query=  $this->db->get('point_price');

        return $query->result_array();
    }
    Public function insert_payments($data){
        $this->db->insert('payments',$data);
        return $this->db->insert_id();
    }
    Public function update_points($id,$points){
        $this->db->query("update members set points =points+$points where id =$id");
    }
    Public function get_point_price_by_id($id){
        $this->db->select('*');
        $query=$this->db->get_where('point_price',['id'=>$id]);
        return $query->result_array();
    }
}
