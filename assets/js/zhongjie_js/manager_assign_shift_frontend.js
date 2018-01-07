const backendURL = "./manager_assign_shift_backend.php";
const startTimeFormatted = "00:00:00", endTimeFormatted = "23:59:59";
var shifts, selectedShiftId, selectedShiftStartTime, selectedShiftEndTime, selectedShiftDay, selectedAssignedTo;
var shiftRowselected = false;
var selectedEmployeeId;
var employeeRowselected = false;
var managerId;

// When page get loaded properly, issue backend an AJAX call to get company list.
// Fill out dropdown selection with returned values.
//
$(document).ready(function () {

    loadAllCompanys();

    managerId = $('#sessionUserId').data('value');
    // console.log("managerId: " + managerId);
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

// Assign employee button click
//
$("#btnShowAssignEmployeeModal").click(function () {

    $("#errorDisplayInBasePage_2").empty();

    // console.log("selectedShiftId: " + (selectedShiftId == null));
    if (selectedShiftId == null) {
        $("#errorDisplayInBasePage_2").html("<p class='text-danger font-weight-bold'>Please select a shift</p>");
    } else {

        if (selectedShiftStartTime != null && selectedShiftEndTime != null && selectedShiftDay != null) {
            $("#selectedShiftTimeInfo").html("<p>Selected shift will start from <b>" + selectedShiftStartTime + "</b> (<b>" + selectedShiftDay + "</b>), end at <b>" + selectedShiftEndTime + "</b></p>");

            // Clear error display, employee display and form.
            // The effect of loadAllCities() method is like reset selection.
            $("#employeeDisplay").empty();
            $("#errorDisplayInModal").empty();
            loadAllCities();
            cleanFormInModal();

            $("#selectEmployee").modal('show');
            employeeRowselected = false;
            $("#btnAssignEmployee").attr('disabled', true);

        } else {
            $("#errorDisplayInBasePage_2").html("<p class='text-danger font-weight-bold'>Error. No valid selectedShiftStartTime, or selectedShiftEndTime, or selectedShiftDay</p>");
        }
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
    // Prevent all default behaviors.
//        e.preventDefault();
    // Get clicked row index
    // rowIndexInAllTable = $(this).index();
//        console.log("rowIndexInAllTable_4: " + $(this).index());
    // Set global values
    selectedShiftId = $(this).attr('value');
    // console.log("selectedShiftId: " + selectedShiftId);
    selectedAssignedTo = $(this).find("td.assignedTo").text();
    selectedShiftStartTime = $(this).find("td.shiftStartTime").text();
    selectedShiftEndTime = $(this).find("td.shiftEndTime").text();
    // console.log("selectedShiftStartTime: " + selectedShiftStartTime + " selectedShiftEndTime: " + selectedShiftEndTime);

    var d = new Date(selectedShiftStartTime);
    selectedShiftDay = convertDayNumberToDayString(d.getDay());

    // console.log("d: " + d);
    // console.log("Year: " + d.getFullYear() + " Month: " + (d.getMonth() + 1) + " Time: " + d.getHours() + " Day: " + d.getDay());

    shiftRowselected = true;
    // For METHOD1: If use method1, below 3 lines need to be uncommented.
//        selectedProductName = $(this).find("td:eq(1)").text();
//        selectedProductType = $(this).find("td:eq(2)").text();
//        selectedProductPrice = $(this).find("td:eq(3)").text();
//     $.each(allProducts.products, function (key, value) {
//         if (selectedProductId == value.ID) {
//             console.log(key + " " + value.ID + " " + value.Name + " " + value.Type + " " + value.Price);
//             selectedProductName = value.Name;
//             selectedProductType = value.Type;
//             selectedProductPrice = value.Price;
//         }
//     });
//        console.log("selectedProductName: " + selectedProductName + " selectedProductType: " + selectedProductType + " selectedProductPrice: " + selectedProductPrice);
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

$("#btnSearchEmployee").click(function () {

    // STEP 1:
    // Always clears div at first. Sometimes if users don't select any fields, the div should be display nothing.
    $("#errorDisplayInModal").empty();

    var errorDisplayMessage = "";

    // STEP 2:
    // Get value of cityName, employeeId, firstName, LastName and employee desired day
    var cityName = $("#citySelection").val();
    var employeeId = $("#employeeId").val();
    var firstName = $("#firstName").val();
    var lastName = $("#lastName").val();
    var desiredDaySelectionInString = [];
    $.each($("input[name='employeeDesiredDay']:checked"), function () {
        desiredDaySelectionInString.push($(this).val());
    });
    // console.log("Selected desired days: " + desiredDaySelection.join(", "));
    // If no desired day is selected, give desiredDaySelectionInBit an empty string.
    // Otherwise it won't be good for sql query if it is 0000000
    var desiredDaySelectionInBit = convertDesiredDayFromStringToBit(desiredDaySelectionInString);
    // desiredDaySelectionInBit = (desiredDaySelectionInBit == '0000000') ? "" : desiredDaySelectionInBit;
    // console.log("desiredDaySelectionInBit: " + desiredDaySelectionInBit);


    // STEP 3:
    // Check whether all the values user selected are empty or not.
    // REQUIRED: cityName
    // OPTIONAL: employeeId, firstName, LastName and employee desired day
    if (jQuery.isEmptyObject(cityName)) {
        errorDisplayMessage += "<p class='text-danger font-weight-bold'>City field is required.</p>";
    }
//        console.log(errorDisplayMessage);

    $("#errorDisplayInModal").html(errorDisplayMessage);

    // STEP 4:
    // If all required fields are selected and not empty, retrieve data from db, otherwise do nothing.
    if (!jQuery.isEmptyObject(cityName)) {
        loadEmployees(cityName, employeeId, firstName, lastName, desiredDaySelectionInBit);
    }


});

// selectAllDesiredDays checkbox check
//
$("#selectAllDesiredDays").change(function () {

    if (this.checked) {
        $("input[name='employeeDesiredDay']").prop('checked', true);
    } else {
        $("input[name='employeeDesiredDay']").prop('checked', false);
    }
});

$(document).on("click", "#employeeDisplay tbody tr", function (e) {

    // Clear all the background color
    $("#employeeDisplay tbody tr").css("background-color", "#fff");
    // Set the background color of clicked row to grey
    $(this).css("background-color", "#c2c2c2");

    selectedEmployeeId = $(this).attr('value');
    // console.log("selectedEmployeeId: " + selectedEmployeeId);

    employeeRowselected = true;
});

$(document).on("mouseover", "#employeeDisplay tbody tr", function (e) {
    if (!employeeRowselected) {
        // Clear all the background color
        $("#employeeDisplay tbody tr").css("background-color", "#fff");
        // Set the background color of clicked row to grey
        $(this).css("background-color", "#c2c2c2");
    }


});

$(document).on("mouseout", "#employeeDisplay tbody tr", function (e) {

    if (!employeeRowselected) {
        // Clear all the background color
        $("#employeeDisplay tbody tr").css("background-color", "#fff");
    }

    // Set the background color of clicked row to grey
    // $(this).css("background-color", "#c2c2c2");

});

$("#btnAssignEmployee").click(function () {
    // console.log("selectedEmployeeId: " + selectedEmployeeId);


    if (selectedEmployeeId == null) {

        $("#errorDisplayInModal").html("<p class='text-danger font-weight-bold'>Please select an employee</p>");
    } else {

        assignEmployeeToShift();

    }
});

$("#btnUndoAssignEmployee").click(function () {

    $("#errorDisplayInBasePage_2").empty();

    // console.log("selectedShiftId: " + (selectedShiftId == null));
    // console.log("selectedAssignedTo: " + selectedAssignedTo);

    if (selectedShiftId == null) {
        $("#errorDisplayInBasePage_2").html("<p class='text-danger font-weight-bold'>Please select a shift</p>");
    } else if (selectedAssignedTo == "") {
        $("#errorDisplayInBasePage_2").html("<p class='text-danger font-weight-bold'>Selected Shift has no employee assigned</p>");
    } else {
        undoAssignEmployee();
    }

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

            // Reset disabled status before any shifts are found
            $("#btnShowAssignEmployeeModal").attr("disabled", true);
            $("#btnUndoAssignEmployee").attr("disabled", true);
            selectedShiftId = null;
            // console.log("shifts.shifts.length: " + shifts.shifts.length);
            if (shifts.shifts.length == 0) {
                $("#errorDisplay").html("<p class='text-danger font-weight-bold'>No shift is found</p>");
            } else {
                $("#btnShowAssignEmployeeModal").attr("disabled", false);
                $("#btnUndoAssignEmployee").attr("disabled", false);
            }
        }
    }

}

function loadAllCities() {
    var paramOperation = "operation=searchAllCities";
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("POST", backendURL, true);
    // Set request header, otherwise AJAX call won't work.
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send(paramOperation);

    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {

            // console.log(this.responseText);
            var allCities = JSON.parse(this.responseText);

            displayAllCities(allCities);
        }
    }

}

function loadEmployees(cityName, employeeId, firstName, lastName, desiredDaySelectionInBit) {
    // Set HTTP post header. Pass all of parameters to backend PHP program in header.
    var paramOperation = "operation=searchEmployees";
    var paramCityName = "cityName=" + cityName;
    var paramEmployeeId = "employeeId=" + employeeId;
    var paramFirstName = "firstName=" + firstName;
    var paramLastName = "lastName=" + lastName;
    var paramDesiredDaySelection = "desiredDaySelection=" + desiredDaySelectionInBit;
    var paramSelectedShiftStartTime = "selectedShiftStartTime=" + selectedShiftStartTime;
    var paramSelectedShiftEndTime = "selectedShiftEndTime=" + selectedShiftEndTime;
    // console.log("paramCityName: " + paramCityName);
    // console.log("paramDesiredDaySelection: " + paramDesiredDaySelection);
    console.log(paramOperation + "&" + paramCityName + "&" + paramEmployeeId + "&" + paramFirstName + "&" + paramLastName
        + "&" + paramDesiredDaySelection + "&" + paramSelectedShiftStartTime + "&" + paramSelectedShiftEndTime);

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("POST", backendURL, true);
    // Set request header, otherwise AJAX call won't work.
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send(paramOperation + "&" + paramCityName + "&" + paramEmployeeId + "&" + paramFirstName + "&" + paramLastName
        + "&" + paramDesiredDaySelection + "&" + paramSelectedShiftStartTime + "&" + paramSelectedShiftEndTime);

    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {

            // console.log(this.responseText);

            var employees = JSON.parse(this.responseText);

            displayEmployees(employees, firstName, lastName);

            // Always reset disabled status of btnAssignEmployee
            $("#btnAssignEmployee").attr("disabled", false);
            selectedEmployeeId = null;
            // Check whether employees are found
            // console.log("employees: " + (employees.employees.length == 0));
            if (employees.employees.length == 0) {
                $("#errorDisplayInModal").html("<p class='text-danger font-weight-bold'>No employee is found</p>");
            } else {
                $("#btnAssignEmployee").attr("disabled", false);
            }
        }
    }
}

function cleanFormInModal() {
    $("#employeeId").val('');
    $("#firstName").val('');
    $("#lastName").val('');
    $("input[name='employeeDesiredDay']").prop('checked', false);
    $("input[id='selectAllDesiredDays']").prop('checked', false);
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

function displayCompanyLocations(companyLocations) {

    var companyLocationOption = "<option value=\"\" selected>Select Location</option>";

    $.each(companyLocations.companylocations, function (key, value) {
//            console.log(key, value);
        companyLocationOption += "<option value=\"" + value.CompanyLocationId + "\">" + value.Address + "</option>"
    });

//        console.log("companyLocationOption" + companyLocationOption);
    $("#companyLocationSelection").html(companyLocationOption);
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
        shiftsTable += "<td class='assignedBy'>" + ((value.AssignedBy != null) ? value.AssignedBy : "") + "</td>";
        shiftsTable += "<td class='assignedTo'>" + ((value.AssignedTo != null) ? value.AssignedTo : "") + "</td>";
        shiftsTable += "<td>" + value.Address + "</td>";
        shiftsTable += "<td>" + value.empDesignationName + "</td>";
        shiftsTable += "<td class='shiftStartTime'>" + value.StartTime + "</td>";
        shiftsTable += "<td class='shiftEndTime'>" + value.EndTime + "</td>";
        shiftsTable += "<td>" + convertShiftStatusFromCharToString(value.ShiftStatus) + "</td>";
        shiftsTable += "<tr>";
    });

    shiftsTable += "</tbody></table>";

    $("#shiftDisplay").html(shiftsTable);

    // Set cursor to hand shape when mouse hover on a row in the table
    $("#shiftDisplay tbody tr").css("cursor", "pointer");
}

function displayAllCities(allCities) {

    var citiesOption = "<option value=\"\" selected>Select City</option>";

    $.each(allCities.cities, function (key, value) {
//            console.log(key, value);
        citiesOption += "<option value=\"" + value.City + "\">" + value.City + "</option>"
    });

//        console.log("citiesOption" + citiesOption);
    $("#citySelection").html(citiesOption);
}

function displayEmployees(employees, firstName, lastName) {

    var EmployeesTable = "<table class=\"table table-condensed\">";
    EmployeesTable += "<thead><tr>";
    EmployeesTable += "<th class='col-sm-1'>ID</th>";
    EmployeesTable += "<th class='col-sm-2'>Fristname</th>";
    EmployeesTable += "<th class='col-sm-2'>Lastname</th>";
    EmployeesTable += "<th class='col-sm-4'>Home Address</th>";
    EmployeesTable += "<th class='col-sm-3'>Desired Day</th>";
    EmployeesTable += "</tr></thead>";
    EmployeesTable += "<tbody>";

    $.each(employees.employees, function (key, value) {
        // console.log(key + " " + value.UserId);
        EmployeesTable += "<tr value=" + value.UserId + ">";
        EmployeesTable += "<td class='col-sm-1'>" + value.UserId + "</td>";
        EmployeesTable += "<td class='col-sm-2'>" + value.FirstName + "</td>";
        EmployeesTable += "<td class='col-sm-2'>" + value.LastName + "</td>";
        EmployeesTable += "<td class='col-sm-4'>" + value.Address + "</td>";
        EmployeesTable += "<td class='col-sm-3'>" + convertDesiredDayFromBitToString(value.DesiredDay) + "</td>";
        EmployeesTable += "<tr>";
    });

    EmployeesTable += "</tbody></table>";

    $("#employeeDisplay").html(EmployeesTable);

    // Set cursor to hand shape when mouse hover on a row in the table
    $("#employeeDisplay tbody tr").css("cursor", "pointer");
}

function assignEmployeeToShift() {

    var paramOperation = "operation=assignEmployeeToShift";
    var paramSelectedShiftId = "selectedShiftId=" + selectedShiftId;
    var paramSelectedEmployeeId = "selectedEmployeeId=" + selectedEmployeeId;
    var paramManagerId = "managerId=" + managerId;

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("POST", backendURL, true);
    // Set request header, otherwise AJAX call won't work.
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send(paramOperation + "&" + paramSelectedShiftId + "&" + paramSelectedEmployeeId + "&" + paramManagerId);

    // console.log(paramOperation + "&" + paramSelectedShiftId + "&" + paramSelectedEmployeeId + "&" + paramManagerId);
    // console.log("selectedShiftStartTime: " + selectedShiftStartTime + " selectedShiftEndTime: " + selectedShiftEndTime);

    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {

            // console.log(this.responseText);
            var status = JSON.parse(this.responseText);
            // console.log("status: " + status.status['success']);

            // Close select employee modal
            $("#selectEmployee").modal('toggle');

            if (status.status['success']) {
                $("#operationResultInfo").html("<p>Successfully assigned the employee</p>");
            } else {
                $("#operationResultInfo").html("<p>Failed to assign the employee</p>");
            }
            // display operationResultDisplay modal
            $("#operationResultDisplay").modal('show');

            // Refresh shift table in the base page
            $("#btnSearchShift").click();

        }
    }
}

