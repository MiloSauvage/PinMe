<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un post - Pin-Me</title>
    <link rel="stylesheet" href="./styles/create-post.css">
</head>
<body>
    <div class="container">
        <h1>Créer un nouveau post</h1>
        <form action="process/create-post.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="image">Image *</label>
                <input type="file" id="image" name="image" accept="image/*" required>
            </div>

            <div class="form-group">
                <label for="title">Titre *</label>
                <input type="text" id="title" name="title" required>
            </div>

            <div class="form-group">
                <label for="description">Description (facultative)</label>
                <textarea id="description" name="description" rows="4"></textarea>
            </div>

            <div class="form-group">
                <label for="tags">Tags (facultatif, séparés par des virgules)</label>
                <input type="text" id="tags" name="tags">
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
                </select>
            </div>

            <div class="form-group">
                <label for="visibility">Visibilité</label>
                <select id="visibility" name="visibility">
                    <option value="public" selected>Publique</option>
                    <option value="private">Privée</option>
                </select>
            </div>

            <button type="submit">Publier</button>
        </form>
    </div>
</body>
</html>
