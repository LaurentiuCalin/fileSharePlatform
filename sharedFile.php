<!--it is not in any folder so that the link looks clean-->
<?php

session_set_cookie_params(time() + 600, "/", "", true, true);
session_start();

include_once "db/dbconnect.php";
include_once "functions/checkLoginCookie.php";
include_once "views/fileDisplay.php";

CheckLoginCookie();



$error = '';

if (isset($_SESSION['error']) && !empty($_SESSION['error'])) {
    $error = $_SESSION['error'];
    unset($_SESSION['error']);
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
                    $userCanComment = "";
                    echo "<li>
                    <a href=\"index.php?loginModal=1\">Login</a>
                </li>
                <li>
                    <a href=\"index.php?registerModal=1\">Register</a>
                </li>";

                } else {

                    $userCanComment = "| <a data-target='#CommentModal' data-toggle='modal' href='#' class='comments_link' data-filecode='".$_GET['x']."'>Comments</a>";

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

                $fileInfo = '';

                if (isset($_GET['x']) && $_GET['x']) {

                    $fileCode = $_GET['x'];

                    if (strlen($fileCode) <= 35 && strlen($fileCode) > 0) {

                        include_once 'functions/getFileInfo.php';
                        include_once 'db/dbconnect.php';
                        $fileInfo = json_decode(getFileInfo($fileCode));


                        echo "<tr><td>$fileInfo->fileName</td><td>$fileInfo->createdAt</td>
                <td><a href='files/$fileCode' download='$fileInfo->fileName'>Download</a> $userCanComment</td></tr>";

                    } else {
                        die("Link invalid!");
                    }
                } else {
                    die("Link not valid!");
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!--comment modal-->

<div aria-hidden="true" aria-labelledby="CommentModalLabel" class="modal fade" id="CommentModal" role="dialog"
     tabindex="-1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title">Comments</h5>
                <p>
                    <?php echo $error; ?>
                </p>

            </div>


            <div class="modal-body">
                <div class="container comments-container">
                </div>

                <form action="controller/addComment.php?fileCode=<?php echo $fileCode; ?>" class="form-horizontal" id="comment-form" method="post"
                      name="comment-form" role="form">
                    <div class="form-group">
                        <label class="col-sm-12 control-label" for="comment_textbox">Comment*</label>

                        <div class="col-sm-12">
                            <input class="form-control" id="comment_textbox" maxlength="255" name="comment"
                                   placeholder="Comment" required tabindex="1" type="text">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-6 col-sm-offset-3">
                                <input class="form-control btn btn-login btn-success" id="comment-submit"
                                       name="comment-submit" tabindex="4" type="submit" value="Add">
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<script src="js/jquery.js" type="text/javascript"></script>
<script src="https://unpkg.com/scrollreveal/dist/scrollreveal.min.js"></script>
<script src="js/main.js" type="text/javascript"></script>
<script src="js/bootstrap.min.js"></script>

</body>
</html>