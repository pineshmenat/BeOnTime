<?php
session_start();
require "../model/CompanyDB.php";
require "../model/Validate.php";
$errorFirstName = "";
$errorLastName = "";
$errorEmail = "";
$errorStreetAddress = "";
$errorCity = "";
$errorProvince = "";
$errorZipCode = "";
$errorSINNumber = "";
if (!isset($_SESSION['userName'])) {
    header("location: ../login/login.php");
}
else{

    if($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['employeeId'])){
        $employeeDetails  = CompanyDB::getEmployeeDetails($_GET['employeeId'],$_SESSION['companyId']);
        unset($_GET['employeeId']);
        foreach ($employeeDetails as $employeeDetail){
            $firstName = $employeeDetail['FirstName'];
            $lastName = $employeeDetail['LastName'];
            $sin = $employeeDetail['SIN'];
            $email = $employeeDetail['EMail'];
            $streetAddress = $employeeDetail['Address'];
            $city = $employeeDetail['City'];
            $state = $employeeDetail['Province'];
            $zipCode = $employeeDetail['PostalCode'];
            $employeeId =   $employeeDetail['UserId'];
            $country = "Canada";
        }
    }
    else if(isset($_POST['save_changes']) && $_POST['save_changes']){
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $sin = $_POST['sin'];
        $email = $_POST['email'];
        $streetAddress = $_POST['route'];
        $city = $_POST['locality'];
        $state = $_POST['administrative_area_level_1'];
        $zipCode = $_POST['postal_code'];
        $employeeId =   $_POST['employeeId'];
        $country = "Canada";
        if(Validate::validateFirstName($firstName) != "" || Validate::validateLastName($lastName) != "" ||
            Validate::validateSINNumber($sin) != "" || Validate::validateEmail($email) != "" ||
            Validate::validateStreet($streetAddress) != "" || Validate::validateCity($city) != "" ||
            Validate::validateProvince($state) != "" || Validate::validateZipCode($zipCode) != ""){
            $errorFirstName = Validate::validateFirstName($firstName);
            $errorLastName = Validate::validateLastName($lastName);
            $errorEmail = Validate::validateEmail($email);
            $errorStreetAddress = Validate::validateStreet($streetAddress);
            $errorCity = Validate::validateCity($city);
            $errorProvince = Validate::validateProvince($state);
            $errorZipCode = Validate::validateZipCode($zipCode);
            $errorSINNumber = Validate::validateSINNumber($sin);
        }
        else {
            CompanyDB::updateEmployeeDetails($_SESSION['companyId'], $_POST['employeeId'], $firstName, $lastName, $sin, $email,
                $streetAddress, $city, $state, $zipCode);
            header("Location: manager_manage_employee.php");
        }
    }
    else{
        header("manager_manage_employee.php");
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
          content="Robust admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords"
          content="admin template, robust admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="PIXINVENT">
    <title>BeOnTime Dashboard</title>
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
    <link rel="stylesheet" type="text/css" href="../../app-assets/css/core/colors/palette-gradient.css">
    <!-- END Page Level CSS-->
    <!-- BEGIN Custom CSS-->
    <!-- END Custom CSS-->
</head>
<body data-open="click" data-menu="vertical-menu" data-col="2-columns" class="vertical-layout vertical-menu 2-columns  fixed-navbar">

<!-- navbar-fixed-top-->
<nav class="header-navbar navbar navbar-with-menu navbar-fixed-top navbar-semi-dark navbar-shadow">
    <div class="navbar-wrapper">
        <div class="navbar-header">
            <ul class="nav navbar-nav">
                <li class="nav-item mobile-menu hidden-md-up float-xs-left"><a class="nav-link nav-menu-main menu-toggle hidden-xs"><i
                                class="icon-menu5 font-large-1"></i></a></li>
                <li class="nav-item"><a href="#" class="navbar-brand nav-link"><img alt="branding logo"
                                                                                    src="../../assets/images/logo_50.png"
                                                                                    data-expand="../../assets/images/logo_50.png"
                                                                                    data-collapse="../../assets/images/logo_xsmall.png"
                                                                                    class="brand-logo"></a></li>
                <li class="nav-item hidden-md-up float-xs-right"><a data-toggle="collapse" data-target="#navbar-mobile"
                                                                    class="nav-link open-navbar-container"><i
                                class="icon-ellipsis pe-2x icon-icon-rotate-right-right"></i></a></li>
            </ul>
        </div>
        <div class="navbar-container content container-fluid">
            <div id="navbar-mobile" class="collapse navbar-toggleable-sm">
                <ul class="nav navbar-nav">
                    <li class="nav-item hidden-sm-down"><a class="nav-link nav-menu-main menu-toggle hidden-xs"><i
                                    class="icon-menu5"> </i></a></li>
                    <li class="nav-item hidden-sm-down"><a href="#" class="nav-link nav-link-expand"><i class="ficon icon-expand2"></i></a>
                    </li>
                </ul>
                <ul class="nav navbar-nav float-xs-right">

                    <li class="dropdown dropdown-user nav-item">
                        <a href="#" data-toggle="dropdown" class="dropdown-toggle nav-link dropdown-user-link">
                            <span class="avatar avatar-online">
                                <img src="../../assets/images/portrait_img/<?= $_SESSION['portraintImg']; ?>" alt="portraitImg"><i></i>
                            </span>
                            <span class="user-name"><?= $_SESSION['userName']; ?></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a href="manager_edit_companyprofile.php" class="dropdown-item"><i class="icon-head"></i> Edit Profile</a>
                            <div class="dropdown-divider"></div>
                            <a href="../login/logout.php" class="dropdown-item"><i class="icon-power3"></i> Logout</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>

<!-- ////////////////////////////////////////////////////////////////////////////-->


<!-- main menu-->
<div data-scroll-to-active="true" class="main-menu menu-fixed menu-dark menu-accordion menu-shadow">
    <!-- main menu header-->
    <div class="main-menu-header">
        <!--        <input type="text" placeholder="Search" class="menu-search form-control round"/>-->
    </div>
    <!-- / main menu header-->
    <!-- main menu content-->
    <div class="main-menu-content">
        <ul id="main-menu-navigation" data-menu="menu-navigation" class="navigation navigation-main">

            <li class=" nav-item">
                <a href="#"><i class="icon-home3"></i>
                    <span data-i18n="nav.page_layouts.main" class="menu-title">Manager</span>
                </a>
                <ul class="menu-content">
                    <li>
                        <a href="manager_assign_shift_frontend.php" data-i18n="nav.page_layouts.1_column" class="menu-item">Assign Shift</a>
                    </li>
                    <li>
                        <a href="manager_view_shift_frontend.php" data-i18n="nav.page_layouts.2_columns" class="menu-item">View Shift</a>
                    </li>
                    <li>
                        <a href="manager_track_emphours.php" data-i18n="nav.page_layouts.2_columns" class="menu-item">Track Emp's Workhour</a>
                    </li>
                    <li>
                        <a href="manager_track_employee.php" data-i18n="nav.page_layouts.2_columns" class="menu-item">Track Emp's Position</a>
                    </li>
                    <li class="active">
                        <a href="manager_create_employee.php" data-i18n="nav.page_layouts.2_columns" class="menu-item">Create Employee</a>
                    </li>
                    <li>
                        <a href="manager_manage_employee.php" data-i18n="nav.page_layouts.2_columns" class="menu-item">Manage Employee</a>
                    </li>
                    <li>
                        <a href="manager_view_companyprofile.php" data-i18n="nav.page_layouts.2_columns" class="menu-item">View Company's Profile</a>
                    </li>
                </ul>
            </li>

        </ul>
    </div>
    <!-- /main menu content-->
    <!-- main menu footer-->
    <!-- include includes/menu-footer-->
    <!-- main menu footer-->
</div>
<!-- / main menu-->
<div class="app-content content container-fluid">
    <div class="content-wrapper">
        <div class="content-header row">
            <h1>Employee Edit Details</h1>
        </div>
        <div class="row mt-1 col-md-12"></div>
        <div class="content-body">
            <form class="form" id="company_signup" method="post" action="">
                <input type="hidden" value="<?php  echo $employeeId; ?>" name="employeeId">
                <div class="form-group row">
                    <label for="firstName" class="col-sm-3 col-lg-1 label-control">First Name: </label>
                    <div class="col-sm-9 col-lg-2">
                        <input class="form-control-sm col-sm-12" type="text" value="<?php echo $firstName ?>" id="firstName" name="firstName">
                        <div class="col-sm-10 nopadding">
                            <small class="help-block text-danger"><?php echo $errorFirstName;?></small>
                        </div>
                    </div>
                    <label for="lastName" class="col-sm-3 col-lg-1 label-control">Last Name: </label>
                    <div class="col-sm-9 col-lg-2">
                        <input class="form-control-sm col-sm-13" type="text" value="<?php echo $lastName ?>" id="lastName" name="lastName">
                        <div class="col-sm-10 nopadding">
                            <small class="help-block text-danger"><?php echo $errorLastName;?></small>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="sin" class="col-sm-3 col-lg-1 label-control">SIN: </label>
                    <div class="col-sm-9 col-lg-10">
                        <input class="form-control-sm col-sm-6" type="text" value="<?php echo $sin ?>" id="sin" name="sin">
                        <div class="col-sm-10 nopadding">
                            <small class="help-block text-danger"><?php echo $errorSINNumber;?></small>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="email" class="col-sm-3 col-lg-1 label-control">Email: </label>
                    <div class="col-sm-9 col-lg-10">
                        <input class="form-control-sm col-sm-6" type="text" value="<?php echo $email ?>" id="email" name="email">
                        <div class="col-sm-10 nopadding">
                            <small class="help-block text-danger"><?php echo $errorEmail;?></small>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="route" class="col-sm-3 col-lg-1 label-control">Street Address: </label>
                    <div class="col-sm-9 col-lg-10">
                        <input class="form-control-sm col-sm-5" type="text" value="<?php echo $streetAddress ?>" id="route" name="route">
                        <div class="col-sm-10 nopadding">
                            <small class="help-block text-danger"><?php echo $errorStreetAddress;?></small>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="locality" class="col-sm-3 col-lg-1 label-control">City</label>
                    <div class="col-sm-9 col-lg-10">
                        <input class="form-control-sm col-sm-6" type="text" value="<?php echo $city ?>" id="locality" name="locality">
                        <div class="col-sm-10 nopadding">
                            <small class="help-block text-danger"><?php echo $errorCity;?></small>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="administrative_area_level_1" class="col-sm-3 col-lg-1 label-control">State: </label>
                    <div class="col-sm-9 col-lg-2">
                        <input class="form-control-sm col-sm-12" type="text" value="<?php echo $state ?>" id="administrative_area_level_1" name="administrative_area_level_1">
                        <div class="col-sm-10 nopadding">
                            <small class="help-block text-danger"><?php echo $errorProvince;?></small>
                        </div>
                    </div>
                    <label for="postal_code" class="col-sm-3 col-lg-1 label-control">ZipCode: </label>
                    <div class="col-sm-9 col-lg-2">
                        <input class="form-control-sm col-sm-13" type="text" value="<?php echo $zipCode ?>" id="postal_code" name="postal_code">
                        <div class="col-sm-10 nopadding">
                            <small class="help-block text-danger"><?php echo $errorZipCode;?></small>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="country" class="col-sm-3 col-lg-1 label-control">Country</label>
                    <div class="col-sm-9 col-lg-10">
                        <input class="form-control-sm col-sm-6" type="text" value="<?php echo $country ?>" id="country" name="country" disabled>
                    </div>
                </div>
                <div class="row mt-1 col-md-12"></div>
                <div class="form-group row ml-3">
                    <input type="submit" class="btn btn-success" value="Save Changes" name="save_changes" />
                </div>
            </form>
        </div>
    </div>
</div>
<!-- ////////////////////////////////////////////////////////////////////////////-->


<footer class="footer footer-static footer-light navbar-border">
    <p class="clearfix text-muted text-sm-center mb-0 px-2"><span class="float-md-left d-xs-block d-md-inline-block">Copyright  &copy; 2017 <a
                    href="#" target="_blank" class="text-bold-800 grey darken-2">BeOnTime Project Group </a>, All rights reserved. </span><span
                class="float-md-right d-xs-block d-md-inline-block">We made with <i class="icon-heart5 pink"></i></span></p>
</footer>

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
<script src="../../app-assets/vendors/js/charts/chart.min.js" type="text/javascript"></script>
<!-- END PAGE VENDOR JS-->
<!-- BEGIN ROBUST JS-->
<script src="../../app-assets/js/core/app-menu.js" type="text/javascript"></script>
<script src="../../app-assets/js/core/app.js" type="text/javascript"></script>
<!-- END ROBUST JS-->
<!-- BEGIN PAGE LEVEL JS-->
<script src="../../app-assets/js/scripts/pages/dashboard-lite.js" type="text/javascript"></script>
<!-- END PAGE LEVEL JS-->
</body>
</html>