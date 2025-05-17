<?php
require_once("bdd.php");

class User {
    public int $id;
    public string $username;
    public string $email;
    public bool $administrator;
    public string $date_joined;
    public string $nom;
    public string $prenom;
    public string $password;
    public string $src_pfp;
    public string $bio;

    public function __construct(
        int $id,
        string $username,
        string $email,
        bool $administrator,
        string $date_joined,
        ?string $nom = null,
        ?string $prenom = null,
        ?string $bio = null,
        ?string $src_pfp = null
    ) {
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

    public function __toString(): string {
        return "User: $this->username, Email: $this->email, Administrator: $this->administrator, Date Joined: $this->date_joined";
    }

    /**
     * Change le nom d'utilisateur dans la base de données.
     * @param string $new_username Nouveau nom d'utilisateur
     * @return bool True si succès, False sinon
     */
    public function change_username(string $new_username): bool {
        if (user_exists($new_username, "")) {
            return false;
        }
        $connexion = connection_database();
        if (is_string($connexion)) {
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

    /**
     * Change l'email dans la base de données.
     * @param string $new_email Nouvel email
     * @return bool True si succès, False sinon
     */
    public function change_email(string $new_email): bool {
        if (user_exists("", $new_email)) {
            return false;
        }
        $connexion = connection_database();
        if (is_string($connexion)) {
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

    /**
     * Change le mot de passe dans la base de données.
     * @param string $new_password Nouveau mot de passe (en clair)
     * @return bool True si succès, False sinon
     */
    public function change_password(string $new_password): bool {
        $hashed = password_hash($new_password, PASSWORD_DEFAULT);
        $connexion = connection_database();
        if (is_string($connexion)) {
            log_error("Erreur de connexion à la base de données : " . $connexion);
            return false;
        }
        $query = "UPDATE Users SET password = :password WHERE id = :id";
        $stmt = $connexion->prepare($query);
        $stmt->execute([
            "password" => $hashed,
            "id" => $this->id
        ]);
        disconnect_database($connexion);
        $this->password = $hashed;
        return true;
    }

    /**
     * Change la photo de profil dans la base de données.
     * @param string $new_src_pfp Nouvelle source de la photo de profil
     * @return bool True si succès, False sinon
     */
    public function change_profile_photo(string $new_src_pfp): bool {
        $connexion = connection_database();
        if (is_string($connexion)) {
            log_error("Erreur de connexion à la base de données : " . $connexion);
            return false;
        }
        $query = "UPDATE Users SET profile_photo_src = :src_pfp WHERE id = :id";
        $stmt = $connexion->prepare($query);
        $stmt->execute([
            "src_pfp" => $new_src_pfp,
            "id" => $this->id
        ]);
        disconnect_database($connexion);
        $this->src_pfp = $new_src_pfp;
        return true;
    }

    /**
     * Change la biographie dans la base de données.
     * @param string $new_bio Nouvelle bio
     * @return bool True si succès, False sinon
     */
    public function change_bio(string $new_bio): bool {
        $connexion = connection_database();
        if (is_string($connexion)) {
            log_error("Erreur de connexion à la base de données : " . $connexion);
            return false;
        }
        $query = "UPDATE Users SET bio = :bio WHERE id = :id";
        $stmt = $connexion->prepare($query);
        $stmt->execute([
            "bio" => $new_bio,
            "id" => $this->id
        ]);
        disconnect_database($connexion);
        $this->bio = $new_bio;
        return true;
    }

    /**
     * Change le nom de famille dans la base de données.
     * @param string $new_nom Nouveau nom de famille
     * @return bool True si succès, False sinon
     */
    public function change_nom(string $new_nom): bool {
        $connexion = connection_database();
        if (is_string($connexion)) {
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

    /**
     * Change le prénom dans la base de données.
     * @param string $new_prenom Nouveau prénom
     * @return bool True si succès, False sinon
     */
    public function change_prenom(string $new_prenom): bool {
        $connexion = connection_database();
        if (is_string($connexion)) {
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
 * Récupère un utilisateur par son nom d'utilisateur.
 * @param string $username Nom d'utilisateur
 * @return User|null L'utilisateur ou null si non trouvé
 */
function get_user(string $username): ?User {
    $connexion = connection_database();
    if (is_string($connexion)) {
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
    if (!$user) {
        return null;
    }
    return new User(
        $user["id"],
        $user["username"],
        $user["email"],
        (bool)$user["administrator"],
        $user["date_joined"],
        $user["last_name"] ?? null,
        $user["first_name"] ?? null,
        $user["bio"] ?? null,
        $user["profile_photo_src"] ?? null
    );
}

/**
 * Vérifie si un utilisateur existe par son nom d'utilisateur ou son email.
 * @param string $username Nom d'utilisateur
 * @param string $email Email
 * @return bool True si l'utilisateur existe, False sinon
 */
function user_exists(string $username, string $email): bool {
    $connexion = connection_database();
    if (is_string($connexion)) {
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
    return count($result) > 0;
}

/**
 * Récupère un utilisateur par son identifiant.
 * @param int|null $id Identifiant utilisateur
 * @return User|null L'utilisateur ou null si non trouvé
 */
function get_user_from_id(?int $id): ?User {
    if ($id === null) {
        return null;
    }
    $connexion = connection_database();
    if (is_string($connexion)) {
        log_error("Erreur de connexion à la base de données : " . $connexion);
        return null;
    }
    $query = "SELECT * FROM Users WHERE id = :id";
    $stmt = $connexion->prepare($query);
    $stmt->execute([
        "id" => $id
    ]);
    $user = $stmt->fetch();
    disconnect_database($connexion);
    if (!$user) {
        return null;
    }
    return new User(
        $user["id"],
        $user["username"],
        $user["email"],
        (bool)$user["administrator"],
        $user["date_joined"],
        $user["last_name"] ?? null,
        $user["first_name"] ?? null,
        $user["bio"] ?? null,
        $user["profile_photo_src"] ?? null
    );
}

/**
 * Ajoute un nouvel utilisateur à la base de données.
 * @param string $username Nom d'utilisateur
 * @param string $email Email
 * @param string $password Mot de passe (en clair)
 * @return User|null L'utilisateur créé ou null en cas d'erreur
 */
function add_user(string $username, string $email, string $password): ?User {
    $connexion = connection_database();
    if (is_string($connexion)) {
        log_error("Erreur de connexion à la base de données : " . $connexion);
        return null;
    }
    $query = "INSERT INTO Users (username, email, password, administrator, date_joined) VALUES (:username, :email, :password, :administrator, :date_joined)";
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
        (int)$last_Id,
        $username,
        $email,
        false,
        date("Y-m-d H:i:s")
    );
    disconnect_database($connexion);
    return $user;
}

/**
 * Vérifie les identifiants de connexion d'un utilisateur.
 * @param string $email Email
 * @param string $password Mot de passe (en clair)
 * @return User|null L'utilisateur si les identifiants sont corrects, sinon null
 */
function test_creditentals(string $email, string $password): ?User {
    $connexion = connection_database();
    if (is_string($connexion)) {
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
            (bool)$user["administrator"],
            $user["date_joined"],
            $user["last_name"] ?? null,
            $user["first_name"] ?? null,
            $user["bio"] ?? null,
            $user["profile_photo_src"] ?? null
        );
    }
    return null;
}

/**
 * Compte le nombre de likes reçus sur les images d'un utilisateur.
 * @param int $id Identifiant utilisateur
 * @return int|null Nombre de likes ou null en cas d'erreur
 */
function count_user_likes(int $id): ?int {
    $connexion = connection_database();
    if (is_string($connexion)) {
        log_error("Erreur de connexion à la base de données : " . $connexion);
        return null;
    }
    $query = "SELECT COUNT(*) FROM Likes WHERE image_id IN (SELECT id FROM Images WHERE author_id = :user_id)";
    $stmt = $connexion->prepare($query);
    $stmt->execute([
        "user_id" => $id
    ]);
    $count = $stmt->fetchColumn();
    disconnect_database($connexion);
    return $count !== false ? (int)$count : null;
}
?>