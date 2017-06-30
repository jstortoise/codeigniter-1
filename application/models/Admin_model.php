<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Admin_Model extends CI_Model
{

    public function __construct()
    {

        // Call the CI_Model constructor

        parent::__construct();
        $this->load->database();
    }

    public function get_members($query)
    {
        $query = $this->db->query($query);
        return $query->result_array();
    }

    public function count_members()
    {
        $this->db->select('count(id)');
        $query = $this->db->get('members');
        return $query->result_array();
    }

    public function count_active_members()
    {
        $sql = "SELECT COUNT(*) 'count' FROM members WHERE active = 1";
        $results = $this->db->query($sql)->result_array();
        if (!empty($results)) {
            return $results[0]['count'];
        }
    }

    public function sum_payments()
    {
        $this->db->select(' SUM(total_payments)');
        $query = $this->db->get('payments');
        return $query->result_array();
    }

    public function get_member($id)
    {
        $this->db->select(['first_name', 'last_name', 'country', 'city', 'id', 'email', 'active']);
        $query = $this->db->get_where('members', ['id' => $id]);
        return $query->result_array();
    }


    public function update_member($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('members', $data);
    }

    public function remove_post($id)
    {
        $sql = "DELETE FROM posts WHERE id=" . $id;
        $result = $this->db->query($sql);
        if ($result) {
            return 1;
        } else {
            return 0;
        }
    }

    public function get_paypal_detail()
    {
        $this->db->select('*');
        $query = $this->db->get_where('paypal_setting', ['id' => 1]);
        return $query->result_array();
    }

    public function update_paypal($data)
    {

        $this->db->where('id', 1);
        $this->db->update('paypal_setting', $data);
    }

    public function get_admin_setting()
    {
        $this->db->select('*');
        $query = $this->db->get_where('admin_info', ['id' => 1]);
        return $query->result_array();
    }

    public function update_admin_setting($data)
    {
        $this->db->where('id', 1);
        $this->db->update('admin_info', $data);
    }

    public function update_admin_post_duration($duration)
    {
        return $this->db->update('setting', ['value' => $duration], ['key' => 'post_duration']);
//        $sql = "UPDATE admin_info SET post_duration=" . $duration . " WHERE id=1";
//        $result = $this->db->query($sql);
//        if ($result) {
//            return 1;
//        } else {
//            return 0;
//        }
    }

    public function get_post_duration()
    {
        return $this->db->select('value')->get_where('setting', ['key' => 'post_duration'])->row()->value;
    }

    public function get_posts_for_delete($duration)
    {
        $this->db->select('id, photos, show_in_gallery, show_in_posts', false);
        $this->db->where("time <= (NOW() - INTERVAL $duration DAY)")->where(['show_in_posts'=>1]);
        $query = $this->db->get('posts');
        return $query->result();
    }

    public function get_login_info($email)
    {
        $this->db->select('*');
        $query = $this->db->get_where('admin_info', ['email' => $email]);
        return $query->result_array();
    }

    public function updatePoints($user_id, $points)
    {
        $sql = "UPDATE members SET points = '" . $points . "' WHERE id = '" . $user_id . "' ;";
        $results = $this->db->query($sql);
        if ($results) {
            return true;
        } else {
            return false;
        }
    }

    public function updatePrice($id, $price)
    {
        $sql = "UPDATE setting SET value = '" . $price . "' WHERE id = '" . $id . "' ;";
        $results = $this->db->query($sql);
        if ($results) {
            return true;
        } else {
            return false;
        }
    }

    public function getOptions()
    {
        $sql = "SELECT * FROM setting WHERE `key` IN('bulletin','ad')";
        $results = $this->db->query($sql)->result_array();
        if ($results) {
            return $results;
        } else {
            return false;
        }
    }

    public function getTopText($key){
        return $this->db->select('value_text')->get_where('setting', ['key' => 'top_text_'.$key])->row()->value_text;
    }

    public function getAllTopTexts(){
        $suffix='top_text_';
        $temp= $this->db->select('key, value_text')->order_by('date_added', 'ASC')->
        where(['key' => $suffix.'night8pm_10pm'])->or_where(['key' => $suffix.'night11pm_12am'])
            ->or_where(['key' => $suffix.'night1am_3am'])
            ->or_where(['key' => $suffix.'night3am_6m'])
            ->or_where(['key' => $suffix.'morning6am_8am'])
            ->or_where(['key' => $suffix.'morning8am_9am'])
            ->or_where(['key' => $suffix.'morning9am_11am'])
            ->or_where(['key' => $suffix.'afternoon12pm_2pm'])
            ->or_where(['key' => $suffix.'afternoon3pm_4pm'])
            ->or_where(['key' => $suffix.'afternoon4pm_5pm'])
            ->or_where(['key' => $suffix.'evening5pm_7pm'])
        ->get('setting')->result();
        $res=[];
        foreach ($temp as $t){
            $key=str_replace($suffix, '', $t->key);
            $res[$key]=$t->value_text;
        }
        return (object)$res;
    }

    public function setTopText($key, $text){
        $suffix='top_text_';
        return $this->db->update('setting', ['value_text' => $text], ['key' => $suffix.$key]);
    }

}