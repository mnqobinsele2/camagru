<?php

class Session {
    static function set($key, $value){
        $_SESSION[$key] = $value;
    }

    static function get($key){
        return $_SESSION[$key];        
    }

    static function destroy(){
        session_destroy();        
    }

    static function loggedIn() {
		if (isset($_SESSION['loggedIn']) && !empty($_SESSION['loggedIn'])) {
			return (TRUE);
		}
		return (FALSE);
    }

    public static function secure($data) {
        $str = trim($data);
        $str = strip_tags($str);
        return ($str);
    }

    static function secureName($data) {
        $str = trim($data);
        $str = stripslashes($data);
        $str = strip_tags($str);
        return ($str);
    }

    static function userExists($db, $arr = []){
        $stmt = $db->prepare("SELECT username FROM users WHERE username = ?");
        $stmt->execute($arr);
        if($user = $stmt->fetch(PDO::FETCH_ASSOC)){
            Session::set('error', 'The username you have chosen already exist in our database!');
            return (TRUE);
        }
        return (FALSE);
    }

    static function emailExists($db, $arr = []){
        $stmt = $db->prepare("SELECT email FROM users WHERE email = ?");
        $stmt->execute($arr);
        if($user = $stmt->fetch(PDO::FETCH_ASSOC)){
            Session::set('error', 'That email belongs to someone, reset password if you forgot your login password!');
            return (TRUE);
        }
        return (FALSE);
    }

    static function verMail($arr = []){
        $to = $arr[1]; // Send email to our user
        $subject = 'Camagru | Signup'; // Give the email a subject
        $message = '
        Thanks for signing up!
        Your account has been created, you can login with the following credentials after you have activated your
        ------------------------
        Username: '.$arr[0].'
        Password: '.$arr[2].'
        ------------------------
        
        Please click this link to activate your account:
        http://localhost:8080/camagru/public/verify?email='.$arr[1].'&ver='.$arr[3].'
        '; 
        $headers = 'From:noreply@yourwebsite.com' . "\r\n"; 
        mail($to, $subject, $message, $headers); 
    }

    static function forgotMail($hash, $mail){
        $to = $mail;
        $subject = 'Camagru | Password Reset'; 
        $message = '
        
        Please click this link to reset your password:
        http://localhost:8080/camagru/public/forgot?email='.$to.'&ver='.$hash.'
        '; 
        $headers = 'From:noreply@yourwebsite.com' . "\r\n"; 
        mail($to, $subject, $message, $headers);
    }

    static function ActivateAcc($db){
        if(!empty($_GET['email'])){
            $sql = "UPDATE users SET active = ? WHERE email = ? AND ver_hash = ?";
            $stmt = $db->prepare($sql);
            if($stmt->execute(['Yes', $_GET['email'], $_GET['ver']])){
                Self::set('error', 'Successfully Verified your account, please login with your credintials.');
            }else {
                Self::set('error','Failed Verifying '.$mail);
            }
        }
    }

    static function passReset($db){
        if(!empty($_POST['email'])){
            $mail = $_POST['email'];
            $pass = md5($_POST['password'] . '42wtc');
            $ver = $_POST['ver'];
            $sql = "UPDATE users SET u_pass = ? WHERE email = ? AND ver_hash = ?";
            $stmt = $db->prepare($sql);
            if($stmt->execute([$pass, $mail, $ver])){
                Self::set('error', 'Successfully updated password.');
            }else {
                Self::set('error','Password reset failed!');
            }
        }
    }

    static function setHash($db, $hash, $mail){
        $sql = "UPDATE users SET ver_hash = ? WHERE email = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$hash, $mail]);
    }

    static function getImgOwner($db){
        $sql = "SELECT user_id FROM gallery WHERE id = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$_POST['img']]);
        $res = $stmt->fetch(PDO::FETCH_ASSOC);

        return $res['user_id'];
    }

    static function notifyUser($db, $id){
        $sql = "SELECT email, notifs FROM users  WHERE id = ?;";
        $stmt = $db->prepare($sql);
        $stmt->execute([$id]);

        $res = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($res['notifs'] == 'true'){
            $headers = 'From: Camagru' . "\r\n" .
            'Reply-To: amokone@student.wethinkcode.co.za' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();
            $subj = "New Comment";
            $message = "You have a new comment on one of your photos!";
            mail($res['email'], $subj, $message, $headers);
        }
    }

    static function verify($db){
        if (Self::get('user') != $_POST['username']){
            if (Self::userExists($db, [$_POST['username']]) === TRUE)
                return (FALSE);
        }
        if (Self::get('email') != $_POST['email']){
            if (Self::emailExists($db, [$_POST['email']]))
                return (FALSE);
        }
        return (TRUE);
    }
    static function update($db){
        if (Self::verify($db) === TRUE){
            if (!(empty($_POST['pass1']) && empty($_POST['pass2']))){
                if ($_POST['pass1'] == $_POST['pass2'] && Self::verPass($_POST['pass1'])){
                    $sql = "UPDATE users SET u_pass = ? WHERE id = ?";
                    $stmt = $db->prepare($sql);
                    $stmt->execute([md5($_POST['pass1'] . '42wtc'), Self::get('id')]);
                }else{
                    Self::set('error', 'Passwords do not match!');
                    return;
                }
            }
            if (Self::get('user') != $_POST['username']){
                $username = $_POST['username'];
                $stmt = $db->prepare("UPDATE users SET username = ? WHERE id = ?");
                if($stmt->execute([$username, Self::get('id')])){
                    Self::set('user', $username);
                }
            }
            if (Self::get('email') != $_POST['email']  && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
                $email = $_POST['email'];
                $stmt = $db->prepare("UPDATE users SET email = ? WHERE id = ?");
                if($stmt->execute([$_POST['email'], Self::get('id')])){
                    Self::set('email', $email);
                }
            }
            if (isset($_POST['notifs'])){
                try{
                    $sql = "UPDATE users SET notifs= ? WHERE id = ?";
                    $stmt = $db->prepare($sql);
                    $stmt->execute([$_POST['notifs'], Self::get('id')]);
                } catch (PDOExcption $e){
                }
            }
            Self::set('error', 'Update Successful');
        } else
            Self::set('error', 'Please enter valid inputs!');
    }
    static function verPass($pass){
        if (strlen($pass) >= 8){
            if (!ctype_lower($pass) && !ctype_upper($pass)){
                return (TRUE);
            }
        }
        Self::set('error', 'Password must contain a mixture of Capital letters, small letters, and numbers or symbol! Minimum length of 8 characters.');
        return (FALSE);
    }
}