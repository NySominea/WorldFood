<?php
require_once("database.class.php");
class Food{
    public $foodId;
    public $foodName;
    public $foodDesc;
    public $foodDate;
    public $foodLike;
    public $foodView;
    public $foodCategoryId;

    public static function getAllFoodByID($id){
        $result=Database::query("SELECT * FROM tbfood WHERE foodId=".$id);
        if($result && mysqli_num_rows($result)>0){
            while($row=$result->fetch_assoc()){
                $food=new Food();
                $food->foodId=$row['foodId'];
                $food->foodName=$row['foodName'];
                $food->foodDesc=$row['foodDesc'];
                $food->foodDate=$row['foodDate'];
                $food->foodLike=$row['foodLike'];
                $food->foodView=$row['foodView'];
                $food->foodCategoryId=$row['foodCategory'];
            }
        }
        return $food;
    }

    public static function getAllFood(){
        $foods=array();
        $result=Database::query("SELECT * FROM tbfood");
        if($result && mysqli_num_rows($result)>0){
            while($row=$result->fetch_assoc()){
                $food=new Food();
                $food->foodId=$row['foodId'];
                $food->foodName=$row['foodName'];
                $food->foodDesc=$row['foodDesc'];
                $food->foodDate=$row['foodDate'];
                $food->foodLike=$row['foodLike'];
                $food->foodView=$row['foodView'];
                $food->foodCategoryId=$row['foodCategory'];
                $foods[]=$food;
            }
        }
        return $foods;
    }
    public static function getCategoryAndFoodOrderbyDate($categories){
        $foods=array();
        for($i=1;$i<count($categories)+1;$i++) {
            $result = Database::query("SELECT * FROM tbfood WHERE foodCategory=" . $i . " ORDER BY foodDate DESC LIMIT 2");

            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = $result->fetch_assoc()) {
                    $food = new Food();
                    $food->foodId = $row['foodId'];
                    $food->foodName = $row['foodName'];
                    $food->foodDesc = $row['foodDesc'];
                    $food->foodDate = $row['foodDate'];
                    $food->foodLike = $row['foodLike'];
                    $food->foodView = $row['foodView'];
                    $food->foodCategoryId = $row['foodCategory'];
                    $foods[] = $food;
                }
            }
        }
        return $foods;
    }

    public static function getOrderFoodByDate(){
        $foods=array();
        $result=Database::query("SELECT * FROM tbfood ORDER BY foodDate DESC");
        if($result && mysqli_num_rows($result)>0){
            while($row=$result->fetch_assoc()){
                $food=new Food();
                $food->foodId=$row['foodId'];
                $food->foodName=$row['foodName'];
                $food->foodDesc=$row['foodDesc'];
                $food->foodDate=$row['foodDate'];
                $food->foodLike=$row['foodLike'];
                $food->foodView=$row['foodView'];
                $food->foodCategoryId=$row['foodCategory'];

                $foods[]=$food;
            }
        }
        return $foods;
    }
    public static function getOrderFoodByViews(){
        $foods=array();
        $result=Database::query("SELECT * FROM tbfood ORDER BY foodView DESC LIMIT 2");
        if($result && mysqli_num_rows($result)>0){
            while($row=$result->fetch_assoc()){
                $food=new Food();
                $food->foodId=$row['foodId'];
                $food->foodName=$row['foodName'];
                $food->foodDesc=$row['foodDesc'];
                $food->foodDate=$row['foodDate'];
                $food->foodLike=$row['foodLike'];
                $food->foodView=$row['foodView'];
                $food->foodCategoryId=$row['foodCategory'];

                $foods[]=$food;
            }
        }
        return $foods;
    }
    public static function getOrderFoodByLikes(){
        $foods=array();
        $result=Database::query("SELECT * FROM tbfood ORDER BY foodLike DESC Limit 2");
        if($result && mysqli_num_rows($result)>0){
            while($row=$result->fetch_assoc()){
                $food=new Food();
                $food->foodId=$row['foodId'];
                $food->foodName=$row['foodName'];
                $food->foodDesc=$row['foodDesc'];
                $food->foodDate=$row['foodDate'];
                $food->foodLike=$row['foodLike'];
                $food->foodView=$row['foodView'];
                $food->foodCategoryId=$row['foodCategory'];

                $foods[]=$food;
            }
        }
        return $foods;
    }

    public static function getFoodByCategory($cat){
        $foods=array();
        $result=Database::query("SELECT * FROM tbfood WHERE foodCategory=".$cat." ORDER BY foodDate DESC");
        if($result && mysqli_num_rows($result)>0){
            while($row=$result->fetch_assoc()){
                $food=new Food();
                $food->foodId=$row['foodId'];
                $food->foodName=$row['foodName'];
                $food->foodDesc=$row['foodDesc'];
                $food->foodDate=$row['foodDate'];
                $food->foodLike=$row['foodLike'];
                $food->foodView=$row['foodView'];
                $food->foodCategoryId=$row['foodCategory'];
                $foods[]=$food;
            }
        }
        return $foods;
    }

    public static function getFoodBySearch($search){
        $foods=array();
        $result=Database::query("SELECT * FROM tbfood WHERE foodName LIKE '%".$search."%'");
        if($result && mysqli_num_rows($result)>0){
            while($row=$result->fetch_assoc()){
                $food=new Food();
                $food->foodId=$row['foodId'];
                $food->foodName=$row['foodName'];
                $food->foodDesc=$row['foodDesc'];
                $food->foodDate=$row['foodDate'];
                $food->foodLike=$row['foodLike'];
                $food->foodView=$row['foodView'];
                $food->foodCategoryId=$row['foodCategory'];
                $foods[]=$food;
            }
        }
        return $foods;
    }

    public static function deleteById($id){
        Database::query("DELETE FROM tbfood WHERE foodId=".$id);
        Database::query("DELETE FROM tbimagefood WHERE foodId=".$id);
    }
}