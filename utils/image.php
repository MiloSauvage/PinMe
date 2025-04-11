<?php
    class Image {
        public $id;
        public $source;
        public $titre;
        public $desc;
        public $categories;
        public $tags;
        public $id_author;
        public $visibility;
        public $upload_date;
        
        function __construct($id, $source, $titre, $desc = "", $categories = "", $tags = "", $id_author, $visibility = true, $upload_date) {
            $this->id = $id;
            $this->source = $source;
            $this->titre = $titre;
            $this->desc = $desc;
            $this->categories = $categories;
            $this->tags = $tags;
            $this->id_author = $id_author;
            $this->visibility = $visibility;
            $this->upload_date = $upload_date;
        }

        function __toString() {
            return "Image: $this->titre, Source: $this->source,  Description: $this->desc, Categories: $this->categories, Tags: $this->tags, Author ID: $this->id_author, Visibility: $this->visibility, Upload Date: $this->upload_date";
        }

        function toHTML(){
            return '<div class="post"><a href="#" role="button" data-target="#modal" data-toggle="modal"><img src="' . htmlspecialchars($this->source) . '" alt="id:' . htmlspecialchars($this->id) . '"></a></div>';
        }

        function put_in_bdd($bdd) {
            $req = $bdd->prepare('INSERT INTO images (src, title, description, categories, tags, author_id, visibility, upload_date) VALUES (:src, :title, :description, :categories, :tags, :author_id, :visibility, :upload_date)');
            $req->execute(array(
                'src' => $this->source,
                'title' => $this->titre,
                'description' => $this->desc,
                'categories' => $this->categories,
                'tags' => $this->tags,
                'author_id' => $this->id_author,
                'visibility' => $this->visibility,
                'upload_date' => $this->upload_date
            ));
        }

        function get_from_bdd($bdd, $id) {
            $req = $bdd->prepare('SELECT * FROM images WHERE id = :id');
            $req->execute(array('id' => $id));
            $data = $req->fetch(PDO::FETCH_ASSOC);
            
            if ($data) {
                return new Image($data['id'], $data['src'], $data['title'], $data['description'], $data['categories'], $data['tags'], $data['author_id'], $data['visibility'], $data['upload_date']);
            } else {
                return null;
            }
        }

        function delete_from_bdd($bdd, $id) {;
            $req = $bdd->prepare('DELETE FROM images WHERE id = :id');
            $req->execute(array('id' => $id));
            unlink($source);
        }
    }
?>