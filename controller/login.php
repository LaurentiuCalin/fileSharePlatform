<?php

include_once '../db/dbconnect.php';
include_once '../functions/encryption.php';
include_once '../functions/salt.php';
include_once '../functions/checkAttempts.php';
include_once '../functions/incrementLoginAttempts.php';

if (!isset($_POST["emailLogin"]) || empty($_POST["emailLogin"])) {
    die('email not set');
} else if (!isset($_POST["PasswordLogin"]) || empty($_POST["PasswordLogin"])) {
    die('password not set');
} else {
    $inputEmail = $_POST['emailLogin'];
    $inputEmail = filter_var($inputEmail, FILTER_SANITIZE_EMAIL);
    if (!filter_var($inputEmail, FILTER_VALIDATE_EMAIL) === false) {
        global $mysqli;
        if ($stmt = $mysqli->prepare("SELECT password, password_salt, email_confirmation FROM users WHERE email = ?")) {

            $stmt->bind_param('s', $inputEmail);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($db_password, $db_password_salt, $email_confirmation);
            $stmt->fetch();


            if ($stmt->num_rows == 1) {
                if ($email_confirmation == 0) {
                    die('please confirm your email');
                } else {
                    if (!checkAttempts($inputEmail)) {
                        die('too many attempts');
                    } else {
                        //we have a user with that email. we check if the password matches next.
                        $inputPassword = $_POST['PasswordLogin'];

                        $sPass = loginEncrypt($inputPassword, $sStaticSalt, $db_password_salt);
                        if ($sPass == $db_password) {
                            //we have a succesfull login. start session etc.
                            echo "Success";
                            return true;
                        } else {
                            //password is incorrect
                            addToAttempts($inputEmail);
//                              header('location: index.php');
                            die('username or password incorrect');
                        }
                    }
                }
            } else {
//                header('location: index.php');
                die('incorrect email or password');
            }
        }
    } else {
//        header('location: index.php');
        die('incorrect email or password');
    }

}

?>
