<?php

class Messages_hook
{
    function do_i_have_new_message()
    {
        $CI = &get_instance();
        $user_id = $CI->session->userdata('user_id');

        if (!empty($user_id)) {
            $sql = "SELECT COUNT(id) AS count FROM messages WHERE receiver_id = '" . $user_id . "' AND is_read = 0 GROUP BY parent_id; ";
            $results = $CI->db->query($sql)->result();
            if (!empty($results)) {
                $CI->session->set_userdata('new_messages', count($results));
            } else {
                $CI->session->set_userdata('new_messages', 0);
            }
        }
    }

}