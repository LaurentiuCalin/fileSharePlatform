<?php

function addToDatabase($sUserId, $sUserName, $sUserEmail, $sPassEnc, $sRandSalt, $account_activation_code)
{

    global $mysqli;

    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }
    else {
        $stmtCheckEmail = $mysqli->prepare("SELECT id FROM users WHERE email = ?");
        $stmtCheckEmail->bind_param('s', $sUserEmail);
        $stmtCheckEmail->execute();
        $stmtCheckEmail->store_result();

        if ($stmtCheckEmail->num_rows) {
            die("mail in use");
        }
        else {
            $stmt = $mysqli->prepare("INSERT INTO users (id, username, email, password, password_salt, account_activation_code) VALUES (?,?,?,?,?,?)");
            $stmt->bind_param("ssssss", $sUserId, $sUserName, $sUserEmail, $sPassEnc, $sRandSalt, $account_activation_code);
            $stmt->execute();
            $stmt->close();
            $mysqli->close();
            return true;
        }
    }

}

?>
