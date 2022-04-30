<?php


class TableModel {

    // Месяц с по дням.
    public static function getArrayWeek($year, $month)
    {
        $countDayMonth = self::countDayMonth($month, $year);

        $arrayDayName = [];
        for($day = 1; $day <= $countDayMonth; $day++) {

            if ($day < 10) {
                $day = "0".$day;
            }   

            $date = $year.'-'.$month.'-'.$day;
            
            $NumDayOfWeek = date("N", strtotime($date));    

            $i = 0;
            foreach(Data::week as $key => $value) {
                if ($NumDayOfWeek == $key) {
                   $arrayDayName[$date]['dayName'] = $value;
                   $arrayDayName[$date]['dayNum'] = $day;
                }
                $i++; 
            }
        } 

        return $arrayDayName;
    }
    
    // Работники + время.
    public static function getTableWorkersInfo($year, $month, $search, $commander)
     {
        $db = DB::getConnection();

        $search = preg_replace("/\s+/", "", $search);

        $tableWorkersInfo = [];

        $result = WorkersModel::workersSearch($commander, $search);

        $i = 0; 
        while($row = $result->fetch()) {
            $tableWorkersInfo[$i]['id'] = $row['w_id'];
            $tableWorkersInfo[$i]['name'] = $row['name'];
            $tableWorkersInfo[$i]['surname'] = $row['surname'];
            $tableWorkersInfo[$i]['father'] = $row['father'];
            $tableWorkersInfo[$i]['minMonth'] = self::getWorkerMinMonth($row['w_id'], $month, $year);
            $tableWorkersInfo[$i]['hourMonth'] = (int)($tableWorkersInfo[$i]['minMonth'] / 60);
            $tableWorkersInfo[$i]['info'] = self::getInfoWorker($row['w_id'],$month, $year);
            $i++; 
        }       
       
        return $tableWorkersInfo;
    } 
    
    // Время работы за месяц.
    public static function getWorkerMinMonth($w_id, $month, $year)
    {
        $db = DB::getConnection();

        $date = $year.'-'.$month;

        $sql = 'SELECT  * FROM info WHERE worker = :id AND date LIKE :date AND flag != 1';
        $result = $db->prepare($sql);
        $result->execute([
            ':id' => $w_id,
            ':date' => '%'.$date.'%',
        ]); 

        $minMonth = 0;       
        while ($row = $result->fetch()) { 
            $minMonth += $row['time'];
        }

        return $minMonth;
    }
    
    // Информация о работниках.
    public static function getInfoWorker($w_id, $month, $year)
    {
        $db = DB::getConnection();

        $workersInfo1 = [];
        $countDayMonth = self::countDayMonth($month, $year);
        for($day = 1; $day <= $countDayMonth; $day++) {

            if ($day < 10) {
                $day = "0".$day;
            }  

            $date = $year.'-'.$month.'-'.$day;
            
            $sql = 'SELECT  * FROM info WHERE worker = :id AND date = :date AND flag != 1';
            $result = $db->prepare($sql);
            $result->execute([
                ':id' => $w_id,
                ':date' => $date,
            ]); 

            $hour = 0;
            $min = 0;
            $i = 0;
            while ($row = $result->fetch()) {   
                $min += $row['time'];
                $hour = (int)($min / 60);
                $workersInfo['minDay'] = $min; 
                $workersInfo['hourDay'] = $hour;
                $workersInfo['detal'][$i]['start'] = $row['start'];
                $workersInfo['detal'][$i]['finish'] = $row['finish'];
                $workersInfo['detal'][$i]['flag'] = InfoModels::getNameFlag($row['flag']);
                $workersInfo['detal'][$i]['time'] = $row['time'];
                $i++;     
            } 

            if (empty($workersInfo)) {
                $workersInfo1[$date] = 0;
            } else {  
                $workersInfo1[$date] = $workersInfo;  
            }

            $workersInfo = array();
        }

        return  $workersInfo1;
    }
    
    // Кол-во дней в месяце.
    public static function countDayMonth($month, $year) 
    { 
        return cal_days_in_month(CAL_GREGORIAN, $month, $year);
    } 
}
