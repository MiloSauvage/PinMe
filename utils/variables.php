<?php
    // Racine du projet
    define('PROJECT_ROOT', '/home/l2info/facqukyl/TPWeb/PinMe/');
    // Base de donnée
    if(1){
        define("DB_HOST", "inf-mysql.univ-rouen.fr");
        define("DB_NAME", "facqukyl_cctp");
        define("DB_USER", "facqukyl");
        define("DB_PASSWORD", "12082005");
    }else{
        define("DB_HOST", "localhost");
        define("DB_NAME", "pinme");
        define("DB_USER", "root");
        define("DB_PASSWORD", "");
    }
    // Gestion d'images
    define("UPLOAD_DIR", PROJECT_ROOT . "public/images/uploads/");
    define("PFP_DIR", PROJECT_ROOT . "public/images/profile_photos/");
    define("EXTENSION_UPLOAD", "jpeg");
    // Gestion des fichiers de logs
    define("LOG_FILE_PATH", PROJECT_ROOT . "/writable/logs/logs.txt");
    define("LOG_ERROR_PATH" , PROJECT_ROOT . "/writable/logs/error.txt");
?>


