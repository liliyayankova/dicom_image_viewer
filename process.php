<?php
    session_start();
?>
<?php
    include("db/config.php");

    //Get the username and password from the login form
    $username = $_POST['username'];
    $password = $_POST['password'];

    if(!empty($_POST)){
        //Sets the username and password and executes the sql statement
        if (isset($username) && isset($password)) {
            $sql = $link->prepare("SELECT * FROM user_tbl WHERE username = ?");
            $sql->bind_param('s', $username);
            $sql->execute();
            $result = $sql->get_result();
            $user = $result->fetch_object();
                
            //Verifies the inputted password against the password in the database
            if(password_verify($password, $user->password) ) {
                $_SESSION['ID'] = $user->ID;
                $_SESSION['username'] = $user->username;
                $_SESSION['forename'] = $user->forename;
                $_SESSION['surname'] = $user->surname;
                $_SESSION['email'] = $user->email;
                //$_SESSION['ID'] = $ID;

                header("Location: http://51.195.202.88/lyankova/dicom-image-viewer/profile.php");
            } else{
                echo '<script>
                        alert("Wrong password");
                        window.location.href = "index.php";
                    </script>';
            }
        }
    }
?>