<?php
//start the session to access it 
session_start();

//unset all of the session variables 
$_SESSION = array();

//destroy the session cookie
if(ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        name: session_name(),
        value: '',
        expires_or_options: time() - 42000,
        path: $params["path"],
        domain: $params["domain"],
        secure: $params["secure"],
        httponly: $params["httponly"]
    );
}


//finally , destro the session 
session_destroy();

//redirect to homepage after logout 
header("Location: ../public/index.php");
exit();


?>









