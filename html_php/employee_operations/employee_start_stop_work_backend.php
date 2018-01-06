<?php
/**
 * Created by PhpStorm.
 * User: Zhongjie FAN
 * Date: 2018-01-03
 * Time: 18:58
 */

include "../model/db_config.php";

$dbConnection = DB::getDBConnection();
$ajaxCallReturn;

$operation = $_POST["operation"];

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


// Interaction with DB based on different operation keywords
//
switch ($operation) {
    case "GetShiftInNext30Minutes": {

        if (isset($userId) && isset($currentTime)) {

            $ajaxCallReturn = getShiftInNext30Minutes($dbConnection, $userId, $currentTime);

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
    // ZF
    case "SaveActualWorkingEndTime": {

        if (isset($shiftId) && isset($currentTime)) {

            $ajaxCallReturn = saveActualWorkingEndTime($dbConnection, $shiftId, $currentTime);

        } else {
            $ajaxCallReturn = "<p>shiftId is not set, or currentTime is not set.</p>";
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
function getShiftInNext30Minutes($dbConnection, $userId, $currentTime) {

    $sql = "select ShiftId, CompanyName, companylocationmaster.Address WorkingPlace, StartTime, EndTime, ActualWorkingStartTime, Latitude, Longitude 
            from shiftmaster 
	            join companymaster on (shiftmaster.CompanyId = companymaster.CompanyId) 
	            join companylocationmaster on (shiftmaster.CompanyLocationId = companylocationmaster.CompanyLocationId) 
            where (:currentTime between DATE_ADD(StartTime, interval -30 minute) and DATE_ADD(EndTime, interval -30 minute)) 
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

?>
