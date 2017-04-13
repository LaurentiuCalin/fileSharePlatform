<?php
/**
 * Created by PhpStorm.
 * User: calin
 * Date: 08-Apr-17
 * Time: 5:22 PM
 */

$error = "";

if (isset($_SESSION['error']) && !empty($_SESSION['error'])) {
    $error = $_SESSION['error'];
    unset($_SESSION['error']);
}
?>
<h1>Settings</h1>
<br>
<div class="col-md-3 col-md-offset-1">
    <ul>
        <li>
            <a href="views/forgotMyPassword.php">Change your password</a>
        </li>
        <li>
            <a data-target="#confirmDeleteModal" data-toggle="modal" href="#">Delete account</a>
        </li>
    </ul>
</div>

<!-- delete account confirm modal -->

<div aria-hidden="true" aria-labelledby="confirmDelete" class="modal fade" id="confirmDeleteModal" role="dialog"
     tabindex="-1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span>
                </button>
                <h2 class="modal-title">Delete your account</h2>
            </div>

            <div class="modal-body">
                <p>By deleting your account you will lose access to the platform and all the files uploaded will be
                    deleted.</p>
                <p class="pull-right">Are you sure you want to continue?</p><br>
            </div>


            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal" data-target="#deleteModal" data-toggle="modal"
                        type="button">Confirm
                </button>
                <button class="btn btn-success" data-dismiss="modal" type="button">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- delete account modal -->

<div aria-hidden="true" aria-labelledby="DeleteModalLabel" class="modal fade" id="deleteModal" role="dialog"
     tabindex="-1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span>
                </button>
                <h2 class="modal-title">Delete your account</h2>
                <h4>Confirm your email and password in order to complete the account removal</h4>
                <p><?php echo $error; ?></p>

            </div>


            <div class="modal-body">
                <form action="controller/deleteAccount.php" autocomplete="off" class="form-horizontal"
                      id="deleteAccount-form" method="post" name="deleteAccount-form" role="form">
                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="EmailDelete">Email</label>

                        <div class="col-sm-8">
                            <input autocomplete="off" class="form-control" id="EmailDelete" maxlength="256"
                                   name="EmailDelete" oncopy="return false" onpaste="return false" placeholder="Email"
                                   required tabindex="1" type="email" value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="PasswordDelete">Password</label>
                        <div class="col-sm-8">
                            <input autocomplete="off" class="form-control" id="PasswordDelete" maxlength="256"
                                   name="PasswordDelete" placeholder="Password" required tabindex="1" type="password"
                                   value="">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-6 col-sm-offset-3">
                                <input class="form-control btn btn-login btn-danger" id="delete-submit"
                                       name="delete-submit"
                                       tabindex="4" type="submit" value="DELETE ACCOUNT">
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
