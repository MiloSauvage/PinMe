<?php
require_once('bdd.php');

/**
 * Classe représentant une annotation sur une image.
 */
class Annotation {
    public $id;
    public $image_id;
    public $title;
    public $user_id;
    public $position_x;
    public $position_y;
    public $width;
    public $height;
    public $color;

    /**
     * Constructeur de la classe Annotation.
     * 
     * @param int $id Identifiant de l'annotation
     * @param int $image_id Identifiant de l'image annotée
     * @param string $title Titre de l'annotation
     * @param int $user_id Identifiant de l'utilisateur
     * @param float $position_x Position X de l'annotation
     * @param float $position_y Position Y de l'annotation
     * @param float $width Largeur de l'annotation
     * @param float $height Hauteur de l'annotation
     * @param string $color Couleur de l'annotation
     */
    public function __construct(
        int $id,
        int $image_id,
        string $title,
        int $user_id,
        float $position_x,
        float $position_y,
        float $width,
        float $height,
        string $color
    ) {
        $this->id = $id;
        $this->image_id = $image_id;
        $this->title = $title;
        $this->user_id = $user_id;
        $this->position_x = $position_x;
        $this->position_y = $position_y;
        $this->width = $width;
        $this->height = $height;
        $this->color = $color;
    }

    /**
     * Retourne une représentation textuelle de l'annotation.
     * 
     * @return string
     */
    public function __toString(): string {
        return "Annotation: $this->title, Image ID: $this->image_id, User ID: $this->user_id, Position: ($this->position_x, $this->position_y)";
    }

    /**
     * Récupère une connexion à la base de données.
     * 
     * @return PDO|false
     */
    private static function get_db() {
        $bdd = connection_database();
        if (is_string($bdd)) {
            log_error("Erreur de connexion à la base de données : " . $bdd);
            return false;
        }
        return $bdd;
    }

    /**
     * Insère l'annotation dans la base de données.
     * 
     * @return bool Succès de l'insertion
     */
    public function put_in_bdd(): bool {
        $bdd = self::get_db();
        if (!$bdd) return false;
        $req = $bdd->prepare(
            'INSERT INTO Annotations (image_id, title, user_id, position_x, position_y, width, height, color) 
            VALUES (:image_id, :title, :user_id, :position_x, :position_y, :width, :height, :color)'
        );
        $req->execute([
            'image_id' => $this->image_id,
            'title' => $this->title,
            'user_id' => $this->user_id,
            'position_x' => $this->position_x,
            'position_y' => $this->position_y,
            'width' => $this->width,
            'height' => $this->height,
            'color' => $this->color
        ]);
        $success = $req->rowCount() > 0;
        if (!$success) log_error("Erreur lors de l'insertion de l'annotation : " . $req->errorInfo()[2]);
        disconnect_database($bdd);
        return $success;
    }

    /**
     * Supprime l'annotation de la base de données.
     * 
     * @return bool Succès de la suppression
     */
    public function delete_from_bdd(): bool {
        $bdd = self::get_db();
        if (!$bdd) return false;
        $req = $bdd->prepare('DELETE FROM Annotations WHERE id = :id');
        $req->execute(['id' => $this->id]);
        $success = $req->rowCount() > 0;
        if (!$success) log_error("Erreur lors de la suppression de l'annotation : " . $req->errorInfo()[2]);
        disconnect_database($bdd);
        return $success;
    }
}

/**
 * Récupère une annotation par son identifiant.
 * 
 * @param int $id Identifiant de l'annotation
 * @return Annotation|null L'annotation trouvée ou null si non trouvée
 */
function get_annotation_by_id(int $id): ?Annotation {
    $bdd = Annotation::get_db();
    if (!$bdd) return false;
    $req = $bdd->prepare('SELECT * FROM Annotations WHERE id = :id');
    $req->execute(['id' => $id]);
    $data = $req->fetch();
    disconnect_database($bdd);
    if ($data) {
        return new Annotation(
            $data['id'],
            $data['image_id'],
            $data['title'],
            $data['user_id'],
            $data['position_x'],
            $data['position_y'],
            $data['width'],
            $data['height'],
            $data['color']
        );
    }
    return null;
}

/**
 * Récupère toutes les annotations associées à une image.
 * 
 * @param int $image_id Identifiant de l'image
 * @return Annotation[] Tableau d'annotations
 */
function get_annotations_by_image_id(int $image_id): array {
    $bdd = Annotation::get_db();
    if (!$bdd) return [];
    $req = $bdd->prepare('SELECT * FROM Annotations WHERE image_id = :image_id');
    $req->execute(['image_id' => $image_id]);
    $annotations = [];
    while ($data = $req->fetch()) {
        $annotations[] = new Annotation(
            $data['id'],
            $data['image_id'],
            $data['title'],
            $data['user_id'],
            $data['position_x'],
            $data['position_y'],
            $data['width'],
            $data['height'],
            $data['color']
        );
    }
    disconnect_database($bdd);
    return $annotations;
}
?>
