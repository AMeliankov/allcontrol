<?php

class UsersController {
    
    public function actionLogin()
    { 
        if (isset($_POST['submit'])) {
            $login = $_POST['login'];
            $password = $_POST['password'];
            $userId = UsersModel::checkUsersData($login, $password);
            if ($userId == false) {
                header("Location: /login");
            } else {
                UsersModel::auth($userId);
                header("Location: /workers");
            }
        } else {
            $userId = UsersModel::checkLogin();
            if($userId !== false){
                $userRole = UsersModel::checkUsersRole(); 
            }
        }
        
        require_once(ROOT . '/views/users/usersLogin.php');

        return true;  
    }
    
    public function actionExit() 
    {
        session_destroy();
        header('Location: /login'); 
    }
    
    public function actionIndex() 
    {
        UsersModel::checkUsersRole();
        $userList = UsersModel::getUsersList();
        require_once ROOT. '/views/users/usersIndex.php';
    }
    
    public function actionAdd() 
    {
        UsersModel::checkUsersRole(); 

        if (isset($_POST['userAdd'])) { 
            $login = $_POST['login'];
            $password = $_POST['password'];
            $name = $_POST['name'];
            $role = $_POST['role'];
            $userAdd = UsersModel::usersAdd($login, $password, $name, $role);
            if ($userAdd) {
                header('Location: /users');
            } 
        }

        $roleList = UsersModel::getRoleList();

        require_once ROOT. '/views/users/usersAdd.php';

        return true;
    }

    public function actionEdit($id) 
    {
        UsersModel::checkUsersRole();

        if (isset($_POST['userEdit'])) { 
            $login = $_POST['login'];
            $password = $_POST['password'];
            $name = $_POST['name'];
            $role = $_POST['role'];
            $status = $_POST['status'];
            $userEdit = UsersModel::usersEdit($id, $login, $password, $name, $role, $status);
            if ($userEdit) {
                header('Location: /users');  
            } 
        }

        $roleList = UsersModel::getRoleList();

        $userEdit = UsersModel::getInfoUsersById($id);

        require_once ROOT. '/views/users/usersEdit.php';

        return true;
    }
      
    public function actionDelete($id) 
    {
        UsersModel::checkUsersRole();

        $usersDelete = UsersModel::usersDelete($id);

        if ($usersDelete) {
            header('Location: /users');  
        } 
 
        return true;
    }  
}
