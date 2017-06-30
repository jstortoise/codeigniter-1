<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Images extends Members_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->ion_auth->logged_in() == false) {
            redirect(base_url());
        }
        $this->load->model('member_model');
        $this->load->model('photos_model');
        date_default_timezone_set('UTC');
    }

    private $type = '';

    public function gallery()
    {
        $photoId = $this->input->post('fakeFormPhotoId');
        $data = [];
        $data['openPhotoId'] = $photoId ? $photoId : null;

        $data['me'] = $this->member_model->get_user($this->session->userdata('user_id'))[0];
        $data['me']->member_url = parent::makeMemberUrl($data['me']->id, $data['me']->profile_url);
        $data['userGallery'] = false;

        $this->type = 'gallery';
        $data = array_merge($data, $this->getDataForPhotos());

        $this->load->view('photos/gallery', $data);
    }

    private function getDataForPhotos($memberId = null)
    {
        if (!$memberId) {
            $memberId = $this->session->userdata('user_id');
        }
        $data = [];
        $data['photos'] = $this->photos_model->getMemberPhotos($memberId, $this->type);
        $membersIds = [];

        foreach ($data['photos'] as $photo) {
            if (count($photo->likes)) {
                foreach ($photo->likes as $like) {
                    array_push($membersIds, $like);//$like here is just id of member that liked post
                }
            }
            if (count($photo->comments)) {
                foreach ($photo->comments as $comment) {
                    array_push($membersIds, $comment->member_id);
                }
                usort($photo->comments, function ($a, $b) {
                    return strtotime($a->created_at) - strtotime($b->created_at);
                });
                foreach ($photo->comments as $comment) {
                    $comment->created_at = parent::convertToUserTimezone($comment->created_at);
                }
            }
        }
        $membersIds = array_unique($membersIds);
        $members = $this->member_model->get_user_data_by_array($membersIds);
        $temp = [];
        foreach ($members as $member) {
            $member->member_url = parent::makeMemberUrl($member->id, $member->profile_url);
            $temp[$member->id] = $member;
        }
        usort($data['photos'], function ($a, $b) {
            return strtotime($b->created_at) - strtotime($a->created_at);
        });
        $data['members'] = $temp;
        return $data;
    }

    public function add_photos()
    {
        $this->load->view('photos/addPhotos');
    }

    public function upload_ajax()
    {
        $id=$this->session->userdata('user_id');
        if(!$id){
            exit;
        }
        $file_formats = array("jpg", "png", "gif", "bmp");
        $filepath = "public/images/photos/";
        $name = $_FILES['imagefile']['name']; // filename to get file's extension
        $size = $_FILES['imagefile']['size'];
        $tmp = $_FILES['imagefile']['tmp_name'];
        list($width, $height) = getimagesize($tmp);
        if ($height < 200 || $width < 200 || $height / $width < 0.3 || $width / $height < 0.3) {
            echo json_encode(['result'=>'error', 'message'=>'Incorrect image size!']);
            exit();
        }

        if (strlen($name)) {
            $extension = strtolower(substr($name, strrpos($name, '.') + 1));
            if (in_array($extension, $file_formats)) { // check it if it's a valid format or not
                if ($size < (2048 * 1024)) { // check it if it's bigger than 2 mb or no
                    $imagename = md5(uniqid() . time()) . "." . $extension;
                    $tmp = $_FILES['imagefile']['tmp_name'];
                    if (move_uploaded_file($tmp, $filepath . $imagename)) {
                        $this->photos_model->addPhoto($id, $imagename);
                        echo(json_encode(['result'=>'ok', 'image'=>$imagename]));
                        exit;
                    } else {
                        echo json_encode(['result'=>'error', 'message'=>'Could not move the file']);
                    }
                } else {
                    echo json_encode(['result'=>'error', 'message'=>'Your image size is bigger than 2MB']);
                }
            } else {
                echo json_encode(['result'=>'error', 'message'=>'Invalid file format']);
            }
        } else {
            echo json_encode(['result'=>'error', 'message'=>'Please select image!']);
        }
        exit();
    }

    public function set_title_ajax()
    {
        $photoId = $this->input->post('photoId');
        $title = $this->input->post('title');

        if ($photoId) {
            if ($this->photos_model->setPhotoTitle($this->session->userdata('user_id'), $photoId, $title)) {
                echo json_encode(['result' => 'ok']);
            } else {
                echo json_encode(['result' => 'error']);
            }
        } else {
            echo json_encode(['result' => 'error']);
        }
    }

    public function delete_photo_ajax()
    {
        $photoId = $this->input->post('photoId');
        if ($photoId) {
            if ($this->photos_model->deletePhoto($this->session->userdata('user_id'), $photoId)) {
                echo json_encode(['result' => 'ok']);
            } else {
                echo json_encode(['result' => 'error']);
            }
        } else {
            echo json_encode(['result' => 'error']);
        }
    }

    public function save_comment_ajax()
    {
        $photoId = $this->input->post('photoId');
        $comment = $this->input->post('comment');

        if ($photoId && $comment) {
            if ($this->photos_model->savePhotoComment($photoId, $comment)) {
                echo json_encode(['result' => 'ok', 'date' => parent::convertToUserTimezone(gmdate("Y-m-d  H:i:s"))]);
            } else {
                echo json_encode(['result' => 'error']);
            }
        } else {
            echo json_encode(['result' => 'error']);
        }
    }

    public function like_ajax()
    {
        $photoId = $this->input->post('photoId');
        if ($photoId) {
            if ($this->photos_model->likePhoto($photoId)) {
                echo json_encode(['result' => 'ok']);
            } else {
                echo json_encode(['result' => 'error']);
            }
        } else {
            echo json_encode(['result' => 'error']);
        }
    }

    public function unlike_ajax()
    {
        $photoId = $this->input->post('photoId');
        if ($photoId) {
            if ($this->photos_model->unlikePhoto($photoId)) {
                echo json_encode(['result' => 'ok']);
            } else {
                echo json_encode(['result' => 'error']);
            }
        } else {
            echo json_encode(['result' => 'error']);
        }
    }

    public function get_user_photos_ajax()  //this action is for dashboard, so we don't display photos for only gallery
    {
        $memberId = $this->input->post('memberId');
        $photoId = $this->input->post('photoId');
        $this->type = 'posts';
        $data = $this->getDataForPhotos($memberId);
        $data['path'] = base_url() . "public/images/photos/";
        $data['photoIdActive'] = $photoId;
        return $this->load->view('photos/carousel', $data);
    }
}