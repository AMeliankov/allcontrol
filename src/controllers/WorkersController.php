<?php

class WorkersController {
  
    public function actionIndex() 
    {
        UsersModel::checkUsersRole();

        $countWorkersAll = WorkersModel::getCountWorkers();
        $countWorkersProfession = WorkersModel::getCountWorkesProfession();

        if (isset($_POST['search'])) {
            $search = $_POST['search'];
            $workersList = WorkersModel::getWorkersList($search);
            include_once ROOT. '/views/workers/workersAjax.php';  
        } else {
            include_once ROOT. '/views/workers/workersIndex.php';
        } 

        return true;
    }
     
    //  просмотр
    public function actionView($id) 
    {
        UsersModel::checkUsersRole();

        $workersView = WorkersModel::workersView($id);

        include_once ROOT. '/views/view/viewIndex.php';

        return true;   
    }
  
    //  добавление
    public function actionAdd() 
    { 
        UsersModel::checkUsersRole();

        if (isset($_POST['add'])) {
            $name = $_POST['name'];
            $surname = $_POST['surname'];
            $father = $_POST['father'];
            $smena = $_POST['smena'];
            $profession = $_POST['profession'];
            $commander = $_POST['commander'];
            $phone = $_POST['phone'];
            $filename = $_FILES["image"]["tmp_name"];
            $workersAdd = WorkersModel::workersAdd($name, $surname, $father, $smena, $profession, $commander, $phone, $filename);
            if ($workersAdd) {
                header("Location: /workers"); 
            }
        } else {
            $commanderList = WorkersModel::getCommanderList();  // массив с бригадирами
            $profession = ProfessionModel::getProfessionList();
            $smena = Data::smena; //списк смен
            include_once ROOT. '/views/workers/workersAdd.php';   
        }

        return true;   
    }
    
    // изименение
    public function actionEdit() 
    {
        UsersModel::checkUsersRole();

        if (isset($_POST['arreyIdEdit'])) { 
            $workersEdit = WorkersModel::getArrayWorkersId($_POST["workers"]);
            $professionList = ProfessionModel::getProfessionList(); //профессии
            $smenaList = Data::smena; //смены
            $commanderList = WorkersModel::getCommanderList(); //список бригадиров
            include_once ROOT. '/views/workers/workersEdit.php';  
        }

        if (isset($_POST['workersformedit'])) { 
            $edit = WorkersModel::workersEdit($_POST["workers"]);
            if ($edit) {
                header("Location: /workers");  
            }   
        }

        return true;  
    }
    
    // печать
    public function actionPrint() 
    { 
        UsersModel::checkUsersRole(); 

        if (isset($_POST['arreyIdPrint'])) {
            $workers = $_POST['workers'] ;
            $workersPrint = WorkersModel::workersPrint($workers);
            include_once ROOT. '/views/workers/workersPrint.php'; 
        }

        return true;   
    }
    
    // удаление
    public function actionDelete()
    {
        UsersModel::checkUsersRole();

        if (isset($_POST['arreyIdDelete'])) {
            $workers = $_POST['workers'] ;
            WorkersModel::workersDelete($workers);
        }  

        return true;   
    }
}
