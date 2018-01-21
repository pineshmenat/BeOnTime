<?php
session_start();
	require_once "config.php";
include("../model/db_config.php");

	try {
		$accessToken = $helper->getAccessToken();
	} catch (\Facebook\Exceptions\FacebookResponseException $e) {
		echo "Response Exception: " . $e->getMessage();
		exit();
	} catch (\Facebook\Exceptions\FacebookSDKException $e) {
		echo "SDK Exception: " . $e->getMessage();
		exit();
	}

	if (!$accessToken) {

		header('Location: login.php');
		exit();
	}

	$oAuth2Client = $FB->getOAuth2Client();
	if (!$accessToken->isLongLived())
		$accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);

	$response = $FB->get("/me?fields=id, first_name, last_name, email, picture.type(large)", $accessToken);
	$userData = $response->getGraphNode()->asArray();
	$_SESSION['userData'] = $userData;
	$_SESSION['access_token'] = (string) $accessToken;
var_dump($userData);
$loginAuthenticationSQL = "SELECT UserId, UserName, RoleId, CompanyId FROM usermaster WHERE EMail = :email";
$emailid=$userData['email'];
$pdpstm = DB::getDBConnection()->prepare($loginAuthenticationSQL);
$pdpstm->bindValue(':email', $emailid, PDO::PARAM_STR);

$pdpstm->execute();
$pdpstm->setFetchMode(PDO::FETCH_ASSOC);

$rowCount = $pdpstm->rowCount();

$resultSet = $pdpstm->fetchAll();


if ($rowCount == 1) {

//                error_log("userId: " . $resultSet[0]['UserId']);

    $_SESSION['userId'] = $resultSet[0]['UserId'];
    $_SESSION['userName'] = $resultSet[0]['UserName'];
    $_SESSION['roleId'] = $resultSet[0]['RoleId'];
    $_SESSION['companyId'] = $resultSet[0]['CompanyId'];
    $_SESSION['portraintImg'] = $resultSet[0]['UserId'] . '_' . $resultSet[0]['UserName'] . '.png';

    error_log("_SESSION['userId']: " . $_SESSION['userId'] . " _SESSION['userName']: " . $_SESSION['userName']
        . " _SESSION['roleId']: " . $_SESSION['roleId'] . " _SESSION['portraintImg']: " . $_SESSION['portraintImg']);

    redirectPage($resultSet[0]['RoleId']);
}
else
    {

        header("location: ../index.html");
    }

function redirectPage($roleId) {
    // NOTES: 10 is manager
    // 11 is client
    // 12 is employee
    switch ($roleId) {
        case '10': {
            header("location: ../manager_operations/manager_assign_shift_frontend.php");
            break;
        }
        case '11': {
            header("location: ../client_operations/client-create-shift.php");
            break;
        }
        case '12': {


            header("location: ../employee_operations/employee-dashboard.php");
            break;

        }
        default: {
            header("location: ../index.html");
            break;
        }
    }
}


//header("location: ../employee_operations/employee-dashboard.php");
	exit();
?>