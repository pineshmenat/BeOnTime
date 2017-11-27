<!--------------->
<!--By Zhongjie-->
<!--------------->

<?php
// pending convert to PDO
//
include "db_config.php";

$ajaxCallReturn;

$operation = $_POST["operation"];
//$companyId;
//$companyLocationId;
//$startDateFormatted;
//$startTimeFormatted;
//$endDateFormatted;
//$endTimeFormatted;
//$cityName;

// Get value if key exists in $_POST
//
if (array_key_exists('companyId', $_POST)) {
    $companyId = $_POST['companyId'];
}
if (array_key_exists('companyLocationId', $_POST)) {
    $companyLocationId = $_POST['companyLocationId'];
}
if (array_key_exists('startDateFormatted', $_POST)) {
    $startDateFormatted = $_POST['startDateFormatted'];
}
if (array_key_exists('startTimeFormatted', $_POST)) {
    $startTimeFormatted = $_POST['startTimeFormatted'];
}
if (array_key_exists('endDateFormatted', $_POST)) {
    $endDateFormatted = $_POST['endDateFormatted'];
}
if (array_key_exists('endTimeFormatted', $_POST)) {
    $endTimeFormatted = $_POST['endTimeFormatted'];
}
if (array_key_exists('cityName', $_POST)) {
    $cityName = $_POST['cityName'];
}
if (array_key_exists('employeeId', $_POST)) {
    $employeeId = $_POST['employeeId'];
}
if (array_key_exists('firstName', $_POST)) {
    $firstName = $_POST['firstName'];
}
if (array_key_exists('lastName', $_POST)) {
    $lastName = $_POST['lastName'];
}
if (array_key_exists('desiredDaySelection', $_POST)) {
    $desiredDaySelection = $_POST['desiredDaySelection'];
}


// Interaction with DB based on different operation keywords
//
switch ($operation) {
    case "searchAllCompanys": {

        // Use function in order to make variables local in the function
        // so that can avoid reuse of many variables with same name and to make program easy to troubleshoot.
        //
        $ajaxCallReturn = searchAllCompany($dbConnection);

        break;
    }
    case "searchCompanyLocation": {

        $ajaxCallReturn = searchCompanyLocation($dbConnection, $companyId);

        break;
    }
    case "searchShift": {

        $ajaxCallReturn = searchShift($dbConnection, $companyId, $companyLocationId, $startDateFormatted, $startTimeFormatted,
            $endDateFormatted, $endTimeFormatted);

        break;
    }
    case "searchAllCities": {

        $ajaxCallReturn = searchAllCities($dbConnection);

        break;
    }
    case "searchEmployees": {

        $ajaxCallReturn = searchEmployees($dbConnection, $cityName, $employeeId, $firstName, $lastName, $desiredDaySelection);

        break;
    }
    default: {
        $ajaxCallReturn = "<p>ERROR happened.</p>";
        break;
    }
}

function searchAllCompany($dbConnection) {

    // This is a default query from frontend page manager_assign_shift.php.
    // Every time when frontend page gets loaded, it will makes an AJAX call to search company.
    // Search company in order to fill out company dropdown selection in manager_assign_shift.php
    //
    $selectCompanySQL = "SELECT DISTINCT * FROM companymaster ORDER BY CompanyId";
    $queryResult = mysqli_query($dbConnection, $selectCompanySQL);

    // Always add first option line as a description of dropdown selection
    //
    $ajaxCallReturn = "<option value=\"\">Company List</option>";

    while ($row = $queryResult->fetch_assoc()) {
        $companyName = $row['CompanyName'];
        $companyId = $row['CompanyId'];
        $ajaxCallReturn .= "<option value=\"$companyId\">" . $companyName . "</option>";
    }

    return $ajaxCallReturn;
}

function searchCompanyLocation($dbConnection, $companyId) {

    // When user selects a company from company dropdown selection, frontend page manager_assign_shift.php will send a new AJAX call
    // to search all locations related with the selected company.
    //
    if (isset($companyId)) {

        $selectCompanyLocationSQL = "SELECT DISTINCT * FROM companylocationmaster WHERE CompanyId='$companyId' ORDER BY CompanyLocationId";
        $queryResult = mysqli_query($dbConnection, $selectCompanyLocationSQL);

        // Always add first option line as a description of dropdown selection
        // NOTE: Leave value blank, otherwise method $("#company_location_selection").val() will give me text rather than value of option in javascript in frontend page
        //
        $ajaxCallReturn = "<option value=\"\">Company Location List</option>";

        while ($row = $queryResult->fetch_assoc()) {
            $address = $row['Address'];
            $companyLocationId = $row['CompanyLocationId'];
            $ajaxCallReturn .= "<option value=\"$companyLocationId\">" . $address . "</option>";
        }
    }

    return $ajaxCallReturn;
}

