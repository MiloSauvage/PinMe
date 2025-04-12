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
        <p><?php echo $image->titre;?></p>
    </div>
    <div class="modal-body">
        <img src="<?= htmlspecialchars($image->source) ?>" alt="Image">

    </div>
    <div class="modal-footer">
        <a href="#" class="btn btn-close" role="button" data-dismiss="post">fermer</a>
        <a href="#" class="btn btn">valider</a>
        <a href="#" class="btn btn-delete" data-delete="post">supprimer</a>
    </div>
</body>
</html>