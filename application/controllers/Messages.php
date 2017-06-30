<?php defined('BASEPATH') OR exit('No direct script access allowed');


class Messages extends Members_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('messages_model');
        $this->load->model('member_model');
        $this->load->library('pagination');
        $id = $this->session->userdata('user_id');
        $this->data['image'] = $this->me->image;
        $this->data['first_name'] = $this->me->first_name;
        $this->data['reference_link'] = $this->me->reference_link;
        $this->data['points'] = $this->me->points;
        $this->data['active'] = $this->me->active;
        $this->data['privacy'] = $this->me->privacy;
        $this->data['friends_list'] = $this->member_model->friend_list($id);
        $data = [
            'last_activity_timestamp' => date('Y-m-d h:i:s', time()),
            'is_login' => 1
        ];
        $this->member_model->update_members_profile($id, $data);
    }

    public function index()
    {
        $this->addGlobalData();
        $this->load->view('messages/index', $this->data);
    }

    private function addGlobalData(){
        $this->data['me'] = $this->member_model->get_user($this->session->userdata('user_id'))[0];
        $this->data['me']->member_url = parent::makeMemberUrl($this->data['me']->id, $this->data['me']->profile_url);
        $temp = parent::getTopText();
        $this->data['topText'] = $temp->text;
        $this->data['topImage'] = $temp->image;
    }

    public function compose($is_redirect = NULL)
    {
        $this->form_validation->set_rules('subject', 'Subject', 'required');
        $this->form_validation->set_rules('message', 'Message', 'required');
        if ($this->form_validation->run() == true) {
            $data = [
//                'sender_id' => $this->input->post('sender_id'),
                'sender_id' => $this->me->id,
                'receiver_id' => $this->input->post('receiver_id'),
                'subject' => $this->input->post('subject'),
                'message' => $this->input->post('message'),
                'thread_id' => $this->messages_model->define_thread($this->me->id, $this->input->post('receiver_id'))
            ];
            $this->messages_model->add_message($data);
            if ($is_redirect != 'no') {
                redirect(base_url('messages'));
            } else {
                return true;
            }
        } else {
            // display the create user form
            // set the flash data error message if there is one
            $this->session->set_flashdata('message', (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message'))));
            redirect(base_url('messages/index'), 'refresh');
        }
    }

    public function delete($id)
    {
        $this->messages_model->delete($id);
        redirect(base_url('messages/index'));
    }

    public function get_message($message_id)
    {
        $replies_array = array();
        $message_id = (int)$message_id;
        $parent_id = $this->messages_model->get_parent_id($message_id);
        $replies = $this->messages_model->get_replies($parent_id);
        $message_text = $this->messages_model->get_message_text($message_id);
        $message_text = htmlspecialchars_decode($message_text);
        $subject = $this->messages_model->get_subject_from_parent($parent_id);
        if (!empty($replies)) {
            foreach ($replies as $reply) {
                $image = '';
                if (!empty($reply['image'])) {
                    $image = $reply['image'];
                }
                $replies_array[] = array("reply_id" => $reply['id'],
                    "reply_from" => $reply['first_name'] . " " . $reply['last_name'],
                    "reply_text" => htmlspecialchars_decode($reply['message']),
                    "reply_date" => $reply['created_at'],
                    "image" => $image
                );
            }
        }
        $array = array(
            "message_id" => $message_id,
            "message_subject" => $subject,
            "message_text" => $message_text,
            "replies" => $replies_array
        );
        $string = json_encode($array);
        echo $string;
    }

    public function reply_to_message()
    {
        error_reporting(E_ALL);
        //$sender_id 			= (int)$this->input->post('sender_id');
        $sender_id = $this->session->userdata['user_id'];
        $message_id = (int)$this->input->post('message_id');
        $parent_id = $this->messages_model->get_parent_id($message_id);
        $subject = $this->messages_model->get_subject_from_parent($parent_id);
        $message = htmlspecialchars($this->input->post('message'));
        $receiver_id = $this->messages_model->get_receiver_id($message_id);

        $data = array(
            "parent_id" => $parent_id,
            "sender_id" => $sender_id,
            "receiver_id" => $receiver_id,
            "subject" => $subject,
            "message" => $message
        );

        $saveReply = $this->messages_model->save_reply($data);
        if ($saveReply) {
            $this->session->set_flashdata('message', 'Thanks for your reply');
            redirect(base_url('messages/index'));
        }
    }

    public function reply($id)
    {
        $threadData = $this->db->query("SELECT msg.* FROM messages msg WHERE msg.thread_id='$id' ORDER BY parent_id")->result_array();
        $this->data['thread_init'] = $threadData;
        $this->data['thread_end'] = end($threadData);
        if (isset($_POST) && !empty($_POST)) {
            $data = [
                'parent_id' => $this->input->post('parent_id'),
                'sender_id' => $this->input->post('sender_id'),
                'subject' => $this->input->post('subject'),
                'receiver_id' => $this->input->post('receiver_id'),
                'thread_id' => $this->messages_model->define_thread($this->input->post('sender_id'), $this->input->post('receiver_id')),
                'message' => $this->input->post('message')
            ];
            //print_r($data);        exit;
            $this->messages_model->save_thread($data);
            redirect(base_url('messages/index'));
        }
        $this->data['msgTypeFlag'] = 'reply';
        $this->load->view('messages/index', $this->data);
    }

    public function get_inbox()
    {
        $user_id = $this->me->id;
        $user_detail = $this->member_model->get_where($user_id);
        $user_detail = $user_detail[0];
        $friends_sql = "SELECT * FROM friends 
        						WHERE (friend_one = '" . $user_id . "' OR friend_two = '" . $user_id . "')
        ";
        $friends_array = $this->db->query($friends_sql)->result_array();
        $friends = array();
        foreach ($friends_array as $one) {
            if ($one['friend_one'] == $user_id) {
                $friends[] = $one['friend_two'];
            } elseif ($one['friend_two'] == $user_id) {
                $friends[] = $one['friend_one'];
            }
        }
        $friends = implode(",", $friends);
        if(!$friends) {
            $this->json("");
            exit;
        }
            $friends_details_sql = "SELECT id, profile_url, first_name,last_name,image FROM members WHERE id IN(" . $friends . ") ;";
            $friends = $this->db->query($friends_details_sql)->result_array();

            for ($i = 0; $i < count($friends); $i++) {
                $friends[$i]['member_url'] = parent::makeMemberUrl($friends[$i]['id'], $friends[$i]['profile_url']);
            }


        $sql = 'SELECT messages.id AS id,messages.sender_id sender_id,messages.subject subject,messages.message message,
                                    messages.receiver_id receiver_id,messages.created_at created_at,messages.is_read as is_read
                                FROM (SELECT * FROM messages WHERE is_archieved = "0" AND (receiver_id = "' . $user_id . '" OR sender_id = "' . $user_id . '") ORDER BY id DESC) as messages
                                WHERE is_archieved = "0"
                                AND (receiver_id = "' . $user_id . '" OR sender_id = "' . $user_id . '")
                                GROUP BY messages.parent_id
                                ORDER BY messages.id DESC
        ';

        $results = $this->db->query($sql)->result_array();

        foreach ($results as $key => $value) {
            $results[$key]['message'] = substr(strip_tags(htmlspecialchars_decode($value['message'])), 0, 30) . " ...";
            $results[$key]['name'] = "";
            $results[$key]['image'] = "";
            if ($value['sender_id'] == $user_id) {
                foreach ($friends AS $friend) {
                    if ($friend['id'] == $value['receiver_id']) {
                        $results[$key]['image'] = $friend['image'];
                        $results[$key]['name'] = $friend['first_name'] . " " . $friend['last_name'];
                        $results[$key]['member_url'] = $friend['member_url'];
                        break;
                    }
                }
            } else {
                foreach ($friends AS $friend) {
                    if ($friend['id'] == $value['sender_id']) {
                        $results[$key]['image'] = $friend['image'];
                        $results[$key]['name'] = $friend['first_name'] . " " . $friend['last_name'];
                        $results[$key]['member_url'] = $friend['member_url'];
                        break;
                    }
                }
            }
        }

        if (!empty($results)) {
            $this->json($results);
        } else {
            $this->json("");
        }
    }

    public function get_sentbox()
    {
        /*$user_id = $this->session->userdata('user_id');
        $this->db->select('messages.*, concat(members.first_name, members.last_name) as name, members.image');
        $this->db->where('sender_id', $user_id);
        $this->db->where('is_archieved', '0');
        $this->db->from('messages');
        $this->db->join('members', 'members.id = messages.receiver_id');
        $this->db->order_by('created_at', 'desc');
        $query = $this->db->get();
        if($query->num_rows() == 0) {
            $data = array();
        } else {
            $data = $query->result();
        }

        $this->json($data);*/
    }

    public function bulletin()
    {
        $errors = array();
        $post = $this->input->post();
        $user_id = $this->session->userdata('user_id');
        $friends_list = $this->member_model->friend_list($user_id);
        $deducted_amount = $this->messages_model->getBulletinPrice();
        $_POST['sender_id'] = $user_id;
        $_POST['subject'] = $post['subject'];
        $_POST['message'] = $post['message'];

        foreach ($friends_list as $friend) {
            $_POST['receiver_id'] = $friend['id'];
            $compose = $this->compose("no");
            if (!$compose) {
                $errors[] = "Error with user " . $friend['id'];
            }
        }
        if (empty($errors)) {
            $deduct = $this->member_model->deduct($user_id, $deducted_amount);
            $this->session->set_flashdata("message", "Your bulletin message has been sent to all friends!.");
            redirect("messages/index");
        } else {
            print_r($errors);
        }
    }

    public function mark_as_read()
    {
        if (!empty($_POST['message_id'])) {
            $message_id = (int)$_POST['message_id'];
            $results = $this->messages_model->mark_message_read($message_id);
            if ($results) {
                echo "ok";
            } else {
                echo "failed";
            }
        }else{
            echo "failed";
        }
    }

    private function json($date)
    {
        $this->output->set_header('Last-Modified: ' . gmdate('D, d M Y H:i:s', (time() - 24 * 60 * 60)) . ' GMT');
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
        $this->output->set_header("Cache-Control: post-check=0, pre-check=0");
        $this->output->set_header("Pragma: no-cache");
        $this->output->set_content_type('application/json');
        echo json_encode($date);
    }

}