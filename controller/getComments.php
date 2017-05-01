<?php

if (isset($_POST['fileCode']) && $_POST['fileCode']){

    $fileCode = $_POST['fileCode'];


    include_once '../db/dbconnect.php';
    include_once '../functions/getFileInfo.php';

    $jFileInfo = json_decode(getFileInfo($fileCode));
    $fileId = $jFileInfo->fileId;

    if ($fileId != null){

        include_once '../functions/getCommentsUsernameDatabase.php';

        $comments = getCommentsUsername($fileId);

        echo json_encode($comments);


    }

}


?>