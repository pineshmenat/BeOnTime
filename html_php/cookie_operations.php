<!--------------->
<!--By Zhongjie-->
<!--------------->
<?php

class CookieOperations {

    static function checkCookieTimeout() {
        if(!isset($_COOKIE['userId'])) {
            session_unset();
            session_destroy();
            header("location: ./index.html");
        }
    }

    static function extendCookieTimeout() {

//        setcookie('userId', $_COOKIE['userId'], time() + 7200, '/');
//        setcookie('userName', $_COOKIE['userName'], time() + 7200, '/');
//        setcookie('roleId', $_COOKIE['roleId'], time() + 7200, '/');
//        setcookie('portraintImg', $_COOKIE['portraintImg'], time() + 7200, '/');
    }
}
?>
