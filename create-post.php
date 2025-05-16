<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un post - Pin-Me!</title>
    <link rel="stylesheet" href="./styles/create-post.css">
</head>
<body>
    <header>
        <img class="logo-header" src="./public/images/logo/logo.png" alt="Logo Pin-Me!">
    </header>
    <div class="page-content">
        <?php include_once 'utils/side-bar.php';?>
        <div class="form-container">
            <h1 class="form-title">Créer un nouveau post</h1>
            <form action="process/create-post.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="image">Image *</label>
                    <input type="file" id="image" name="image" accept="image/*" required>
                    <p class="required-text">Format recommandé : JPG, PNG ou GIF (max 5 Mo)</p>
                </div>
                <div class="preview-section">
                    <h3 class="preview-title">Aperçu de l'image</h3>
                    <div class="image-preview">
                        <p class="image-preview-text">L'aperçu de votre image apparaîtra ici</p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="title">Titre *</label>
                    <input type="text" id="title" name="title" placeholder="Donnez un titre à votre post" required>
                </div>
                <div class="form-group">
                    <label for="description">Description (facultative)</label>
                    <textarea id="description" name="description" rows="4" placeholder="Décrivez votre post..."></textarea>
                </div>
                <div class="form-group">
                    <label for="tags">Tags (facultatif, séparés par des virgules)</label>
                    <input type="text" id="tags" name="tags" placeholder="nature, voyage, photographie...">
                </div>
                <div class="form-group">
                    <label for="categories">Catégories (facultatif)</label>
                    <select id="categories" name="categories[]" multiple>
                        <option value="art">Art</option>
                        <option value="photographie">Photographie</option>
                        <option value="voyage">Voyage</option>
                        <option value="gastronomie">Gastronomie</option>
                        <option value="mode">Mode</option>
                        <option value="animaux">Animaux</option>
                        <option value="design">Design</option>
                        <option value="technologie">Technologie</option>
                        <option value="histoire">Histoire</option>
                        <option value="artistique">Artistique</option>
                    </select>
                    <p class="required-text">Maintenez Ctrl (ou Cmd) pour sélectionner plusieurs catégories</p>
                </div>
                <div class="form-group">
                    <label>Visibilité</label>
                    <div class="visibility-options">
                        <div class="visibility-option selected" id="opt-public">
                            <i>🌎</i>
                            <h4>Public</h4>
                            <p>Visible par tous</p>
                            <input type="radio" name="visibility" value="public" checked style="display: none;">
                        </div>
                        <div class="visibility-option" id="opt-private">
                            <i>🔒</i>
                            <h4>Privé</h4>
                            <p>Visible par vous uniquement</p>
                            <input type="radio" name="visibility" value="private" style="display: none;">
                        </div>
                    </div>
                </div>
                <button type="submit" class="submit-button">Publier</button>
            </form>
        </div>
    </div>
    <script>
        document.getElementById('image').addEventListener('change', function(e) {
            const preview = document.querySelector('.image-preview');
            preview.innerHTML = '';
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    const img = document.createElement('img');
                    img.src = event.target.result;
                    preview.appendChild(img);
                }
                reader.readAsDataURL(file);
            } else {
                preview.innerHTML = '<p class="image-preview-text">L\'aperçu de votre image apparaîtra ici</p>';
            }
        });
        document.getElementById('opt-public').addEventListener('click', function() {
            document.getElementById('opt-public').classList.add('selected');
            document.getElementById('opt-private').classList.remove('selected');
            document.querySelector('input[value="public"]').checked = true;
        });
        document.getElementById('opt-private').addEventListener('click', function() {
            document.getElementById('opt-private').classList.add('selected');
            document.getElementById('opt-public').classList.remove('selected');
            document.querySelector('input[value="private"]').checked = true;
        });
    </script>
</body>
</html>
