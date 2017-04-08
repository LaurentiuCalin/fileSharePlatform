<?php
/**
 * Created by PhpStorm.
 * User: calin
 * Date: 07-Apr-17
 * Time: 2:06 PM
 */

if (isset($_COOKIE['aqInfo']) && !empty($_COOKIE['aqInfo'])) {
    include_once "../db/dbconnect.php";
    global $mysqli;

    $cookie = $_COOKIE['aqInfo'];
    $cookie_info_array = explode(".", $cookie);

    $hashToken = hash('sha256', $cookie_info_array[1]);

    $stmt = $mysqli->prepare("DELETE FROM auth_tokens WHERE selector = ? AND token = ?");
    $stmt->bind_param("ss", $cookie_info_array[0], $hashToken);
    $stmt->execute();
    $stmt->close();

    unset($_COOKIE['aqInfo']);
    setcookie("aqInfo", '', time() - 3600, '/', '');
}
session_start();
session_destroy();

header("location: ../index.php");
?>