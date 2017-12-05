const url = "example2_backend.php";
const startTimeFormatted = "00:00:00", endTimeFormatted = "23:59:59";

// When page get loaded properly, issue backend an AJAX call to get company list.
// Fill out dropdown selection with returned values.
//
$(document).ready(function () {
    $("#companySelection").css("width", "250px");
    $("#companyLocationSelection").css("width", "250px");

    loadAllCompanys();
});

// Company selection changes
// run following code to get company locations.
//
$("#companySelection").change(function () {

    var companyId = "";
    companyId = $("#companySelection").val();

    if (!jQuery.isEmptyObject(companyId)) {

        loadAllCompanyLocations(companyId);

    } else {
        // If none of company is selected, just fill out a description in company location selection.
        $("#companyLocationSelection").html("<option>Company Location List</option>");
    }

});

// Search shift button click
//
$("#btnSearchShift").click(function () {

    // STEP 1:
    // Always clears div at first. Sometimes if users don't select any fields, the div should be display nothing.
    $("#shiftDisplay").empty();

    var errorDisplayMessage = "";
    var companyId = "";
    var companyLocationId = "";

    // STEP 2:
    // Get value of companyId
    // Get value of companyLocationId
    companyId = $("#companySelection").val();
    companyLocationId = $("#companyLocationSelection").val();

    // Get value of startDate and format it. Time will be taken from constant variable.
    var startDateObject = $('#startDateTimePicker').data("DateTimePicker").date();

    if (!jQuery.isEmptyObject(startDateObject)) {
//            console.log(startDateObject);
        var startDate = startDateObject['_d'];
        // In format YYYY-MM-DD
        var startDateFormatted = startDate.getFullYear() + '-' + (startDate.getMonth() + 1) + '-' + startDate.getDate();
//            console.log(startDateFormatted);
    }

    // Get value of endDate and format it. Time will be taken from constant variable.
    var endDateObject = $('#endDateTimePicker').data("DateTimePicker").date();

    if (!jQuery.isEmptyObject(endDateObject)) {
//            console.log(endDateObject);
        var endDate = endDateObject['_d'];
        // In format YYYY-MM-DD
        var endDateFormatted = endDate.getFullYear() + '-' + (endDate.getMonth() + 1) + '-' + endDate.getDate();
//            console.log(endDateFormatted);
    }


    // STEP 3:
    // Check whether all the values user selected are empty or not.
    // REQUIRED: companyId, startDate and endDate
    // OPTIONAL: companyLocationId
    if (jQuery.isEmptyObject(companyId)) {
        errorDisplayMessage += "<p>Company field is required.</p>";
    }
    if (jQuery.isEmptyObject(startDateObject)) {
        errorDisplayMessage += "<p>Start date field is required.</p>";
    }
    if (jQuery.isEmptyObject(endDateObject)) {
        errorDisplayMessage += "<p>End date field is required.</p>";
    }
//        console.log(errorDisplayMessage);

    $("#errorDisplay").html(errorDisplayMessage);

    // STEP 4:
    // If all required fields are selected and not empty, retrieve data from db, otherwise do nothing.
    if (!jQuery.isEmptyObject(companyId) && !jQuery.isEmptyObject(startDateObject) && !jQuery.isEmptyObject(endDateObject)) {

        loadShift(companyId, companyLocationId, startDateFormatted, startTimeFormatted, endDateFormatted, endTimeFormatted);
    }
});

// Assign employee button click
//
$("#btnAssignEmployee").click(function () {

    // Clear error display, employee display and form.
    // The effect of loadAllCities() method is like reset selection.
    $("#employeeDisplay").empty();
    $("#errorDisplayInModal").empty();
    loadAllCities();
    clearFormInModal();


    /*    $("#errorDisplay").empty();

        var rowCount = $("input[name='shiftList']").length;
        var selectedRowCount = $("input[name='shiftList']:checked").length;
        // console.log("selectedRowCount: " + selectedRowCount);
        // console.log("rowCount: " + rowCount);

        // Assigning employee works only when table has shift row(s) selected
        if(rowCount > 1) {
            if (selectedRowCount >= 1) {

                var shiftIdList = [];
                $.each($("input[name='shiftList']:checked"), function(){
                    shiftIdList.push($(this).val());
                });

                $("#selectEmployee").modal('show');

                console.log("Selected shifts: " + shiftIdList.join(", "));
            } else {
                $("#errorDisplay").html("<p>Please select at least 1 shift.</p>");
            }
        } else {
            $("#errorDisplay").html("<p>Please get shift at first.</p>");
        }*/


    $("#selectEmployee").modal('show');

});

// Select all shifts checkbox check
// NOTE: For any results returned by AJAX call, use on() to attach event handler
//
$(document).on("change", "#selectAllShifts", function (e) {

    if(this.checked) {
        $("input[name='shiftList']").prop('checked', true);
    } else {
        $("input[name='shiftList']").prop('checked', false);
    }

});

