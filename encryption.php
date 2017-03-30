<?php


function encrypt($sPassword, $sStaticSalt){
    $sRandSalt = base64_encode(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM));

    $sHashPass = hash("sha256", $sStaticSalt.$sPassword.$sRandSalt);

    return '{"hashPass":"'.$sHashPass.'", "randSalt":"'.$sRandSalt.'"}';
}

function loginEncript($inputPassword, $sStaticSalt, $db_password_salt){

	$sHashPass = hash("sha256", $sStaticSalt.$inputPassword.$db_password_salt);

	return $sHashPass;
}
?>
