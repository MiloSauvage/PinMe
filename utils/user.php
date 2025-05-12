<?php
    require_once("bdd.php");

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
        
        function __construct($id, $username, $email, $administrator, $date_joined, $nom = null, $prenom = null, $bio = null, $src_pfp = null) {
            $this->id = $id;
            $this->username = $username;
            $this->email = $email;
            $this->administrator = $administrator;
            $this->date_joined = $date_joined;
            $this->nom = $nom;
            $this->prenom = $prenom;
            $this->bio = $bio;
            $this->src_pfp = $src_pfp;
        }

        function __toString() {
            return "User: $this->username, Email: $this->email, Administrator: $this->administrator, Date Joined: $this->date_joined";
        }

        /**
         * Change le nom d'utilisateur de l'utilisateur dans la base de données.
         * Renvoie true si la modification a réussi, false sinon.
         */
        function change_username($new_username):bool {
            if (user_exists($new_username, "")) {
                return false;
            }
            $this->username = $new_username;
            $connexion = connection_database();
            if(is_string($connexion)){
                log_error("Erreur de connexion à la base de données : " . $connexion);
                return false;
            }
            $query = "UPDATE Users SET username = :username WHERE id = :id";
            $stmt = $connexion->prepare($query);
            $stmt->execute([
                "username" => $new_username,
                "id" => $this->id
            ]);
            disconnect_database($connexion);
            $this->username = $new_username;
            return true;
        }

        function change_email($new_email){
            if (user_exists("", $new_email)) {
                return false;
            }
            $this->email = $new_email;
            $connexion = connection_database();
            if(is_string($connexion)){
                log_error("Erreur de connexion à la base de données : " . $connexion);
                return false;
            }
            $query = "UPDATE Users SET email = :email WHERE id = :id";
            $stmt = $connexion->prepare($query);
            $stmt->execute([
                "email" => $new_email,
                "id" => $this->id
            ]);
            disconnect_database($connexion);
            $this->email = $new_email;
            return true;
        }

        function change_password($new_password){
            $this->password = password_hash($new_password, PASSWORD_DEFAULT);
            $connexion = connection_database();
            if(is_string($connexion)){
                log_error("Erreur de connexion à la base de données : " . $connexion);
                return false;
            }
            $query = "UPDATE Users SET password = :password WHERE id = :id";
            $stmt = $connexion->prepare($query);
            $stmt->execute([
                "password" => $this->password,
                "id" => $this->id
            ]);
            disconnect_database($connexion);
            $this->password = $new_password;
            return true;
        }

        function change_profile_photo($new_src_pfp){
            $this->src_pfp = $new_src_pfp;
            $connexion = connection_database();
            if(is_string($connexion)){
                log_error("Erreur de connexion à la base de données : " . $connexion);
                return false;
            }
            $query = "UPDATE Users SET profile_photo_src = :src_pfp WHERE id = :id";
            $stmt = $connexion->prepare($query);
            $stmt->execute([
                "src_pfp" => $this->src_pfp,
                "id" => $this->id
            ]);
            disconnect_database($connexion);
            $this->src_pfp = $new_src_pfp;
            return true;

        }

        function change_bio($new_bio){
            $this->bio = $new_bio;
            $connexion = connection_database();
            if(is_string($connexion)){
                log_error("Erreur de connexion à la base de données : " . $connexion);
                return false;
            }
            $query = "UPDATE Users SET bio = :bio WHERE id = :id";
            $stmt = $connexion->prepare($query);
            $stmt->execute([
                "bio" => $this->bio,
                "id" => $this->id
            ]);
            disconnect_database($connexion);
            $this->bio = $new_bio;
            return true;

        }

        function change_nom($new_nom){
            $this->nom = $new_nom;
            $connexion = connection_database();
            if(is_string($connexion)){
                log_error("Erreur de connexion à la base de données : " . $connexion);
                return false;
            }
            $query = "UPDATE Users SET last_name = :nom WHERE id = :id";
            $stmt = $connexion->prepare($query);
            $stmt->execute([
                "nom" => $new_nom,
                "id" => $this->id
            ]);
            disconnect_database($connexion);
            $this->nom = $new_nom;
            return true;

        }

        function change_prenom($new_prenom){
            $this->prenom = $new_prenom;
            $connexion = connection_database();
            if(is_string($connexion)){
                log_error("Erreur de connexion à la base de données : " . $connexion);
                return false;
            }
            $query = "UPDATE Users SET first_name = :prenom WHERE id = :id";
            $stmt = $connexion->prepare($query);
            $stmt->execute([
                "prenom" => $new_prenom,
                "id" => $this->id
            ]);
            disconnect_database($connexion);
            $this->prenom = $new_prenom;
            return true;
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
        $query = "SELECT * FROM Users WHERE username = :username";
        $stmt = $connexion->prepare($query);
        $stmt->execute([
            "username" => $username
        ]);
        $user = $stmt->fetch();
        disconnect_database($connexion);
        if(!$user){
            return null;
        }

        return new User(
            $user["id"], 
            $user["username"], 
            $user["email"], 
            $user["administrator"], 
            $user["date_joined"], 
            $user["last_name"] ?? null, 
            $user["first_name"] ?? null,
            $user["bio"] ?? null,
            $user["profile_photo_src"] ?? null
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
        $query = "SELECT * FROM Users WHERE username = :username OR email = :email";
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
     * Renvoie un utilisateur grâce à son id.
     * Si l'utilisateur n'existe pas, renvoie null.
     * Si l' id est null, renvoie null.
     */
    function get_user_from_id($id):User|null {
        if($id === null){
            return null;
        }
        $connexion = connection_database();
        if(is_string($connexion)){
            log_error("Erreur de connexion à la base de données : " . $connexion);
            return false;
        }
        $query = "SELECT * FROM Users WHERE id = :id";
        $stmt = $connexion->prepare($query);
        $stmt->execute([
            "id" => $id
        ]);
        $user = $stmt->fetch();
        disconnect_database($connexion);
        if(!$user){
            return null;
        }
        return new User(
            $user["id"], 
            $user["username"], 
            $user["email"], 
            $user["administrator"], 
            $user["date_joined"], 
            $user["last_name"] ?? null, 
            $user["first_name"] ?? null,
            $user["bio"] ?? null,
            $user["profile_photo_src"] ?? null
        );
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
        $query = "INSERT INTO Users (username , email, password, administrator, date_joined) VALUES (:username, :email, :password, :administrator, :date_joined)";
        $stmt = $connexion->prepare($query);
        $stmt->execute([
            "username" => $username,
            "email" => $email,
            "password" => password_hash($password, PASSWORD_DEFAULT),
            "administrator" => 0,
            "date_joined" => date("Y-m-d H:i:s")
        ]);
        $last_Id = $connexion->lastInsertId();
        $user = new User(
            $last_Id, 
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
        $query = "SELECT * FROM Users WHERE email = :email";
        $stmt = $connexion->prepare($query);
        $stmt->execute([
            "email" => $email
        ]);
        $user = $stmt->fetch(); 
        disconnect_database($connexion);
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
        return null;
    }

    function count_user_likes($id){
        $connexion = connection_database();
        if(is_string($connexion)){
            log_error("Erreur de connexion à la base de données : " . $connexion);
            return null;
        }
        $query = "SELECT COUNT(*) FROM Likes WHERE image_id in (SELECT id FROM Images WHERE author_id = :user_id)";
        $stmt = $connexion->prepare($query);
        $stmt->execute([
            "user_id" => $id
        ]);
        $count = $stmt->fetchColumn();
        disconnect_database($connexion);
        return $count;
    }
?>