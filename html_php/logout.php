<!--------------->
<!--By Zhongjie-->
<!--------------->
<?php
session_start();

session_unset();

if(session_destroy()) {

    $dbConnection = null;

    setcookie('userId', $resultSet[0]['UserId'], time() - 10000);
    setcookie('userName', $resultSet[0]['UserName'], time() - 10000);
    setcookie('roleId', $resultSet[0]['RoleId'], time() - 10000);
    setcookie('portraintImg', $resultSet[0]['UserId'] . '_' . $resultSet[0]['UserName'] . '.png', time() - 10000);

    header("Location: ./index.html");
}
?>