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
        <?php require_once 'utils/session.php'; ?>
        <?php include_once 'utils/side-bar.php'; ?>

        <?php
        /** 
        * Charges des images publics de la bdd et les affiches en html.
        *  @param int $limit la limite d'image voulue.
        *  @param string|null $category catégorie voulue, optionnelle.
        *  @return null.
        */
        function render_images($limit, $category = null) {
            $images = get_public_image($limit, $category);
            if (empty($images)) {
                echo '<p class="no-images">Ça semble vide ici !</p>';
            } else {
                foreach ($images as $image) {
                    echo '<div class="image-item" role="button" post-id="' . $image->id . '" data-target="#modal" data-toggle="modal">';
                    echo '<img src="' . $image->source . '" alt="' . $image->titre . '">';
                    echo '<p>' . $image->titre . '</p>';
                    echo '</div>';
                }
            }
        }
        ?>

        <div class="img-div">
            <h2>Les images les plus récentes</h2>
            <br>
            <div class="recent-images">
                <?php render_images(6); ?>
            </div>
            <br>
            <h2>La catégorie art</h2>
            <br>
            <div class="recent-images">
                <?php render_images(10, "Art"); ?>
            </div>
            <br>
            <h2>La catégorie photographie</h2>
            <br>
            <div class="recent-images">
                <?php render_images(1, "photographie"); ?>
            </div>
            <br>
            <h2>La catégorie voyage</h2>
            <br>
            <div class="recent-images">
                <?php render_images(10, "voyage"); ?>
            </div>
            <br>
            <h2>La catégorie gastronomie</h2>
            <br>
            <div class="recent-images">
                <?php render_images(10, "gastronomie"); ?>
            </div>
            <h2>La catégorie mode</h2>
            <br>
            <div class="recent-images">
                <?php render_images(10, "mode"); ?>
            </div>
            <h2>La catégorie animaux</h2>
            <br>
            <div class="recent-images">
                <?php render_images(10, "animaux"); ?>
            </div>
            <h2>La catégorie design</h2>
            <br>
            <div class="recent-images">
                <?php render_images(10, "design"); ?>
            </div>
            <h2>La catégorie technologie</h2>
            <br>
            <div class="recent-images">
                <?php render_images(10, "technologie"); ?>
            </div>
            <h2>La catégorie histoire</h2>
            <br>
            <div class="recent-images">
                <?php render_images(10, "histoire"); ?>
            </div>
            <h2>La catégorie artistique</h2>
            <br>
            <div class="recent-images">
                <?php render_images(10, "artistique"); ?>
            </div>
        </div>
    </div>
    <div class="modal" id="modal" role="post">
        <div class="modal-content"></div>
    </div>
</body>
</html>
