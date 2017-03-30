
$("#resetpassword-error-message").hide();

function CheckRegistrationForm(form) {

    if (form.username.value == "") /*username not empty */{
        $("#username").parent().addClass('has-error');
        $("#usernameError").addClass('glyphicon glyphicon-remove form-control-feedback');
        form.username.focus();
        // $("#username").attr("placeholder","Do not leave the field blank!");

        return false;
    } else if (!/^[a-zA-Z]*$/g.test(form.username.value)) { /* username contains only string */
        $("#username").parent().addClass('has-error');
        $("#usernameError").addClass('glyphicon glyphicon-remove form-control-feedback');
        form.username.focus();
        return false;
    }
    if (form.email.value == "") { /* email not empty */
        form.email.focus();
        $("#email").parent().addClass('has-error');
        $("#emailError").addClass('glyphicon glyphicon-remove form-control-feedback');

        return false;
    } else { /* validate email */
        var atpos = form.email.value.indexOf("@");
        var dotpos = form.email.value.lastIndexOf(".");
        if (atpos < 1 || dotpos < atpos + 2 || dotpos + 2 >= form.email.value.length) {
            $("#email").parent().addClass('has-error');
            $("#emailError").addClass('glyphicon glyphicon-remove form-control-feedback');
            return false;
        }
    }
    var uEmail = form.email.value.toLowerCase();
    var uEmail_check = form.emailCheck.value.toLowerCase();
    // console.log(a, email_check);
    if (uEmail !== uEmail_check) { /* check email match */
        $("#emailCheck").parent().addClass('has-error');
        $("#emailCheckError").addClass('glyphicon glyphicon-remove form-control-feedback');

        return false;
    }

    if (form.password.value != "" && form.password.value == form.passwordCheck.value) { /* password not empty and matches passwordCheck */
        if (form.password.value == form.username.value) { /* password is not username */
            $("#password").parent().addClass('has-error');
            $("#passwordError").addClass('glyphicon glyphicon-remove form-control-feedback');
            form.password.focus();
            return false;
        }
        if (form.password.value == form.email.value) { /* password is not email */
            $("#password").parent().addClass('has-error');
            $("#passwordError").addClass('glyphicon glyphicon-remove form-control-feedback');
            form.password.focus();
            return false;
        }
        var re = /(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*]).{10,}/;
        if (!re.test(form.password.value)) { /* password has number, lowercase, uppercase, 10 length, special character*/
            $("#password").parent().addClass('has-error');
            $("#passwordError").addClass('glyphicon glyphicon-remove form-control-feedback');
            form.password.focus();
            return false;
        }
    } else { /* password is empty or doesn't match the check*/
        $("#password").parent().addClass('has-error');
        $("#passwordError").addClass('glyphicon glyphicon-remove form-control-feedback');
        form.password.focus();
        return false;
    }
}

function CheckLoginForm(form) {
    if (form.emailLogin.value == "") {
        $("#emailLogin").parent().addClass('has-error');
        $("#emailLoginError").addClass('glyphicon glyphicon-remove form-control-feedback');
        form.emailLogin.focus();
        return false;
    }
    if (form.PasswordLogin.value == "") {
        $("#PasswordLogin").parent().addClass('has-error');
        $("#PasswordLoginError").addClass('glyphicon glyphicon-remove form-control-feedback');
        form.PasswordLogin.focus();
        return false;
    }
}


function CheckResetPasswordForm(form) {
  if(form.resetPassword.value == ""){
    $("#resetPassword").parent().addClass('has-error');
    $("#resetPasswordError").addClass('glyphicon glyphicon-remove form-control-feedback');
    form.resetPassword.focus();
    return false;
  }
  if(form.confirmResetPassword.value == ""){
    $("#confirmResetPassword").parent().addClass('has-error');
    $("#confirmResetPasswordError").addClass('glyphicon glyphicon-remove form-control-feedback');
    form.confirmResetPassword.focus();
    return false;
  }
else if(form.resetPassword.value !== form.confirmResetPassword.value){
  $("#resetpassword-error-message").show();
  $("#resetPassword").parent().addClass('has-error');
  $("#resetPasswordError").addClass('glyphicon glyphicon-remove form-control-feedback');
  form.resetPassword.focus();
  $("#confirmResetPassword").parent().addClass('has-error');
  $("#confirmResetPasswordError").addClass('glyphicon glyphicon-remove form-control-feedback');
  form.confirmResetPassword.focus();
  return false;
}


}

  $("#resetPassword").click(function(){
    $("#resetpassword-error-message").hide();
    $("#resetPassword").parent().removeClass('has-error');
    $("#confirmResetPassword").parent().removeClass('has-error');
    $("#resetPasswordError").removeClass('glyphicon glyphicon-remove form-control-feedback');
    $("#resetPassword").val("");
    $("#confirmResetPassword").val("");

  });
