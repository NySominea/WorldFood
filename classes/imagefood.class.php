<?php
require_once("database.class.php");
class Image{
    public $foodId;
    public $image1;
    public $image2;
    public $image3;

    public static function getAllImageByID($fid){
        $result=Database::query("SELECT * FROM tbimagefood WHERE foodId=".$fid);
        if($result && mysqli_num_rows($result)>0){
            while($row=$result->fetch_assoc()){
                $image= new Image();
                $image->foodId=$row["foodId"];
                $image->image1=$row["imagePath1"];
                $image->image2=$row["imagePath2"];
                $image->image3=$row["imagePath3"];

            }
        }
        return $image;
    }
    public static function getAllImage(){
        $images=array();
        $result=Database::query("SELECT * FROM tbimagefood");
        if($result && mysqli_num_rows($result)>0){
            while($row=$result->fetch_assoc()){
                $image= new Image();
                $image->foodId=$row["foodId"];
                $image->image1=$row["imagePath1"];
                $image->image2=$row["imagePath2"];
                $image->image3=$row["imagePath3"];
                $images[]=$image;
            }
        }
        return $images;
    }
    public static function getAnImage($fId){
        $image=array();
        $result=Database::query("SELECT * FROM tbimagefood WHERE foodId=".$fId);
        if($result && mysqli_num_rows($result)>0){
            while($row=$result->fetch_assoc()){
                $image= new Image();
                $image->foodId=$row["foodId"];
                $image->image1=$row["imagePath1"];
            }
        }
        return $image->image1;
    }
}