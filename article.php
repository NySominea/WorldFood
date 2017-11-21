<?php
session_start();
    if(empty($_GET['article'])){
        header("location:index.php");
    }
    require_once("classes/category.class.php");
    require_once("classes/food.class.php");
    require_once("classes/imagefood.class.php");
    require_once("classes/update.class.php");
    require_once("classes/insert.class.php");
    require_once("classes/useraccount.class.php");
    require_once("classes/update.class.php");
    require_once("classes/macaddress.php");

    $categories=Category::getAll();
    $food=Food::getAllFoodByID($_GET['article']);
    Update::updateFoodView($_GET['article']);
    $foods=Food::getFoodByCategory($food->foodCategoryId);
    $image=Image::getAllImageByID($_GET['article']);
    $users=User::getAllUser();
    $macs=Mac::getAllMac();

    $like=0;

//Mac Addres User
ob_start();
//Get the ipconfig details using system commond
system('ipconfig /all');
// Capture the output into a variable
$mycomsys=ob_get_contents();
// Clean (erase) the output buffer
ob_clean();
$find_mac = "Physical"; //find the "Physical" & Find the position of Physical text
$pmac = strpos($mycomsys, $find_mac);
// Get Physical Address
$macaddress=substr($mycomsys,($pmac+36),17);

//Sign up
$signup=false;
if(isset($_POST['signup'])){
    if(!empty($_POST['nameSignUp']) && !empty($_POST['emailSignUp']) && !empty($_POST['passwordSignUp'])){
        if($_POST['passwordSignUp']==$_POST['confirmPasswordSignUp']){
            Insert::insertUserAccount($_POST['nameSignUp'],$_POST['passwordSignUp'],$_POST['emailSignUp'],$_POST['telSignUp']);
            $signup=true;
        }else{
            echo "<script>alert('Your password is not the same as the first one.');</script>";
        }
    }else{
        echo "<script>alert('Sign Up fail. Please fill all information.');</script>";
    }
}

//Login
if(isset($_POST['login'])){
    $login=false;
    if(!empty($_POST['loginUsername']) && !empty($_POST['loginPassword'])){
        foreach($users as $user){
            if($_POST['loginUsername']==$user->username && $_POST['loginPassword']==$user->password){
                $_SESSION['userLogin']=$user->userId;
                Update::updateUserLogin($user->userId,'1');
                $login=true;
                echo "<script>alert('Logged in.');</script>";
                break;
            }
        }
        if(!$login)
            echo "<script>alert('Log in fail.');</script>";

    }else{
        echo "<script>alert('Please fill Username and Password.');</script>";
    }

}
?>

<!DOCTYPE html>
<html>
<head>
    <title>World Food | <?php echo $food->foodName?></title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="bs3/css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="bs3/css/bootstrap-theme.css" type="text/css">
    <link rel="stylesheet" href="bs3/css/bootstrap-theme.min.css" type="text/css">
    <link rel="stylesheet" href="bs3/css/bootstrap.css" type="text/css">
    <link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="css/header_footer.css" type="text/css">
    <link rel="stylesheet" href="css/bodyarticle.css" type="text/css">

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
    if(!empty($_SESSION['subscribe'])){
        unset($_SESSION['subscribe']);
        echo "
            <script type='text/javascript'>
                $(window).load(function(){
                    $('#thankSubscribeModal').modal('show');
                });

            </script>
        ";
    }
    ?>
