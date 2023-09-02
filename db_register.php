<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    include("db/config.php");

    $forename = $_POST['forename'];
    $surname = $_POST['surname'];
    $username = $_POST['username'];
    $password1 = $_POST['password'];
    $password2 = $_POST['confirm_pass'];
    $hashed_password = password_hash($password1, PASSWORD_DEFAULT);
    $email = $_POST['email'];

    if($password1 != $password2){
        echo "The passwords do not match. Please try again!";
        exit;
    }

    $sql = "SELECT * FROM user_tbl WHERE username = '$username'";
    $user_result = mysqli_query($link, $sql);
    if($user_result->num_rows > 0){
        echo "The username " . $username . " already exists in the database!";
        exit;
    }

    $sql = "INSERT INTO user_tbl (ID, username, forename, surname, password, email) VALUES (null, ?, ?, ?, ?, ?)";
    $statement = mysqli_prepare($link, $sql);
    $statement->bind_param("sssss", $username, $forename, $surname, $hashed_password, $email);
    $result = $statement->execute();

    if($result && password_verify($password1, $hashed_password)){
        echo "You have successfully registered!";
    } else{
        echo "Failed to register!";
    }
?>