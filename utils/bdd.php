<?php
    require_once('variables.php');
    require_once('user.php');
    require_once('image.php');
    require_once('logs.php');

    /**
     * Crée et renvoie la connexion à la base de donnée en cas de succès, sinon renvoie une chaîne de 
     * caractère contenant l'erreur.
     */
    function connection_database():PDO|string {
        try{
            $connexion = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME , DB_USER, DB_PASSWORD);
        }
        catch (PDOException $e){
            return "Connection failed: " . $e->getMessage();
        }
        return $connexion;
    }

    /**
     * Ferme la connexion à la base de données
     */
    function disconnect_database(&$connexion):void {
        $connexion = null;
    }
?>