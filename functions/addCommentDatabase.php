<?php

function addCommentDatabase($fileId, $userId, $comment){

    global $mysqli;

    if ($mysqli->connect_error){
        die("Connection failed: ". $mysqli->connect_error);
    }else {
        $stmt = $mysqli->prepare("INSERT INTO comments(body, userid, fileid) VALUES (?,?,?)");
        $stmt->bind_param("sss", $comment, $userId, $fileId);
        $stmt->execute();
        $stmt->close();
        return true;
    }

}

?>