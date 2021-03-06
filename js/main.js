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
    if (form.resetPassword.value == "") {
        $("#resetPassword").parent().addClass('has-error');
        $("#resetPasswordError").addClass('glyphicon glyphicon-remove form-control-feedback');
        form.resetPassword.focus();
        return false;
    }
    if (form.confirmResetPassword.value == "") {
        $("#confirmResetPassword").parent().addClass('has-error');
        $("#confirmResetPasswordError").addClass('glyphicon glyphicon-remove form-control-feedback');
        form.confirmResetPassword.focus();
        return false;
    }
    else if (form.resetPassword.value !== form.confirmResetPassword.value) {
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

$("#resetPassword").click(function () {
    $("#resetpassword-error-message").hide();
    $("#resetPassword").parent().removeClass('has-error');
    $("#confirmResetPassword").parent().removeClass('has-error');
    $("#resetPasswordError").removeClass('glyphicon glyphicon-remove form-control-feedback');
    $("#resetPassword").val("");
    $("#confirmResetPassword").val("");

});
//jQuery to collapse the navbar on scroll
$(window).scroll(function () {
    if ($(".navbar").offset().top > 700) {
        $(".navbar-fixed-top").addClass("top-nav-collapse");
    } else {
        $(".navbar-fixed-top").removeClass("top-nav-collapse");
    }
});

$(window).scroll(function () {

    var $theWindowSize = $(this).width();

    if ($(this).scrollTop() > 700) {
        $('.navbar-brand').show();
    } else if ($theWindowSize < 768) {
        $('.navbar-brand').show();
    } else {
        $('.navbar-brand').hide();

    }

});


var fooReveal = {
    delay: 300,
    distance: '300px',
    origin: 'left',

};

// window.sr = ScrollReveal();
// sr.reveal('#one', fooReveal);
// sr.reveal('#two', {
//     delay: 600,
// });
// sr.reveal('#three', {
//     delay: 900,
// });
// sr.reveal('#four', {
//     delay: 1200,
// });
// sr.reveal('#five', {
//     delay: 1500,
// });
// sr.reveal('#six', {
//     delay: 1800,
// });

$(document).on("click", ".comments_link", function () {
   var linkFileCode = $(this).data("filecode");
   $("#comment-form").attr('action', 'controller/addComment.php?fileCode='+linkFileCode+'');

   $.ajax({
       "url":"controller/getComments.php",
       "method":"POST",
       "cache":"false",
       "data":{fileCode:linkFileCode}
   }).done(function (comments) {

       var jComments = JSON.parse(comments);

       // console.log(jComments);

       var container = $('.comments-container');
       container = container.html("");

       var commentTemplate = ' <div class="row comment-container">\
           <div class="username">\
           <b>{{username}}</b>\
           </div>\
           <div class="date container">\
           <i>{{date}}</i>\
       </div>\
       <div class="comment-container">\
           <span>{{body}}</span>\
       </div>\
       </div>';

       for(var i = 0; i < jComments.length; i++){

           var comment = JSON.parse(jComments[i]);

           // console.log(c.username);

           template = commentTemplate.replace("{{username}}", comment.username).replace("{{date}}", comment.commentDate).replace("{{body}}", comment.commentBody);
           // template += commentTemplate.replace("{{date}}", comment.commentDate);
           // template += commentTemplate.replace("{{body}}", comment.commentBody);

           container.append(template);
       }
       
   })


});

