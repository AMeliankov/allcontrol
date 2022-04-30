<?php

class WorkersModel {

    // Список работников по бригадам.
    public static function getWorkersList($search) 
    {
        $db = DB::getConnection();
        
        $search = preg_replace("/\s+/", "", $search);
        $workersList = array();
        
        if (!empty($search)) {
            $sql = "SELECT * FROM `workers` WHERE (w_id LIKE :search OR name LIKE :search "
                ."OR surname LIKE :search father LIKE :search OR code LIKE :search ) ORDER BY w_id DESC";
        } else {
            $sql = "SELECT * FROM `workers` WHERE commander = 0 ORDER BY w_id DESC";
        }

        $workers = $db->prepare($sql);
        $workers->execute([
            ':search' => '%'.$search.'%',
        ]);
        
        $i = 0;
        while ($row = $workers->fetch()) {
           $workersList[$i]['id'] =  $row['w_id'];
           $workersList[$i]['name'] =  $row['name'];
           $workersList[$i]['surname'] =  $row['surname'];
           $workersList[$i]['father'] =  $row['father'];
           $workersList[$i]['code'] =  $row['code'];
           $workersList[$i]['smena'] =  $row['smena'];
           $workersList[$i]['phone'] =  $row['phone'];
           $workersList[$i]['commander'] =  self:: getCommanderName($row['commander']);
           $workersList[$i]['status'] =  self::getWorkersStatus($row['status']);
           $workersList[$i]['profession'] = ProfessionModel::getProfessionName($row['profession']);
           $workersList[$i]['count'] = self::getWorkersCountComand($row['w_id']);
           $workersList[$i]['command'] = self::getWorkersComand($row['w_id']);
           $i++;   
        }

        return $workersList;
    }

    // Обработка фото.
    public static function resizePhoto($code, $filename) 
    {
        $src = 'photo/'.$code.'.png';
        
        $info = getimagesize($filename);
    
        $width  = $info[0];
        $height = $info[1];
        $type   = $info[2];

        switch ($type) { 
            case 1: 
                $img = imageCreateFromGif($filename);
                imageSaveAlpha($img, true);
                break;					
            case 2: 
                $img = imagecreatefromjpeg($filename);
                break;
            case 3: 
                $img = imageCreateFromPng($filename); 
                imageSaveAlpha($img, true);
                break;
        }

        // Размеры новой фотографии.
        $w = 300;
        $h = 225;

        if (empty($w)) {
            $w = ceil($h / ($height / $width));
        }

        if (empty($h)) {
            $h = ceil($w / ($width / $height));
        }

        $tmp = imageCreateTrueColor($w, $h);

        $white = imagecolorallocate($tmp, 255, 255, 255);
        imagefill($tmp, 0, 0, $white);

        if ($type == 1 || $type == 3) {
            imagealphablending($tmp, true); 
            imageSaveAlpha($tmp, true);
            $transparent = imagecolorallocatealpha($tmp, 255, 255, 255, 127); 
            imagefill($tmp, 0, 0, $transparent); 
            imagecolortransparent($tmp, $transparent);    
        }   

        $tw = ceil($h / ($height / $width));
        $th = ceil($w / ($width / $height));

        if ($tw < $w) {
            imageCopyResampled($tmp, $img, ceil(($w - $tw) / 2), 0, 0, 0, $tw, $h, $width, $height);        
        } else {
            imageCopyResampled($tmp, $img, 0, ceil(($h - $th) / 2), 0, 0, $w, $th, $width, $height);    
        }            

        $img = $tmp;

        // Переворт фото.   
        $exif = @exif_read_data($filename); 

        if(!empty($exif['Orientation'])) {
            switch($exif['Orientation']) {
                case 8:
                    $img = imagerotate($img,90,0);
                    break;
                case 3:
                    $img = imagerotate($img,180,0);
                    break;
                case 6:
                    $img = imagerotate($img,-90,0);
                    break;
            }
        }

        switch ($type) {
            case 1:
                imageGif($img, $src);
                break;			
            case 2:
                imageJpeg($img, $src, 100);
                break;			
            case 3:
                imagePng($img, $src);
                break;
        }
        
        imagedestroy($img);
        
        return true;  
    }
    
