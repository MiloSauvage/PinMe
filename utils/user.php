<?php
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
        
        function __construct($id, $username, $email, $administrator, $date_joined, $nom = null, $prenom = null) {
            $this->id = $id;
            $this->username = $username;
            $this->email = $email;
            $this->administrator = $administrator;
            $this->date_joined = $date_joined;
            $this->nom = $nom;
            $this->prenom = $prenom;
        }

        function __toString() {
            return "User: $this->username, Email: $this->email, Administrator: $this->administrator, Date Joined: $this->date_joined";
        }
    }


?>