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
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #fafafa;
        }

        .profile-header {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            padding: 30px 20px;
            background-color: white;
            border-bottom: 1px solid #ddd;
            position: relative;
        }

        .profile-pic {
            width: 140px;
            height: 140px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #4A90E2;
            margin-right: 30px;
        }

        .profile-info {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .username {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .name {
            font-size: 18px;
            color: #555;
            margin-bottom: 5px;
        }

        .bio {
            font-size: 16px;
            color: #777;
            margin-top: 10px;
        }

        .actions {
            display: flex;
            gap: 10px;
            margin-top: 20px;
            flex-wrap: wrap;
        }

        .btn {
            padding: 10px 15px;
            background-color: #4A90E2;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 14px;
            cursor: pointer;
            text-decoration: none;
            transition: 0.3s ease;
        }

        .btn:hover {
            background-color: #357ABD;
        }

        .btn-primary {
            background-color: #e91e63;
            font-weight: bold;
            font-size: 16px;
        }

        .btn-primary:hover {
            background-color: #c2185b;
        }

        .nav-links {
            position: absolute;
            top: 15px;
            right: 20px;
            display: flex;
            gap: 10px;
        }

        .posts-section {
            padding: 30px 20px;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 15px;
        }

        .post {
            background-color: #eee;
            aspect-ratio: 1 / 1;
            border-radius: 10px;
            overflow: hidden;
        }

        .post img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        @media (max-width: 600px) {
            .profile-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .actions {
                flex-direction: column;
                width: 100%;
            }

            .btn {
                width: 100%;
                text-align: center;
            }

            .nav-links {
                position: static;
                margin-top: 15px;
                width: 100%;
                justify-content: flex-start;
            }
        }
    </style>
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
        <div class="post"><img src="https://picsum.photos/400?random=1" alt="Post 1"></div>
        <div class="post"><img src="https://picsum.photos/400?random=2" alt="Post 2"></div>
        <div class="post"><img src="https://picsum.photos/400?random=3" alt="Post 3"></div>
        <div class="post"><img src="https://picsum.photos/400?random=4" alt="Post 4"></div>
        <div class="post"><img src="https://picsum.photos/400?random=5" alt="Post 5"></div>
    </div>

</body>
</html>
