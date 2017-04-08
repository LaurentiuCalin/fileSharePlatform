<?php

function generateId($userEmail){
    return hexdec( substr(sha1($userEmail), 0, 5) );
}

function generateRandomString(){

    $characters = 'abcdefghijklmnopqrstuvwxyz0123456789';

    $string = '';
    $max = strlen($characters) - 1;
    for ($i = 0; $i < 35; $i++) {
        $string .= $characters[mt_rand(0, $max)];
    }

    return $string;
}


?>