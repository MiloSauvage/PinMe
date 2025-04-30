<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un post - Pin-Me!</title>
    <style>
        /* Reset de base */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Style général */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f9f9f9;
            color: #333;
            line-height: 1.6;
            padding: 20px;
        }

        .logo-header {
            width: 200px;
            display: block;
            margin: 0 auto;
        }

        /* Header */
        header {
            text-align: center;
            padding: 40px 20px 20px 20px;
            background: linear-gradient(135deg, #ff7e5f, #feb47b);
            color: white;
            border-radius: 10px;
            margin-bottom: 40px;
        }

        .page-title {
            font-size: 2.5rem;
            margin-bottom: 10px;
            text-align: center;
            color: #ff7e5f;
        }

        /* Page Content */
        .page-content {
            display: flex;
            gap: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }

        /* Side Bar */
        .side-bar {
            flex: 1;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            min-width: 200px;
            max-width: 280px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 20px;
            height: max-content;
            max-height: calc(100vh - 40px);
            overflow-y: auto;
        }

        .side-bar h2 {
            font-size: 1.5rem;
            margin-bottom: 20px;
        }

        /* Liens rapides */
        .quick-links {
            margin-top: 20px;
        }

        .quick-links h3 {
            font-size: 1.1rem;
            margin-bottom: 10px;
            color: #444;
        }

        .quick-links ul {
            list-style: none;
        }

        .quick-links li {
            margin-bottom: 8px;
        }

        .quick-links a {
            text-decoration: none;
            color: #555;
            display: flex;
            align-items: center;
            padding: 5px 0;
            transition: color 0.2s ease;
        }

        .quick-links a:hover {
            color: #ff7e5f;
        }

        .quick-links .icon {
            margin-right: 8px;
            color: #ff7e5f;
            font-size: 0.9rem;
        }

        /* Formulaire de création */
        .form-container {
            flex: 3;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .form-title {
            color: #444;
            margin-bottom: 30px;
            text-align: center;
            font-size: 1.8rem;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #555;
        }

        .form-group input[type="text"],
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-family: inherit;
            font-size: 1rem;
            transition: border 0.3s ease;
        }

        .form-group input[type="text"]:focus,
        .form-group textarea:focus,
        .form-group select:focus {
            border-color: #ff7e5f;
            outline: none;
        }

        .form-group input[type="file"] {
            background: #f5f5f5;
            padding: 15px;
            border-radius: 6px;
            border: 2px dashed #ddd;
            cursor: pointer;
            width: 100%;
        }

        .form-group input[type="file"]:hover {
            border-color: #ff7e5f;
        }

        .form-group textarea {
            resize: vertical;
            min-height: 120px;
        }

        .form-group select[multiple] {
            height: 150px;
        }

        .visibility-options {
            display: flex;
            gap: 15px;
        }

        .visibility-option {
            flex: 1;
            border: 2px solid #ddd;
            border-radius: 6px;
            padding: 15px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .visibility-option:hover {
            border-color: #ff7e5f;
        }

        .visibility-option.selected {
            border-color: #ff7e5f;
            background-color: rgba(255, 126, 95, 0.1);
        }

        .visibility-option i {
            font-size: 1.8rem;
            color: #ff7e5f;
            margin-bottom: 10px;
            display: block;
        }

        .submit-button {
            background: linear-gradient(135deg, #ff7e5f, #feb47b);
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 30px;
            font-size: 1.1rem;
            font-weight: bold;
            cursor: pointer;
            display: block;
            margin: 40px auto 0;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            box-shadow: 0 4px 10px rgba(255, 126, 95, 0.3);
        }

        .submit-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(255, 126, 95, 0.4);
        }

        .submit-button:active {
            transform: translateY(0);
            box-shadow: 0 2px 6px rgba(255, 126, 95, 0.4);
        }

        .preview-section {
            margin-top: 30px;
            text-align: center;
        }

        .preview-title {
            font-size: 1.3rem;
            color: #444;
            margin-bottom: 15px;
        }

        .image-preview {
            max-width: 100%;
            height: 300px;
            background: #f5f5f5;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            border: 2px dashed #ddd;
        }

        .image-preview img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }

        .image-preview-text {
            color: #777;
            font-size: 1.1rem;
        }

        .required-text {
            color: #ff7e5f;
            font-size: 0.9rem;
            margin-top: 5px;
        }

        /* Tags Input Style */
        .tags-input-container {
            border: 1px solid #ddd;
            padding: 5px;
            border-radius: 6px;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
        }

        .tag-item {
            background-color: #ff7e5f;
            color: white;
            padding: 5px 10px;
            border-radius: 20px;
            margin: 5px;
            display: inline-flex;
            align-items: center;
        }

        .tag-item .close {
            margin-left: 5px;
            cursor: pointer;
            font-weight: bold;
        }

        .tags-input {
            flex: 1;
            border: none;
            padding: 10px;
            outline: none;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .page-content {
                flex-direction: column;
            }
            
            .side-bar {
                max-width: 100%;
                position: static;
            }
        }
    </style>
</head>

<body>
    <header>
        <img class="logo-header" src="./public/images/logo/logo.png" alt="Logo Pin-Me!">
    </header>

    <div class="page-content">
        <div class="side-bar">
            <h2>Menu</h2>
            <div class="quick-links">
                <h3>Actions rapides</h3>
                <ul>
                    <li><a href="index.php"><span class="icon">🏠</span> Accueil</a></li>
                    <li><a href="profile.php"><span class="icon">👤</span> Mon profil</a></li>
                    <li><a href="favorites.php"><span class="icon">❤️</span> Mes favoris</a></li>
                    <li><a href="settings.php"><span class="icon">⚙️</span> Paramètres</a></li>
                    <li><a href="gallery.php"><span class="icon">🖼️</span> Galerie publique</a></li>
                    <li><a href="process/logout.php"><span class="icon">🚪</span> Se déconnecter</a></li>
                </ul>
            </div>
        </div>

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
        // Image preview
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

        // Visibility options
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