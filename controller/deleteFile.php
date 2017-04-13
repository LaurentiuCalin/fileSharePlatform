<?php

session_set_cookie_params(time() + 600, "/", "", true, true);
session_start();

include_once "../db/dbconnect.php";
include_once "../functions/checkLoginCookie.php";
include_once "../functions/addFileInfoDatabase.php";

CheckLoginCookie();

if (!isset($_SESSION['logged']) || $_SESSION['logged'] != 1) {
    $_SESSION['error'] = "Please login to view this page";
    header("Location:index.php?loginModal=1");
} else {
    if (isset($_GET['deleteFile']) && !empty($_GET['deleteFile'])) {
        $fileToDelete = "files/" . $_GET['deleteFile'];
        global $mysqli;
        $stmt = $mysqli->prepare("SELECT user_id FROM files WHERE path_to_file = ?");
        $stmt->bind_param("s", $fileToDelete);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($db_uid);
        $stmt->fetch();

        if ($stmt->num_rows == 1) {
            $stmt->close();
            if ($_SESSION['user'] == $db_uid) {

                $fileSize = filesize("../" . $fileToDelete);

                $fileSize = $fileSize * -1;

                unlink("../" . $fileToDelete);

                $stmt = $mysqli->prepare("DELETE FROM files WHERE path_to_file = ?");
                $stmt->bind_param("s", $fileToDelete);
                $stmt->execute();
                $stmt->close();

                updateUserAvailableSpace($db_uid, $fileSize);

                header("location:../dashboard.php");
                die();

            } else {
                header("location:../logout.php");
                die();
            }
        }
    } else {
        header("location:../index.php");
        die();
    }
}


?>