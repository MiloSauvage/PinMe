<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        require_once("./image.php");
        require_once("./bdd.php");
        if(!isset($_GET["id"])){
            exit;
        }
        $id = $_GET["id"];
        $connexion = connection_database();
        $image = get_image_from_id($connexion, $id);
        if($image == null){
            exit;
        }
    ?>
    <div class="modal-close" data-dismiss="post">&times;</div>
    <div class="modal-header">
        <div class="title">
            <p><?php echo $image->titre;?></p>
        </div>
        <div class="description">
            <p><?php echo $image->desc;?></p>
        </div>
        <div class="author">

        </div>
        <div class="category">

        </div>
        <div class="tags">
            
        </div>
    </div>
    <div class="modal-body">
        <div class="img">
            <img src="<?= htmlspecialchars($image->source) ?>" alt="Image">
        </div>
        <div class="comments">
            <h3>Commentaires</h3>
            <div class="comment-list">
                <?php
                    // $comments = get_comments_from_image($connexion, $id);
                    // foreach($comments as $comment){
                    //     echo "<div class='comment'>";
                    //     echo "<p class='comment-author'>".$comment->auteur."</p>";
                    //     echo "<p class='comment-content'>".$comment->contenu."</p>";
                    //     echo "</div>";
                    // }
                ?>
            </div>
            <form action="#" method="post" class="comment-form">
                <input type="text" name="author" placeholder="Votre nom" required>
                <textarea name="content" placeholder="Votre commentaire" required></textarea>
                <button type="submit">Ajouter un commentaire</button>
            </form>
        </div>
    </div>
    <div class="modal-footer">
        <a href="#" class="btn btn-close" role="button" data-dismiss="post">fermer</a>
        <a href="#" class="btn btn">valider</a>
        <a href="#" class="btn btn-delete" data-delete="post">supprimer</a>
    </div>
</body>
</html>