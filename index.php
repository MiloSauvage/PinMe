<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pin-me !</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7f6;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #4A90E2;
            color: white;
            padding: 40px 20px;
            text-align: center;
        }

        h1 {
            font-size: 36px;
            margin-bottom: 10px;
        }

        p {
            font-size: 18px;
            margin: 10px 0;
        }

        .cta-buttons a {
            display: inline-block;
            padding: 12px 25px;
            background-color: #fff;
            color: #4A90E2;
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px;
            margin: 10px;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .cta-buttons a:hover {
            background-color: #357ABD;
            color: white;
        }

        .recent-images {
            padding: 40px 20px;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 15px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .image-item {
            background-color: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .image-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .image-item p {
            padding: 10px;
            background-color: #f1f1f1;
            font-size: 16px;
            color: #333;
        }
    </style>
</head>
<body>

<header>
    <h1>Pin-me !</h1>
    <p>Pin-me est une application web simple vous permettant de créer et gérer vos propres épingles.</p>
    <p>Pour commencer, connectez-vous ou inscrivez-vous.</p>
    <div class="cta-buttons">
        <?php
            require_once('./utils/user.php');
            require_once('./utils/session.php');
            /* Les variables de session contiennent :
             *          - user_id : id de l'utilisateur courant
             *          - token : token de l'utilisateur courant
             */
            if(!is_connected()) {
                echo '<a href="login.php">Se connecter</a>';
                echo '<a href="register.php">S\'inscrire</a>';
            } else {
                echo '<a href="process/logout.php">Se déconnecter</a>';
                echo '<a href="profile.php?username=' . session_get_user()->username . '">Mon profil</a>';
            }
        ?>
    </div>
    <p>Les images les plus récentes :</p>
</header>

<div class="recent-images">
    <div class="image-item">
        <img src="https://picsum.photos/400?random=1" alt="Image 1">
        <p>Image récente 1</p>
    </div>
    <div class="image-item">
        <img src="https://picsum.photos/400?random=2" alt="Image 2">
        <p>Image récente 2</p>
    </div>
    <div class="image-item">
        <img src="https://picsum.photos/400?random=3" alt="Image 3">
        <p>Image récente 3</p>
    </div>
    <div class="image-item">
        <img src="https://picsum.photos/400?random=4" alt="Image 4">
        <p>Image récente 4</p>
    </div>
    <div class="image-item">
        <img src="https://picsum.photos/400?random=5" alt="Image 5">
        <p>Image récente 5</p>
    </div>
</div>

</body>
</html>
