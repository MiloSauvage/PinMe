<?php
    require_once("../utils/session.php");
    require_once("../utils/comment.php");
    require_once("../utils/user.php");

    if(is_connected() && isset($_GET["id"])){
        $user = session_get_user();
        $comment = get_comment_from_id(($_GET["id"]) );

        if($user->administrator || $user->id === intval($comment->id_author)){
            echo "ok";
            $comment->delete_from_bdd();
            header("Location: " . $_SERVER["HTTP_REFERER"]);
            exit;
        } else {
            echo "Vous n'avez pas les droits pour supprimer ce commentaire.";
            exit;
        }
    } else {
        echo "Vous devez être connecté pour supprimer un commentaire.";
        exit;
    }
?>