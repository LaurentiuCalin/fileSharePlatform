<?php

function checkAttempts($email)
{
    global $mysqli;

    if ($stmt = $mysqli->prepare("SELECT attempts, last_attempt FROM login_attempts WHERE email = ?")) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($attempts, $last_attempt);
        $stmt->fetch();
        if ($stmt->num_rows == 1) {
            $stmt->close();
            if ((time() - strtotime($last_attempt)) > 30) {
                $stmtDeleteAttempts = $mysqli->prepare("DELETE FROM login_attempts WHERE email = ?");
                $stmtDeleteAttempts->bind_param("s", $email);
                $stmtDeleteAttempts->execute();
                $stmtDeleteAttempts->close();

                return true;
            }
            if ($attempts < 5) {
                return true;
            } else {
                return false;
            }

        } else {
            return true;
        }
    } else {
        return false;
    }
}

function addToAttempts($email)
{
    global $mysqli;
    $stmt = $mysqli->prepare("SELECT attempts, last_attempt FROM login_attempts WHERE email =  ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($attempts, $lastAttempt);


    if ($stmt->num_rows == 1) {
        $stmt->close();
        $stmtInc = $mysqli->prepare("UPDATE login_attempts SET attempts = attempts + 1 , last_attempt = NOW()");
        $stmtInc->execute();
        $stmtInc->close();

        if ($attempts == 5) {

        }

        die();

    } else {
        $stmtCreate = $mysqli->prepare("INSERT INTO login_attempts (email, last_attempt, attempts) VALUES (?,NOW(),1)");
        $stmtCreate->bind_param("s", $email);
        $stmtCreate->execute();
        $stmtCreate->close();

        die();
    }


}


?>