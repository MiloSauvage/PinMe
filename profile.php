<?php
    require_once("./utils/bdd.php");
    require_once("./utils/user.php");
    require_once("./utils/session.php");
    require_once("./utils/image.php");

    $profile = $_GET["username"];

    $user = get_user($profile);

    if($user === null){
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
    <link rel="stylesheet" href="./styles/profile.css">
    <script src="./scripts/modal.js" defer></script>
    <script src="jquery-3.7.1.min.js"></script>
</head>
<body>

    <div class="profile-header">
        <img src=<?php if(isset($user->src_pfp)) {
                echo "./images/pfp/" . htmlspecialchars($user->src_pfp);
            } else {
                echo "./images/default-avatar.avif";
            }
            ?> alt="Photo de profil" class="profile-pic">
        <div class="profile-info">
            <div class="username">@<?= htmlspecialchars($user->username) ?></div>
            <div class="name"><?php 
                if (isset($user->last_name)) {
                    echo "Nom : " . htmlspecialchars($user->last_name);
                }
                if(isset($user->last_name) && isset($user->first_name)){
                    echo " | ";
                }
                if (isset($user->first_name)) {
                    echo "Prénom : " . htmlspecialchars($user->first_name);
                }
            ?></div>
            <div class="bio"><?= !empty($user->bio) ? nl2br(htmlspecialchars($user->bio)) : "Aucune bio pour le moment." ?></div>

            <?php if ($editable): ?>
            <div class="actions">
                <a class="btn" href="edit-profile.php?username=<?= urlencode($profile) ?>">Modifier le profil</a>
                <a class="btn btn-primary" href="create-post.php">+ Créer un post</a>
            </div>
            <?php endif; ?>
        </div>

        <div class="nav-links">
            <a class="btn" href="./index.php">🏠 Accueil</a>
            <a class="btn" href="./process/logout.php">🚪 Déconnexion</a>
        </div>
    </div>

    <div class="posts-section">
        <?php
            $images = get_all_images_from_user_id($user->id);

            if($images === null || count($images) === 0){
                echo '<p style="font-size: 200%;width:100vw;text-align:center;color:#585858;">Ça semble vide ici !</p>';
                disconnect_database($connexion);
                exit;
            }
            foreach ($images as $image) {
                echo $image->toHTML() . "\n\t\t";
            }
            disconnect_database($connexion);
        ?>
    </div>

    <div class="modal" id="modal" role="post">
        <div class="modal-content">
        </div>
    </div>
</body>
</html>
