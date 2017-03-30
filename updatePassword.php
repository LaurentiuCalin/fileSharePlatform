<?php


function updatePassword($userId, $passCode, $newPass){

    global $sStaticSalt;
    global $mysqli;

    if ($mysqli->connect_error){
        die("Connection failed: ". $mysqli->connect_error);
        return false;
    }else{
//        checking if there is an userid associated with the resetCode
        $stmtCheckIdAndCode = $mysqli->prepare("SELECT EXISTS(SELECT * FROM users WHERE id = ? AND password_reset_code = ?)");
        $stmtCheckIdAndCode->bind_param('ss', $userId, $passCode);
        $stmtCheckIdAndCode->execute();
        $stmtCheckIdAndCode->store_result();

        if ($stmtCheckIdAndCode->num_rows){
//            the id and the reset code match, we can change the pass and set the reset code to null

            $jEnc = json_decode(encrypt($newPass, $sStaticSalt));
            $sPassEnc = $jEnc->hashPass;
            $sRandSalt = $jEnc->randSalt;

            $nullPassCode = NULL;

           //there is no need for a WHERE to select the user to be updated?
            $stmtChangePass = $mysqli->prepare("UPDATE users SET password=?, password_reset_code=?, password_salt=?");
            $stmtChangePass->bind_param('sis', $sPassEnc, $nullPassCode, $sRandSalt);
            $stmtChangePass->execute();
            $stmtChangePass->store_result();


        }else{
            die("Something went wrong, please try again!");
            return false;
        }
    }
    return true;
}


?>
