<?php

session_start();

include_once "db/dbconnect.php";
include_once "functions/checkLoginCookie.php";

CheckLoginCookie();

if (isset($_SESSION['logged']) || $_SESSION['logged'] == 1){
    header("Location:dashboard.php");
}

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
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="web-security-project">
        <meta name="author" content="Air-Quick">

        <title>Air Quick</title>
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/style.css" rel="stylesheet">


    </head>

    <body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
            <div class="container">
                <div class="navbar-header page-scroll">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                    <a class="navbar-brand page-scroll" href="#page-top">Air Quick</a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse navbar-ex1-collapse">
                    <ul class="nav navbar-nav right">
                        <!-- Hidden li included to remove active class from about link when scrolled up past about section -->
                        <li class="hidden">
                            <a class="page-scroll" href="#page-top"></a>
                        </li>
                        <li>
                            <a class="page-scroll" data-target="#LoginModal" data-toggle="modal" href="#">Login</a>
                        </li>
                        <li>
                            <a class="page-scroll" data-target="#registerModal" data-toggle="modal" href="#">Register</a>
                        </li>
                        <li>
                            <a class="page-scroll" href="#about">About</a>
                        </li>
                    </ul>
                </div>
                <!-- /.navbar-collapse -->
            </div>
            <!-- /.container -->
        </nav>

        <div id="messageModal" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-body">
                        <b>Successfully Registered! In order to log in, activate your account by using the link sent to your
                        e-mail.</b>
                    </div>

                </div>

            </div>
        </div>


        <!-- register modal -->
        <div aria-hidden="true" aria-labelledby="registerModalLabel" class="modal fade" id="registerModal" role="dialog" tabindex="-1">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span>
                    </button>
                        <h5 class="modal-title">Register</h5>
                        <p>
                            <?php echo $error; ?>
                        </p>

                    </div>


                    <div class="modal-body">
                        <form action="controller/register.php" autocomplete="off" class="form-horizontal" id="register-form" method="post" name="register-form" onsubmit="return CheckRegistrationForm(this);" role="form">
                            <div class="form-group">
                                <label class="col-sm-12 control-label" for="username">Username *</label>

                                <div class="col-sm-12">
                                    <input autocomplete="off" class="form-control" id="username" maxlength="30" minlength="4" name="username" oncopy="return false" onpaste="return false" placeholder="Username" required="" tabindex="1" type="text" value="">                                    <span class="" id="usernameError"></span>
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="col-sm-12 control-label" for="email">E-mail *</label>

                                <div class="col-sm-12">
                                    <input autocomplete="off" class="form-control" id="email" maxlength="256" name="email" placeholder="E-mail" required="" tabindex="1" type="email" value=""><span class="" id="emailError"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-12 control-label" for="emailCheck">Repeat e-mail *</label>

                                <div class="col-sm-12">
                                    <input autocomplete="off" class="form-control" id="emailCheck" maxlength="256" name="emailCheck" placeholder="Repeat e-mail" required="" tabindex="1" type="email" value=""><span class="" id="emailCheckError"></span>
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="col-sm-12 control-label" for="password">Password *</label>

                                <div class="col-sm-12">
                                    <input autocomplete="off" class="form-control" id="password" name="password" placeholder="Password" tabindex="1" type="password" value="Passw0rd!1"><span class="" id="passwordError"></span>
                                </div>
                            </div>
                            <!-- required="" minlength="10" oncopy="return false" onpaste="return false"-->
                            <div class="form-group">
                                <label class="col-sm-12 control-label" for="passwordCheck">Repeat password *</label>

                                <div class="col-sm-12">
                                    <input autocomplete="off" class="form-control" id="passwordCheck" name="passwordCheck" placeholder="Repeat password" tabindex="1" type="password" value="Passw0rd!1"><span class="" id="passwordCheckError"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-6 col-sm-offset-3">
                                        <input class="form-control btn btn-register btn-success" id="register-submit" name="register-submit" tabindex="4" type="submit" value="Register Now">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>



                </div>
            </div>
        </div>
        <!--  --------------------------------------end of register modal -->


        <!-- login modal -->

        <div aria-hidden="true" aria-labelledby="LoginModalLabel" class="modal fade" id="LoginModal" role="dialog" tabindex="-1">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span>
                    </button>
                        <h5 class="modal-title">Login</h5>
                        <p>
                            <?php echo $error; ?>
                        </p>

                    </div>


                    <div class="modal-body">
                        <form action="controller/login.php" autocomplete="off" class="form-horizontal" id="login-form" method="post" name="login-form" onsubmit="return CheckLoginForm(this);" role="form">
                            <div class="form-group">
                                <label class="col-sm-12 control-label" for="emailLogin">Email *</label>

                                <div class="col-sm-12">
                                    <input autocomplete="off" class="form-control" id="emailLogin" maxlength="256" name="emailLogin" oncopy="return false" onpaste="return false" placeholder="Email" required="" tabindex="1" type="email" value="">
                                    <span class="" id="emailLoginError"></span>
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="col-sm-12 control-label" for="PasswordLogin">Password *</label>

                                <div class="col-sm-12">
                                    <input autocomplete="off" class="form-control" id="PasswordLogin" maxlength="256" name="PasswordLogin" placeholder="Password" required="" tabindex="1" type="password" value=""> <span class="" id="confirmResetPasswordError"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12 ">
                                    <div class="checkbox">
                                        <label><input type="checkbox" class="checkbox-primary" name="rememberCb">Remember me</label>
                                    </div>
                                </div>
                            </div>


                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-6 col-sm-offset-3">
                                        <input class="form-control btn btn-login btn-success" id="login-submit" name="login-submit" tabindex="4" type="submit" value="Login">
