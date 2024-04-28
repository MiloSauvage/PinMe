<?php
    include '../db.php';

    $requete = "";

    // On ignore les espaces blancs et caractères inutiles ( tablulation, saut de ligne etc) et on supprime les derniers espace de fin si ya

    if ($_POST["name"] != null) {
        $name = rtrim(preg_replace('/,\s*(?=]\s*})/',"] }", $_POST["name"]), " ");
        $requete .= "name LIKE '%".$name."%' AND ";
    }

   if ($_POST["description"] != null) {
        $description = rtrim(preg_replace('/,\s*(?=]\s*})/',"] }", $_POST["description"]), " ");
        $requete .= "description LIKE '%".$description."%' AND ";
    }

    if ($_POST["deadline"] != null) {
        $deadline = $_POST["deadline"];
        $requete .= "deadline = '$deadline' AND ";
    }

    if ($_POST["status"] != null) {
        $status = $_POST["status"];
        $requete .= "status = '$status' AND ";
    }

    // Supprimer le dernier "AND" s'il est présent
    $requete = rtrim($requete, "AND ");

    echo $requete;

    session_start();
    

    $_SESSION["search"] = $requete;


    if($requete == ""){
        unset($_SESSION['search']);
    }

    header("Location: ../dashboard.php");
?>