    // Список работников в бригаде.
    public static function getWorkersComand($id)
    {
        $db = DB::getConnection();

        $workers = $db->prepare('SELECT * FROM workers WHERE commander = :commander');
        $workers->execute([
            ':commander' => $id,    
        ]);

        $i = 0;
        $workersCommand = [];
        while($row = $workers->fetch()){
           $workersCommand[$i]['id'] =  $row['w_id'];
           $workersCommand[$i]['name'] =  $row['name'];
           $workersCommand[$i]['surname'] =  $row['surname'];
           $workersCommand[$i]['father'] =  $row['father'];
           $workersCommand[$i]['code'] =  $row['code'];
           $workersCommand[$i]['smena'] =  $row['smena'];
           $workersCommand[$i]['phone'] =  $row['phone'];
           $workersCommand[$i]['commander'] =  self:: getCommanderName($row['commander']);
           $workersCommand[$i]['status'] = self::getWorkersStatus($row['status']);
           $workersCommand[$i]['profession'] = ProfessionModel::getProfessionName($row['profession']);
           $i++;   
        }

        return $workersCommand; 
    }
    
    // Кол-во работников в бригаде.
    public static function getWorkersCountComand($id)
    {
        $db = DB::getConnection();

        $count = $db->prepare('SELECT count(*) FROM workers WHERE commander = :commander');
        $count->execute([
            ':commander' => $id,  
        ]);
        $countCommand = $count->fetchColumn();

        return $countCommand;  
        
    }
    
    // Статус работника.
    public static function getWorkersStatus($status)
    {
        switch ($status) {
            case 1: $status = 'Работает'; break;
            case 0: $status = 'Не работает'; break;
        } 

        return $status;
    }
    
    // Имя и фамилия бригадира.
    public static function getCommanderName($id)
    {
        if ($id == 0) {
            $commanderName = 'Бригадир';
        } else {
            $db = DB::getConnection();
            $commander = $db->prepare('SELECT name, surname, w_id FROM workers WHERE w_id = :commander');
            $commander->execute([
                ':commander' => $id,
            ]);
            $commanderName = $commander->fetch();
            $commanderName = $commanderName['surname'].' '.$commanderName['name'];  
        }

        return $commanderName;
    }
    
    public static function getCountWorkesProfession() 
    {
        $db = DB::getConnection();
        
        $professionListAll = ProfessionModel::getProfessionList();
        
        $i = 0;
        foreach ($professionListAll as $key => $value){
            $count = $db->query('SELECT count(w_id) FROM workers WHERE profession = '.$value['id']);
            while ($row = $count->fetch()) {
                $countWorkersProfession[$i]['name'] = $value['name'];
                $countWorkersProfession[$i]['count'] = $row['count(w_id)'];  
            }
            $i++;
        }

        return $countWorkersProfession;
    }
    
    // Кол-во работников в бд.
    public static function getCountWorkers() 
    {
        $db = DB::getConnection();

        $count = $db->query('SELECT count(w_id) FROM workers');
        $countWorkersAll = $count->fetchColumn();

        return $countWorkersAll;
    }
    
    public static function workersView($id) 
    {
        $db = DB::getConnection();
         
        $workersView = [];
        
        $result = $db->query('SELECT * FROM workers WHERE w_id = '.$id);
        $workersView = $result->fetch();
       
        $workersView['profession'] = ProfessionModel::getProfessionName($workersView['profession']);
        $workersView['commander'] = self::getCommanderName($workersView['commander']) ; 
        $workersView['status'] = self::getWorkersStatus($workersView['status']);
   
       return  $workersView;
    }
    
    // Код пропуска работника.
    public static function generateCode()
    {
        $length = 13;
        $str = '';

        for($i = 0; $i < $length; ++$i) {
            $first = $i ? 0 : 1;
            $n = mt_rand($first, 9);
            $str .= $n;
        }

        return $str;
    }
    
    // Список всех бригадиров.
    public static function getCommanderList()
    {
        $db = DB::getConnection();

        $commander = $db->query('SELECT  w_id, name, surname FROM workers WHERE commander = 0');
        $commanderList = [];
        $commanderList = $commander->fetchAll();

        return $commanderList;   
    }
    
    
    // Добавление нового работника в бд.
    public static function workersAdd($name, $surname, $father, $smena,$profession, $commander, $phone, $filename)
    {
        $db = DB::getConnection();

        $code = WorkersModel::generateCode();
           
        $workers = $db->prepare("INSERT INTO workers (name, surname, father, code, smena, profession, commander, phone, status)"
                . " VALUES (:name, :surname, :father, :code, :smena, :profession, :commander, :phone, :status)");
        $workers->execute([
            ':name' => trim($name, ' '),
            ':surname' => trim($surname, ' '),
            ':father' =>  trim($father, ' '),
            ':code' => $code,
            ':smena' => $smena,
            ':profession' => $profession,
            ':commander' => $commander,
            ':phone' => $phone,
            ':status' => 1,
        ]);
         
        $resize = WorkersModel::resizePhoto($code, $filename);
      
        if ($resize == true && $workers == true) {
            return true;   
        } else {
            return false;   
        }        
    }
    
