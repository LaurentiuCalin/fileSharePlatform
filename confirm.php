<?php

$email_token = $_GET['et'];

include_once 'dbconnect.php';
global $mysqli;

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
} else {
    $stmt = $mysqli->prepare("SELECT email_confirmation FROM users WHERE email_token = ?");
    $stmt->bind_param('s', $email_token);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($email_confirmation);
    $stmt->fetch();

    if ($stmt->num_rows == 1) {
        if ($email_confirmation == 0) {
            $stmtUpdate = $mysqli->prepare("UPDATE  users  SET email_confirmation = 1 WHERE email_token = ?");
            $stmtUpdate->bind_param('s', $email_token);
            $stmtUpdate->execute();
            $stmtUpdate->close();

            header('location: index.php');
            return true;
        } else {
            die('token already in use');
        }
    } else {
        die('an error has occurred');
    }
}

?>
