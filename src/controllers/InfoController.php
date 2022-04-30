<?php

class InfoController {
    
    public function actionIndex()
    {
        UsersModel::checkUsersRole(); 

        if(isset($_POST['search'])){
            $search = $_POST['search']; 
            $infoAjax = InfoModels::getInfoWorkersList($search);
            include_once ROOT.'/views/info/infoAjax.php';
        } else {   
            $countProfessionWorkesInfo = InfoModels::countProfessionWorkes();
            $countAllWorkersInfo = InfoModels::getInfoCountWorkersAll(); // всего людей на территории
            $infoList = InfoModels::infoList(); // список работников на территори
            include_once ROOT.'/views/info/infoIndex.php';
        }

        return true;
    }
    
    // ушел, не отметился 
    public function actionExit($i_id, $w_id)
    {
        UsersModel::checkUsersRole();

        $addTmeWork = InfoModels::infoExit($i_id);
        $addShtraf = MoneyModels::moneyAdd($w_id, 's', 1000, date('Y-m-d') );

        if($addTmeWork && $addShtraf)
        {
            header("Location: /info"); 
        } 

        return true;  
    } 
}
