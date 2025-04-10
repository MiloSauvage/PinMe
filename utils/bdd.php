<?php
    require_once('variables.php');

    function connection_database(){
        global $db_host, $db_name, $db_user, $db_password;
        try{
            $connexion = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_password);
        }
        catch (PDOException $e){
            echo "Connection failed: " . $e->getMessage();
            exit;
        }
        return $connexion;
    }

    function disconnect_database(&$connexion){
        $connexion = null;
    }

    function user_exists($connexion, $username, $email) {
        $query = "SELECT * FROM users WHERE username = :username OR email = :email";
        $stmt = $connexion->prepare($query);
        $stmt->execute([
            "username" => $username,
            "email" => $email
        ]);
        $result = $stmt->fetchAll();

        if (count($result) > 0) {
            return true;
        } else {
            return false;
        }
    }

    function test_creditentals($connexion, $email, $password){
        $query = "SELECT * FROM users WHERE email = :email";
        $stmt = $connexion->prepare($query);
        $stmt->execute([
            "email" => $email
        ]);
        $user = $stmt->fetch(); 
        if ($user && password_verify($password, $user["password"])) {
            return new User(
                $user["id"], 
                $user["username"], 
                $user["email"], 
                $user["administrator"], 
                $user["date_joined"], 
                isset($user["nom"]) ? $user["nom"] : null, 
                isset($user["prenom"]) ? $user["prenom"] : null
            );
        }
        return false;
    }
?>