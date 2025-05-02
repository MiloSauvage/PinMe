<?php
    include_once("./utils/session.php");
    include_once("./utils/bdd.php");
    include_once("./utils/image.php");

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
    <link rel="stylesheet" href="./styles/index.css">
    <link rel="stylesheet" href="./styles/modal.css">

    <script src="./scripts/modal.js" defer></script>
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
        //function __construct($id, $source,  $titre, $id_author, $upload_date, $desc = "", $categories = "", $tags = "",$visibility = true, $likes = 0) {
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

<header>
        <img class="logo-header" src="./public/images/logo/logo.png" alt="Logo">
    </header>

    <div class="page-content">
    <div class="side-bar">
        <?php
            include_once 'utils/session.php';
        ?>
        <?php if(is_connected()): ?>
            <!-- Section d'informations utilisateur -->
            <div class="user-info">
                <?php $user = session_get_user(); ?>
                <img src="<?= $user->src_pfp ?? 'public/images/default-avatar.avif' ?>" alt="Avatar" class="avatar">
                <p class="username"><?= $user->username ?></p>
                
                <!-- Statistiques utilisateur -->
                <div class="user-stats">
                    <div class="stat-item">
                        <div class="stat-count"><?=count_user_images($user->id) ?? 0 ?></div>
                        <div class="stat-label">Images</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-count"><?= count_user_likes($user->id) ?? 0 ?></div>
                        <div class="stat-label">J'aimes</div>
                    </div>
                </div>
            </div>
            
            <!-- Liens rapides pour utilisateur connecté -->
            <div class="quick-links">
                <h3>Actions rapides</h3>
                <ul>
                    <li><a href="create-post.php"><span class="icon">➕</span> Ajouter une image</a></li>
                    <li><a href="profile.php?username=<?= $user->username ?>"><span class="icon">👤</span> (+) Mon profil</a></li>
                    <li><a href="favorites.php"><span class="icon">❤️</span> (+) Mes favoris</a></li>
                    <li><a href="search.php"><span class="icon">🔍</span> (+) Rechercher</a></li>
                    <li><a href="edit-profile.php?username=<?= $user->username?>"><span class="icon">⚙️</span> (+) Paramètres</a></li>
                    <li><a href="process/logout.php"><span class="icon">🚪</span> Se déconnecter</a></li>
                </ul>
            </div>
        <?php else: ?>
            <!-- Boutons pour utilisateur non connecté -->
            <div class="cta-buttons">
                <a href="login.php">Se connecter</a>
                <a href="register.php">S'inscrire</a>
            </div>
            
            <!-- Information pour visiteur -->
            <div class="quick-links">
                <h3>Explorer</h3>
                <ul>
                    <li><a href="gallery.php"><span class="icon">🖼️</span> Galerie publique</a></li>
                    <li><a href="categories.php"><span class="icon">📂</span> Catégories</a></li>
                    <li><a href="about.php"><span class="icon">ℹ️</span> À propos</a></li>
                </ul>
            </div>
        <?php endif; ?>
    </div>

    <div class="img-div">
        <h2>Les images les plus récentes :</h2>
        <br>
        <div class="recent-images ">
            <?php
                if (empty($images_array)) {
                    echo '<p class="no-images">Ça semble vide ici !</p>';
                } else {
                    foreach ($images_array as $image) {
                        echo "\t\t\t\t<div class=\"image-item\" role=\"button\" post-id=\"$image->id\" data-target=\"#modal\" data-toggle=\"modal\">\n\t\t\t\t";
                        echo "<img src=\"" . $image->source . "\" alt=\"" . $image->titre . "\">\n\t\t\t\t";
                        echo "<p>" . $image->titre . "</p>\n\t\t\t\t";
                        echo "</div>\n";
                    }
                }
            ?>
        </div>
    </div>

    <div class="modal" id="modal" role="post">
        <div class="modal-content"></div>
    </div>
</body>
</html>