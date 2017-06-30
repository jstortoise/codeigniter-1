<?php

if (!defined('BASEPATH'))

    exit('No direct script access allowed');

class Messages_model extends CI_Model
{
    public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
        $this->load->database();
    }

    public function add_message($data)
    {
        $query = "INSERT INTO messages (sender_id, receiver_id, subject, message, thread_id) VALUES(" . $data['sender_id'] . "," . $data['receiver_id'] . ",'" . $data['subject'] . "','" . $data['message'] . "','" . $data['thread_id'] . "')";
        if ($this->db->query($query)) {
            $message_id = $this->db->insert_id();
            $sql2 = "UPDATE messages SET parent_id = '" . $message_id . "' WHERE id = '" . $message_id . "' ;";
            $this->db->query($sql2);
        }
    }

    public function get_sent_messages($id)
    {
        $query = $this->db->query('SELECT msg.*, mem.first_name, mem.last_name, mem.image FROM messages msg LEFT JOIN members mem ON mem.id = msg.sender_id WHERE msg.sender_id=' . $id . " AND msg.is_archieved=0 GROUP BY thread_id LIMIT 0,1");
        return $query->result_array();
    }

    public function get_received_messages($id)
    {
        $query = $this->db->query('SELECT msg.*, mem.first_name, mem.last_name, mem.image FROM messages msg LEFT JOIN members mem ON mem.id = msg.receiver_id WHERE msg.receiver_id=' . $id . " AND msg.is_archieved=0 "); //GROUP BY thread_id LIMIT 0,1
        return $query->result_array();
    }

    public function define_thread($sen_id, $rec_id)
    {
        $threadArr = [$sen_id, $rec_id];
        sort($threadArr);
        return implode('-', $threadArr);
    }

    public function delete($id)
    {
        $user_id = $this->session->userdata('user_id');
        $this->db->query("UPDATE messages SET is_archieved=1 WHERE (sender_id=" . $user_id . " || receiver_id=" . $user_id . ") AND id=" . $id);
    }

    public function save_thread($data)
    {
        $query = "INSERT INTO messages (parent_id, sender_id, receiver_id, subject, message, thread_id) VALUES(" . $data['parent_id'] . "," . $data['sender_id'] . "," . $data['receiver_id'] . ",'" . $data['subject'] . "','" . $data['message'] . "','" . $data['thread_id'] . "')";
        $this->db->query($query);
    }

    public function get_thread($threadId)
    {
        $this->db->select('*');
        $query = $this->db->query('SELECT * FROM messages msg WHERE msg.thread_id=' . $threadId);
        return $query->result_array();
    }

    public function get_original_message($id)
    {
        $id = (int)$id;
        $sql = "SELECT * FROM messages WHERE id = '" . $id . "' ;";
        $results = $this->db->query($sql)->result_array();
        if (!empty($results)) {
            return $results[0];
        } else {
            return false;
        }
    }

    public function get_subject_from_parent($parent_id)
    {
        $parent_id = (int)$parent_id;
        $sql = "SELECT subject FROM messages WHERE id = '" . $parent_id . "' LIMIT 1 ;";
        $results = $this->db->query($sql)->result_array();
        if (!empty($results)) {
            return $results[0]['subject'];
        }
        return false;
    }

    public function save_reply($data = array())
    {
        $thread_id = $data['sender_id'] . "-" . $data['receiver_id'];
        $sql = "INSERT INTO messages (`parent_id`,`subject`,`sender_id`,`receiver_id`,`message`,`thread_id`,`created_at`) 
                            VALUES ('" . $data['parent_id'] . "','" . $data['subject'] . "',
                            '" . $data['sender_id'] . "','" . $data['receiver_id'] . "',
                            '" . $data['message'] . "','" . $thread_id . "',NOW()) ;";
        $results = $this->db->query($sql);
        if ($results) {
            return true;
        } else {
            return false;
        }
    }

    public function get_receiver_id($message_id)
    {
        $user_id = $this->session->userdata('user_id');
        $message_id = (int)$message_id;
        $sql = "SELECT sender_id,receiver_id FROM messages WHERE id = '" . $message_id . "' LIMIT 1 ;";
        $results = $this->db->query($sql)->result_array();
        if (!empty($results)) {
            $sender_id = $results[0]['sender_id'];
            $receiver_id = $results[0]['receiver_id'];
            if ($sender_id == $user_id) {
                return $receiver_id;
            } else {
                return $sender_id;
            }
        }
        return false;
    }

    public function get_replies($parent_id)
    {
        $sql = "SELECT messages.id AS id,messages.parent_id parent_id,messages.sender_id sender_id,
                                messages.receiver_id receiver_id,messages.message message,messages.created_at created_at,
                                members.id member_id,members.first_name first_name,members.last_name last_name,members.image image
                            FROM messages,members
                            WHERE sender_id = members.id
                            AND messages.parent_id = '" . $parent_id . "' 
                            ORDER BY created_at DESC
                        ;";
        $results = $this->db->query($sql)->result_array();
        if (!empty($results)) {
            return $results;
        } else {
            return false;
        }
    }

    public function get_parent_id($message_id)
    {
        $message_id = (int)$message_id;
        $sql = "SELECT parent_id FROM messages WHERE id = '" . $message_id . "' LIMIT 1 ;";
        $results = $this->db->query($sql)->result_array();
        if (!empty($results)) {
            return $results[0]['parent_id'];
        }
    }

    public function get_message_text($message_id)
    {
        $sql = "SELECT message FROM messages WHERE id = '" . $message_id . "' ;";
        $results = $this->db->query($sql)->result_array();
        if (!empty($results)) {
            return $results[0]['message'];
        } else {
            return false;
        }
    }

    public function mark_message_read($message_id)
    {
        $parent_id = $this->get_parent_id($message_id);
        $user_id = $this->session->userdata('user_id');
        $sql = "UPDATE messages SET is_read = '1' WHERE parent_id = '" . $parent_id . "' AND receiver_id = '" . $user_id . "' ; ";
        $results = $this->db->query($sql);
        if ($results) {
            return true;
        } else {
            return false;
        }
    }

    public function getBulletinPrice()
    {
        $sql = "SELECT `value` FROM setting WHERE `key` = 'bulletin' ;";
        $results = $this->db->query($sql)->result_array();
        if (!empty($results)) {
            return $results[0]['value'];
        } else {
            return false;
        }
    }

}