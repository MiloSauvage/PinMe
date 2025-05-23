<?php
require_once "user.php";
session_start();

/**
 * Vérifie si un utilisateur est connecté.
 *
 * @return bool True si un utilisateur est connecté, sinon false.
 */
function is_connected(): bool {
    return isset($_SESSION["user_id"]);
}

/**
 * Définit l'utilisateur courant dans la session.
 *
 * @param object $user L'utilisateur à définir (doit avoir une propriété 'id').
 * @return void
 */
function session_set_user(object $user): void {
    $_SESSION['user_id'] = $user->id;
}

/**
 * Récupère l'utilisateur courant depuis la session.
 *
 * @return mixed L'utilisateur courant ou null s'il n'est pas défini.
 */
function session_get_user() {
    if (!isset($_SESSION['user_id'])) return null;
    return get_user_from_id($_SESSION['user_id']);
}

/**
 * Termine la session et redirige vers la page d'accueil.
 *
 * @return void
 */
function session_stop(): void {
    session_unset();
    session_destroy();
    header("Location: ../index.php");
    exit;
}
?>