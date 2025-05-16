<?php
require_once("variables.php");
require_once("bdd.php");

class Comment {
    public $id;
    public $linked_image_id;
    public $id_author;
    public $content;
    public $upload_date;

    /**
     * Constructeur de la classe Comment.
     * @param int $id Identifiant du commentaire.
     * @param int $linked_image_id Identifiant de l'image liée.
     * @param int $id_author Identifiant de l'auteur.
     * @param string $content Contenu du commentaire.
     * @param string $upload_date Date de publication.
     */
    function __construct($id, $linked_image_id, $id_author, $content, $upload_date) {
        $this->id = $id;
        $this->linked_image_id = $linked_image_id;
        $this->id_author = $id_author;
        $this->content = $content;
        $this->upload_date = $upload_date;
    }

    /**
     * Retourne une représentation textuelle du commentaire.
     * @return string
     */
    function __toString(): string {
        return "Comment: $this->content, Linked Image ID: $this->linked_image_id, Author ID: $this->id_author, Upload Date: $this->upload_date";
    }

    /**
     * Retourne une représentation HTML du commentaire (non implémenté).
     * @return string
     */
    function toHTML(): string {
        return "toHTML() not implemented yet";
    }

    /**
     * Insère le commentaire dans la base de données.
     * @return void
     */
    function put_in_bdd(): void {
        $bdd = connection_database();
        $req = $bdd->prepare('INSERT INTO Comments (image_id, user_id, comment, date) VALUES (:linked_image_id, :id_author, :content, NOW())');
        $req->execute([
            'linked_image_id' => $this->linked_image_id,
            'id_author' => $this->id_author,
            'content' => $this->content
        ]);
        disconnect_database($bdd);
    }

    /**
     * Supprime le commentaire de la base de données.
     * @return void
     */
    function delete_from_bdd(): void {
        $bdd = connection_database();
        $req = $bdd->prepare('DELETE FROM Comments WHERE id = :id');
        $req->execute(['id' => $this->id]);
        disconnect_database($bdd);
    }

    /**
     * Modifie le contenu du commentaire et met à jour la base de données.
     * @param string $new_content Nouveau contenu du commentaire.
     * @return void
     */
    function edit(string $new_content): void {
        $this->content = $new_content;
        $bdd = connection_database();
        $req = $bdd->prepare('UPDATE Comments SET comment = :content WHERE id = :id');
        $req->execute([
            'content' => $this->content,
            'id' => $this->id
        ]);
        disconnect_database($bdd);
    }
}

/**
 * Récupère tous les commentaires liés à une image.
 * @param int $id Identifiant de l'image.
 * @return Comment[] Tableau d'objets Comment.
 */
function get_comments_from_image_id(int $id): array {
    $bdd = connection_database();
    $req = $bdd->prepare('SELECT * FROM Comments WHERE image_id = :id ORDER BY date DESC');
    $req->execute(['id' => $id]);
    $comments = [];
    while ($data = $req->fetch()) {
        $comments[] = new Comment(
            $data['id'],
            $data['image_id'],
            $data['user_id'],
            $data['comment'],
            $data['date']
        );
    }
    disconnect_database($bdd);
    return $comments;
}

/**
 * Récupère un commentaire par son identifiant.
 * @param int $id Identifiant du commentaire.
 * @return Comment|null Objet Comment ou null si non trouvé.
 */
function get_comment_from_id(int $id): ?Comment {
    $bdd = connection_database();
    $req = $bdd->prepare('SELECT * FROM Comments WHERE id = :id');
    $req->execute(['id' => $id]);
    $data = $req->fetch();
    disconnect_database($bdd);
    if ($data) {
        return new Comment(
            $data['id'],
            $data['image_id'],
            $data['user_id'],
            $data['comment'],
            $data['date']
        );
    }
    return null;
}
?>