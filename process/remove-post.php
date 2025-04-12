<?php
    if(!isset($_GET["id"])) {
        exit;
    }
    require_once("../utils/bdd.php");
    require_once("../utils/image.php");
    require_once("../utils/user.php");
    $id = $_GET["id"];
    $connexion = connection_database();
    $img = get_image_from_id($connexion, $id);
    $img->delete_from_bdd($connexion);
    disconnect_database($connexion);
?>