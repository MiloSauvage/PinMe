<?php
    class User {
        public $id;
        public $username;
        public $email;
        public $administrator;
        public $date_joined;
        public $nom;
        public $prenom;
        public $password;
        public $src_pfp;
        public $bio;
        
        function __construct($id, $username, $email, $administrator, $date_joined, $nom = null, $prenom = null) {
            $this->id = $id;
            $this->username = $username;
            $this->email = $email;
            $this->administrator = $administrator;
            $this->date_joined = $date_joined;
            $this->nom = $nom;
            $this->prenom = $prenom;
        }

        function __toString() {
            return "User: $this->username, Email: $this->email, Administrator: $this->administrator, Date Joined: $this->date_joined";
        }
    }

        /**
     * Renvoie l'utilisateur correspondant au nom d'utilisateur passé en paramètre.
     * Si l'utilisateur n'existe pas, renvoie null.
     */
    function get_user($username):User|null {
        $connexion = connection_database();
        if(is_string($connexion)){
            log_error("Erreur de connexion à la base de données : " . $connexion);
            return null;
        }
        $query = "SELECT * FROM users WHERE username = :username";
        $stmt = $connexion->prepare($query);
        $stmt->execute([
            "username" => $username
        ]);
        $user = $stmt->fetch();
        disconnect_database($connexion);
        if(!$user){
            include_once("./utils/no-profile.php");
            exit;
        }
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

    /**
     * Vérifie si un utilisateur existe dans la base de données
     */
    function user_exists($username, $email):bool {
        $connexion = connection_database();
        if(is_string($connexion)){
            log_error("Erreur de connexion à la base de données : " . $connexion);
            return false;
        }
        $query = "SELECT * FROM users WHERE username = :username OR email = :email";
        $stmt = $connexion->prepare($query);
        $stmt->execute([
            "username" => $username,
            "email" => $email
        ]);
        $result = $stmt->fetchAll();
        disconnect_database($connexion);

        if (count($result) > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Ajoute un utilisateur dans la base de données.
     * Renvoie l'utilisateur créé ou null en cas d'erreur.
     */
    function add_user($username, $email, $password):User|null {
        $connexion = connection_database();
        if(is_string($connexion)){
            log_error("Erreur de connexion à la base de données : " . $connexion);
            return null;
        }
        $query = "INSERT INTO users (username , email, password, administrator, date_joined) VALUES (:username, :email, :password, :administrator, :date_joined)";
        $stmt = $connexion->prepare($query);
        $stmt->execute([
            "username" => $username,
            "email" => $email,
            "password" => password_hash($password, PASSWORD_DEFAULT),
            "administrator" => false,
            "date_joined" => date("Y-m-d H:i:s")
        ]);
        $user = new User(
            null, 
            $username, 
            $email, 
            false, 
            date("Y-m-d H:i:s")
        );
        $user->id = $connexion->lastInsertId();
        disconnect_database($connexion);
        return $user;
    }

    /**
     * Renovie l'utilisateur s'il existe dans la base de donnée, renvoie null sinon.
     */
    function test_creditentals($email, $password):User|null {
        $connexion = connection_database();
        if(is_string($connexion)){
            log_error("Erreur de connexion à la base de données : " . $connexion);
            return null;
        }
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
        disconnect_database($connexion);
        return null;
    }
?>