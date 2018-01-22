<?php
require_once "client-db-operations.php";
session_start();
$companyName = ClientSideDB::getCompanyName($_SESSION['companyId']);
$companyLocations = ClientSideDB::getCompanyLocations($_SESSION['companyId']);
$designations = ClientSideDB::getEmployeeDesignations();
$shiftstatus = array('N'=>'New Shift','A'=>'Accepted','R'=>'Rejected','D'=>'Done');
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
    <title>Client View Edit Shift</title>
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
    <!--Vaishnavi CSS START-------------------------------->
    <link rel="stylesheet" type="text/css" href="../../assets/css/vaishnavi_style/vaishnavi-style.css"><!--for SLIDER-->
    <!--Start & End Calendar-->
    <link rel="stylesheet" type="text/css" href="../../assets/css/datetimepicker/bootstrap-datetimepicker.css">
    <!--/Start & End Calendar-->
    <!--Star Rating-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
    <link rel='stylesheet prefetch' href='http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css'>
    <link rel="stylesheet" href="../../assets/css/starrating/star-rating.css">
    <!--/Star Rating-->
    <!--Modal for CKEditor textarea-->
    <style>
        .modal {
        }

        .vertical-alignment-helper {
            display: table;
            height: 100%;
            width: 100%;
        }

        .vertical-align-center {
            /* To center vertically */
            display: table-cell;
            vertical-align: middle;
        }

        .modal-content {
            /* Bootstrap sets the size of the modal in the modal-dialog class, we need to inherit it */
            width: inherit;
            height: inherit;
            /* To center horizontally */
            margin: 0 auto;
        }
    </style>
    <!--/Modal for CKEditor textarea-->
    <!--Vaishnavi CSS END-------------------------------->
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
<!--                            <a href="#" class="dropdown-item"><i class="icon-head"></i> Edit Profile</a>-->
<!--                            <a href="#" class="dropdown-item"><i class="icon-mail6"></i> My Inbox</a>-->
<!--                            <a href="#" class="dropdown-item"><i class="icon-clipboard2"></i> Task</a>-->
<!--                            <a href="#" class="dropdown-item"><i class="icon-calendar5"></i> Calender</a>-->
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
                    <li>
                        <a href="client-create-shift.php" data-i18n="nav.page_layouts.1_column" class="menu-item">Create</a>
                    </li>
                    <li class="active">
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
                                <label id="companyName"><h1><?=$companyName ?></h1></label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/Company Name Row-->

            <!--Form 1 with Location Designation StartDate EndDate-->
            <form method="post" action="">
                <div class="row mt-2 col-md-12">
                    <div class="col-xl-6 col-lg-6 col-xs-12">
                        <div class="card-body">
                            <div class="media">
                                <div class="p-2 text-xs-center bg-light-green bg-darken-2 media-left media-middle">
                                    <i class="icon-android-locate font-large-2 white"></i>
                                </div>
                                <div class="form-group p-2 bg-light-green white media-body">
                                    <select class="form-control" id="sel1" name="companyLocation">
                                        <option value="">Select Location</option>
                                        <?php
                                        foreach ($companyLocations as $loc)
                                        { ?>
                                            <option
                                                <?php if(isset($_POST['companyLocation']) && $_POST['companyLocation'] == $loc->getCompanyLocationId()){echo 'selected';}?>
                                                    value="<?=$loc->getCompanyLocationId() ?>"><?=$loc->getAddress().', '.$loc->getCity().', '.$loc->getPostalCode() ?></option>
                                            <?php
                                        } ?>
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
                                    <select class="form-control" id="sel2" name="jobDesignation">
                                        <option value="">Select Job Designation</option>
                                        <?php
                                        foreach ($designations as $d => $dVal)
                                        { ?>
                                            <option
                                                    <?php if(isset($_POST['jobDesignation']) && $_POST['jobDesignation'] == $d){echo 'selected';}?>
                                                    value="<?=$d ?>"><?=$dVal ?></option>
                                            <?php
                                        } ?>
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
                <!--/Start & End Calender-->
                <div class="row mt-2 col-md-12">
                    <div class="row">
                        <div class="col-xl-12 col-lg-6 col-xs-12">
                            <div class="card-body">
                                <div class="media">
                                    <div class="col-xl-12 col-lg-6 col-xs-12"
                                         class="p-2 text-xs-center bg-accent-2 media-left media-middle">
                                        <input style='border-radius: 0 !important; '
                                               id="btnSubmit" name="btnSubmit" type="submit"
                                               class="btn btn-info btn-lg btn-block" value="Display Shifts">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <!--/Form 1 with Location Designation StartDate EndDate-->

            <!--Form 2 View Shift Details Table-->
            <form id="formShiftsEdit" method="post" action="">
            <?php
            if(isset($_POST['btnSubmit']))
                $shifts = ClientSideDB::getAllShifts($_SESSION['companyId'], $_POST['companyLocation'], $_POST['jobDesignation'], $_POST['selectedStartDate'], $_POST['selectedEndDate']);
            else
                $shifts = ClientSideDB::getAllShifts($_SESSION['companyId'], null, null, null, null);

            if(!empty($shifts)){
                ?>
                <div class="row mt-2 col-md-12">
                    <div class="col-xl-12 col-lg-12 col-xs-12">
                        <table class="table table-striped table-hover table-responsive">
                            <thead class="thead-inverse">
                                <tr>
                                    <th style="padding-right: 5.3em;">Date</th>
                                    <th style="padding-right: 7em;">Timing</th>
                                    <th style="padding-right: 13em;">Location</th>
                                    <th style="padding-right: 4em;">Status</th>
                                    <th style="padding-right: 8em;"></th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach ($shifts as $shift) {
                                ?>
                                <tr>
                                    <td><?=date('d M Y', strtotime($shift->getStartTime())) ?></td>
                                    <td><?=date('g:i A', strtotime($shift->getStartTime())).'-'.date('g:i A', strtotime($shift->getEndTime())) ?></td>
                                    <td><?=$shift->getShiftAddress().', '.$shift->getShiftCity().', '.$shift->getShiftPostalCode() ?></td>
                                    <td><?=$shiftstatus[$shift->getShiftStatus()] ?></td>
                                    <td>
                                        <button type="button" class="btn btn-sm" data-toggle="modal" title="Provide rating and comments for Shift"
                                                shift-id="<?=$shift->getShiftId() ?>"
                                                designation="<?=$shift->getEmpDesignationName() ?>"
                                                pay-per-hour="<?=$shift->getPayPerhour() ?>"
                                                emp-first-name="<?=$shift->getFirstname() ?>"
                                                emp-last-name="<?=$shift->getLastName() ?>"
                                                data-target="#myModal">
                                            <img src="../../assets/images/icons8-edit-50.png" width="30px">
                                        </button>
                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" title="Delete Shift"
                                            <?php if($shift->getShiftStatus() == 'D') echo "disabled";?>
                                                shift-id="<?=$shift->getShiftId() ?>"
                                                data-target="#deleteModal">
                                            <img src="../../assets/images/icons8-delete-50.png" width="30px">
                                        </button>

                                        <div class="modal fade" id="myModal" role="dialog">
                                            <div class="modal-dialog modal-lg">
                                                <!-- Modal content-->
                                                <div class="vertical-alignment-helper">
                                                    <div class="modal-dialog vertical-align-center">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close"
                                                                        data-dismiss="modal">
                                                                    &times;
                                                                </button>
                                                                <h4 class="modal-title">Edit</h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                <label><b>Designation:</b></label>&nbsp;<label id="designation"></label><br/>
                                                                <label><b>Payment Per Hour:</b></label>&nbsp;<label
                                                                        id="payPerHour"></label><br/>
                                                                <label><b>Employee Name:</b></label>&nbsp;<label id="empName"></label><br/>
                                                                <!-- Rating Stars Box -->
                                                                <label><b>Would you like to rate the
                                                                        employee?</b></label>
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
                                                                <!--/ Rating Stars Box -->
                                                                <label><b>Did the employee perform well? Please provide your review!</b></label>
                                                                <textarea class="ckeditor" id="row1_editor" cols="3" rows="1"></textarea>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                <button id="btnSaveModalData" name="btnSaveModalData" type="submit" class="btn btn-primary">Save Changes</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--/ Modal content-->
                                            </div>
                                        </div>
                                        <div class="modal fade" id="deleteModal" role="dialog">
                                            <div class="modal-dialog modal-lg">
                                                <!-- Modal content-->
                                                <div class="vertical-alignment-helper">
                                                    <div class="modal-dialog vertical-align-center">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close"
                                                                        data-dismiss="modal">
                                                                    &times;
                                                                </button>
                                                                <h4 class="modal-title">Are you sure you want to delete this shift?</h4>
                                                                <label id="shiftId"></label>
                                                            </div>
                                                            <div class="modal-body">
                                                                <button id="btnYesDelete" name="btnYesDelete" type="submit" class="btn btn-default">Yes</button>
                                                                <button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
                                                            </div>
                                                            <div class="modal-footer"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--/ Modal content-->
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php
            }
            else{
                ?>
                <div class="row mt-2 col-md-12">
                    <div class="col-xl-12 col-lg-12 col-xs-12">
                <h2>No Data.</h2>
                    </div>
                </div>
                <?php
            }
            ?>
            </form>
            <!--/Form 2 View Shift Details Table-->

            <?php
            if(isset($_POST['btnSaveModalData'])){
                ClientSideDB::updateClientRatingAndReviewForShift($_POST['shiftId'], $_POST['rating'], $_POST['ckEditorData']);
            }
            if(isset($_POST['btnYesDelete'])){
                ClientSideDB::deleteShift($_POST['shiftId']);
            }
            ?>
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

<!--Vaishnavi START-->
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

    //to display record specific data in modal
    var shiftId;
    $('#myModal').on('show.bs.modal', function (e) {
        // get information to update quickly to modal view as loading begins
        var opener=e.relatedTarget;//this holds the element who called the modal
        shiftId=$(opener).attr('shift-id');
        var designation=$(opener).attr('designation');
        var payPerHour=$(opener).attr('pay-per-hour');
        var empFirstName=$(opener).attr('emp-first-name');
        var empLastName=$(opener).attr('emp-last-name');

        $('#designation').text(designation);
        $('#payPerHour').text(payPerHour);
        $('#empName').text(empFirstName+' '+empLastName);
    });
    $('#myModal').on('hidden.bs.modal', function () {
        //Clearing Star Rating data
        $('#stars li').each(function (i) {
            $(this).removeClass('selected');
            rating = 0;
        });
        //Clearing CKEditor data
        CKEDITOR.instances['row1_editor'].setData('');
    });

    //for Star Ratings value
    var rating = 0;
    $('li').click(function () {
        rating = $(this).data('value');
    });

    $("#btnSaveModalData").on('click',function(){
        //var ckEditorData = CKEDITOR.instances['row1_editor'].getData();                       //getData() gets it with html tags as well
        var ckEditorData = CKEDITOR.instances['row1_editor'].document.getBody().getText();      //document.getBody().getText() gets it with only plain text
        alert("ckeditor data: "+ckEditorData+ " RATING: "+rating+" shiftId "+shiftId);

        $('#formShiftsEdit').append('<input type="hidden" name="ckEditorData" value='+ckEditorData+' />');
        $('#formShiftsEdit').append('<input type="hidden" name="rating" value='+rating+' />');
        $('#formShiftsEdit').append('<input type="hidden" name="shiftId" value='+shiftId+' />');

    });

    //for delete shift modal
    $('#deleteModal').on('show.bs.modal', function (e) {
        var opener=e.relatedTarget;
        shiftId=$(opener).attr('shift-id');
        $('#shiftId').text(shiftId);
    });
    $('#deleteModal').on('hidden.bs.modal', function () {
        shiftId = null;
    });
    $("#btnYesDelete").on('click',function(){
        $('#formShiftsEdit').append('<input type="hidden" name="shiftId" value='+shiftId+' />');
        alert('Shift deleted!');
    });
</script>
<!--/START & END CALENDAR JS-->
<!--Star Rating JS-->
<script src="../../assets/js/starrating/star-rating.js" type="text/javascript"></script>
<!--/Star Rating JS-->
<!--CKEditor JS-->
<script src="../../assets/ckeditor/ckeditor.js" type="text/javascript"></script>
<script>
    CKEDITOR.replace('row1_editor',{height:150});
</script>
<!--/CKEditor JS-->
<!--Vaishnavi END-->
</body>

</html>
