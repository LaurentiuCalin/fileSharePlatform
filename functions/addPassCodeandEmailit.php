<?php

function addPassCodeandEmailIt($email, $userId)
{

//    create the password reset code
    $resetCode = rand(99999, 999999);

//            send the email to the user\
    include_once 'sendEmail/sendEmailReset.php';
    include_once '../db/dbconnect.php';
    global $mysqli;

    $stmt = $mysqli->prepare("UPDATE users SET password_reset_code=? WHERE email=? AND id=?");
    $stmt->bind_param('sss', $resetCode, $email, $userId);
    $stmt->execute();
    $stmt->store_result();

    emailPasswordReset($email, $userId, $resetCode);


}

?>

