<?php
    require_once("variables.php");
    require_once("bdd.php");

    class Comment {
        public $id;
        public $linked_image_id;
        public $id_author;
        public $content;
        public $upload_date;
        
        function __construct($id, $linked_image_id, $id_author, $content, $upload_date) {
            $this->id = $id;
            $this->linked_image_id = $linked_image_id;
            $this->id_author = $id_author;
            $this->content = $content;
            $this->upload_date = $upload_date;
        }

        function __toString() {
            return "Comment: $this->content, Linked Image ID: $this->linked_image_id, Author ID: $this->id_author, Likes: $this->likes, Pinned: $this->pinned, Upload Date: $this->upload_date";
        }

        function toHTML(){
            return "toHTML() not implemented yet";
        }

        function put_in_bdd() {
            $bdd = connection_database();
            $req = $bdd->prepare('INSERT INTO Comments (image_id, user_id, comment, date) VALUES (:linked_image_id, :id_author, :content, NOW())');
            $req->execute(array(
                'linked_image_id' => $this->linked_image_id,
                'id_author' => $this->id_author,
                'content' => $this->content
            ));
            disconnect_database($bdd);
        }

        function delete_from_bdd() {
            $bdd = connection_database();
            $req = $bdd->prepare('DELETE FROM Comments WHERE id = :id');
            $req->execute(array('id' => $this->id));
            disconnect_database($bdd);
        }

        function edit($new_content) {
            $this->content = $new_content;
            $bdd = connection_database();
            $req = $bdd->prepare('UPDATE Comments SET comment = :content WHERE id = :id');
            $req->execute(array(
                'content' => $this->content,
                'id' => $this->id
            ));
            disconnect_database($bdd);
        }
    }

    /*
    * Renvoie tous les commentaires créer sous un post d'id $id.
    */
    function get_comments_from_image_id($id) {
        $bdd = connection_database();
        $req = $bdd->prepare('SELECT * FROM Comments WHERE image_id = :id ORDER BY date DESC');
        $req->execute(array('id' => $id));
        disconnect_database($bdd);
        $comments = array();
        while ($data = $req->fetch()) {
            $comments[] = new Comment(
                $data['id'],
                $data['image_id'],
                $data['user_id'],
                $data['comment'],
                $data['date']
            );
        }
        return $comments;
    }

    /*
    * Renvoie le commentaire d'id $id.
    * Renvoie null si le commentaire n'existe pas.
    */
    function get_comment_from_id($id) {
        $bdd = connection_database();
        $req = $bdd->prepare('SELECT * FROM Comments WHERE id = :id');
        $req->execute(array('id' => $id));
        disconnect_database($bdd);
        $data = $req->fetch();
        if ($data) {
            return new Comment(
                $data['id'],
                $data['image_id'],
                $data['user_id'],
                $data['comment'],
                $data['date']
            );
        } else {
            return null;
        }
    }
?>