function undoAssignEmployee() {

    // console.log("selectedShiftId: " + selectedShiftId);

    var paramOperation = "operation=undoAssignEmployee";
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
                $("#operationResultInfo").html("<p>Employee is removed from selected shift</p>");
            } else {
                $("#operationResultInfo").html("<p>Failed to remove employee from selected shift</p>");
            }
            // display operationResultDisplay modal
            $("#operationResultDisplay").modal('show');

            // Refresh shift table in the base page
            $("#btnSearchShift").click();

        }
    }
}

function convertDesiredDayFromStringToBit(desiredDayInString) {

    // Initalize string as all bits are set to 0
    var desiredDay = '0000000';
    $.each(desiredDayInString, function (key, value) {
        // console.log(key + " " + value);

        switch (value) {
            case 'Mon': {
                desiredDay = '1' + desiredDay.substr(1);
                // console.log(desiredDay);
                break;
            }
            case 'Tue': {
                desiredDay = desiredDay.substr(0, 1) + '1' + desiredDay.substr(2);
                // console.log(desiredDay);
                break;
            }
            case 'Wed': {
                desiredDay = desiredDay.substr(0, 2) + '1' + desiredDay.substr(3);
                break;
            }
            case 'Thur': {
                desiredDay = desiredDay.substr(0, 3) + '1' + desiredDay.substr(4);
                break;
            }
            case 'Fri': {
                desiredDay = desiredDay.substr(0, 4) + '1' + desiredDay.substr(5);
                break;
            }
            case 'Sat': {
                desiredDay = desiredDay.substr(0, 5) + '1' + desiredDay.substr(6);
                break;
            }
            case 'Sun': {
                desiredDay = desiredDay.substr(0, 6) + '1' + desiredDay.substr(7);
                break;
            }
        }
        // console.log(desiredDay);
    });

    return desiredDay;
}

