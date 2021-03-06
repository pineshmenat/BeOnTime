const backendURL = "./employee_movement_check_backend.php";
const CANADA_CENTER_LAT = 59.0985492, CANADA_CENTER_LNG = -104.4796261, ZOOM = 16;
const MOVEMENT_RADIUS = 180;
const INFOWINDOW_DELAY = 1800;
const EMPLOYEE_LOCATION_REFRESH_INTERVAL = 12000;

var map;
var userId;
var workPlaceLat, workPlaceLng, currentLat, currentLng;
var currentEmployeePositionMarker, workPlaceMarker;
var workPlaceMovementcircle;
var hasActiveShift = false;

$(document).ready(function () {

    userId = $('#sessionUserId').data('value');
    console.log("userId: " + userId);

    if (userId != null) {
        getCurrentShift();
    }
});

$("#btnFakeLocation").click(function () {

    // prepare 3 fake location data for demonstration
    const fakeLatLng = [
        [43.7258846, -79.6088498],
        [43.7312217, -79.6004444],
        [43.7309581, -79.6062702]
    ];

    var randomIndex = Math.floor(Math.random() * 3);
    // console.log("randomIndex: " + randomIndex);

    currentLat = fakeLatLng[randomIndex][0];
    currentLng = fakeLatLng[randomIndex][1];

    plotCurrentEmployeePosition();
    // panTo() is to move to employee's current position
    map.panTo(new google.maps.LatLng(currentLat, currentLng));

    checkEmployeeInRange();

});

$("#btnRefreshMyPosition").click(function () {

    getEmployeeRealPosition();
});

function prepareMap() {

    // Get height of page window, so that in the big screen, map won't be too small
    var mapHeight = $(window).height();
    // console.log("mapHeight: " + mapHeight);
    $('#mapDisplay').css("height", mapHeight * 0.73);

    initMap();
}

function initMap() {

    map = new google.maps.Map(document.getElementById('mapDisplay'), {
        // Initially, just display map of Canada
        center: {lat: CANADA_CENTER_LAT, lng: CANADA_CENTER_LNG},
        zoom: 4
    });
}

function getCurrentShift() {

    // Get current date and time
    var dt = new Date($.now());
    // console.log("Date: " + dt);
    // console.log("Year: " + dt.getFullYear() + " Month: " + (dt.getMonth() + 1) + " Date: " + dt.getDate());
    // console.log("Hour: " + dt.getHours() + " Minute: " + dt.getMinutes() + " Second: " + dt.getSeconds());
    // console.log(dt.getFullYear() + "-" + (dt.getMonth() + 1) + "-" + dt.getDate() + " " + dt.getHours() + ":" + dt.getMinutes() + ":" + dt.getSeconds());
    var currentTime = dt.getFullYear() + "-" + (dt.getMonth() + 1) + "-" + dt.getDate() + " " + dt.getHours() + ":" + dt.getMinutes() + ":" + dt.getSeconds();

    var paramOperation = "operation=GetShiftInNext30Minutes";
    var paramUserId = "userId=" + userId;
    var paramCurrentTime = "currentTime=" + currentTime;

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("POST", backendURL, true);
    // Set request header, otherwise AJAX call won't work.
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send(paramOperation + "&" + paramUserId + "&" + paramCurrentTime);

    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            // $("#companyLocationSelection").html(this.responseText);
            // console.log(this.responseText);
            var currentShift = JSON.parse(this.responseText);

            displayShift(currentShift);

            if(hasActiveShift) {
                // Go to work place
                toWorkPlace();

                // Add marker and info window for work place
                plotWorkPlace();

                // Get employee real geo position
                getEmployeeRealPosition();

                // Go to real employee position
                setInterval(toEmployeeCurrentPosition, EMPLOYEE_LOCATION_REFRESH_INTERVAL);

                $("#btnFakeLocation").attr("disabled", false);

            }

        }
    }
}

