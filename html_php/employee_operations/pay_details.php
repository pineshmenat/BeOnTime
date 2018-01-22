<?php
session_start();
include_once 'employeeCalendar.php';
include_once 'ShiftOperations.php';
?>



<html lang="en" data-textdirection="ltr" class="loading">
<title>Pay Details</title>
<link rel="stylesheet" type="text/css" href="../../assets/css/datetimepicker/bootstrap-datetimepicker.css">
<?php include("emp_header.php"); ?>


<!-- main menu-->

<script
        src="https://code.jquery.com/jquery-3.2.1.min.js"
        integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
        crossorigin="anonymous">
</script>

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
                    <li><a href="employee-dashboard.php" data-i18n="nav.dash.main" class="menu-item">Dashboard</a>
                    </li>
                    <li><a href="latest_shift.php" data-i18n="nav.dash.main" class="menu-item">Latest Shift</a>
                    </li>
                    <li class="active"><a href="pay_details.php" data-i18n="nav.dash.main" class="menu-item">Pay Details</a>
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

<div class="app-content content container-fluid">
    <div class="content-wrapper">
        <div class="content-header row">

        </div>
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
                                <label id="companyName"><h1><?php if(isset($_SESSION['companyId'])) echo EmployeeCalendar::getCompanyName($_SESSION['companyId']); else echo 'Unknown';?></h1></label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/Company Name Row-->
            <div class="row mt-2 col-md-12">
                <div class="col-xl-6 col-lg-6 col-xs-12">
                    <div class="card-body">
                        <div style="overflow: visible" class="media">
                            <div class="p-2 text-xs-center bg-grey bg-darken-2 media-left media-middle">
                                <i class="icon-android-calendar font-large-2 white"></i>
                            </div>
                            <div style="overflow: visible" class="p-2 bg-grey white media-body">
                                <div class="form-group">
                                    <div class='input-group date' id='datetimepicker6'>
                                        <input type='text' id="selectedStartDate" name="selectedStartDate"
                                               value="<?php if(isset($_POST['selectedStartDate'])){echo $_POST['selectedStartDate'];}?>"
                                               class="form-control"/>
                                        <span class="input-group-addon">
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
                                <div class="form-group">
                                    <div class='input-group date' id='datetimepicker7'>
                                        <input type='text' id="selectedEndDate" name="selectedEndDate"
                                               value="<?php if(isset($_POST['selectedEndDate'])){echo $_POST['selectedEndDate'];}?>"
                                               class="form-control"/>
                                        <span class="input-group-addon">
                                                <i class="icon-android-calendar font-size-large black"></i>
                                            </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                <div class="row mt-2 col-md-12">
                    <div class="row">
                        <div class="col-xl-12 col-lg-6 col-xs-12">
                            <div class="card-body">
                                <div class="media">
                                    <div class="col-xl-12 col-lg-6 col-xs-12"
                                         class="p-2 text-xs-center bg-accent-2 media-left media-middle">

                                        <input style='border-radius: 0 !important;' id="btnSubmit" type="submit" class="btn btn-info btn-lg btn-block" value="Display Paydetails"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </br>

                <div class="row mt-2 col-md-12">
                    <div class="col-xl-12 col-lg-12 col-xs-12">
                        <table id="table" class='table table-striped table-hover table-responsive'>
                            <thead class='thead-inverse'>
                            <tr>
                                <th>Shift Id</th>
                                <th>Company</th>
                                <th>StartTime</th>
                                <th>EndTime</th>
                                <th>Actual Working StartTime</th>
                                <th>Actual Working EndTime</th>
                                <th>Client Review</th>
                                <th>Special Note</th>
                                <th>Shift Pay</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>

                        <script>
                            var shiftPayDetails = null;
                            $('#btnSubmit').on('click', function(event) {
                                event.preventDefault(); // To prevent following the link (optional)
                                console.log(document.getElementById("selectedStartDate").value);
                                var settings = {
                                    "async": true,
                                    "crossDomain": true,
				    "url": "http://beontime.byethost16.com/beontime/html_php/employee_operations/ShiftOperations.php",
                                    "method": "POST",
                                    "headers": {
                                        "content-type": "application/x-www-form-urlencoded",
                                        "cache-control": "no-cache",
                                        "postman-token": "3f0afa24-0ff4-63fc-ed48-7bb348022540"
                                    },
                                    "data": {
                                        "operation": "getTodaysPayDetails",
                                        "userId": "<?php echo $_SESSION['userId'];?>",
                                        "startDate":document.getElementById("selectedStartDate").value,
                                        "endDate":document.getElementById("selectedEndDate").value
                                    }
                                }

                                $.ajax(settings).done(function (response) {
                                    console.log(response);
                                    shiftPayDetails= JSON.parse(response);
                                    var shifts_table = "";
                                    if(shiftPayDetails != null){
                                        for(var i=0; i<shiftPayDetails.length; i++){

                                            shifts_table += "<tr>" +
                                                "<td>" + shiftPayDetails[i].ShiftId + "</td>" +
                                                "<td>" + shiftPayDetails[i].CompanyName + "</td>" +
                                                "<td>" + shiftPayDetails[i].StartTime + "</td>" +
                                                "<td>" + shiftPayDetails[i].EndTime + "</td>" +
                                                "<td>" + shiftPayDetails[i].ActualWorkingStartTime+ "</td>" +
                                                "<td>" + shiftPayDetails[i].ActualWorkingEndTime + "</td>" +
                                                "<td style='word-wrap: break-word;min-width: 160px;max-width: 160px;'>" + shiftPayDetails[i].ClientReview + "</td>" +
                                                "<td style='word-wrap: break-word;min-width: 160px;max-width: 160px;'>" + shiftPayDetails[i].SpecialNote+ "</td>" +
                                                "<td>" + shiftPayDetails[i].shiftPay + "</td>" +
                                                "</tr>";
                                        }
                                    }
                                    shifts_table += "</tbody>";
                                    $('#table').append(shifts_table);

                                });
                            });
                        </script>
        </div>
    </div>
</div>

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

<script type="text/javascript">

</script>
<!--/START & END CALENDAR JS-->
</html>
