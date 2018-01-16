<?php
session_start();
include 'employeeCalendar.php';

if(isset($_POST['status']) && isset($_POST['shift_id'])) {
    EmployeeCalendar::_updateShiftStatus($_POST['status'],$_POST['shift_id']); }
?>

<html lang="en" data-textdirection="ltr" class="loading">
<?php include("emp_header.php"); ?>
<!-- main menu-->
<div data-scroll-to-active="true" class="main-menu menu-fixed menu-dark menu-accordion menu-shadow">
    <!-- main menu header-->
    <div class="main-menu-header">

    </div>
    <!-- / main menu header-->
    <!-- main menu content-->
    <div class="main-menu-content">
        <ul id="main-menu-navigation" data-menu="menu-navigation" class="navigation navigation-main">
            <li class=" nav-item"><a href="#"><i class="icon-home3"></i><span data-i18n="nav.dash.main"
                                                                              class="menu-title">Employee</span></a>
                <ul class="menu-content">
                    <li class="active"><a href="employee-dashboard.php" data-i18n="nav.dash.main" class="menu-item">Dashboard</a>
                    </li>
                    <li><a href="latest_shift.php" data-i18n="nav.dash.main" class="menu-item">Latest Shift</a>
                    </li>
                    <li><a href="pay_details.php" data-i18n="nav.dash.main" class="menu-item">Pay Details</a>
                    </li>
                    <li><a href="employee_movement_check_frontend.php" data-i18n="nav.dash.main" class="menu-item">Movement Check</a>
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
<title>Employee Dashboard</title>
<div class="app-content content container-fluid">
    <div class="content-wrapper">
        <div class="content-header row"></div>
        <div class="content-body">
            <!--Company Name Row-->
            <div class="row">
                <div class="col-xl-12 col-lg-6 col-xs-12">
                    <div class="card-body">
                        <div class="media">
                            <div class="p-2 text-xs-center bg-cyan bg-darken-2 media-left media-middle">
                                <i class="icon-bank font-large-2 white"></i>
                            </div>
                            <div class="p-2 bg-cyan white media-body">
                                <label id="companyName"><h1><?php if(isset($_SESSION['companyId'])) echo EmployeeCalendar::getCompanyName($_SESSION['companyId']); else echo 'Unknown';?></h1></label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/Company Name Row-->

            <div class="row mt-2 col-md-12">
                    <?php $calendar = new EmployeeCalendar($_SESSION['userId']); echo $calendar->show();
                    //echo var_dump($calendar->_getShiftsOfCurrentMonth($_SESSION['userId']));
                    ?>
            </div>
        </div>
	</div>
</div>
<br/>

<?php include("emp_footer.php"); ?>

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



<!--<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>-->
<script src='http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js'></script><!--for SLIDER-->
<script src="../../assets/js/startendtimeslider/start-and-end-time-slider.js"></script><!--for SLIDER-->

<!--START & END CALENDAR JS-->
<script src="../../assets/js/datetimepicker/moment.js" type="text/javascript"></script>
<script src="../../assets/js/datetimepicker/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
<script src="../../assets/js/datetimepicker/transition.js" type="text/javascript"></script>
<script src="../../assets/js/datetimepicker/collapse.js" type="text/javascript"></script>
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
</html>
