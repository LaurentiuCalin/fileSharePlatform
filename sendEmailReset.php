<?php


function emailPasswordReset($sUserEmail, $iUserId, $iResetPassCode)
{

    $to=$sUserEmail;
    $subject="Change your passowrd on AirQuick ";
    $from = 'emailconfirmation@airquick.dk';
    $body='In order to change your password click here: <a href="resetPasswordForm.php?userId='.$iUserId.'&code='.$iResetPassCode.'>link</a>.';
    $headers = "From:".$from;


    if (mail($to,$subject,$body,$headers)) {
        echo "An reset Code Is Sent To You Check You Email";
    }else{
        die("email failed");
    }

}

?>