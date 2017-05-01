<?php

function getCommentsUsername($fileId){

    global $mysqli;
    if ($mysqli->connect_error){
        die("Connection failed: " . $mysqli->connect_error);
    }else{
        $stmt = $mysqli->prepare("SELECT comments.created_at, comments.body, users.username FROM comments, users WHERE comments.fileid = ? AND comments.userid = users.id");

        $stmt->bind_param('s', $fileId);
        if ($stmt->execute()){
            die("something went wrong, try again");
        }
        $stmt->store_result();
        $stmt->bind_result($commentDate, $commentBody, $user);

        $comments = array();

        while ($stmt->fetch()){

            $jCommentDetails = json_decode("{}");
            $jCommentDetails->username = $user;
            $jCommentDetails->commentBody = $commentBody;
            $jCommentDetails->commentDate = $commentDate;
            $commentDetails = json_encode($jCommentDetails);

            array_push($comments, $commentDetails);

        }

        return $comments;
    }

}

//[
//    {"username": "Daniel",
//        "comment":"askdjnsa"
//        "date":"askdjnsa"
//    },
//    {"username": "Daniel",
//        "comment":"askdjnsa"
//        "date":"askdjnsa"
//    }
//]

?>