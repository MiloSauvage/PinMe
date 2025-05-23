<?php
    require_once("../utils/variables.php");
    require_once("../utils/bdd.php");
    require_once("../utils/comment.php");
    require_once("../utils/user.php");
    require_once("../utils/session.php");

    if(!isset($_POST["id"])){
        exit;
    }
    $image_id = $_POST["id"];
    
    $image = get_image_from_id($image_id);
    if($image == null){
        exit;
    }

    if(!is_connected()){
        exit;
    }
    $user = session_get_user();
    
    if(!isset($_POST["content"])){
        exit;
    }
    
    $content = $_POST["content"];
    
    $comment = new Comment(null, $image_id, $user->id, $content, date("Y-m-d H:i:s"));
    
    $comment->put_in_bdd();
    
    header("Location: ". $_SERVER["HTTP_REFERER"]);
?>