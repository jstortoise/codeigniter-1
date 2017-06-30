<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Posts_model extends CI_Model
{

    public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
        $this->load->database();
    }

    public function insert_post($data)
    {
        $this->db->insert('posts', $data);
        return $this->db->insert_id();
    }

    public function count_rows_privacy1($friend_list = array())
    {
        $friend_list = join(', ', $friend_list);
        $query = $this->db->query("SELECT posts.id,posts.status,posts.photos , posts.time ,members.first_name,members.last_name, members.image, COUNT(posts_like.id) as likes, GROUP_CONCAT(members.first_name SEPARATOR '|') AS liked_by from posts left JOIN posts_like ON posts.id=posts_like.post_id left join members on members.id=posts.member_id where posts.member_id in($friend_list) and (posts.privacy in (1, 2, 3)) Group by posts.id order by posts.id DESC");
        return $query->num_rows();
    }

    public function count_rows_privacy2($friend_list = array())
    {
        $friend_list = join(', ', $friend_list);
        $query = "SELECT posts.id,posts.status,posts.photos , posts.time ,members.first_name,members.last_name, members.image, COUNT(posts_like.id) as likes, GROUP_CONCAT(members.first_name SEPARATOR '|') AS liked_by from posts left JOIN posts_like ON posts.id=posts_like.post_id left join members on members.id=posts.member_id where posts.member_id in($friend_list) and posts.privacy=2  Group by posts.id order by posts.id DESC";
        $query = $this->db->query($query);
        return $query->num_rows();
    }

    public function count_rows_privacy3($friend_list)
    {
        $query = $this->db->query("SELECT posts.id,posts.status,posts.photos , posts.time ,members.first_name,members.last_name, members.image, COUNT(posts_like.id) as likes, GROUP_CONCAT(members.first_name SEPARATOR '|') AS liked_by from posts left JOIN posts_like ON posts.id=posts_like.post_id left join members on members.id=posts.member_id where posts.member_id = $friend_list and posts.privacy=3 Group by posts.id order by posts.id DESC");
        return $query->num_rows();
    }

    public function count_search_rows()
    {
        $query = $this->db->get('posts');
        return $query->num_rows();
    }

    public function select_rows_privacy1($start, $limit, $friend_list)
    {
        $q = "SELECT posts.id,posts.status,posts.photos , posts.time ,members.first_name,members.last_name, posts.member_id,  members.profile_url, members.image, COUNT(posts_like.id) as likes, GROUP_CONCAT(members.first_name SEPARATOR '|') AS liked_by from posts left JOIN posts_like ON posts.id=posts_like.post_id left join members on members.id=posts.member_id where posts.privacy =1 AND posts.show_in_posts=1  Group by posts.id order by posts.id DESC Limit $start, $limit";
        $query = $this->db->query($q);
        return $query->result_array();
    }

    public function select_rows_privacy2($start, $limit, $friend_list)
    {
        $frndListt = implode(',', $friend_list);
        $userId = $this->session->userdata('user_id');
        $q = "SELECT posts.id,posts.status,posts.photos , posts.member_id, posts.time ,members.first_name,members.last_name,  members.profile_url, members.image, COUNT(posts_like.id) as likes, GROUP_CONCAT(members.first_name SEPARATOR '|') AS liked_by from posts left JOIN posts_like ON posts.id=posts_like.post_id left join members on members.id=posts.member_id where posts.privacy=2 AND posts.show_in_posts=1 AND posts.member_id IN($frndListt) Group by posts.id order by posts.id DESC Limit $start,$limit";
        $query = $this->db->query($q);
        return $query->result_array();
    }

    public function select_rows_privacy3($start, $limit, $friend_list)
    {
        //$friend_list = join(', ', $friend_list);
        $userId = $this->session->userdata('user_id');
        //  $q = "SELECT posts.id,posts.status,posts.photos , posts.time ,members.first_name,members.last_name, members.image, COUNT(posts_like.id) as likes, GROUP_CONCAT(members.first_name SEPARATOR '|') AS liked_by from posts left JOIN posts_like ON posts.id=posts_like.post_id left join members on members.id=posts.member_id where posts.privacy=3 AND posts.member_id = $userId Group by posts.id order by posts.id DESC Limit $start, $limit";
        $q = "SELECT posts.id,posts.status,posts.photos , posts.member_id, posts.time ,members.first_name,members.last_name, members.profile_url, members.image, COUNT(posts_like.id) as likes, GROUP_CONCAT(members.first_name SEPARATOR '|') AS liked_by from posts left JOIN posts_like ON posts.id=posts_like.post_id left join members on members.id=posts.member_id where posts.member_id = $userId  AND posts.show_in_posts=1 Group by posts.id order by posts.id DESC Limit $start, $limit";
        $query = $this->db->query($q);
        // print_R($query->result_array());exit;
        return $query->result_array();
    }

    public function select_friend_detail($start, $limit, $friendId)
    {
//echo "select * from friends WHERE friend_one = $friendId OR friend_two = $friendId Limit $start, $limit";die;
        $query = $this->db->query("select * from friends WHERE friend_one = $friendId OR friend_two = $friendId Limit $start, $limit");
        return $query->result_array();
    }

    public function get_user_image($userId)
    {
        $query = $this->db->query("select image from members WHERE id = $userId");
        return $query->result_array();
    }

    public function posts_like($user_id, $posts_id)
    {
        $query = $this->db->query("insert into posts_like (member_id,post_id) select $user_id,$posts_id from posts where exists (select id from posts where id = $posts_id) and not exists (select id from posts_like where member_id=$user_id and post_id=$posts_id) LIMIT 1 ");
        return $this->db->insert_id();
    }


    function find_like_on_post($user_id, $posts_id)
    {
        $this->db->select('*');
        $this->db->from('posts_like');
        $this->db->where(array('post_id' => $posts_id, 'member_id' => $user_id));
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    function remove_post_by_id($id)
    {
        if ($this->db->delete('posts', array('id' => $id))) {
            return 1;
        } else {
            return 0;
        }
    }


    function remove_post_like($user_id, $posts_id)
    {
        if ($this->db->delete('posts_like', array('post_id' => $posts_id, 'member_id' => $user_id))) {
            return 1;
        } else {
            return 0;
        }
    }

    // Post Likers User details
    public function total_likes_user_details($posts_id)
    {
        $this->db->select('*');
        $this->db->from('posts_like');
        $this->db->where(array('post_id' => $posts_id));
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return 0;
        }
    }

    public function report_post($id)
    {
        $sql = "UPDATE posts SET is_reported = 1 WHERE id=" . $id;
        return $this->db->query($sql);
    }


    public function get_all_posts()
    {
        $query = $this->db->query("SELECT * FROM posts");
        return $query->result_array();
    }

    public function get_posts_like($posts_id)
    {
        $query = $this->db->query("select COUNT(id) as likes from posts_like WHERE post_id = $posts_id");
        return $query->result_array();
    }

    public function get_posts_comments($posts_id)
    {
        $query = $this->db->query("select members.first_name,members.last_name,members.image,posts_comment.member_id,posts_comment.comment,posts_comment.timestamp from posts_comment LEFT JOIN members on posts_comment.member_id = members.id WHERE posts_comment.post_id = $posts_id ORDER by posts_comment.timestamp asc");
        return $query->result_array();
    }

    public function count_posts_comments($posts_id, $start, $limit)
    {
        $query = $this->db->query("select members.first_name,members.last_name,members.image,posts_comment.member_id,posts_comment.comment,posts_comment.timestamp from posts_comment LEFT JOIN members on posts_comment.member_id = members.id WHERE posts_comment.post_id = $posts_id Limit $start,$limit");
        return $query->num_rows();
    }

    public function posts_comment($user_id, $posts_id, $comment)
    {
//        $this->db->query("insert into posts_comment (member_id,post_id,comment) select $user_id,$posts_id,'$comment' from posts where exists (select id from posts where id = $posts_id)  LIMIT 1 ");
        $this->db->insert('posts_comment', ['member_id' => $user_id, 'post_id' => $posts_id, 'comment' => $comment, 'timestamp' => gmdate("Y-m-d  H:i:s")]);
        return $this->db->insert_id();
    }

    public function get_one_post($post_id)
    {
        $query = $this->db->query("SELECT posts.id,posts.status,posts.photos , posts.time ,members.first_name,members.last_name, members.image, COUNT(posts_like.id) as likes, GROUP_CONCAT(members.first_name SEPARATOR '|') AS liked_by from posts left JOIN posts_like ON posts.id=posts_like.post_id left join members on members.id=posts.member_id where posts.id=$post_id   Group by posts.id ");
        return $query->result_array();
    }

    public function getUserDetails($id)
    {
        $this->db->select('first_name,last_name,image');
        $this->db->from('members');
        $this->db->where(array('id' => $id));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return array();
        }
    }

    public function deletePostsArray($ids)
    {
        $this->db->where_in('id', $ids);
        return $this->db->delete('posts');
    }

    public function hidePostsImage($id)
    {
        $this->db->where('id', $id);
        return $this->db->update('posts', ['show_in_posts' => 0]);
    }
}