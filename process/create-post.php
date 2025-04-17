<?php
    require_once "../utils/variables.php";
    require_once "../utils/image.php";
    require_once "../utils/user.php";
    require_once "../utils/session.php";
    require_once "../utils/bdd.php";

    if (is_connected() && isset($_FILES['image']) && $_FILES['image']['error'] == 0)
    {
        $infosfichier = pathinfo($_FILES['image']['name']);

        $dest = '';
        $f_name = '';
        do {
            $f_name = uniqid() . "." . EXTENSION_UPLOAD;
            $dest = UPLOAD_DIR . $f_name;
        } while (file_exists($dest));

        $dir = dirname($dest);
        if (!is_dir($dir)) {
            if (!mkdir(UPLOAD_DIR, 0775, true)) {
                error_log("Impossible de créer le dossier de log : $dir");
                return;
            }
        }
        move_uploaded_file($_FILES['image']['tmp_name'], $dest);

        $image = new Image(
            0, // id
            str_replace($_SERVER["DOCUMENT_ROOT"], '', UPLOAD_DIR) . $f_name,
            $_POST['title'],
            $_POST['description'],
            isset($_POST['categories']) ? $_POST['categories'] : null,
            $_POST['tags'],
            $_SESSION['user']->id,
            true, // visibility
            date("Y-m-d H:i:s")
        );

        $connexion = connection_database();
        $image->put_in_bdd($connexion);
        
        header('Location: ../profile.php?username=' . $_SESSION['user']->username);
    }
?>