    // Массив с id работкиков (edit, print, del).
    public static function getArrayWorkersId($workersArrayId) 
    {
        $db = DB::getConnection();

        $check = implode(" ", $_POST["workers"]);
        $workersArrayId = preg_split('/[ ]+/', $check);

        $i = 0;
        foreach ($workersArrayId as $id) {
            $id = (int)$id; // Преобразуем id к типу intю.

            $result = $db->prepare('SELECT * FROM workers WHERE w_id = :id');
            $result->execute([
                ':id' => $id,
            ]);

            while ($row = $result->fetch()) {
                $workers[$i]['id'] = $row['w_id'];
                $workers[$i]['name'] = $row['name'];
                $workers[$i]['surname'] = $row['surname'];
                $workers[$i]['father'] = $row['father'];
                $workers[$i]['father'] = $row['father'];
                $workers[$i]['smena'] = $row['smena'];
                $workers[$i]['code'] = $row['code'];
                $workers[$i]['profession'] = $row['profession'];
                $workers[$i]['commander'] = $row['commander'];
                $workers[$i]['status'] = $row['status'] ;
                $workers[$i]['phone'] = $row['phone'];
            }    
            $i++;
        }

        return $workers;
    }
    
    
    // Изменение.
    public static function workersEdit($workersEdit) 
    {
        $db = DB::getConnection();

        foreach ($workersEdit as $key => $value) {
            $sql = "UPDATE workers SET name = :name, surname = :surname, father = :father, smena = :smena,"
                    . "profession = :profession, commander = :commander, phone = :phone, status = :status WHERE w_id = :id";
            $result = $db->prepare($sql);
            $result->execute([
                ':name' => trim($value['name'], ' '),
                ':surname' => trim($value['surname'], ' '),
                ':father' =>  trim($value['father'], ' '),
                ':smena' => $value['smena'],
                ':profession' => $value['profession'],
                ':commander' => $value['commander'],
                ':phone' => $value['phone'],
                ':status' => $value['status'],
                ':id' => $value['id'],
            ]);
        }
        return $result; 
    }
    
    // Печать пропуска.
    public static function workersPrint($workers) 
    {
        $workersPrint = WorkersModel::getArrayWorkersId($workers); 

        $i = 0;
        foreach ($workersPrint as $key => $value) {
            $workersPrint[$key]['profession'] = ProfessionModel::getProfessionName($value['profession']); 
            $workersPrint[$key]['commander'] = WorkersModel::getCommanderName($value['commander']) ; 
            $i++;
        }

        return $workersPrint;
    }
    
    // Удаление.
    public static function workersDelete($workersArrayId)
     {
        $db = DB::getConnection();
        
        foreach($workersArrayId as $value){
        
            $code = WorkersModel::workersView($value);
            $delPhoto = 'photo/'.$code['code'].'.png';
            
            $sql = "DELETE FROM workers WHERE w_id = :id";
            $result = $db->prepare($sql);
            $result->execute([
                ':id' => $value,
            ]);

            if (unlink($delPhoto)) {
                header("Location: /workers"); 
            } 
        }

        return true;
    }
    
    // Поиск для money и table.
    public static function workersSearch($commander, $search)
     {
        $db = DB::getConnection();
        
        if (!empty($search)) {
            $sql = 'SELECT  w_id, name, surname, father FROM workers  '
                    . ' WHERE (name LIKE :search OR surname LIKE :search OR father LIKE :search)';
            $result = $db->prepare($sql);
            $result->execute([
                ':commander' => $commander,
                ':search' => '%'.$search.'%',
            ]);
        } else {
            $sql = 'SELECT  w_id, name, surname, father FROM workers'
                    . ' WHERE commander = :commander OR w_id = :commander';
            $result = $db->prepare($sql);
            $result->execute([
                ':commander' => $commander,
            ]);
        }
        
        return $result;
    }
   
    // Проверка работника.
    public static function validateSecurityWorkers($code)
    {
        $db = DB::getConnection();

        $worker = $db->prepare("SELECT w_id, name, surname, father, code,"
                . "status FROM workers WHERE code = :code AND status = :status ");
        $worker->execute([
            ':code' => $code,
            ':status' => 1,
        ]);
        $workerArray = $worker->fetch();
        
        if ($worker) {
            return $workerArray;      
        } else {
             return false; 
        }
    }  
}