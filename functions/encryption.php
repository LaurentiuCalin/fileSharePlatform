<?php


function encrypt($sPassword, $sStaticSalt){
    $sRandSalt = base64_encode(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM));

    $sHashPass = password_hash($sStaticSalt.$sPassword.$sRandSalt, PASSWORD_BCRYPT);

    return '{"hashPass":"'.$sHashPass.'", "randSalt":"'.$sRandSalt.'"}';
}

//function encryptGivenRandSalt($sPassword, $sStaticSalt, $sRandSalt){
//    $sHashPass = password_hash($sStaticSalt.$sPassword.$sRandSalt, PASSWORD_BCRYPT );
//
//    return $sHashPass;
//}


// not necessary. use password_verify instead

//function loginEncrypt($inputPassword, $sStaticSalt, $db_password_salt){
//
//	$sHashPass = password_hash("sha256", $sStaticSalt.$inputPassword.$db_password_salt);
//
//	return $sHashPass;
//}
?>
