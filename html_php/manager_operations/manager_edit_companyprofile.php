<?php
include "../model/db_config.php";
session_start();
$error_name="";
if(isset($_POST['save_changes']) && $_POST['save_changes']){
    $name = $_POST['company_name'];
    $url = $_POST['company_url'];
    $id = $_POST['company_id'];
    $street_number = $_POST['street_number'];
    $street_name = $_POST['route'];
    $city = $_POST['locality'];
    $state = $_POST['administrative_area_level_1'];
    $postal_code = $_POST['postal_code'];
    $country = $_POST['country'];
    $insertcompanydataSQL = 'UPDATE companymaster SET CompanyName = :name,CompanyURL = :url, 
                             CompanyStreetNumber = :street_number, CompanyStreetName = :street_name,
                             CompanyCity = :city, CompanyState = :state, CompanyPostal = :postal_code,
                             CompanyCountry = :country
                             WHERE CompanyId = :id';
    $dbConnection = DB::getDBConnection();
    $pdpstm = $dbConnection->prepare($insertcompanydataSQL);
    $pdpstm->bindValue(':name',$name);
    $pdpstm->bindValue(':url',$url);
    $pdpstm->bindValue(':street_number',$street_number);
    $pdpstm->bindValue(':street_name',$street_name);
    $pdpstm->bindValue(':city',$city);
    $pdpstm->bindValue(':state',$state);
    $pdpstm->bindValue(':postal_code',$postal_code);
    $pdpstm->bindValue(':country',$country);
    $pdpstm->bindValue(':id',$id);
    $pdpstm->execute();
    $pdpstm->closeCursor();
    header("location:manager_create_employee.php");
}
/*
if(!isset($_SESSION['userName'])) {
    header("location:../login/login.php");
}*/
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
                            <span class="user-name"><?= $_SESSION['userName']; ?></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a href="#" class="dropdown-item"><i class="icon-head"></i> Edit Profile</a>
                            <a href="#" class="dropdown-item"><i class="icon-mail6"></i> My Inbox</a>
                            <a href="#" class="dropdown-item"><i class="icon-clipboard2"></i> Task</a>
                            <a href="#" class="dropdown-item"><i class="icon-calendar5"></i> Calender</a>
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
                    <li>
                        <a href="manager_create_employee.php" data-i18n="nav.page_layouts.2_columns" class="menu-item">Create Employee</a>
                    </li>
                    <li>
                        <a href="manager_manage_employee.php" data-i18n="nav.page_layouts.2_columns" class="menu-item">Manage Employee</a>
                    </li>
                    <li class="active">
                        <a href="manager_edit_companyprofile.php" data-i18n="nav.page_layouts.2_columns" class="menu-item">Edit Company's Profile</a>
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
            <div class="row">
                <div class="col-xl-8 col-lg-12">
                    <img src="../../assets/images/logo.png" alt="beontime_logo" width="639" height="165">
                </div>
            </div>
        </div>
        <div class="content-body">
            <form class="form" id="company_signup" method="post" action="">
                <h1>Basic Information</h1>
                <input type="hidden" value="<?php  echo $_SESSION['company_id']; ?>" name="company_id">
                <div class="form-group row">
                    <label for="company_name" class="col-sm-3 col-lg-1 label-control">Company Name: </label>
                    <div class="col-sm-9 col-lg-10">
                        <input class="form-control-sm col-sm-6" type="text" value="" id="company_name" name="company_name"><br/>
                        <div class="col-sm-10 nopadding">
                            <small class="help-block text-danger"><?php echo $error_name;?></small>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="company_url" class="col-sm-3 col-lg-1 label-control">Company website: </label>
                    <div class="col-sm-9 col-lg-10">
                        <input class="form-control-sm col-sm-6" type="text" value="" id="company_url" name="company_url">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="email" class="col-sm-3 col-lg-1 label-control">Email: </label>
                    <div class="col-sm-9 col-lg-10">
                        <input class="form-control-sm col-sm-6" type="text" value="<?php echo $_SESSION['userName'];?>" id="email" name="email">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-9 col-lg-9">
                        <input class="form-control-sm col-sm-8" type="text" onfocus="geolocate()" value="" id="street_address" name="street_address" placeholder="Enter your address">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="street_address" class="col-sm-3 col-lg-1 label-control">Street Address: </label>
                    <div class="col-sm-9 col-lg-10">
                        <input class="form-control-sm col-sm-1" type="text" value="" id="street_number" name="street_number" disabled>
                        <input class="form-control-sm col-sm-5" type="text" value="" id="route" name="route" disabled>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="locality" class="col-sm-3 col-lg-1 label-control">City</label>
                    <div class="col-sm-9 col-lg-10">
                        <input class="form-control-sm col-sm-6" type="text" value="" id="locality" name="locality" disabled>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="administrative_area_level_1" class="col-sm-3 col-lg-1 label-control">State: </label>
                    <div class="col-sm-9 col-lg-2">
                        <input class="form-control-sm col-sm-12" type="text" value="" id="administrative_area_level_1" name="administrative_area_level_1" disabled>
                    </div>
                    <label for="postal_code" class="col-sm-3 col-lg-1 label-control">ZipCode: </label>
                    <div class="col-sm-9 col-lg-2">
                        <input class="form-control-sm col-sm-13" type="text" value="" id="postal_code" name="postal_code" disabled>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="country" class="col-sm-3 col-lg-1 label-control">Country</label>
                    <div class="col-sm-9 col-lg-10">
                        <input class="form-control-sm col-sm-6" type="text" value="" id="country" name="country" disabled>
                    </div>
                </div>
                <div class="form-group row">
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
<script src="../../assets/js/dhruvin_js/address_autocomplete.js" type="text/javascript"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCFlizZVKgKqJxlylxGg74orpJaWC5Z_sU&libraries=places&callback=initAutocomplete"
        async defer></script>
<!-- END PAGE LEVEL JS-->
</body>
</html>