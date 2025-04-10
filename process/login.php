<?php
    if(!isset($_POST["password"]) || !isset($_POST["email"])){
        header("Location: ../register.php");
        exit;
    }

    require_once('../utils/bdd.php');
    require_once('../utils/session.php');
    require_once('../utils/user.php');

    $password = $_POST["password"];
    $email = $_POST["email"];

    $connexion = connection_database();

    $r = test_creditentals($connexion, $email, $password);
    if($r === false){
        disconnect_database($connexion);
        header("Location: ../login.php");
        exit;
    }

    session_set_user($r);

    disconnect_database($connexion);
    header("Location: ../index.php");
    exit;
?>