function searchShift($dbConnection, $companyId, $companyLocationId, $startDateFormatted, $startTimeFormatted,
                     $endDateFormatted, $endTimeFormatted) {

    // NOTE: If companyLocationId is not given, it would be "" here. So it should be always set.
    if (isset($companyId) && isset($companyLocationId) && isset($startDateFormatted) && isset($startTimeFormatted)
        && isset($endDateFormatted) && isset($endTimeFormatted)) {

        // NOTE: Line (shiftmaster.CompanyLocationId = '$companyLocationId' OR '$companyLocationId' = '') means even if $companyLocationId is "",
        // sql query will get all locations from DB.
        $select_shift_sql =
            "SELECT shiftmaster.ShiftId, usermaster.UserName, companymaster.CompanyName, companylocationmaster.Address, shiftmaster.StartTime, shiftmaster.EndTime
                  FROM usermaster 
                      JOIN shiftmaster ON (usermaster.UserId = shiftmaster.AssignedBy) 
                      JOIN companymaster ON (companymaster.CompanyId = shiftmaster.CompanyId) 
                      JOIN companylocationmaster ON (companylocationmaster.CompanyLocationId = shiftmaster.CompanyLocationId) 
                  WHERE shiftmaster.CompanyId='$companyId' 
                      AND (shiftmaster.CompanyLocationId = '$companyLocationId' OR '$companyLocationId' = '') 
                      AND (StartTime >= CONCAT('$startDateFormatted', ' ', '$startTimeFormatted')) 
                      AND (EndTime <= CONCAT('$endDateFormatted', ' ', '$endTimeFormatted')) 
                  ORDER BY shiftmaster.ShiftId";

//        error_log("******select_shift_sql: " . $select_shift_sql);

        $queryResult = mysqli_query($dbConnection, $select_shift_sql);

        // Always add below lines as a table header.
        $ajaxCallReturn = "<table class=\"table table-striped table-condensed\">";
        $ajaxCallReturn .= "<thead><tr>";
        $ajaxCallReturn .= "<th class=\"first_column\"><input type=\"checkbox\" id=\"selectAllShifts\"></th>";
        $ajaxCallReturn .= "<th>Shift Id</th>";
        $ajaxCallReturn .= "<th>Assigned By</th>";
        $ajaxCallReturn .= "<th>Company Name</th>";
        $ajaxCallReturn .= "<th>Company Location</th>";
        $ajaxCallReturn .= "<th>Start Time</th>";
        $ajaxCallReturn .= "<th>End Time</th>";
        $ajaxCallReturn .= "</tr></thead>";
        $ajaxCallReturn .= "<tbody>";

        while ($row = $queryResult->fetch_assoc()) {
            $shiftId = $row['ShiftId'];
            $userName = $row['UserName']; // UserName = AssignedBy
            $companyName = $row['CompanyName'];
            $address = $row['Address'];
            $startTime = $row['StartTime'];
            $endTime = $row['EndTime'];

            $ajaxCallReturn .= "<tr>";
            $ajaxCallReturn .= "<td class=\"first_column\"><input type=\"checkbox\" name=\"shiftList\" value=\"" . $shiftId . "\"></td>";
            $ajaxCallReturn .= "<td>" . $shiftId . "</td>";
            $ajaxCallReturn .= "<td>" . $userName . "</td>";
            $ajaxCallReturn .= "<td>" . $companyName . "</td>";
            $ajaxCallReturn .= "<td>" . $address . "</td>";
            $ajaxCallReturn .= "<td>" . $startTime . "</td>";
            $ajaxCallReturn .= "<td>" . $endTime . "</td>";
            $ajaxCallReturn .= "</tr>";
        }

        $ajaxCallReturn .= "</tbody>";
        $ajaxCallReturn .= "</table>";
    }

    return $ajaxCallReturn;
}

function searchAllCities($dbConnection) {

    // Every time when modal in frontend page gets loaded, it will makes an AJAX call to search city.
    // Search city in order to fill out city dropdown selection in the modal in manager_assign_shift.php
    //
    $selectCompanySQL = "SELECT DISTINCT City FROM usermaster ORDER BY City";
    $queryResult = mysqli_query($dbConnection, $selectCompanySQL);

    // Always add first option line as a description of dropdown selection
    //
    $ajaxCallReturn = "<option value=\"\">City List</option>";

    while ($row = $queryResult->fetch_assoc()) {
        $cityName = $row['City'];
        $ajaxCallReturn .= "<option value=\"$cityName\">" . $cityName . "</option>";
    }

    return $ajaxCallReturn;
}

