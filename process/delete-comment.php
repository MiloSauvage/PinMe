<?php
    require_once("../utils/session.php");
    require_once("../utils/comment.php");
    require_once("../utils/user.php");

    if(is_connected() && isset($_GET["id"])){
        $user = session_get_user();
        $comment = get_comment_from_id(($_GET["id"]) );
        if($user->administrator || $user->id === $comment->id_author){
            $comment->delete_from_bdd();
            header("Location: " . $_SERVER["HTTP_REFERER"]);
            exit;
        } else {
            header("Location: " . $_SERVER["HTTP_REFERER"] . "?error=not_authorized");
            exit;
        }
    } else {
        header("Location: " . $_SERVER["HTTP_REFERER"] . "?error=not_connected");
        exit;
    }
?>