<?php
session_start();
require "../model/CompanyDB.php";
$errorDisplayMessage="";
$errorModify="";
if(!isset($_SESSION['userName'])) {
    header("location:../login/login.php");
}
else {
    $companyId = $_SESSION['companyId'];
    $ids = CompanyDB::getAllEmployeeID($companyId);
    $provinces = CompanyDB::getAllProvince($companyId);
    $cities = CompanyDB::getAllCities($companyId);
    if (isset($_POST['search']) && $_POST['search'] == "Search") {
        $employeeId = $_POST['employeeID'];
        $province = $_POST['province'];
        $city = $_POST['city'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        if ($employeeId != "0" || $province || "0" || $city != "0" || !empty($firstname) || !empty($lastname)) {
            $employeerecords = CompanyDB::getSelectedEmployee($companyId, $employeeId, $province, $city, $firstname, $lastname);
            /* foreach ($employeerecords as $employeerecord){
                 echo $employeerecord['UserId'];
             }*/
        } else {
            $errorDisplayMessage = "Alteast one field should be selected";
        }
    } elseif (isset($_POST['modify']) && $_POST['modify'] == "Modify") {
        if (isset($_POST['employeeId'])) {
            $empId = $_POST['employeeId'];
            header("Location: manager_modify_employee.php?employeeId=" . $empId);
        } else {
            $errorModify = "Please Select one record.";
            $employeeId = $_POST['employeeID'];
            $province = $_POST['province'];
            $city = $_POST['city'];
            $firstname = $_POST['firstname'];
            $lastname = $_POST['lastname'];
            if ($employeeId != "0" || $province || "0" || $city != "0" || !empty($firstname) || !empty($lastname)) {
                $employeerecords = CompanyDB::getSelectedEmployee($companyId, $employeeId, $province, $city, $firstname, $lastname);
            } else {
                $errorDisplayMessage = "Alteast one field should be selected";
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
    <link rel="stylesheet" type="text/css" href="../assets/css/zhongjie_style.css">
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
                    <li>
                        <a href="manager_create_employee.php" data-i18n="nav.page_layouts.2_columns" class="menu-item">Create Employee</a>
                    </li>
                    <li class="active">
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
        <div class="content-header row"></div>
            <div class="content-body">
                <form action="" method="post">
                    <div class="row mt-2 ml-2 col-md-12">
                        <div class="col-xl-2 col-lg-3 col-xs-12">
                            <div class="card-body">
                            <select class="form-control" name="employeeID">
                                <option value="0">Select ID</option>
                                <?php foreach ($ids as $id): ?>
                                <option value="<?php echo $id['UserId'] ?>" <?php if(isset($_POST['employeeID'])){echo $_POST['employeeID'] == $id['UserId'] ? ' selected="selected"' : '' ;} ?> ><?php echo $id['UserId']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        </div>
                        <div class="col-xl-2 col-lg-3 col-xs-12">
                            <select class="form-control" name="province">
                                <option value="0">Select Province</option>
                                <?php foreach ($provinces as $province): ?>
                                    <option value="<?php echo $province['Province'] ?>" <?php if(isset($_POST['province'])){echo $_POST['province'] == $province['Province'] ? ' selected="selected"' : '' ;} ?> ><?php echo $province['Province'];?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-xl-2 col-lg-3 col-xs-12">
                            <select class="form-control" name="city">
                                <option value="0">Select City</option>
                                <?php foreach ($cities as $city): ?>
                                    <option value="<?php echo $city['City'] ?>" <?php if(isset($_POST['city'])){echo $_POST['city'] == $city['City'] ? ' selected="selected"' : '' ;} ?> ><?php echo $city['City'];?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-xl-2 col-lg-3 col-xs-12">
                            <input class="form-control" name="firstname" id="firstname" placeholder="First Name" value="<?php if(isset($_POST['firstname'])){echo $_POST['firstname'];}?>"/>
                        </div>
                        <div class="col-xl-2 col-lg-3 col-xs-12">
                            <input class="form-control" name="lastname" id="lastname" placeholder="Last Name" value="<?php if(isset($_POST['lastname'])){echo $_POST['lastname'];}?>"/>
                        </div>
                    </div>
                    <div class="row mt-1 ml-3 col-md-12 help-block text-danger"><span><?php echo $errorDisplayMessage; ?></span></div>
                    <div class="row mt-1 col-md-12 ml-3">
                        <input class="btn btn-success btn-lg font-weight-bold" type="submit" name="search" id="search" value="Search"/>
                    </div>
                </form>
        </div>
    </div>
    <div class="row mt-1 col-md-12"></div>
    <?php if(isset($employeerecords) && empty($employeerecords)){ ?>
        <p class="row mt-1 ml-3 col-md-12 help-block text-danger"><span>No records found!</span></p>
    <?php }else if(isset($employeerecords) && !empty($employeerecords)){ ?>
    <div class="table-responsive">
        <form action="" method="post">
            <input type="hidden" name="employeeID" value="<?php echo $_POST['employeeID']; ?>">
            <input type="hidden" name="province" value="<?php echo $_POST['province']; ?>">
            <input type="hidden" name="city" value="<?php echo $_POST['city']; ?>">
            <input type="hidden" name="firstname" value="<?php echo $_POST['firstname']; ?>">
            <input type="hidden" name="lastname" value="<?php echo $_POST['lastname']; ?>">
        <table class="table table-condensed">
            <thead>
                <tr>
                    <th>Employee ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>City</th>
                    <th>Province</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($employeerecords as $employeerecord): ?>
                <tr>
                    <td><input type="radio" name="employeeId" value="<?php echo $employeerecord['UserId']?>" id="employeeId"><?php echo $employeerecord['UserId'] ?></td>
                    <td><?php echo $employeerecord['FirstName'] ?></td>
                    <td><?php echo $employeerecord['LastName'] ?></td>
                    <td><?php echo $employeerecord['City'] ?></td>
                    <td><?php echo $employeerecord['Province'] ?></td>
                    <td><?php echo "Status"; ?></td>
                </tr>
                <?php endforeach;?>
            </tbody>
        </table>
            <div class="row mt-1 ml-3 col-md-2 help-block text-danger"><span><?php echo $errorModify; ?></span></div>
            <div class="row mt-1 col-md-12">
                <div align="center" class="col-xl-2 col-lg-2 col-xs-12">
                    <input class="btn btn-success btn-lg font-weight-bold" value="Modify" id="modify" type="submit" name="modify"/>
                </div>
            </div>
        </form>
    </div>
    <?php } ?>
    <div class="row mt-1 col-md-12"></div>
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