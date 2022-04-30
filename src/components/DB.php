<?php


class DB {
    
    public static function getConnection() {

        $host = 'database-allcontrol';
        $dbname = 'allcontrol';
        $user = 'root'; 
        $pass = 'root'; 
     
        $dsn = "mysql:host=$host;port=3306;dbname=$dbname;charset=utf8";
       
        $opt = [
        //    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        //    PDO::ATTR_EMULATE_PREPARES   => false,
        //    PDO::ATTR_CURSOR             => PDO::CURSOR_FWDONLY,
        ];
        
        try {
            $db = new PDO($dsn, $user, $pass, $opt);
        } catch (PDOException $e) {
            die('Не удалось подключиться к бд: ' . $e->getMessage());
        }
      
        return $db;
    }
}
