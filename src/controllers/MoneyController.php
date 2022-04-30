<?php

class MoneyController {
   
    public function actionIndex() 
    {
        UsersModel::checkUsersRole();

        if (isset($_POST['search'])) {
            $year = $_POST['year'];
            $month= $_POST['month'];
            $search = $_POST['search'];
            $commander = $_POST['commander'];
            $workersMoney = MoneyModels::workersMoney($year, $month, $search, $commander);
            include_once ROOT. '/views/money/moneyAjax.php'; 
        } else {
            $monthArray = Data::month;
            $yearArray = Data::year;
            $commanderList = WorkersModel::getCommanderList(); 
            include_once ROOT. '/views/money/moneyIndex.php';   
        }   

        return true;    
    }
    
    public function actionAdd() 
    {
        UsersModel::checkUsersRole();
       
        if (isset($_POST['moneyAdd'])) {  
            $worker = $_POST['worker'];
            $type = $_POST['type'];
            $money = $_POST['money'];
            $date = $_POST['date'];
            $moneyAdd = MoneyModels::moneyAdd($worker, $type, $money, $date);

            if($moneyAdd) {
               header('location: /money');
            } 
        }
      
        return true;     
    }
    
    public function actionClose($id) 
    {
       UsersModel::checkUsersRole();
        
        $moneyClose = MoneyModels::moneyClose($id);

        if ($moneyClose) {
            header('location: /money');
        } 
      
        return true;      
    }

    public function actionDelete($id) 
    {
        UsersModel::checkUsersRole();

        $moneyDelete = MoneyModels::moneyDelete($id);

        if ($moneyDelete) {
            header('location: /money');
        } 

        return true;        
    }
}
