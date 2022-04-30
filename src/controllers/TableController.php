<?php

class TableController {
   
    public function actionIndex()
    {
        UsersModel::checkUsersRole(); 

        if (isset($_POST['search'])) {
            $year = $_POST['year'];
            $month= $_POST['month'];
            $search = $_POST['search'];
            $commander = $_POST['commander'];
            $dayName = TableModel::getArrayWeek($year, $month);
            $tableAjax = TableModel::getTableWorkersInfo($year, $month, $search, $commander);
            include_once ROOT. '/views/table/tableAjax.php';
        } else {
            $monthArray = Data::month;
            $yearArray = Data::year;
            $commanderList = WorkersModel::getCommanderList();
            include_once ROOT. '/views/table/tableIndex.php';
        }

        return true;
    } 
}
