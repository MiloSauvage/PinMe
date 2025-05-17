<?php
    require_once '../utils/annotation.php';
    require_once '../utils/image.php';
    require_once '../utils/user.php';
    require_once '../utils/bdd.php';
    require_once '../utils/session.php';

    if(!is_connected()){
        exit('Erreur : Vous devez être connecté pour créer une annotation.');
    }

    $image_id = $_POST['image_id'] ?? null;
    $pos_x = $_POST['pos_x'] ?? null;
    $pos_y = $_POST['pos_y'] ?? null;
    $width = $_POST['width'] ?? null;
    $height = $_POST['height'] ?? null;
    $title = $_POST['title'] ?? null;
    $color = $_POST['color'] ?? null;

    if($image_id === null || $pos_x === null || $pos_y === null || $width === null || $height === null || $title === null || $color === null){
        exit('Erreur : Données manquantes.');
    }

    $annotation = new Annotation(
        0,
        intval($image_id),
        $title,
        intval(session_get_user()->id),
        floatval($pos_x),
        floatval($pos_y),
        floatval($width),
        floatval($height),
        $color
    );

    if($annotation->put_in_bdd() === false){
        exit('Erreur : Impossible de créer l\'annotation.');
    }
?>