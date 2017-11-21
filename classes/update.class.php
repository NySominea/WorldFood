<?php
require_once("database.class.php");

class Update{

    public static function updateFoodView($fid){
        Database::query("UPDATE tbfood SET foodView = foodView +1 WHERE foodId=".$fid);
    }

    public static function updateUserLogin($userId,$login){
        Database::query("UPDATE tbuser SET userLogin='".$login."' WHERE userId=".$userId);
    }
    public static function updateUserSubscribe($userId){
        Database::query("UPDATE tbuser SET userSubscribe=1 WHERE userId=".$userId);
    }

    public static function updateFoodLike($fid){
        Database::query("UPDATE tbfood SET foodLike = foodLike +1 WHERE foodId=".$fid);
    }

    public static function updateFoodUnike($fid){
        Database::query("UPDATE tbfood SET foodLike = foodLike -1 WHERE foodId=".$fid);
    }
}