<?php
  if(isset($_GET["id"])){
    $id = $_GET["id"];
    session_start();
    $username = $_SESSION["username"];

    include '../db.php';

    $requete = "DELETE from task WHERE id='$id' AND owner='$username'";
    $res = mysqli_query($connexion, $requete);

    if(!$res){
        mysqli_close($connexion);
        error();
    }
    mysqli_close($connexion);
    header("Location: ../dashboard.php");
  }

  function error(){
    echo "An error occured, <a href=\"dashboard.php\">go back</a>";
    exit;
  }
?>
