<?php
    session_start();

    function is_connected() {
        return isset($_SESSION["user"]);
    }

    function session_set_user($user) {
        $_SESSION["user"] = $user;
    }

    function session_get_user() {
        return $_SESSION["user"];
    }

    function session_stop() {
        session_unset();
        session_destroy();
        header("Location: ../index.php");
    }
?>