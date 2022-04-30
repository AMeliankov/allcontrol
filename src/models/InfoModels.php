<?php

class InfoModels {
    
    // Добавление времени ухода.
    public static function addTimeExit($i_id) 
    {
        $db = DB::getConnection();

        $sql = "UPDATE info SET finish = NOW() WHERE i_id = :id";
        $result = $db->prepare($sql);
        $result->execute([
            ':id' => $i_id
        ]);
        
        if ($result) {
            return true;
        } else {
            return false; 
        }
    }
    
    // Получение информации по id.
    public static function getInfoById($idInfo) 
    {
        $db = DB::getConnection();

        $sql = "SELECT * FROM info  WHERE i_id = :id";
        $result = $db->prepare($sql);
        $result->execute([
            ':id' => $idInfo
        ]);  
        
        $timeArray = $result->fetch();
        
        if (!empty($timeArray)) {
            return $timeArray;
        } else {
            return false;
        }
    }
    
    // Добавление времени работы.
    public static function addTimeWork($idInfo, $start, $finish, $flag) 
    {
        $db = DB::getConnection();
        
        // Время работы.
        $timeWork = abs(strtotime($start) - strtotime($finish)) / 60;  
        $timeWork = (int)$timeWork;
         
        $sql = "UPDATE info SET time = :time, flag = :flag WHERE i_id = :id";
        $result = $db->prepare($sql);
        $result->execute([  
            ':id' => $idInfo, 
            ':time' => $timeWork, 
            ':flag' => $flag,
        ]); 
        
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
    
    // Добавление пришел.
    public static function addInfo($idWorker) 
    {
        $db = DB::getConnection();

        $sql = "INSERT INTO info (worker, start, flag, date) VALUES (:id, NOW(), :flag, CURRENT_DATE())";
        $result = $db->prepare($sql);
        $result->execute([ 
            ':id' => $idWorker, 
            ':flag' => 1, 
        ]); 
        
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
    
    // Информация.
    public static function getInfoWorkersList($search) 
    {

        $db = DB::getConnection();

        $search = preg_replace("/\s+/", "", $search);

        if (!empty($search)) {
             $sql = "SELECT workers.*, info.* FROM workers workers , info info "
                     . "WHERE info.flag = 1 AND workers.w_id = info.worker AND"
                . "(workers.w_id LIKE :search "
                . "OR workers.name LIKE :search "
                . "OR workers.surname LIKE :search "
                . "OR workers.father LIKE :search "
                . "OR workers.code LIKE :search ) "
                . " ORDER BY info.i_id DESC";    
        } else {
              $sql = "SELECT workers.* , info.* FROM workers workers, info info "
                      . "WHERE info.flag = 1 AND workers.w_id = info.worker ORDER BY info.i_id DESC";
        }

        $result = $db->prepare($sql);
        $result->execute(array(
            ':search' => '%'.$search.'%'  
        ));

        $workersList = [];

        $i = 0; 
        while($row = $result->fetch()){
            $workersList[$i]['w_id'] = $row['w_id'];
            $workersList[$i]['name'] = $row['name'];
            $workersList[$i]['surname'] = $row['surname'];
            $workersList[$i]['father'] = $row['father'];
            $workersList[$i]['commander'] = WorkersModel::getCommanderName($row['commander']);
            $workersList[$i]['profession'] = ProfessionModel::getProfessionName($row['profession']);
            $workersList[$i]['smena'] = $row['smena'];
            $workersList[$i]['start'] = $row['start']; 
            $workersList[$i]['i_id'] = $row['i_id']; 
            $i++; 
        }

        return $workersList;
    }
    
    // Список работников на территории(по бригадирам).
    public static function infoList()
    {
        $db = DB::getConnection(); 

        $sql = 'SELECT *  FROM workers WHERE commander = :commander ';
        $result = $db->prepare($sql);
        $result->execute([
            ':commander' => 0,  
        ]);

        $infoList = [];

        if ($result) {
            $i = 0; 
            while($row = $result->fetch()){
                $infoList[$i]['id'] = $row['w_id'];
                $infoList[$i]['name'] = $row['name'];
                $infoList[$i]['surname'] = $row['surname'];
                $infoList[$i]['father'] = $row['father'];
                $infoList[$i]['count'] = InfoModels::getWorkersCommandCount($row['w_id']);
                $infoList[$i]['command'] = InfoModels::getWorkersCommand($row['w_id']);
                $i++; 
            }
        }

        return $infoList; 
    }
    
    
    // Кол-во работников в бригаде на территории.
    public static function getWorkersCommandCount($id)
    {
        $db = DB::getConnection();

        $sql = 'SELECT count(*) FROM workers, info WHERE commander = :id AND status = :status AND w_id = worker AND flag = :flag';
        $result = $db->prepare($sql);
        $result->execute([
            ':id' => $id,
            ':status' => 1,
            ':flag' => 1,
        ]);
        
        $countWorkerCommand = $result->fetchColumn();

        return $countWorkerCommand;   
    }
    
    // Информация о работниках в бригаде, находтся на территории.
    public static function getWorkersCommand($id)
    {
        $db = DB::getConnection();

        $workerCommand = [];

        $sql = 'SELECT  commander, name, surname, father, status, w_id, worker, flag   FROM workers, info WHERE commander = :id AND status = :status AND w_id = worker AND flag = :flag';
        $result = $db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));;
        $result->execute([
            ':id' => $id,
            ':status' => 1,
            ':flag' => 1,
        ]);

        if ($result) {
            $i = 0;
            while($row = $result->fetch()){
               $workerCommand[$i]['id'] = $row['w_id'];
               $workerCommand[$i]['name'] = $row['name'];
               $workerCommand[$i]['surname'] = $row['surname'];
               $workerCommand[$i]['father'] = $row['father'];
               $i++; 
           }
        }

        return $workerCommand;
    }
    
