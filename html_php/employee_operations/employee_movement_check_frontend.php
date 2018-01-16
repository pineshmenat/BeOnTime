<?php
session_start();

if (!isset($_SESSION['userId'])) {
    header("location: ../index.html");
}
?>
<!--<!DOCTYPE html> is important. Removing this indication will cause padding display abnormal in some places.-->
<!DOCTYPE html>
<html lang="en" data-textdirection="ltr" class="loading">
<title>Movement Check</title>
<?php include("emp_header.php"); ?>

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
                    <span data-i18n="nav.page_layouts.main" class="menu-title">Employee</span>
                </a>
                <ul class="menu-content">
                    <li><a href="employee-dashboard.php" data-i18n="nav.dash.main" class="menu-item">Dashboard</a>
                    </li>
                    <li><a href="latest_shift.php" data-i18n="nav.dash.main" class="menu-item">Latest Shift</a>
                    </li>
                    <li><a href="pay_details.php" data-i18n="nav.dash.main" class="menu-item">Pay Details</a>
                    </li>
                    <li class="active"><a href="employee_movement_check_frontend.php" data-i18n="nav.dash.main" class="menu-item">Movement Check</a>
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
    <div class="content-wrapper pt-1">
        <div class="content-header row">
        </div>
        <div class="content-body">

            <!--                error display-->
            <div id="errorDisplayInBasePage" class="row mt-1 col-md-12"></div>

            <!--            4 buttons-->
            <div class="row mt-0 col-md-12">

                <!--                Check shift button-->
<!--                <div class="col-xl-2 col-lg-2 col-xs-4">-->
<!--                    <button type="button" id="btnCheckShift" class="btn btn-block btn-success font-weight-bold">-->
<!--                        Check Shift-->
<!--                    </button>-->
<!--                </div>-->

                <!--                Start to work button-->
<!--                <div class="col-xl-2 col-lg-2 col-xs-4">-->
<!--                    <button type="button" id="btnStartToWork" class="btn btn-block btn-success font-weight-bold" disabled>-->
<!--                        Start To Work-->
<!--                    </button>-->
<!--                </div>-->

                <!--                Take off work button-->
<!--                <div class="col-xl-2 col-lg-2 col-xs-4">-->
<!--                    <button type="button" id="btnTakeOff" class="btn btn-block btn-danger font-weight-bold" disabled>-->
<!--                        Take Off-->
<!--                    </button>-->
<!--                </div>-->

                <!--                Refresh My Position button-->
                <div class="col-xl-2 col-lg-2 col-xs-5">
                    <button type="button" id="btnRefreshMyPosition" class="btn btn-block btn-success font-weight-bold">
                        Refresh My Position
                    </button>
                </div>

                <!--                Empty column for placehold-->
                <div class="col-xl-8 col-lg-8"></div>

                <!--                Fake Location button-->
                <div class="col-xl-2 col-lg-2 col-xs-5">
                    <button type="button" id="btnFakeLocation" class="btn btn-block btn-warning font-weight-bold" disabled>
                        Feed Fake Location
                    </button>
                </div>


            </div>

            <!--            To make a space line-->
            <div class="row mt-1 col-md-12"></div>

            <!--                shift display-->
            <div id="shiftDisplay" class="table-responsive"></div>

            <!--            Display map here-->
            <div id="mapDisplay"></div>



        </div>
    </div>

    <!-- Modal for operation result display-->
    <div id="warningDisplay" class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title text-danger">Warning</h4>
                </div>
                <div id="warningInfo" class="modal-body"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">I know</button>
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
<!--<script src="../app-assets/js/scripts/pages/dashboard-lite.js" type="text/javascript"></script>-->
<!-- END PAGE LEVEL JS-->
<!--START & END CALENDAR JS-->
<script src="../../assets/js/datetimepicker/moment.js" type="text/javascript"></script>
<script src="../../assets/js/datetimepicker/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
<script src="../../assets/js/datetimepicker/transition.js" type="text/javascript"></script>
<script src="../../assets/js/datetimepicker/collapse.js" type="text/javascript"></script>
<!--/START & END CALENDAR JS-->

<!--Zhongjie JS-->
<script src="../../assets/js/zhongjie_js/employee_movement_check_frontend.js" type="text/javascript"></script>
<!--/Zhongjie JS-->
<!--START & END Google Maps-->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVwcDlI_b14uF5T0Nr9oOBgzP0LH6pvNg&callback=prepareMap" async
        defer></script>
<!--/START & END Google Maps-->
</body>
</html>
