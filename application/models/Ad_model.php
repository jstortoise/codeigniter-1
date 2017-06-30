<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Ad_Model extends CI_Model
{


    public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
        $this->load->database();
    }

    public function insert_ad($data)
    {
        $this->delete_old_ads();
        $this->db->insert('ads', $data);
    }

    public function get_latest_10_ad()
    {
        $this->db->select(['ad_title', 'ad_description', 'ad_url'])->where(['member_id' => $this->session->userdata('user_id')])->order_by('id', 'DESC')->limit(10, 0);
        $query = $this->db->get('ads');
        return $query->result_array();
    }

    public function getAllAds(){
        $this->db->select(['ad_title', 'ad_description', 'ad_url'])->order_by('created_at', 'DESC');
        $query = $this->db->get('ads');
        return $query->result_array();
    }

    public function pointsForAd()
    {
        $sql = "SELECT `value` FROM setting WHERE `key` = 'ad' LIMIT 1;";
        $results = $this->db->query($sql)->result_array();
        if (!empty($results)) {
            return $results[0]['value'];
        }
        return false;
    }

    private function delete_old_ads()
    {
        $this->db->select('id')->from('ads')->where(['member_id' => $this->session->userdata('user_id')])->limit(999999999, 9)->order_by('created_at', 'DESC');
        $query = $this->db->get();

        if ($res = $query->result()) {
            $del = [];
            foreach ($res as $r) {
                array_push($del, $r->id);
            }
            $this->db->where_in('id', $del);
            $this->db->delete('ads');
        }
    }
}
