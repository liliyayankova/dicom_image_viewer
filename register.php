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
    <div id="form">
        <h2>Register</h2>
        <form action="db_register.php" method="post">
             <p>
                <label>Forename</label>
                <input type="text" id="forename" name="forename">
            </p>
            <p>
                <label>Surname</label>
                <input type="text" id="surname" name="surname">
            </p>
            <p>
                <label>Username</label>
                <input type="text" id="name" name="username">
            </p>
            <p>
                <label>Password</label>
                <input type="password" id="pass" name="password">
            </p>
            <p>
                <label>Confirm password</label>
                <input type="password" id="confirm_pass" name="confirm_pass">
            </p>
            <p>
                <label>Email</label>
                <input type="text" id="email" name="email">
            </p>
            <p>
                <input type="submit" id="button" value="Register">
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