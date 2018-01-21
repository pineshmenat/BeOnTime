<?php
session_start();
include "../model/db_config.php";
include "../model/Validate.php";
if(isset($_POST['register']) && $_POST['register']){
    $email = $_POST['userName'];
    $password = $_POST['password'];
    $repeatpassword = $_POST['repeat_password'];
    if(isset($email) && isset($password) && isset($repeatpassword)) {
        $email_error = Validate::validateEmail($email);
        $password_error = Validate::validatePassword($password, $repeatpassword);
        if ($email_error == "" && $password_error == "") {
            $signUpAuthenticationSQL = "SELECT * FROM companymaster WHERE CompanyEmail = :email";
            $dbConnection = DB::getDBConnection();
            $pdpstm = $dbConnection->prepare($signUpAuthenticationSQL);
            $pdpstm->bindValue(':email', $email, PDO::PARAM_STR);
            $pdpstm->execute();
            $pdpstm->setFetchMode(PDO::FETCH_ASSOC);

            $rowCount = $pdpstm->rowCount();
            if($rowCount > 0){
                $email_error="has already been taken";
            }
            else {
               /* $createAccountSQL = "INSERT INTO companymaster(CompanyEmail,CompanyPassword) VALUES (:email,:password)";
                $dbConnection = DB::getDBConnection();
                $pdpstm =$dbConnection->prepare($createAccountSQL);
                $pdpstm->bindValue(':email',$email);
                $pdpstm->bindValue(':password',$password);
                $pdpstm->execute();
                $companyIDSQL = "SELECT * FROM companymaster where CompanyEmail = :email";
                $pdpstm = $dbConnection -> prepare($companyIDSQL);
                $pdpstm->bindValue(':email',$email);
                $pdpstm->execute();
                $id = $pdpstm->fetch();
                $_SESSION['company_id'] = $id['CompanyId'];*/
                $_SESSION['userName'] = $email;
                $_SESSION['password'] = $password;

                header("location:../manager_operations/manager_create_companyprofile.php");
            }
        }
    }
}
?>
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
    <title>Register Page - BeOnTime</title>
    <link rel="apple-touch-icon" sizes="60x60" href="../../app-assets/images/ico/apple-icon-60.png">
    <link rel="apple-touch-icon" sizes="76x76" href="../../app-assets/images/ico/apple-icon-76.png">
    <link rel="apple-touch-icon" sizes="120x120" href="../../app-assets/images/ico/apple-icon-120.png">
    <link rel="apple-touch-icon" sizes="152x152" href="../../app-assets/images/ico/apple-icon-152.png">
    <link rel="shortcut icon" type="image/x-icon" href="../../assets/images/favicon.ico">
    <link rel="shortcut icon" type="image/png" href="../../assets/images/favicon-32.png">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <!-- BEGIN VENDOR CSS-->
    <link rel="stylesheet" type="text/css" href="../../app-assets/css/bootstrap.css">
    <!-- font icons-->
    <link rel="stylesheet" type="text/css" href="../../app-assets/fonts/icomoon.css">
    <link rel="stylesheet" type="text/css" href="../../app-assets/fonts/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" type="text/css" href="../../app-assets/vendors/css/extensions/pace.css">
    <!-- END VENDOR CSS-->
    <!-- BEGIN ROBUST CSS-->
    <link rel="stylesheet" type="text/css" href="../../app-assets/css/bootstrap-extended.css">
    <link rel="stylesheet" type="text/css" href="../../app-assets/css/app.css">
    <link rel="stylesheet" type="text/css" href="../../app-assets/css/colors.css">
    <!-- END ROBUST CSS-->
    <!-- BEGIN Page Level CSS-->
    <link rel="stylesheet" type="text/css" href="../../app-assets/css/core/menu/menu-types/vertical-menu.css">
    <link rel="stylesheet" type="text/css" href="../../app-assets/css/core/menu/menu-types/vertical-overlay-menu.css">
    <link rel="stylesheet" type="text/css" href="../../app-assets/css/pages/login-register.css">
    <!-- END Page Level CSS-->
    <!-- BEGIN Custom CSS-->

    <!-- END Custom CSS-->
