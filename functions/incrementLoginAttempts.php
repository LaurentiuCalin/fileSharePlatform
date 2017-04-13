<?php
function addToAttempts($email)
{
    global $mysqli;
    $stmt = $mysqli->prepare("SELECT attempts, last_attempt FROM login_attempts WHERE email =  ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($attempts, $lastAttempt);
    $stmt->fetch();

    if ($stmt->num_rows == 1) {
        $stmt->close();
        $stmtInc = $mysqli->prepare("UPDATE login_attempts SET attempts = attempts + 1 , last_attempt = NOW() WHERE email = ?");
        $stmtInc->bind_param("s", $email);
        $stmtInc->execute();
        $stmtInc->close();
    } else {

        $stmt = $mysqli->prepare("SELECT id FROM users WHERE email =  ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($db_uid);
        $stmt->fetch();
        $stmt->close();

        $stmtCreate = $mysqli->prepare("INSERT INTO login_attempts (email, userid, last_attempt, attempts) VALUES (?,?,NOW(),1)");
        $stmtCreate->bind_param('ss', $email, $db_uid);
        $stmtCreate->execute();
        $stmtCreate->close();
    }
}

?>