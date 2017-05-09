<?php

function deleteAttempts($email){

    include_once '../db/dbconnect.php';
    global $mysqli;

    $stmtDeleteAttempts = $mysqli->prepare("DELETE FROM login_attempts WHERE email = ?");
    $stmtDeleteAttempts->bind_param("s", $email);
    $stmtDeleteAttempts->execute();
    $stmtDeleteAttempts->close();

    return true;
}

?>