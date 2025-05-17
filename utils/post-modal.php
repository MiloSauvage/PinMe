<?php
require_once("../utils/image.php");
require_once("../utils/bdd.php");
require_once("../utils/comment.php");
require_once("../utils/user.php");
require_once("../utils/session.php");
require_once("../utils/like.php");
require_once("../utils/annotation.php");

if (!isset($_GET["id"])) {
    exit;
}
$id = $_GET["id"];
if($id === null || !is_numeric($id)) {
    echo "<p>Erreur : l'image n'existe pas ou vous n'avez pas les droits d'accès.</p>";
    exit;
}
$image = get_image_from_id($id);
if ($image == null) {
    echo "<p>Erreur : l'image n'existe pas ou vous n'avez pas les droits d'accès.</p>";
    exit;
}
if($image->visibility === false && ( session_get_user() === null || $image->id_author !== session_get_user()->id)){
    echo "<p>Erreur : l'image n'existe pas ou vous n'avez pas les droits d'accès.</p>";
    exit;
}
$user = session_get_user();
$is_liked = false;
$like_count = get_post_like_count($image);
if (is_connected()) {
    $current_user_id = session_get_user()->id;
    $is_liked = check_if_post_liked($image, $user);
}
$annotations = get_annotations_by_image_id($id);

/**
 * Formate une date pour affichage relatif.
 * @param string $date_str Date au format string
 * @return string Date formatée
 */
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
<div class="modal-close" data-dismiss="post">&times;</div>
<div class="modal-header">
    <div class="title">
        <p><?= htmlspecialchars($image->titre); ?></p>
    </div>
    <div class="description">
        <p><?= htmlspecialchars($image->desc); ?></p>
    </div>
    <div class="author">
        <?php 
            $user = get_user_from_id($image->id_author);
            if ($user !== null) {
                echo "<p>Par : <a href='profile.php?username=" . htmlspecialchars($user->username) . "'>" . htmlspecialchars($user->username) . "</a></p>";
            }
        ?>
    </div>
    <div class="category"></div>
    <div class="tags"></div>
</div>
<div class="modal-body">
    <div class="img-container position-relative">
        <img src="<?= htmlspecialchars($image->source) ?>" alt="Image" class="post-image" id="annotated-image">
        <div class="annotations-container">
            <?php foreach ($annotations as $annotation): ?>
                <?php 
                    $annotation_user = get_user_from_id($annotation->user_id);
                    $username = $annotation_user !== null ? htmlspecialchars($annotation_user->username) : "Utilisateur inconnu";
                ?>
                <div class="annotation-marker" 
                    data-id="<?= $annotation->id ?>"
                    data-pos-x="<?= $annotation->position_x ?>"
                    data-pos-y="<?= $annotation->position_y ?>"
                    data-width="<?= $annotation->width ?>"
                    data-height="<?= $annotation->height ?>"
                    style="border-color: <?= $annotation->color ?>;">
                    <div class="annotation-tooltip">
                        <strong><?= htmlspecialchars($annotation->title) ?></strong>
                        <span class="annotation-author">Par: <?= $username ?></span>
                        <?php if (is_connected() && ($annotation->user_id == session_get_user()->id || $image->id_author == session_get_user()->id)): ?>
                            <a href="process/delete-annotation.php?id=<?= $annotation->id ?>" class="annotation-delete-btn" data-annotation-id="<?= $annotation->id ?>">🗑️</a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="post-actions">
        <?php if (is_connected()): ?>
            <a href="./process/<?= $is_liked ? "dis" : "" ?>like-post.php?id=<?= $id ?>" class="post-like-btn <?= $is_liked ? 'liked' : '' ?>">
                <span class="like-icon"><?= $is_liked ? '❤️' : '🤍' ?></span>
                <span class="like-count"><?= $like_count > 0 ? $like_count : '' ?></span>
            </a>
            <a href="./create-annotation.php?id=<?= $id ?>" class="post-pin-btn">
                <span class="pin-icon">📌</span>
            </a>
        <?php else: ?>
            <div class="post-like-info">
                <span class="like-icon">🤍</span>
                <span class="like-count"><?= $like_count > 0 ? $like_count : '' ?></span>
                <span class="like-login-prompt">Pour <strong>aimer</strong>, ou <strong>annoter</strong> <a href="login.php">connectez-vous</a></span>
            </div>
        <?php endif; ?>
    </div>
    <div class="comments">
        <h3>Commentaires</h3>
        <div class="comment-list">
            <?php
                $comments = get_comments_from_image_id($id);
                if (count($comments) == 0) {
                    echo "<p>Aucun commentaire pour le moment.</p>";
                } else {
                    foreach ($comments as $comment) {
                        $user = get_user_from_id($comment->id_author);
                        $username = $user === null ? "Utilisateur inconnu" : $user->username;
                        $profile_pic = $user === null ? "./public/images/default-avatar.avif" : ($user->src_pfp ?? "./public/images/default-avatar.avif");
                        $is_post_author = ($user && $image->id_author == $user->id);
                        $is_comment_author = ($user && is_connected() && session_get_user()->id == $user->id);

                        echo "<div class='comment'>";
                        echo "<div class='comment-header'>";
                        echo "<img src='" . htmlspecialchars($profile_pic) . "' alt='Avatar' class='comment-avatar'>";
                        echo "<p class='comment-author'><a href='profile.php?username=" . htmlspecialchars($username) . "'>" . htmlspecialchars($username) . "</a></p>";
                        echo "<span class='comment-date'>" . format_date($comment->upload_date) . "</span>";
                        echo "<div class='comment-actions'>";
                        if ($is_post_author || $is_comment_author) {
                            echo "<a class='btn-delete' href='./process/delete-comment.php?id=" . $comment->id . "'>🗑️</a>";
                        }
                        echo "</div>";
                        echo "</div>";
                        echo "<p class='comment-content'>" . htmlspecialchars($comment->content) . "</p>";
                        echo "</div>";
                    }
                }
            ?>
        </div>
        <?php if (is_connected()): ?>
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
</div>
<div class="modal-footer">
    <a href="#" class="btn btn-close" role="button" data-dismiss="post">fermer</a>
    <a href="#" class="btn btn">valider</a>
    <?php
        if (is_connected() && (session_get_user()->id == $image->id_author || session_get_user()->administrator)) {
            echo '<a href="#" class="btn btn-delete" data-delete="post">supprimer</a>';
        }
    ?>
</div>