<?php


function emailPasswordReset($sUserEmail, $iUserId, $iResetPassCode)
{

    $to=$sUserEmail;
    $subject="Change your password on AirQuick ";
    $from = 'emailconfirmation@airquick.dk';
    $body="In order to change your password click here: <a href='../../resetPasswordForm.php?userId=$iUserId&code=$iResetPassCode'>link</a>.";
    $headers = "From:".$from;

    if (mail($to,$subject,$body,$headers)) {
        echo "<div class='container'>
            <div class='row'>
                <div class='col-md-4 col-md-offset-4'>
                    <div class='panel panel-default-success'>
                        <div class='panel-body'>
                            <h3><center><i class='fa fa-check-circle-o fa-4x'></i></center></h3>
                          <h5 class='text-center'>
                            <b>A reset code was sent to your e-mail.</b>
                          </h5>

                        </div>
                    </div>
                </div>
            </div>";
    }else{
        die("email failed");
    }

}

?>
