<?php

//check if user exists
//make sure you get protected value  from the form. DANIEL, TO DO


function addFileDatabase($fileName, $fileNewAddress, $userId)
{

    global $mysqli;

    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    } else {
        $stmtAddFileDetails = $mysqli->prepare("INSERT INTO files (user_id, path_to_file, file_name, protected) VALUES (?,?,?,?)");
        $protection = 1;
        $stmtAddFileDetails->bind_param("ssss", $userId, $fileNewAddress, $fileName, $protection);
        if (!$stmtAddFileDetails->execute()) {
            die("Something went wrong, try again");
            return false;
        }
        $stmtAddFileDetails->close();
        return true;

    }


}

function checkAvailableSpace($userId, $fileSize){

    global $mysqli;

    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    } else {
        $stmtCheckSpace = $mysqli->prepare("SELECT available_space FROM users WHERE id = ?");
        $stmtCheckSpace->bind_param("s", $userId);
        if (!$stmtCheckSpace->execute()) {
            die("Something went wrong, try again");
            return false;
        }
        $stmtCheckSpace->store_result();
        $stmtCheckSpace->bind_result($availableSpace);
        $stmtCheckSpace->fetch();
        $stmtCheckSpace->close();
    }

    if ($fileSize <= $availableSpace){
        return true;
    }else{
        return false;
    }

}



function updateUserAvailableSpace($userId, $fileSize)
{

    global $mysqli;


//    $fileSize = 1234;

    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    } else {
        $stmtUpdateSpace = $mysqli->prepare("UPDATE users SET available_space = available_space - ? WHERE id = ?");
        $stmtUpdateSpace->bind_param("ss", $fileSize, $userId);
        if (!$stmtUpdateSpace->execute()) {
            die("Something went wrong, try again");
            return false;
        }
        $stmtUpdateSpace->close();
        return true;

    }
}

?>