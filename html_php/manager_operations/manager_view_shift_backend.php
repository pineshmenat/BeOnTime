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
if (array_key_exists('selectedShiftId', $_POST)) {
    $selectedShiftId = $_POST['selectedShiftId'];
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
    case "cancelShift": {

        $ajaxCallReturn = cancelShift($dbConnection, $selectedShiftId);

        break;
    }
    case "activateShift": {

        $ajaxCallReturn = activateShift($dbConnection, $selectedShiftId);

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
            "SELECT shiftmaster.ShiftId, u1.UserName AssignedBy, u2.UserName AssignedTo, companylocationmaster.Address, employeedesignationmaster.empDesignationName, shiftmaster.StartTime, shiftmaster.EndTime, shiftmaster.ShiftStatus 
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

function cancelShift($dbConnection, $selectedShiftId) {

    $ajaxCallReturn = "";
    $response = [];

//    error_log("selectedShiftId in undoAssignEmployee(): " . $selectedShiftId);

    try {
        if (isset($selectedShiftId)) {

            $undoAssignEmployeeSQL = "UPDATE shiftmaster SET ShiftStatus='C' WHERE ShiftId=:selectedShiftId";
            $pdpstm = $dbConnection->prepare($undoAssignEmployeeSQL);
            $pdpstm->bindValue(':selectedShiftId', $selectedShiftId, PDO::PARAM_STR);

            $response['success'] = false;

            if ($pdpstm->execute()) {
                $response['success'] = true;

                // Get shift info
                $shiftAndClientInfoResponse = getShiftAndClientInfo($dbConnection, $selectedShiftId);

                $shiftId = $selectedShiftId;
                $companyName = $shiftAndClientInfoResponse['CompanyName'];
                $companyEmail = $shiftAndClientInfoResponse['CompanyEmail'];
                $address = $shiftAndClientInfoResponse['Address'];
                $startTime = $shiftAndClientInfoResponse['StartTime'];
                $endTime = $shiftAndClientInfoResponse['EndTime'];
                $eMail = $shiftAndClientInfoResponse['EMail'];
                $firstName = $shiftAndClientInfoResponse['FirstName'];
                $lastName = $shiftAndClientInfoResponse['LastName'];

                // Specify email subject and body
                $eMailSubject = '[BeOnTime][Client] Shift Cancellation Notification';

                // send employee a notification email
//                error_log("firstName: " . $firstName . " lastName: " . $lastName . " eMail: " . $eMail);

                if($firstName != "" && $lastName != "" && $eMail != "") {
                    if (filter_var($eMail, FILTER_VALIDATE_EMAIL)) {

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

                        sendNotificationEmail($eMailSubject, $eMailBody, $firstName, $lastName, $eMail);
                    }
                }


                // send notification to company email
                error_log("companyName: " . $companyName . " companyEmail: " . $companyEmail);

                if($companyName != "" && $companyEmail != "") {
                    if (filter_var($companyEmail, FILTER_VALIDATE_EMAIL)) {

                        $eMailBody = "<html>"
                            . "Dear " . ucwords($companyName) . ",<br/><br/>"
                            . "Below shift is cancelled. <br/><br/>"
                            . "Shift Id: <b>" . $shiftId . "</b><br/>"
                            . "Company Name: <b>" . $companyName . "</b><br/>"
                            . "Address: <b>" . $address . "</b><br/>"
                            . "Shift Start Time: <b>" . $startTime . "</b><br/>"
                            . "Shift End Time: <b>" . $endTime . "</b><br/><br/>"
                            . "Regards,<br/>BeOnTime project group"
                            . "</html>";

                        sendNotificationEmail($eMailSubject, $eMailBody, $companyName, "", $companyEmail);
                    }
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

function activateShift($dbConnection, $selectedShiftId) {

    $ajaxCallReturn = "";
    $response = [];

//    error_log("selectedShiftId in undoAssignEmployee(): " . $selectedShiftId);

    try {
        if (isset($selectedShiftId)) {

            $undoAssignEmployeeSQL = "UPDATE shiftmaster SET ShiftStatus='N' WHERE ShiftId=:selectedShiftId";
            $pdpstm = $dbConnection->prepare($undoAssignEmployeeSQL);
            $pdpstm->bindValue(':selectedShiftId', $selectedShiftId, PDO::PARAM_STR);

            $response['success'] = false;

            if ($pdpstm->execute()) {
                $response['success'] = true;

                // Get shift info
                $shiftAndClientInfoResponse = getShiftAndClientInfo($dbConnection, $selectedShiftId);

                $shiftId = $selectedShiftId;
                $companyName = $shiftAndClientInfoResponse['CompanyName'];
                $companyEmail = $shiftAndClientInfoResponse['CompanyEmail'];
                $address = $shiftAndClientInfoResponse['Address'];
                $startTime = $shiftAndClientInfoResponse['StartTime'];
                $endTime = $shiftAndClientInfoResponse['EndTime'];
                $eMail = $shiftAndClientInfoResponse['EMail'];
                $firstName = $shiftAndClientInfoResponse['FirstName'];
                $lastName = $shiftAndClientInfoResponse['LastName'];

                // Specify email subject and body
                $eMailSubject = '[BeOnTime][Client] Shift Activation Notification';

                // send employee a notification email
//                error_log("firstName: " . $firstName . " lastName: " . $lastName . " eMail: " . $eMail);

                if($firstName != "" && $lastName != "" && $eMail != "") {
                    if (filter_var($eMail, FILTER_VALIDATE_EMAIL)) {

                        $eMailBody = "<html>"
                            . "Dear " . ucwords($firstName) . ' ' . ucwords($lastName) . ",<br/><br/>"
                            . "Below shift is activated. <br/><br/>"
                            . "Shift Id: <b>" . $shiftId . "</b><br/>"
                            . "Company Name: <b>" . $companyName . "</b><br/>"
                            . "Address: <b>" . $address . "</b><br/>"
                            . "Shift Start Time: <b>" . $startTime . "</b><br/>"
                            . "Shift End Time: <b>" . $endTime . "</b><br/><br/>"
                            . "Regards,<br/>BeOnTime project group"
                            . "</html>";

                        sendNotificationEmail($eMailSubject, $eMailBody, $firstName, $lastName, $eMail);
                    }
                }


                // send notification to company email
                error_log("companyName: " . $companyName . " companyEmail: " . $companyEmail);

                if($companyName != "" && $companyEmail != "") {
                    if (filter_var($companyEmail, FILTER_VALIDATE_EMAIL)) {

                        $eMailBody = "<html>"
                            . "Dear " . ucwords($companyName) . ",<br/><br/>"
                            . "Below shift is cancelled. <br/><br/>"
                            . "Shift Id: <b>" . $shiftId . "</b><br/>"
                            . "Company Name: <b>" . $companyName . "</b><br/>"
                            . "Address: <b>" . $address . "</b><br/>"
                            . "Shift Start Time: <b>" . $startTime . "</b><br/>"
                            . "Shift End Time: <b>" . $endTime . "</b><br/><br/>"
                            . "Regards,<br/>BeOnTime project group"
                            . "</html>";

                        sendNotificationEmail($eMailSubject, $eMailBody, $companyName, "", $companyEmail);
                    }
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

function getShiftAndClientInfo($dbConnection, $selectedShiftId) {

    $getShiftInfoSQL = "SELECT s.ShiftId, s.AssignedTo, c.CompanyName, c.CompanyEmail, cl.Address, s.StartTime, s.EndTime, u.FirstName, u.LastName, u.EMail  
                          FROM shiftmaster s 
                          JOIN companymaster c ON(s.CompanyId = c.CompanyId) 
                          JOIN companylocationmaster cl ON(s.CompanyLocationId = cl.CompanyLocationId) 
                          LEFT JOIN usermaster u ON(s.AssignedTo = u.UserId) 
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
    $response['AssignedTo'] = $resultSet[0]->AssignedTo;
    $response['CompanyName'] = $resultSet[0]->CompanyName;
    $response['CompanyEmail'] = $resultSet[0]->CompanyEmail;
    $response['Address'] = $resultSet[0]->Address;
    $response['StartTime'] = $resultSet[0]->StartTime;
    $response['EndTime'] = $resultSet[0]->EndTime;
    $response['FirstName'] = $resultSet[0]->FirstName;
    $response['LastName'] = $resultSet[0]->LastName;
    $response['EMail'] = $resultSet[0]->EMail;

    return $response;
}

function sendNotificationEmail($eMailSubject, $eMailBody, $firstName, $lastName, $eMail) {

//    error_log("firstName: " . $firstName . " lastName: " . $lastName . "eMail" . $eMail);
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