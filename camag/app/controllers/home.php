<?php

class Home extends Controller {
    public function __construct(){
        if (!Session::loggedIn())
        {
            header('Location: ' . URL . 'login');
        }
    }
    public function index(){

        $this->view('home/index', $_SESSION);
    }

    public function logout(){
        Session::destroy();
        header('Location: ' . URL . 'login');
    }

    public function upload(){
        $db = $this->model('Login_Model')->connect();
        $f_upload = $this->model('Photos')->setImages($db);       
    }

    public function get_images(){
        $db = $this->model('Login_Model')->connect();
        
        if(Session::loggedIn() && ($_GET['q'] == 'imgs')) {
            $start = intval($_GET['a']);
            $imgpp = intval($_GET['z']);

            $sql = "SELECT * FROM gallery WHERE user_id = :id ORDER BY date_time DESC LIMIT :start, :end";
            $stmt = $db->prepare($sql);
            $stmt->bindValue(':id', Session::get('id'));
            $stmt->bindValue(':start', $start, PDO::PARAM_INT);
            $stmt->bindValue(':end', $imgpp, PDO::PARAM_INT);
            $stmt->execute();
            $images = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            echo json_encode($images);
        }
    }
}