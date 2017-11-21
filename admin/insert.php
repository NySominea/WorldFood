<?php
session_start();
require_once("../classes/food.class.php");
require_once("../classes/category.class.php");
require_once("../classes/imagefood.class.php");
require_once("../classes/update.class.php");
require_once("../classes/insert.class.php");
$categories=Category::getAll();
$foods=Food::getAllFood();
$foodsByView=Food::getOrderFoodByViews();
$foodsByLike=Food::getOrderFoodByLikes();
$images=Image::getAllImage();
if(!$_SESSION['admin']){
    header("location:admin.php");
}

if(isset($_POST['submit'])
    && !empty($_POST['foodName']) && !empty($_POST['foodDesc']) && !empty($_POST['categoryId'])
    && !empty($_FILES['imagePath1']['name']) //&& !empty($_FILES['imagePath2']['name']) && !empty($_FILES['imagePath3']['name'])
){
    Insert::insertFood($_POST['foodName'],$_POST['foodDesc'],$_POST['categoryId'],$_FILES['imagePath1']['name'],$_FILES['imagePath2']['name'],$_FILES['imagePath3']['name']);

    //print_r($_POST['foodName']);
    //print_r($_FILES['imagePath1']['name']);

    $tmp_path=$_FILES['imagePath1']['tmp_name'];
    $path="../images/".$_FILES['imagePath1']['name'];
    move_uploaded_file($tmp_path,$path);

    $tmp_path=$_FILES['imagePath2']['tmp_name'];
    $path="../images/".$_FILES['imagePath2']['name'];
    move_uploaded_file($tmp_path,$path);

    $tmp_path=$_FILES['imagePath3']['tmp_name'];
    $path="../images/".$_FILES['imagePath3']['name'];
    move_uploaded_file($tmp_path,$path);

    header("location:tables.php");
}

$signup=false;
if(isset($_POST['signup'])){
    if(!empty($_POST['nameSignUp']) && !empty($_POST['emailSignUp']) && !empty($_POST['passwordSignUp'])){
        if($_POST['passwordSignUp']==$_POST['confirmPasswordSignUp']){
            Insert::insertAdminAccount($_POST['nameSignUp'],$_POST['passwordSignUp'],$_POST['emailSignUp']);
            $signup=true;
        }else{
            echo "<script>alert('Your password is not the same as the first one.');</script>";
        }
    }else{
        echo "<script>alert('Sign Up fail. Please fill all information.');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../css/adminheader.css" type="text/css">
    <link rel="stylesheet" href="../css/adminbodyinsert.css" type="text/css">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <?php
    if($signup){
        echo "
                <script type=\"text/javascript\">
                $(window).load(function(){
                $('#thankSignupModal').modal('show');
                });
                </script>
            ";
    }
    ?>
</head>
<body style="background:lightgrey;">
<div class="divContainer">
    <!--Header-->
    <div class="divHeader">
        <a href="tables.php"><img src="logo_final.png" alt="logo"></a>
        <h1>Admin</h1>
        <button data-target="#signupModal" data-toggle="modal">SIGN UP</button>
    </div>
    <div class="divRuler"></div>

    <!--Nav-->
    <div class="divNavBar">
        <ul>
            <li><a href="tables.php" >តារាង</a></li>
            <li><a href="insert.php" class="current">បញ្ចូល</a></li>
            <li><a href="logout.php">ចាកចេញ</a></li>
        </ul>
    </div>
    <div class="divRuler"></div>

    <!--Body-->
    <div class="divBody">
        <table>

            <form method="post" enctype="multipart/form-data">
                <tr>
                    <td width="25%">Food Name</td>
                    <td><input type="text" name="foodName" placeholder="Food Name"></td>
                </tr>
                <tr>
                    <td width="20%">Food Description</td>
                    <td><textarea style="width: 100%" rows="10" name="foodDesc" placeholder="Food Description"></textarea></td>
                </tr>
                <tr>
                    <td width="20%">Food Category</td>
                    <td><select name="categoryId">
                            <option disabled selected>ប្រភេទ</option>
                            <?php
                                foreach($categories as $c){
                                    echo "<option value='$c->categoryId'>".$c->categoryName."</option>";
                                }
                            ?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td width="20%">Image1</td>
                    <td><input type="file" name="imagePath1"></td>
                </tr>
                <tr>
                    <td width="20%">Image2</td>
                    <td><input type="file" name="imagePath2"></td>
                </tr>
                <tr>
                    <td width="20%">Image3</td>
                    <td><input type="file" name="imagePath3"></td>
                </tr>

                <tr align="center">
                    <td colspan="2">
                        <input type="submit" value="Submit" style="width: 100px" name="submit">
                        <input type="reset" name="reset" value="Reset"  style="width: 100px">
                    </td>
                </tr>
            </form>

        </table>

    </div>

    <!--Model Sign up-->
    <div class="modal fade"  id="signupModal" data-keyboard="false" data-backdrop="static" style="margin-right: 100px">
        <div class="modal-dialog modal-sm">
            <div class="modal-content" style="width: 400px">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h2 class="modal-title" style="text-align: center">Sign Up Admin Account</h2>
                </div>
                <div class="modal-body">
                    <form method="post">
                        <div class="form-group">
                            <label for="inputUserName">Username</label>
                            <input class="form-control" placeholder="Username" type="text" name="nameSignUp"/>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail">Email</label>
                            <input class="form-control" placeholder="Email" type="email" name="emailSignUp"/>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword">Password</label>
                            <input class="form-control" placeholder="Password" type="password" name="passwordSignUp"/>
                        </div>
                        <div class="form-group">
                            <label for="inputConfirmPassword">Confirm Password</label>
                            <input class="form-control" placeholder="Password" type="password" name="confirmPasswordSignUp"/>
                        </div>
                        <div class="modal-footer">
                            <input type="submit" class="btn btn-primary" style="width: 100%;margin: 0px" value="Sign Up" name="signup">

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--Welcome Admin-->
    <div class="modal fade"  id="thankSignupModal" data-keyboard="false" data-backdrop="static" style="margin-right: 100px">
        <div class="modal-dialog modal-sm">
            <div class="modal-content" style="width: 400px">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        &times;
                    </button>
                    <h2 class="modal-title" style="text-align: center">Congratulation!</h2>
                </div>
                <div class="modal-body">
                    <h4>Congratulation for being an admin for this website.</h4>
                </div>
                <div class="modal-footer">
                    <a class="btn btn-primary" data-dismiss="modal">Close</a>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
