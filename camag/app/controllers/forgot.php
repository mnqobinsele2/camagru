<?php

class Forgot extends Controller {
    public function index(){
        if (isset($_GET['email']) && isset($_GET['ver'])){
            $db = $this->model('Login_Model')->connect();
            $this->view('home/reset');
        } else {
            header('Location:'.  URL);
        }
    }

    public function reset(){
        $db = $this->model('Login_Model')->connect();
        if (isset($_POST['reset_pass'])){
            Session::passReset($db);
        }
        header('Location:' . URL);
    }

    public function setreset(){
        $db = $this->model('Login_Model')->connect();
        if (isset($_POST['reset_pass']) && !(empty($_POST['email']))){
            $mail = $_POST['email'];
            $hash = md5(rand(10, 9856));
            Session::forgotMail($hash, $mail);
            Session::setHash($db, $hash, $mail);
        }
        header('Location:'.  URL);
    }
}