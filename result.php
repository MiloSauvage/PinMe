<?php
    include_once("./utils/session.php");
    include_once("./utils/bdd.php");

    $query = $_GET["q"] ?? null;
    $category = $_GET["category"] ?? null;
    $sort = $_GET["sort"] ?? null;

    if($query === null || $category  === null|| $sort === null || !is_connected()){
        header("location: ./index.php");
        exit;
    }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultat - PinMe !</title>
</head>
<body>
    <?php
        $sql = "SELECT *
        FROM Images
        WHERE ( title LIKE CONCAT('%', :search, '%')
           OR tags LIKE CONCAT('%', :search, '%')
           OR description LIKE CONCAT('%', :search, '%'))";
        
        if($category !== ""){
            $sql .= " AND categories like $category";
        }

        $sql .= " ORDER BY ";

        switch($sort){
            case "popular":
                $sql .= "like";
                break;
            case "oldest":
                $sql .= "upload_date DESC";
                break;
            default:
                $sql .= "upload_date";
                break;
        }
                    
        $connexion = connection_database();

        $stmt = $connexion->prepare($sql);
        $stmt->bindValue(':search', $query);
        $stmt->execute();
        $images = $stmt->fetchAll();

        if($images === false){
            echo "<p>Aucune image trouvée.</p>";
        } else {
            foreach($images as $image){
                echo "<div class='image'>";
                echo "<img src='{$image['src']}' alt='{$image['title']}'>";
                echo "<h3>{$image['title']}</h3>";
                echo "<p>{$image['description']}</p>";
                echo "</div>";
            }
        }
    ?>
</body>
</html>