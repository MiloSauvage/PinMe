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
        <!-- Sidebar identique à l'index -->
        <div class="side-bar">
            <?php include_once 'utils/session.php'; ?>
            <?php if(is_connected()): ?>
                <div class="user-info">
                    <?php $user = session_get_user(); ?>
                    <img src="<?= $user->src_pfp ?? 'public/images/default-avatar.avif' ?>" alt="Avatar" class="avatar">
                    <p class="username"><?= $user->username ?></p>
                    
                    <div class="user-stats">
                        <div class="stat-item">
                            <div class="stat-count"><?=count_user_images($user->id) ?? 0 ?></div>
                            <div class="stat-label">Images</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-count"><?= count_user_likes($user->id) ?? 0 ?></div>
                            <div class="stat-label">J'aimes</div>
                        </div>
                    </div>
                </div>
                
                <div class="quick-links">
                    <h3>Actions rapides</h3>
                    <ul>
                        <li><a href="create-post.php"><span class="icon">➕</span> Ajouter une image</a></li>
                        <li><a href="profile.php?username=<?= $user->username ?>"><span class="icon">👤</span> Mon profil</a></li>
                        <li><a href="favorites.php"><span class="icon">❤️</span> Mes favoris</a></li>
                        <li><a href="search.php" class="active"><span class="icon">🔍</span> Rechercher</a></li>
                        <li><a href="edit-profile.php?username=<?= $user->username?>"><span class="icon">⚙️</span> Paramètres</a></li>
                        <li><a href="process/logout.php"><span class="icon">🚪</span> Se déconnecter</a></li>
                    </ul>
                </div>
            <?php else: ?>
                <div class="cta-buttons">
                    <a href="login.php">Se connecter</a>
                    <a href="register.php">S'inscrire</a>
                </div>
                
                <div class="quick-links">
                    <h3>Explorer</h3>
                    <ul>
                        <li><a href="gallery.php"><span class="icon">🖼️</span> Galerie publique</a></li>
                        <li><a href="categories.php"><span class="icon">📂</span> Catégories</a></li>
                        <li><a href="about.php"><span class="icon">ℹ️</span> À propos</a></li>
                    </ul>
                </div>
            <?php endif; ?>
        </div>

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