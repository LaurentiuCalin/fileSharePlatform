<?php

include_once '../db/dbconnect.php';
include_once '../functions/encryption.php';
include_once '../functions/salt.php';
include_once '../functions/checkAttempts.php';
include_once '../functions/incrementLoginAttempts.php';
include_once '../functions/sendEmail/sendEmailReset.php';

session_start();


if (isset($_POST['emailLogin']) && !empty($_POST['emailLogin'])) {
    if (isset($_POST["PasswordLogin"]) && !empty($_POST["PasswordLogin"])) {
        $inputEmail = $_POST['emailLogin'];
        $inputEmail = filter_var($inputEmail, FILTER_SANITIZE_EMAIL);
        if (!filter_var($inputEmail, FILTER_VALIDATE_EMAIL) === false) {
            global $mysqli;
            $stmt = $mysqli->prepare("SELECT id, password_reset_code, password, password_salt, email_confirmation FROM users WHERE email = ?");
            $stmt->bind_param('s', $inputEmail);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($db_id, $db_pass_code, $db_password, $db_password_salt, $email_confirmation);
            $stmt->fetch();
            if ($stmt->num_rows == 1) {
                if ($email_confirmation != 0) {
                    if (checkAttempts($inputEmail) === true) {
                        $inputPassword = $_POST['PasswordLogin'];
//                        $sPass = loginEncrypt($inputPassword, $sStaticSalt, $db_password_salt);
                        if (password_verify($sStaticSalt . $inputPassword . $db_password_salt, $db_password)) {
                            $randomValue = md5(time() . rand() . $db_password);
                            setcookie("aqInfo", $db_id . "." . $randomValue, strtotime('+30 days'), '/');
                            echo "ok";
//                            header("location: ../dashboard.php");
                            die();
                        } else {
                            addToAttempts($inputEmail);
                            $_SESSION['error'] = "incorrect email or password";
                            header("location: ../index.php?loginModal=1");
                            die();
                        }
                    } else {
                        $jAttempts = json_decode(checkAttempts($inputEmail));
                        if ($jAttempts->error == 3) {
                            addToAttempts($inputEmail);
                            $_SESSION['error'] = "Too many attempts! Wait 5 minutes!";
                            header("location: ../index.php?loginModal=1");
                            die();
                        } elseif ($jAttempts->error == 5) {
                            emailPasswordReset($inputEmail, $db_id, $db_pass_code);
                            $_SESSION['error'] = "Too many attempts! A password reset email has been sent!";
                            header("location: ../index.php?loginModal=1");
                            die();
                        } else {
                            $_SESSION['error'] = "An error has occurred! Contact us at: bla";
                            header("location: ../index.php?loginModal=1");
                            die();
                        }
                    }
                } else {
                    $_SESSION['error'] = "please confirm your email";
                    header("location: ../index.php?loginModal=1");
                    die();
                }
            } else {
                $_SESSION['error'] = "incorrect email or password";
                header("location: ../index.php?loginModal=1");
                die();
            }
        } else {
            $_SESSION['error'] = "incorrect email or password";
            header("location: ../index.php?loginModal=1");
            die();
        }

    } else {
        $_SESSION['error'] = "email or password not set";
        header("location: ../index.php?loginModal=1");
        die();
    }
} else {
    $_SESSION['error'] = "email or password not set";
    header("location: ../index.php?loginModal=1");
    die();
}

?>
