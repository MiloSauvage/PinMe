<?php
    if(!(isset($_POST["id"]))){
        error();
    }

    session_start();

    $username = (isset($_SESSION["username"]));
    $name = (isset($_POST["name"])) ? $_POST["name"] : null;
    $deadline = (isset($_POST["deadline"])) ? $_POST["deadline"] : null;
    $desc = (isset($_POST["desc"])) ? $_POST["description"] : null;
    $id = (isset($_POST["id"])) ? $_POST["id"] : null;
    $status = (isset($_POST["status"])) ? $_POST["status"] : null;

    //echo "$desc, $username, $deadline, $name";

    $cur_date = date("Y\-m\-d"); // voir manuel php date() pour savoir quoi mettre dedans

    include '../db.php';

    $requete = "UPDATE task SET ";

    if($name != null){
        $requete = $requete." name='$name', ";
    }

    if($desc != null){
        $requete = $requete." description='$desc', ";
    }

    if($deadline != null){
        $requete = $requete." deadline='$deadline', ";
    }

    if($status != null){
        $requete = $requete." status='$status', ";
    }

    // Supprimer la dernière virgule et l'espace ajoutés en trop
    $requete = rtrim($requete, ", ");

    $requete = $requete." WHERE (id = '$id')";

    $res = mysqli_query($connexion, $requete);

    if(!$res){
        mysqli_close($connexion);
        error();
    }

    mysqli_close($connexion);

    header("Location: ../dashboard.php");

    function error(){
        echo "An error occured, <a href=\"../dashboard.php\">go back</a>";
        exit;
    }
?>
