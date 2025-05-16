<?php
require_once("variables.php");
require_once("bdd.php");

class Image {
    public int $id;
    public string $source;
    public string $titre;
    public string $desc;
    public string $categories;
    public string $tags;
    public int $id_author;
    public bool $visibility;
    public int $likes;
    public string $upload_date;

    /**
     * Constructeur de la classe Image.
     * @param int $id Identifiant de l'image
     * @param string $source Chemin source de l'image
     * @param string $titre Titre de l'image
     * @param int $id_author Identifiant de l'auteur
     * @param string $upload_date Date d'upload
     * @param string $desc Description de l'image (optionnel)
     * @param string $categories Catégories de l'image (optionnel)
     * @param string $tags Tags de l'image (optionnel)
     * @param bool $visibility Visibilité de l'image (optionnel)
     * @param int $likes Nombre de likes (optionnel)
     */
    public function __construct(
        int $id,
        string $source,
        string $titre,
        int $id_author,
        string $upload_date,
        string $desc = "",
        string $categories = "",
        string $tags = "",
        bool $visibility = true,
        int $likes = 0
    ) {
        $this->id = $id;
        $this->source = $source;
        $this->titre = $titre;
        $this->desc = $desc;
        $this->categories = $categories;
        $this->tags = $tags;
        $this->id_author = $id_author;
        $this->likes = $likes;
        $this->visibility = $visibility;
        $this->upload_date = $upload_date;
    }

    /**
     * Retourne une représentation textuelle de l'objet Image.
     * @return string
     */
    public function __toString(): string {
        return "Image: $this->titre, Source: $this->source, Description: $this->desc, Categories: $this->categories, Tags: $this->tags, Author ID: $this->id_author, Visibility: $this->visibility, Upload Date: $this->upload_date";
    }

    /**
     * Retourne le HTML d'affichage de l'image.
     * @return string
     */
    public function toHTML(): string {
        return '<div class="post"><a href="#" role="button" post-id="' . $this->id . '" data-target="#modal" data-toggle="modal"><img src="' . htmlspecialchars($this->source) . '" alt="id:' . htmlspecialchars((string)$this->id) . '"></a></div>';
    }

    /**
     * Insère l'image dans la base de données.
     * @return void
     */
    public function put_in_bdd(): void {
        $bdd = connection_database();
        if (is_string($bdd)) {
            log_error("Erreur de connexion à la base de données : " . $bdd);
            return;
        }
        $req = $bdd->prepare('INSERT INTO Images (src, title, description, categories, tags, author_id, likes, visibility, upload_date) VALUES (:src, :title, :description, :categories, :tags, :author_id, :likes, :visibility, :upload_date)');
        $req->execute([
            'src' => $this->source,
            'title' => $this->titre,
            'description' => $this->desc,
            'categories' => $this->categories,
            'tags' => $this->tags,
            'author_id' => $this->id_author,
            'likes' => $this->likes,
            'visibility' => $this->visibility,
            'upload_date' => $this->upload_date
        ]);
        $this->id = (int)$bdd->lastInsertId();
        disconnect_database($bdd);
    }

    /**
     * Supprime l'image de la base de données et les fichiers associés.
     * @return void
     */
    public function delete_from_bdd(): void {
        $bdd = connection_database();
        if (is_string($bdd)) {
            log_error("Erreur de connexion à la base de données : " . $bdd);
            return;
        }
        $req = $bdd->prepare('DELETE FROM Images WHERE id = :id');
        $req->execute(['id' => $this->id]);
        $filename = basename($this->source);
        $file_dir = UPLOAD_DIR . $filename;
        if (file_exists($file_dir)) {
            unlink($file_dir);
        }
        $req = $bdd->prepare('DELETE FROM Comments WHERE image_id = :id');
        $req->execute(['id' => $this->id]);
        $req = $bdd->prepare('DELETE FROM Likes WHERE image_id = :id');
        $req->execute(['id' => $this->id]);
        disconnect_database($bdd);
    }
}

/**
 * Récupère une image à partir de son identifiant.
 * @param int $id Identifiant de l'image
 * @return Image|null
 */
function get_image_from_id(int $id): ?Image {
    $bdd = connection_database();
    if (is_string($bdd)) {
        log_error("Erreur de connexion à la base de données : " . $bdd);
        return null;
    }
    $req = $bdd->prepare('SELECT * FROM Images WHERE id = :id');
    $req->execute(['id' => $id]);
    $data = $req->fetch();
    disconnect_database($bdd);
    if ($data) {
        return new Image(
            (int)$data['id'],
            $data['src'],
            $data['title'],
            (int)$data['author_id'],
            $data['upload_date'],
            $data['description'],
            $data['categories'],
            $data['tags'],
            (bool)$data['visibility'],
            (int)$data['likes']
        );
    }
    return null;
}

