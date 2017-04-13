

<?php
session_start();

//need to check if the user is logged in with SESSION
//add protected checkbox for the file

$error = "";

if (isset($_SESSION['error'])) {
    $error = $_SESSION['error'];
    unset($_SESSION['error']);
}

if (!isset($_SESSION['user'])){
    die("please log in");
}else{

}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="IE=edge" http-equiv="X-UA-Compatible">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <meta content="" name="description">
    <meta content="" name="author">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
</head>

<body class="body-reset-password">

<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="text-center">
                        <h3><i class="fa fa-cloud-upload fa-4x"></i></h3>
                        <h2 class="text-center">Upload file here</h2>
                        <p id="myError" style="color:red;">
                            <?php echo $error; ?>
                        </p>
                        <p class="resetpassword-error-message" id="resetpassword-error-message"><b>Password does not
                                match!</b></p>
                        <div class="panel-body">
                            <form id="resetPasswordform"
                                  action="../controller/uploadFile.php"
                                  role="form" autocomplete="off" class="form" method="post" enctype="multipart/form-data">
<!--                                  onsubmit="return (this);">-->
                                <div class="form-group">
                                    <div class="input-group">
                                        <label>Please select or drag your file here</label>
                                        <input id="inputEmail" type="file" name="fileToUpload" class="form-control" value="">
                                        <span class="" id="resetPasswordError"></span>
                                        <span class="" id="confirmResetPasswordError"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input id="btn-new-password" name="submit"
                                           class="btn btn-lg btn-primary btn-block" value="Upload file"
                                           type="submit">
                                </div>
                            </form>



                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="../js/jquery.js" type="text/javascript"></script>
    <script src="../js/main.js" type="text/javascript"></script>

</body>

</html>

