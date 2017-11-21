<?php
    require_once("../classes/food.class.php");
    require_once("../classes/admin.class.php");
    require_once("../classes/category.class.php");
    require_once("../classes/useraccount.class.php");

    Food::deleteById($_GET['foodId']);
    Admin::deleteByAdminId($_GET['adminId']);
    Category::deleteByCategoryId($_GET['categoryId']);
    User::deleteByUserId($_GET['userId']);
    header("location:tables.php");