<?php

//if (isset($_COOKIE['aqInfo']))

session_start();

$error = '';

if (isset($_SESSION['error']) && !empty($_SESSION['error'])){
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
    <meta content="" name="web-security">
    <meta content="" name="DanielLaurentiuOla">

    <title>Air Quick</title>
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
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->


        <div class="navbar-header">
            <button class="navbar-toggle" data-target="#bs-example-navbar-collapse-1" data-toggle="collapse"
                    type="button"><span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span
                        class="icon-bar"></span> <span class="icon-bar"></span></button>
            <a class="navbar-brand" href="#">Logo</a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->


        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav right">
                <li>
                    <a data-target="#registerModal" data-toggle="modal" href="#">Register</a>
                </li>


                <li>
                    <a data-target="#LoginModal" data-toggle="modal" href="#">Login</a>
                </li>


                <li>
                    <a href="#">Contact</a>
                </li>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>

<!-- register modal -->
<div aria-hidden="true" aria-labelledby="registerModalLabel" class="modal fade" id="registerModal" role="dialog"
     tabindex="-1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Register</h5>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span>
                </button>
            </div>


            <div class="modal-body">
                <form action="controller/register.php" autocomplete="off" class="form-horizontal" id="register-form"
                      method="post" name="register-form" onsubmit="return CheckRegistrationForm(this);" role="form">
                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="username">Username</label>

                        <div class="col-sm-8">
                            <input autocomplete="off" class="form-control" id="username" maxlength="30" minlength="4"
                                   name="username" oncopy="return false" onpaste="return false" placeholder="Username"
                                   required="" tabindex="1" type="text" value=""> <span class=""
                                                                                        id="usernameError"></span>
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="email">E-mail</label>

                        <div class="col-sm-8">
                            <input autocomplete="off" class="form-control" id="email" maxlength="256" name="email"
                                   placeholder="E-mail" required="" tabindex="1" type="email" value=""><span class=""
                                                                                                             id="emailError"></span>
                        </div>
                    </div>
                    <!--oncopy="return false" onpaste="return false"-->

                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="emailCheck">Repeat e-mail</label>

                        <div class="col-sm-8">
                            <input autocomplete="off" class="form-control" id="emailCheck" maxlength="256"
                                   name="emailCheck" placeholder="Repeat e-mail" required="" tabindex="1" type="email"
                                   value=""><span class="" id="emailCheckError"></span>
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="password">Password</label>

                        <div class="col-sm-8">
                            <input autocomplete="off" class="form-control" id="password" name="password"
                                   placeholder="Password" tabindex="1" type="password" value=""><span class=""
                                                                                                      id="passwordError"></span>
                        </div>
                    </div>
                    <!-- required="" minlength="10" oncopy="return false" onpaste="return false"-->
                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="passwordCheck">Repeat password</label>

                        <div class="col-sm-8">
                            <input autocomplete="off" class="form-control" id="passwordCheck" name="passwordCheck"
                                   placeholder="Repeat password" tabindex="1" type="password" value=""><span class=""
                                                                                                             id="passwordCheckError"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-6 col-sm-offset-3">
                                <input class="form-control btn btn-register btn-success" id="register-submit" name="register-submit"
                                       tabindex="4" type="submit" value="Register Now">
                            </div>
                        </div>
                    </div>
                </form>
            </div>


            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal" type="button">Close</button>
            </div>
        </div>
    </div>
</div>
<!--  --------------------------------------end of register modal -->


<!-- login modal -->

<div aria-hidden="true" aria-labelledby="LoginModalLabel" class="modal fade" id="LoginModal" role="dialog"
     tabindex="-1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Login</h5>
                <p><?php echo $error; ?></p>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span>
                </button>
            </div>


            <div class="modal-body">
                <form action="controller/login.php" autocomplete="off" class="form-horizontal" id="login-form"
                      method="post" name="login-form" onsubmit="return CheckLoginForm(this);" role="form">
                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="emailLogin">Email</label>

                        <div class="col-sm-8">
                            <input autocomplete="off" class="form-control" id="emailLogin" maxlength="256"
                                   name="emailLogin" oncopy="return false" onpaste="return false" placeholder="Email"
                                   required="" tabindex="1" type="email" value=""> <span class=""
                                                                                         id="emailLoginError"></span>
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="PasswordLogin">Password</label>

                        <div class="col-sm-8">
                            <input autocomplete="off" class="form-control" id="PasswordLogin" maxlength="256"
                                   name="PasswordLogin"                                   placeholder="Password" required="" tabindex="1" type="password" value=""> <span
                                    class="" id="confirmResetPasswordError"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-4 col-sm-offset-8">
                            <div class="checkbox">
                                <label><input type="checkbox" name="rememberCb">Remember me</label>
                            </div>
                        </div>
                    </div>


                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-6 col-sm-offset-3">
                                <input class="form-control btn btn-login btn-success" id="login-submit" name="login-submit"
                                       tabindex="4" type="submit" value="Login">
                            </div>
                        </div>
                    </div>
                </form>
            </div>


            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal" type="button">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="container intro">
  <div class="content">
    <div id="large-header" class="large-header">
      <canvas id="demo-canvas"></canvas>
      <h1 class="main-title">Air-Quick </h1>
    </div>
<footer>
           <div class="row">
               <div class="col-lg-12">
                   <p class="text-center">Copyright &copy; Air-Quick 2017</p>
               </div>
           </div>
           <!-- /.row -->
       </footer>

</section>

<script src="js/jquery.js" type="text/javascript"></script>
<script src="js/main.js" type="text/javascript"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/TweenLite.min.js"></script>
<script src="js/EasePack.min.js"></script>
<script src="js/rAF.js"></script>
<script src="js/bg.js"></script>
<?php
if (isset($_GET['loginModal']) && $_GET['loginModal'] == 1){ ?>
    <script type = 'text/javascript'>
        $("#LoginModal").modal('show');
    </script>
<?php } ?>
</body>
</html>
