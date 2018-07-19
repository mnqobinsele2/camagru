<?php 
	require_once 'database.php';
	
	try {
		$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
		$sql = "CREATE DATABASE IF NOT EXISTS camagru";
        $db->exec($sql);
        
		$sql = "USE camagru;
        CREATE TABLE `users` (
            `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `username` varchar(10) NOT NULL,
            `email` varchar(100) NOT NULL,
            `u_pass` varchar(100) NOT NULL,
            `active` varchar(100) NOT NULL DEFAULT 'No',
            `ver_hash` varchar(100) NOT NULL,
            `notifs` varchar(6) NOT NULL DEFAULT 'true'
        );
        CREATE TABLE `gallery` (
            `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `user_id` int(11) NOT NULL,
            `image` text NOT NULL,
            `date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        );
        CREATE TABLE `comments` (
            `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `img_id` int(11) NOT NULL,
            `user_id` int(11) NOT NULL,
            `username` varchar(255) NOT NULL,
            `comment` text NOT NULL,
            `date_comment` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        );
        CREATE TABLE `likes` (
            `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `img_id` int(11) NOT NULL,
            `user_id` int(11) NOT NULL,
            `username` varchar(255) NOT NULL,
            `date_like` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        );";
		$db->exec($sql);
	}
	catch(PDOException $e)
	{
		echo $e->getMessage();
		die();
    }
    
    header('Location: ' . URL);
