<?php
session_start();

if (!isset($_SESSION['userId'])) {
    header("location: ../index.html");
}
?>
<?php

/**
 * Created by PhpStorm.
 * User: Anubhav
 * Date: 12/14/2017
 * Time: 6:36 PM
 */


$city=$_SESSION['ddlcity'];
//$city = $_POST['ddlcity'];
//var_dump(($city));
include "../model/db_config.php";
$db=DB::getDBConnection();
$SQL = "SELECT  * FROM dummytable where City=:city";
$pdpstm = $db->prepare($SQL);
$pdpstm->bindValue(':city', $city);
$pdpstm->execute();
$pdpstm->setFetchMode(PDO::FETCH_OBJ);
//    var_dump($pdpstm);

$resultSet = $pdpstm->fetchAll();

foreach($resultSet as $result)
{
    $arr1[]=($result->{'Latitude'});
    $arr2[]=($result->{'Longitude'});
}

$lat1=$resultSet[0]->{'Latitude'};
$long1=$resultSet[0]->{'Longitude'};
$lat2=($resultSet[1]->{'Latitude'});
$long2=($resultSet[1]->{'Longitude'});



?>
<!--<!DOCTYPE html> is important. Removing this indication will cause padding display abnormal in some places.-->
<!DOCTYPE html>
<html lang="en" data-textdirection="ltr" class="loading">
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <style>
        #map {
            height: 300px;
            width: 1000px;
        }
    </style>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description"
          content="Robust admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords"
          content="admin template, robust admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="PIXINVENT">
    <title>Manager Track Employees</title>
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
    <link rel="stylesheet" type="text/css" href="../../assets/css/zhongjie_style/zhongjie_style.css">
    <!-- END Custom CSS-->
    <!--Start & End Calendar-->
    <link rel="stylesheet" type="text/css" href="../../assets/css/datetimepicker/bootstrap-datetimepicker.css">
    <!--/Start & End Calendar-->
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
                    <li class="active">
                        <a href="manager_track_employee.php" data-i18n="nav.page_layouts.2_columns" class="menu-item">Track Emp's Position</a>
                    </li>
                    <li>
                        <a href="manager_create_employee.php" data-i18n="nav.page_layouts.2_columns" class="menu-item">Create Employee</a>
                    </li>
                    <li>
                        <a href="manager_manage_employee.php" data-i18n="nav.page_layouts.2_columns" class="menu-item">Manage Employee</a>
                    </li>
                    <li>
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

