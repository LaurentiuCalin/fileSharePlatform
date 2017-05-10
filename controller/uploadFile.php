<?php

session_set_cookie_params(time() + 600, "/", "", true, true);
session_start();

include_once "../db/dbconnect.php";
include_once "../functions/checkLoginCookie.php";

CheckLoginCookie();

if (!isset($_SESSION['logged']) || $_SESSION['logged'] != 1) {
    $_SESSION['error'] = "Please login to upload image";
    header("Location:../index.php?loginModal=1");
} else {
    if ($_FILES['fileToUpload'] && isset($_FILES['fileToUpload'])) {
        if ($_FILES['fileToUpload']['error'] !== UPLOAD_ERR_OK) {
            die("Upload failed with error " . $_FILES['fileToUpload']['error']);
        } else {
            $fileName = htmlentities($_FILES['fileToUpload']['name']);
            $fileTmpName = $_FILES['fileToUpload']['tmp_name'];
            $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
            $fileType = finfo_file($fileInfo, $_FILES['fileToUpload']['tmp_name']);
            $fileSizeKb = filesize($fileTmpName);
            $fileIsOk = false;

            switch ($fileType) {
                case 'image/jpeg':
                case 'image/jpg':
                case 'image/png':
                case 'image/x-icon':
                case 'image/gif':
                case 'image/tiff':
                case 'image/bmp':
                case 'audio/basic':
                case 'audio/mp4':
                case 'video/mpeg':
                case 'video/3gpp':
                case 'video/mp4':
                case 'video/3gpp2':
                case 'video/H261':
                case 'video/H263':
                case 'video/H264':
                case 'video/H265':
                case 'video/MPV':
                case 'video/ogg':
                case 'video/quicktime':
                case 'text/plain':
                case 'application/pdf':
                case 'application/zip':
                    $fileIsOk = true;
                    break;
                default:
                    $fileIsOk = false;
                    echo "we don't accept <br>" . $fileType;
                    break;
            }
            if (filesize($fileTmpName) <= 0) {
                $fileIsOk = false;
            }
            if ($fileIsOk) {
                include_once "../functions/userIdGenerator.php";
                include "../db/dbconnect.php";
                include_once "../functions/addFileInfoDatabase.php";

                $fileNewName = generateRandomString();
                $fileNewAddress = "../files/" . $fileNewName;
                rename($fileTmpName, $fileNewAddress);
                $fileDownloadAddress = "files/" . $fileNewName;
                $userId = $_SESSION['user'];

                if (checkAvailableSpace($userId, $fileSizeKb)) {
                    if (addFileDatabase($fileName, $fileDownloadAddress, $userId) && updateUserAvailableSpace($userId, $fileSizeKb)) {
                        header("Location: ../dashboard.php");
                        die("you know you're not in the right place");
                    } else {
                        die("Something went wrong! Please try again!");
                    }
                } else {
                    die("Please upgrade your account for more disk space!");
                }
            }
        }
    } else {
        die("Something went wrong! Please try again!");
    }
}


?>

