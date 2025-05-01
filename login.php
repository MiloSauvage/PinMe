<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Connexion - Pin-Me !</title>
    <link rel="stylesheet" href="/styles/login.css">
    <link rel="stylesheet" href="/styles/error-message.css">

</head>
<body>
    <header>
        <img class="logo-header" src="./public/images/logo/logo.png" alt="Logo Pin-Me!">
    </header>
   
    <div class="page-content">
        <div class="login-container">
            <h1 class="form-title">Connexion</h1>
            
            <?php 
                // Afficher le message d'erreur avant le formulaire
                if(isset($_GET["err"]) && $_GET["err"] == 1) {
                    echo "<div class=\"error-message\">\n<p>Erreur : Identifiants ou mot de passe incorrect.</p>\n</div>";
                }
            ?>

            <form action="process/login.php" method="post" autocomplete="off">
                <div class="form-group">
                    <label for="email">Adresse e-mail</label>
                    <input type="email" id="email" name="email" required aria-required="true" placeholder="exemple@mail.com">
                </div>
                
                <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <input type="password" id="password" name="password" required aria-required="true" placeholder="Votre mot de passe">
                </div>
                
                <div class="form-options">
                    <a href="forgot-password.php" class="forgot-password">Mot de passe oublié ?</a>
                </div>
                
                <button type="submit" class="submit-button">Se connecter</button>
            </form>
            
            <div class="register-link">
                <p>Pas encore de compte ? <a href="register.php">S'inscrire</a></p>
            </div>
        </div>
    </div>
</body>
</html>