<?php
    require_once("./image.php");
    require_once("./bdd.php");
    require_once("./comment.php");
    require_once("./user.php");
    require_once("./session.php");


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





<!-- Version améliorée de la structure des commentaires -->
<div class="comments">
    <h3>Commentaires</h3>
    <div class="comment-list">
        <?php
            $comments = get_comments_from_image_id($id);
            if(count($comments) == 0){
                echo "<p>Aucun commentaire pour le moment.</p>";
            } else {
                foreach($comments as $comment){
                    $user = get_user_from_id($comment->id_author);
                    $username = $user === null ? "Utilisateur inconnu" : $user->username;
                    $profile_pic = $user === null ? "./public/images/default-avatar.avif" : ($user->src_pfp ?? "./public/images/default-avatar.avif");
                    $is_post_author = ($user->id == $image->id_author);
                    $is_comment_author = ($user->id == $comment->id_author);
                   
                    echo "<div class='comment'>";
                    echo "<div class='comment-header'>";
                    echo "<img src='$profile_pic' alt='Avatar' class='comment-avatar'>";
                    echo "<p class='comment-author'><a href='profile.php?username=$username'>$username</a></p>";
                    echo "<span class='comment-date'>" . format_date($comment->upload_date) . "</span>";
                    
                    // Actions sur les commentaires (like, supprimer, épingler)
                    echo "<div class='comment-actions'>";
                    
                    // Boutons pour l'auteur du post uniquement
                    if($is_post_author || $is_comment_author){
                        // Bouton Supprimer
                        echo "<a class='btn-delete' href=/process/delete-comment.php?id=" . $comment->id . ">";
                        echo "🗑️";
                        echo "</a>";
                    }
                    
                    echo "</div>"; // .comment-actions
                    echo "</div>"; // .comment-header
                    echo "<p class='comment-content'>" . htmlspecialchars($comment->content) . "</p>";
                    echo "</div>"; // .comment

                }
            }
           
            // Fonction d'aide pour formater la date
            function format_date($date_str) {
                $date = new DateTime($date_str);
                $now = new DateTime();
                $diff = $now->diff($date);
               
                if ($diff->days == 0) {
                    if ($diff->h == 0) {
                        if ($diff->i == 0) {
                            return "À l'instant";
                        }
                        return "Il y a " . $diff->i . " minute" . ($diff->i > 1 ? "s" : "");
                    }
                    return "Il y a " . $diff->h . " heure" . ($diff->h > 1 ? "s" : "");
                } else if ($diff->days < 7) {
                    return "Il y a " . $diff->days . " jour" . ($diff->days > 1 ? "s" : "");
                } else {
                    return $date->format('d/m/Y à H:i');
                }
            }

        ?>
    </div>
   
    <?php if(is_connected()): ?>
    <form action="process/add-comment.php" method="post" class="comment-form">
        <textarea name="content" placeholder="Partagez votre avis..." required></textarea>
        <button type="submit">Ajouter un commentaire</button>
        <input type="hidden" name="id" value="<?= htmlspecialchars($image->id) ?>">
    </form>
    <?php else: ?>
    <div class="comment-login-prompt">
        <p>Vous devez être <a href="login.php">connecté</a> pour commenter.</p>
    </div>
    <?php endif; ?>
</div>

<!-- JavaScript pour gérer les actions des boutons -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gestion du bouton Supprimer
    document.querySelectorAll('.btn-delete').forEach(button => {
        button.addEventListener('click', function() {
            if(confirm('Êtes-vous sûr de vouloir supprimer ce commentaire ?')) {
                const commentId = this.getAttribute('data-comment-id');
                
                // Appel AJAX pour supprimer
                fetch('process/delete-comment.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'comment_id=' + commentId
                })
                .then(response => response.json())
                .then(data => {
                    if(data.success) {
                        // Supprimer le commentaire du DOM
                        this.closest('.comment').remove();
                    }
                });
            }
        });
    });
});
</script>













</div>
<div class="modal-footer">
    <a href="#" class="btn btn-close" role="button" data-dismiss="post">fermer</a>
    <a href="#" class="btn btn">valider</a>
    <a href="#" class="btn btn-delete" data-delete="post">supprimer</a>
</div>
