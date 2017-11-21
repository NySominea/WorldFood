<?php
session_start();

require_once("../classes/food.class.php");
require_once("../classes/category.class.php");
require_once("../classes/imagefood.class.php");
require_once("../classes/update.class.php");
require_once("../classes/useraccount.class.php");
require_once("../classes/admin.class.php");
require_once("../classes/insert.class.php");

$categories=Category::getAll();
$foods=Food::getAllFood();
$foodsByView=Food::getOrderFoodByViews();
$foodsByLike=Food::getOrderFoodByLikes();
$images=Image::getAllImage();
$users=User::getAllUser();
$admins=Admin::getAllAdminAccount();

if(!$_SESSION['admin']){
    header("location:admin.php");
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
    <link href="../css/adminheader.css" rel="stylesheet" type="text/css">
    <link href="../css/adminbodytable.css" rel="stylesheet" type="text/css">

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
            <li><a href="tables.php" class="current">តារាង</a></li>
            <li><a href="insert.php">បញ្ចូល</a></li>
            <li><a href="logout.php">ចាកចេញ</a></li>
        </ul>
    </div>
    <div class="divRuler"></div>

    <!--Body-->
    <div class="divBody">

        <!--Table Admin Account-->
        <div class="divTable">
            <h2>Table Admin Account</h2>
            <div class="divRuler"></div>
            <table>
                <th>adminId</th> <th>adminUsername</th> <th>adminPassword</th> <th>adminEmail</th> <th>adminDateRegister</th> <th>Option</th>
                <?php
                foreach($admins as $admin)
                    echo "<tr>
                            <td>".$admin->adminId."</td>
                            <td>".$admin->adminUsername."</td>
                            <td>".$admin->adminPassword."</td>
                            <td>".$admin->adminEmail."</td>
                            <td>".$admin->adminDateRegister."</td>
                            <td><a href='delete.php?adminId=".$admin->adminId."' onClick=\"return confirm('Are you sure you want to delete?')\">Delete</a></td>
                          </tr>"
                ?>
            </table>
        </div>

        <!--Table Food-->
        <div class="divTable">
            <h2>Table Food</h2>
            <div class="divRuler"></div>
            <table>
                <th>foodId</th> <th>foodName</th> <th>foodDesc</th> <th>foodDate</th> <th>foodView</th> <th>foodLike</th> <th>foodCategory</th> <th>Options</th>
                <?php
                    foreach($foods as $f)
                    echo "<tr>
                            <td>".$f->foodId."</td>
                            <td>".$f->foodName."</td>
                            <td class='desc'>".$f->foodDesc."</td>
                            <td>".$f->foodDate."</td>
                            <td>".$f->foodView."</td>
                            <td>".$f->foodLike."</td>
                            <td>".$f->foodCategoryId."</td>
                            <td><a href='delete.php?foodId=".$f->foodId."' onClick=\"return confirm('Are you sure you want to delete?')\">Delete</a></td>
                          </tr>"
                ?>
            </table>
        </div>

        <!--Table Image-->
        <div class="divTable">
            <h2>Table Image</h2>
            <div class="divRuler"></div>
            <table>
                <th>foodId</th> <th>imagePath1</th> <th>imagePath2</th> <th>imagePath3</th>
                <?php
                foreach($images as $i)
                    echo "<tr>
                            <td>".$i->foodId."</td>
                            <td>".$i->image1."</td>
                            <td>".$i->image2."</td>
                            <td>".$i->image3."</td>
                          </tr>"
                ?>
            </table>
        </div>

        <!--Table Category-->
        <div class="divTable">
            <h2>Table Category</h2>
            <div class="divRuler"></div>
            <table>
                <th>categoryId</th> <th>categoryName</th> <th>Option</th>
                <?php
                foreach($categories as $c)
                    echo "<tr>
                            <td>".$c->categoryId."</td>
                            <td>".$c->categoryName."</td>
                            <td><a href='delete.php?categoryId=".$c->categoryId."' onClick=\"return confirm('Are you sure you want to delete?')\">Delete</a></td>
                          </tr>"
                ?>
            </table>
        </div>

        <!--Table User-->
        <div class="divTable" style="padding-bottom: 100px">
            <h2>Table User Account</h2>
            <div class="divRuler"></div>
            <table>
                <th>userId</th> <th>userName</th> <th>userPassword</th> <th>userEmail</th> <th>userPhoneNumber</th> <th>userDateRegister</th> <th>userSubscribe</th> <th>userLogin</th> <th>Option</th>
                <?php
                    foreach($users as $user)
                        echo "<tr>
                                <td>".$user->userId."</td>
                                <td>".$user->username."</td>
                                <td>".$user->password."</td>
                                <td>".$user->userPhoneNumber."</td>
                                <td>".$user->userEmail."</td>
                                <td>".$user->userDateRegister."</td>
                                <td>".$user->userSubscribe."</td>
                                <td>".$user->userLogin."</td>
                                <td><a href='delete.php?userId=".$user->userId."' onClick=\"return confirm('Are you sure you want to delete?')\">Delete</a></td>
                              </tr>"
                ?>

            </table>
        </div>
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