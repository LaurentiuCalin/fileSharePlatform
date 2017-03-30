<?php

$account_activation_code = $_GET['et'];

include_once '../db/dbconnect.php';
global $mysqli;

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
} else {
    $stmt = $mysqli->prepare("SELECT email_confirmation FROM users WHERE account_activation_code = ?");
    $stmt->bind_param('s', $account_activation_code);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($email_confirmation);
    $stmt->fetch();

    if ($stmt->num_rows == 1) {
        if ($email_confirmation == 0) {
            $stmtUpdate = $mysqli->prepare("UPDATE  users  SET email_confirmation = 1 WHERE account_activation_code = ?");
            $stmtUpdate->bind_param('s', $account_activation_code);
            $stmtUpdate->execute();
            $stmtUpdate->close();

            header('location: ../index.php');
            return true;
        } else {
            die('account already activated');
        }
    } else {
        die('an error has occurred');
    }
}

?>
