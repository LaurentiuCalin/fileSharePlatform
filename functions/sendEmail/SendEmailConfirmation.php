<?php

function emailConfirmation($sUserEmail, $emailToken)
{
    $to = $sUserEmail;
    $subject = "Activate your account on AirQuick ";
    $from = 'emailconfirmation@airquick.dk';
    $body = "This is the activation e-mail to your AirQuick account. Please Click On This <a href='controller/confirm.php?et=" . $emailToken . "'>link</a>to activate your account.";
    $headers = "From:" . $from;

    if (mail($to, $subject, $body, $headers)) {
        echo "<div class='container'>
            <div class='row'>
                <div class='col-md-4 col-md-offset-4'>
                    <div class='panel panel-default-success'>
                        <div class='panel-body'>
                            <h3><center><i class='fa fa-check-circle-o fa-4x'></i></center></h3>
                          <h5 class='text-center'>
                            <b>An Activation Code was just sent to your e-mail address.</b>
                          </h5>

                        </div>
                    </div>
                </div>
            </div>";
    } else {
        die("email failed");
    }

}

?>
