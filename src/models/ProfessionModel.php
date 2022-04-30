<?php


class ProfessionModel {
   
    public static function getProfessionList()
    {
        $db = DB::getConnection();
        
        $professionList = [];

        $profession = $db->prepare('SELECT * FROM profession');
        $profession->execute();
        $professionList = $profession->fetchAll();
        
        return $professionList;
    }
    
    public static function getProfessionName($id)
    {
        $db = DB::getConnection();
        
        $profession = $db->prepare('SELECT * FROM profession WHERE id = :id');
        $profession->execute([
            ':id' => $id,
        ]);
        $professionName = $profession->fetch();

        $professionName = $professionName['name'];
            
        return $professionName;
    }
}
