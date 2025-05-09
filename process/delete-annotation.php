<?php
    require_once('utils/annotation.php');
    require_once('utils/session.php');

    if(!is_connected()){
        exit;
    }

    $id = $_POST['id'] ?? null;

    if($id === null){
        exit('ID de l\'annotation non spécifié.');
    }

    $annotation = get_annotation_by_id($id);

    if($annotation === false || $annotation === null){
        exit('Id incorrect.');
    }

    $annotation->delete_from_bdd();
?>