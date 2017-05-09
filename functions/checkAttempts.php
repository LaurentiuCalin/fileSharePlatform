<?php

function checkAttempts($email)
{
    global $mysqli;

    $stmt = $mysqli->prepare("SELECT attempts, last_attempt FROM login_attempts WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($attempts, $last_attempt);
    $stmt->fetch();
    if ($stmt->num_rows == 1) {
        $stmt->close();
        if ($attempts < 5) {
            if ((time() - strtotime($last_attempt)) > 300) {
                include_once 'deleteAttempts.php';
                deleteAttempts($email);
            } else {
                if ($attempts < 3) {
                    return true;
                } else {
                    //the user has to wait some time because of the failed attempts
                    return '{"error":"3"}'; //,"message":"wait 5 minutes. too many attempts"}
                }
            }
        } else {
            //user has to reset the password
            return '{"error":"5"}'; //,"message":"too many attempts! a password reset email has been sent to your email address"
        }
    } else {
        // there are no previous attempts
        return true;
    }

}

?>