<?php
session_start();
include 'employeeCalendar.php';
?>

<html lang="en" data-textdirection="ltr" class="loading">
<title>Pay Details</title>
<?php include("emp_header.php"); ?>

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
                            <div style="overflow: visible" class="media" >
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

                <!--/Start & End Calender-->
                <div class="row mt-2 col-md-12">
                    <div class="row">
                        <div class="col-xl-12 col-lg-6 col-xs-12">
                            <div class="card-body">
                                <div class="media">
                                    <!--<div class="col-xl-0 col-lg-6 col-xs-12"></div>-->
                                    <div class="col-xl-12 col-lg-6 col-xs-12" class="p-2 text-xs-center bg-accent-2 media-left media-middle">
                                        <input style='border-radius: 0 !important; '
                                               type="submit" class="btn btn-info btn-lg btn-block" value="Display Shifts">
                                    </div>
                                    <!--<div class="col-xl-0 col-lg-6 col-xs-12"></div>-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <!--/Form 1 with Location Designation StartDate EndDate-->

            <!--Form 2 View Shift Details Table-->
            <form method="get" action="">
                <div class="row mt-2 col-md-12">
                    <div class="col-xl-12 col-lg-12 col-xs-12">
                        <table class="table table-striped table-hover table-responsive">
                        <thead class="thead-inverse">
                            <tr>
                                <th></th>
                                <th style="padding-right: 5em;">Date</th>
                                <th style="padding-right: 9em;">Timing</th>
                                <th>Location</th>
                                <th>Designation</th>
                                <th>Status</th>
                                <th>Payment Per Hr</th>
                                <th>Employee Name</th>
                                <th style="padding-right: 6.5em;">Rating</th>
                                <th>Comment</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">
                                    <input type="checkbox">
                                </th>
                                <td>31 Oct 2016</td>
                                <td>10:00 AM - 10:00 PM</td>
                                <td>Sunny, Etobicoke</td>
                                <td>Asst Security</td>
                                <td>Confirmed</td>
                                <td>$13</td>
                                <td>Mr. X</td>
                                <td>
                                    <!-- Rating Stars Box -->
                                    <div class='rating-stars text-center'>
                                        <ul id='stars'>
                                            <li class='star' title='Poor' data-value='1'>
                                                <i class='fa fa-star fa-fw'></i>
                                            </li>
                                            <li class='star' title='Fair' data-value='2'>
                                                <i class='fa fa-star fa-fw'></i>
                                            </li>
                                            <li class='star' title='Good' data-value='3'>
                                                <i class='fa fa-star fa-fw'></i>
                                            </li>
                                            <li class='star' title='Excellent' data-value='4'>
                                                <i class='fa fa-star fa-fw'></i>
                                            </li>
                                            <li class='star' title='WOW!!!' data-value='5'>
                                                <i class='fa fa-star fa-fw'></i>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                                <td>
                                    <!--<textarea class="ckeditor" id="row1_editor" cols="50" rows="5"></textarea>-->
                                    <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Comment</button>
                                    <div class="modal fade" id="myModal" role="dialog">
                                        <div class="modal-dialog modal-lg">

                                            <!-- Modal content-->
                                            <div class="vertical-alignment-helper">
                                                <div class="modal-dialog vertical-align-center">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            <h4 class="modal-title">Comments</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <textarea class="ckeditor" id="row_editor" cols="3" rows="1"></textarea>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                            <button type="button" class="btn btn-primary">Save changes</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--/ Modal content-->
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">
                                    <input type="checkbox">
                                </th>
                                <td>30 Oct 2016</td>
                                <td>9:00 AM - 4:00 PM</td>
                                <td>Sunny, Etobicoke</td>
                                <td>Asst Security</td>
                                <td>Confirmed</td>
                                <td>$13</td>
                                <td>Mr. X</td>
                                <td>
                                    <!-- Rating Stars Box -->
                                    <div class='rating-stars text-center'>
                                        <ul id='stars'>
                                            <li class='star' title='Poor' data-value='1'>
                                                <i class='fa fa-star fa-fw'></i>
                                            </li>
                                            <li class='star' title='Fair' data-value='2'>
                                                <i class='fa fa-star fa-fw'></i>
                                            </li>
                                            <li class='star' title='Good' data-value='3'>
                                                <i class='fa fa-star fa-fw'></i>
                                            </li>
                                            <li class='star' title='Excellent' data-value='4'>
                                                <i class='fa fa-star fa-fw'></i>
                                            </li>
                                            <li class='star' title='WOW!!!' data-value='5'>
                                                <i class='fa fa-star fa-fw'></i>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                                <td>
                                    <!--<textarea class="ckeditor" id="row2_editor" cols="3" rows="1"></textarea>-->
                                    <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Comment</button>
                                    <div class="modal fade" id="myModal" role="dialog">
                                        <div class="modal-dialog modal-lg">

                                            <!-- Modal content-->
                                            <div class="vertical-alignment-helper">
                                                <div class="modal-dialog vertical-align-center">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            <h4 class="modal-title">Comments</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <textarea class="ckeditor" id="row2_editor" cols="3" rows="1"></textarea>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                            <button type="button" class="btn btn-primary">Save changes</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--/ Modal content-->
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                        </table>
                    </div>
                </div>
                <div class="row mt-2 col-md-12">
                    <div class="col-xl-6 col-lg-12 col-xs-12">
                        <input style='border-radius: 0 !important; '
                               type="submit" class="btn btn-info btn-lg btn-block" value="Modify">
                    </div>
                    <div class="col-xl-6 col-lg-12 col-xs-12">
                        <input style='border-radius: 0 !important; '
                               type="submit" class="btn btn-danger btn-lg btn-block" value="Delete">
                    </div>
                </div>
            </form>
            <!--/Form 2 View Shift Details Table-->
		</div>
	</div>
</div>
        <!--/ project charts -->
<!-- ////////////////////////////////////////////////////////////////////////////-->
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
