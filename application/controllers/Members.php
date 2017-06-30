<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Members extends Members_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('member_model');
        $this->load->helper('tree_helper');
        $this->load->helper('url');
        $id = $this->session->userdata('user_id');
        $data = [
            'last_activity_timestamp' => date('Y-m-d h:i:s', time()),
            'is_login' => 1
        ];
        $this->member_model->update_members_profile($id, $data);
    }

//    public function index()
//    {
//        $this->load->view('website/index');
//    }

    private function addGlobalData(){
        $this->data['me'] = $this->member_model->get_user($this->session->userdata('user_id'))[0];
        $this->data['me']->member_url = parent::makeMemberUrl($this->data['me']->id, $this->data['me']->profile_url);
        $temp = parent::getTopText();
        $this->data['topText'] = $temp->text;
        $this->data['topImage'] = $temp->image;
    }


    public function logout()
    {
        $id = $this->session->userdata('user_id');
        $data = [
            'last_activity_timestamp' => date('Y-m-d h:i:s', time()),
            'is_login' => 0
        ];
        $this->member_model->update_members_profile($id, $data);
        // log the user out
        $this->ion_auth->logout();
        // redirect them to the login page
        $this->session->set_flashdata('message', $this->ion_auth->messages());
        redirect(base_url(), 'refresh');
    }

    public function report()
    {
        $email = $this->input->post('email');
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('reported_issue', 'Message', 'required');
        $id = $this->session->userdata('user_id');
        $this->data['title'] = "Edit User";
        $this->data['getStep1ProfileDetails'] = $this->member_model->getStep1ProfileDetails($id);
        $user = $this->ion_auth->user($id)->row();
        $groups = $this->ion_auth->groups()->result_array();
        $currentGroups = $this->ion_auth->get_users_groups($id)->result();
        if ($this->form_validation->run() == true) {
            $insert_issue = $this->member_model->insertIssue();
            if ($insert_issue) {
                $this->data['message'] = "Your report is submitted successfullt, We will get back to you as soon as possible.";
            } else {
                $this->data['message'] = "Sorry, something went wrong. Please try again later!.";
            }
        }
        $this->load->view('members/report', $this->data);
    }


    public function resend_activation_email(){
        $data = ['id'=>$this->me->id, 'activation'=>$this->me->activation_code];
        $to = $this->me->email;
        $subject = "Orriz - Account Activation";
        $body = $this->load->view('public/email/activate', $data, true);
        echo parent::sendEmail($to, $subject, $body);
        exit;
    }

    public function edit_profile()
    {
        $id = $this->session->userdata('user_id');
        $this->data['title'] = "Edit User";
        $this->data['getStep1ProfileDetails'] = $this->member_model->getStep1ProfileDetails($id);

//        $groups = $this->ion_auth->groups()->result_array();
//        $currentGroups = $this->ion_auth->get_users_groups($id)->result();
        // validate form input
        $this->form_validation->set_rules('first_name', $this->lang->line('edit_user_validation_fname_label'), 'required');
        $this->form_validation->set_rules('last_name', $this->lang->line('edit_user_validation_lname_label'), 'required');
        // $this->form_validation->set_rules('phone', $this->lang->line('edit_user_validation_phone_label'), 'required');
        // $this->form_validation->set_rules('company', $this->lang->line('edit_user_validation_company_label'), 'required');
        // $this->form_validation->set_rules('city', $this->lang->line('edit_user_validation_fname_label'), 'required');
        // $this->form_validation->set_rules('country', $this->lang->line('edit_user_validation_lname_label'), 'required');

        if (isset($_POST) && !empty($_POST)) {
            // do we have a valid request?
            //if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id')) {
            //    show_error($this->lang->line('error_csrf'));
            //}
            //// update the password if it was posted
            //if ($this->input->post('password')) {
            //    $this->form_validation->set_rules('password', $this->lang->line('edit_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
            //$this->form_validation->set_rules('password_confirm', $this->lang->line('edit_user_validation_password_confirm_label'), 'required');
            //}
            $city = $this->input->post('city');
            $country = $this->input->post('country');
            $relationship_status = $this->input->post('relationship_status');
            $religion = $this->input->post('religion');
            $school = $this->input->post('school');
            $college = $this->input->post('college');
            $university = $this->input->post('university');
            $intrest_in_dating = $this->input->post('dating');
            $intrest_in_friends = $this->input->post('friends');
            $intrest_in_serious_relationship = $this->input->post('serious_relationship');
            $intrest_in_networking = $this->input->post('networking');

            $city = isset($city) ? $city : '';
            $country = isset($country) ? $country : '';
            $relationship_status = isset($relationship_status) ? $relationship_status : '';
            $religion = isset($religion) ? $religion : '';
            $school = isset($school) ? $school : '';
            $college = isset($college) ? $college : '';
            $university = isset($university) ? $university : '';
            $intrest_in_dating = isset($intrest_in_dating) ? 1 : 0;
            $intrest_in_friends = isset($intrest_in_friends) ? 1 : 0;
            $intrest_in_serious_relationship = isset($intrest_in_serious_relationship) ? 1 : 0;
            $intrest_in_networking = isset($intrest_in_networking) ? 1 : 0;

            if ($this->form_validation->run() === TRUE) {
                $data = array(
                    'first_name' => $this->input->post('first_name'),
                    'last_name' => $this->input->post('last_name'),
                    'city' => $city,
                    'country' => $country,
                    'relationship_status' => $relationship_status,
                    'religion' => $religion,
                    'school' => $school,
                    'college' => $college,
                    'university' => $university,
                    "intrest_in_dating" => $intrest_in_dating,
                    "intrest_in_friends" => $intrest_in_friends,
                    "intrest_in_serious_relationship" => $intrest_in_serious_relationship,
                    "intrest_in_networking" => $intrest_in_networking,
                );


                // update the password if it was posted
                if ($this->input->post('password')) {
                    $data['password'] = $this->input->post('password');
                }
                // Only allow updating groups if user is admin
                if ($this->ion_auth->is_admin()) {
                    //Update the groups user belongs to
                    $groupData = $this->input->post('groups');
                    if (isset($groupData) && !empty($groupData)) {
                        $this->ion_auth->remove_from_group('', $id);
                        foreach ($groupData as $grp) {
                            $this->ion_auth->add_to_group($grp, $id);
                        }
                    }
                }
                // check to see if we are updating the user
                if ($this->ion_auth->update($this->me->id, $data)) {
                    $this->session->set_flashdata('message', $this->ion_auth->messages());
                    redirect('members/edit_profile', 'refresh');
                } else {
                    $this->session->set_flashdata('message', $this->ion_auth->errors());
                    redirect('members/edit_profile', 'refresh');
                }
            }
        }
        $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
        $this->addGlobalData();
        $this->load->view('members/edit_profile', $this->data);
    }

    public function edit_about_yourself()
    {
        $id = $this->session->userdata('user_id');
        $user = $this->ion_auth->user($id)->row();
        $this->data['title'] = "Edit User";
        $this->data['getStep2ProfileDetails'] = $this->member_model->getStep1ProfileDetails($id);
        $this->data['getStep1ProfileDetails'] = $this->data['getStep2ProfileDetails'];
        $this->form_validation->set_rules('music', 'Music', 'trim');
        $this->form_validation->set_rules('movies', 'Movies', 'trim');
        $this->form_validation->set_rules('tv', 'TV Status', 'trim');
        $this->form_validation->set_rules('books', 'Books', 'trim');
        $this->form_validation->set_rules('sports', 'Sports', 'trim');
        $this->form_validation->set_rules('interests', 'Interests Relationship', 'trim');
        $this->form_validation->set_rules('best_feature', 'Best Feature', 'trim');
        $this->form_validation->set_rules('dreams', 'Dreams', 'trim');
        $this->form_validation->set_rules('about_me', 'About Me', 'trim');
        if (isset($_POST) && !empty($_POST)) {
            if ($this->form_validation->run() === TRUE) {
                $data = [
                    'music' => $this->input->post('music'),
                    'movies' => $this->input->post('movies'),
                    'tv' => $this->input->post('tv'),
                    'books' => $this->input->post('books'),
                    'sports' => $this->input->post('sports'),
                    'interests' => $this->input->post('interests'),
                    'best_feature' => $this->input->post('best_feature'),
                    'dreams' => $this->input->post('dreams'),
                    'about_me' => $this->input->post('about_me')
                ];
                // check to see if we are updating the user
                if ($this->ion_auth->update($user->id, $data)) {
                    $this->session->set_flashdata('message', $this->ion_auth->messages());
                    redirect('members/edit_about_yourself', 'refresh');
                } else {
                    $this->session->set_flashdata('message', $this->ion_auth->errors());
                    redirect('members/edit_about_yourself', 'refresh');
                }
            }
        }
        $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
        $this->addGlobalData();
        $this->load->view('members/edit_about_yourself', $this->data);
    }

    public function set_avatar()
    {
        if (isset($_POST['filename'])) {
            $oldAvatar=$this->me->image;
            $upload_path = "public/images/photos/";
            $thumb_path="public/images/thumb/";
            $thumb_width = "150";
            $thumb_height = "150";
            $filename = $_POST['filename'];
            $large_image_location = $upload_path . $filename;
            $thumb_image_location = $thumb_path . $_POST['filename'];
            $x1 = $_POST["x1"];
            $y1 = $_POST["y1"];
            $x2 = $_POST["x2"];
            $y2 = $_POST["y2"];
            $w = $_POST["w"];
            $h = $_POST["h"];
            $scale = $thumb_width / $w;
            $cropped = resizeThumbnailImage($thumb_image_location, $large_image_location, $w, $h, $x1, $y1, $scale);
            $data = [
                'image' => $cropped
            ];
            $user_id = $this->me->id;
            $this->member_model->update_members_profile($user_id, $data);
            if($oldAvatar) {
                unlink($thumb_path . $oldAvatar);
            }
            if ($cropped) {
                echo json_encode(['result' => 'ok']);
            } else {
                echo json_encode(['result' => 'error']);
            }
        } else{
            echo json_encode(['result' => 'error']);
        }
    }


