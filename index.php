<?php
    ob_start();
    session_start();
?>
<!DOCTYPE html>
<html>
 <head>
  <title>DICOM Image Viewer</title>
  <link rel="stylesheet" type="text/css" href="css/style.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
 </head>
 <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
 <body>
    <div id="login_form">
        <h2>Login</h2>
        <form action="process.php" method="post">
            <p>
                <label>Username</label>
                <input type="text" id="user_name" name="username">
            </p>
            <p>
                <label>Password</label>
                <input type="password" id="pass" name="password">
            </p>
            <p>
                <input type="submit" id="button" value="Login">
            </p>
        </form>
    </div>
 </body>
 <div class="footer">
    <p>DICOM Image Viewer © Liliya Yankova</p>
</div>
<style>
    .footer {
    position: fixed;
    left: 0;
    bottom: 0;
    width: 100%;
    background-color: CornflowerBlue;
    color: white;
    text-align: center;
    }
</style>
</html>