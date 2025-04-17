<?php
    if(!isset($_POST["username"]) || !isset($_POST["password"]) || !isset($_POST["email"])){
        header("Location: ../register.php");
        exit;
    }

    require_once('../utils/bdd.php');
    require_once('../utils/session.php');
    require_once('../utils/user.php');
    require_once('../utils/logs.php');

    $username = $_POST["username"];
    $password = $_POST["password"];
    $email = $_POST["email"];

    $user = add_user($username, $email, $password);
    if($user == null){
        header("Location: ../index.php");
        exit;
    }

    session_set_user($user);
    log_message("Utilisateur enregistré : " . $user->username);
    header("Location: ../index.php");
?>