</head>
<body>
<div class="divContainer">
    <!--Header-->
    <div class="divHeader">
        <a href="index.php"><img src="images/logo_final.png" alt="logo"></a>
        <div class="divHeaderRight">
            <div class="divIcon">
                <a href="https://www.facebook.com/Ny.Sominea"><i class="fa fa-facebook-square fa-2x" style="color: blue"></i></a>
                <a href="https://twitter.com/"><i class="fa fa-twitter-square fa-2x" style="color: deepskyblue"></i></a>
                <a href="https://plus.google.com/"><i class="fa fa-google-plus-square fa-2x" style="color: red"></i></a>
                <a href="https://www.youtube.com/"><i class="fa fa-youtube-square fa-2x" style="color: red"></i></a>
            </div>
            <form class="divFormSearch" method="post" action="searchpage.php">
                <input type="search" name="userSearch" placeholder="ស្វែងរក" autocomplete="on"/><input type="submit" name="search" value="ស្វែងរក">
            </form>
            <div class="divButtonForUser">
                <?php
                if(isset($_SESSION['userLogin']))
                    echo "<a href='logout.php?userId=".$_SESSION['userLogin']."'>LOG OUT</a>";
                else
                    echo "<a href='#' data-target='#loginModal' data-toggle='modal'>LOG IN</a>";
                ?>
                <a href="#" data-target="#signupModal" data-toggle="modal">SIGN UP</a><br><br>

                <?php
                if(isset($_SESSION['userLogin']))
                    echo "<a href='subscribe.php'
                    style='padding: 6px 33px; background:red'>SUBSCRIBE</a>";
                else
                    echo "<a href='#' data-target='#loginModal' data-toggle='modal' style='padding: 6px 33px; background:red'>SUBSCRIBE</a>";
                ?>
            </div>
        </div>
    </div>
    <div class="divRuler"></div>
    <!--Navigation bar-->
    <div class="divNavBar">
        <ul>
            <li><a href="index.php"><i class="fa fa-home" style="font-size: 25px"></i></a></li>
            <?php
            foreach($categories as $c){
                echo "<li><a href='category.php?categoryId=".$c->categoryId."'>".$c->categoryName."</a>";
            }
            ?>
        </ul>
    </div>
    <div class="divRuler"></div>

    <!--Body-->
    <div class="divBody">
        <div class="divBodyArticle">
            <?php
                echo "<h3>".$food->foodName."</h3>";
                echo "<div class='divBodyRuler'></div>";
                echo "<h4>កាលបរិច្ឆេទ:".$food->foodDate."</h4>";
            if(!$macs){
                echo "<a href='like.php?foodId=".$food->foodId."& mac=".$macaddress."& bln=1' role='button'​>ចូលចិត្ត<i class='fa fa-thumbs-up'></i> ".$food->foodLike."</a>";
            }else{
                foreach($macs as $mac){
                    if($macaddress==$mac->macaddress && $_GET['article']==$mac->foodId) {
                        echo "<a href='like.php?foodId=" . $food->foodId . "& mac=" . $macaddress . "& bln=0' role='button'​>មិនចូលចិត្ត<i class='fa fa-thumbs-down'></i> " . $food->foodLike . "</a>";
                        $like=0;
                        break;
                    }else $like=1;
                }
                if($like==1)
                    echo "<a href='like.php?foodId=".$food->foodId."& mac=".$macaddress."& bln=1' role='button'​>ចូលចិត្ត<i class='fa fa-thumbs-up'></i> ".$food->foodLike."</a>";

            }




                echo "<img src='images/".$image->image1."'>";
                echo "<img src='images/".$image->image2."'>";
                echo "<img src='images/".$image->image3."'>";
                echo "<pre>".$food->foodDesc."</pre>";
            ?>
        </div>
        <div class="divBodySideContent">
            <h4>អត្ថបទទាក់ទង</h4>
            <div class="divBodyRuler"></div>
            <?php
            foreach($foods as $f){
                if($f->foodId!=$food->foodId) {
                    echo "<div class=\"divBodySideFoodContent\">
                                <a href='article.php?article=".$f->foodId."'>
                                    <img src='images/" .Image::getAnImage($f->foodId) . "'>
                                    <h5>" . $f->foodName . "</h5>";
                    echo "<i class='fa fa-thumbs-up'>" . $f->foodLike . "</i><i class='fa fa-eye'>" . $f->foodView . "</i>
                                </a>
                              </div>";
                }
            }
            ?>
        </div>
    </div>
    <div class="divRuler"></div>

    <!--Footer-->
    <div class="divFooter">
        <h4 style="color: red">www.worldfood.orgfree.com</h4>
        <h4 style="color: white">Copyright <i class="fa fa-copyright" aria-hidden="true"></i> 2016 <span style="color:red;">World Food</span> All rights reserved
        </h4>
        <button data-target='#contactModal' data-toggle='modal'>Contact us</button>
    </div>

    <!--Modal Login-->
    <div class="modal fade"  id="loginModal" data-keyboard="false" data-backdrop="static" style="margin-right: 100px">
        <div class="modal-dialog modal-sm">
            <div class="modal-content" style="width: 400px  ">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        &times;
                    </button>
                    <h2 class="modal-title" style="text-align: center">Login</h2>
                </div>
                <div class="modal-body">
                    <form method="post">
                        <div class="form-group">
                            <label for="inputUserName">Username</label>
                            <input class="form-control" placeholder="Login Username" type="text" name="loginUsername"/>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword">Password</label>
                            <input class="form-control" placeholder="Login Password" type="password" name="loginPassword"/>
                        </div>
                        <div class="modal-footer">
                            <input type="submit" class="btn btn-primary" style="width: 100%;margin: 0px" value="Login" name="login">

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!--Model Sign up-->
    <div class="modal fade"  id="signupModal" data-keyboard="false" data-backdrop="static" style="margin-right: 100px">
        <div class="modal-dialog modal-sm">
            <div class="modal-content" style="width: 400px">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h2 class="modal-title" style="text-align: center">Sign Up Account</h2>
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
                            <label for="inputTel">Phone number</label>
                            <input class="form-control" placeholder="Phone number" type="tel" name="telSignUp"/>
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

    <!--Modal Thanks for sign up-->
    <div class="modal fade"  id="thankSignupModal" data-keyboard="false" data-backdrop="static" style="margin-right: 100px">
        <div class="modal-dialog modal-sm">
            <div class="modal-content" style="width: 400px">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        &times;
                    </button>
                    <h2 class="modal-title" style="text-align: center">Thank you!</h2>
                </div>
                <div class="modal-body">
                    <p>Thank you for signin up our website.</p>
                    <p>Please enjoy with us!</p>
                </div>
                <div class="modal-footer">
                    <a class="btn btn-primary" data-dismiss="modal">Close</a>
                </div>
            </div>
        </div>
    </div>

    <!--Modal Thanks for Subscribe-->
    <div class="modal fade"  id="thankSubscribeModal" data-keyboard="false" data-backdrop="static" style="margin-right: 100px">
        <div class="modal-dialog modal-sm">
            <div class="modal-content" style="width: 450px">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        &times;
                    </button>
                    <h2 class="modal-title" style="text-align: center">Thank You For Subcribe Us!</h2>
                </div>
                <div class="modal-footer">
                    <a class="btn btn-primary" data-dismiss="modal">Close</a>
                </div>
            </div>
        </div>
    </div>

    <!--Modal Contact Us-->
    <div class="modal fade"  id="contactModal" data-keyboard="false" data-backdrop="static" style="margin-right: 100px">
        <div class="modal-dialog modal-sm">
            <div class="modal-content" style="width: 450px">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        &times;
                    </button>
                    <h2 class="modal-title" style="text-align: center">Contact Us</h2>
                </div>
                <div class="modal-body">
                    <pre><h3>TEL   : 093355045</h3></pre><br>
                    <pre><h3>TEL   : 098837562</h3></pre><br>
                    <pre style="margin-bottom: 30px"><h3>Email : sominea.ny77@gmail.com</h3></pre>
                    <pre><h3>Email : chongeangy@gmail.com</h3></pre>
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
