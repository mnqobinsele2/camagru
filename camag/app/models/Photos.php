<?php

class Photos extends Model {
/*  #===========================================================#
    #   User Images                                             #
    #===========================================================#*/
    public function setImages($db) {
        if (Session::loggedIn()){
            $data = $_POST['image'];
            $data = str_replace('data:image/png;base64,', '', $data);
            $data = str_replace(' ', '+', $data);
            $dataUnencoded = base64_decode($data);
            $file = chdir('../photos/') . uniqid() . '.png';
            $path = PICS . $file;
            $fp = fopen($file, 'wb');
            fwrite($fp, $dataUnencoded);
            fclose($fp);
            $sql = "INSERT INTO gallery (user_id, image) VALUES (?, ?)";
            $stmt = $db->prepare($sql);
            $stmt->execute([$_SESSION['id'], $path]);
        }
    }

    public function dropImage($db) {
        if(Session::loggedIn() && isset($_POST['delete'])) {
            $file = $_POST['delete'];
            $sql = "DELETE FROM gallery WHERE `image` = ? AND `user_id` = ?";
            $stmt = $db->prepare($sql);
            $stmt->execute([$file, Session::get('id')]);
            echo getcwd();
            chdir('../../');
            echo getcwd();
            
            unlink($file);
        }
    }

    function getCountImages($db){
        if(Session::loggedIn() && ($_GET['imgNum'] == 'fetch')) {
            $sql = "SELECT COUNT(id) AS total FROM gallery WHERE user_id = ?";
            $stmt = $db->prepare($sql);
            $stmt->execute([$_SESSION['id']]);
            $images = $stmt->fetch(PDO::FETCH_ASSOC);
    
            echo ($images['total']);
        }
    }

/*  #===========================================================#
    #   Gallery Images                                          #
    #===========================================================#*/
    function getGallery($db){
        if (isset($_GET['start']) && isset($_GET['end'])){
            $start = intval($_GET['start']);
            $imgpp = intval($_GET['end']);
            $sql = "SELECT id,image FROM gallery ORDER BY date_time DESC LIMIT :start, :end";
            $stmt = $db->prepare($sql);
            $stmt->bindValue(':start', $start, PDO::PARAM_INT);
            $stmt->bindValue(':end', $imgpp, PDO::PARAM_INT);
            $stmt->execute();
            $images = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $images;
        }
    }

    function getCountGallery($db){
        if($_GET['imgNum'] == 'fetch') {
            $sql = "SELECT COUNT(id) AS total FROM gallery";
            $stmt = $db->prepare($sql);
            $stmt->execute();
            $images = $stmt->fetch(PDO::FETCH_ASSOC);
    
            echo ($images['total']);
        }
    }

    function setComment($db) {
        if (Session::loggedIn()){
            $comment = Session::secure($_POST['comment']);//secure
            if(!empty($comment)) {
                $sql = "INSERT INTO comments (img_id, user_id, username,comment) VALUES (?, ?, ?, ?)";
                $stmt = $db->prepare($sql);
                $stmt->execute([$_POST['img'], $_SESSION['id'], $_SESSION['user'], $comment]);
                $u_id = Session::getImgOwner($db);
                Session::notifyUser($db, $u_id);
            }
        }
    }

    function setLike($db) {
        if (Session::loggedIn()){
            $sql = "INSERT INTO likes (img_id, user_id, username) VALUES (?, ?, ?)";
            $stmt = $db->prepare($sql);
            $stmt->execute([$_POST['like'], $_SESSION['id'], $_SESSION['user']]);
        }
    }

    function getComments($db) {
        $sql = "SELECT * FROM comments WHERE img_id = ? ORDER BY date_comment DESC";
        $stmt = $db->prepare($sql);
        $stmt->execute([$_GET['getCom']]);
        $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $comments;
    }

    function getCountLikes($db, $id){
        $sql = "SELECT COUNT(id) AS total FROM likes WHERE img_id = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$id]);
        $likes = $stmt->fetch(PDO::FETCH_ASSOC);

        return $likes;
    }

    function getCountComments($db, $id){
        $sql = "SELECT COUNT(id) AS total FROM comments WHERE img_id = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$id]);
        $comments = $stmt->fetch(PDO::FETCH_ASSOC);
    
        return $comments;
    }

    function isLiked($db){
        if(Session::loggedIn() && ($_GET['isLiked'] == 'fetch')) {
            $sql = "SELECT COUNT(id) AS state FROM likes WHERE user_id = ? AND img_id = ?";
            $stmt = $db->prepare($sql);
            $stmt->execute([$_SESSION['id'], $_GET['imgID']]);
            $liked = $stmt->fetch(PDO::FETCH_ASSOC);
    
            echo ($liked['state']);
        }
    }
}