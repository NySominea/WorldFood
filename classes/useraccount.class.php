<?php

require_once("database.class.php");

class User{
    public $userame;
    public $password;
    public $userId;
    public $userPhoneNumber;
    public $userEmail;
    public $userDateRegister;
    public $userSubscribe;
    public $userLogin;

    public static function getAllUser(){
        $users=array();
        $result=Database::query("SELECT * FROM tbuser");
        if($result && mysqli_num_rows($result)>0){
            while($row=$result->fetch_assoc()){
                $user=new User();
                $user->userId=$row['userId'];
                $user->username=$row['userName'];
                $user->userPhoneNumber=$row['userPhoneNumber'];
                $user->password=$row['userPassword'];
                $user->userEmail=$row['userEmail'];
                $user->userDateRegister=$row['userDateRegister'];
                $user->userSubscribe=$row['userSubscribe'];
                $user->userLogin=$row['userLogin'];
                $users[]=$user;
            }
        }
        return $users;
    }

    public static function deleteByUserId($id){
        Database::query("DELETE FROM tbuser WHERE userId=".$id);
    }
}