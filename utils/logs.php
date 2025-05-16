<?php
require_once('variables.php');

/**
 * Écrit un message dans le journal général.
 *
 * @param string $message Le message à enregistrer.
 * @return void
 */
function log_message(string $message): void {
    p_write($message, LOG_FILE_PATH);
}

/**
 * Écrit un message dans le journal des erreurs.
 *
 * @param string $message Le message d'erreur à enregistrer.
 * @return void
 */
function log_error(string $message): void {
    p_write($message, LOG_ERROR_PATH);
}

/**
 * Écrit un message dans un fichier de log spécifié.
 *
 * @param string $message Le message à enregistrer.
 * @param string $log_file Le chemin du fichier de log.
 * @return void
 */
function p_write(string $message, string $log_file): void {
    $log_dir = dirname($log_file);

    if (!is_dir($log_dir)) {
        if (!mkdir($log_dir, 0775, true)) {
            echo("Impossible de créer le dossier de log : $log_dir<br>");
            return;
        }
    }

    if (!file_exists($log_file)) {
        if (!touch($log_file)) {
            echo("Impossible de créer le fichier de log : $log_file");
            return;
        }
        chmod($log_file, 0664);
    }

    $date = date('Y-m-d H:i:s');
    $log_entry = "[$date] $message\n";

    if (file_put_contents($log_file, $log_entry, FILE_APPEND) === false) {
        error_log("Erreur d'écriture dans le fichier de log : $log_file");
    }
}
?>