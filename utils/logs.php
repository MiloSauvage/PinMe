<?php
    require_once('variables.php');

    // Méthode publique : log général
    function log_message($message) {
        p_write($message, LOG_FILE_PATH);
    }

    // Méthode publique : log d'erreur
    function log_error($message) {
        p_write($message, LOG_ERROR_PATH);
    }

    // Méthode privée : écriture dans un fichier
    function p_write($message, $log_file) {
        $log_dir = dirname($log_file);

        /*
        // Créer le dossier si nécessaire   
        if (!is_dir($log_dir)) {
            // permissions ignorées sur windows
            if (!mkdir($log_dir, 0775, true)) {
                echo("Impossible de créer le dossier de log : $log_dir<br>");
                return;
            }
        }

        // Créer le fichier si nécessaire
        if (!file_exists($log_file)) {
            if (!touch($log_file)) {
                echo("Impossible de créer le fichier de log : $log_file");
                return;
            }
            chmod($log_file, 0664);
        }

        // Écriture
        $date = date('Y-m-d H:i:s');
        $log_entry = "[$date] $message\n";

        if (file_put_contents($log_file, $log_entry, FILE_APPEND) === false) {
            error_log("Erreur d'écriture dans le fichier de log : $log_file");
        }*/
    }

?>