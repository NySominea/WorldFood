<?php
session_start();
require_once("classes/update.class.php");
Update::updateUserLogin($_GET['userId'],0);
unset($_SESSION['userLogin']);
header("location:index.php");
