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
            return "Image: $this->titre, Source: $this->source, Description: $this->desc, Categories: $this->categories, Tags: $this->tags, Author ID: $this->id_author, Visibility: $this->visibility, Upload Date: $this->upload_date";
        }
    }


?>