<?php

include "dbconnect.php";
include "encryption.php";
include "salt.php";
include "addUserDatabase.php";
include 'sendEmailConfirmation.php';
include 'userIdGenerator.php';


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
//    } elseif (!preg_match_all('(?=\S*[a-z])', $sUserName)) {
    } elseif ($sUserName=="blabla") {
        die("username can contain only letters");
    } elseif (filter_var($sUserEmail, FILTER_VALIDATE_EMAIL) === false) {
        die("invalid email");
    } else {
        $jEnc = json_decode(encrypt($sPasswordCheck, $sStaticSalt));

        $sPassEnc = $jEnc->hashPass;
        $sRandSalt = $jEnc->randSalt;
        $emailToken = md5(uniqid(rand()));

//        generate the id for the password reset
        $sUserId = generateId($sUserEmail);

        if (addToDatabase($sUserId, $sUserName, $sUserEmail, $sPassEnc, $sRandSalt, $emailToken)) {

            echo "added";
            emailConfirmation($sUserEmail, $emailToken);

        } else {
            die("An error has occurred. Please try again");
        }

    }
}


//
//$bRegistration = false;
//
//if (ctype_alpha($sUserName)===true){
//    echo"good job";
//}else{
//    header('Location: http://www.example.com/');
//    echo "please enter a valid username";
//    die();
//}
//
////check if the passwords and the emails are the same
//
//if ($sUserEmailCheck == $sUserEmail && $sPasswordCheck == $sPassword){
//
//    $sUserEmail = filter_var($sUserEmail, FILTER_SANITIZE_EMAIL);
//
//    if (filter_var($sUserEmail, FILTER_VALIDATE_EMAIL) === true){
//
//    }
//
//    $sPassword = mysql_real_escape_string($sPassword);
//}
//
//
//
//
//
//if (!filter_var($sUserEmail, FILTER_SANITIZE_EMAIL) === false){
//
////    var_dump($sUserEmail);
//}
//
//
//
//
//
//if ($mysqli->connect_error){
//    die("Connection error".$mysqli->connect_error);
//}
////echo $mysqli;
////echo "Conected succesfully";,
//


//$iv = mcrypt_create_iv(mcrypt_get_iv_size('tripledes', 'cbc'), MCRYPT_DEV_URANDOM);
//$secretKey = base64_encode(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM));


//$sPasswordEnc = base64_encode(mcrypt_encrypt('tripledes', $secretKey, $sPassword, 'cbc', $iv));
//echo $iv;
//
//echo "<br>";
//
//echo $secretKey;
//
//echo "<br>";
//
//echo $sPasswordEnc;

//$sPassword = encrypt($sPassword);


//exit();
//die();
//header("Location: http://localhost:90/websecurity/");

?>
