<?php

class MoneyModels {
   
    public static function workersMoney($year, $month, $search, $commander)
    {
        $search = preg_replace("/\s+/", "", $search);
        
        $result = WorkersModel::workersSearch($commander, $search); 
        
        $date = $year.'-'.$month;
        
        $workersMoney = [];

        if (isset($result)) {   
            $i = 0; 
            while($row = $result->fetch()){
                $workersMoney[$i]['id'] = $row['w_id'];
                $workersMoney[$i]['name'] = $row['name'];
                $workersMoney[$i]['surname'] = $row['surname'];
                $workersMoney[$i]['father'] = $row['father'];
                $workersMoney[$i]['avans'] = self::getCountMoneyMonth($row['w_id'], $date, 'a');
                $workersMoney[$i]['shtraf'] = self::getCountMoneyMonth($row['w_id'], $date, 's');
                $workersMoney[$i]['foot'] = self::getCountMoneyMonth($row['w_id'], $date, 'f');
                $workersMoney[$i]['money'] = self::getWorkersMoneyById($row['w_id'], $date);
                $workersMoney[$i]['kredit'] = ($workersMoney[$i]['shtraf'] + $workersMoney[$i]['foot']) - $workersMoney[$i]['avans'];
                $i++; 
            }          
        }

        return $workersMoney;
    }
    
    public static function getCountMoneyMonth($id, $date, $type)
    {
        $db = DB::getConnection();
        $workers = $db->prepare('SELECT * FROM money WHERE worker = :id AND date LIKE :date AND payout = :payout AND type = :type');
        $workers->execute([
            ':id' => $id, 
            ':date' => '%'.$date.'%',
            ':payout' => 0,
            ':type' => $type,
        ]);

        $sumAvans = 0;
        while ($row = $workers->fetch()) {
            $sumAvans += $row['sum'];  
        }

        return $sumAvans; 
    }
    
    public static function getWorkersMoneyById($id, $date)
    {
        $db = DB::getConnection();

        $moneyInfo = [];

        $workers = $db->prepare('SELECT * FROM money WHERE worker = :id AND date  LIKE :date');
        $workers->execute([
            ':id' => $id, 
            ':date' => '%'.$date.'%',
        ]);

        $i = 0;
        while($row = $workers->fetch()){
            $moneyInfo[$i]['id'] = $row['m_id'];
            $moneyInfo[$i]['date'] = $row['date'];
            $moneyInfo[$i]['type'] = self::getTypeMoney($row['type']);
            $moneyInfo[$i]['sum'] = $row['sum'];
            $moneyInfo[$i]['payout'] = self::getMoneyStatus($row['payout']);
            $i++;
        }

        return $moneyInfo; 
    }
    
    public static function getTypeMoney($type) 
    {
        switch ($type) {
            case 's': $typeName = 'Штраф'; break;
            case 'a': $typeName = 'Аванс'; break;
            case 'f': $typeName = 'Питание'; break;  
        }

        return $typeName;
    }
    
    public static function moneyAdd($worker, $type, $money, $date)
    {
        $db = DB::getConnection();

        $avansAdd = $db->prepare("INSERT INTO money (worker, type, date, sum, payout) VALUES (:worker, :type, :date, :money, :payout)");
        $avansAdd->execute([
            ':worker' => $worker,
            ':type' => $type,
            ':date' => $date,
            ':money' =>  $money,
            ':payout' => 0,
        ]);

        return $avansAdd;
    }
    
    public static function moneyClose($id)
    {
        $db = DB::getConnection();

        $sql = "UPDATE money SET payout = :payout WHERE m_id = :id";
        $moneyClose = $db->prepare($sql);
        $moneyClose->execute([
            ':id' => $id,
            ':payout' => 1,
        ]);

        return $moneyClose;
    }
    
    public static function moneyDelete($id)
    {
        $db = DB::getConnection();

        $sql = "DELETE FROM money WHERE m_id = :id";
        $moneyDelete = $db->prepare($sql);
        $moneyDelete->execute([
            ':id' => $id,
        ]);

        return $moneyDelete;
    }
    
    public static function getMoneyStatus($payout)
    {
        switch ($payout) {
            case 1: $payoutName = 'Выплачено'; break;
            case 0: $payoutName = 'Активно'; break;
        }

        return $payoutName;
    } 
}