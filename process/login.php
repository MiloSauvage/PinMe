<?php
    if(!isset($_POST["password"]) || !isset($_POST["email"])){
        header("Location: ../register.php");
        exit;
    }

    require_once('../utils/bdd.php');
    require_once('../utils/session.php');
    require_once('../utils/user.php');
    require_once('../utils/logs.php');

    $password = $_POST["password"];
    $email = $_POST["email"];

    $r = test_creditentals($email, $password);

    if($r === null){
        log_message("Tentative de connexion échouée pour l'utilisateur : $email");
        header("Location: ../login.php?err=1");
        exit;
    }
    log_message("connexion réussie pour l'utilisateur : $email");
    session_set_user($r);

    header("Location: ../index.php");
    exit;
?>