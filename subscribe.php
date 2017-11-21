<?php
session_start();
require_once("classes/update.class.php");

Update::updateUserSubscribe($_GET['userId']);

$_SESSION['subscribe']=1;
header("location:index.php");
