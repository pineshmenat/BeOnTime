<?php

ini_set('display_errors', 'On');
error_reporting(E_ALL);
?>

<?php

$login_error = "";

include("db_config.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
// To remove special characters
    $loginUsername = mysqli_real_escape_string($db_connection, $_POST['login_username']);
    $loginPassword = mysqli_real_escape_string($db_connection, $_POST['login_password']);

    $sql = "SELECT * FROM usermaster WHERE UserName = '$loginUsername' and Password = '$loginPassword'";
    $queryResult = mysqli_query($db_connection, $sql);
    $row = mysqli_fetch_array($queryResult, MYSQLI_ASSOC);

    $rowCount = mysqli_num_rows($queryResult);

//    error_log(print_r("my_errors: " . $loginUsername . " " . $loginPassword . " " . $rowCount, true));
    if ($rowCount == 1) {

        $_SESSION['login_id'] = $row['UserId'];
        $_SESSION['login_username'] = $row['UserName'];
        $_SESSION['login_password'] = $row['Password'];
        $_SESSION['login_type'] = $row['RoleId'];

        header("location: dashboard.php");
    } else {
        $login_error = "Username or password is wrong.";
    }
}
?>

<!--<!DOCTYPE html> is important. Removing this indication will cause padding display abnormal in some places.-->
<!DOCTYPE html>
<html lang="en" data-textdirection="ltr" class="loading">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description"
          content="">
    <meta name="keywords"
          content="">
    <meta name="author" content="PIXINVENT">
    <title>Login Page - BeOnTime</title>
    <link rel="apple-touch-icon" sizes="60x60" href="../app-assets/images/ico/apple-icon-60.png">
    <link rel="apple-touch-icon" sizes="76x76" href="../app-assets/images/ico/apple-icon-76.png">
    <link rel="apple-touch-icon" sizes="120x120" href="../app-assets/images/ico/apple-icon-120.png">
    <link rel="apple-touch-icon" sizes="152x152" href="../app-assets/images/ico/apple-icon-152.png">
    <link rel="shortcut icon" type="image/x-icon" href="../assets/images/favicon.ico">
    <link rel="shortcut icon" type="image/png" href="../assets/images/favicon-32.png">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <!-- BEGIN VENDOR CSS-->
    <link rel="stylesheet" type="text/css" href="../app-assets/css/bootstrap.css">
    <!-- font icons-->
    <link rel="stylesheet" type="text/css" href="../app-assets/fonts/icomoon.css">
    <link rel="stylesheet" type="text/css" href="../app-assets/fonts/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" type="text/css" href="../app-assets/vendors/css/extensions/pace.css">
    <!-- END VENDOR CSS-->
    <!-- BEGIN ROBUST CSS-->
    <link rel="stylesheet" type="text/css" href="../app-assets/css/bootstrap-extended.css">
    <link rel="stylesheet" type="text/css" href="../app-assets/css/app.css">
    <link rel="stylesheet" type="text/css" href="../app-assets/css/colors.css">
    <!-- END ROBUST CSS-->
    <!-- BEGIN Page Level CSS-->
    <link rel="stylesheet" type="text/css" href="../app-assets/css/core/menu/menu-types/vertical-menu.css">
    <link rel="stylesheet" type="text/css" href="../app-assets/css/core/menu/menu-types/vertical-overlay-menu.css">
    <link rel="stylesheet" type="text/css" href="../app-assets/css/pages/login-register.css">
    <!-- END Page Level CSS-->
    <!-- BEGIN Custom CSS-->

    <!-- END Custom CSS-->
</head>
<body data-open="click" data-menu="vertical-menu" data-col="1-column"
      class="vertical-layout vertical-menu 1-column  blank-page blank-page">
<!-- ////////////////////////////////////////////////////////////////////////////-->
<div class="app-content content container-fluid">
    <div class="content-wrapper">

        <div class="content-header row"></div>

        <div class="content-body">
            <section class="flexbox-container">
                <div class="col-md-4 offset-md-4 col-xs-10 offset-xs-1  box-shadow-2 p-0">
                    <div class="card border-grey border-lighten-3 m-0">

<!--                        header-->
                        <div class="card-header no-border">
                            <div class="card-title text-xs-center">
                                <div class="p-1"><img src="../assets/images/logo.png" alt="BeOnTime logo" height="50" width="193">
                                </div>
                            </div>
                            <h6 class="card-subtitle line-on-side text-muted text-xs-center font-small-3">
                                <span>Login with BeOnTime</span></h6>
                        </div>

