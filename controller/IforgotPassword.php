<?php
session_start();

if (isset($_POST['email']) && $_POST['email']) {

    $email = strtolower($_POST["email"]);

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

        include_once '../db/dbconnect.php';
        global $mysqli;

        if ($mysqli->connect_error) {
            $_SESSION['error'] = "Something went wrong! Please try again!";
            header('Location: ../views/forgotMyPassword.php');
            die();
        } else {

//            check if the user exists and save the id
            $userId = null;

            $stmtSearchUser = $mysqli->prepare("SELECT id FROM users WHERE email=?");
            $stmtSearchUser->bind_param('s', $email);
            $stmtSearchUser->execute();
            $stmtSearchUser->store_result();
            $stmtSearchUser->bind_result($userId);
            $stmtSearchUser->fetch();

            if (!empty($userId)) {

                include_once '../functions/addPassCodeandEmailit.php';
                addPassCodeandEmailIt($email, $userId);

                $_SESSION['error'] = "An email is on your way! You can reset your password using the link we sent you!";
                header('Location: ../views/forgotMyPassword.php');
                die();


            } else {
                $_SESSION['error'] = "Please enter a valid email";
                header('Location: ../views/forgotMyPassword.php');
                die();
            }
        }
    } else {
        $_SESSION['error'] = "please insert a valid email!";
        header('Location: ../views/forgotMyPassword.php');
        die();
    }
}
?>