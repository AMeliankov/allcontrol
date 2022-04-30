<?php

class SecurityController {
    
    public function actionIndex() 
    {
        UsersModel::checkUsersRole(); 

        if (isset($_POST['code'])) {
            $code = $_POST['code'];
            $workerArray = WorkersModel::validateSecurityWorkers($code);
            if ($workerArray) {  
                $idWorker = $workerArray['w_id'];
                $name = $workerArray['name']; 
                $surname = $workerArray['surname']; 
                $father = $workerArray['father'];
                // берем последню запись работника из бд, из таблице info
                $workerInfo = InfoModels::chekInfoSecurity($idWorker);
                $idInfo = $workerInfo['id']; 
                if (!empty($workerInfo)) {   
                    if ($workerInfo['flag'] == 1){ 
                        $timeIntervalStart = InfoModels::getTimeInterval($workerInfo['start'], date("Y-m-d H:i:s"));
                        if ($timeIntervalStart > 10) {
                            // добавляем время ухода
                            $addTimeExit = InfoModels::addTimeExit($idInfo);
                            if ($addTimeExit){                         
                                // получаем start, finish, для рачета времени работы
                                $timeArrey = InfoModels::getInfoById($idInfo);
                                if ($timeArrey){
                                    // добавляем время работы
                                    $AddTimeWork = InfoModels::addTimeWork($idInfo, $timeArrey['start'], $timeArrey['finish'], 2);
                                    if($AddTimeWork){
                                        $result = self::messageSuccess('Ушел', $code, $surname, $name, $father);
                                    }
                                } else {
                                    $result = self::messageError('Ошибка получения данных!');
                                } 
                            } else {
                                $result = self::messageError('Ошибка добавления ухода!');
                            }
                        } else {
                            $result = self::messageInfo('Прошло меньше 10 минут');
                        }
                    } elseif ($workerInfo['flag'] !== 1) { 
                        $timeIntervalFinish = InfoModels::getTimeInterval($workerInfo['finish'], date("Y-m-d H:i:s"));
                        if ($timeIntervalFinish > 10) {
                            $addInfo = InfoModels::addInfo($idWorker);
                            if ($addInfo) {
                                $result = self::messageSuccess('Пришел', $code, $surname, $name, $father);
                            } else {
                               $result = self::messageError('Ошибка создания записи!');
                            }
                        } else {
                            $result = self::messageInfo('Прошло меньше 10 минут!');
                        }
                    }     
                } else {
                    $addInfo = InfoModels::addInfo($idWorker);
                    if ($addInfo) {
                        $result = self::messageSuccess('Пришел', $code, $surname, $name, $father);
                    } else {
                        $result = self::messageError('Ошибка создания записи!');
                    }  
                }
            } else {
                $result = self::messageError('Такого пропуска не существует!');
            }
            include_once ROOT. '/views/security/securityAjax.php'; 
        } else {
            include_once ROOT. '/views/security/securityIndex.php'; 
        }

        return true;
    }
    
    public static function messageError($message)
    {
        return '<div class="alert alert-danger alert-dismissible fade show" role="alert"><h2>'.$message.'<h2></div>';
    }
 
    public static function messageInfo($message)
    {
        return '<div class="alert alert-info alert-dismissible fade show" role="alert"><h2>'.$message.'<h2></div>';
    }
    
    
    public static function messageSuccess($message, $code, $surname, $name, $father)
    {
        return '<div class=" alert alert-success alert-dismissible fade show" style="height: 360px;">
            <div class="row">
                <div class="col" >
                <br><br><br>
                    <img class="img-fluid" style="" src="/photo/'.$code.'.png"" alt="">
                </div>
                <div class="col">
                    <h1 class="text-center"><b>'.$message.'</b></h1>

                    <div class="form-group">
                        <label for="name">Фамилия:</label>
                        <input class="form-control" type="text" value="'.$surname.'" disabled >
                    </div>

                    <div class="form-group">
                        <label for="name">Имя:</label>
                        <input class="form-control" type="text" value="'.$name.'" disabled >
                    </div>

                    <div class="form-group">
                        <label for="name">Отчество:</label>
                        <input class="form-control" type="text" value="'.$father.'" disabled >
                    </div>
                </div>
            </div>
        </div>';
    }  
}
