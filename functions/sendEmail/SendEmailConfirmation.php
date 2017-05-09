<?php

function emailConfirmation($sUserEmail, $emailToken)
{
    require("PHPMailer_5.2.0/class.phpmailer.php");

    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->SMTPDebug = 2;
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'tls';
    $mail->Host = "smtp.gmail.com";
    $mail->Mailer = "smtp";
    $mail->Port = 587;
    $mail->Username = "airquickmailer@gmail.com";
    $mail->Password = "I love Mondays!";

    $mail->From = "airquickmailer@gmail.com";
    $mail->FromName = "Air Quick";

    $mail->AddAddress($sUserEmail);       // name is optional


    $mail->WordWrap = 50;                                 // set word wrap to 50 characters
    $mail->IsHTML(true);                                  // set email format to HTML

    $mail->Subject = "Here is the subject";
    $mail->Body    = "Click <a href=http://188.226.141.170/controller/confirm.php?et=".$emailToken.">here</a> to activate your AirQuick account!";
    $mail->AltBody = "Go to the link below to activate your AirQuick account http://188.226.141.170/controller/confirm.php?et=".$emailToken;

if(!$mail->Send())
{
   echo "Message could not be sent. <p>";
   echo "Mailer Error: " . $mail->ErrorInfo;
   exit;
}

    // echo "Message has been sent";
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




    // $to = $sUserEmail;
    // $subject = "Activate your account on AirQuick ";
    // $from = 'emailconfirmation@airquick.dk';
    // $body = "This is the activation e-mail to your AirQuick account. Please Click On This <a href='controller/confirm.php?et=" . $emailToken . "'>link</a>to activate your account.";
    // $headers = "From:" . $from;

    // if (mail($to, $subject, $body, $headers)) {
        // echo "<div class='container'>
        //     <div class='row'>
        //         <div class='col-md-4 col-md-offset-4'>
        //             <div class='panel panel-default-success'>
        //                 <div class='panel-body'>
        //                     <h3><center><i class='fa fa-check-circle-o fa-4x'></i></center></h3>
        //                   <h5 class='text-center'>
        //                     <b>An Activation Code was just sent to your e-mail address.</b>
        //                   </h5>

        //                 </div>
        //             </div>
        //         </div>
        //     </div>";
    // } else {
    //     die("email failed");
    // }

}

?>
