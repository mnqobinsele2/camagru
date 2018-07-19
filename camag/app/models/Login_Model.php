<?php

class Login_Model extends Model{
    public function __construct(){
        Session::set('error', '');
    }

    public function loginUser($db, $arr = []){
        $stmt = $db->prepare("SELECT * FROM users WHERE `username` = ? AND `u_pass` = ?");
        $stmt->execute($arr);
        if($user = $stmt->fetch(PDO::FETCH_ASSOC)){
            Session::set('loggedIn', true);
            Session::set('id', $user['id']);
            Session::set('user', $user['username']);
            Session::set('email', $user['email']);
            Session::set('notifs', $user['notifs']);
            Session::set('stat', $user['active']);
            header('Location: '. URL);
        } else {
            Session::set('error', 'Incorrect login credintials');        
            header('Location: '.LOGIN);
        }
    }

    public function registerUser($db){
        $hash = md5(rand(0, 3563));
        $username = stripslashes(trim($_POST['username']));
        $email = $_POST['email'];
        $pass1 = md5($_POST['pass1'] . '42wtc');
        $pass2 = md5($_POST['pass2'] . '42wtc');
        $password = $_POST['pass1'];
        if($pass1 == $pass2){
            if (Session::verPass($_POST['pass1'])){
                if (!Session::userExists($db, [$username])){
                    if (!Session::emailExists($db, [$email])){
                        if (filter_var($email, FILTER_VALIDATE_EMAIL)){
                            $sql = "INSERT INTO users(`username`, `email`, `u_pass`, `ver_hash`) 
                            VALUES(?, ?, ?, ?)";
                            $stmt = $db->prepare($sql);
                            $arr1 = [$username, $email, $pass1, $hash];
                            $arr2 = [$username, $email, $password, $hash];
                            if($stmt->execute($arr1)){
                                Session::verMail($arr2);
                                Session::set('error', 'Successfully Registered! An activation link has been sent to your email for verification.');
                            }
                        }else{
                            Session::set('error', 'Please enter a valid email address!');
                        }
                    }
                }
            }
        } else {
            Session::set('error', 'Passwords do not match!');
        }
    }
}