<?php

function addToDatabase($sUserName, $sUserEmail, $sPassEnc, $sRandSalt, $emailToken){

    global $mysqli;

    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }else
    {
        $stmtCheckEmail = $mysqli->prepare("SELECT id FROM users WHERE email = ?");
        $stmtCheckEmail->bind_param('s', $sUserEmail);
        $stmtCheckEmail->execute();
        $stmtCheckEmail->store_result();

        if ($stmtCheckEmail->num_rows){
            die("mail in use");
        }
        else{
            $stmt = $mysqli->prepare("INSERT INTO users (username, email, password, password_salt, email_token) VALUES (?,?,?,?,?)");
            $stmt->bind_param("sssss", $sUserName, $sUserEmail, $sPassEnc, $sRandSalt, $emailToken);
            $stmt->execute();
            $stmt->close();
            $mysqli->close();
            return true;
        }
    }

}

?>
