<?php
require_once("database.class.php");

class Mac{
    public $macaddress;
    public $foodId;

    public static function getAllMac(){
        $macs=array();
        $result=Database::query("SELECT * FROM tbmacaddress");
        if($result && mysqli_num_rows($result)>0)
            while($row=$result->fetch_assoc()){
                $mac = new Mac();
                $mac->macaddress=$row['macAddress'];
                $mac->foodId=$row['foodId'];
                $macs[]=$mac;
            }
        return $macs;
    }

    public static function insertMac($mac,$foodId){
        Database::query("INSERT INTO tbmacaddress (macAddress, foodId) VALUES ('".$mac."','".$foodId."') ");
    }

    public static function deleteMac($mac,$foodId){
        Database::query("DELETE FROM tbmacaddress WHERE macAddress='".$mac."' AND foodId='".$foodId."'");
    }
}