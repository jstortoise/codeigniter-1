<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Member_Model extends CI_Model
{


    public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
        $this->load->database();
    }


    public function get()
    {
        $this->db->select(['id', 'parent_id', 'first_name', 'image']);
        $query = $this->db->get('members');
        return $query->result_array();
    }

    public function get_where($id)
    {
        $this->db->select(['id', 'first_name', 'image', 'active', 'privacy', 'points', 'reference_link']);
        $query = $this->db->get_where('members', ['id' => $id]);
        return $query->result_array();
    }

    public function get_user($id)
    {
        $this->db->select(['id', 'first_name', 'last_name', 'image', 'profile_url', 'luv_points', 'points']);
        $query = $this->db->get_where('members', ['id' => $id]);
        return $query->result();
    }

    public function get_user_data($id)
    {
        $this->db->select('*');
        $query = $this->db->get_where('members', ['id' => $id]);
        return $query->result_array();
    }

    public function get_user_data_by_array($id)//$id is array
    {
        if (count($id)) {
            $this->db->select('id, first_name, last_name, image, profile_url');
            $this->db->from('members');
            $this->db->where_in('id', $id);
            $query = $this->db->get();
            return $query->result();
        } else {
            return [];
        }
    }

    public function total_referel($child)
    {
        $this->db->select(['id', 'parent_id', 'first_name']);
        $this->db->where_in('id', $child);
        $query = $this->db->get('members');
        return $query->result_array();
    }

    public function total_indirect_referel($id)
    {
        $this->db->select(['GetFamilyTree(id)']);
        $this->db->where('id', $id);
        $query = $this->db->get('members');
        return $query->result_array();
    }

    public function total_direct_referel($id)
    {
        $id = (int)$id;
        $sql = "SELECT count(id) 'count' FROM members WHERE parent_id = $id AND active = 1";
        $results = $this->db->query($sql)->result_array();
        return $results[0]['count'];
    }

    public function get_parent_id($id)
    {
        $this->db->select(['parent_id']);
        $this->db->where('id', $id);
        $query = $this->db->get('members');
        return $query->result_array();
    }

    public function ten_level_table_children($id)
    {
        $query = $this->db->query("SELECT
        p.id as parent_id,
        p.first_name as parent_name,
         c1.id as child_id_1,
         c1.first_name as child_name_1,
        c2.id as child_id_2,
         c2.first_name as child_name_2,
        c3.id as child_id_3,
         c3.first_name as child_name_3,
        c4.id as child_id_4,
         c4.first_name as child_name_4,
        c5.id as child_id_5,
         c5.first_name as child_name_5,
        c6.id as child_id_6,
         c6.first_name as child_name_6,
        c7.id as child_id_7,
         c7.first_name as child_name_7,
        c8.id as child_id_8,
         c8.first_name as child_name_8,
        c9.id as child_id_9,
         c9.first_name as child_name_9,
        c10.id as child_id_10,
         c10.first_name as child_name_10
        FROM members p
        LEFT JOIN members c1
        ON c1.parent_id = p.id
        LEFT JOIN members c2
            ON c2.parent_id = c1.id
        LEFT JOIN members c3
            ON c3.parent_id = c2.id
        LEFT JOIN members c4
            ON c4.parent_id = c3.id
        LEFT JOIN members c5
            ON c5.parent_id = c4.id
        LEFT JOIN members c6
            ON c6.parent_id = c5.id
        LEFT JOIN members c7
            ON c7.parent_id = c6.id
        LEFT JOIN members c8
            ON c8.parent_id = c7.id
        LEFT JOIN members c9
            ON c9.parent_id = c8.id
        LEFT JOIN members c10
            ON c10.parent_id = c9.id
        WHERE p.parent_id=$id");
        return $query->result_array();
    }

    public function ten_level_table_parents($id)
    {
        $query = $this->db->query("SELECT
        p.id AS parent_id,
        p.first_name AS parent_name,
         c1.id AS child_id_1,
         c1.first_name AS child_name_1,
        c2.id AS child_id_2,
         c2.first_name AS child_name_2,
        c3.id AS child_id_3,
         c3.first_name AS child_name_3,
        c4.id AS child_id_4,
         c4.first_name AS child_name_4,
        c5.id AS child_id_5,
         c5.first_name AS child_name_5,
        c6.id AS child_id_6,
         c6.first_name AS child_name_6,
        c7.id AS child_id_7,
         c7.first_name AS child_name_7,
        c8.id AS child_id_8,
         c8.first_name AS child_name_8,
        c9.id AS child_id_9,
         c9.first_name AS child_name_9,
        c10.id AS child_id_10,
         c10.first_name AS child_name_10
        FROM members p
        LEFT OUTER JOIN members c1
        ON c1.id = p.parent_id
        LEFT OUTER JOIN members c2
            ON c2.id = c1.parent_id
        LEFT OUTER JOIN members c3
            ON c3.id = c2.parent_id
        LEFT OUTER JOIN members c4
            ON c4.id = c3.parent_id
        LEFT OUTER JOIN members c5
            ON c5.id = c4.parent_id
        LEFT OUTER JOIN members c6
            ON c6.id = c5.parent_id
        LEFT OUTER JOIN members c7
            ON c7.id = c6.parent_id
        LEFT OUTER JOIN members c8
            ON c8.id = c7.parent_id
        LEFT OUTER JOIN members c9
            ON c9.id = c8.parent_id
        LEFT OUTER JOIN members c10
            ON c10.id = c9.parent_id
        WHERE p.id=$id");

        return $query->result_array();
    }

    public function get_points($id)
    {
        $this->db->select(['points']);
        $query = $this->db->get_where('members', ['id' => $id]);
        return $query->result_array();
    }

    public function members_insert_detail($data = array())
    {
        $query = $this->db->insert('members', $data);
        return $query->update_batch();
    }

    public function update_members_profile($id, $data = array())
    {
        $this->db->where('id', $id);
        $this->db->update('members', $data);
    }

    public function debit_points($id, $points)
    {
        return $this->db->query("update members set points = points-$points where id=$id");
//        $this->db->update('members', null, ['id'=>$id]);
    }

    public function update_reference_link($id, $reference_link)
    {
        $this->db->set('reference_link', $reference_link);
        $this->db->where('id', $id);
        $this->db->update('members');

    }

    public function get_email($id)
    {
        $this->db->select(['email']);
        $query = $this->db->get_where('members', ['id' => $id]);
        return $query->result_array();
    }

    public function get_id($email)
    {
        $this->db->select(['id']);
        $query = $this->db->get_where('members', ['email' => $email]);
        return $query->result_array();
    }

    public function search_friends($key1, $key2, $key3)
    {
        $UserID = $this->session->userdata('user_id');

        $query1 = $this->db->query("SELECT F.status,M.id
                            FROM members M, friends F WHERE CASE
                            WHEN F.friend_one = '$UserID'
                            THEN F.friend_two = M.id
                            WHEN F.friend_two= '$UserID'
                            THEN F.friend_one= M.id
                            END
                           ");
        $friendList = $query1->result_array();

        //  p($friendList);
        $ids = array('1', $UserID);
        if (!empty($friendList)) {
            $ids = ['1', $UserID];
            foreach ($friendList as $key => $value) {
                $ids[] = $value['id'];
            }

        }

        $p = $this->db->select('*');
        // $this->db->like('last_name',$key1,'both');
        // $this->db->or_like('last_name', $key2,'both');
        $this->db->where('(first_name LIKE ' . $key1 . ' OR last_name LIKE ' . $key2 . ')', NULL, FALSE);
        $this->db->where_not_in('id', $ids);
        $query = $p->get_where('members');
        if ($query->num_rows() > 0) {


            return $array = $query->result_array();
            //return array_rand($array,4);
        } else {
            return array();
        }


        if (!empty($key3)) {
            //p($key3);
            $query = $this->db->query("SELECT `first_name`,`last_name`,`id`,`email` from `members` where `email` LIKE '$key3'");
            return $query->result_array();
        }
        $query = $this->db->query("SELECT `first_name`,`last_name`,`id`,`email` from `members` where `first_name` LIKE $key1 OR last_name LIKE $key2 AND id NOT IN ($ids)");
        return $query->result_array();

    }

    function get_all_users($limit = '', $offset = '')
    {
        $ids = $this->getFriendsIds();
        //Setting Limit for Paging
        if ($limit) {
            $limit = "LIMIT $limit";
            if ($limit != '' && $offset == 0) {
                $offset = '';
            } else if ($limit != '' && $offset != 0) {
                $offset = "OFFSET $offset";
            }
        }
        $query = $this->db->query("SELECT SQL_CALC_FOUND_ROWS * FROM `members` WHERE `id` NOT IN($ids) ORDER BY `first_name` ASC, `last_name` ASC $limit $offset");

//        $p = $this->db->where_not_in('id', $ids)->order_by('first_name ASC, last_name ASC');
//        $count=$this->db->count_all_results('members', false);
//        $query = $p->get_where();

        if ($query->num_rows() > 0) {
            $count = (array)($this->db->query('SELECT FOUND_ROWS()')->row());
            $count = $count["FOUND_ROWS()"];
            return (object)['users' => $query->result_array(), 'count' => $count];
        } else {
            return (object)[];
        }
    }

    function get_all_user_search($limit = '', $offset = '', $Keywords)
    {
        //Setting Limit for Paging
        if ($limit) {
            $limit = "LIMIT $limit";
            if ($limit != '' && $offset == 0) {
                $offset = '';
            } else if ($limit != '' && $offset != 0) {
                $offset = "OFFSET $offset";
            }
        }
        $ids = $this->getFriendsIds();
        $birthday = $country = $city = $gender = '';
        if (empty($Keywords['end_age']) && !empty($Keywords['start_age'])) {
            $date = date("Y-m-d", strtotime(" -{$Keywords['start_age']} year"));
            $birthday = "AND birthday <= '$date'";
        } elseif (!empty($Keywords['end_age']) && empty($Keywords['start_age'])) {
            $date = date("Y-m-d", strtotime(" -{$Keywords['end_age']} year"));
            $birthday = "AND birthday >= '$date'";
        } elseif (!empty($Keywords['end_age']) && !empty($Keywords['start_age'])) {
            $dateFrom = date("Y-m-d", strtotime(" -{$Keywords['end_age']} year"));
            $dateTo = date("Y-m-d", strtotime(" -{$Keywords['start_age']} year"));
            $birthday = "AND birthday BETWEEN '$dateFrom' AND '$dateTo'";
        }

        if ($Keywords['city'] != '') {
            $city = "AND city LIKE '%{$Keywords['city']}%'";
        }
        if ($Keywords['country'] != '') {
            $country = "AND country LIKE '%{$Keywords['country']}%'";
        }
        if ($Keywords['gender'] != '') {
            $gender = "AND gender LIKE '%{$Keywords['gender']}%'";
        }

        $query = $this->db->query("SELECT SQL_CALC_FOUND_ROWS * FROM `members` 
WHERE `id` NOT IN($ids) $city $country $gender $birthday 
ORDER BY `first_name` ASC, `last_name` ASC 
$limit $offset");

        if ($query->num_rows() > 0) {
            $count = (array)($this->db->query('SELECT FOUND_ROWS()')->row());
            $count = $count["FOUND_ROWS()"];
            return (object)['users' => $query->result_array(), 'count' => $count];
        } else {
            return (object)[];
        }
    }

    public function getRelatedUsers()
    {
        $limit = 5;
        $user = $this->ion_auth->user()->row();
        if (!$user->city && !$user->country) {
            return [];
        }
        $res = [];
        $ids = $this->getFriendsIds();
        $count = 0;
        if ($user->city) {
            $query = $this->db->query("SELECT * FROM `members` WHERE `id` NOT IN($ids) AND city LIKE '%{$user->city}%' ORDER BY rand() LIMIT $limit");
            $count = $query->num_rows();
            $res = $query->result_array();
            $extraIds='';
            foreach ($res as $r){
                $extraIds.=", {$r['id']}";
            }
            $ids.=$extraIds;
        }
        if ($count < $limit && $user->country) {
            $newLimit = $limit - $count;
            $query = $this->db->query("SELECT * FROM `members` WHERE `id` NOT IN($ids) AND country LIKE '%{$user->country}%' ORDER BY rand() LIMIT $newLimit");
            $count += $query->num_rows();
            $res = array_merge($res, $query->result_array());
        }
        if($count<$limit){
            $newLimit=$limit-$count;
            $query = $this->db->query("SELECT * FROM `members` WHERE `id` NOT IN($ids) AND country NOT LIKE '%{$user->country}%' ORDER BY rand() LIMIT $newLimit");
            $res = array_merge($res, $query->result_array());
        }
        return $res;
    }

    private function getFriendsIds()
    {
        $UserID = $this->session->userdata('user_id');
        $query1 = $this->db->query("SELECT F.status,M.id
                            FROM members M, friends F WHERE CASE
                            WHEN F.friend_one = '$UserID'
                            THEN F.friend_two = M.id
                            WHEN F.friend_two= '$UserID'
                            THEN F.friend_one= M.id
                            END");
        $friendList = $query1->result_array();
        $ids = "$UserID";
        if (!empty($friendList)) {
            foreach ($friendList as $friend) {
//                $ids[] = $friend['id'];
                $ids .= ", {$friend['id']}";
            }
        }
        return $ids;
    }

    public function search_friend($key1, $key2, $start, $limit, $user_id)
    {
        $sql = "
                SELECT members.first_name,members.last_name,members.id, members.profile_url, members.image, friends.status,friends.friend_one 
                FROM members 
                LEFT join friends ON (friends.friend_one = $user_id OR friends.friend_two = $user_id)
                    AND (friends.friend_two = members.id  OR friends.friend_one = members.id)
                AND friends.friend_two = $user_id  
                WHERE members.first_name LIKE $key1 
                OR members.last_name LIKE $key1 
                Group by members.id 
                Limit $start,$limit
        ";
        $sql = trim($sql);
        $query = $this->db->query($sql);
        $results = $query->result_array();
        if (!empty($results)) {
            return $results;
        } else {
            return array();
        }
    }

    public function count_search_friend($key1, $key2)
    {
        $query = $this->db->query("SELECT count(id) from `members` where first_name LIKE $key1 OR last_name Like $key2");
        return $query->num_rows();
    }

    public function friend_requests($data)
    {
        $this->db->insert('friends', $data);
        return $this->db->insert_id();
    }

    public function friend_list($user_id)
    {
        $query = $this->db->query("SELECT F.status,M.id, M.profile_url, M.first_name, M.last_name, M.image, M.city, M.country, M.birthday 
                            FROM members M, friends F WHERE CASE
                            WHEN F.friend_one = '$user_id'
                            THEN F.friend_two = M.id
                            WHEN F.friend_two= '$user_id'
                            THEN F.friend_one= M.id
                            END
                            AND
                            F.status='2'");
        return $query->result_array();
    }

    public function getOnlineFriends($user_id)
    {
        $sql = "SELECT F.status,M.id, M.profile_url, M.first_name,M.last_name,M.image, M.city, M.country, M.birthday 
                            FROM members M, friends F 
                            WHERE M.last_seen BETWEEN (DATE_SUB(NOW(),INTERVAL +1 MINUTE)) AND NOW() 
                            AND CASE
                            WHEN F.friend_one = '$user_id'
                            THEN F.friend_two = M.id
                            WHEN F.friend_two= '$user_id'
                            THEN F.friend_one= M.id
                            END
                            AND F.status='2'
        ;";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function friend_request_recieved($user_id)
    {
        $query = $this->db->query("SELECT F.status,M.id, M.profile_url, M.first_name,M.last_name,M.image, M.city, M.country, M.birthday 
                            FROM members M, friends F WHERE CASE
                            WHEN F.friend_two= '$user_id'
                            THEN F.friend_one= M.id
                            END
                            AND
                            F.status='1'");
        return $query->result_array();
    }

    public function acceptfriendrequest($friend_id, $user_id)
    {

        $this->db->query("update friends set status=2 where friend_one=$friend_id and friend_two = $user_id LIMIT 1");
    }

    public function deletefriendrequest($friend_id, $user_id)
    {
        $this->db->query("delete from friends where friend_one=$friend_id and friend_two = $user_id LIMIT 1");
    }

    public function deletefriend($friend_id, $user_id)
    {
        $this->db->query("delete from friends where friend_one=$friend_id and friend_two= $user_id or friend_one = $user_id and friend_two=$friend_id and status=2 LIMIT 1 ");
    }

    // Edited By Vishad
    public function getStep1ProfileDetails($id)
    {
        $this->db->select('*');
        $this->db->from('members');
        $this->db->where(array('id' => $id));
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return array();
        }
    }

    public function getCode($id)
    {
        $id = (int)$id;
        $sql = "SELECT activation_code FROM members WHERE `id` = '" . $id . "' ;";
        $results = $this->db->query($sql);
        $results = $results->result();
        if (!empty($results)) {
            return $results[0]->activation_code;
        }
        return false;
    }

    public function give_points_for_reffer($parent_id)
    {
        $referrers = $this->ten_level_table_parents($parent_id);
        $referrers = $referrers[0];
        if (!empty($referrers['parent_id'])) {
            $id = $referrers['parent_id'];
            $sql = "UPDATE members SET points = (points+10) WHERE id = '" . $id . "' ;";
            $query = $this->db->query($sql);
            if (!$query) {
                $errors[] = "Error here : parent_id";
            }
        }
        if (!empty($referrers['child_id_1'])) {
            $id = $referrers['child_id_1'];
            $sql = "UPDATE members SET points = (points+5) WHERE id = '" . $id . "' ;";
            $query = $this->db->query($sql);
            if (!$query) {
                $errors[] = "Error here : child_id_1";
            }
        }
        if (!empty($referrers['child_id_2'])) {
            $id = $referrers['child_id_2'];
            $sql = "UPDATE members SET points = (points+2) WHERE id = '" . $id . "' ;";
            $query = $this->db->query($sql);
            if (!$query) {
                $errors[] = "Error here : child_id_2";
            }
        }
        if (!empty($referrers['child_id_3'])) {
            $id = $referrers['child_id_3'];
            $sql = "UPDATE members SET points = (points+2) WHERE id = '" . $id . "' ;";
            $query = $this->db->query($sql);
            if (!$query) {
                $errors[] = "Error here : child_id_3";
            }
        }
        if (!empty($referrers['child_id_4'])) {
            $id = $referrers['child_id_4'];
            $sql = "UPDATE members SET points = (points+2) WHERE id = '" . $id . "' ;";
            $query = $this->db->query($sql);
            if (!$query) {
                $errors[] = "Error here : child_id_4";
            }
        }
        if (!empty($referrers['child_id_5'])) {
            $id = $referrers['child_id_5'];
            $sql = "UPDATE members SET points = (points+1) WHERE id = '" . $id . "' ;";
            $query = $this->db->query($sql);
            if (!$query) {
                $errors[] = "Error here : child_id_5";
            }
        }
        if (!empty($referrers['child_id_6'])) {
            $id = $referrers['child_id_6'];
            $sql = "UPDATE members SET points = (points+1) WHERE id = '" . $id . "' ;";
            $query = $this->db->query($sql);
            if (!$query) {
                $errors[] = "Error here : child_id_6";
            }
        }
        if (!empty($referrers['child_id_7'])) {
            $id = $referrers['child_id_7'];
            $sql = "UPDATE members SET points = (points+1) WHERE id = '" . $id . "' ;";
            $query = $this->db->query($sql);
            if (!$query) {
                $errors[] = "Error here : child_id_7";
            }
        }
        if (!empty($referrers['child_id_8'])) {
            $id = $referrers['child_id_8'];
            $sql = "UPDATE members SET points = (points+1) WHERE id = '" . $id . "' ;";
            $query = $this->db->query($sql);
            if (!$query) {
                $errors[] = "Error here : child_id_8";
            }
        }
        if (!empty($referrers['child_id_9'])) {
            $id = $referrers['child_id_9'];
            $sql = "UPDATE members SET points = (points+1) WHERE id = '" . $id . "' ;";
            $query = $this->db->query($sql);
            if (!$query) {
                $errors[] = "Error here : child_id_9";
            }
        }

        if (empty($errors)) {
            return true;
        } else {
            return $errors;
        }
    }

    public function insertIssue()
    {
        $name = $this->input->post('name');
        $email = $this->input->post('email');
        $reported_issue = $this->input->post('reported_issue');
        $sql = "INSERT INTO reports (`name`,`email`,`reported_issue`,`date_added`) 
                            VALUES ('" . $name . "','" . $email . "','" . $reported_issue . "',NOW())";
        $results = $this->db->query($sql);
        if ($results) {
            return true;
        } else {
            return false;
        }
    }

    public function deduct($user_id, $deducted_amount)
    {
        $sql = "UPDATE members SET points = (points-" . $deducted_amount . ") WHERE id = '" . $user_id . "' ;";
        $results = $this->db->query($sql);
        if ($results) {
            return true;
        }
        return false;
    }

    public function updateLastSeen($id)
    {
        $id = (int)$id;
        $sql = "UPDATE members SET last_seen = NOW() WHERE id = '" . $id . "' ;";
        $results = $this->db->query($sql);
        if ($results) {
            return true;
        }
        return false;
    }

    public function update_user_data($user_id, $col, $value)
    {
        $sql = "UPDATE members SET " . $col . " = '" . $value . "' WHERE id = '" . $user_id . "' ;";
        $results = $this->db->query($sql);
        if ($results) {
            return 1;
        }
        return false;
    }

    public function check_user_profile_url($profile_url)
    {
        $sql = "SELECT * FROM members WHERE profile_url = '" . $profile_url . "' ;";
        $results = $this->db->query($sql);
        $results = $results->result();
        if (!empty($results)) {
            return $results[0]->id;
        }
        return false;
    }

    public function check_profile_url($profile_url)
    {
        $sql = "SELECT * FROM members WHERE profile_url = '" . $profile_url . "' ;";
        $results = $this->db->query($sql);
        $results = $results->result();
        if (!empty($results)) {
            return $results[0]->id;
        }
        return false;
    }

    public function check_member_id($id)
    {
        $sql = "SELECT * FROM members WHERE id = '" . $id . "' ;";
        $results = $this->db->query($sql);
        $results = $results->result();

        if (!empty($results)) {
            return $results[0]->id;
        }
        return false;
    }

    /*public function update_profile_slider($user_id,$_FILES)
    {
        foreach($_FILES as $file)
        {
            return $file;
        }
    }*/


}