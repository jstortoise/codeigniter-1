<?php

class Cron extends CI_Controller
{
    private $isAdmin=false;
    public function __construct()
    {
        parent::__construct();
        $this->isAdmin=isset($_SESSION['admin_id']);
        if (!$this->input->is_cli_request() && !$this->isAdmin) {
            echo('Direct access is not allowed');
            return false;
        }
        date_default_timezone_set('UTC');
        $this->load->database();
        $this->load->model('admin_model');
        $this->load->model('posts_model');
        echo "\r\n" . date('Y-m-d H:i:s') . " - Cron Started --> ";
        if ($this->isAdmin){
            ob_clean();
        }
    }

    public function postclear()
    {
        $duration = intval($this->admin_model->get_post_duration());
        $postsToDeleteArray = $this->admin_model->get_posts_for_delete($duration);

        $ids = [];
        $idsToHide = [];
        $imagesToDelete = [];

        foreach ($postsToDeleteArray as $post) {
            if ($post->show_in_gallery == 0) {
                array_push($ids, $post->id);
                if ($post->photos) {
                    array_push($imagesToDelete, $post->photos);
                }
            } elseif ($post->show_in_posts == 1) {
                array_push($idsToHide, $post->id);
            }
        }

        $count = count($ids);

        if (!$count) {
            echo("No expired posts found.");
        } else {
            $this->posts_model->deletePostsArray($ids);
            echo("$count expired posts successfully deleted.");
            foreach ($imagesToDelete as $image) {
                unlink('public/images/photos/' . $image);
            }
        }

        $count = count($idsToHide);
        foreach ($idsToHide as $id) {
            $this->posts_model->hidePostsImage($id);
        }
        if ($count) {
            echo(" $count posts successfully hided.");
        }
    }
}