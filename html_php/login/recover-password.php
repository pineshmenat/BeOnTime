<?php

ini_set('display_errors', 'On');
error_reporting(E_ALL);
?>

<?php

use PHPMailer\PHPMailer\PHPMailer;
//use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\OAuth;
use League\OAuth2\Client\Provider\Google;

session_start();
include("../model/db_config.php");
require '../../assets/composer/vendor/autoload.php';


$forgetPasswordErrorDisplay = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $userEmail = $_POST['userEmail'];

    error_log("userEmail: " . $userEmail);

    if (isset($userEmail)) {

        $forgetPasswordErrorDisplay = processForgetPassword($userEmail);
    }
}

function processForgetPassword($userEmail) {

    $forgetPasswordSQL = "SELECT UserName, FirstName, LastName, Password FROM usermaster WHERE EMail = :email";
    $pdpstm = DB::getDBConnection()->prepare($forgetPasswordSQL);
    $pdpstm->bindValue(':email', $userEmail, PDO::PARAM_STR);
    $pdpstm->execute();
    $pdpstm->setFetchMode(PDO::FETCH_ASSOC);

    $rowCount = $pdpstm->rowCount();
//    error_log("rowCount: " . $rowCount);

    $resultSet = $pdpstm->fetchAll();

    if ($rowCount == 1) {

        $userName = $resultSet[0]['UserName'];
        $firstname = $resultSet[0]['FirstName'];
        $lastname = $resultSet[0]['LastName'];
        $password = $resultSet[0]['Password'];

//        return sendEmail($userEmail, $firstname, $lastname, $password);
        return sendEmailWithOAuth($userName, $userEmail, $firstname, $lastname, $password);

    } else if ($rowCount == 0) {
        return "This email address doesn't exist.";
    } else {
        return "There is more than 1 BeOnTime user account associated with this email address. Please change.";
    }

}


function sendEmailWithOAuth($userName, $userEmail, $firstname, $lastname, $password) {

    $mail = new PHPMailer;
    $mail->isSMTP();
    $mail->SMTPDebug = 0;
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 587;
    $mail->SMTPSecure = 'tls';
    $mail->SMTPAuth = true;
    $mail->AuthType = 'XOAUTH2';

    $email = 'mail.beontime@gmail.com';
    $clientId = '54609260413-6h0k89v22dej7neoc4hndh2jisos3a4a.apps.googleusercontent.com';
    $clientSecret = 'esvUbmEqrZvXKDz-6RCx11oA';

    $refreshToken = '1/qSqerD_tXh9bCwZyfa0j2vx3zIAWgFNZk2CBekgM9K4Moig2PqRA_Np5daRRAi3n';
    $provider = new Google(['clientId' => $clientId, 'clientSecret' => $clientSecret]);
    $mail->setOAuth(
        new OAuth(
            [
                'provider' => $provider,
                'clientId' => $clientId,
                'clientSecret' => $clientSecret,
                'refreshToken' => $refreshToken,
                'userName' => $email
            ]));
    $mail->setFrom($email, 'BeOnTime Admin');
    $mail->addAddress($userEmail, $firstname . ' ' . $lastname);
    $mail->Subject = '[BeOnTime] Password recovery';
    $mail->CharSet = 'utf-8';
    $mail->Body = "<html><body>" .
        "Dear " . ucwords($firstname) . ' ' . ucwords($lastname) . ",<br/><br/>" .
        "Your username is " . "<b>" . $userName . "</b><br/>" .
        "Your password is " . "<b>" . $password . "</b><br/>" .
        "<br/>Regards," .
        "<br/>BeOnTime project group" .
        "<br/><img src=\"https://lh3.googleusercontent.com/txsj9j8T7lrry_VAxqamtdSLjTI09WqB_2wToAF9RL_IDcPGi4oin4hrB_UBGRcdSqCbeNl8PBj9LsumgTe6IGgSXztdb-GLKC-TlOfarAXTr8zAEciMExpUS3syFCqvqxYKAMTe=w194-h50-no\" alt=\"BeOnTime logo 50\" width=\"194\" height=\"50\">" .
        "</body></html>";
    $mail->IsHTML(true);

    if (!$mail->send()) {
        return "Mailer Error: " . $mail->ErrorInfo;
    } else {
        return "Message sent!";
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
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="PIXINVENT">
    <title>Recover Password - BeOnTime</title>
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
    <!-- END Page Level CSS-->
    <!-- BEGIN Custom CSS-->

    <!-- END Custom CSS-->
</head>
<body data-open="click" data-menu="vertical-menu" data-col="1-column"
      class="vertical-layout vertical-menu 1-column  blank-page blank-page">
<!-- ////////////////////////////////////////////////////////////////////////////-->
<div class="app-content content container-fluid">
    <div class="content-wrapper">

        <!--                        header-->
        <div class="content-header row"></div>

        <!--                        body-->
        <div class="content-body">
            <section class="flexbox-container">
                <div class="col-md-4 offset-md-4 col-xs-10 offset-xs-1 box-shadow-2 p-0">
                    <div class="card border-grey border-lighten-3 px-2 py-2 m-0">

                        <!--                        Information display-->
                        <div class="card-header no-border pb-0">
                            <div class="card-title text-xs-center">
                                <img src="../../assets/images/logo.png" alt="branding logo" height="50" width="193">
                            </div>
                            <h6 class="card-subtitle line-on-side text-muted text-xs-center font-small-3 pt-2"><span>We will send you an email to tell you your password.</span>
                            </h6>
                        </div>


                        <div class="card-body collapse in">
                            <div class="card-block">
                                <!--                                recover password form-->
                                <form class="form-horizontal" action="" novalidate>
                                    <fieldset class="form-group position-relative has-icon-left">
                                        <input type="email" class="form-control form-control-lg input-lg" id="userEmail"
                                               name="userEmail"
                                               placeholder="Your Email Address" required autofocus>
                                        <div class="form-control-position">
                                            <i class="icon-mail6"></i>
                                        </div>
                                        <div class="text-danger">
                                            <?= $forgetPasswordErrorDisplay; ?>
                                        </div>
                                    </fieldset>
                                    <button type="submit" class="btn btn-success btn-lg btn-block" formmethod="post"><i
                                                class="icon-lock4"></i> Recover
                                        Password
                                    </button>
                                </form>

                            </div>
                        </div>

                        <!--                        some links to other login related functions-->
                        <div class="card-footer no-border">
                            <p class="float-sm-left text-xs-center"><a href="../index.html" class="card-link">Main page&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>
                            </p>
                            <p class="float-sm-left text-xs-center"><a href="login.php" class="card-link">Login</a></p>
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