function convertDesiredDayFromBitToString(desiredDayInBit) {

    var desiredDay = [];
    // console.log(desiredDayInBit);
    for (var i = 0; i < desiredDayInBit.length; i++) {

        if (desiredDayInBit.charAt(i) == 1) {

            switch (i) {
                case 0: {
                    desiredDay.push('Mon');
                    break;
                }
                case 1: {
                    desiredDay.push('Tue');
                    break;
                }
                case 2: {
                    desiredDay.push('Wed');
                    break;
                }
                case 3: {
                    desiredDay.push('Thur');
                    break;
                }
                case 4: {
                    desiredDay.push('Fri');
                    break;
                }
                case 5: {
                    desiredDay.push('Sat');
                    break;
                }
                case 6: {
                    desiredDay.push('Sun');
                    break;
                }
            }

        }
    }


    return desiredDay.join(", ");
}

function convertDayNumberToDayString(dayNumber) {

    switch (dayNumber) {
        case 0: {
            return "Sunday";
            break;
        }
        case 1: {
            return "Monday";
            break;
        }
        case 2: {
            return "Tuesday";
            break;
        }
        case 3: {
            return "Wednesday";
            break;
        }
        case 4: {
            return "Thursday";
            break;
        }
        case 5: {
            return "Friday";
            break;
        }
        case 6: {
            return "Saturday";
            break;
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
