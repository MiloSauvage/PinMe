<?php
    require_once "../utils/variables.php";

    global $upload_dir, $extension_upload;

    if (isset($_FILES['image']) AND $_FILES['image']['error'] == 0)
    {
        $infosfichier = pathinfo($_FILES['image']['name']);

        $dest = '';
        do {
            $dest = $upload_dir . uniqid() . '.' . $extension_upload;
        } while (file_exists($dest));

        move_uploaded_file($_FILES['image']['tmp_name'], $dest);

        
    }
?>