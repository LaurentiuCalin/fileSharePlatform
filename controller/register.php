<?php
session_start();
include "../db/dbconnect.php";
include "../functions/encryption.php";
include "../functions/salt.php";
include "../functions/addUserDatabase.php";
include "../functions/sendEmail/SendEmailConfirmation.php";
include "../functions/userIdGenerator.php";

if (empty($_POST['username']) || empty($_POST['email']) || empty($_POST['emailCheck']) || empty($_POST['password']) || empty($_POST['passwordCheck'])) {
    $_SESSION['error'] = "Please fill all the fields";
    header("Location:../index.php?registerModal=1");
    die();
} else {

    $sUserName = strtolower(htmlentities($_POST["username"]));
    $sUserEmail = strtolower($_POST["email"]);
    $sUserEmailCheck = strtolower($_POST["emailCheck"]);
    $sPassword = $_POST["password"];
    $sPasswordCheck = $_POST["passwordCheck"];
    $sUserEmail = filter_var($sUserEmail, FILTER_SANITIZE_EMAIL);

    if ($sUserEmail !== $sUserEmailCheck) {
        $_SESSION['error'] = "E-mails do not match! ";
        header("Location:../index.php?registerModal=1");
        die();
    } elseif ($sPassword !== $sPasswordCheck) {
        $_SESSION['error'] = "Passwords do not match!";
        header("Location:../index.php?registerModal=1");
        die();
    } elseif (!preg_match_all('$\S*(?=\S{10,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])(?=\S*[\W])\S*$', $sPassword)) {
        $_SESSION['error'] = "The password does not meet the requirements";
        header("Location:../index.php?registerModal=1");
        die();
    } elseif (!preg_match_all('/(?=\S*[a-z])/', $sUserName)) {
        $_SESSION['error'] = "Username can contain only letters";
        header("Location:../index.php?registerModal=1");
        die();
    } elseif (filter_var($sUserEmail, FILTER_VALIDATE_EMAIL) === false) {
        $_SESSION['error'] = "Invalid e-mail address";
        header("Location:../index.php?registerModal=1");
        die();
    } else {
        $jEnc = json_decode(encrypt($sPasswordCheck, $sStaticSalt));

        $sPassEnc = $jEnc->hashPass;
        $sRandSalt = $jEnc->randSalt;
        $account_activation_code = md5(uniqid(rand()));

//        generate the id for the password reset
        $sUserId = generateId($sUserEmail);

        if (addUserToDatabase($sUserId, $sUserName, $sUserEmail, $sPassEnc, $sRandSalt, $account_activation_code)) {
            emailConfirmation($sUserEmail, $account_activation_code);
            header("Location:../index.php?messageModal=1");

        } else {
            $_SESSION['error'] = "An error has occurred. Please try again";
            header("Location:../index.php?registerModal=1");
            die();
        }

    }
}
?>
