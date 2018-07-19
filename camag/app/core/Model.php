<?php

class Model {
    
    public function connect(){
        $DB_DSN = 'mysql:host=localhost;dbname=camagru;charset=utf8;';
        $DB_USER = 'root';
        $DB_PASSWORD = '';
    
        try {
            $db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        }
        catch(Exception $e) {
        }
        return $db;
    }
}