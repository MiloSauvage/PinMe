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
        <?php include_once 'utils/side-bar.php';?>

        <div class="profile-container">
            <div class="profile-header">
                <img
                    src="<?= isset($user->src_pfp) ? htmlspecialchars($user->src_pfp) : './public/images/default-avatar.avif' ?>"
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