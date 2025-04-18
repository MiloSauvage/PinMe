<?php
    // base de donnée
    define("DB_HOST", "localhost");
    define("DB_NAME", "pinme");
    define("DB_USER", "root");
    define("DB_PASSWORD", "");
    // Gestion d'images
    define("UPLOAD_DIR", $_SERVER['DOCUMENT_ROOT'] . "/images/uploads/");
    define("PFP_DIR", $_SERVER['DOCUMENT_ROOT'] . "/images/profile_photos/");
    define("EXTENSION_UPLOAD", "jpeg");
    // Gestion des fichiers de logs
    define("LOG_FILE_PATH", $_SERVER['DOCUMENT_ROOT'] . "/logs/logs.txt");
    define("LOG_ERROR_PATH" , $_SERVER['DOCUMENT_ROOT'] . "/logs/error.txt");
?>