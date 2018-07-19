<?php

class Settings extends Controller {
    public function __construct(){
        if (!Session::loggedIn() || (Session::get('stat') == 'No'))
        {
            header('Location: '. URL);
        }
    }
    public function index(){
        $this->view('settings/index');
    }

    public function setupdate(){
        $db = $this->model('Login_Model')->connect();
        Session::update($db);
        header('Location: '. URL . 'settings');
    }
}