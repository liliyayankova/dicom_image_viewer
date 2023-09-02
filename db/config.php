<?php
//Database credentials
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'dicom_user');
define('DB_PASSWORD', 'dicom_user');
define('DB_NAME', 'dicom');

//Connection to database
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>