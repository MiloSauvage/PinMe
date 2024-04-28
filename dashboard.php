<?php
    session_start();
    if(!isset($_SESSION["username"])){
        echo "You are not connected <a href=\"index.php\">retour au lobby</a>";
        exit;
    }
    $username = $_SESSION["username"];
?>
<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="css/dashboard.css">
</head>
<body>
    <header>
        <div id="information">
            <p id="info_user">Tasks of <strong><?php echo "$username";?></strong></p>
            <div id="logout">
                <a href="process/logout.php" id="logout-btn"><img alt="logout image" src="css/logout.webp"></a>
            </div>
        </div>
    </header>
    <hr>
    <div id="forms">
        <div id="newtask">
            <form method="POST" action="process/newtask.php">
                <fieldset id="new_task_field">
                    <legend><h3>Creation</h3></legend>
                    <label>Name : </label><input type="text" name="name" placeholder="name" required>
                    <label>Deadline: </label><input type="date" name="deadline" required>
                    <label>Desciption : </label><textarea name="description" cols="30" rows="5" placeholder="description" required></textarea>
                    <input type="submit" value="valider">
                </fieldset>
            </form>
        </div>
        <div id="search">
            <form method="POST" action="process/search.php">
                <fieldset id="search_task_field">
                    <legend><h3>Search</h3></legend>
                    <label>Name : </label><input type="text" placeholder="name" name="name">
                    <label>Deadline: </label><input type="date" name="deadline">
                    <label>Status: </label>
                    <select id="status" name="status">
                        <option value="" selected hidden>--Status--</option>
                        <option value="To do">To do</option>
                        <option value="In progress">In progress</option>
                        <option value="Finished">Finished</option>
                    </select><br>
                    <label>Desciption : </label><textarea name="description" placeholder="description" cols="30" rows="5"></textarea>
                    <input type="submit" value="valider">
                </fieldset>
            </form>
        </div>
        <div id="sort">
            <form method="GET">
                <fieldset id="sort_task_field">
                    <legend><h3>Sort</h3></legend>
                    <select name="sort">
                        <option value="" selected disabled hidden>--Sort by--</option>
                        <option value="name">Name</option>
                        <option value="status">Status</option>
                        <option value="deadline">Deadline</option>
                    </select>
                    <div id="increasing-checkbox">
                        <input type="checkbox" id="decreasing" name="decreasing">
                        <label for="decreasing">decreasing</label>
                    </div>
                    <input type="submit" value="valider">
                </fieldset>
            </form>
        </div>
    </div>
    <hr>
    <?php
        if(isset($_GET["err"])){
            $err = $_GET["err"];

            switch($err){
                case 1:
                    echo "<p id=\"err\"><strong>Invalide date</strong>, must be between 1900 and 2100</p>";
                    break;
                case 2:
                    echo "<p id=\"err\"><strong>Description</strong> too large, you can put upto 10'000 characters</p>";
                    break;
                case 2:
                    echo "<p id=\"err\"><strong>Nom</strong> too large, you can put upto 100 caractères</p>";
                    break;
            }
        }
    ?>

    <div id="tasks">
<?php
            include 'db.php';

            // Décroissant, selon les cas

            // Classement par date croissante /!\ il faudrait les classer par ceux qui sont les plus proches de la date actuelle
            // Et qui ne sont pas dépassés

            // Recherche si référencé
            if(isset($_SESSION["search"])){
                $requete = "SELECT * FROM task WHERE (owner='$username') AND ".$_SESSION["search"];
            }else{
                $requete = "SELECT * FROM task WHERE (owner='$username')";
            }

            // Tri

            if(isset($_GET["sort"]) && isset($_GET["decreasing"]) && $_GET["decreasing"] == "on"){ // DESC décroissance
                switch($_GET["sort"]){
                    case "name":
                        $requete .= " ORDER BY Name DESC";
                        break;
                    case "status":
                        $requete .= " ORDER BY status DESC";
                        break;
                    case "deadline":
                        $requete .= " ORDER BY deadline DESC";
                        break;
                    default:
                        $requete = " DESC";
                        break;
                }
            }else if(isset($_GET["sort"])){ // Croissant selon les cas
                switch($_GET["sort"]){
                    case "name":
                        $requete .= " ORDER BY Name";
                        break;
                    case "status":
                        $requete .= " ORDER BY status";
                        break;
                    case "deadline":
                        $requete .= " ORDER BY deadline";
                        break;
                }
            }
            
            // Décommenter pour afficher la requête effectuée au serveur SQL
            // echo $requete;
            $res = mysqli_query($connexion, $requete);

            if(!$res){
                mysqli_close($connexion);
                echo("Erreur de bdd");
                exit;
            }

            while ($task = mysqli_fetch_array($res)) {
                echo "\t\t<div class=\"item\">\n";
                echo "\t\t\t<fieldset class=\"task\">\n";
                echo "\t\t\t\t<legend class=\"legend-task\"><h3>[ ".$task["name"]." ]</h3></legend>\n";
                echo "\t\t\t\t<p><strong>Description</strong> : ".$task["description"]."</p>\n";
                $deadline = date("l, F jS Y", strtotime($task["deadline"]));
                echo "\t\t\t\t<p><strong>Deadline</strong> : ".$deadline."</p>\n";
                $cur_date = date("l, F jS Y");
                $remain = (strtotime($deadline) - strtotime($cur_date))/60/60/24;
                if($remain > 0){
                    echo "\t\t\t\t<p><strong>Remain</strong> : ".$remain." days</p>\n";
                }else if($remain === 0){
                    echo "\t\t\t\t<p><strong>Remain</strong> : <strong>today</strong></p>\n";
                }else{
                    echo "\t\t\t\t<p><strong>Remain</strong> : elapsed</p>\n";
                }

                if($task["status"] == "To do"){
                    echo "\t\t\t\t<p><strong>Status</strong> : ".$task["status"]." 🟣</p>\n";
                }else if($task["status"] == "In progress"){
                    echo "\t\t\t\t<p><strong>Status</strong> : ".$task["status"]." 🔵</p>\n";
                }else if($task["status"] == "Finished"){
                    echo "\t\t\t\t<p><strong>Status</strong> : ".$task["status"]." 🟢</p>\n";
                }
                // bouton d'edition de tâche
                echo "\t\t\t\t<div class=\"btn-box\">\n";
                echo "\t\t\t\t\t<form method=\"GET\" action=\"edit.php\">\n";
                echo "\t\t\t\t\t\t<button class=\"button\">edit</button>\n";
                echo "\t\t\t\t\t\t<input type=\"hidden\" name=\"id\" value=\"".$task["id"]."\">\n";
                echo "\t\t\t\t\t</form>\n";
                echo "\t\t\t\t</div>";
                // bouton de suppression de tâche
                echo "\t\t\t\t<div class=\"btn-box\">\n";
                echo "\t\t\t\t\t<form action=\"process/deltask.php\">\n";
                echo "\t\t\t\t\t\t<button class=\"button\">delete</button>\n";
                echo "\t\t\t\t\t\t<input type=\"hidden\" name=\"id\" value=\"".$task["id"]."\">\n";
                echo "\t\t\t\t\t</form>\n";
                echo "\t\t\t\t</div>\n";
                echo "\t\t\t\t</fieldset>\n";
                echo "\t\t\t</div>\n";
            }

            mysqli_close($connexion);
        ?>
    </div>
</body>
</html>
