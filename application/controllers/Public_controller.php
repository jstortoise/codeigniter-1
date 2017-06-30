<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Public_controller extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->helper('tree_helper');
        $this->load->helper('url');
    }

    public function index($reference_link = false)
    {
        $data=[];
        $data['reference_link']=null;
        if ($reference_link !== false) {
            $data['reference_link']=$reference_link;
        }
        if ($this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect(base_url('dashboard'), 'refresh');
        } else {
//            $this->load->model('member_model');
//            $data['members'] = $this->member_model->get();
            $this->load->view('public/index', $data);
        }
    }

    public function register_member()
    {
        $tables = $this->config->item('tables', 'ion_auth');
        $identity_column = $this->config->item('identity', 'ion_auth');
        $this->data['identity_column'] = $identity_column;
        $this->form_validation->set_rules('first_name', 'First Name', 'required');
        $this->form_validation->set_rules('last_name', 'Last Name', 'required');
        $this->form_validation->set_rules('email', 'Email Address', 'required|valid_email|is_unique[' . $tables['users'] . '.email]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
        $this->form_validation->set_rules('password_confirm', 'Confirm Password', 'required');
        $this->form_validation->set_rules('gender', 'Gender', 'required');
        $this->form_validation->set_rules('birthday[0]', 'birthday', 'required');
        $this->form_validation->set_rules('birthday[1]', 'birthday', 'required');
        $this->form_validation->set_rules('birthday[2]', 'birthday', 'required');
        $this->form_validation->set_message('is_unique', '%s not available.');
        if ($this->form_validation->run() == true) {
            $this->load->model('member_model');
            $reference_link=$this->input->post('reference_link');
            $parent_id=1;
            if($reference_link){
                $temp=$this->member_model->get_id(simple_decrypt($reference_link))[0]['id'];
                if($temp){
                    $parent_id=$temp;
                }
            }
            $email = strtolower($this->input->post('email'));
            $identity = ($identity_column === 'email');
            $password = $this->input->post('password');
            $date = implode("-", $this->input->post('birthday'));
            $date_fomate = date('Y-m-d', strtotime($date));
            $reference_link = simple_encrypt($email);
            //give 20 points to every new user
            $points=20;
            if($parent_id!=1){
                //give 10 additional points to user that registered by referal link
                $points+=10;
            }

            $additional_data = array(
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name'),
                'gender' => $this->input->post('gender'),
                'parent_id' => $parent_id,
                'birthday' => $date_fomate,
                'reference_link' => $reference_link,
                'points' => $points
            );
            $user_id = $this->ion_auth->register($identity, $password, $email, $additional_data);
            if ($user_id != false) {
                if ($this->ion_auth->login($this->input->post('email'), $this->input->post('password'))) {
                    $this->session->set_flashdata('message', $this->ion_auth->messages());
                    redirect(base_url('dashboard/memberdetail'), 'refresh');
                } else {
                    // if the login was un-successful
                    // redirect them back to the login page
                    $this->session->set_flashdata('message', $this->ion_auth->errors());
                    redirect('/', 'refresh'); // use redirects instead of loading views for compatibility with MY_Controller libraries
                }
            } else {
                $this->data['message'] = $this->ion_auth->errors();
                $this->load->view('public/index', $this->data);
            }
        } else {
            // display the create user form
            // set the flash data error message if there is one
            $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
            $this->load->view('public/index', $this->data);
        }
    }

    public function login()
    {
        $this->data['title'] = "Login";
        //validate form input
        $this->form_validation->set_rules('identity', 'Email', 'required');
        $this->form_validation->set_rules('login_password', 'Password', 'required');
        if ($this->form_validation->run() == true) {
            // check to see if the user is logging in
            // check for "remember me"
            $remember = (bool)$this->input->post('remember');
            if ($this->ion_auth->login($this->input->post('identity'), $this->input->post('login_password'), $remember)) {
                //if the login is successful
                //redirect them back to the Dashboard page
                $this->session->set_flashdata('message', $this->ion_auth->messages());
                redirect(base_url('dashboard'), 'refresh');
            } else {
                // if the login was un-successful
                // redirect them back to the login page
                $this->session->set_flashdata('message', $this->ion_auth->errors());
                redirect('/', 'refresh'); // use redirects instead of loading views for compatibility with MY_Controller libraries
            }
        } else {
            // the user is not logging in so display the login page
            // set the flash data error message if there is one
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
            $this->load->view('public/index', $this->data);
        }
    }


    // Activate Account After registration
    public function activate($id, $code = false)
    {
        error_reporting(0);
        $activation = false;
        if ($code !== false) {
            $activation = $this->ion_auth->activate($id, $code);
        }
        if ($activation) {
            $this->load->model('member_model');
            $memberData = $this->member_model->get_user_data($id);
            if ($memberData[0]['parent_id']) {
                $this->member_model->give_points_for_reffer($memberData[0]['parent_id']);
            }
            if ($this->ion_auth->logged_in()) {
                redirect(base_url('dashboard'), 'refresh');
                //$this->session->set_flashdata('message', $this->ion_auth->messages());
            }
            //$this->session->set_flashdata('message', $this->ion_auth->messages());
        } else {
            //$this->session->set_flashdata('message', $this->ion_auth->errors());
        }
        redirect(base_url(), 'refresh');
    }


    function forgot_password()
    {
        if ($this->ion_auth->logged_in()) {
            redirect(base_url('dashboard'), 'refresh');
        }
        // setting validation rules by checking wheather identity is username or email
        if ($this->config->item('identity', 'ion_auth') != 'email') {
            $this->form_validation->set_rules('identity', $this->lang->line('forgot_password_identity_label'), 'required');
        } else {
            $this->form_validation->set_rules('email', $this->lang->line('forgot_password_validation_email_label'), 'required|valid_email');
        }
        if ($this->form_validation->run() == false) {
            // setup the input
            $this->data['email'] = array(
                'name' => 'email',
                'id' => 'email'
            );
            if ($this->config->item('identity', 'ion_auth') != 'email') {
                $this->data['identity_label'] = $this->lang->line('forgot_password_identity_label');
            } else {
                $this->data['identity_label'] = $this->lang->line('forgot_password_email_identity_label');
            }
            // set any errors and display the form
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
            $this->load->view('public/forgot_password', $this->data);
        } else {
            $identity_column = $this->config->item('identity', 'ion_auth');
            $identity = $this->ion_auth->where($identity_column, $this->input->post('email'))->users()->row();
            if (empty($identity)) {
                if ($this->config->item('identity', 'ion_auth') != 'email') {
                    $this->ion_auth->set_error('forgot_password_identity_not_found');
                } else {
                    $this->ion_auth->set_error('forgot_password_email_not_found');
                }
                $this->session->set_flashdata('message_forgot_password', $this->ion_auth->errors());
                redirect(base_url('public/forgot_password'), 'refresh');
            }
            // run the forgotten password method to email an activation code to the user
            $forgotten = $this->ion_auth->forgotten_password($identity->{$this->config->item('identity', 'ion_auth')});
            if ($forgotten) {
                // if there were no errors
                $this->session->set_flashdata('message_forgot_password', $this->ion_auth->messages());
                redirect(base_url('public/forgot_password'), 'refresh'); //we should display a confirmation page here instead of the login page
            } else {
                $this->session->set_flashdata('message_forgot_password', $this->ion_auth->errors());
                redirect(base_url('public/forgot_password'), 'refresh');
            }
        }
    }

    public function reset_password($code = NULL)
    {
        if (!$code) {
            show_404($this->uri->uri_string);
        }
        $user = $this->ion_auth->forgotten_password_check($code);
        if ($user) {
            // if the code is valid then display the password reset form
            $this->form_validation->set_rules('new_password', $this->lang->line('reset_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
            $this->form_validation->set_rules('new_confirm', $this->lang->line('reset_password_validation_new_password_confirm_label'), 'required');
            if ($this->form_validation->run() == false) {
                // display the form
                // set the flash data error message if there is one
                $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
                $this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
                $this->data['user_id'] = $user->id;
                $this->data['code'] = $code;
                // render
                $this->load->view('public/reset_password', $this->data);
            } else {
                // do we have a valid request?
                if ($user->id != $this->input->post('user_id')) {
                    // something fishy might be up
                    $this->ion_auth->clear_forgotten_password_code($code);
                } else {
                    // finally change the password
                    $identity = $user->{$this->config->item('identity', 'ion_auth')};
                    $change = $this->ion_auth->reset_password($identity, $this->input->post('new_password'));
                    if ($change) {
                        // if the password was successfully changed
                        $this->session->set_flashdata('message', $this->ion_auth->messages());
                        redirect(base_url(), 'refresh');
                    } else {
                        $this->session->set_flashdata('message', $this->ion_auth->errors());
                        redirect(base_url('public/reset_password/') . $code, 'refresh');
                    }
                }
            }
        } else {
            // if the code is invalid then send them back to the forgot password page
            $this->session->set_flashdata('message', $this->ion_auth->errors());
            redirect(base_url('public/forgot_password'), 'refresh');
        }
    }

}
