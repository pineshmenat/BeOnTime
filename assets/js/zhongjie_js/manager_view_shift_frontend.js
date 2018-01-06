const backendURL = "./manager_view_shift_backend.php";
const startTimeFormatted = "00:00:00", endTimeFormatted = "23:59:59";
var shifts, selectedShiftId, selectedShiftStatus;
var shiftRowselected = false;

// When page get loaded properly, issue backend an AJAX call to get company list.
// Fill out dropdown selection with returned values.
//
$(document).ready(function () {

    loadAllCompanys();
});


// Company selection changes
// run following code to get all locations of selected company.
//
$("#companySelection").change(function () {

    var companyId = "";
    companyId = $("#companySelection").val();

    if (!jQuery.isEmptyObject(companyId)) {

        loadCompanyLocations(companyId);

    } else {
        // If none of company is selected, just fill out a description in company location selection.
        $("#companyLocationSelection").html("<option>Select Location</option>");
    }

});

// Search shift button click
//
$("#btnSearchShift").click(function () {

    // STEP 1:
    // Always clears div at first. Sometimes if users don't select any fields, the div should be display nothing.
    $("#shiftDisplay").empty();
    $("#errorDisplayInBasePage_1").empty();

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
        errorDisplayMessage += "<span class='text-danger'>Company field is required.</span><br/>";
    }
    if (jQuery.isEmptyObject(startDateObject)) {
        errorDisplayMessage += "<span class='text-danger'>Start date field is required.</span><br/>";
    }
    if (jQuery.isEmptyObject(endDateObject)) {
        errorDisplayMessage += "<span class='text-danger'>End date field is required.</span><br/>";
    }
//        console.log(errorDisplayMessage);

    $("#errorDisplayInBasePage_1").html(errorDisplayMessage);

    // STEP 4:
    // If all required fields are selected and not empty, retrieve data from db, otherwise do nothing.
    if (!jQuery.isEmptyObject(companyId) && !jQuery.isEmptyObject(startDateObject) && !jQuery.isEmptyObject(endDateObject)) {

        // console.log("companyId: " + companyId + " companyLocationId: " + companyLocationId
        //     + " startDateFormatted: " + startDateFormatted + " startTimeFormatted: " + startTimeFormatted
        //     + " endDateFormatted: " + endDateFormatted + " endTimeFormatted: " + endTimeFormatted);

        loadShifts(companyId, companyLocationId, startDateFormatted, startTimeFormatted, endDateFormatted, endTimeFormatted);
    }

    // Reset status, so that mouseover and mouseout event can work properly
    shiftRowselected = false;
});

$("#btnCancelShift").click(function () {
    // console.log("selectedEmployeeId: " + selectedEmployeeId);
    // console.log("selectedShiftStatus: " + selectedShiftStatus);
    // console.log("inArray: " + $.inArray(selectedShiftStatus, ["C", "D"]));

    $("#errorDisplayInBasePage_2").empty();

    if (selectedShiftId == null) {

        $("#errorDisplayInBasePage_2").html("<p class='text-danger font-weight-bold'>Please select a shift</p>");

    } else if ($.inArray(selectedShiftStatus, ["C", "D"]) >= 0) {
        // C means cancelled, D means done

        $("#errorDisplayInBasePage_2").html("<p class='text-danger font-weight-bold'>It's already cancelled</p>");

    } else {

        cancelShift();

    }
});

$("#btnActivateShift").click(function () {
    // console.log("selectedEmployeeId: " + selectedEmployeeId);
    // console.log("selectedShiftStatus: " + selectedShiftStatus);

    $("#errorDisplayInBasePage_2").empty();

    if (selectedShiftId == null) {

        $("#errorDisplayInBasePage_2").html("<p class='text-danger font-weight-bold'>Please select a shift</p>");

    } else if ($.inArray(selectedShiftStatus, ["R", "A", "N"]) >= 0) {
        // R means Rejected, A means Accepted, N means New
        $("#errorDisplayInBasePage_2").html("<p class='text-danger font-weight-bold'>It's already activated</p>");
    } else {

        activateShift();

    }
});

// Select a row from table and get the value attribute of the row
// NOTE: For any results returned by AJAX call, use on() to attach event handler
//
$(document).on("click", "#shiftDisplay tbody tr", function (e) {
    // Clear all the background color
    $("#shiftDisplay tbody tr").css("background-color", "#f3f3f3");
    // Set the background color of clicked row to grey
    $(this).css("background-color", "#c2c2c2");

    // Set global values
    selectedShiftId = $(this).attr('value');
    // console.log("selectedShiftId: " + selectedShiftId);
    shiftRowselected = true;

    selectedShiftStatus = $(this).find("td.shiftStatus").attr('value');
    // console.log("selectedShiftStatus: " + selectedShiftStatus);

});

