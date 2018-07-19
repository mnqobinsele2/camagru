<?php

class Login extends Controller {
    public function __construct(){
        if (Session::loggedIn())
        {
            header('Location: '. URL);
        }
    }
    public function index(){
        $this->view('home/login');
    }

    public function forgot(){

        $this->view('home/forgot');
    }

    public function signin(){
        $db = $this->model('Login_Model')->connect();
        $login = $_POST['username'];
        $password = md5($_POST['password'] . '42wtc');
        $exec = [$login, $password];

        $this->model('Login_Model')->loginUser($db, $exec);
    }

    public function register(){
        $db = $this->model('Login_Model')->connect();
        $this->model('Login_Model')->registerUser($db);
        header('Location: '.LOGIN);        
    }
}