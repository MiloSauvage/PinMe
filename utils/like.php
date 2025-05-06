<?php
    require_once("bdd.php");
    require_once("user.php");
    require_once("image.php");
    require_once("logs.php");

    function add_like($image, $user){
        $connexion = connection_database();
        if(is_string($connexion)){
            log_error("Erreur de connexion à la base de données : " . $connexion);
            return false;
        }
        $query = "INSERT INTO Likes (user_id, image_id, liked_at) VALUES (:user_id, :image_id, NOW())";
        $stmt = $connexion->prepare($query);
        $stmt->bindParam(':user_id', $user->id);
        $stmt->bindParam(':image_id', $image->id);
        $stmt->execute();
        disconnect_database($connexion);
        return true;
    }

    function remove_like($image, $user){
        $connexion = connection_database();
        if(is_string($connexion)){
            log_error("Erreur de connexion à la base de données : " . $connexion);
            return false;
        }
        $query = "DELETE FROM Likes WHERE user_id = :user_id AND image_id = :image_id";
        $stmt = $connexion->prepare($query);
        $stmt->bindParam(':user_id', $user->id);
        $stmt->bindParam(':image_id', $image->id);
        $stmt->execute();
        disconnect_database($connexion);
        return true;
    }

    // Fonction pour vérifier si un post est liké par un utilisateur
    function check_if_post_liked($image, $user) {
        $connexion = connection_database();
        if(is_string($connexion)){
            log_error("Erreur de connexion à la base de données : " . $connexion);
            return false;
        }
        $query = "SELECT COUNT(*) FROM Likes WHERE user_id = :user_id AND image_id = :image_id";
        $stmt = $connexion->prepare($query);
        $stmt->bindParam(':user_id', $user->id);
        $stmt->bindParam(':image_id', $image->id);
        $stmt->execute();
        $count = $stmt->fetchColumn();
        disconnect_database($connexion);
        return $count > 0;
    }

    // Fonction pour obtenir le nombre de likes d'un post
    function get_post_like_count($image) {
        $connexion = connection_database();
        if(is_string($connexion)){
            log_error("Erreur de connexion à la base de données : " . $connexion);
            return 0;
        }
        $query = "SELECT COUNT(*) FROM Likes WHERE image_id = :image_id";
        $stmt = $connexion->prepare($query);
        $stmt->bindParam(':image_id', $image->id);
        $stmt->execute();
        $count = $stmt->fetchColumn();
        disconnect_database($connexion);
        return $count;
    }
?>