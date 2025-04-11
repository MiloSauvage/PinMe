<?php
    require_once "../utils/variables.php";
    require_once "../utils/image.php";
    require_once "../utils/user.php";
    require_once "../utils/session.php";
    require_once "../utils/bdd.php";

    global $upload_dir, $extension_upload;

    if (is_connected() && isset($_FILES['image']) AND $_FILES['image']['error'] == 0)
    {
        $infosfichier = pathinfo($_FILES['image']['name']);

        $dest = '';
        $f_name = '';
        do {
            $f_name = uniqid() . "." . $extension_upload;
            $dest = __DIR__ . "/.." . $upload_dir . $f_name;
        } while (file_exists($dest));

        move_uploaded_file($_FILES['image']['tmp_name'], $dest);

        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
        $domain = $_SERVER['HTTP_HOST'];

        // le "pinme" à supprimer
        $adresse = $protocol . $domain . "/pinme/" . $upload_dir . $f_name;

        $image = new Image(0, $adresse, $_POST['title'], $_POST['description'], isset($_POST['categories'])? $_POST['categories'] : null, $_POST['tags'], $_SESSION['user']->id, true, date("Y-m-d H:i:s"));

        $connexion = connection_database();
        $image->put_in_bdd($connexion);

        header('Location: ../profile.php?username=' . $_SESSION['user']->username);
    }
?>