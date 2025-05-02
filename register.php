<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Inscription - Pin-Me !</title>
    <link rel="stylesheet" href="./styles/register.css">
    <link rel="stylesheet" href="./styles/error-messages.css">
</head>
<body>
    <header>
        <img class="logo-header" src="./public/images/logo/logo.png" alt="Logo Pin-Me!">
    </header>
   
    <div class="page-content">
        <div class="register-container">
            <h1 class="form-title">Inscription</h1>
           
            <?php
            // Afficher le message d'erreur avant le formulaire
            if(isset($_GET["err"])) {
                $error_message = "";
               
                switch($_GET["err"]) {
                    case "1":
                        $error_message = "Les mots de passe ne correspondent pas.";
                        break;
                    case "2":
                        $error_message = "Cette adresse e-mail est déjà utilisée.";
                        break;
                    case "3":
                        $error_message = "Ce nom d'utilisateur est déjà pris.";
                        break;
                    case "4":
                        $error_message = "Le mot de passe doit contenir au moins 8 caractères.";
                        break;
                    default:
                        $error_message = "Une erreur est survenue lors de l'inscription.";
                }
               
                echo "<div class=\"error-message\">\n<p>Erreur : $error_message</p>\n</div>";
            }
            ?>
           
            <form action="process/registration.php" method="post" autocomplete="off">
                <div class="form-group">
                    <label for="username">Nom d'utilisateur</label>
                    <input type="text" id="username" name="username" required aria-required="true" placeholder="Votre nom d'utilisateur">
                </div>
               
                <div class="form-group">
                    <label for="email">Adresse e-mail</label>
                    <input type="email" id="email" name="email" required aria-required="true" placeholder="exemple@mail.com">
                </div>
               
                <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <input type="password" id="password" name="password" required aria-required="true" placeholder="Votre mot de passe">
                </div>
               
                <div class="form-group">
                    <label for="repassword">Confirmer le mot de passe</label>
                    <input type="password" id="repassword" name="repassword" required aria-required="true" placeholder="Retapez votre mot de passe">
                </div>
               
                <button type="submit" class="submit-button">S'inscrire</button>
            </form>
           
            <div class="login-link">
                <p>Déjà un compte ? <a href="login.php">Se connecter</a></p>
            </div>
        </div>
    </div>
</body>
</html>