<!-- main content-->
<div class="app-content content container-fluid">
    <div class="content-wrapper" style="width: 1000%";>

        <div class="content-header row"></div>


        <div class="content-body">
            <!--            below form is for searching shifts that are created by clients.-->
            <form method="post" action="">

                <div class="row mt-0 col-md-12">

                    <!--                company selection-->
                    <div class="col-xl-3 col-lg-3 col-xs-12">
                        <div class="card-body">
                            <div class="media">

                                <div id="map"></div>
                                <script>

                                    function initMap() {
                                        if(<?php echo $city; ?>='Toronto')
                                        {
                                            var uluru = {lat: 43.6532, lng: -79.3832};
                                            var map = new google.maps.Map(document.getElementById('map'), {
                                                zoom: 6,
                                                center: uluru
                                            });


                                            var latLng = new google.maps.LatLng(<?php echo $lat1?>,<?php echo $long1?>);
                                            var marker = new google.maps.Marker({
                                                position: latLng,
                                                map: map
                                            });
                                            var latLng1 = new google.maps.LatLng(<?php echo $lat2?>,<?php echo $long2?>);
                                            var marker = new google.maps.Marker({
                                                position: latLng1,
                                                map: map
                                            });



                                        }
                                        else
                                        {
                                            alert('<?php echo $city; ?>');
                                            var uluru = {lat: 45.5017, lng: -73.5673};
                                            var map = new google.maps.Map(document.getElementById('map'), {
                                                zoom: 12,
                                                center: uluru
                                            });







                                            var latLng = new google.maps.LatLng(<?php echo $lat1?>,<?php echo $long1?>);
                                            var marker = new google.maps.Marker({
                                                position: latLng,
                                                map: map
                                            });
                                            var latLng1 = new google.maps.LatLng(<?php echo $lat2?>,<?php echo $long2?>);
                                            var marker = new google.maps.Marker({
                                                position: latLng1,
                                                map: map
                                            });
                                        }




                                    }

                                </script>



                                <script async defer
                                        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBTd7zK0XohiaBH0OzHJ-sqpQl1XtRZpik&callback=initMap">
                                </script>

                            </div>
                        </div>
                    </div>

                    <!--                    company location selection-->


                    <!--                    start_date_time_picker control-->


                    <!--                    end_date_time_picker control-->

                </div>

                <!--                search shift button-->
                <div class="row mt-1 col-md-12">


                    <div class="col-xl-11 col-lg-11 col-xs-12">
                    </div>
                </div>

            </form>

            <!--            To make a space line-->
            <div class="row mt-1 col-md-12"></div>

            <!--            Display search result here-->
            <div id="shift_display" class="table-responsive">

            </div>

            <!--            button under the shift search result-->


            <!--            To make a space line-->
            <div class="row mt-1 col-md-12"></div>

        </div>
    </div>

    <!--   Form in modal. When clicking "Assign Employee" button, this modal will pop up -->
    <div class="modal fade" id="select_employee" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <!--                header of modal-->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Employee selection</h4>
                </div>

                <!--                body of modal-->
                <div class="modal-body">
                    <div class="container">

                        <form method="post" action="">
                            <div class="row mt-0 col-md-12">

                                <!--                                city selection-->
                                <div class="col-xl-6 col-lg-6 col-xs-12">
                                    <label for="city_select" class="font-weight-bold">City:</label>
                                          <select class="form-control" id="city_select">
                                        <option>Option_1</option>
                                        <option>Option_2</option>
                                        <option>Option_3</option>
                                        <option>Option_4</option>
                                          </select>
                                </div>

                                <!--                                date selection-->
                                <div class="col-xl-6 col-lg-6 col-xs-12">
                                    <label for="preferred_date" class="font-weight-bold">Preferred Date:</label><br/>
                                    <input type="checkbox" name="preferred_date" value="monday"> Monday
                                    <input type="checkbox" name="preferred_date" value="tuesday"> Tuesday
                                    <input type="checkbox" name="preferred_date" value="wednesday"> Wednesday
                                    <input type="checkbox" name="preferred_date" value="thursday"> Thursday<br/>
                                    <input type="checkbox" name="preferred_date" value="friday"> Friday
                                    <input type="checkbox" name="preferred_date" value="saturday"> Saturday
                                    <input type="checkbox" name="preferred_date" value="sunday"> Sunday
                                </div>
                            </div>

                            <!--                            first name and last name-->
                            <div class="row mt-1 col-md-12">
                                <div class="col-xl-6 col-lg-6 col-xs-12">
                                    <label for="first_name" class="font-weight-bold">First Name:</label>
                                    <input type="text" class="form-control" name="first_name" placeholder="First Name">
                                </div>

                                <div class="col-xl-6 col-lg-6 col-xs-12">
                                    <label for="last_name" class="font-weight-bold">Last Name:</label>
                                    <input type="text" class="form-control" name="last_name" placeholder="Last Name">
                                </div>
                            </div>

                            <!--                            search employee button-->
                            <div class="row mt-1 col-md-12">
                                <div class="col-xl-2 col-lg-2 col-xs-12" align="center">
                                    <button type="button" formmethod="post" class="btn btn-success font-weight-bold">Search Employee
                                    </button>
                                </div>
                            </div>

                        </form>

                        <!--            To make a space line-->
                        <div class="row mt-1 col-md-12"></div>

                        <!--            Display employee search result here-->
                        <div id="employee_display" class="table-responsive">

                            <?php
                            if (!empty($employee_display)) {
                                echo $employee_display;
                            }
                            ?>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <div class="col-xs-7"></div>
                    <div class="col-xs-3">
                        <button type="button" class="btn btn-block btn-success font-weight-bold">Assign</button>
                    </div>
                    <div class="col-xs-2">
                        <button type="button" class="btn btn-block btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>
<!-- / main content-->
<!-- ////////////////////////////////////////////////////////////////////////////-->


<footer class="footer footer-static footer-light navbar-border">
    <p class="clearfix text-muted text-sm-center mb-0 px-2"><span class="float-md-left d-xs-block d-md-inline-block">Copyright  &copy; 2017 <a
                href="#" target="_blank"
                class="text-bold-800 grey darken-2">BeOnTime Project Group </a>, All rights reserved. </span><span
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
<!-- END PAGE LEVEL JS-->
<!--START & END CALENDAR JS-->
<script src="../../assets/js/datetimepicker/moment.js" type="text/javascript"></script>
<script src="../../assets/js/datetimepicker/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
<script src="../../assets/js/datetimepicker/transition.js" type="text/javascript"></script>
<script src="../../assets/js/datetimepicker/collapse.js" type="text/javascript"></script>
<!--/START & END CALENDAR JS-->


<!---------------------------------------------------------->
<!--Anubhav, please copy below js files to your own folder-->
<!---------------------------------------------------------->
<!--Zhongjie JS-->
<script src="../../assets/js/zhongjie_js/date_time_picker.js" type="text/javascript"></script>
<script src="../../assets/js/zhongjie_js/manager_assign_shift_frontend.js" type="text/javascript"></script>
<!--/Zhongjie JS-->
</body>
</html>
