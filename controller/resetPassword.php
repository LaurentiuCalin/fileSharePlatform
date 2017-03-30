<?php

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
                die("password succesfully changed!");
            } else {
                die("something went wrong! Please try again");
            }

        } else {
            die("Confirmation password does not match");
        }
    } else {
        die("the password doesn't meet the requirements");
    }
} else {
    die("Something went wrong! Please try again!");
}


?>