<?php
require_once "../utils/variables.php";
require_once "../utils/image.php";
require_once "../utils/user.php";
require_once "../utils/session.php";
require_once "../utils/bdd.php";

if (is_connected() && isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
    $infosfichier = pathinfo($_FILES['image']['name']);

    do {
        $f_name = uniqid() . "." . EXTENSION_UPLOAD;
        $dest = UPLOAD_DIR . $f_name;
    } while (file_exists($dest));

    $dir = dirname($dest);
    if (!is_dir($dir)) {
        if (!mkdir(UPLOAD_DIR, 0775, true)) {
            error_log("Impossible de créer le dossier d'image : $dir");
            return;
        }
    }
    move_uploaded_file($_FILES['image']['tmp_name'], $dest);

    $visibility = true;
    if (isset($_POST['visibility'])) {
        $visibility = filter_var($_POST['visibility'], FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
        if (is_null($visibility)) {
            $visibility = true;
        }
    }

    $image = new Image(
        0,
        str_replace(PROJECT_ROOT, '', UPLOAD_DIR) . $f_name,
        isset($_POST['title']) ? $_POST['title'] : '',
        session_get_user()->id,
        date("Y-m-d H:i:s"),
        isset($_POST['description']) ? $_POST['description'] : '',
        isset($_POST['categories'][0]) ? $_POST['categories'][0] : '',
        isset($_POST['tags']) ? $_POST['tags'] : '',
        $visibility,
        0
    );

    $image->put_in_bdd();

    header('Location: ../profile.php?username=' . session_get_user()->username);
}
?>
