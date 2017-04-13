<?php

function fileDisplay($userid)
{
    global $mysqli;

    $stmt = $mysqli->prepare("SELECT path_to_file, file_name, created_at FROM files WHERE user_id = ?");
    $stmt->bind_param("s", $userid);
    $stmt->execute();
    $stmt->bind_result($path, $file_name, $created_at);

    while ($stmt->fetch()) {
        echo "<tr><td>$file_name</td><td>$created_at</td><td></td><td><a href='$path' download='$file_name'>Download</td></tr>";
    }
    $stmt->close();
}

?>

