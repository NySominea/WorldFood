<?php
require_once("database.class.php");

class Admin{
    public $adminId;
    public $adminUsername;
    public $adminPassword;
    public $adminEmail;
    public $adminDateRegister;

    public static function getAllAdminAccount(){
        $admins=array();
        $result=Database::query("SELECT * FROM tbadmin");
        if($result && mysqli_num_rows($result)>0)
            while($row=$result->fetch_assoc()){
                $admin=new Admin();
                $admin->adminId=$row['adminId'];
                $admin->adminUsername=$row['adminUsername'];
                $admin->adminPassword=$row['adminPassword'];
                $admin->adminEmail=$row['adminEmail'];
                $admin->adminDateRegister=$row['adminDateRegister'];
                $admins[]=$admin;
            }

        return $admins;
    }

    public static function deleteByAdminId($id){
        Database::query("DELETE FROM tbadmin WHERE adminId=".$id);
    }
}