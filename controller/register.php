<?php

include "../db/dbconnect.php";
include "../functions/encryption.php";
include "../functions/salt.php";
include "../functions/addUserDatabase.php";
include '../functions/sendEmail/SendEmailConfirmation.php';
include '../functions/userIdGenerator.php';

if (empty($_POST['username']) || empty($_POST['email']) ||
    empty($_POST['email']) || empty($_POST['emailCheck']) ||
    empty(['password']) || empty($_POST['passwordCheck'])
) {
    die("please fill all the fields");
} else {

    $sUserName = strtolower($_POST["username"]);
    $sUserEmail = strtolower($_POST["email"]);
    $sUserEmailCheck = strtolower($_POST["emailCheck"]);
    $sPassword = $_POST["password"];
    $sPasswordCheck = $_POST["passwordCheck"];
    $sUserEmail = filter_var($sUserEmail, FILTER_SANITIZE_EMAIL);

    if ($sUserEmail !== $sUserEmailCheck) {
        die("the emails don't match");
    } elseif ($sPassword !== $sPasswordCheck) {
        die("the passwords don't match");
    } elseif (!preg_match_all('$\S*(?=\S{10,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])(?=\S*[\W])\S*$', $sPassword)) {
        die("the password doesn't meet the requirements");
    } elseif (!preg_match_all('/(?=\S*[a-z])/', $sUserName)) {
        die("username can contain only letters");
    } elseif (filter_var($sUserEmail, FILTER_VALIDATE_EMAIL) === false) {
        die("invalid email");
    } else {
        $jEnc = json_decode(encrypt($sPasswordCheck, $sStaticSalt));

        $sPassEnc = $jEnc->hashPass;
        $sRandSalt = $jEnc->randSalt;
        $account_activation_code = md5(uniqid(rand()));

//        generate the id for the password reset
        $sUserId = generateId($sUserEmail);

        if (addToDatabase($sUserId, $sUserName, $sUserEmail, $sPassEnc, $sRandSalt, $account_activation_code)) {

            echo "added";
            emailConfirmation($sUserEmail, $account_activation_code);

        } else {
            die("An error has occurred. Please try again");
        }

    }
}
?>
