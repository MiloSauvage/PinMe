<?php
    require_once("../utils/variables.php");
    require_once("../utils/bdd.php");
    require_once("../utils/image.php");
    require_once("../utils/user.php");
    require_once("../utils/session.php");
    require_once("../utils/like.php");

    if(!isset($_GET["id"])){
        exit;
    }
    $image_id = $_GET["id"];
    
    $image = get_image_from_id($image_id);
    if($image == null){
        exit;
    }

    if(!is_connected()){
        exit;
    }
    $user = session_get_user();
    
    if(add_like($image, $user) == false){
        exit;
    };
    
    header("Location: ". $_SERVER["HTTP_REFERER"]);
?>