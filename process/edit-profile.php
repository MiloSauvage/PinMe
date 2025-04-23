<?php
    require_once "../utils/session.php";
    require_once "../utils/user.php";
    require_once "../utils/logs.php";

    $user = session_get_user();

    if($user->username !== $_GET["username"]){
        header("Location: ../index.php");
        echo "pas le bon user";
        exit;
    }

    $new_username = $_POST["username"] ?? null;
    $new_email = $_POST["email"] ?? null;
    $new_password = $_POST["password"] ?? null;
    $new_prenom = $_POST["first_name"] ?? null;
    $new_nom = $_POST["last_name"] ?? null;
    $new_bio = $_POST["bio"] ?? null;
    $new_photo = $_FILES["profile_photo"] ?? null;

    /*if($new_username !== null){
        if(!$user->change_username($new_username)){
            log_error("Erreur lors du changement de nom d'utilisateur : " . $new_username);
        }
    }
    if($new_email !== null){
        if(!$user->change_email($new_email)){
            log_error("Erreur lors du changement d'email : " . $new_email);
        }
    }
    if($new_password !== null){
        if(!$user->change_password($new_password)){
            log_error("Erreur lors du changement de mot de passe.");
        }
    }
    if($new_prenom !== null){
        if(!$user->change_prenom($new_prenom)){
            log_error("Erreur lors du changement de prénom : " . $new_prenom);
        }
    }
    if($new_nom !== null){
        if(!$user->change_nom($new_nom)){
            log_error("Erreur lors du changement de nom : " . $new_nom);
        }
    }
    if($new_bio !== null){
        if(!$user->change_bio($new_bio)){
            log_error("Erreur lors du changement de la bio.");
        }
    }*/

    if($new_photo !== null && $new_photo["error"] === 0){
        $upload_dir = "../images/user_profile_picture/";
        $upload_file = $upload_dir . basename($new_photo["name"]);
        
        if(){
            
        }

        if(move_uploaded_file($new_photo["tmp_name"], $upload_file)){
            $photo_url = "/images/user_profile_picture/" . basename($new_photo["name"]);
            if(!$user->change_photo($photo_url)){
                log_error("Erreur lors du changement de la photo de profil : " . $photo_url);
            }
        } else {
            log_error("Erreur lors de l'enregistrement de la photo de profil.");
        }
    }

    //header("Location: ../profile.php?username=" . $user->username);
?>