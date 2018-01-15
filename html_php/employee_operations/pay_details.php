<?php
session_start();
include_once 'employeeCalendar.php';
include_once 'ShiftOperations.php';
?>


<script
        src="https://code.jquery.com/jquery-3.2.1.min.js"
        integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
        crossorigin="anonymous">
</script>

<script>
    var shiftPayDetails;
    var settings = {
        "async": true,
        "crossDomain": true,
        "url": "http://localhost/BOT/html_php/employee_operations/ShiftOperations.php",
        "method": "POST",
        "headers": {
            "content-type": "application/x-www-form-urlencoded",
            "cache-control": "no-cache",
            "postman-token": "3f0afa24-0ff4-63fc-ed48-7bb348022540"
        },
        "data": {
            "operation": "getTodaysPayDetails",
            "userId": "<?php echo $_SESSION['userId'];?>"
        }
    }

    $.ajax(settings).done(function (response) {
        //console.log(response);
        shiftPayDetails= JSON.parse(response);
    });

</script>

<html lang="en" data-textdirection="ltr" class="loading">
<title>Pay Details</title>

<?php include("emp_header.php"); ?>

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
                                <label id="companyName"><h1><?php if(isset($_SESSION['companyId'])) echo EmployeeCalendar::getCompanyName($_SESSION['companyId']); else echo 'Unknown';?></h1></label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/Company Name Row-->
            </br>

            <form method="post" action="">
                <div class="row mt-2 col-md-12">
                    <div class="col-xl-12 col-lg-12 col-xs-12">
                        <script>
                            var shifts_table = "<table class='table table-striped table-hover table-responsive'>" +
                                "<thead class='thead-inverse'>" +
                                "<tr>" +
                                "<th>ShiftId</th>" +
                                "<th>Company</th>" +
                                "<th>StartTime</th>" +
                                "<th>EndTime</th>" +
                                "<th>ActualWorkingStartTime</th>" +
                                "<th>ActualWorkingEndTime</th>" +
                                "<th>SpecialNote</th>" +
                                "<th>ShiftPay</th>" +
                                "</tr>" +
                                "</thead>" +
                                "<tbody>";
                            if(shiftPayDetails != null){
                                for(var i=0; i<shiftPayDetails.length; i++){

                                    shifts_table += "<tr>" +
                                        "<td>" + shiftPayDetails[i].ShiftId + "</td>" +
                                        "<td>" + shiftPayDetails[i].CompanyName + "</td>" +
                                        "<td>" + shiftPayDetails[i].StartTime + "</td>" +
                                        "<td>" + shiftPayDetails[i].EndTime + "</td>" +
                                        "<td>" + shiftPayDetails[i].ActualWorkingStartTime+ "</td>" +
                                        "<td>" + shiftPayDetails[i].ActualWorkingEndTime + "</td>" +
                                        "<td style='word-wrap: break-word;min-width: 160px;max-width: 160px;'>" + shiftPayDetails[i].SpecialNote + "</td>" +
                                        "<td>" + shiftPayDetails[i].shiftPay + "</td>" +
                                        "</tr>";
                                }
                            }

                            shifts_table += "</tbody></table>";

                            document.write(shifts_table);

                        </script>
                    </div>
                </div>
            </form>
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
<!--/START & END CALENDAR JS-->
</html>
