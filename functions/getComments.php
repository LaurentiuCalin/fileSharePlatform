<?php

function getComments($code){
    global $mysqli;

    if ($mysqli->connect_error){
        die("Connection failed: ". $mysqli->connect_error);
    }else{

$path_to_file = "files/".$code;

    }
}