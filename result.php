<?php
include_once("./utils/session.php");
include_once("./utils/bdd.php");
include_once("./utils/image.php");

$query = $_GET["q"] ?? null;
$category = $_GET["category"] ?? null;
$sort = $_GET["sort"] ?? null;

if ($query === null || $category === null || $sort === null) {
    header("location: " . $_SERVER["HTTP_REFERER"]);
    exit;
}

$sql = "SELECT * FROM Images WHERE (LOWER(title) LIKE LOWER(CONCAT('%', :search, '%')) OR tags LIKE LOWER(CONCAT('%', :search, '%')) OR description LIKE LOWER(CONCAT('%', :search, '%')))";
if ($category !== "") {
    $sql .= " AND categories LIKE $category";
}
$sql .= " ORDER BY ";
switch ($sort) {
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
disconnect_database($connexion);

$images_array = [];
foreach ($images as $image) {
    $img = new Image(
        $image["id"],
        $image["src"],
        $image["title"],
        $image["description"],
        $image["categories"],
        $image["tags"],
        $image["author_id"],
        $image["likes"],
        $image["visibility"],
        $image["upload_date"]
    );
    array_push($images_array, $img);
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultat - PinMe !</title>
    <link rel="stylesheet" href="./styles/index.css">
    <link rel="stylesheet" href="./styles/modal.css">
    <script src="./scripts/modal.js" defer></script>
</head>
<body>
    <header>
        <img class="logo-header" src="./public/images/logo/logo.png" alt="Logo">
    </header>
    <div class="page-content">
        <?php include_once 'utils/side-bar.php'; ?>
        <div class="img-div">
            <h2>Les images les plus récentes :</h2>
            <br>
            <div class="recent-images">
                <?php
                if (empty($images_array)) {
                    echo '<p class="no-images">Ça semble vide ici !</p>';
                } else {
                    foreach ($images_array as $image) {
                        echo "<div class=\"image-item\" role=\"button\" post-id=\"$image->id\" data-target=\"#modal\" data-toggle=\"modal\">";
                        echo "<img src=\"" . $image->source . "\" alt=\"" . $image->titre . "\">";
                        echo "<p>" . $image->titre . "</p>";
                        echo "</div>";
                    }
                }
                ?>
            </div>
        </div>
        <div class="modal" id="modal" role="post">
            <div class="modal-content"></div>
        </div>
    </div>
</body>
</html>
