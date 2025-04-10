<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pin-Me !</title>
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
            text-align: center;
            padding: 40px 20px;
        }

        header h1 {
            font-size: 36px;
            margin: 0;
        }

        fieldset {
            background-color: #fff;
            border-radius: 10px;
            padding: 30px;
            margin: 40px auto;
            max-width: 500px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        legend {
            font-size: 24px;
            font-weight: bold;
            color: #4A90E2;
            margin-bottom: 20px;
        }

        label {
            font-size: 16px;
            color: #333;
            margin-bottom: 8px;
            display: block;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            margin: 8px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        input[type="submit"] {
            background-color: #4A90E2;
            color: white;
            font-size: 18px;
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            margin-top: 20px;
        }

        input[type="submit"]:hover {
            background-color: #357ABD;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
        }

        .footer a {
            color: #4A90E2;
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<header>
    <h1>Pin-Me !</h1>
</header>

<fieldset>
    <legend>Inscription</legend>
    <form action="process/registration.php" method="post">
        <label for="username">Nom d'utilisateur :</label>
        <input type="text" id="username" name="username" required>

        <label for="email">E-mail :</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="password" required>

        <label for="repassword">Retaper le mot de passe :</label>
        <input type="password" id="repassword" name="repassword" required>

        <input type="submit" value="S'inscrire">
    </form>
</fieldset>

<div class="footer">
    <p>Déjà un compte ? <a href="login.php">Se connecter</a></p>
</div>

</body>
</html>
