<?php
    require_once('bdd.php');

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

        function __construct($id, $image_id, $title, $user_id, $position_x, $position_y, $width, $height, $color) {
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

        function __toString() {
            return "Annotation: $this->title, Image ID: $this->image_id, User ID: $this->user_id, Description: $this->description, Position: ($this->position_x, $this->position_y)";
        }

        function put_in_bdd():bool{
            $bdd = connection_database();
            if (is_string($bdd)) {
                log_error("Erreur de connexion à la base de données : " . $bdd);
                return false;
            }
            $req = $bdd->prepare('INSERT INTO Annotations (image_id, title, user_id, position_x, position_y, width, height, color) VALUES (:image_id, :title, :user_id, :position_x, :position_y, :width, :height, :color)');
            $req->execute(array(
                'image_id' => $this->image_id,
                'title' => $this->title,
                'user_id' => $this->user_id,
                'position_x' => $this->position_x,
                'position_y' => $this->position_y,
                'width' => $this->width,
                'height' => $this->height,
                'color' => $this->color
            ));
            if ($req->rowCount() > 0) {
                return true;
            } else {
                log_error("Erreur lors de l'insertion de l'annotation : " . $req->errorInfo()[2]);
                return false;
            }
            disconnect_database($bdd);
        }

    }
?>