<?php
    if(!(isset($_POST["name"]) && isset($_POST["deadline"]) && isset($_POST["description"]))){
        error();
    }
    session_start();

    $username = $_SESSION["username"];
    $name = $_POST["name"];
    $deadline = $_POST["deadline"];
    $desc = $_POST["description"];

    //     /!\ Si on veut faire un header(), il ne faut pas faire d'echo dans la page.
    if(strlen($name) > 100){
        header("Location: ../dashboard.php?err=3");
        exit;
    }

    // desc trop grosse : Taille max : 2^16-1 soit 65535, si taille > 2048, erreur de header, on bride la taille
    if(strlen($desc) > 65536){
        header("Location: ../dashboard.php?err=2");
        exit;
    }

    // Date incorrecte
    if($deadline > 2100 || $deadline < 1900){
        header("Location: ../dashboard.php?err=1");
        exit;
    }

    include '../db.php';

    // To do, In progress, finished
    $requete = "INSERT INTO task (name, description, deadline, status, owner) VALUES('$name', '$desc', '$deadline', 'To do', '$username')";
    $res = mysqli_query($connexion, $requete);

    if(!$res){
        mysqli_close($connexion);
        $err = mysqli_error($connexion);
        echo "$err";
        error();
    }

    mysqli_close($connexion);

    header("Location: ../dashboard.php");

    function error(){
        echo "An error occured, <a href=\"../dashboard.php\">go back</a>";
        exit;
    }
?>