<!--                        body-->
                        <div class="card-body collapse in">
                            <div class="card-block">

<!--                                login form consists of username, password, remember me option and a login button-->
                                <form class="form-horizontal form-simple" action="" method="post">

<!--                                    username-->
                                    <fieldset class="form-group position-relative has-icon-left mb-0">
                                        <input type="text" class="form-control form-control-lg input-lg" id="login_username" name="login_username"
                                               placeholder="Your Username" required>
                                        <div class="form-control-position">
                                            <i class="icon-head"></i>
                                        </div>
                                    </fieldset>

<!--                                    password-->
                                    <fieldset class="form-group position-relative has-icon-left">
                                        <input type="password" class="form-control form-control-lg input-lg" id="login_password" name="login_password"
                                               placeholder="Enter Password" required>
                                        <div class="form-control-position">
                                            <i class="icon-key3"></i>
                                        </div>
                                    </fieldset>

<!--                                    remember me option-->
                                    <fieldset class="form-group row">
                                        <div class="col-md-6 col-xs-12 text-xs-center text-md-left">
                                            <fieldset>
                                                <input type="checkbox" id="remember-me" class="chk-remember">
                                                <label for="remember-me"> Remember Me</label>
                                            </fieldset>
                                        </div>
                                        <div class="col-md-6 col-xs-12 text-xs-center text-md-right">
                                            <a href="recover-password.php" class="card-link">Forgot Password?</a>
                                        </div>
                                    </fieldset>

<!--                                    login button-->
                                    <button type="submit" class="btn btn-success btn-lg btn-block" formmethod="post" ><i class="icon-unlock2"></i> Login</button>

                                </form>

                                <!--Login BeOnTime With Social Media account-->
                                <h6 class="card-subtitle line-on-side text-muted text-xs-center font-small-3 pt-2">
                                    <span>Login BeOnTime With Social Media Account</span></h6>
                                <a href="#"><img src="../app-assets/images/icons/facebook-logo.jpg" alt="Facebook icon" width="48" height="48"></a>
                                <a href="#"><img src="../app-assets/images/icons/twitter-logo.jpg" alt="Facebook icon" width="48" height="48"></a>
                            </div>
                        </div>

<!--                        some links to other login related functions-->
                        <div class="card-footer">
                            <div class="">
                                <p class="float-sm-left text-xs-center m-0"><a href="index.html" class="card-link">Main page&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a></p>
                                <p class="float-sm-left text-xs-center m-0"><a href="recover-password.php" class="card-link">Recover password</a></p>
                                <p class="float-sm-right text-xs-center m-0">New to BeOnTime ? <a href="register-simple.php" class="card-link">Sign Up</a></p>
                            </div>
                        </div>

                    </div>
                </div>
            </section>

        </div>
    </div>
</div>
<!-- ////////////////////////////////////////////////////////////////////////////-->

<!-- BEGIN VENDOR JS-->
<script src="../app-assets/js/core/libraries/jquery.min.js" type="text/javascript"></script>
<script src="../app-assets/vendors/js/ui/tether.min.js" type="text/javascript"></script>
<script src="../app-assets/js/core/libraries/bootstrap.min.js" type="text/javascript"></script>
<script src="../app-assets/vendors/js/ui/perfect-scrollbar.jquery.min.js" type="text/javascript"></script>
<script src="../app-assets/vendors/js/ui/unison.min.js" type="text/javascript"></script>
<script src="../app-assets/vendors/js/ui/blockUI.min.js" type="text/javascript"></script>
<script src="../app-assets/vendors/js/ui/jquery.matchHeight-min.js" type="text/javascript"></script>
<script src="../app-assets/vendors/js/ui/screenfull.min.js" type="text/javascript"></script>
<script src="../app-assets/vendors/js/extensions/pace.min.js" type="text/javascript"></script>
<!-- BEGIN VENDOR JS-->
<!-- BEGIN PAGE VENDOR JS-->
<!-- END PAGE VENDOR JS-->
<!-- BEGIN ROBUST JS-->
<script src="../app-assets/js/core/app-menu.js" type="text/javascript"></script>
<script src="../app-assets/js/core/app.js" type="text/javascript"></script>
<!-- END ROBUST JS-->
<!-- BEGIN PAGE LEVEL JS-->
<!--<script src="../assets/js/login-simple.js" type="text/javascript"></script>-->
<!-- END PAGE LEVEL JS-->
</body>
</html>