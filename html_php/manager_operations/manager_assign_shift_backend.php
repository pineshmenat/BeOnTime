<?php
//
// By Zhongjie
//
include "../db_config.php";

$dbConnection = DB::getDBConnection();
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
    case "searchAllCompanies": {

        // Use function in order to make variables local in the function
        // so that can avoid reuse of many variables with same name and to make program easy to troubleshoot.
        //
        $ajaxCallReturn = searchAllCompanies($dbConnection);

        break;
    }
    case "searchCompanyLocations": {

        $ajaxCallReturn = searchCompanyLocations($dbConnection, $companyId);

        break;
    }
    case "searchShifts": {

        $ajaxCallReturn = searchShifts($dbConnection, $companyId, $companyLocationId, $startDateFormatted, $startTimeFormatted,
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

$dbConnection = null;

header('Content-Type: application/json');

echo $ajaxCallReturn;

?>


<?php
//
// Functions
//
function searchAllCompanies($dbConnection) {

    // This is a default query from frontend page manager_assign_shift.php.
    // Every time when frontend page gets loaded, it will makes an AJAX call to search company.
    // Search company in order to fill out company dropdown selection in manager_assign_shift.php
    //
    $selectCompanySQL = "SELECT DISTINCT * FROM companymaster ORDER BY CompanyId";
    $pdpstm = $dbConnection->prepare($selectCompanySQL);
    $pdpstm->execute();
    $pdpstm->setFetchMode(PDO::FETCH_OBJ);
//    var_dump($pdpstm);

    $resultSet = $pdpstm->fetchAll();

    $ajaxCallReturn = json_encode(array("companies" => $resultSet));

    return $ajaxCallReturn;
}

function searchCompanyLocations($dbConnection, $companyId) {

    $ajaxCallReturn = "";
    // When user selects a company from company dropdown selection, frontend page manager_assign_shift.php will send a new AJAX call
    // to search all locations related with the selected company.
    //
    if (isset($companyId)) {

        $selectCompanyLocationSQL = "SELECT * FROM companylocationmaster WHERE CompanyId = :companyId ORDER BY CompanyLocationId";
        $pdpstm = $dbConnection->prepare($selectCompanyLocationSQL);
        $pdpstm->bindValue(':companyId', $companyId, PDO::PARAM_STR);
        $pdpstm->execute();
        $pdpstm->setFetchMode(PDO::FETCH_OBJ);
//    var_dump($pdpstm);

        $resultSet = $pdpstm->fetchAll();

        $ajaxCallReturn = json_encode(array("companylocations" => $resultSet));
    }
    return $ajaxCallReturn;
}

function searchShifts($dbConnection, $companyId, $companyLocationId, $startDateFormatted, $startTimeFormatted,
                      $endDateFormatted, $endTimeFormatted) {

    $ajaxCallReturn = "";

    // NOTE: If companyLocationId is not given, it would be "" here. So it should be always set.
    if (isset($companyId) && isset($companyLocationId) && isset($startDateFormatted) && isset($startTimeFormatted)
        && isset($endDateFormatted) && isset($endTimeFormatted)) {

//        error_log("companyId: " . $companyId . " companyLocationId: " . $companyLocationId
//             . " startDateFormatted: " . $startDateFormatted . " startTimeFormatted: " . $startTimeFormatted
//             . " endDateFormatted: " . $endDateFormatted . " endTimeFormatted: " . $endTimeFormatted);

        // NOTE: Line (shiftmaster.CompanyLocationId = '$companyLocationId' OR '$companyLocationId' = '') means even if $companyLocationId is "",
        // sql query will get all locations from DB.
        $selectShiftSQL =
            "SELECT shiftmaster.ShiftId, u1.UserName AssignedBy, u2.Username AssignedTo, companymaster.CompanyName, companylocationmaster.Address, shiftmaster.StartTime, shiftmaster.EndTime
                  FROM shiftmaster 
                      JOIN usermaster u1 ON (u1.UserId = shiftmaster.AssignedBy) 
                      JOIN usermaster u2 ON (u2.UserId = shiftmaster.AssignedTo) 
                      JOIN companymaster ON (companymaster.CompanyId = shiftmaster.CompanyId) 
                      JOIN companylocationmaster ON (companylocationmaster.CompanyLocationId = shiftmaster.CompanyLocationId) 
                  WHERE shiftmaster.CompanyId = :companyId 
                      AND (shiftmaster.CompanyLocationId = :companyLocationId OR :companyLocationId = '') 
                      AND (StartTime >= CONCAT(:startDateFormatted, ' ', :startTimeFormatted)) 
                      AND (EndTime <= CONCAT(:endDateFormatted, ' ', :endTimeFormatted)) 
                  ORDER BY shiftmaster.ShiftId";

//        error_log("******selectShiftSQL: " . $selectShiftSQL);

        $pdpstm = $dbConnection->prepare($selectShiftSQL);
        $pdpstm->bindValue(':companyId', $companyId, PDO::PARAM_STR);
        $pdpstm->bindValue(':companyLocationId', $companyLocationId, PDO::PARAM_STR);
        $pdpstm->bindValue(':startDateFormatted', $startDateFormatted, PDO::PARAM_STR);
        $pdpstm->bindValue(':startTimeFormatted', $startTimeFormatted, PDO::PARAM_STR);
        $pdpstm->bindValue(':endDateFormatted', $endDateFormatted, PDO::PARAM_STR);
        $pdpstm->bindValue(':endTimeFormatted', $endTimeFormatted, PDO::PARAM_STR);
//        error_log("*******pdpstm: " . print_r($pdpstm, true));
        $pdpstm->execute();
        $pdpstm->setFetchMode(PDO::FETCH_OBJ);
//    var_dump($pdpstm);

        $resultSet = $pdpstm->fetchAll();

        $ajaxCallReturn = json_encode(array("shifts" => $resultSet));
    }

    return $ajaxCallReturn;
}

function searchAllCities($dbConnection) {

    // Every time when modal in frontend page gets loaded, it will makes an AJAX call to search city.
    // Search city in order to fill out city dropdown selection in the modal in manager_assign_shift.php
    //
    $selectCitiesSQL = "SELECT DISTINCT City FROM usermaster ORDER BY City";
    $pdpstm = $dbConnection->prepare($selectCitiesSQL);
    $pdpstm->execute();
    $pdpstm->setFetchMode(PDO::FETCH_OBJ);
//    var_dump($pdpstm);

    $resultSet = $pdpstm->fetchAll();

    $ajaxCallReturn = json_encode(array("cities" => $resultSet));

    return $ajaxCallReturn;
}

function searchEmployees($dbConnection, $cityName, $employeeId, $firstName, $lastName, $desiredDaySelection) {

    if (isset($cityName) && isset($employeeId) && isset($firstName) && isset($lastName) && isset($desiredDaySelection)) {
        error_log("cityName: " . $cityName . " employeeId: " . $employeeId . " firstName: " . $firstName . " lastName: " . $lastName);
        error_log("desiredDaySelection: " . $desiredDaySelection);

//        $desiredDay = convertDesiredDayFromStringToBit($desiredDaySelection);

        // NOTE: RoleId=12 indicates Employee role.
        $selectEmployeesSQL =
            "SELECT UserId, UserName, Address, DesiredDay 
              FROM usermaster 
              WHERE RoleId = 12 
                  AND City = :cityName 
                  AND (DesiredDay = :desiredDaySelection OR :desiredDaySelection = '') 
                  AND (UserId = :employeeId OR :employeeId = '') 
                  AND (FirstName = :firstName OR :firstName = '') 
                  AND (LastName = :lastName OR :lastName = '')";

//        error_log("******select_employees_sql: " . $select_employees_sql);
        $pdpstm = $dbConnection->prepare($selectEmployeesSQL);
        $pdpstm->bindValue(':cityName', $cityName , PDO::PARAM_STR);
        $pdpstm->bindValue(':desiredDaySelection', $desiredDaySelection , PDO::PARAM_STR);
        $pdpstm->bindValue(':employeeId', $employeeId , PDO::PARAM_STR);
        $pdpstm->bindValue(':firstName', $firstName , PDO::PARAM_STR);
        $pdpstm->bindValue(':lastName', $lastName , PDO::PARAM_STR);
        $pdpstm->execute();
        $pdpstm->setFetchMode(PDO::FETCH_OBJ);
//    var_dump($pdpstm);
//        error_log("pdpstm: " . print_r($pdpstm));

        $resultSet = $pdpstm->fetchAll();

        $ajaxCallReturn = json_encode(array("employees" => $resultSet));
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

//function convertDesiredDayFromStringToBit($desiredDaySelection) {
//
//    // Initalize string as all bits are set to 0
//    $desiredDay = '0000000';
//    $desiredDaySelectionInArray = explode(',', $desiredDaySelection);
////    var_dump($desiredDaySelectionInArray);
//    for ($i = 0; $i < sizeof($desiredDaySelectionInArray); $i++) {
//        switch ($desiredDaySelectionInArray[$i]) {
//            case 'Mon': {
//                $bit = 0;
//                break;
//            }
//            case 'Tue': {
//                $bit = 1;
//                break;
//            }
//            case 'Wed': {
//                $bit = 2;
//                break;
//            }
//            case 'Thur': {
//                $bit = 3;
//                break;
//            }
//            case 'Fri': {
//                $bit = 4;
//                break;
//            }
//            case 'Sat': {
//                $bit = 5;
//                break;
//            }
//            case 'Sun': {
//                $bit = 6;
//                break;
//            }
//        }
//        $desiredDay[$bit] = '1';
//    }
//
////    error_log("desiredDay: " . $desiredDay);
//    return $desiredDay;
//}


?>