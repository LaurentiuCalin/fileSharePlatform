<?php

function emailPasswordReset($sUserEmail, $emailToken)
{
    $to=$sUserEmail;
    $subject="Change your passowrd on AirQuick ";
    $from = 'emailconfirmation@airquick.dk';
    $body='In order to change your password click here: <a href="resetPassword.php?et='.$emailToken.'>link</a>.';
    $headers = "From:".$from;


    if (mail($to,$subject,$body,$headers)) {
        echo "An reset Code Is Sent To You Check You Email";
    }else{
        die("email failed");
    }

}

?>