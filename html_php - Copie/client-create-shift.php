<!---------------->
<!--By Vaishnavi-->
<!---------------->
<?php

include "./cookie_operations.php";
// If cookie expires, go to index.html
CookieOperations::checkCookieTimeout();
//CookieOperations::extendCookieTimeout();

session_start();

?>

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
    <title>Client Create Shift</title>
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
    <link rel="stylesheet" type="text/css" href="../app-assets/css/core/colors/palette-gradient.css">
    <!-- END Page Level CSS-->
    <!--Vaishnavi CSS START-->
    <link rel="stylesheet" type="text/css" href="../assets/css/vaishnavi_style/vaishnavi-style.css"><!--for SLIDER-->
    <!--Start & End Calendar-->
    <link rel="stylesheet" type="text/css" href="../assets/css/datetimepicker/bootstrap-datetimepicker.css">
    <!--/Start & End Calendar-->
    <!--Vaishnavi CSS END-->
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
                                                                                    src="../assets/images/logo_50.png"
                                                                                    data-expand="../assets/images/logo_50.png"
                                                                                    data-collapse="../assets/images/logo_xsmall.png"
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
                                <img src="../assets/images/portrait_img/<?= $_COOKIE['portraintImg']; ?>" alt="portraitImg"><i></i>
                            </span>
                            <span class="user-name"><?= $_COOKIE['userName']; ?></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a href="#" class="dropdown-item"><i class="icon-head"></i> Edit Profile</a>
                            <a href="#" class="dropdown-item"><i class="icon-mail6"></i> My Inbox</a>
                            <a href="#" class="dropdown-item"><i class="icon-clipboard2"></i> Task</a>
                            <a href="#" class="dropdown-item"><i class="icon-calendar5"></i> Calender</a>
                            <div class="dropdown-divider"></div>
                            <a href="logout.php" class="dropdown-item"><i class="icon-power3"></i> Logout</a>
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
    </div>
    <!-- / main menu header-->
    <!-- main menu content-->
    <div class="main-menu-content">
        <ul id="main-menu-navigation" data-menu="menu-navigation" class="navigation navigation-main">
            <li class=" nav-item">
                <a href="#"><i class="icon-home3"></i>
                    <!--                    <span data-i18n="nav.dash.main" class="menu-title">Shift</span>-->
                    <span data-i18n="nav.page_layouts.main" class="menu-title">Shift</span>
                </a>
                <ul class="menu-content">
                    <li class="active">
                        <a href="client-create-shift.php" data-i18n="nav.page_layouts.1_column" class="menu-item">Create</a>
                    </li>
                    <li>
                        <a href="client-view-edit-shift.php" data-i18n="nav.page_layouts.2_columns" class="menu-item">View</a>
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
            <!--/ project charts -->
            <!--Company Name Row-->
            <div class="row">
                <div class="col-xl-12 col-lg-6 col-xs-12">
                    <div class="card-body">
                        <div class="media">
                            <div class="p-2 text-xs-center bg-cyan bg-darken-2 media-left media-middle">
                                <i class="icon-bank font-large-2 white"></i>
                            </div>
                            <div class="p-2 bg-cyan white media-body">
                                <label id="companyName"><h1>Culinary Group</h1></label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/Company Name Row-->

            <!--Form 1 with Location Designation StartDate EndDate-->
            <form method="get" action="">
                <div class="row mt-2 col-md-12">
                    <div class="col-xl-6 col-lg-6 col-xs-12">
                        <div class="card-body">
                            <div class="media">
                                <div class="p-2 text-xs-center bg-light-green bg-darken-2 media-left media-middle">
                                    <i class="icon-android-locate font-large-2 white"></i>
                                </div>
                                <div class="form-group p-2 bg-light-green white media-body">
                                    <select class="form-control" id="sel1">
                                        <option>Select Location</option>
                                        <option>Niagara Falls</option>
                                        <option>Missisauga Ocean Hall</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-xs-12">
                        <div class="card-body">
                            <div class="media">
                                <div class="p-2 text-xs-center bg-amber bg-darken-2 media-left media-middle">
                                    <i class="icon-person font-large-2 white"></i>
                                </div>
                                <div class="form-group p-2 bg-amber white media-body">
                                    <select class="form-control" id="sel1">
                                        <option>Select Job Designation</option>
                                        <option>Security Assistant</option>
                                        <option>Security Senior</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--Start & End Calender-->

                <div class="row mt-2 col-md-12">
                    <div class="col-xl-6 col-lg-6 col-xs-12">
                        <div class="card-body">
                            <div style="overflow: visible" class="media">
                                <div class="p-2 text-xs-center bg-grey bg-darken-2 media-left media-middle">
                                    <i class="icon-android-calendar font-large-2 white"></i>
                                </div>
                                <div style="overflow: visible" class="p-2 bg-grey white media-body">
                                    <!--<input type="date" id="startDate" name="startDate">-->
                                    <div class="form-group">
                                        <div class='input-group date' id='datetimepicker6'>
                                            <input type='text' class="form-control"/>
                                            <span class="input-group-addon">
                                                <!--<span class="glyphicon glyphicon-calendar"></span>-->
                                                <i class="icon-android-calendar font-size-large black"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-xs-12">
                        <div class="card-body">
                            <div style="overflow: visible" class="media">
                                <div class="p-2 text-xs-center bg-grey bg-darken-2 media-left media-middle">
                                    <i class="icon-android-calendar font-large-2 white"></i>
                                </div>
                                <div style="overflow: visible" class="p-2 bg-grey white media-body">
                                    <!--<input type="date" id="endDate" name="endDate">-->
                                    <div class="form-group">
                                        <div class='input-group date' id='datetimepicker7'>
                                            <input type='text' class="form-control"/>
                                            <span class="input-group-addon">
                                                <!--<span class="glyphicon glyphicon-calendar"></span>-->
                                                <i class="icon-android-calendar font-size-large black"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!--<div class="row mt-2 col-md-12">
                    <div class="col-xl-6 col-lg-6 col-xs-12">
                        <div class="card-body">
                            <div class="media">
                                <div class="p-2 text-xs-center bg-grey bg-darken-2 media-left media-middle">
                                    <i class="icon-android-calendar font-large-2 white"></i>
                                </div>
                                <div class="p-2 bg-grey white media-body">
                                    <input type="date" id="startDate" name="startDate">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-xs-12">
                        <div class="card-body">
                            <div class="media">
                                <div class="p-2 text-xs-center bg-grey bg-darken-2 media-left media-middle">
                                    <i class="icon-android-calendar font-large-2 white"></i>
                                </div>
                                <div class="p-2 bg-grey white media-body">
                                    <input type="date" id="endDate" name="endDate">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>-->
                <!--/Start & End Calender-->
                <div class="row mt-2 col-md-12">
                    <div class="row">
                        <div class="col-xl-12 col-lg-6 col-xs-12">
                            <div class="card-body">
                                <div class="media">
                                    <!--<div class="col-xl-0 col-lg-6 col-xs-12"></div>-->
                                    <div class="col-xl-12 col-lg-6 col-xs-12"
                                         class="p-2 text-xs-center bg-accent-2 media-left media-middle">
                                        <input style='border-radius: 0 !important; '
                                               type="submit" class="btn btn-info btn-lg btn-block" value="Display Calendar">
                                    </div>
                                    <!--<div class="col-xl-0 col-lg-6 col-xs-12"></div>-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <!--/Form 1 with Location Designation StartDate EndDate-->

            <!--Form 2 for Calender Time Slider-->
            <div class="row mt-2 col-md-12">
                <div class="row">
                    <div class="col-xl-1 col-lg-1" style="">
                        <h5>Oct 19</h5>
                    </div>
                    <div class="col-xl-9 col-lg-11">
                        <div class="time-range">
                            <!--<p>Time Range: <span class="slider-time">9:00 AM</span> - <span class="slider-time2">5:00 PM</span></p>-->
                            <div class="sliders_step1">
                                <div class="slider-range"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-1" style="">
                        <h5><span class="slider-time">9:00 AM</span> - <span class="slider-time2">5:00 PM</span></h5>
                    </div>
                </div>
                <div class="row mt-1">
                    <div class="col-xl-1 col-lg-1" style="">
                        <h5>Oct 21</h5>
                    </div>
                    <div class="col-xl-9 col-lg-11">
                        <div class="time-range">
                            <!--<p>Time Range: <span class="slider-time">9:00 AM</span> - <span class="slider-time2">5:00 PM</span></p>-->
                            <div class="sliders_step1">
                                <div class="slider-range"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-1" style="">
                        <h5><span class="slider-time">9:00 AM</span> - <span class="slider-time2">5:00 PM</span></h5>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-xl-12 col-lg-6 col-xs-12">
                        <div class="card-body">
                            <div class="media">
                                <div class="col-xl-2 col-lg-6 col-xs-12"></div>
                                <div class="col-xl-8 col-lg-6 col-xs-12"
                                     class="p-2 text-xs-center bg-accent-2 media-left media-middle">
                                    <input style='border-radius: 0 !important;'
                                           type="submit" class="btn btn-success btn-lg btn-block" value="Submit">
                                </div>
                                <div class="col-xl-2 col-lg-6 col-xs-12"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/Form 2 for Calender Time Slider-->
        </div>
    </div>
