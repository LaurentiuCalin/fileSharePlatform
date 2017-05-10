<?php

function Cookie($id)
{
    global $mysqli;

//    $stmtSelect = $mysqli->prepare("SELECT * FROM auth_tokens WHERE userid = ? ");
//    $stmtSelect->bind_param('s', $id);
//    $stmtSelect->execute();
//    $stmtSelect->store_result();
//    $stmtSelect->close();

    $selector = base64_encode(mcrypt_create_iv(10, MCRYPT_DEV_URANDOM));

    $token = base64_encode(mcrypt_create_iv(64, MCRYPT_DEV_URANDOM));

    $hashToken = hash('sha256', $token);

    $expires = strtotime('+30 days');

    $stmt = $mysqli->prepare("INSERT INTO auth_tokens (selector, token, userid, expires) VALUES (?,?,?,?)");
    $stmt->bind_param("ssss", $selector, $hashToken, $id, $expires);
    $stmt->execute();
    $stmt->close();

    setcookie("aqInfo", $selector . "." . $token, $expires, '/', '');
}