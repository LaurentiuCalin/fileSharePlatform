<?php

session_start();

if (isset($_POST['comment']) && $_POST['comment'] && isset($_GET['fileCode']) && $_GET['fileCode'] && isset($_SESSION['user']) && $_SESSION['user']){

    $comment = htmlentities($_POST['comment']);
    $fileCode = $_GET['fileCode'];
    $userId = $_SESSION['user'];

    include_once '../db/dbconnect.php';
    include_once '../functions/getFileInfo.php';
    include_once '../functions/addCommentDatabase.php';

    $jFileInfo = json_decode(getFileInfo($fileCode));
    $fileId = $jFileInfo->fileId;

    addCommentDatabase($fileId, $userId, $comment);
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    
}else{
    die("Something went wrong");
}

?>