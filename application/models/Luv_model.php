<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Luv_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function giveLuv($from_member_id, $to_member_id, $isFree = 1)
    {
        $this->disableNotShow($to_member_id);
        return $this->db->insert('luv', ['from_member_id' => $from_member_id, 'to_member_id' => $to_member_id, 'is_free' => $isFree, 'sent_at'=>gmdate("Y-m-d  H:i:s")]);
    }

    public function getLastFreeLuv()
    {
        $query = $this->db->get_where('luv', ['from_member_id' => ($this->session->userdata('user_id')), 'sent_at >=' => 'DATE_SUB(UTC_TIMESTAMP(), INTERVAL 1 DAY)']);
        $query = $this->db->query("SELECT * FROM `luv` WHERE `from_member_id` = "
            . $this->session->userdata('user_id')
            . " AND `sent_at` >= DATE_SUB(UTC_TIMESTAMP() , INTERVAL 1 DAY) AND `is_free` = 1 ORDER BY  `sent_at` DESC");
        return $query->result();
    }

    public function give_luv_points($from_member_id, $to_member_id)
    {
        $this->db->query("UPDATE members SET luv_points = (luv_points+10) WHERE id = $from_member_id");
        return $this->db->query("UPDATE members SET luv_points = (luv_points+25) WHERE id = $to_member_id");
    }

    public function getAllLuv()
    {
        $id = $this->session->userdata('user_id');
//        $this->db->select('luv.*, m.id as memberId, m.first_name, m.last_name, m.luv_points, m.image, m.profile_url');
//        $this->db->from('luv');
//        $this->db->where(['luv.from_member_id' => $id]);
//        $this->db->or_where(['luv.to_member_id' => $id]);
//        $this->db->join('members as m', "m.id != $id AND (m.id = luv.from_member_id OR m.id = luv.to_member_id)", 'left');
        $query = $this->db->query("SELECT `luv`.*, `m`.`id` as `memberId`, `m`.`first_name`, `m`.`last_name`, `m`.`luv_points`, `m`.`image`, `m`.`profile_url`, `m`.`city`, `m`.`country`, `m`.`birthday` 
              FROM `luv` 
              LEFT JOIN `members` as `m` 
              ON `m`.`id` != $id AND (`m`.`id` = `luv`.`from_member_id` OR `m`.`id` = luv.to_member_id) 
              WHERE `luv`.`from_member_id` = $id OR `luv`.`to_member_id` = $id
              GROUP BY `luv`.`sent_at` DESC");
        $res = $query->result();
        $temp = [];
        foreach ($res as $r) {
            if (!isset($temp[$r->memberId])) {
                $temp[$r->memberId] = (object)[];
                $temp[$r->memberId]->first_name = $r->first_name;
                $temp[$r->memberId]->last_name = $r->last_name;
                $temp[$r->memberId]->profile_url = $r->profile_url;
                $temp[$r->memberId]->image = $r->image;
                $temp[$r->memberId]->luv_points = $r->luv_points;
                $temp[$r->memberId]->city = $r->city;
                $temp[$r->memberId]->country = $r->country;
                $temp[$r->memberId]->birthday = $r->birthday;
                $temp[$r->memberId]->luvs = [];
            }
            $luv = (object)[];
            $luv->id = $r->id;
            $luv->from_member_id = $r->from_member_id;
            $luv->to_member_id = $r->to_member_id;
            $luv->sent_at = $r->sent_at;
            array_push($temp[$r->memberId]->luvs, $luv);
        }
        foreach ($temp as $key=>$val){
            if($this->checkNotShow($key)){
                unset($temp[$key]);
            }
        }
        return $temp;
    }

    public function notShow($id){
        return $this->db->insert('not_show_luv', ['member_id' => $id, 'for_member_id' => $this->session->userdata('user_id')]);
    }

    protected function checkNotShow($id){
        $this->db->select('id');
        $this->db->where(['member_id' => $id, 'for_member_id' => $this->session->userdata('user_id')]);
        $this->db->or_where(['member_id' => $this->session->userdata('user_id'), 'for_member_id' => $id]);
        return $this->db->count_all_results('not_show_luv');
    }

    private function disableNotShow($id){
        $this->db->where(['member_id' => $id, 'for_member_id' => $this->session->userdata('user_id')]);
        $this->db->or_where(['member_id' => $this->session->userdata('user_id'), 'for_member_id' => $id]);
        return $this->db->delete('not_show_luv');
    }

}