$(document).on("mouseover", "#shiftDisplay tbody tr", function (e) {
    if (!shiftRowselected) {
        // Clear all the background color
        $("#shiftDisplay tbody tr").css("background-color", "#f3f3f3");
        // Set the background color of clicked row to grey
        $(this).css("background-color", "#c2c2c2");
    }


});

$(document).on("mouseout", "#shiftDisplay tbody tr", function (e) {

    if (!shiftRowselected) {
        // Clear all the background color
        $("#shiftDisplay tbody tr").css("background-color", "#f3f3f3");
    }

    // Set the background color of clicked row to grey
    // $(this).css("background-color", "#c2c2c2");

});


function loadAllCompanys() {

    var paramOperation = "operation=searchAllCompanies";
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("POST", backendURL, true);
    // Set request header, otherwise AJAX call won't work.
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send(paramOperation);

    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            // $("#companySelection").html(this.responseText);
            //    console.log(this.responseText);

            var allCompanies = JSON.parse(this.responseText);

            displayAllCompanies(allCompanies);
        }
    }

}

function displayAllCompanies(allCompanies) {

    var companiesOption = "<option value=\"\" selected>Select Company</option>";

    $.each(allCompanies.companies, function (key, value) {
//            console.log(key, value);
        companiesOption += "<option value=\"" + value.CompanyId + "\">" + value.CompanyName + "</option>"
    });

//        console.log("companiesOption" + companiesOption);
    $("#companySelection").html(companiesOption);

}

function loadCompanyLocations(companyId) {
    var paramOperation = "operation=searchCompanyLocations";
    var paramCompanyId = "companyId=" + companyId;

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("POST", backendURL, true);
    // Set request header, otherwise AJAX call won't work.
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send(paramOperation + "&" + paramCompanyId);

    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            // $("#companyLocationSelection").html(this.responseText);
//                console.log(this.responseText);
            var companyLocations = JSON.parse(this.responseText);

            displayCompanyLocations(companyLocations);
        }
    }

}

function displayCompanyLocations(companyLocations) {

    var companyLocationOption = "<option value=\"\" selected>Select Location</option>";

    $.each(companyLocations.companylocations, function (key, value) {
//            console.log(key, value);
        companyLocationOption += "<option value=\"" + value.CompanyLocationId + "\">" + value.Address + "</option>"
    });

//        console.log("companyLocationOption" + companyLocationOption);
    $("#companyLocationSelection").html(companyLocationOption);
}

function loadShifts(companyId, companyLocationId, startDateFormatted, startTimeFormatted, endDateFormatted, endTimeFormatted) {
    // Set HTTP post header. Pass all of parameters to backend PHP program in header.
    var paramOperation = "operation=searchShifts";
    var paramCompanyId = "companyId=" + companyId;
    var paramCompanyLocationId = "companyLocationId=" + companyLocationId;
    var paramStartDateFormatted = "startDateFormatted=" + startDateFormatted;
    var paramStartTimeFormatted = "startTimeFormatted=" + startTimeFormatted;
    var paramEndDateFormatted = "endDateFormatted=" + endDateFormatted;
    var paramEndTimeFormatted = "endTimeFormatted=" + endTimeFormatted;
    // console.log("paramCompanyId: " + paramCompanyId);
    // console.log("paramCompanyLocationId: " + paramCompanyLocationId);

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("POST", backendURL, true);
    // Set request header, otherwise AJAX call won't work.
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send(paramOperation + "&" + paramCompanyId + "&" + paramCompanyLocationId + "&"
        + paramStartDateFormatted + "&" + paramStartTimeFormatted + "&" + paramEndDateFormatted + "&" + paramEndTimeFormatted);

    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {

            // console.log(this.responseText);

            shifts = JSON.parse(this.responseText);
            // console.log("shifts: " + shifts);
            displayShifts();

            // Reset disabled status before shifts are displayed
            $("#btnUnassignEmployee").attr("disabled", true);
            $("#btnCancelShift").attr("disabled", true);
            $("#btnActivateShift").attr("disabled", true);
            selectedShiftId = null;
            // console.log("shifts.shifts.length: " + shifts.shifts.length);
            if (shifts.shifts.length == 0) {
                $("#errorDisplay").html("<p class='text-danger font-weight-bold'>No shift is found</p>");
            } else {
                $("#btnUnassignEmployee").attr("disabled", false);
                $("#btnCancelShift").attr("disabled", false);
                $("#btnActivateShift").attr("disabled", false);
            }
        }
    }

}