//    public function view($view, $data = null, $returnhtml = false)
//    {
//        //I think this makes more sense
//        $this->viewdata = (empty($data)) ? $this->data : $data;
//        $view_html = $this->load->view($view, $this->viewdata, $returnhtml);
//        if ($returnhtml)
//            return $view_html; //This will return html on 3rd argument being true
//    }

    public function change_password()
    {
        $id = $this->session->userdata('user_id');
        $this->data['getStep1ProfileDetails'] = $this->member_model->getStep1ProfileDetails($id);
        $user = $this->ion_auth->user($id)->row();

        $this->data['me'] = $this->member_model->get_user($this->session->userdata('user_id'))[0];
        $this->data['me']->member_url = parent::makeMemberUrl($this->data['me']->id, $this->data['me']->profile_url);
        $temp = parent::getTopText();
        $this->data['topText'] = $temp->text;
        $this->data['topImage'] = $temp->image;

        //change_password($identity, $old, $new)
        $this->form_validation->set_rules('password', 'password', 'required');
        $this->form_validation->set_rules('new_password', $this->lang->line('reset_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
        $this->form_validation->set_rules('new_confirm', $this->lang->line('reset_password_validation_new_password_confirm_label'), 'required');
        if (isset($_POST) && !empty($_POST)) {
            if ($this->form_validation->run() === TRUE) {
                if ($this->ion_auth->change_password($user->email, $this->input->post('password'), $this->input->post('new_password'))) {
                    //if the login is successful
                    //redirect them back to the Dashboard page
                    // p($this->ion_auth->messages());
                    $this->session->set_flashdata('message', $this->ion_auth->messages());
                    redirect(base_url('members/change_password'), 'refresh');
                } else {
                    // if the login was un-successful
                    // redirect them back to the login page
                    $this->session->set_flashdata('message', $this->ion_auth->errors());
                    redirect(base_url('members/change_password'), 'refresh'); // use redirects instead of loading views for compatibility with MY_Controller libraries
                }
            } else {
                $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
                $this->data['password'] = $this->input->post('password');
                $this->data['new_password'] = $this->input->post('new_password');
                $this->data['new_confirm'] = $this->input->post('new_confirm');
                $this->session->set_flashdata('message', $this->data['message']);
                redirect(base_url('members/change_password'));
            }
        }
        $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
        $this->load->view('members/change_password', $this->data);
    }

    public function iamonline()
    {
        $id = $this->session->userdata('user_id');
        $update_last_seen = $this->member_model->updateLastSeen($id);
        if ($update_last_seen) {
            return true;
        }
        return false;
    }

    public function set_timezone_offset()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION['timezoneOffset'] = $_GET['timezoneOffset'];//set offset in minutes
    }

}
