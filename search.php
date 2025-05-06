<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recherche - Pin-me !</title>
    <link rel="stylesheet" href="./styles/index.css">
    <link rel="stylesheet" href="./styles/search.css">
</head>
<body>
    <header>
        <img class="logo-header" src="./public/images/logo/logo.png" alt="Logo">
    </header>

    <div class="page-content">
        <?php include_once 'utils/side-bar.php';?>

        <!-- Contenu principal avec le formulaire de recherche -->
        <div class="main-content">
            <div class="search-section">
                <h1>Rechercher des images</h1>
                
                <form action="result.php" method="get" class="search-form">
                    <div class="search-input-container">
                        <input type="text" 
                               name="q" 
                               placeholder="Titre, description, tags..." 
                               class="search-input"
                               required>
                        <button type="submit" class="search-button">
                            <span class="search-icon">🔍</span>
                        </button>
                    </div>
                    
                    <div class="search-options">
                        <div class="option-group">
                            <label for="category">Catégorie</label>
                            <select name="category" id="category" class="option-select">
                                <option value="">Toutes</option>
                                <option value="Artistique">Artistique</option>
                                <option value="Photographie">Photographie</option>
                                <option value="Voyage">Voyage</option>
                                <option value="Histoire">Histoire</option>
                            </select>
                        </div>
                        
                        <div class="option-group">
                            <label for="sort">Trier par</label>
                            <select name="sort" id="sort" class="option-select">
                                <option value="recent">Plus récent</option>
                                <option value="popular">Plus populaire</option>
                                <option value="oldest">Plus ancien</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>