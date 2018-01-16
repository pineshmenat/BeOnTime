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
var shiftDetails;

    var settings = {
        "async": true,
        "crossDomain": true,
        "url": "http://beontime.byethost16.com/beontime/html_php/employee_operations/ShiftOperations.php",
        "method": "POST",
        "headers": {
            "content-type": "application/x-www-form-urlencoded",
            "cache-control": "no-cache",
            "postman-token": "4777d1b7-284d-ab92-56a7-374ada391524"
        },
        "data": {
            "operation": "getTodayShiftDetailsPhp",
            "userId": "<?php echo $_SESSION['userId'];?>"
        }
    };

    $.ajax(settings).done(function (response) {
        //console.log(response);
        shiftDetails = JSON.parse(response);
    });

</script>

<html lang="en" data-textdirection="ltr" class="loading">
<title>Latest Shift</title>
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
                    <li><a href="employee-dashboard.php" data-i18n="nav.dash.main" class="menu-item">Dashboard</a>
                    </li>
                    <li class="active"><a href="latest_shift.php" data-i18n="nav.dash.main" class="menu-item">Latest
                            Shift</a>
                    </li>
                    <li><a href="pay_details.php" data-i18n="nav.dash.main" class="menu-item">Pay Details</a>
                    </li>
                    <li><a href="employee_movement_check_frontend.php" data-i18n="nav.dash.main" class="menu-item">Movement
                            Check</a>
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
                                <label id="companyName">
                                    <h1><?php if (isset($_SESSION['companyId'])) echo EmployeeCalendar::getCompanyName($_SESSION['companyId']); else echo 'Unknown'; ?></h1>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/Company Name Row-->
            </br>

            <div id="map"></div>

            <script>
                var map, infoWindow, myCoordinates,currentLat, currentLong;

                function initMap() {
                    var mapCanvas = document.getElementById("map");
                    var mapOptions = { zoom: 17, mapTypeControl: false, fullscreenControl: false };

                    map = new google.maps.Map(mapCanvas,mapOptions);
                    setZoomAtCurrentLocation();
                    if(shiftDetails != null){
                        plotShiftLocations();
                    }
                }

                function plotShiftLocations() {
                    for (var i = 0; i < shiftDetails.length; i++) {
                        var marker1 = new google.maps.Marker({
                            position: {
                                lat: parseFloat(shiftDetails[i].Latitude),
                                lng: parseFloat(shiftDetails[i].Longitude)
                            },
                            map: map,
                            title: 'ShiftId:'+ shiftDetails[i].ShiftId +'. CompanyName: '+shiftDetails[i].CompanyName
                        });
                    }

                }

                function setZoomAtCurrentLocation() {
                    if (navigator.geolocation) {
                        navigator.geolocation.getCurrentPosition(function(position) {
                            currentLat = position.coords.latitude;
                            currentLng = position.coords.longitude;
                            myCoordinates = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);

                            var youAreHereMarker = new google.maps.Marker({
                                position: myCoordinates,
                                map: map,
                                animation: google.maps.Animation.BOUNCE,
                                title: "You are here!"
                            });
                            dataContent = "<p>You are here!</p>";
                            var infowindow = new google.maps.InfoWindow({
                                content: dataContent
                            });
                            map.setCenter(myCoordinates);
                        });
                    } else {
                    }
                    //handleLocationError(false, infoWindow, map.getCenter());
                }

                function handleLocationError(browserHasGeolocation, infoWindow, pos) {
                    infoWindow.setPosition(pos);
                    infoWindow.setContent(browserHasGeolocation ?
                        'Error: The Geolocation service failed.' :
                        'Error: Your browser doesn\'svgfiles support geolocation.');
                    infoWindow.open(map);
                }

                function loginClick(rowId) {
                    if (shiftDetails != null) {
                        //console.log(rowId);
                        //console.log("Inside loginClick: " + shiftDetails[rowId - 1].ShiftId);
                        workplace = new google.maps.LatLng(parseFloat(shiftDetails[rowId].Latitude), parseFloat(shiftDetails[rowId].Longitude));
                        var distanceInMetres = google.maps.geometry.spherical.computeDistanceBetween(myCoordinates, workplace);
                        if (distanceInMetres < 300) {
                            if(shiftDetails[rowId].ActualWorkingStartTime == null) {
                                var settings = {
                                    "async": true,
                                    "crossDomain": true,
                                    "url": "http://beontime.byethost16.com/beontime/html_php/employee_operations/ShiftOperations.php",
                                    "method": "POST",
                                    "headers": {
                                        "content-type": "application/x-www-form-urlencoded",
                                        "cache-control": "no-cache",
                                        "postman-token": "e84e9a9e-2427-6d51-fbae-36d4c9ab9bef"
                                    },
                                    "data": {
                                        "operation": "ShiftLoginUpdate",
                                        "LoginLat": currentLat,
                                        "LoginLng": currentLng,
                                        "shiftId": shiftDetails[rowId].ShiftId
                                    }
                                }

                                $.ajax(settings).done(function (response) {
                                    alert("Shift Started!!");
                                    document.getElementById(shiftDetails[rowId].ShiftId).disabled = true;
                                });
                            } else {
                                alert("Shift is already started!!");
                            }
                        } else {
                            alert("You're not in the range of your workplace!!");
                        }
                    }
                }

                function logoutClick(rowId) {
                    if (shiftDetails != null) {
                        workplace = new google.maps.LatLng(parseFloat(shiftDetails[rowId].Latitude), parseFloat(shiftDetails[rowId].Longitude));
                        var distanceInMetres = google.maps.geometry.spherical.computeDistanceBetween(myCoordinates, workplace);
                        if (distanceInMetres < 300) {
                            if(shiftDetails[rowId].ActualWorkingEndTime == null) {
                                var settings = {
                                    "async": true,
                                    "crossDomain": true,
                                    "url": "http://beontime.byethost16.com/beontime/html_php/employee_operations/ShiftOperations.php",
                                    "method": "POST",
                                    "headers": {
                                        "content-type": "application/x-www-form-urlencoded",
                                        "cache-control": "no-cache",
                                        "postman-token": "00764e16-14d4-e620-2cb3-1dd56a5127ca"
                                    },
                                    "data": {
                                        "operation": "ShiftLogoutUpdate",
                                        "LogoutLat": currentLat,
                                        "LogoutLng": currentLng,
                                        "shiftId": shiftDetails[rowId].ShiftId
                                    }
                                }

                                $.ajax(settings).done(function (response) {
                                    alert("Shift Ended!!");
                                    document.getElementById(shiftDetails[rowId].ShiftId + 'l').disabled = true;
                                });
                            } else {
                                alert("Shift is already Ended!!");
                            }
                        } else {
                            alert("You're not in the range of your workplace!!");
                        }
                    }
                }
            </script>


            <form method="post" action="">
                <div class="row mt-2 col-md-12">
                    <div class="col-xl-12 col-lg-12 col-xs-12">
                        <script>
                                var shifts_table = "";
                                if (shiftDetails != '') {
                                    shifts_table = "<table class='table table-striped table-hover table-responsive'>" +
                                        "<thead class='thead-inverse'>" +
                                        "<tr>" +
                                        "<th>ShiftId</th>" +
                                        "<th>Company</th>" +
                                        "<th>StartTime</th>" +
                                        "<th>EndTime</th>" +
                                        "<th>ActualWorkingStartTime</th>" +
                                        "<th>ActualWorkingEndTime</th>" +
                                        "<th>SpecialNote</th>" +
                                        "<th>Login</th>" +
                                        "<th>LogOut</th>" +
                                        "</tr>" +
                                        "</thead>" +
                                        "<tbody>";

                                    $.each(shiftDetails, function (index, shift) {
                                        console.log(shift);
                                        if(shift.ActualWorkingStartTime != null) {
                                            shifts_table += "<tr>" +
                                                "<td>" + shift.ShiftId + "</td>" +
                                                "<td>" + shift.CompanyName + "</td>" +
                                                "<td>" + shift.StartTime + "</td>" +
                                                "<td>" + shift.EndTime + "</td>" +
                                                "<td>" + shift.ActualWorkingStartTime + "</td>" +
                                                "<td>" + shift.ActualWorkingEndTime + "</td>" +
                                                "<td style='word-wrap: break-word;min-width: 160px;max-width: 160px;'>" + shift.SpecialNote + "</td>" +
                                                "<td>" +
                                                "<input type='hidden' name='WorkplaceLat' id='" + shift.ShiftId + "Lat' value='" + shift.Latitude + "'/>" +
                                                "<input type='hidden' name='WorkplaceLong' id='" + shift.ShiftId + "Long' value='" + shift.Longitude + "'/>" +
                                                "<input type='button' class='btn btn-info' name='Login' value='Login' id='"+shift.ShiftId+"' onclick='loginClick("+index+")' disabled/></td>" +
                                                "<td><input type='button' class='btn btn-info' name='Logout' value='Logout' id='"+shift.ShiftId+"l' onclick='logoutClick("+index+")'/></td>" +
                                                "</tr>";
                                        } else {
                                            shifts_table += "<tr>" +
                                                "<td>" + shift.ShiftId + "</td>" +
                                                "<td>" + shift.CompanyName + "</td>" +
                                                "<td>" + shift.StartTime + "</td>" +
                                                "<td>" + shift.EndTime + "</td>" +
                                                "<td>" + shift.ActualWorkingStartTime + "</td>" +
                                                "<td>" + shift.ActualWorkingEndTime + "</td>" +
                                                "<td style='word-wrap: break-word;min-width: 160px;max-width: 160px;'>" + shift.SpecialNote + "</td>" +
                                                "<td>" +
                                                "<input type='hidden' name='WorkplaceLat' id='" + shift.ShiftId + "Lat' value='" + shift.Latitude + "'/>" +
                                                "<input type='hidden' name='WorkplaceLong' id='" + shift.ShiftId + "Long' value='" + shift.Longitude + "'/>" +
                                                "<input type='button' class='btn btn-info' name='Login' value='Login' id='"+shift.ShiftId+"' onclick='loginClick("+index+")'/></td>" +
                                                "<td><input type='button' class='btn btn-info' name='Logout' value='Logout' id='"+shift.ShiftId+"l' onclick='logoutClick("+index+")'/></td>" +
                                                "</tr>";
                                        }
                                    });
                                    shifts_table += "</tbody></table>";
                                } else {
                                    shifts_table += "<h2>You're on leave Today :)</h2>";
                                }
                                document.write(shifts_table);
                        </script>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include("emp_footer.php"); ?>

<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBTd7zK0XohiaBH0OzHJ-sqpQl1XtRZpik&callback=initMap">
</script>

<script src="http://maps.googleapis.com/maps/api/js?libraries=geometry&sensor=false"></script>


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