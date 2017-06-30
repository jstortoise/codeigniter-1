<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Photos_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getMemberPhotos($memberId, $type)
    {
        $this->db->select('p.id, p.member_id, p.status as title, p.photos as photo, p.time as created_at,
        pl.id as likeId, pl.member_id as likeMemberId, 
        pc.id as commentId, pc.member_id as commentMemberId, pc.comment, pc.timestamp as commentCreated');
        $this->db->from('posts as p');
        $this->db->where(['p.member_id' => $memberId])->where('p.photos IS NOT NULL AND p.photos != ""', null, false);
        if ($type == 'gallery') {
            $this->db->where(['p.show_in_gallery' => 1]);
        }
        if ($type == 'posts') {
            $this->db->where(['p.show_in_posts' => 1]);
        }
        $this->db->join('posts_like as pl', 'pl.post_id = p.id', 'left');
        $this->db->join('posts_comment as pc', 'pc.post_id = p.id', 'left');
        $query = $this->db->get();
        $res = $query->result();
        $result = [];

        //merging dublicate join fields
        foreach ($res as $r) {
            $flag = true;
            foreach ($result as $temp) {
                if ($r->id == $temp->id) {
                    if ($r->likeId) {
                        array_push($temp->likes, (object)['id' => $r->likeId, 'member_id' => $r->likeMemberId]);
                    }
                    if ($r->commentId) {
                        array_push($temp->comments, (object)['id' => $r->commentId, 'member_id' => $r->commentMemberId, 'comment' => $r->comment, 'created_at' => $r->commentCreated]);
                    }
                    $flag = false;
                }
            }
            if ($flag) {
                $obj = (object)['id' => $r->id,
                    'member_id' => $r->member_id,
                    'photo' => $r->photo,
                    'title' => $r->title,
                    'created_at' => $r->created_at,
                    'likes' => [],
                    'comments' => []
                ];
                if ($r->likeId) {
                    array_push($obj->likes, (object)['id' => $r->likeId, 'member_id' => $r->likeMemberId]);
                }
                if ($r->commentId) {
                    array_push($obj->comments, (object)['id' => $r->commentId, 'member_id' => $r->commentMemberId, 'comment' => $r->comment, 'created_at' => $r->commentCreated]);
                }
                array_push($result, $obj);
            }
        }

        //removing dublicate likes and comments
        foreach ($result as $r) {
            $likes = [];
            foreach ($r->likes as $l) {
                $likes[$l->id] = $l->member_id;
            }

            $comments = [];
            foreach ($r->comments as $c) {
                $comments[$c->id] = (object)['member_id' => $c->member_id, 'comment' => $c->comment, 'created_at' => $c->created_at];
            }
            $r->likes = $likes;
            $r->comments = $comments;
        }

        return $result;
    }

    public function addPhoto($userId, $imagename)
    {
        if (!$userId || !$imagename) {
            return false;
        }
        return $this->db->insert('posts', ['member_id' => $userId, 'photos' => $imagename]);
    }

    public function deletePhoto($memberId, $photo_id)
    {
        $query = $this->db->get_where('posts', ['id' => $photo_id]);
        $filename = $query->result()[0]->photos;

        $this->db->select('image');
        $query = $this->db->get_where('members', ['id' => $memberId]);
        $im = $query->result()[0]->image;

        if ($this->db->delete('posts', ['id' => $photo_id, 'member_id' => $memberId])) {
            unlink('public/images/photos/' . $filename);
            if ($im && $im == $filename) {
                if (
                $this->db->update('members', ['image' => null], ['id' => $memberId])
                ) {
                    unlink('public/images/thumb/' . $filename);
                }
            }
            return true;
        } else {
            return false;
        }
    }

    public function setPhotoTitle($memberId, $photo_id, $title)
    {
        return $this->db->update('posts', ['status' => $title], ['member_id' => $memberId, 'id' => $photo_id]);
    }

    public function savePhotoComment($photoId, $comment)
    {
        if (!$photoId || !$comment) {
            return false;
        }
        return $this->db->insert('posts_comment', ['member_id' => $this->session->userdata('user_id'),
            'post_id' => $photoId,
            'comment' => $comment,
            'timestamp' => gmdate("Y-m-d  H:i:s")]);
    }

    public function likePhoto($id)
    {
        $this->unlikePhoto($id);
        return $this->db->insert('posts_like', ['member_id' => $this->session->userdata('user_id'), 'post_id' => $id]);
    }

    public function unlikePhoto($id)
    {
        return $this->db->delete('posts_like', ['post_id' => $id, 'member_id' => $this->session->userdata('user_id')]);
    }
}