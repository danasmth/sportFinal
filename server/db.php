<?php

//database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'sportify_db');


//create connection
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

//check connection 
if ($conn->connect_error) {
    //in a real application, log this error instead of showing it directly
    die("Connection failed:" . $conn->connect_error);
}

$conn->set_charset("utf8mb4");



