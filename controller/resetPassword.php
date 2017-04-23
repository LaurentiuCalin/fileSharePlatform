<?php

session_start();
//echo $_GET['userId']."<br> ". $_GET['passcode']  ."<br>".$_POST['newpassword'];
//here we check the fields and add the new password in the database


//check if we get the userid, code to reset the pass and the passwords
if (isset($_GET['userId']) && $_GET['userId'] &&
    isset($_GET['passCode']) && $_GET['passCode'] &&
    isset($_POST['newPassword']) && $_POST['newPassword'] &&
    isset($_POST['confirmNewPassword']) && $_POST['confirmNewPassword']
) {

    include_once('../functions/updatePassword.php');

    $userId = $_GET['userId'];
    $passCode = $_GET['passCode'];
    $newPass = $_POST['newPassword'];
    $passConf = $_POST['confirmNewPassword'];


    if (preg_match_all('$\S*(?=\S{10,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])(?=\S*[\W])\S*$', $newPass)) {
        //    check if the passwords match
        if ($newPass == $passConf) {

            include_once('../db/dbconnect.php');
            include_once('../functions/salt.php');
            include_once('../functions/encryption.php');


            if (updatePassword($userId, $passCode, $newPass)) {
                header("Location:../successfulpassreset.php");
                die();
            } else {
                $_SESSION['error'] = "Something went wrong! Please try again";
                header("Location: resetPasswordForm.php?userId=" . $userId . "&code=" . $passCode . "");
                die();
            }
        } else {
            $_SESSION['error'] = "Confirmation password does not match";
            header("Location: resetPasswordForm.php?userId=" . $userId . "&code=" . $passCode . "");
            die();
        }
    } else {
        $_SESSION['error'] = "The password doesn't meet the requirements";
        header("Location: resetPasswordForm.php?userId=" . $userId . "&code=" . $passCode . "");
        die();
    }
} else {
    $_SESSION['error'] = "Both fields are required!";
    header("Location: resetPasswordForm.php?userId=" . $_GET['userId'] . "&code=" . $_GET['passCode'] . "");
    die();
}


?>