/**
 * Récupère toutes les images d'un utilisateur.
 * @param int $id Identifiant de l'utilisateur
 * @return array<Image>|null
 */
function get_all_images_from_user_id(int $id): ?array {
    $connexion = connection_database();
    if (is_string($connexion)) {
        log_error("Erreur de connexion à la base de données : " . $connexion);
        return null;
    }
    $query = "SELECT * FROM Images WHERE author_id = :author_id";
    $stmt = $connexion->prepare($query);
    $stmt->execute(["author_id" => $id]);
    $images = $stmt->fetchAll();
    disconnect_database($connexion);
    if (count($images) === 0) {
        return null;
    }
    $images_array = [];
    foreach ($images as $image) {
        $img = new Image(
            (int)$image["id"],
            $image["src"],
            $image["title"],
            (int)$image["author_id"],
            $image["upload_date"],
            $image["description"],
            $image["categories"],
            $image["tags"],
            (bool)$image["visibility"],
            (int)$image["likes"]
        );
        $images_array[] = $img;
    }
    return $images_array;
}

/**
 * Récupère toutes les images publiques d'un utilisateur.
 * @param int $id Identifiant de l'utilisateur
 * @return array<Image>|null
 */
function get_public_images_from_user_id(int $id): ?array {
    $connexion = connection_database();
    if (is_string($connexion)) {
        log_error("Erreur de connexion à la base de données : " . $connexion);
        return null;
    }
    $query = "SELECT * FROM Images WHERE author_id = :author_id AND visibility = true";
    $stmt = $connexion->prepare($query);
    $stmt->execute(["author_id" => $id]);
    $images = $stmt->fetchAll();
    disconnect_database($connexion);
    if (count($images) === 0) {
        return null;
    }
    $images_array = [];
    foreach ($images as $image) {
        $img = new Image(
            (int)$image["id"],
            $image["src"],
            $image["title"],
            (int)$image["author_id"],
            $image["upload_date"],
            $image["description"],
            $image["categories"],
            $image["tags"],
            (bool)$image["visibility"],
            (int)$image["likes"]
        );
        $images_array[] = $img;
    }
    return $images_array;
}

/**
 * Récupère un tableau de n images publiques aléatoires, éventuellement filtrées par catégorie.
 * @param int $n Nombre d'images à récupérer
 * @param string|null $category Catégorie à filtrer (optionnel)
 * @return array<Image>|null
 */
function get_public_image(int $n, ?string $category): ?array {
    if ($n < 1) {
        return null;
    }
    $connexion = connection_database();
    if (is_string($connexion)) {
        log_error("Erreur de connexion à la base de données : " . $connexion);
        return null;
    }
    $query = "SELECT * FROM Images WHERE visibility = true";
    if ($category !== null) {
        $query .= " AND categories LIKE :category";
    }
    $query .= " ORDER BY RAND() LIMIT :n";
    $stmt = $connexion->prepare($query);
    $stmt->bindValue(':n', $n, PDO::PARAM_INT);
    if ($category !== null) {
        $stmt->bindValue(':category', "%$category%", PDO::PARAM_STR);
    }
    $stmt->execute();
    $images = $stmt->fetchAll();
    disconnect_database($connexion);
    if (count($images) === 0) {
        return null;
    }
    $images_array = [];
    foreach ($images as $image) {
        $img = new Image(
            (int)$image["id"],
            $image["src"],
            $image["title"],
            (int)$image["author_id"],
            $image["upload_date"],
            $image["description"],
            $image["categories"],
            $image["tags"],
            (bool)$image["visibility"],
            (int)$image["likes"]
        );
        $images_array[] = $img;
    }
    return $images_array;
}

/**
 * Compte le nombre d'images d'un utilisateur.
 * @param int $id Identifiant de l'utilisateur
 * @return int
 */
function count_user_images(int $id): int {
    $connexion = connection_database();
    if (is_string($connexion)) {
        log_error("Erreur de connexion à la base de données : " . $connexion);
        return 0;
    }
    $query = "SELECT COUNT(*) FROM Images WHERE author_id = :author_id";
    $stmt = $connexion->prepare($query);
    $stmt->execute(["author_id" => $id]);
    $count = $stmt->fetchColumn();
    disconnect_database($connexion);
    return (int)$count;
}
?>