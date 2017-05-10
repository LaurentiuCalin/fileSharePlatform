<?php
function CheckLoginCookie()
{
    include_once "setCookie.php";
    global $mysqli;
    if (isset($_COOKIE['aqInfo']) && !empty($_COOKIE['aqInfo'])) {
        $cookie = $_COOKIE['aqInfo'];
        $cookie_info_array = explode(".", $cookie);

        $selector = $cookie_info_array[0];

        $stmt = $mysqli->prepare("SELECT token, userid FROM auth_tokens WHERE selector = ?");
        $stmt->bind_param("s", $selector);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($db_token, $db_userid);
        $stmt->fetch();
        if ($stmt->num_rows != NULL) {
            $stmt->close();

            $cookie_token = hash('sha256', $cookie_info_array[1]);
            if (hash_equals($db_token, $cookie_token)) {

                $stmt = $mysqli->prepare("DELETE FROM auth_tokens WHERE selector = ?");
                $stmt->bind_param("s", $selector);
                $stmt->execute();
                $stmt->close();

                Cookie($db_userid);

                $_SESSION['logged'] = 1;
                $_SESSION['user'] = $db_userid;
                return true;
            } else {
                $stmt = $mysqli->prepare("DELETE FROM auth_tokens WHERE userid = ?");
                $stmt->bind_param("s", $db_userid);
                $stmt->execute();
                $stmt->close();
                die("changes in the cookie");
            }
        } else {
            return false;
        }
    } else {
        return false;
    }
}