    // Ушел, не отметился.
    public static function infoExit($id)
    {
        // Добавление времени ухода в последнюю запись.
        $addTmeExit = self::addTimeExit($id);
   
        // Получение времени ухода и прихода.
        $infoArray = self::getInfoById($id);
        
        // Добавление времени работы
        $addTmeWork = self::addTimeWork($id, $infoArray['start'], $infoArray['finish'], 3);
        
        return $addTmeWork;
    }
   
    // Кол-во работников на территории (пришел).
    public static function getInfoCountWorkersAll() 
    {
        $db = DB::getConnection();
        
        $sql = 'SELECT count(*) FROM info, workers WHERE w_id = worker AND flag = :flag AND status = :status';     
        $result = $db->prepare($sql);   
        $result->execute([
            ':flag' => 1,
            ':status' => 1,
        ]);
        
        $getInfoCountWorkersAll = $result->fetchColumn();
       
        return $getInfoCountWorkersAll; 
    }
    
    // Кол-во работников на территори по профессиям.
    public static function countProfessionWorkes() 
    {
        $db = DB::getConnection();
        
        $professionListAll = ProfessionModel::getProfessionList();
        
        $i = 0;
        foreach ($professionListAll as $key => $value) {
            
            $sql = 'SELECT count(w_id) FROM workers, info WHERE worker = w_id AND flag = :flag AND status = :status AND profession = :profession';         
            $result = $db->prepare($sql);  
            $result->execute([
                ':profession' => $value['id'],
                ':status' => 1,
                ':flag' => 1,
            ]);
            
            while ($row = $result->fetch()) {
                $profession[$i]['name'] = $value['name']; // Наименование специальности.
                $profession[$i]['count'] = $row['count(w_id)'];  
            }
            $i++;
        }
        
        return $profession;
    }
    
    // Всемени между приходом или уходом.
    public static function getTimeInterval($start, $finish) 
    {
        $timeInterval = abs(strtotime($start) - strtotime($finish)) / 60;
        $timeInterval = (int)$timeInterval;   

        return $timeInterval;
    }
    
    // Значение флага.
    public static function getNameFlag($flag) 
    { 
        $flagArray = Data::flag;
        foreach ($flagArray as $key => $value) {
            if($key == $flag){
                $flagName = $value;
            }
        }
        return $flagName;
    }
    
    // Получение данных из последней записи в таблице info.
    public static function chekInfoSecurity($idInfo) 
    {
        $db = DB::getConnection();
        
        $info = $db->prepare("SELECT i_id, worker, flag, finish, start FROM info WHERE worker = :id");
        $info->execute([
            ':id' => $idInfo,
        ]);
        $infoArray = $info->fetchAll();

        foreach ($infoArray as $key => $value) {
            $infoArrayResult['id'] = $value['i_id'];
            $infoArrayResult['flag'] = $value['flag'];
            $infoArrayResult['start'] = $value['start'];
            $infoArrayResult['finish'] = $value['finish'];
        }
        
        if (!empty($infoArray)) {
            return $infoArrayResult;     
        } else {
            return false;
        }
    } 
}