<?php
require_once 'utils/session.php';
if (!is_connected()) {
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pin-me ! Créer une Annotation</title>
    <link rel="stylesheet" href="./styles/index.css">
    <link rel="stylesheet" href="./styles/create-annotation.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="./scripts/create-annotation.js" defer></script>
</head>
<body>
    <header>
        <img class="logo-header" src="./public/images/logo/logo.png" alt="Logo">
    </header>
    <div class="page-content">
        <?php include_once 'utils/side-bar.php'; ?>
        <div class="annotation-container">
            <h2>Créer une Annotation</h2>
            <?php
            require_once 'utils/image.php';
            $id = $_GET['id'] ?? null;
            if ($id === null) {
                exit('ID de l\'image non spécifié.');
            }
            $image = get_image_from_id($id);
            if ($image === null) {
                exit('Id incorrect.');
            }
            ?>
            <div class="annotation-workspace">
                <div class="image-container">
                    <div class="image-wrapper" style="position: relative;">
                        <img id="annotationImage" draggable="false" class="image" img-id="<?= $id ?>" src="<?= $image->source ?>" alt="<?= $image->titre ?>">
                        <div id="selectionBox" class="selection-box"></div>
                        <div id="existingAnnotations"></div>
                    </div>
                </div>
                <div class="annotation-form">
                    <div class="form-group">
                        <label for="annotationTitle">Titre de l'annotation</label>
                        <input type="text" id="annotationTitle" placeholder="Ex: Chapeau de Louis XIV">
                    </div>
                    <div class="form-group">
                        <label>Couleur de l'annotation</label>
                        <div class="color-selector">
                            <div class="color-option" data-color="#FF7E5F"></div>
                            <div class="color-option" data-color="#FEB47B"></div>
                            <div class="color-option" data-color="#4BC0C0"></div>
                            <div class="color-option" data-color="#9966FF"></div>
                            <div class="color-option" data-color="#36A2EB"></div>
                            <div class="color-option" data-color="#FFCE56"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Coordonnées de sélection</label>
                        <div class="coordinates">
                            <div>
                                <span>X:</span>
                                <span id="selectionX">0</span>
                            </div>
                            <div>
                                <span>Y:</span>
                                <span id="selectionY">0</span>
                            </div>
                            <div>
                                <span>Largeur:</span>
                                <span id="selectionWidth">0</span>
                            </div>
                            <div>
                                <span>Hauteur:</span>
                                <span id="selectionHeight">0</span>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button id="saveAnnotation" class="btn btn-primary">Sauvegarder l'annotation</button>
                        <button id="resetSelection" class="btn btn-secondary">Réinitialiser la sélection</button>
                    </div>
                    <div class="annotation-guide">
                        <h3>Comment annoter une image</h3>
                        <ol>
                            <li>Cliquez et glissez sur l'image pour sélectionner une zone</li>
                            <li>Remplissez le titre et la description</li>
                            <li>Choisissez une couleur pour l'annotation</li>
                            <li>Cliquez sur "Sauvegarder l'annotation"</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
