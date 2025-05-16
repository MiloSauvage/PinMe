<?php
require_once "./utils/session.php";
require_once "./utils/user.php";
if (session_get_user()->username !== $_GET["username"]) {
    header("Location: ./index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editing @<?php echo session_get_user()->username ?></title>
    <link rel="stylesheet" href="./styles/index.css">
    <link rel="stylesheet" href="./styles/edit-profile.css">
</head>
<body>
    <header>
        <img class="logo-header" src="./public/images/logo/logo.png" alt="Logo">
    </header>
    <div class="page-content">
        <?php include_once 'utils/side-bar.php'; ?>
        <div class="form-container">
            <h2>Modifier votre profil</h2>
            <form action="process/edit-profile.php?username=<?php echo session_get_user()->username ?>" method="POST" enctype="multipart/form-data">
                <fieldset>
                    <div class="form-group">
                        <label for="username">Nom d'utilisateur:</label>
                        <input type="text" id="username" name="username" placeholder="Nom d'utilisateur" value="<?php echo session_get_user()->username ?>">
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" placeholder="exemple@test.com" value="<?php echo session_get_user()->email ?>">
                    </div>
                    <div class="form-group">
                        <label for="password">Mot de passe:</label>
                        <input type="password" id="password" name="password" placeholder="Nouveau mot de passe">
                    </div>
                    <div class="form-group">
                        <label for="profile_photo">Photo de profil:</label>
                        <input type="file" id="profile_photo" name="profile_photo" accept="image/*">
                    </div>
                    <div class="form-group">
                        <label for="first_name">Prénom:</label>
                        <input type="text" id="first_name" name="first_name" placeholder="Prénom" value="<?php echo session_get_user()->prenom ?>">
                    </div>
                    <div class="form-group">
                        <label for="last_name">Nom:</label>
                        <input type="text" id="last_name" name="last_name" placeholder="Nom" value="<?php echo session_get_user()->nom ?>">
                    </div>
                    <div class="form-group">
                        <label for="bio">Biographie:</label>
                        <textarea id="bio" name="bio" rows="4" placeholder="Votre biographie"><?php echo session_get_user()->bio ?></textarea>
                    </div>
                </fieldset>
                <div class="form-actions">
                    <button type="submit">Mettre à jour le profil</button>
                    <a href="profile.php?username=<?php echo session_get_user()->username ?>" class="cancel-button">Annuler</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
