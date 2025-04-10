<?php
    declare(strict_types=1);
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    
    if(!isset($_POST["username"]) || !isset($_POST["password"]) || !isset($_POST["email"])){
        header("Location: ../register.php");
        exit;
    }

    require_once('../utils/bdd.php');
    require_once('../utils/session.php');
    require_once('../utils/user.php');

    $username = $_POST["username"];
    $password = $_POST["password"];
    $email = $_POST["email"];

    $connexion = connection_database();

    if(user_exists($connexion, $username, $email)){
        header("Location: ../register.php");
        exit;
    }
    $query = "INSERT INTO users (username, password, email, administrator, date_joined) VALUES (:username, :password, :email, :administrator, :date_joined)";
    $stmt = $connexion->prepare($query);

    $user = new User(null, $username, $email, false, date("Y-m-d H:i:s"));

    $stmt->execute([
        "username" => $username,
        "password" => password_hash($password, PASSWORD_DEFAULT),
        "email" => $email,
        "administrator" => false,
        "date_joined" => date("Y-m-d H:i:s")
    ]);

    $user->id = $connexion->lastInsertId();

    disconnect_database($connexion);

    session_set_user($user);

    header("Location: ../index.php");
?>