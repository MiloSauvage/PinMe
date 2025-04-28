<?php
    require_once("variables.php");
    require_once("bdd.php");

    class Image {
        public $id;
        public $source;
        public $titre;
        public $desc;
        public $categories;
        public $tags;
        public $id_author;
        public $visibility;
        public $likes;
        public $upload_date;
        
        function __construct($id, $source,  $titre, $id_author, $upload_date, $desc = "", $categories = "", $tags = "",$visibility = true, $likes = 0) {
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

        function __toString() {
            return "Image: $this->titre, Source: $this->source,  Description: $this->desc, Categories: $this->categories, Tags: $this->tags, Author ID: $this->id_author, Visibility: $this->visibility, Upload Date: $this->upload_date";
        }

        // obselète, à refaire
        function toHTML(){
            return '<div class="post"><a href="#" role="button" post-id="' . $this->id .'" data-target="#modal" data-toggle="modal"><img src="' . htmlspecialchars($this->source) . '" alt="id:' . htmlspecialchars($this->id) . '"></a></div>';
        }

        function put_in_bdd($bdd) {
            $req = $bdd->prepare('INSERT INTO Images (src, title, description, categories, tags, author_id, likes, visibility, upload_date) VALUES (:src, :title, :description, :categories, :tags, :author_id, :likes, :visibility, :upload_date)');
            $req->execute(array(
                'src' => $this->source,
                'title' => $this->titre,
                'description' => $this->desc,
                'categories' => $this->categories,
                'tags' => $this->tags,
                'author_id' => $this->id_author,
                'likes' => $this->likes,
                'visibility' => $this->visibility,
                'upload_date' => $this->upload_date
            ));
        }

        function delete_from_bdd() {
            $bdd = connection_database();
            $req = $bdd->prepare('DELETE FROM Images WHERE id = :id');
            $req->execute(array('id' => $this->id));
            $filename = basename($this->source);
            $file_dir = UPLOAD_DIR . $filename;
            if (file_exists($file_dir)) {
                unlink($file_dir);
            }
            disconnect_database($bdd);
        }
    }

    function get_image_from_id($id) {
        $bdd = connection_database();
        $req = $bdd->prepare('SELECT * FROM Images WHERE id = :id');
        $req->execute(array('id' => $id));
        $data = $req->fetch();
        if ($data) {
            return new Image($data['id'],
                             $data['src'],
                             $data['title'],
                             $data['author_id'],
                             $data['upload_date'],
                             $data['description'],
                             $data['categories'],
                             $data['tags'],
                             $data['visibility'],
                             $data["likes"]);
        } else {
            return null;
        }
        disconnect_database($bdd);
    }

    /**
     * Renvoie un tableau contenant toutes les images d'un utilisateur.
     * Si l'utilisateur n'a pas d'images, renvoie null.
     */
    function get_all_images_from_user_id($id):array|null{
        $connexion = connection_database();
        if(is_string($connexion)){
            log_error("Erreur de connexion à la base de données : " . $connexion);
            return null;
        }
        $query = "SELECT * FROM Images WHERE author_id = :author_id";
        $stmt = $connexion->prepare($query);
        $stmt->execute([
            "author_id" => $id
        ]);
        $images = $stmt->fetchAll();
        disconnect_database($connexion);
        if(count($images) === 0){
            return null;
        }
        $images_array = [];
        foreach ($images as $image) {
            $img = new Image(
                $image["id"], 
                $image["src"], 
                $image["title"], 
                $image["description"], 
                $image["categories"], 
                $image["tags"], 
                $image["author_id"], 
                $image["likes"],
                $image["visibility"], 
                $image["upload_date"]
            );
            array_push($images_array, $img);
        }
        return $images_array;
    }

    /**
     * Renvoie un tableau contenant toutes les images publics d'un utilisateur.
     * Si l'utilisateur n'a pas d'images, renvoie null.
     */
    function get_public_images_from_user_id($id):array|null{
        $connexion = connection_database();
        if(is_string($connexion)){
            log_error("Erreur de connexion à la base de données : " . $connexion);
            return null;
        }
        $query = "SELECT * FROM Images WHERE author_id = :author_id AND visibility = true";
        $stmt = $connexion->prepare($query);
        $stmt->execute([
            "author_id" => $id
        ]);
        $images = $stmt->fetchAll();
        disconnect_database($connexion);
        if(count($images) === 0){
            return null;
        }
        $images_array = [];
        foreach ($images as $image) {
            $img = new Image(
                $image["id"], 
                $image["src"], 
                $image["title"], 
                $image["description"], 
                $image["categories"], 
                $image["tags"], 
                $image["author_id"], 
                $image["likes"],
                $image["visibility"], 
                $image["upload_date"]
            );
            array_push($images_array, $img);
        }
        return $images_array;
    }

    /**
     * Renvoie un tableau contenant un nombre n d'images aléatoires publics selon une catégorie 
     * nommée category.
     * Si category vaut null, renvoie un tableau contenant n images aléatoires publiques.
     */
    function get_public_image($n, $category):array|null{
        if($n < 1){
            return null;
        }
        $connexion = connection_database();
        if(is_string($connexion)){
            log_error("Erreur de connexion à la base de données : " . $connexion);
            return null;
        }
        $query = "SELECT * FROM Images WHERE visibility = true";
        if($category !== null){
            $query .= " AND Categories LIKE :category";
        }
        // trie dans l'ordre aléatoire et limite le nombre d'images à n
        $query .= " ORDER BY RAND() LIMIT :n";
        $stmt = $connexion->prepare($query);
        // force l' " int "
        $stmt->bindValue(':n', $n, PDO::PARAM_INT);
        if($category !== null){
            $stmt->bindValue(':category', "%$category%", PDO::PARAM_STR);
        }
        $stmt->execute();
        $images = $stmt->fetchAll();
        disconnect_database($connexion);

        echo count($images);
        if(count($images) === 0){
            return null;
        }
        $images_array = [];
        foreach ($images as $image) {
            $img = new Image(
                $image["id"], 
                $image["src"], 
                $image["title"], 
                $image["description"], 
                $image["categories"], 
                $image["tags"], 
                $image["author_id"], 
                $image["likes"],
                $image["visibility"], 
                $image["upload_date"]
            );
            array_push($images_array, $img);
        }
        return $images_array;
    }
?>