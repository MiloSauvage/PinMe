<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pin-me !</title>
    <link rel="stylesheet" href="./styles/index.css">
    <link rel="stylesheet" href="./styles/modal.css">

    <script src="./scripts/modal.js" defer></script>
</head>

<body>
    <header>
        <img class="logo-header" src="./public/images/logo/logo.png" alt="Logo">
    </header>

    <div class="page-content">
    <?php include_once 'utils/side-bar.php';?>

    <div class="img-div">
        <h2>Les images les plus récentes :</h2>
        <br>
        <div class="recent-images ">
            <?php
                $images = get_public_image(6, null);
                if (empty($images)) {
                    echo '<p class="no-images">Ça semble vide ici !</p>';
                } else {
                    foreach ($images as $image) {
                        echo "\t\t\t\t<div class=\"image-item\" role=\"button\" post-id=\"$image->id\" data-target=\"#modal\" data-toggle=\"modal\">\n\t\t\t\t";
                        echo "<img src=\"" . $image->source . "\" alt=\"" . $image->titre . "\">\n\t\t\t\t";
                        echo "<p>" . $image->titre . "</p>\n\t\t\t\t";
                        echo "</div>\n";
                    }
                }
            ?>
        </div>

        <br>
        <h2>Catégorie - Artistique :</h2>
        <br>
        <div class="recent-images ">
            <?php
                $images = get_public_image(10, "Artistique");
                if (empty($images)) {
                    echo '<p class="no-images">Ça semble vide ici !</p>';
                } else {
                    foreach ($images as $image) {
                        echo "\t\t\t\t<div class=\"image-item\" role=\"button\" post-id=\"$image->id\" data-target=\"#modal\" data-toggle=\"modal\">\n\t\t\t\t";
                        echo "<img src=\"" . $image->source . "\" alt=\"" . $image->titre . "\">\n\t\t\t\t";
                        echo "<p>" . $image->titre . "</p>\n\t\t\t\t";
                        echo "</div>\n";
                    }
                }
            ?>
        </div>

        <br>
        <h2>Catégorie - Histroire :</h2>
        <br>
        <div class="recent-images ">
            <?php
                $images = get_public_image(1, "Histoire");
                if (empty($images)) {
                    echo '<p class="no-images">Ça semble vide ici !</p>';
                } else {
                    foreach ($images as $image) {
                        echo "\t\t\t\t<div class=\"image-item\" role=\"button\" post-id=\"$image->id\" data-target=\"#modal\" data-toggle=\"modal\">\n\t\t\t\t";
                        echo "<img src=\"" . $image->source . "\" alt=\"" . $image->titre . "\">\n\t\t\t\t";
                        echo "<p>" . $image->titre . "</p>\n\t\t\t\t";
                        echo "</div>\n";
                    }
                }
            ?>
        </div>

        <br>
        <h2>Catégorie - Artistique :</h2>
        <br>
        <div class="recent-images ">
            <?php
                $images = get_public_image(10, null);
                if (empty($images)) {
                    echo '<p class="no-images">Ça semble vide ici !</p>';
                } else {
                    foreach ($images as $image) {
                        echo "\t\t\t\t<div class=\"image-item\" role=\"button\" post-id=\"$image->id\" data-target=\"#modal\" data-toggle=\"modal\">\n\t\t\t\t";
                        echo "<img src=\"" . $image->source . "\" alt=\"" . $image->titre . "\">\n\t\t\t\t";
                        echo "<p>" . $image->titre . "</p>\n\t\t\t\t";
                        echo "</div>\n";
                    }
                }
            ?>
        </div>

        <br>
        <h2>Catégorie - Artistique :</h2>
        <br>
        <div class="recent-images ">
            <?php
                $images = get_public_image(10, null);
                if (empty($images)) {
                    echo '<p class="no-images">Ça semble vide ici !</p>';
                } else {
                    foreach ($images as $image) {
                        echo "\t\t\t\t<div class=\"image-item\" role=\"button\" post-id=\"$image->id\" data-target=\"#modal\" data-toggle=\"modal\">\n\t\t\t\t";
                        echo "<img src=\"" . $image->source . "\" alt=\"" . $image->titre . "\">\n\t\t\t\t";
                        echo "<p>" . $image->titre . "</p>\n\t\t\t\t";
                        echo "</div>\n";
                    }
                }
            ?>
        </div>
    </div>

    <div class="modal" id="modal" role="post">
        <div class="modal-content"></div>
    </div>
</body>
</html>
