<?php


function updatePassword($userId, $passCode, $newPass){

    global $sStaticSalt;
    global $mysqli;

    if ($mysqli->connect_error){
        die("Connection failed: ". $mysqli->connect_error);
    }else{
//        checking if there is an userid associated with the resetCode
        $stmtCheckIdAndCode = $mysqli->prepare("SELECT EXISTS(SELECT * FROM users WHERE id = ? AND password_reset_code = ?)");
        $stmtCheckIdAndCode->bind_param('is', $userId, $passCode);
        $stmtCheckIdAndCode->execute();
        $stmtCheckIdAndCode->store_result();

        if ($stmtCheckIdAndCode->num_rows){

            $jNewEnc = json_decode(encrypt($newPass, $sStaticSalt));
            $NewPassEnc = $jNewEnc->hashPass;
            $NewRandSalt = $jNewEnc->randSalt;

            $stmtCheckOldPass = $mysqli->prepare("SELECT password FROM users WHERE id = ? AND password_reset_code = ?");
            $stmtCheckIdAndCode->bind_param('is', $userId, $passCode);
            $stmtCheckOldPass->execute();
            $stmtCheckIdAndCode->store_result();
            $stmtCheckOldPass->bind_result($OldPasswordEnc);

            if ($NewPassEnc != $OldPasswordEnc){

                $nullPassCode = NULL;

                $stmtChangePass = $mysqli->prepare("UPDATE users SET password=?, password_reset_code=?, password_salt=? WHERE id=?");
                $stmtChangePass->bind_param('sisi', $NewPassEnc, $nullPassCode, $NewRandSalt, $userId);
                $stmtChangePass->execute();
                $stmtChangePass->store_result();
            }
            else{
                die("Please don't use a password you used before");
            }
        }else{
            die("Something went wrong, please try again!");
        }
    }
    return true;
}


?>
