<?php
header('Access-Control-Allow-Origin: *');

session_start();
include("config.php");

error_log("Hello database");

// Gets the function name from platform/ui/src/components/MeasurementTable/MeasurementTable.js and executes it
if(isset($_GET['function'])) {
    if($_GET['function'] == 'addAnnotation') {
        addAnnotation();
    }
    if($_GET['function'] == 'retrieveAnnotation') {
        retrieveAnnotation();
    }
}

// A function that adds the annotations in the database in a JSON format based on the user_id (the user currently logged in)
function addAnnotation(){
    global $link;
    //saves the username from the cookie
    $username_string = json_encode($_POST['myKey1']);
    $username = str_replace('"', '', $username_string);

    //sql statement to get the id based on the username
    $sql = "SELECT ID FROM user_tbl WHERE username = ?";
    $statement = mysqli_prepare($link, $sql);
    $statement->bind_param('s', $username);
    $statement->execute();
    $result = $statement->get_result();
    $row = mysqli_fetch_array($result);
    $user_id = $row[0];

    //variable that holds an annotation in json format
    $annotation = json_encode($_POST['myKey']);
    
    //sql statement to insert the relevant values in the database
    $sql1 = "INSERT INTO annotations VALUES (null, ?, ?)";
    $statement1 = mysqli_prepare($link, $sql1);
    $statement1->bind_param("is", $user_id, $annotation);
    $result1 = $statement1->execute();
}

// A function that retrieves the annotations from the database in a JSON format based on the user_id (the user currently logged in)
function retrieveAnnotation(){
    global $link;
    error_log("In retriveAnnotation");

    //saves the username from the cookie
    $username_string = json_encode($_GET['name']);
    $username = str_replace('"', '', $username_string);

    //sql statement to get the user id based on the username
    $sql = "SELECT ID FROM user_tbl WHERE username = ?";
    $statement = mysqli_prepare($link, $sql);
    $statement->bind_param('s', $username);
    $statement->execute();
    $result = $statement->get_result();
    $row = mysqli_fetch_array($result);
    $user_id = $row[0];

    //sql statement to get the annotations based on the user id
    $sql = "SELECT annotation_info FROM annotations WHERE user_id = ?";
    $statement = mysqli_prepare($link, $sql);
    $statement->bind_param('i', $user_id);
    $statement->execute();
    $result = $statement->get_result();
    $row = mysqli_fetch_array($result);

    //prints the annotation
    echo json_decode($row[0]);
}

?>