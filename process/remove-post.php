<?php
    if(!isset($_GET["id"])) {
        echo "aucun id de post fourni";
        exit;
    }
    require_once("../utils/bdd.php");
    require_once("../utils/image.php");
    require_once("../utils/user.php");
    require_once("../utils/variables.php");
    $id = $_GET["id"];
    $img = get_image_from_id($id);
    $img->delete_from_bdd();
?>