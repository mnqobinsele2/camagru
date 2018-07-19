<?php

class Verify extends Controller {
    public function index(){
        $db = $this->model('Login_Model')->connect();
        Session::activateAcc($db);
        if (Session::loggedIn()){
            Session::set('stat', 'Yes');   
        }
        header('Location:'.  URL);
    }
}