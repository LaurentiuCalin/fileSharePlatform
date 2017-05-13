<?php

function addPassCodeandEmailIt($email, $userId)
{

//    create the password reset code
    $resetCode = rand(99999, 999999);

//            send the email to the user\
    include_once 'sendEmail/sendEmailReset.php';
    include_once '../db/dbconnect.php';
    global $mysqli;

    $hash_code = hash('sha256', $resetCode);

    $stmt = $mysqli->prepare("UPDATE users SET password_reset_code=? WHERE email=? AND id=?");
    $stmt->bind_param('sss', $hash_code, $email, $userId);
    $stmt->execute();
    $stmt->store_result();

    emailPasswordReset($email, $userId, $resetCode);


}

?>

