<?php

function fileDisplay($userid)
{
    global $mysqli;

    $stmt = $mysqli->prepare("SELECT path_to_file, file_name, created_at FROM files WHERE user_id = ?");
    $stmt->bind_param("s", $userid);
    $stmt->execute();
    $stmt->bind_result($path, $file_name, $created_at);





    while ($stmt->fetch()) {
        $path_info = explode("/", $path);

        echo "<tr><td>$file_name</td><td>$created_at</td><td><a href='$path' download='$file_name'>Download</a> | <a href='dashboard.php?deleteFile=$path_info[1]' >Delete</a>|<label>Copy shareable link from here</label> <input type='text' id='copyTarget' value='http://localhost:90/ws/sharedFile.php?x=$path_info[1]'></td></tr>";

    }
    $stmt->close();
}

?>

