<?php 
   session_start();

   if (isset($_SESSION['ID'])) {
      $username = $_SESSION['username'];
      setcookie('user_name', $username, time() + (86400 * 7), '/');
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
   <div id="profile_form" class="profile">
      <p>
         <label><b>Forename: </b></label>
         <?php echo $_SESSION['forename'];?>
      </p>
      <p>
         <label><b>Surname: </b></label>
         <?php echo $_SESSION['surname'];?>
      </p>
      <p>
         <label><b>Username: </b></label>
         <?php echo $_SESSION['username'];?>
      </p>
      <p>
         <label><b>Email: </b></label>
         <?php echo $_SESSION['email'];?>
      </p>
      <br>
      <form action="http://51.195.202.88:8042/app/explorer.html" target="_blank">
         <input type="submit" id="link_button" value="Add images"/>
      </form>
      <br>
      <form action="http://51.195.202.88:3000">
         <input type="submit" id="link_button" value="Viewer"/>
      </form>
      <br>
      <form action="logout.php">
         <input type="submit" id="link_button" value="Logout"/>
      </form>
   </div>
 </body>
 <div class="footer">
    <p>DICOM Image Viewer © Liliya Yankova</p>
</div>
<?php 
   } else {
      echo '<script>
               alert("Session not set");
               window.location.href = "index.php";
            </script>';
   }
  ?>
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