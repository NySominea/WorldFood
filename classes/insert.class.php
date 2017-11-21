<?php
require_once("database.class.php");
class Insert{

    public static function insertFood($foodName,$foodDesc,$foodCategory,$image1,$image2,$image3){
        Database::query("INSERT INTO tbfood (foodName, foodDesc,foodDate,foodCategory)
                        VALUES('".$foodName."','".$foodDesc."',now(),'".$foodCategory."')");
        $result=Database::query("SELECT * FROM tbfood ORDER by foodId DESC LIMIT 1 ");
        if($result && mysqli_num_rows($result)>0){
            while($row=$result->fetch_assoc()){
                $foodId=$row['foodId'];
            }
        }
        Database::query("INSERT INTO tbimagefood (foodId, imagePath1, imagePath2, imagePath3)
                        VALUES('".$foodId."','".$image1."','".$image2."','".$image3."')");
    }

    public static function insertUserAccount($name,$password,$email,$tel){
        Database::query("INSERT INTO tbuser (userName, userPhoneNumber, userEmail, userPassword, userDateRegister, userSubscribe)
                        VALUES('".$name."','".$tel."','".$email."','".$password."',now(),'0')");
    }

    public static function insertAdminAccount($name,$password,$email){
        Database::query("INSERT INTO tbadmin (adminUsername, adminPassword, adminEmail, adminDateRegister)
                        VALUES('".$name."','".$password."','".$email."',now())");
    }
}