</head>
<body data-open="click" data-menu="vertical-menu" data-col="1-column"
      class="vertical-layout vertical-menu 1-column  blank-page blank-page">
<!-- ////////////////////////////////////////////////////////////////////////////-->
<div class="app-content content container-fluid">
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <section class="flexbox-container">
                <div class="col-md-4 offset-md-4 col-xs-10 offset-xs-1 box-shadow-2 p-0">
                    <div class="card border-grey border-lighten-3 px-2 py-2 m-0">
                        <div class="card-header no-border">
                            <div class="card-title text-xs-center">
                                <img src="../../assets/images/logo.png" alt="branding logo" height="50" width="193">
                            </div>
                            <h6 class="card-subtitle line-on-side text-muted text-xs-center font-small-3 pt-2">
                                <span>Create Account</span></h6>
                        </div>
                        <div class="card-body collapse in">
                            <div class="card-block">
                                <form class="form-horizontal form-simple" action="" method="post">
                                    <fieldset class="form-group position-relative has-icon-left mb-1">
                                        <input type="text" class="form-control form-control-lg input-lg" id="userName"
                                               placeholder="Your Email Address" name="userName" value="<?php if(isset($email)){ echo $email;} ?>">
                                        <div class="form-control-position">
                                            <i class="icon-mail6"></i>
                                        </div>
                                        <small class="help-block text-danger"><?php if(isset($email_error)){ echo $email_error;} ?></small>
                                    </fieldset>
                                    <fieldset class="form-group position-relative has-icon-left">
                                        <input type="password" class="form-control form-control-lg input-lg" id="user-password" name="password"
                                               placeholder="Enter Password">
                                        <div class="form-control-position">
                                            <i class="icon-key3"></i>
                                        </div>
                                        <small class="help-block text-danger"><?php if(isset($password_error)){ echo $password_error;} ?></small>
                                    </fieldset>
                                    <fieldset class="form-group position-relative has-icon-left">
                                        <input type="password" class="form-control form-control-lg input-lg" id="user-password" name="repeat_password"
                                               placeholder="Repeat Password">
                                        <div class="form-control-position">
                                            <i class="icon-key3"></i>
                                        </div>
                                    </fieldset>
                                    <input type="submit" id="register" name="register" value="&rarrhk; Register" class="btn btn-success btn-lg btn-block"/>
                                </form>
                            </div>
                            <p class="float-sm-left text-xs-center"><a href="index.php" class="card-link">Main page&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a></p>
                            <p class="text-xs-center">Already have an account ? <a href="login.php" class="card-link">Login</a></p>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
<!-- ////////////////////////////////////////////////////////////////////////////-->

<!-- BEGIN VENDOR JS-->
<script src="../../app-assets/js/core/libraries/jquery.min.js" type="text/javascript"></script>
<script src="../../app-assets/vendors/js/ui/tether.min.js" type="text/javascript"></script>
<script src="../../app-assets/js/core/libraries/bootstrap.min.js" type="text/javascript"></script>
<script src="../../app-assets/vendors/js/ui/perfect-scrollbar.jquery.min.js" type="text/javascript"></script>
<script src="../../app-assets/vendors/js/ui/unison.min.js" type="text/javascript"></script>
<script src="../../app-assets/vendors/js/ui/blockUI.min.js" type="text/javascript"></script>
<script src="../../app-assets/vendors/js/ui/jquery.matchHeight-min.js" type="text/javascript"></script>
<script src="../../app-assets/vendors/js/ui/screenfull.min.js" type="text/javascript"></script>
<script src="../../app-assets/vendors/js/extensions/pace.min.js" type="text/javascript"></script>
<!-- BEGIN VENDOR JS-->
<!-- BEGIN PAGE VENDOR JS-->
<!-- END PAGE VENDOR JS-->
<!-- BEGIN ROBUST JS-->
<script src="../../app-assets/js/core/app-menu.js" type="text/javascript"></script>
<script src="../../app-assets/js/core/app.js" type="text/javascript"></script>
<!-- END ROBUST JS-->
<!-- BEGIN PAGE LEVEL JS-->
<!-- END PAGE LEVEL JS-->
</body>
</html>
