<?php


function updatePassword($userId, $passCode, $newPass)
{

    global $sStaticSalt;
    global $mysqli;

    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    } else {
//        checking if there is an userid associated with the resetCode
        $stmtCheckIdAndCode = $mysqli->prepare("SELECT password, password_salt FROM users WHERE id = ? AND password_reset_code = ?");
        $stmtCheckIdAndCode->bind_param('ii', $userId, $passCode);
        $stmtCheckIdAndCode->execute();
        $stmtCheckIdAndCode->store_result();
        $stmtCheckIdAndCode->bind_result($oldPass, $oldSalt);

        if ($stmtCheckIdAndCode->fetch()) {

            $newPassWOldSalt = encryptGivenRandSalt($newPass, $sStaticSalt, $oldSalt);

            if ($oldPass != $newPassWOldSalt) {

                $nullPassCode = NULL;

                $jNewPassEnc = json_decode(encrypt($newPass, $sStaticSalt));
                $newPassEnc = $jNewPassEnc->hashPass;
                $sNewRandSalt = $jNewPassEnc->randSalt;


                $stmtChangePass = $mysqli->prepare("UPDATE users SET password=?, password_reset_code=?, password_salt=? WHERE id=?");
                $stmtChangePass->bind_param('sisi', $newPassEnc, $nullPassCode, $sNewRandSalt, $userId);
                $stmtChangePass->execute();
                $stmtChangePass->store_result();
            } else {
                die("Please don't use a password you used before");
            }
        } else {
            die("Something went wrong, please try again!");
        }
    }
    return true;
}


?>
