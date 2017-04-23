<?php

session_set_cookie_params(time() + 600, "/", "", true, true);
session_start();

include_once "db/dbconnect.php";
include_once "functions/checkLoginCookie.php";
include_once "views/fileDisplay.php";

CheckLoginCookie();

if (!isset($_SESSION['logged']) || $_SESSION['logged'] != 1) {
    $_SESSION['error'] = "Please login to view this page";
    header("Location:index.php?loginModal=1");
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

<body>
<!-- Navigation -->


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
                <li>
                    <a href="dashboard.php">Home</a>
                </li>
                <li>
                    <a href="views/uploadFileForm.php">Upload</a>
                </li>
                <li>
                    <a href="dashboard.php?settings">Settings</a>
                </li>
                <li>
                    <a href="#">Contact</a>
                </li>
                <li>
                    <a href="functions/logout.php">Logout</a>
                </li>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>

<div id="main-content" class="container-fluid" style="margin-top: 50px;">
    <div class="container">
        <h2>Your files</h2>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>file name</th>
                    <th>uploaded at</th>
                    <th>options</th>
                </tr>
                </thead>
                <tbody>
                <?php
                fileDisplay($_SESSION['user']);
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- delete file confirm modal -->

<div aria-hidden="true" aria-labelledby="confirmFileDelete" class="modal fade" id="confirmFileDeleteModal" role="dialog"
     tabindex="-1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span>
                </button>
                <h2 class="modal-title">Delete file </h2>
            </div>

            <div class="modal-body">
                <p>Are you sure you want to delete the file?</p>
            </div>


            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal" type="button" onclick="window.location='controller/deleteFile.php?deleteFile=<?php echo $_GET['deleteFile'];?>'">Yes</button>
                <button class="btn btn-success" data-dismiss="modal" type="button" onclick="window.location='dashboard.php';">No</button>
            </div>
        </div>
    </div>
</div>

<script src="js/jquery.js" type="text/javascript"></script>
<script src="js/main.js" type="text/javascript"></script>
<script src="js/bootstrap.min.js"></script>
<?php
if (isset($_GET['settings'])) {
    ?>
    <script type="text/javascript">
        $("#main-content").load("settings.php");
    </script>
    <?php
}

if (isset($_GET['delete'])) {
    ?>
    <script type="text/javascript">
        function showModal() {
            $('#deleteModal').modal('show')
        }
        setTimeout(showModal, 200);
    </script>
<?php }

if (isset($_GET['deleteFile'])) {
    ?>
    <script type="text/javascript">
        $('#confirmFileDeleteModal').modal('show');
    </script>
<?php } ?>
</body>
</html>
