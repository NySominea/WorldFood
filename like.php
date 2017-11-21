<?php
require_once("classes/macaddress.php");
require_once("classes/update.class.php");

if($_GET['bln']==1){
    Mac::insertMac($_GET['mac'],$_GET['foodId']);
    Update::updateFoodLike($_GET['foodId']);
}else{
    Mac::deleteMac($_GET['mac'],$_GET['foodId']);
    Update::updateFoodUnike($_GET['foodId']);
}


header("location:article.php?article=".$_GET['foodId']);
