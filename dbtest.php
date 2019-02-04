<?php
    session_start();
    $_SESSION['message'] = '';

    $hostname = 'localhost';
    $user = 'root';
    $pass = '';
    $db = 'testdb';

    $conn = new mysqli($hostname, $user, $pass, $db) or die();

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        // if the two passwords are equal to each other
        if($_POST['password'] == $_POST['confirmpassword']) {
            $username = $conn->real_escape_string($_POST['username']);
            $email = $conn->real_escape_string($_POST['email']);
            $password = md5($_POST['password']); // md5 --> hash password for security

            $_SESSION['message'] = $username;

            // makes sql request
            $sql = "INSERT INTO users (ussername, email, password) VALUES('$username', '$email', '$password')";
            
            if($conn->query($sql) == true) {
                $_SESSION['message'] = "Registration succesful! Added $username to the database!";
                header('location: welcome_dbtest.php'); // goes to the welcome page
            }
            else {
                $_SESSION['message'] = "User could not be added to the database!";
            }
        }
        else {
            $_SESSION['message'] = "The two passwords do not match!";
        }
    }
?>

<!doctype html>
<html>
    <head>
        <title>PHP Test</title>

        <link href="//db.onlinewebfonts.com/c/a4e256ed67403c6ad5d43937ed48a77b?family=Core+Sans+N+W01+35+Light" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="dbtest-styles.css">
    </head>
    <body style="background: #037db6;">
        <div class="body-content">
            <div class="module">
                <h1>Create an account</h1>
                <form class="form" action="dbtest.php" method="post" enctype="multipart/form-data" autocomplete="off">
                    <div class="alert alert-error"><?= $_SESSION['message'] ?></div>

                    <input type="text" placeholder="User Name" name="username" required />
                    <input type="email" placeholder="Email" name="email" required />
                    <input type="password" placeholder="Password" name="password" autocomplete="new-password" required />
                    <input type="password" placeholder="Confirm Password" name="confirmpassword" autocomplete="new-password" required />

                    <input type="submit" value="Register" name="register" class="btn btn-block btn-primary" />
                </form>
            </div>
        </div>
    </body>
</html>