function displayShift(currentShift) {

    $("#errorDisplayInBasePage").empty();
    $("#shiftDisplay").empty();

    if (currentShift.shift.length == 0) {

        $("#errorDisplayInBasePage").html("<p class='text-danger font-weight-bold'>You do not have any shift now.</p>");

    } else if (currentShift.shift.length == 1) {


        var shiftsTable = "<table class=\"table table-condensed\">";
        shiftsTable += "<thead><tr>";
        shiftsTable += "<th>Shift Id</th>";
        shiftsTable += "<th>Company</th>";
        shiftsTable += "<th>Working Place</th>";
        shiftsTable += "<th>Start Time</th>";
        shiftsTable += "<th>End Time</th>";
        shiftsTable += "</tr></thead>";
        shiftsTable += "<tbody>";

        $.each(currentShift.shift, function (key, value) {
            // console.log(key + " " + value.ShiftId);
            shiftsTable += "<tr value=" + value.ShiftId + ">";
            shiftsTable += "<td>" + value.ShiftId + "</td>";
            shiftsTable += "<td>" + value.CompanyName + "</td>";
            shiftsTable += "<td>" + value.WorkingPlace + "</td>";
            shiftsTable += "<td>" + value.StartTime + "</td>";
            shiftsTable += "<td>" + value.EndTime + "</td>";
            shiftsTable += "<tr>";

            workPlaceLat = parseFloat(value.Latitude);
            workPlaceLng = parseFloat(value.Longitude);

        });

        shiftsTable += "</tbody></table>";

        $("#shiftDisplay").html(shiftsTable);

        hasActiveShift = true;

        // console.log("workPlaceLat: " + workPlaceLat + " workPlaceLng: " + workPlaceLng);
    } else {
        // More than 1 shift returns. This is not logical and should be avoided.
        $("#errorDisplayInBasePage").html("<p class='text-danger font-weight-bold'>Error</p>");
    }
}

function toWorkPlace() {

    // console.log("workPlaceLat: " + workPlaceLat + " workPlaceLng: " + workPlaceLng);

    // display and mark work place
    map = new google.maps.Map(document.getElementById('mapDisplay'), {
        // Initially, just display map of Canada
        center: {lat: workPlaceLat, lng: workPlaceLng},
        zoom: ZOOM
    });
}

function plotWorkPlace() {

    // Mark work place position
    workPlaceMarker = new google.maps.Marker({
        position: {lat: workPlaceLat, lng: workPlaceLng},
        map: map,
    });

    // Draw a circle for work place, indicating the movement range for employee
    workPlaceMovementcircle = new google.maps.Circle({
        strokeColor: '#FF0000',
        strokeOpacity: 0.4,
        strokeWeight: 1,
        fillColor: '#FF0000',
        fillOpacity: 0.2,
        map: map,
        center: {lat: workPlaceLat, lng: workPlaceLng},
        radius: MOVEMENT_RADIUS,
    });

    var workPlaceInfoWindow = new google.maps.InfoWindow({
        content: "Work Place"
    });

    workPlaceMarker.addListener('click', function () {
        // Bind infowindow to marker
        workPlaceInfoWindow.open(map, workPlaceMarker);
        // info window will disappear after 1.5 seconds
        setTimeout(function () {
            workPlaceInfoWindow.close();
        }, 1500);
    });

}

function toEmployeeCurrentPosition() {

    navigator.geolocation.getCurrentPosition(
        // successfully get position
        function (position) {
            // console.log(position);
            // console.log(position.coords.latitude + " " + position.coords.longitude);
            currentLat = position.coords.latitude;
            currentLng = position.coords.longitude;
            // console.log("currentLat: " + currentLat + " currentLng: " + currentLng);

            if (currentLat != null && currentLng != null) {

                plotCurrentEmployeePosition();

                // panTo() is to move to employee's current position
                map.panTo(new google.maps.LatLng(currentLat, currentLng));

                // Save current employee's position in DB shiftmaster table
                saveCurrentEmployeePositionInDB();

                // Check employee's position every few seconds
                checkEmployeeInRange();
            }
        },
        // failed to get position
        function () {

            $("#errorDisplayInBasePage").html("<p class='text-danger font-weight-bold'>Failed to get your current position data.</p>");

        }
    );

}

