<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pin-Me !</title>
    <style>
/* Réinitialiser les marges et les bordures par défaut */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* Définir la police par défaut */
body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    color: #333;
    line-height: 1.6;
    padding: 20px;
}

/* Style du header */
header {
    text-align: center;
    margin-bottom: 40px;
}

h1 {
    font-size: 2.5em;
    color: #4CAF50;
}

/* Style du formulaire */
fieldset {
    width: 100%;
    max-width: 400px;
    margin: 0 auto;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 10px;
    background-color: #fff;
}

legend {
    font-size: 1.5em;
    color: #4CAF50;
    text-align: center;
}

/* Style des labels et des champs du formulaire */
label {
    display: block;
    margin-bottom: 10px;
    font-weight: bold;
}

input[type="email"],
input[type="password"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 1em;
}

input[type="submit"] {
    background-color: #4CAF50;
    color: white;
    padding: 10px 20px;
    font-size: 1.1em;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    width: 100%;
}

input[type="submit"]:hover {
    background-color: #45a049;
}

/* Ajouter une légère ombre à la boîte pour lui donner du relief */
fieldset {
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
}

/* Espacement entre les éléments du formulaire */
form {
    padding: 10px;
}

input[type="email"]:focus,
input[type="password"]:focus {
    border-color: #4CAF50;
    outline: none;
}

main {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

    </style>
</head>
<body>
    <header>
        <h1>Pin-Me !</h1>
    </header>
    
    <main>
        <fieldset>
            <legend>Login</legend>
            <form action="process/login.php" method="post" autocomplete="off">
                <label for="email">E-mail:</label><br>
                <input type="email" id="email" name="email" required aria-required="true" placeholder="exemple@mail.com"><br><br>
                
                <label for="password">Password:</label><br>
                <input type="password" id="password" name="password" required aria-required="true" placeholder="Votre mot de passe"><br><br>
                
                <input type="submit" value="Login">
            </form>
        </fieldset>
    </main>
</body>
</html>
