<?php
require_once("database.class.php");

class Category{
    public $categoryId;
    public $categoryName;

    public static function getAll(){
        $categories=array();
        $result=Database::query("SELECT * FROM tbfoodcategory");
        if($result && mysqli_num_rows($result)>0){
            while($row=$result->fetch_assoc()){
                $c=new Category();
                $c->categoryId=$row['categoryId'];
                $c->categoryName=$row['categoryName'];
                $categories[]=$c;
            }
        }
        return $categories;
    }

    public static function deleteByCategoryId($id){
        Database::query("DELETE FROM tbfoodcategory WHERE categoryId=".$id);
        Database::query("DELETE FROM tbfood WHERE foodCategory=".$id);
    }
}