function searchEmployees($dbConnection, $cityName, $employeeId, $firstName, $lastName, $desiredDaySelection) {

    if (isset($cityName) && isset($employeeId) && isset($firstName) && isset($lastName) && isset($desiredDaySelection)) {
//        error_log("cityName: " . $cityName . " employeeId: " . $employeeId . " firstName: " . $firstName . " lastName: " . $lastName);
//        error_log("desiredDaySelection: " . $desiredDaySelection);

        $desiredDay = convertDesiredDayFromStringToBit($desiredDaySelection);

        // NOTE: RoleId=12 indicates Employee role.
        $select_employees_sql =
            "SELECT UserId, UserName, Address, DesiredDay 
              FROM usermaster 
              WHERE RoleId = 12 
                  AND City = '$cityName' 
                  AND DesiredDay = '$desiredDay' 
                  AND (UserId = '$employeeId' OR '$employeeId' = '') 
                  AND (FirstName = '$firstName' OR '$firstName' = '') 
                  AND (LastName = '$lastName' OR '$lastName' = '')";

//        error_log("******select_employees_sql: " . $select_employees_sql);

        $queryResult = mysqli_query($dbConnection, $select_employees_sql);

        // Always add below lines as a table header.
        $ajaxCallReturn = "<table class=\"table table-head-fixed\">";
        $ajaxCallReturn .= "<thead><tr>";
        $ajaxCallReturn .= "<th class=\"col-xs-1\">&nbsp;</th>";
        $ajaxCallReturn .= "<th class=\"col-xs-1\">UserId</th>";
        $ajaxCallReturn .= "<th class=\"col-xs-2\">UserName</th>";
        $ajaxCallReturn .= "<th class=\"col-xs-4\">Address</th>";
        $ajaxCallReturn .= "<th class=\"col-xs-4\">Desired Day</th>";
        $ajaxCallReturn .= "</tr></thead>";
        $ajaxCallReturn .= "<tbody>";

        while ($row = $queryResult->fetch_assoc()) {
            $userId = $row['UserId'];
            $userName = $row['UserName']; // UserName = AssignedBy
            $address = $row['Address'];
            $desiredDay = $row['DesiredDay'];
            $desiredDay = convertDesiredDayFromBitToString($desiredDay);

            $ajaxCallReturn .= "<tr>";
            $ajaxCallReturn .= "<td class=\"col-xs-1 first_column\"><input type=\"radio\" name=\"EmployeeList\" value=\"" . $userId . "\"></td>";
            $ajaxCallReturn .= "<td class=\"col-xs-1\">" . $userId . "</td>";
            $ajaxCallReturn .= "<td class=\"col-xs-2\">" . $userName . "</td>";
            $ajaxCallReturn .= "<td class=\"col-xs-4\">" . $address . "</td>";
            $ajaxCallReturn .= "<td class=\"col-xs-4\">" . $desiredDay . "</td>";
            $ajaxCallReturn .= "</tr>";
        }

        $ajaxCallReturn .= "</tbody>";
        $ajaxCallReturn .= "</table>";
    }

    return $ajaxCallReturn;
}

function convertDesiredDayFromBitToString($desiredDay) {

    $desiredDayFormatted = [];

//    error_log("desiredDay: " . $desiredDay);

    // The $desiredDay bit order is Mon, Tue, Wed, Thur, Fri, Sat and Sun
    for ($i = 0; $i < strlen($desiredDay); $i++) {

        switch ($i) {
            case 0: {
                if ($desiredDay[$i]) {
                    array_push($desiredDayFormatted, 'Mon');
                }
                break;
            }
            case 1: {
                if ($desiredDay[$i]) {
                    array_push($desiredDayFormatted, 'Tue');
                }
                break;
            }
            case 2: {
                if ($desiredDay[$i]) {
                    array_push($desiredDayFormatted, 'Wed');
                }
                break;
            }
            case 3: {
                if ($desiredDay[$i]) {
                    array_push($desiredDayFormatted, 'Thur');
                }
                break;
            }
            case 4: {
                if ($desiredDay[$i]) {
                    array_push($desiredDayFormatted, 'Fri');
                }
                break;
            }
            case 5: {
                if ($desiredDay[$i]) {
                    array_push($desiredDayFormatted, 'Sat');
                }
                break;
            }
            case 6: {
                if ($desiredDay[$i]) {
                    array_push($desiredDayFormatted, 'Sun');
                }
                break;
            }
        }
    }
    return implode(', ', $desiredDayFormatted);
}

function convertDesiredDayFromStringToBit($desiredDaySelection) {

    // Initalize string as all bits are set to 0
    $desiredDay = '0000000';
    $desiredDaySelectionInArray = explode(',', $desiredDaySelection);
//    var_dump($desiredDaySelectionInArray);
    for($i = 0; $i < sizeof($desiredDaySelectionInArray); $i++) {
        switch ($desiredDaySelectionInArray[$i]) {
            case 'Mon': {
                $bit = 0; break;
            }
            case 'Tue': {
                $bit = 1; break;
            }
            case 'Wed': {
                $bit = 2; break;
            }
            case 'Thur': {
                $bit = 3; break;
            }
            case 'Fri': {
                $bit = 4; break;
            }
            case 'Sat': {
                $bit = 5; break;
            }
            case 'Sun': {
                $bit = 6; break;
            }
        }
        $desiredDay[$bit] = '1';
    }

//    error_log("desiredDay: " . $desiredDay);
    return $desiredDay;
}

mysqli_close($dbConnection);

echo $ajaxCallReturn;

?>