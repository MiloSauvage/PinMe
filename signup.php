<!DOCTYPE HTML>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Signup</title>
  <link rel="stylesheet" href="css/login.css">
</head>
<body>
  <div id = "content">
    <h1>Join us</h1>
    <div id="login">
      <form method="POST" action="traitement.php" id ="box">
        <fieldset>
          <legend>sign up</legend>
          <div id="username">
            <input type="text" name="username" placeholder="Username" id="user_ipt" required><br>
          </div>
          <div id="password">
            <input type="password" name="password" placeholder="Password" id="pwrd_ipt" required><br>
          </div>
        </fieldset>
        <input type="submit" value="Submit" id="submit">
        <input type="hidden" name ="type" value="signup">
      </form>
    </div>
  </div>
  <?php
    if(isset($_GET["err"])){
      $err = $_GET["err"]; // Variables dans l'url
      // Erreur 1 : Utilisateur existant
      if($err == "1"){
        echo "<div id=\"err_cont\"><p id=\"error\">A user own this username</p></div>";
      }
      // Erreur 2 : Erreur surevenur
      if($err == "2"){
        echo "<div id=\"err_cont\"><p id=\"error\">Inscription failed</p></div>";
      }
    }
  ?>
  <footer>
    <hr>
    <p>Click <a href="index.php">here</a> to cancel.</p>
  </footer>
</body>
</html>
