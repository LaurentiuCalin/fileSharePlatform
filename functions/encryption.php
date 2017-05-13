<?php


function encrypt($sPassword, $sStaticSalt)
{
    $sRandSalt = base64_encode(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM));

    $sHashPass = password_hash($sStaticSalt . $sPassword . $sRandSalt, PASSWORD_BCRYPT);

    return '{"hashPass":"' . $sHashPass . '", "randSalt":"' . $sRandSalt . '"}';
}
?>
