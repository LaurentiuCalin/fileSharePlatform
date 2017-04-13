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
//        $mysqli->close();
        return true;

    }


}

function updateUserAvailableSpace($userId, $fileSize)
{

    global $mysqli;

    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    } else {
        $stmtUpdateSpace = $mysqli->prepare("UPDATE users SET available_space = available_space - ? WHERE id = ?");
        $stmtUpdateSpace->bind_param("ss", $fileSize, $userId);
        if (!$stmtUpdateSpace->execute()) {
            die("Something went wrong, try again");
        }
        $stmtUpdateSpace->close();
        $mysqli->close();
        return true;

    }
}

?>