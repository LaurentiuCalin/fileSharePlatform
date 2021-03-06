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
                $stmt = $mysqli->prepare("SELECT users.id, users.password, users.password_salt, files.path_to_file FROM users, files WHERE email = ? AND users.id = files.user_id");
                $stmt->bind_param('s', $inputEmail);
                $stmt->execute();
                $stmt->store_result();
                $stmt->bind_result($db_id, $db_password, $db_password_salt, $db_path_to_file);
                $user_files = array();
                while ($stmt->fetch()) {
                    $server_file_name = explode("/", $db_path_to_file);
                    array_push($user_files, $server_file_name[1]);
                }
                $stmt->fetch();
                if ($stmt->num_rows >= 1) {
                    $stmt->close();
                    $session_uid = $_SESSION['user'];
                    if ($session_uid == $db_id) {
                        $inputPassword = $_POST['PasswordDelete'];
                        if (password_verify($sStaticSalt . $inputPassword . $db_password_salt, $db_password)) {
                            $stmt = $mysqli->prepare("DELETE FROM users WHERE email = ?");
                            $stmt->bind_param("s", $inputEmail);
                            $stmt->execute();
                            $stmt->close();

                            foreach ($user_files as $file_name) {
                                unlink("../files/" . $file_name);
                            }

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