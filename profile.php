<?php
    require_once("./utils/bdd.php");
    require_once("./utils/user.php");
    require_once("./utils/session.php");

    $profile = $_GET["username"] ?? '';

    $query = "SELECT * FROM users WHERE username = :username";
    $connexion = connection_database();
    $stmt = $connexion->prepare($query);
    $stmt->execute([
        "username" => $profile
    ]);
    $user = $stmt->fetch();

    if(!$user){
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
    <title>@<?= htmlspecialchars($user["username"]) ?> | Pin-Me</title>
    <link rel="stylesheet" href="./styles/profile.css">
    <script src="./scripts/modal.js" defer></script>
</head>
<body>

    <div class="profile-header">
        <img src="./images/default-avatar.avif" alt="Photo de profil" class="profile-pic">
        <div class="profile-info">
            <div class="username">@<?= htmlspecialchars($user["username"]) ?></div>
            <div class="name">Nom : <?= htmlspecialchars($user["last_name"] ?? "Dupont") ?> | Prénom : <?= htmlspecialchars($user["first_name"] ?? "Jean") ?></div>
            <div class="bio"><?= !empty($user["bio"]) ? nl2br(htmlspecialchars($user["bio"])) : "Aucune bio pour le moment." ?></div>

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
            require_once("./utils/image.php");
            require_once("./utils/bdd.php");

            $query = "SELECT * FROM images WHERE author_id = :author_id";
            $connexion = connection_database();

            $stmt = $connexion->prepare($query);
            $stmt->execute([
                "author_id" => $user["id"]
            ]);
            $images = $stmt->fetchAll();
            if(count($images) === 0){
                echo '<p style="font-size: 200%;width:100vw;text-align:center;color:#585858;">Ça semble vide ici !</p>';
                disconnect_database($connexion);
                exit;
            }
            foreach ($images as $image) {
                $img = new Image($image["id"], $image["src"], $image["title"], $image["description"], $image["categories"], $image["tags"], $image["author_id"], $image["visibility"], $image["upload_date"]);
                echo $img->toHTML() . "\n\t\t";
            }
            disconnect_database($connexion);
        ?>
    </div>

    <div class="modal" id="modal" role="post">
        <div class="modal-content">
            <div class="modal-close" data-dismiss="post">&times;</div>
            <div class="modal-header">
                <p>Titre de la modal</p>
            </div>
            <div class="modal-body">
                Lorem ipsum, dolor sit amet consectetur adipisicing elit. Laudantium, molestiae? Eos sint inventore ducimus, nobis dignissimos pariatur? Ab temporibus vitae porro harum? Non natus adipisci a, hic maxime quo unde.
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-close" role="button" data-dismiss="post">fermer</a>
                <a href="#" class="btn btn">valider</a>
            </div>
        </div>
    </div>
</body>
</html>
