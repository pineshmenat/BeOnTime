<?php
//
// By Zhongjie
//

include "../model/db_config.php";

$dbConnection = DB::getDBConnection();
$ajaxCallReturn;

$operation = $_POST["operation"];
//error_log("operation: " . $operation);
// Get value if key exists in $_POST
//
if (array_key_exists('userId', $_POST)) {
    $userId = $_POST['userId'];
}
if (array_key_exists('currentTime', $_POST)) {
    $currentTime = $_POST['currentTime'];
}
if (array_key_exists('shiftId', $_POST)) {
    $shiftId = $_POST['shiftId'];
}
if (array_key_exists('employeeCurrentLat', $_POST)) {
    $employeeCurrentLat = $_POST['employeeCurrentLat'];
}
if (array_key_exists('employeeCurrentLng', $_POST)) {
    $employeeCurrentLng = $_POST['employeeCurrentLng'];
}

// Interaction with DB based on different operation keywords
//
switch ($operation) {
    case "GetShiftInNext30Minutes": {

        if (isset($userId) && isset($currentTime)) {

            $ajaxCallReturn = getCurrentShift($dbConnection, $userId, $currentTime);

        } else {
            $ajaxCallReturn = "<p>userId is not set, or currentTime is not set.</p>";
        }

        break;
    }
    case "SaveActualWorkingStartTime": {

        if (isset($shiftId) && isset($currentTime)) {

            $ajaxCallReturn = saveActualWorkingStartTime($dbConnection, $shiftId, $currentTime);

        } else {
            $ajaxCallReturn = "<p>shiftId is not set, or currentTime is not set.</p>";
        }
        break;
    }
    case "SaveActualWorkingEndTime": {

        if (isset($shiftId) && isset($currentTime)) {

            $ajaxCallReturn = saveActualWorkingEndTime($dbConnection, $shiftId, $currentTime);

        } else {
            $ajaxCallReturn = "<p>shiftId is not set, or currentTime is not set.</p>";
        }
        break;
    }
    case "SaveCurrentEmployeePosition": {

//        error_log($shiftId . $employeeCurrentLat . $employeeCurrentLng);

        if (isset($shiftId) && isset($employeeCurrentLat) && isset($employeeCurrentLng)) {

            $ajaxCallReturn = saveCurrentEmployeePosition($dbConnection, $shiftId, $employeeCurrentLat, $employeeCurrentLng);

        } else {
            $ajaxCallReturn = "<p>shiftId is not set, or employeeCurrentLat/employeeCurrentLng is not set.</p>";
        }
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
function getCurrentShift($dbConnection, $userId, $currentTime) {

//    error_log("userId: " . $userId + " currentTime: " . $currentTime);

    $sql = "select ShiftId, CompanyName, companylocationmaster.Address WorkingPlace, StartTime, EndTime, Latitude, Longitude 
            from shiftmaster 
	            join companymaster on (shiftmaster.CompanyId = companymaster.CompanyId) 
	            join companylocationmaster on (shiftmaster.CompanyLocationId = companylocationmaster.CompanyLocationId) 
            where (:currentTime between DATE_ADD(StartTime, interval 0 minute) and DATE_ADD(EndTime, interval 0 minute)) 
	            and AssignedTo=:assignTo 
	            and ShiftStatus = 'A'  
            order by StartTime";

    $pdpstm = $dbConnection->prepare($sql);
    $pdpstm->bindValue(':assignTo', $userId, PDO::PARAM_STR);
    $pdpstm->bindValue(':currentTime', $currentTime, PDO::PARAM_STR);
    $pdpstm->execute();
    $pdpstm->setFetchMode(PDO::FETCH_OBJ);

    $resultSet = $pdpstm->fetchAll();

    $ajaxCallReturn = json_encode(array("shift" => $resultSet));

    return $ajaxCallReturn;
}

function saveActualWorkingStartTime($dbConnection, $shiftId, $currentTime) {

    error_log("shiftId: " + $shiftId + " currentTime: " + $currentTime);
    $response = [];
    $response['success'] = false;

    $SQL = "UPDATE shiftmaster SET ActualWorkingStartTime=:time WHERE ShiftId=:shiftId";
    $pdpstm = $dbConnection->prepare($SQL);
    $pdpstm->bindValue(':time', $currentTime, PDO::PARAM_STR);
    $pdpstm->bindValue(':shiftId', $shiftId, PDO::PARAM_STR);

    if ($pdpstm->execute()) {
        $response['success'] = true;
    }
    return json_encode($response);
}

function saveActualWorkingEndTime($dbConnection, $shiftId, $time) {

    $response = [];
    $response['success'] = false;

    $SQL = "UPDATE shiftmaster SET ActualWorkingEndTime=:time, ShiftStatus='D' WHERE ShiftId=:shiftId";
    $pdpstm = $dbConnection->prepare($SQL);
    $pdpstm->bindValue(':time', $time, PDO::PARAM_STR);
    $pdpstm->bindValue(':shiftId', $shiftId, PDO::PARAM_STR);

    if ($pdpstm->execute()) {
        $response['success'] = true;
    }
    return json_encode($response);
}

function saveCurrentEmployeePosition($dbConnection, $shiftId, $employeeCurrentLat, $employeeCurrentLng) {

    $response = [];
    $response['success'] = false;

    $SQL = "UPDATE shiftmaster SET CurrentLat=:employeeCurrentLat, CurrentLong=:employeeCurrentLng WHERE ShiftId=:shiftId";
    $pdpstm = $dbConnection->prepare($SQL);
    $pdpstm->bindValue(':employeeCurrentLat', $employeeCurrentLat, PDO::PARAM_STR);
    $pdpstm->bindValue(':employeeCurrentLng', $employeeCurrentLng, PDO::PARAM_STR);
    $pdpstm->bindValue(':shiftId', $shiftId, PDO::PARAM_STR);

    if ($pdpstm->execute()) {
        $response['success'] = true;
    }
    return json_encode($response);
}

//
// By Zhongjie
//
?>
