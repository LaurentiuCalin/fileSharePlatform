<?php


function getFileInfo($code){

    global $mysqli;

    if ($mysqli->connect_error){
        die("Connection failed: ". $mysqli->connect_error);
    }else{

        $lookFor = '%'.$code;
        $fileName = "asd";

        $stmtFileInfo = $mysqli->prepare("SELECT id, file_name, created_at FROM files WHERE path_to_file LIKE ?");
        $stmtFileInfo->bind_param('s', $lookFor);
        if (!$stmtFileInfo->execute()){
            die("Something went wrong, try again");
            return false;
        }
        $stmtFileInfo->store_result();
        $stmtFileInfo->bind_result($fileId, $fileName, $createdAt);
        $stmtFileInfo->fetch();
        $stmtFileInfo->close();

    }

    if (empty($fileName) || empty($createdAt) || empty($fileId)){
        die('file not found');
    }else{

        $jFileInfo = json_decode("{}");
        $jFileInfo->fileId = $fileId;
        $jFileInfo->fileName = $fileName;
        $jFileInfo->createdAt = $createdAt;
        $fileInfo = json_encode($jFileInfo);

        return $fileInfo;
    }

}

?>