$("#btnSearchEmployee").click(function () {

    // STEP 1:
    // Always clears div at first. Sometimes if users don't select any fields, the div should be display nothing.
    $("#employeeDisplay").empty();

    var errorDisplayMessage = "";

    // STEP 2:
    // Get value of cityName, employeeId, firstName, LastName and employee desired day
    var cityName = $("#citySelection").val();
    var employeeId = $("#employeeId").val();
    var firstName = $("#firstName").val();
    var lastName = $("#lastName").val();
    var desiredDaySelection = [];
    $.each($("input[name='employeeDesiredDay']:checked"), function(){
        desiredDaySelection.push($(this).val());
    });
    // console.log("Selected desired days: " + employeeDesiredDaySelection.join(", "));

    // STEP 3:
    // Check whether all the values user selected are empty or not.
    // REQUIRED: cityName
    // OPTIONAL: employeeId, firstName, LastName and employee desired day
    if (jQuery.isEmptyObject(cityName)) {
        errorDisplayMessage += "<p>City field is required.</p>";
    }
//        console.log(errorDisplayMessage);

    $("#errorDisplayInModal").html(errorDisplayMessage);

    // STEP 4:
    // If all required fields are selected and not empty, retrieve data from db, otherwise do nothing.
    if (!jQuery.isEmptyObject(cityName)) {
        loadEmployees(cityName, employeeId, firstName, lastName, desiredDaySelection);
    }
});

// selectAllDesiredDays checkbox check
//
$("#selectAllDesiredDays").change(function () {

    if(this.checked) {
        $("input[name='employeeDesiredDay']").prop('checked', true);
    } else {
        $("input[name='employeeDesiredDay']").prop('checked', false);
    }
});

function loadAllCompanys() {

    var paramOperation = "operation=searchAllCompanys";
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("POST", url, true);
    // Set request header, otherwise AJAX call won't work.
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            $("#companySelection").html(this.responseText);
//                console.log(this.responseText);
        }
    }
    xmlhttp.send(paramOperation);
}

function loadAllCompanyLocations(companyId) {
    var paramOperation = "operation=searchCompanyLocation";
    var paramCompanyId = "companyId=" + companyId;

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("POST", url, true);
    // Set request header, otherwise AJAX call won't work.
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            $("#companyLocationSelection").html(this.responseText);
//                console.log(this.responseText);
        }
    }
    xmlhttp.send(paramOperation + "&" + paramCompanyId);
}

function loadShift(companyId, companyLocationId, startDateFormatted, startTimeFormatted, endDateFormatted, endTimeFormatted) {
    // Set HTTP post header. Pass all of parameters to backend PHP program in header.
    var paramOperation = "operation=searchShift";
    var paramCompanyId = "companyId=" + companyId;
    var paramCompanyLocationId = "companyLocationId=" + companyLocationId;
    var paramStartDateFormatted = "startDateFormatted=" + startDateFormatted;
    var paramStartTimeFormatted = "startTimeFormatted=" + startTimeFormatted;
    var paramEndDateFormatted = "endDateFormatted=" + endDateFormatted;
    var paramEndTimeFormatted = "endTimeFormatted=" + endTimeFormatted;
    // console.log("paramCompanyId: " + paramCompanyId);
    // console.log("paramCompanyLocationId: " + paramCompanyLocationId);

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("POST", url, true);
    // Set request header, otherwise AJAX call won't work.
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            $("#shiftDisplay").html(this.responseText);
            // console.log(this.responseText);
        }
    }
    xmlhttp.send(paramOperation + "&" + paramCompanyId + "&" + paramCompanyLocationId + "&"
        + paramStartDateFormatted + "&" + paramStartTimeFormatted + "&" + paramEndDateFormatted + "&" + paramEndTimeFormatted);
}

function loadAllCities() {
    var paramOperation = "operation=searchAllCities";
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("POST", url, true);
    // Set request header, otherwise AJAX call won't work.
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            $("#citySelection").html(this.responseText);
//                console.log(this.responseText);
        }
    }
    xmlhttp.send(paramOperation);
}

function loadEmployees(cityName, employeeId, firstName, lastName, desiredDaySelection) {
    // Set HTTP post header. Pass all of parameters to backend PHP program in header.
    var paramOperation = "operation=searchEmployees";
    var paramCityName = "cityName=" + cityName;
    var paramEmployeeId = "employeeId=" + employeeId;
    var paramFirstName = "firstName=" + firstName;
    var paramLastName = "lastName=" + lastName;
    var paramDesiredDaySelection = "desiredDaySelection=" + desiredDaySelection;
    // console.log("paramCityName: " + paramCityName);
    // console.log("paramDesiredDaySelection: " + paramDesiredDaySelection);

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("POST", url, true);
    // Set request header, otherwise AJAX call won't work.
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            $("#employeeDisplay").html(this.responseText);
            // console.log(this.responseText);
        }
    }
    xmlhttp.send(paramOperation + "&" + paramCityName + "&" + paramEmployeeId + "&" + paramFirstName + "&" + paramLastName + "&" + paramDesiredDaySelection);
}

function clearFormInModal() {
    $("#employeeId").val('');
    $("#firstName").val('');
    $("#lastName").val('');
    $("input[name='employeeDesiredDay']").prop('checked', false);
    $("input[id='selectAllDesiredDays']").prop('checked', false);
}
