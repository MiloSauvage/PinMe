<?php
    session_start();
    if(!isset($_SESSION["username"])){
        echo "You are not connected <a href=\"index.php\">retour au lobby</a>";
        exit;
    }
    if(!isset($_GET["id"]) || $_GET["id"] == NULL){
        echo "There is no id <a href=\"dashboard.php\">retour au lobby</a>";
        exit;
    }
    $username = $_SESSION["username"];
    $id = $_GET["id"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit</title>
    <link rel="stylesheet" href="css/edit.css">
</head>
<body>
    <header>
        <p id="info_user">Tasks of <strong><?php echo "$username";?></strong></p>
        <a href="process/logout.php" id="logout-btn"><img alt="logout image" src="css/logout.webp"></a>
    </header>
    <hr>
    <div id="container">
      <div id="tasks">
          <h2 id ="titre1"> Previous </h2>
          <?php
                include 'db.php';

                $requete = "SELECT * FROM task WHERE (owner='$username' AND id='$id')";
                $res = mysqli_query($connexion, $requete);

                if(!$res){
                    mysqli_close($connexion);
                    echo("Erreur de bdd");
                    exit;
                    }
                    $task = mysqli_fetch_array($res);

                if ($task === NULL) {
                    echo "erreur d'id";
                    mysqli_close($connexion);
                    exit;
                }

                echo "<fieldset id=\"task\">";
                echo "<legend><h3>[ ".$task["name"]." ]</h3></legend>";
                echo "<p><strong>Description</strong> : ".$task["description"]."</p>";
                echo "<p><strong>Deadline</strong> : ".date("l, F jS Y", strtotime($task["deadline"]))."</p>";
                echo "<p><strong>Status</strong> : ".$task["status"]."</p>";
                echo "</fieldset>";

                mysqli_close($connexion);
          ?>
      </div>
      <div id="vertical-border">
      </div>
      <div id="edit">
        <h2 id ="titre2"> Modification </h2>
        <div id="edit_task">
            <form method="POST" action="process/edittask.php">
                <fieldset id="edit_task_field">
                    <legend><h3>Edit</h3></legend>
                    <label>Name : </label><input type="text" name="name" value="<?php echo $task["name"]?>"><br>
                    <label>Deadline : </label><input type="date" name="deadline" value="<?php echo $task["deadline"]?>"><br>
                    <label>Status : </label>
                    <select id="status" name="status">
                        <option value="To do" <?php if($task["status"] == "To do") echo"selected"; ?>>To do</option>
                        <option value="In progress" <?php if($task["status"] == "In progress") echo"selected"; ?>>In progress</option>
                        <option value="Finished" <?php if($task["status"] == "Finished") echo"selected"; ?>>Finished</option>
                    </select><br>
                    <label>Desciption : </label><br><textarea name="description" cols="30" rows="5"><?php echo $task["name"]?></textarea><br>
                    <input type="hidden" name="id" value="<?php echo $id;?>">
                    <input type="submit" value="Submit" id="submit">
                </fieldset>
            </form>
        </div>
      </div>
    </div>
</body>
</html>
