<?php

function generateId($userEmail){
    return hexdec( substr(sha1($userEmail), 0, 5) );
}

?>