<?php
    require_once("./utils/bdd.php");
    require_once("./utils/user.php");
    require_once("./utils/session.php");
    require_once("./utils/image.php");
    $profile = $_GET["username"] ?? null;
    if (!$profile) {
        include_once("./utils/no-profile.php");
        exit;
    }
    $user = get_user($profile);
    if ($user === null) {
        include_once("./utils/no-profile.php");
        exit;
    }
    $editable = is_connected() && (session_get_user()->administrator || session_get_user()->username === $profile);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@<?= htmlspecialchars($user->username) ?> | Pin-Me</title>
    <link rel="stylesheet" href="./styles/index.css">
    <link rel="stylesheet" href="./styles/profile.css">
    <link rel="stylesheet" href="./styles/modal.css">
    <script src="./scripts/modal.js" defer></script>
</head>
<body>
    <header>
        <img class="logo-header" src="./public/images/logo/logo.png" alt="Logo">
    </header>

    <div class="page-content">
        <div class="side-bar">
            <?php
                include_once 'utils/session.php';
            ?>
            <?php if(is_connected()): ?>
                <!-- Section d'informations utilisateur -->
                <div class="user-info">
                    <?php $current_user = session_get_user(); ?>
                    <img src="<?= $current_user->src_pfp ?? 'public/images/default-avatar.avif' ?>" alt="Avatar" class="avatar">
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

        <div class="profile-container">
            <div class="profile-header">
                <img
                    src="<?= isset($user->src_pfp) ? htmlspecialchars($user->src_pfp) : '/public/images/default-avatar.avif' ?>"
                    alt="Photo de profil"
                    class="profile-pic"
                >
                <div class="profile-info">
                    <h2 class="username">@<?= htmlspecialchars($user->username) ?></h2>
                    <?php if(isset($user->nom) && $user->nom !== "" || isset($user->prenom) && $user->prenom !== ""): ?>
                        <div class="name">
                            <?= isset($user->prenom) && $user->prenom !== "" ? htmlspecialchars($user->prenom) : "" ?>
                            <?= isset($user->nom) && isset($user->prenom) && $user->prenom !== "" && $user->nom !== ""  ? " " : "" ?>
                            <?= isset($user->nom) && $user->nom !== "" ? htmlspecialchars($user->nom) : "" ?>
                        </div>
                    <?php endif; ?>
                    <div class="bio"><?= $user->bio ?? "Aucune bio pour le moment." ?></div>
                    <?php if ($editable): ?>
                        <div class="profile-actions">
                            <a class="edit-btn" href="edit-profile.php?username=<?= urlencode($profile) ?>">Modifier le profil</a>
                            <a class="create-btn" href="create-post.php">Ajouter une image</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="profile-stats">
                <div class="stat-item">
                    <div class="stat-count"><?=count_user_images($user->id) ?? 0 ?></div>
                    <div class="stat-label">Images</div>
                </div>
                <div class="stat-item">
                    <div class="stat-count"><?= count_user_likes($user->id) ?? 0 ?></div>
                    <div class="stat-label">J'aimes</div>
                </div>
            </div>

            <h2 class="section-title">Images publiées</h2>
            <div class="posts-section">
                <?php
                    $images = get_all_images_from_user_id($user->id);
                    if (empty($images)) {
                        echo '<p class="no-images">Ça semble vide ici !</p>';
                    } else {
                        echo '<div class="recent-images">';
                        foreach ($images as $image) {
                            echo "\t\t\t\t<div class=\"image-item\" role=\"button\" post-id=\"$image->id\" data-target=\"#modal\" data-toggle=\"modal\">\n\t\t\t\t";
                            echo "<img src=\"" . $image->source . "\" alt=\"" . $image->titre . "\">\n\t\t\t\t";
                            echo "<p>" . $image->titre . "</p>\n\t\t\t\t";
                            echo "</div>\n";
                        }
                        echo '</div>';
                    }
                    disconnect_database($connexion);
                ?>
            </div>
        </div>
    </div>

    <div class="modal" id="modal" role="post">
        <div class="modal-content"></div>
    </div>
</body>
</html>