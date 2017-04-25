<!--it is not in any folder so that the link looks clean-->
<?php

session_set_cookie_params(time() + 600, "/", "", true, true);
session_start();

include_once "db/dbconnect.php";
include_once "functions/checkLoginCookie.php";
include_once "views/fileDisplay.php";

CheckLoginCookie();



?>

<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="IE=edge" http-equiv="X-UA-Compatible">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <meta content="" name="description">
    <meta content="" name="author">

    <title>Air Quick</title><!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body class="dashboard">


<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->


        <div class="navbar-header">
            <button class="navbar-toggle" data-target="#bs-example-navbar-collapse-1" data-toggle="collapse"
                    type="button"><span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span
                    class="icon-bar"></span> <span class="icon-bar"></span></button>
            <a class="navbar-brand" href="#">Start Bootstrap</a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->


        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">

                <?php
                if (!isset($_SESSION['logged']) || $_SESSION['logged'] != 1) {


                    echo "<li>
                    <a href=\"index.php?loginModal=1\">Login</a>
                </li>
                <li>
                    <a href=\"index.php?registerModal=1\">Register</a>
                </li>";

                }else{
                    echo "<li>
                    <a href=\"dashboard.php\">Home</a>
                </li>
                <li>
                    <a href=\"views/uploadFileForm.php\">Upload</a>
                </li>
                <li>
                    <a href=\"dashboard.php?settings\">Settings</a>
                </li>
                <li>
                    <a href=\"#\">Contact</a>
                </li>
                <li>
                    <a href=\"functions/logout.php\">Logout</a>
                </li>";
                }
                ?>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>

<?php

$fileInfo = '';

if (isset($_GET['x']) && $_GET['x']){

    $fileCode = $_GET['x'];

    if (strlen($fileCode) <= 35 && strlen($fileCode) > 0){

        include_once 'functions/getFileInfo.php';
        include_once 'db/dbconnect.php';
        $fileInfo = json_decode(getFileInfo($fileCode));



        echo "<div id=\"main-content\" class=\"container-fluid\" style=\"margin-top: 50px;\">
    <div class=\"container\">
        <h2>Your files</h2>
        <div class=\"table-responsive\">
            <table class=\"table table-striped\">
                <thead>
                <tr>
                    <th>file name</th>
                    <th>uploaded at</th>
                    <th>options</th>
                </tr>
                </thead>
                <tbody>
                <?php
                <tr><td>$fileInfo->fileName</td><td>$fileInfo->createdAt</td>
                <td><a href='files/$fileCode' download='$fileInfo->fileName'>Download</a></td></tr>
                </tbody>
            </table>
        </div>
    </div>
</div>";

    }else{
        die("Link invalid!");
        exit();
    }

}else{
    die("Link not valid!");
    exit();
}


?>

</body>
