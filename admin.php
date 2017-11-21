<?php
    session_start();
    require_once("classes/admin.class.php");

    $admins=Admin::getAllAdminAccount();

    if(isset($_POST['login'])){
        foreach($admins as $admin){
            if($admin->adminUsername==$_POST['adminUsername'] && $admin->adminPassword==$_POST['adminPassword']){
                $_SESSION['admin']=$_POST['adminUsername'];
                header("location:admin/tables.php");
            }
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin</title>
    <link rel="stylesheet" href="bs3/css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="bs3/css/bootstrap-theme.css" type="text/css">
    <link rel="stylesheet" href="bs3/css/bootstrap-theme.min.css" type="text/css">
    <link rel="stylesheet" href="bs3/css/bootstrap.css" type="text/css">

    <link rel="stylesheet" href=    "https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<div>
    <script type="text/javascript">
        $(window).load(function(){
            $('#myModal').modal('show');
        });
    </script>
    <!--Model Login-->
    <div class="modal fade"  id="myModal" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-sm">
            <div class="modal-content" style="width: 400px">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        &times;
                    </button>
                    <h2 class="modal-title" style="text-align: center">Admin Login</h2>
                </div>
                <div class="modal-body">
                    <form method="post">
                        <div class="form-group">
                            <label for="inputUserName">Username</label>
                            <input class="form-control" placeholder="Login Username" type="text" name="adminUsername"/>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword">Password</label>
                            <input class="form-control" placeholder="Login Password" type="password" name="adminPassword"/>
                        </div>
                        <div class="modal-footer">
                            <input type="submit" class="btn btn-primary" style="width: 100%;margin: 0px" value="Login" name="login">

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