function plotCurrentEmployeePosition() {

    // Clean previous currentEmployeePositionMarker on the map
    if (currentEmployeePositionMarker != null) {
        currentEmployeePositionMarker.setMap(null);
    }

    // Mark employee's current position
    currentEmployeePositionMarker = new google.maps.Marker({
        position: {lat: currentLat, lng: currentLng},
        map: map,
        icon: "http://maps.google.com/mapfiles/marker_yellow.png"
    });

}

function checkEmployeeInRange() {

    var distance = getDistance(currentLat, currentLng, workPlaceLat, workPlaceLng);

    var currentEmployeePositionInfoWindow = new google.maps.InfoWindow({
        // content: "My position:<br/>Latitude: " + currentLat + "<br/>Longitude: " + currentLng
        content: (distance > MOVEMENT_RADIUS) ? (Math.round((distance - MOVEMENT_RADIUS) * 10 / 10) + " meters to your work place.") : "You are in the movement range"
    });

    currentEmployeePositionMarker.addListener('click', function () {
        // Bind infowindow to marker
        currentEmployeePositionInfoWindow.open(map, currentEmployeePositionMarker);
        // info window will disappear after 1.8 seconds
        setTimeout(function () {
            currentEmployeePositionInfoWindow.close();
        }, INFOWINDOW_DELAY);
    });

    if (distance > MOVEMENT_RADIUS) {
        $("#warningInfo").html("<p>Please go back to work.</p>")
        $("#warningDisplay").modal('show');
    }
}

function getEmployeeRealPosition() {

    navigator.geolocation.getCurrentPosition(
        // successfully get position
        function (position) {
            // console.log(position);
            // console.log(position.coords.latitude + " " + position.coords.longitude);
            currentLat = position.coords.latitude;
            currentLng = position.coords.longitude;
            // console.log("currentLat: " + currentLat + " currentLng: " + currentLng);

            if (currentLat != null && currentLng != null) {

                plotCurrentEmployeePosition();

                // panTo() is to move to employee's current position
                map.panTo(new google.maps.LatLng(currentLat, currentLng));
                
            }
        },
        // failed to get position
        function () {

            $("#errorDisplayInBasePage").html("<p class='text-danger font-weight-bold'>Failed to get your current position data.</p>");

        }
    );
}

function getDistance(p1Lat, p1Lng, p2Lat, p2Lng) {
    var R = 6378137; // Earth’s mean radius in meter
    var dLat = (p2Lat - p1Lat) * Math.PI / 180;
    var dLong = (p2Lng - p1Lng) * Math.PI / 180;
    var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
        Math.cos((p1Lat)) * Math.PI / 180 * Math.cos((p2Lat) * Math.PI / 180) *
        Math.sin(dLong / 2) * Math.sin(dLong / 2);
    var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
    var d = R * c;
    return Math.round(d * 10) / 10; // returns the distance in meter
}

function saveCurrentEmployeePositionInDB() {

    var paramOperation = "operation=SaveCurrentEmployeePosition";
    var paramShiftId = "shiftId=" + $("#shiftDisplay tbody tr").first().attr('value');
    var paramEmployeeCurrentLat = "employeeCurrentLat=" + Math.round(currentLat * 100000000) / 100000000;
    var paramEmployeeCurrentLng = "employeeCurrentLng=" + Math.round(currentLng * 100000000) / 100000000;

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("POST", backendURL, true);
    // Set request header, otherwise AJAX call won't work.
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send(paramOperation + "&" + paramShiftId + "&" + paramEmployeeCurrentLat + "&" + paramEmployeeCurrentLng);
    // console.log(paramOperation + "&" + paramShiftId + "&" + paramEmployeeCurrentLat + "&" + paramEmployeeCurrentLng);

    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            // $("#companyLocationSelection").html(this.responseText);
            // console.log(this.responseText);
            var result = JSON.parse(this.responseText);

            // console.log("saveActualWorkingStartTimeInDB() result: " + result['success']);
        }
    }
}