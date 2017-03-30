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
//            the id and the reset code match, we can change the pass and set the reset code to null

            $jEnc = json_decode(encrypt($newPass, $sStaticSalt));
            $sPassEnc = $jEnc->hashPass;
            $sRandSalt = $jEnc->randSalt;

            $nullPassCode = NULL;

            $stmtChangePass = $mysqli->prepare("UPDATE users SET password=?, password_reset_code=?, password_salt=? WHERE id=?");
            $stmtChangePass->bind_param('sisi', $sPassEnc, $nullPassCode, $sRandSalt, $userId);
            $stmtChangePass->execute();
            $stmtChangePass->store_result();


        }else{
            die("Something went wrong, please try again!");
        }
    }
    return true;
}


?>
