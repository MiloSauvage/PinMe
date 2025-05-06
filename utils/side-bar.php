<div class="side-bar">
    <?php
        include_once 'utils/session.php';
        include_once 'utils/user.php';
        include_once 'utils/image.php';
    ?>
    <?php if(is_connected()): ?>
        <!-- Section d'informations utilisateur -->
        <div class="user-info">
            <?php $current_user = session_get_user();?>
            <img src="<?= isset($current_user->src_pfp) ? htmlspecialchars($current_user->src_pfp) : './public/images/default-avatar.avif' ?>" alt="Avatar" class="avatar">
            <p class="username"><?= $current_user->username ?></p>
            
            <!-- Statistiques utilisateur -->
            <div class="user-stats">
                <div class="stat-item">
                    <div class="stat-count"><?=count_user_images($current_user->id) ?? 0 ?></div>
                    <div class="stat-label">Images</div>
                </div>
                <div class="stat-item">
                    <div class="stat-count"><?= count_user_likes($current_user->id) ?? 0 ?></div>
                    <div class="stat-label">J'aimes</div>
                </div>
            </div>
        </div>
        
        <!-- Liens rapides pour utilisateur connecté -->
        <div class="quick-links">
            <h3>Actions rapides</h3>
            <ul>
                <li><a href="index.php"><span class="icon">🏠</span> Accueil</a></li>
                <li><a href="create-post.php"><span class="icon">➕</span> Ajouter une image</a></li>
                <li><a href="profile.php?username=<?= $current_user->username ?>"><span class="icon">👤</span> Mon profil</a></li>
                <li><a href="favorites.php"><span class="icon">❤️</span> Mes favoris</a></li>
                <li><a href="search.php"><span class="icon">🔍</span> Rechercher</a></li>
                <li><a href="edit-profile.php?username=<?= $current_user->username?>"><span class="icon">⚙️</span> Paramètres</a></li>
                <li><a href="process/logout.php"><span class="icon">🚪</span> Se déconnecter</a></li>
            </ul>
        </div>
    <?php else: ?>
        <!-- Boutons pour utilisateur non connecté -->
        <div class="cta-buttons">
            <a href="login.php">Se connecter</a>
            <a href="register.php">S'inscrire</a>
        </div>
        
        <!-- Information pour visiteur -->
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