<!DOCTYPE HTML>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>process</title>
</head>
<body>
  <?php
    // savoir si formulaire bien envoyé
    if(isset($_POST["username"])
      && isset($_POST["password"])
      && isset($_POST["type"])){

      // Récupération des variables
      $username = $_POST["username"];
      $password = $_POST["password"];
      $type = $_POST["type"];

      echo "$username, $password, $type";

      include 'db.php';

      if($type == "login"){

        // Connexion à la base de donnée
        $requete = "SELECT * FROM user";
        $res = mysqli_query($connexion, $requete);

        while($user = mysqli_fetch_array($res)){
          if(strtolower($user["username"]) == strtolower($username) && $user["password"] == $password){
            echo "Connecté, redirection dashboard";
            // Ouverture de session
            session_start();
            $_SESSION["username"] = $username;
            header("Location: dashboard.php");
            exit;
          }
        }

        echo "<br/> Ca ne marche pas";
        // err 1, mauvais identifiants
        header("Location: login.php?err=1");
        exit;

        // fermeture de la connexion
        mysqli_close($connexion);
      }else if($type == "signup"){
        // Connexion à la base de donnée
        $u = strtolower($username);
        $requete = "SELECT username from user where (username='$u')";
        $res = mysqli_query($connexion, $requete);
        $usernames = mysqli_fetch_array($res);

        if(strtolower($usernames["username"]) != $u){ // le mec n'existe pas déjà dans la bdd
          echo "inscription...";
          $requete = "INSERT INTO user VALUES('$username', '$password')";
          $res = mysqli_query($connexion, $requete);
          if($res){
            echo "<br/>succed";
            // Ouverture de session
            session_start();
            $_SESSION["username"] = $username;
            header("Location: dashboard.php");
          }else{
            // err 2, erreur de création de compte
            header("Location: signup.php?err=2");
          }
          mysqli_close($connexion);
        }else{
          // err 1, pseudo existant
          header("Location: signup.php?err=1");
          mysqli_close($connexion);
        }
      }else
        error();
    }else{
      error();
    }

    function error(){
      echo "An error occured, <a href=\"index.php\">go back</a>";
      exit;
    }
  ?>
</body>
</html>
