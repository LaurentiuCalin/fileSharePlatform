    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta content="IE=edge" http-equiv="X-UA-Compatible">
        <meta content="width=device-width, initial-scale=1" name="viewport">
        <meta content="" name="description">
        <meta content="" name="author">

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/style.css" rel="stylesheet">
    </head>

    <body class="body-reset-password">
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="text-center">
                                <h3><i class="fa fa-lock fa-4x"></i></h3>
                                <h2 class="text-center">Forgot your Password?</h2>
                                <p>You can reset it here.</p>
                                <p class="resetpassword-error-message" id="resetpassword-error-message"><b>Password does not match!</b></p>
                                <div class="panel-body">
                                    <form id="resetPasswordform" action="resetPassword.php?userId=<?php echo $userId;?>&passCode=<?php echo $passCode;?>" role="form" autocomplete="off" class="form" method="post" onsubmit="return CheckResetPasswordForm(this);">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <input id="resetPassword" type="password" name="newPassword" placeholder="New password" class="form-control" onpaste="return false" autocomplete="off" for="resetPassword" value="">
                                                <span class="" id="resetPasswordError"></span>
                                                <input id="confirmResetPassword" type="password" name="confirmNewPassword" placeholder="Confirm your new password" class="form-control" onpaste="return false" autocomplete="off" for="confirmResetPassword" value="">
                                                <span class="" id="confirmResetPasswordError"></span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <input id="btn-new-password" name="recover-submit" class="btn btn-lg btn-primary btn-block" value="Reset Password" type="submit">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <script src="js/main.js" type="text/javascript"></script>
        <script src="js/jquery.js" type="text/javascript"></script>

    </body>

    </html>