<a href="views/forgotMyPassword.php" class="pull-left">reset password</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
        <!-- Intro Section -->
        <section id="intro" class="intro-section">
            <div class="container">
                <div class="row">
                    <div id="logo">
                        Air Quick
                    </div>
                    <div class="col-sm-12">
                        <h1>Share files quickly</h1>
                        <p>
                            Air Quick makes it easy to store, share and access your files from anywhere, anytime. We create product that is easy to use and is built on trust. Our users’ privacy has always been our first priority, and it always will be.

                        </p>
                        <button id="btn-register" class="btn-intro"> <a data-target="#registerModal" data-toggle="modal" href="#">Register</a> </button><span>&nbsp; </span><span>&nbsp; </span>
                        <button id="btn-login" class="btn-intro"> <a data-target="#LoginModal" data-toggle="modal" href="#">Login</a> </button>
    <div class="col-sm-12">
                        <a href="#about"><img id="arrow-down" class="arrow bounce" src="img/arrow-down.svg" /></a>
                      </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- About Section -->
        <section id="about" class="about-section">
            <div class="container">
                <div class="row">

                    <div class="col-lg-12">
                        <h1>Keep your files safe, secure, and private.</h1>
                    </div>

                        <div id="one">
                            <div class="about-container col-lg-4 col-md-6 col-sm-12">
                                <h3>
                            100% private cloud
                        </h3>
                                <img src="img/1.svg" class="img-responsive" />
                                <p>
                                    Lorem ipsum dolor sit amet, soluta fabellas sententiae et pro. Ei mazim nominavi mediocritatem sea, nec alterum appareat an.
                                </p>
                            </div>
                        </div>
                        <div id="two">
                            <div class="about-container col-lg-4 col-md-6 col-sm-12">
                                <h3>
                          Automatic backup and sync
                      </h3>
                                <img src="img/1.svg" class="img-responsive" />
                                <p>
                                    Lorem ipsum dolor sit amet, soluta fabellas sententiae et pro. Ei mazim nominavi mediocritatem sea, nec alterum appareat an.
                                </p>
                            </div>
                        </div>
                        <div id="three">
                            <div class="about-container col-lg-4 col-md-6 col-sm-12">
                                <h3>
                        Access from anywhere
                      </h3>
                                <img src="img/1.svg" class="img-responsive" />
                                <p>
                                    Lorem ipsum dolor sit amet, soluta fabellas sententiae et pro. Ei mazim nominavi mediocritatem sea, nec alterum appareat an.
                                </p>
                            </div>
                        </div>
                        <div id="four">
                            <div class="about-container col-lg-4 col-md-6 col-sm-12">
                                <h3>
                        Share files securely
                      </h3>
                                <img src="img/1.svg" class="img-responsive" />
                                <p>
                                    Lorem ipsum dolor sit amet, soluta fabellas sententiae et pro. Ei mazim nominavi mediocritatem sea, nec alterum appareat an.
                                </p>
                            </div>
                        </div>
                        <div id="five">
                            <div class="about-container col-lg-4 col-md-6 col-sm-12">
                                <h3>
                        Fast sharing
                      </h3>
                                <img src="img/1.svg" class="img-responsive" />
                                <p>
                                    Lorem ipsum dolor sit amet, soluta fabellas sententiae et pro. Ei mazim nominavi mediocritatem sea, nec alterum appareat an.
                                </p>
                            </div>
                        </div>
                        <div id="six">
                            <div class="about-container col-lg-4 col-md-6 col-sm-12">
                                <h3>
                        Cheap
                      </h3>
                                <img src="img/1.svg" class="img-responsive" />
                                <p>
                                    Lorem ipsum dolor sit amet, soluta fabellas sententiae et pro. Ei mazim nominavi mediocritatem sea, nec alterum appareat an.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Services Section -->


        <!-- Contact Section -->
        <!-- <section id="contact" class="contact-section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <h1>contact</h1>
                    </div>
                </div>
            </div>
        </section> -->

      <!-- Footer -->
        <section id="footer" class="footer-section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <span>
                          Air Quick 2017 © All rights reserved.
                        </span>
                    </div>
                </div>
            </div>
        </section>

        <script src="js/jquery.js" type="text/javascript"></script>
        <script src="https://unpkg.com/scrollreveal/dist/scrollreveal.min.js"></script>
        <script src="js/main.js" type="text/javascript"></script>
        <script src="js/bootstrap.min.js"></script>
        <script>
        // $(document).ready(function()
        // {
        //   $("#LoginModal").modal('show');
        // })
            $(function smoothScroll() {
                $('a[href*=#]:not([href=#])').click(function() {
                    if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
                        var target = $(this.hash);
                        target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                        if (target.length) {
                            $('html,body').animate({
                                scrollTop: target.offset().top
                            }, 1500);
                            return false;
                        }
                    }
                });
            });
        </script>

        <?php
    if (isset($_GET['loginModal']) && $_GET['loginModal'] == 1) { ?>
            <script type='text/javascript'>
                $("#LoginModal").modal('show');
            </script>
            <?php }

    if (isset($_GET['registerModal']) && $_GET['registerModal'] == 1) { ?>
            <script type='text/javascript'>
                $("#registerModal").modal('show');
            </script>
            <?php }
    if (isset($_GET['messageModal']) && $_GET['messageModal'] == 1) { ?>
            <script type='text/javascript'>
                $("#messageModal").modal('show');
            </script>

            <?php } ?>

    </body>

    </html>
