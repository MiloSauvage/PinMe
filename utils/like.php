<?php
require_once("bdd.php");
require_once("user.php");
require_once("image.php");
require_once("logs.php");

/**
 * Ajoute un like à une image pour un utilisateur.
 *
 * @param object $image L'objet image à liker (doit avoir une propriété 'id').
 * @param object $user L'objet utilisateur qui like (doit avoir une propriété 'id').
 * @return bool True si le like a été ajouté, false en cas d'erreur.
 */
function add_like($image, $user): bool {
    $connexion = connection_database();
    if (is_string($connexion)) {
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

/**
 * Supprime un like d'une image pour un utilisateur.
 *
 * @param object $image L'objet image à unliker (doit avoir une propriété 'id').
 * @param object $user L'objet utilisateur qui unlike (doit avoir une propriété 'id').
 * @return bool True si le like a été supprimé, false en cas d'erreur.
 */
function remove_like($image, $user): bool {
    $connexion = connection_database();
    if (is_string($connexion)) {
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

/**
 * Vérifie si un utilisateur a liké une image.
 *
 * @param object $image L'objet image à vérifier (doit avoir une propriété 'id').
 * @param object $user L'objet utilisateur à vérifier (doit avoir une propriété 'id').
 * @return bool True si l'utilisateur a liké l'image, false sinon ou en cas d'erreur.
 */
function check_if_post_liked($image, $user): bool {
    $connexion = connection_database();
    if (is_string($connexion)) {
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

/**
 * Retourne le nombre de likes pour une image.
 *
 * @param object $image L'objet image dont on veut le nombre de likes (doit avoir une propriété 'id').
 * @return int Le nombre de likes pour l'image, ou 0 en cas d'erreur.
 */
function get_post_like_count($image): int {
    $connexion = connection_database();
    if (is_string($connexion)) {
        log_error("Erreur de connexion à la base de données : " . $connexion);
        return 0;
    }
    $query = "SELECT COUNT(*) FROM Likes WHERE image_id = :image_id";
    $stmt = $connexion->prepare($query);
    $stmt->bindParam(':image_id', $image->id);
    $stmt->execute();
    $count = $stmt->fetchColumn();
    disconnect_database($connexion);
    return (int)$count;
}
?>