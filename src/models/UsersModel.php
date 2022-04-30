<?php

class UsersModel {
 
    public static function checkLogin() 
    {
        if (isset($_SESSION['userId'])) {
            return $_SESSION['userId'];
        } 

        return false;   
    }
    
    public static function auth($u_id)
    {
        $_SESSION['userId'] = $u_id;
    }
    
    public static function checkUsersData($login, $password)
    {
        $db = DB::getConnection();
        
        $sql = 'SELECT * FROM users WHERE login = :login AND status = :status';
        $result = $db->prepare($sql);
        $result->execute([
            ':login' => $login,
            ':status' => 1,
        ]);

        $user = $result->fetch();
        
        $verify = password_verify($password, $user['password']);
        
        if ($verify) {
            return $user['u_id'];
        } else {
            return false;
        }
    }
    
    public static function getInfoUsersById($u_id)
    {
        $db = DB::getConnection();

        $sql = 'SELECT * FROM users , role  WHERE role = r_id AND u_id = :id';
        $result = $db->prepare($sql);
        $result->execute([
            ':id' => $u_id,
        ]);

        $userInfo = [];
        while($row = $result->fetch()){
            $userInfo['id'] = $row['u_id'];
            $userInfo['name'] = $row['name'];
            $userInfo['login'] = $row['login'];
            $userInfo['password'] = $row['password'];
            $userInfo['role'] = $row['r_role'];  
            $userInfo['status'] = $row['status'];  
        }

        return $userInfo;
    }
    
    public static function checkUsersRole()
    {
        // Проверка сессии.
        $u_id = self::checkLogin(); 
        
        if ($u_id !== false) {
            $userInfo = self::getInfoUsersById($u_id);
            $role = $userInfo['role'];
            $arrayRole = Role::role;
            $path = preg_replace('/\d/', '', trim($_SERVER['REQUEST_URI'], '/'));
            
            $pathArray = [];
            if (array_key_exists($role, $arrayRole)) {
                 foreach ($arrayRole as $key => $value) {

                    if ($key == $role){   
                        $pathArray = $value;
                        break;
                    }
                }
            }

            if (in_array($path, $pathArray)) {
                foreach ($pathArray as $value1) {
                    if($path == $value1){ 
                        break;
                    }
                } 
            } else {
                $index = $pathArray['index'];
                header("Location: /$index"); 
                exit(); 
            }
            
        } else {
            header("Location: /login"); 
        } 
    }
    
    public static function getUsersList() 
    {
        $db = DB::getConnection();

        $usersList = [];

        $sql = 'SELECT * FROM users ';
        $result = $db->prepare($sql);
        $result->execute();

        $usersList = $result->fetchAll();

        return $usersList;  
    }
    
    public static function getRoleList() 
    {
        $db = DB::getConnection();

        $roleList = [];

        $sql = 'SELECT * FROM role ';
        $result = $db->prepare($sql);
        $result->execute();

        $roleList = $result->fetchAll();

        return $roleList;    
    }
    
    public static function usersAdd($login, $password, $name, $role) 
    {
        $db = DB::getConnection();

        $password = preg_replace('/ /', '',$password);
        $user = $db->prepare("INSERT INTO users (login, password, name, role, status) VALUES (:login, :password, :name, :role, :status)");
        $user->execute([
            ':name' => $name,
            ':login' => preg_replace('/ /', '',$login),
            ':password' => password_hash($password, PASSWORD_DEFAULT),
            ':role' => $role,
            ':status' => 1,
        ]);

        if ($user) {
            return true;  
        }
    }
       
    public static function usersEdit($id, $login, $password, $name, $role, $status) 
    {
        $db = DB::getConnection();

        if (!empty($password)) {
            $sql = "UPDATE users SET login = :login, password = :password, name = :name, role = :role, status = :status WHERE u_id = :id"; 
            $data = [
                ':login' => preg_replace('/ /', '',$login),
                ':name' => $name,
                ':role' => $role,
                ':password' => password_hash($password, PASSWORD_DEFAULT),
                ':status' => $status,
                ':id' => $id,
            ];
        } else {
            $sql = "UPDATE users SET login = :login, name = :name, role = :role, status = :status WHERE u_id = :id"; 
            $data = [
                ':login' => preg_replace('/ /', '',$login),
                ':name' => $name,
                ':role' => $role,
                ':status' => $status,
                ':id' => $id,
            ];
        }
        
        $result = $db->prepare($sql);
        $result->execute($data);
        
        if ($result) {
           return true; 
        }
    }
    
    public static function usersDelete($id) 
    {
        $db = DB::getConnection();
        
        $sql = "DELETE FROM users WHERE u_id = :id";
        $result = $db->prepare($sql);
        $result->execute([
            ':id' => $id,
        ]);

        if ($result) {
           return true;
        }
    }  
}