function displayShifts() {

    var shiftsTable = "<table class=\"table table-condensed\">";
    shiftsTable += "<thead><tr>";
    shiftsTable += "<th>Shift Id</th>";
    shiftsTable += "<th>By</th>";
    shiftsTable += "<th>To</th>";
    shiftsTable += "<th>Working Place</th>";
    shiftsTable += "<th>Level</th>";
    shiftsTable += "<th>Start Time</th>";
    shiftsTable += "<th>End Time</th>";
    shiftsTable += "<th>Status</th>";
    shiftsTable += "</tr></thead>";
    shiftsTable += "<tbody>";

    $.each(shifts.shifts, function (key, value) {
        // console.log(key + " " + value.ShiftId);
        shiftsTable += "<tr value=" + value.ShiftId + ">";
        shiftsTable += "<td>" + value.ShiftId + "</td>";
        shiftsTable += "<td>" + value.AssignedBy + "</td>";
        shiftsTable += "<td>" + ((value.AssignedTo != null) ? value.AssignedTo : "") + "</td>";
        shiftsTable += "<td>" + value.Address + "</td>";
        shiftsTable += "<td>" + value.empDesignationName + "</td>";
        shiftsTable += "<td class='shiftStartTime'>" + value.StartTime + "</td>";
        shiftsTable += "<td class='shiftEndTime'>" + value.EndTime + "</td>";
        shiftsTable += "<td class='shiftStatus' value='" + value.ShiftStatus + "'>" + convertShiftStatusFromCharToString(value.ShiftStatus) + "</td>";
        shiftsTable += "<tr>";
    });

    shiftsTable += "</tbody></table>";

    $("#shiftDisplay").html(shiftsTable);

    // Set cursor to hand shape when mouse hover on a row in the table
    $("#shiftDisplay tbody tr").css("cursor", "pointer");
}

function cancelShift() {

    // console.log("selectedShiftId: " + selectedShiftId);

    var paramOperation = "operation=cancelShift";
    var paramSelectedShiftId = "selectedShiftId=" + selectedShiftId;
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("POST", backendURL, true);
    // Set request header, otherwise AJAX call won't work.
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send(paramOperation + "&" + paramSelectedShiftId);

    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {

            // console.log(this.responseText);
            var status = JSON.parse(this.responseText);
            // console.log("status: " + status.status['success']);

            if (status.status['success']) {
                $("#operationResultInfo").html("<p>Selected shift is cancelled</p>");
            } else {
                $("#operationResultInfo").html("<p>Failed to cancel shift</p>");
            }

            // display operationResultDisplay modal
            $("#operationResultDisplay").modal('show');

            // Refresh shift table in the base page
            $("#btnSearchShift").click();

        }
    }
}

function activateShift() {

    // console.log("selectedShiftId: " + selectedShiftId);

    var paramOperation = "operation=activateShift";
    var paramSelectedShiftId = "selectedShiftId=" + selectedShiftId;
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("POST", backendURL, true);
    // Set request header, otherwise AJAX call won't work.
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send(paramOperation + "&" + paramSelectedShiftId);

    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {

            // console.log(this.responseText);
            var status = JSON.parse(this.responseText);
            // console.log("status: " + status.status['success']);

            if (status.status['success']) {
                $("#operationResultInfo").html("<p>Selected shift is activated</p>");
            } else {
                $("#operationResultInfo").html("<p>Failed to activate shift</p>");
            }

            // display operationResultDisplay modal
            $("#operationResultDisplay").modal('show');

            // Refresh shift table in the base page
            $("#btnSearchShift").click();

        }
    }
}

function convertShiftStatusFromCharToString(shiftStatusInChar) {

    var shiftStatusInString;
    // console.log(shiftStatusInChar);
    switch (shiftStatusInChar) {
        case 'N': {
            shiftStatusInString = "New";
            break;
        }
        case 'A': {
            shiftStatusInString = "Accepted";
            break;
        }
        case 'R': {
            shiftStatusInString = "Rejected";
            break;
        }
        case 'D': {
            shiftStatusInString = "Done";
            break;
        }
        case 'C': {
            shiftStatusInString = "Cancelled";
            break;
        }
        default: {
            shiftStatusInString = "Unknown";
            break;
        }
    }
    return shiftStatusInString;
}
