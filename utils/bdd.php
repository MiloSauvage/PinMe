<?php
require_once 'variables.php';
require_once 'user.php';
require_once 'image.php';
require_once 'logs.php';

/**
 * Crée une connexion PDO à la base de données.
 *
 * @return PDO|string Retourne l'objet PDO en cas de succès, sinon une chaîne d'erreur.
 */
function connection_database(): PDO|string {
    try {
        $connexion = new PDO(
            "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME,
            DB_USER,
            DB_PASSWORD
        );
    } catch (PDOException $e) {
        return "Connection failed: " . $e->getMessage();
    }
    return $connexion;
}

/**
 * Ferme la connexion à la base de données.
 *
 * @param PDO|null $connexion Référence vers l'objet PDO à fermer.
 * @return void
 */
function disconnect_database(PDO|null &$connexion): void {
    $connexion = null;
}
?>