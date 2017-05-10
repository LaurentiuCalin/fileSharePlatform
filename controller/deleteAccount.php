<?php
include_once '../db/dbconnect.php';
include_once '../functions/encryption.php';
include_once '../functions/salt.php';


session_set_cookie_params(time() + 600, "/", "", true, true);
session_start();


if (isset($_SESSION['logged']) && $_SESSION['logged'] == 1) {
    if (isset($_POST['EmailDelete']) && !empty($_POST['EmailDelete'])) {
        if (isset($_POST['PasswordDelete']) && !empty($_POST['PasswordDelete'])) {
            $inputEmail = $_POST['EmailDelete'];
            $inputEmail = filter_var($inputEmail, FILTER_SANITIZE_EMAIL);
            if (!filter_var($inputEmail, FILTER_VALIDATE_EMAIL) === false) {
                global $mysqli;
                $stmt = $mysqli->prepare("SELECT id, password, password_salt FROM users WHERE email = ?");
                $stmt->bind_param('s', $inputEmail);
                $stmt->execute();
                $stmt->store_result();
                $stmt->bind_result($db_id, $db_password, $db_password_salt);
                $stmt->fetch();
                if ($stmt->num_rows == 1) {
                    $stmt->close();
                    $session_uid = $_SESSION['user'];
                    if ($session_uid == $db_id) {
                        $inputPassword = $_POST['PasswordDelete'];
                        if (password_verify($sStaticSalt . $inputPassword . $db_password_salt, $db_password)) {
                            $stmt = $mysqli->prepare("DELETE FROM users WHERE email = ?");
                            $stmt->bind_param("s", $inputEmail);
                            $stmt->execute();
                            $stmt->close();

                            $stmt = $mysqli->prepare("DELETE FROM files WHERE user_id = ?");
                            $stmt->bind_param("s", $db_id);
                            $stmt->execute();
                            $stmt->close();

                            header("location: ../functions/logout.php");
                        } else {
                            $_SESSION['error'] = "incorrect email or password";
                            header("location:../dashboard.php?settings&delete");
                            die();
                        }
                    } else {
                        $_SESSION['error'] = "An error has occurred! Please login again.";
                        header("location:../index.php?loginModal=1");
                        die ();
                    }
                } else {
                    $_SESSION['error'] = "An error has occurred! Please try again.";
                    header("location:../dashboard.php?settings&delete");
                    die();
                }
            } else {
                $_SESSION['error'] = "incorrect email or password";
                header("location:../dashboard.php?settings&delete");
                die ();
            }
        } else {
            $_SESSION['error'] = "incorrect email or password";
            header("location:../dashboard.php?settings&delete");
            die ();
        }
    } else {
        $_SESSION['error'] = "incorrect email or password";
        header("location:../dashboard.php?settings&delete");
        die ();
    }
} else {
    $_SESSION['error'] = "Please login to view this page";
    header("location:../index.php?loginModal=1");
    die();
}