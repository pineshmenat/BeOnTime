<?php
//
// By Zhongjie
//
use PHPMailer\PHPMailer\PHPMailer;
//use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\OAuth;
use League\OAuth2\Client\Provider\Google;

include "../model/db_config.php";
require '../../assets/composer/vendor/autoload.php';

$dbConnection = DB::getDBConnection();
$ajaxCallReturn;

$operation = $_POST["operation"];

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
if (array_key_exists('managerId', $_POST)) {
    $managerId = $_POST['managerId'];
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
if (array_key_exists('selectedShiftId', $_POST)) {
    $selectedShiftId = $_POST['selectedShiftId'];
}
if (array_key_exists('selectedEmployeeId', $_POST)) {
    $selectedEmployeeId = $_POST['selectedEmployeeId'];
}
if (array_key_exists('selectedShiftStartTime', $_POST)) {
    $selectedShiftStartTime = $_POST['selectedShiftStartTime'];
}
if (array_key_exists('selectedShiftEndTime', $_POST)) {
    $selectedShiftEndTime = $_POST['selectedShiftEndTime'];
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

        $ajaxCallReturn = searchEmployees($dbConnection, $cityName, $employeeId, $firstName, $lastName, $desiredDaySelection, $selectedShiftStartTime, $selectedShiftEndTime);

        break;
    }
    case  "assignEmployeeToShift": {

        $ajaxCallReturn = assignEmployeeToShift($dbConnection, $selectedShiftId, $selectedEmployeeId, $managerId);

        break;
    }
    case  "undoAssignEmployee": {

        $ajaxCallReturn = undoAssignEmployee($dbConnection, $selectedShiftId);

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

        error_log("companyId: " . $companyId . " companyLocationId: " . $companyLocationId
             . " startDateFormatted: " . $startDateFormatted . " startTimeFormatted: " . $startTimeFormatted
             . " endDateFormatted: " . $endDateFormatted . " endTimeFormatted: " . $endTimeFormatted);

        // NOTE: Line (shiftmaster.CompanyLocationId = '$companyLocationId' OR '$companyLocationId' = '') means even if $companyLocationId is "",
        // sql query will get all locations from DB.
        $selectShiftSQL =
            "SELECT shiftmaster.ShiftId, u1.UserName AssignedBy, u2.UserName AssignedTo, companylocationmaster.Address, 
                    employeedesignationmaster.empDesignationName, shiftmaster.StartTime, shiftmaster.EndTime, shiftmaster.ShiftStatus 
                  FROM shiftmaster 
                      LEFT JOIN usermaster u1 ON (u1.UserId = shiftmaster.AssignedBy) 
                      LEFT JOIN usermaster u2 ON (u2.UserId = shiftmaster.AssignedTo) 
                      JOIN companymaster ON (companymaster.CompanyId = shiftmaster.CompanyId) 
                      JOIN companylocationmaster ON (companylocationmaster.CompanyLocationId = shiftmaster.CompanyLocationId) 
                      JOIN employeedesignationmaster ON (employeedesignationmaster.empDesignationId = shiftmaster.empDesignationId) 
                  WHERE shiftmaster.CompanyId = :companyId 
                      AND (shiftmaster.CompanyLocationId = :companyLocationId OR :companyLocationId = '') 
                      AND (StartTime >= CONCAT(:startDateFormatted, ' ', :startTimeFormatted)) 
                      AND (EndTime <= CONCAT(:endDateFormatted, ' ', :endTimeFormatted)) 
                      AND (ShiftStatus = 'N' || ShiftStatus = 'R') 
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

function searchEmployees($dbConnection, $cityName, $employeeId, $firstName, $lastName, $desiredDaySelection, $selectedShiftStartTime, $selectedShiftEndTime) {

    if (isset($cityName) && isset($employeeId) && isset($firstName) && isset($lastName) && isset($desiredDaySelection)) {
//        error_log("cityName: " . $cityName . " employeeId: " . $employeeId . " firstName: " . $firstName . " lastName: " . $lastName);
//        error_log("desiredDaySelection: " . $desiredDaySelection);
        error_log("selectedShiftStartTime: " . $selectedShiftStartTime . " selectedShiftEndTime: " . $selectedShiftEndTime);

        $desiredDaySelection = str_replace('0', '_', $desiredDaySelection);
//        error_log("desiredDaySelection: " . $desiredDaySelection);

        // NOTE: RoleId=12 indicates Employee role.
        // NOTE: starttime minus 1 hour and endtime add 1 hour. This is to give time for employee to travel to next work place.
        $selectEmployeesSQL =
            "SELECT u.UserId, u.FirstName, u.LastName, u.Address, u.DesiredDay 
                FROM usermaster u 
              WHERE u.RoleId = 12 
                AND u.City = :cityName 
                AND (u.UserId = :employeeId OR :employeeId = '') 
                AND (u.FirstName = :firstName OR :firstName = '') 
                AND (u.LastName = :lastName OR :lastName = '') 
                AND (u.DesiredDay LIKE :desiredDay) 
                AND u.UserId NOT IN (SELECT DISTINCT u.UserId 
                                    FROM usermaster u 
                                      JOIN shiftmaster s ON (u.UserId = s.AssignedTo) 
                                    WHERE u.RoleId = 12 
                                      AND (s.StartTime BETWEEN DATE_ADD(:selectedShiftStartTime, INTERVAL -1 HOUR) AND DATE_ADD(:selectedShiftEndTime, INTERVAL 1 HOUR)) 
                                      AND (s.EndTime BETWEEN DATE_ADD(:selectedShiftStartTime, INTERVAL -1 HOUR) AND DATE_ADD(:selectedShiftEndTime, INTERVAL 1 HOUR)))";

//        error_log("******select_employees_sql: " . $selectEmployeesSQL);
        $pdpstm = $dbConnection->prepare($selectEmployeesSQL);
        $pdpstm->bindValue(':cityName', $cityName, PDO::PARAM_STR);
        $pdpstm->bindValue(':employeeId', $employeeId, PDO::PARAM_STR);
        $pdpstm->bindValue(':firstName', $firstName, PDO::PARAM_STR);
        $pdpstm->bindValue(':lastName', $lastName, PDO::PARAM_STR);
        $pdpstm->bindValue(':desiredDay', $desiredDaySelection, PDO::PARAM_STR);
        $pdpstm->bindValue(':selectedShiftStartTime', $selectedShiftStartTime, PDO::PARAM_STR);
        $pdpstm->bindValue(':selectedShiftEndTime', $selectedShiftEndTime, PDO::PARAM_STR);
        $pdpstm->execute();
        $pdpstm->setFetchMode(PDO::FETCH_OBJ);
//    var_dump($pdpstm);
//        error_log("pdpstm: " . print_r($pdpstm));

        $resultSet = $pdpstm->fetchAll();

        $ajaxCallReturn = json_encode(array("employees" => $resultSet));
    }

    return $ajaxCallReturn;
}

function assignEmployeeToShift($dbConnection, $selectedShiftId, $selectedEmployeeId, $managerId) {

    $ajaxCallReturn = "";
    $response = [];

    try {
        if (isset($selectedShiftId) && isset($selectedEmployeeId) && isset($managerId)) {

            $assignEmployeeToShiftSQL = "UPDATE shiftmaster 
                                          SET AssignedBy=:managerId, AssignedTo=:selectedEmployeeId, ShiftStatus='N' 
                                          WHERE ShiftId=:selectedShiftId";
            $pdpstm = $dbConnection->prepare($assignEmployeeToShiftSQL);
            $pdpstm->bindValue(':selectedEmployeeId', $selectedEmployeeId, PDO::PARAM_STR);
            $pdpstm->bindValue(':selectedShiftId', $selectedShiftId, PDO::PARAM_STR);
            $pdpstm->bindValue(':managerId', $managerId, PDO::PARAM_STR);

            $response['success'] = false;

            if ($pdpstm->execute()) {
                $response['success'] = true;

                // Get user info
                $userInfoResponse = getUserInfo($dbConnection, $selectedEmployeeId);
                $firstName = $userInfoResponse['FirstName'];
                $lastName = $userInfoResponse['LastName'];
                $eMail = $userInfoResponse['EMail'];

                // Get shift info
                $shiftInfoResponse = getShiftInfo($dbConnection, $selectedShiftId);
                $shiftId = $selectedShiftId;
                $companyName = $shiftInfoResponse['CompanyName'];
                $address = $shiftInfoResponse['Address'];
                $startTime = $shiftInfoResponse['StartTime'];
                $endTime = $shiftInfoResponse['EndTime'];

//                error_log("firstName: " . $firstName . " lastName: " . $lastName . " eMail: " . $eMail);

                // Specify email subject and body
                $eMailSubject = '[BeOnTime][Employee] New Shift Notification';
                $eMailBody = "<html>"
                    . "Dear " . ucwords($firstName) . ' ' . ucwords($lastName) . ",<br/><br/>"
                    . "You have a new shift. <br/><br/>"
                    . "Shift Id: <b>" . $shiftId . "</b><br/>"
                    . "Company Name: <b>" . $companyName . "</b><br/>"
                    . "Address: <b>" . $address . "</b><br/>"
                    . "Shift Start Time: <b>" . $startTime . "</b><br/>"
                    . "Shift End Time: <b>" . $endTime . "</b><br/><br/>"
                    . "Regards,<br/>BeOnTime project group"
                    . "</html>";

                // If email is not null and valid, send notification email
                if (isset($eMail) && filter_var($eMail, FILTER_VALIDATE_EMAIL)) {
                    sendNotificationEmail($eMailSubject, $eMailBody, $firstName, $lastName, $eMail);
                }
            }

            $ajaxCallReturn = json_encode(array("status" => $response));
        }
    } catch (Exception $e) {

        $response['success'] = false;
        $ajaxCallReturn = json_encode(array("status" => $response));
    }
    return $ajaxCallReturn;
}

function undoAssignEmployee($dbConnection, $selectedShiftId) {

    $ajaxCallReturn = "";
    $response = [];

//    error_log("selectedShiftId in undoAssignEmployee(): " . $selectedShiftId);

    try {
        if (isset($selectedShiftId)) {

            // Get shift & employee info BEFORE remove AssignTo for a shift
            $shiftAndEmployeeInfoResponse = getShiftAndEmployeeInfo($dbConnection, $selectedShiftId);
//            error_log("shiftInfoResponse: " . print_r($shiftInfoResponse));

            $undoAssignEmployeeSQL = "UPDATE shiftmaster SET AssignedBy=NULL, AssignedTo=NULL WHERE ShiftId=:selectedShiftId";
            $pdpstm = $dbConnection->prepare($undoAssignEmployeeSQL);
            $pdpstm->bindValue(':selectedShiftId', $selectedShiftId, PDO::PARAM_STR);

            $response['success'] = false;

            if ($pdpstm->execute()) {
                $response['success'] = true;

                // If employee removal is successful, send a notification email
                $shiftId = $selectedShiftId;
                $companyName = $shiftAndEmployeeInfoResponse['CompanyName'];
                $address = $shiftAndEmployeeInfoResponse['Address'];
                $startTime = $shiftAndEmployeeInfoResponse['StartTime'];
                $endTime = $shiftAndEmployeeInfoResponse['EndTime'];
                $eMail = $shiftAndEmployeeInfoResponse['EMail'];
                $firstName = $shiftAndEmployeeInfoResponse['FirstName'];
                $lastName = $shiftAndEmployeeInfoResponse['LastName'];

                // Specify email subject and body
                $eMailSubject = '[BeOnTime][Employee] Cancel Shift Notification';
                $eMailBody = "<html>"
                    . "Dear " . ucwords($firstName) . ' ' . ucwords($lastName) . ",<br/><br/>"
                    . "Below shift is cancelled. <br/><br/>"
                    . "Shift Id: <b>" . $shiftId . "</b><br/>"
                    . "Company Name: <b>" . $companyName . "</b><br/>"
                    . "Address: <b>" . $address . "</b><br/>"
                    . "Shift Start Time: <b>" . $startTime . "</b><br/>"
                    . "Shift End Time: <b>" . $endTime . "</b><br/><br/>"
                    . "Regards,<br/>BeOnTime project group"
                    . "</html>";

                // If email is not null and valid, send notification email
                if (isset($eMail) && filter_var($eMail, FILTER_VALIDATE_EMAIL)) {
                    sendNotificationEmail($eMailSubject, $eMailBody, $firstName, $lastName, $eMail);
                }
            }

            $ajaxCallReturn = json_encode(array("status" => $response));
        }
    } catch (Exception $e) {

        $response['success'] = false;
        $ajaxCallReturn = json_encode(array("status" => $response));
    }

    return $ajaxCallReturn;
}

function getUserInfo($dbConnection, $selectedEmployeeId) {

    $getUserInfoSQL = "SELECT FirstName, LastName, EMail from usermaster WHERE UserId=:selectedEmployeeId";
    $pdpstm = $dbConnection->prepare($getUserInfoSQL);
    $pdpstm->bindValue(':selectedEmployeeId', $selectedEmployeeId, PDO::PARAM_STR);
    $pdpstm->execute();
    $pdpstm->setFetchMode(PDO::FETCH_OBJ);
//    var_dump($pdpstm);

    $resultSet = $pdpstm->fetchAll();
//    error_log("resultSet: " . print_r($resultSet, true));
//    error_log("FirstName: " . $resultSet[0]->FirstName . " LastName: ". $resultSet[0]->LastName . " EMail: ". $resultSet[0]->EMail);
    $response['FirstName'] = $resultSet[0]->FirstName;
    $response['LastName'] = $resultSet[0]->LastName;
    $response['EMail'] = $resultSet[0]->EMail;
    return $response;
}

function getShiftInfo($dbConnection, $selectedShiftId) {

    $getShiftInfoSQL = "SELECT s.ShiftId, c.CompanyName, cl.Address, s.StartTime, s.EndTime 
                          FROM shiftmaster s 
                          JOIN companymaster c ON(s.CompanyId = c.CompanyId) 
                          JOIN companylocationmaster cl ON(s.CompanyLocationId = cl.CompanyLocationId) 
                          WHERE s.ShiftId=:selectedShiftId";
    $pdpstm = $dbConnection->prepare($getShiftInfoSQL);
    $pdpstm->bindValue(':selectedShiftId', $selectedShiftId, PDO::PARAM_STR);
    $pdpstm->execute();
    $pdpstm->setFetchMode(PDO::FETCH_OBJ);
//    var_dump($pdpstm);

    $resultSet = $pdpstm->fetchAll();
//    error_log("resultSet: " . print_r($resultSet, true));
//    error_log("FirstName: " . $resultSet[0]->FirstName . " LastName: ". $resultSet[0]->LastName . " EMail: ". $resultSet[0]->EMail);
    $response['ShiftId'] = $resultSet[0]->ShiftId;
    $response['CompanyName'] = $resultSet[0]->CompanyName;
    $response['Address'] = $resultSet[0]->Address;
    $response['StartTime'] = $resultSet[0]->StartTime;
    $response['EndTime'] = $resultSet[0]->EndTime;

    return $response;
}

function getShiftAndEmployeeInfo($dbConnection, $selectedShiftId) {

    error_log("selectedShiftId: " . $selectedShiftId);
    $getShiftAndEmployeeInfoSQL = "SELECT s.ShiftId, s.AssignedTo, c.CompanyName, cl.Address, s.StartTime, s.EndTime, u.EMail, u.FirstName, u.LastName  
                          FROM shiftmaster s 
                          JOIN companymaster c ON(s.CompanyId = c.CompanyId) 
                          JOIN companylocationmaster cl ON(s.CompanyLocationId = cl.CompanyLocationId) 
                          JOIN usermaster u ON(s.AssignedTo = u.UserId) 
                          WHERE s.ShiftId=:selectedShiftId";
    $pdpstm = $dbConnection->prepare($getShiftAndEmployeeInfoSQL);
    $pdpstm->bindValue(':selectedShiftId', $selectedShiftId, PDO::PARAM_STR);
    $pdpstm->execute();
    $pdpstm->setFetchMode(PDO::FETCH_OBJ);
//    var_dump($pdpstm);

    $resultSet = $pdpstm->fetchAll();
    error_log("resultSet: " . print_r($resultSet, true));
//    error_log("FirstName: " . $resultSet[0]->FirstName . " LastName: ". $resultSet[0]->LastName . " EMail: ". $resultSet[0]->EMail);
    $response['ShiftId'] = $resultSet[0]->ShiftId;
//    $response['AssignedTo'] = $resultSet[0]->AssignedTo;
    $response['CompanyName'] = $resultSet[0]->CompanyName;
    $response['Address'] = $resultSet[0]->Address;
    $response['StartTime'] = $resultSet[0]->StartTime;
    $response['EndTime'] = $resultSet[0]->EndTime;
    $response['EMail'] = $resultSet[0]->EMail;
    $response['FirstName'] = $resultSet[0]->FirstName;
    $response['LastName'] = $resultSet[0]->LastName;
//error_log("response: " . print_r($response));
    return $response;
}

function sendNotificationEmail($eMailSubject, $eMailBody, $firstName, $lastName, $eMail) {

    error_log("firstName: " . $firstName . " lastName: " . $lastName . "eMail" . $eMail);
    // By using Google OAuth 2.0
    $mail = new PHPMailer;
    $mail->isSMTP();
    $mail->SMTPDebug = 0;
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 587;
    $mail->SMTPSecure = 'tls';
    $mail->SMTPAuth = true;
    $mail->AuthType = 'XOAUTH2';

    $email = 'mail.beontime@gmail.com';
    $clientId = '54609260413-6h0k89v22dej7neoc4hndh2jisos3a4a.apps.googleusercontent.com';
    $clientSecret = 'esvUbmEqrZvXKDz-6RCx11oA';

    $refreshToken = '1/qSqerD_tXh9bCwZyfa0j2vx3zIAWgFNZk2CBekgM9K4Moig2PqRA_Np5daRRAi3n';
    $provider = new Google(['clientId' => $clientId, 'clientSecret' => $clientSecret]);
    $mail->setOAuth(
        new OAuth(
            [
                'provider' => $provider,
                'clientId' => $clientId,
                'clientSecret' => $clientSecret,
                'refreshToken' => $refreshToken,
                'userName' => $email
            ]));
    $mail->setFrom($email, 'BeOnTime Admin');
    $mail->addAddress($eMail, $firstName . ' ' . $lastName);
    $mail->Subject = $eMailSubject;
    $mail->CharSet = 'utf-8';
    $mail->msgHTML($eMailBody, "./", false);
//    $mail->Body = $eMailBody;

    if (!$mail->send()) {
        error_log("Mailer Error: " . $mail->ErrorInfo);
    } else {
        error_log("Message sent!");
    }
}


?>