</div>
<!--/ project charts -->
<!-- ////////////////////////////////////////////////////////////////////////////-->
<br/>

<footer class="footer footer-static footer-light navbar-border">
    <p class="clearfix text-muted text-sm-center mb-0 px-2"><span class="float-md-left d-xs-block d-md-inline-block">Copyright  &copy; 2017 <a
                    href="#" target="_blank"
                    class="text-bold-800 grey darken-2">BeOnTime Project Group </a>, All rights reserved. </span><span
                class="float-md-right d-xs-block d-md-inline-block">We made with <i class="icon-heart5 pink"></i></span></p>
</footer>

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
<script src="../app-assets/vendors/js/charts/chart.min.js" type="text/javascript"></script>
<!-- END PAGE VENDOR JS-->
<!-- BEGIN ROBUST JS-->
<script src="../app-assets/js/core/app-menu.js" type="text/javascript"></script>
<script src="../app-assets/js/core/app.js" type="text/javascript"></script>
<!-- END ROBUST JS-->
<!-- BEGIN PAGE LEVEL JS-->
<!-- END PAGE LEVEL JS-->


<!--Vaishnavi START-->
<!--<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>-->
<script src='http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js'></script><!--for SLIDER-->
<script src="../assets/js/startendtimeslider/start-and-end-time-slider.js"></script><!--for SLIDER-->

<!--START & END CALENDAR JS-->
<script src="../assets/js/datetimepicker/moment.js" type="text/javascript"></script>
<script src="../assets/js/datetimepicker/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
<script src="../assets/js/datetimepicker/transition.js" type="text/javascript"></script>
<script src="../assets/js/datetimepicker/collapse.js" type="text/javascript"></script>
<script type="text/javascript">
    $(function () {
        $('#datetimepicker6').datetimepicker({
            // display date only, no time. remove below line will show time picker
            format: 'MMM DD, YYYY'
        });
        $('#datetimepicker7').datetimepicker({
            // display date only, no time. remove below line will show time picker
            format: 'MMM DD, YYYY',
            useCurrent: false //Important! See issue #1075
        });
        $("#datetimepicker6").on("dp.change", function (e) {
            $('#datetimepicker7').data("DateTimePicker").minDate(e.date);
        });
        $("#datetimepicker7").on("dp.change", function (e) {
            $('#datetimepicker6').data("DateTimePicker").maxDate(e.date);
        });
    });
</script>
<!--/START & END CALENDAR JS-->

<!--Vaishnavi END-->
</body>

</html>
