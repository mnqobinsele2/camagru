<?php

class Gallery extends Controller {
    public function index(){
        $this->view('gallery/index', $_SESSION);
    }

    protected function delete(){
        $db = $this->model('Photos')->connect();
       
    }

    public function gallery_count(){
        $db = $this->model('Photos')->connect();
        $this->model('Photos')->getCountGallery($db);       
    }

    public function getgallery(){
        $db = $this->model('Photos')->connect();
        $images = $this->model('Photos')->getGallery($db);
        echo json_encode($images);
    }
    public function comment(){
        $db = $this->model('Photos')->connect();
        $this->model('Photos')->setComment($db);
        header('Location: '. URL . 'gallery/');
    }

    public function like(){
        $db = $this->model('Photos')->connect();
        $this->model('Photos')->setLike($db);
    }

    public function comments(){
        $db = $this->model('Photos')->connect();
        $comments = $this->model('Photos')->getComments($db);
        echo json_encode($comments);
    }

    public function lc_counts(){
        if (isset($_GET['img_id'])) {
            $id = $_GET['img_id'];
            $db = $this->model('Photos')->connect();
            $comments = $this->model('Photos')->getCountComments($db, $id);
            $likes = $this->model('Photos')->getCountLikes($db, $id);
            $res = [$likes, $comments];
            
            echo json_encode($res);
        } else {
            echo 'Hello';
        }
    }

    public function checklikes(){
        if (isset($_GET['isLiked'])) {
            $db = $this->model('Photos')->connect();
            $this->model('Photos')->isLiked($db);
        }
    }
}