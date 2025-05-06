<?php
    require_once "user.php";
    session_start();

    function is_connected() {
        return isset($_SESSION["user"]);
    }

    function session_set_user($user) {
        $_SESSION["user"] = get_user_from_id($user->id);
    }

    function session_get_user() {
        return $_SESSION["user"] ?? null;
    }

    function session_stop() {
        session_unset();
        session_destroy();
        header("Location: ../index.php");
    }
?>