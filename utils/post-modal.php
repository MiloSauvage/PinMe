<?php
    require_once("./image.php");
    require_once("./bdd.php");
    require_once("./comment.php");
    require_once("./user.php");

    if(!isset($_GET["id"])){
        exit;
    }
    $id = $_GET["id"];
    $image = get_image_from_id($id);
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
        <?php 
            $user = get_user_from_id($image->id_author);
            if($user !== null){
                echo "<p>Par : <a href='../profile.php?username=".htmlspecialchars($user->username)."'>".htmlspecialchars($user->username)."</a></p>";
            }
        ?>
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
                $comments = get_comments_from_image_id($id);
                if(count($comments) == 0){
                    echo "<p>Aucun commentaire pour le moment.</p>";
                }else{
                    foreach($comments as $comment){
                        $username = get_user_from_id($comment->id_author) === null ? "Error" : get_user_from_id($comment->id_author)->username;
                        echo "<div class='comment'>";
                        echo "<p class='comment-author'><a href='/profile.php?username=$username'>$username</a></p>";
                        echo "<p class='comment-content'>".$comment->content."</p>";
                        echo "</div>";
                    }
                }
            ?>
        </div>
        <form action="/process/add-comment.php" method="post" class="comment-form">
            <textarea name="content" placeholder="Ajouter un commentaire" required></textarea>
            <button type="submit">Ajouter un commentaire</button>
            <input type="hidden" name="id" value="<?= htmlspecialchars($image->id) ?>">
        </form>
    </div>
</div>
<div class="modal-footer">
    <a href="#" class="btn btn-close" role="button" data-dismiss="post">fermer</a>
    <a href="#" class="btn btn">valider</a>
    <a href="#" class="btn btn-delete" data-delete="post">supprimer</a>
</div>
