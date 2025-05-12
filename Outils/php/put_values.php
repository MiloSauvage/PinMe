<?php
    require_once('../../utils/bdd.php');
    require_once('../../utils/user.php');
    require_once('../../utils/image.php');
    require_once('../../utils/annotation.php');
    require_once('../../utils/like.php');
    require_once('../../utils/comment.php');

    // Admettons que tout se passe bien :)

    // Ajout des utilisateurs

    $Ambre = add_user('Ambre-des-bois', 'ambre@pinme.fr', '123');
    $Perrine = add_user('Perr', 'perrine@pinme.fr', '123');
    $Christopher = add_user('chris', 'christopher@pinme.fr', '123');
    $Philippe = add_user('philou', 'philippe@pinme.fr', '123');

    $Ambre->change_prenom('Ambre');
    $Ambre->change_nom('Des Bois');
    $Ambre->change_bio('Belle au bois d\'Ambre-ant');
    $Ambre->change_profile_photo('public/test/ambre.jpeg');

    $Perrine->change_prenom('Perrine');
    $Perrine->change_nom('Jadine');
    $Perrine->change_bio('Oh Christophe arrête de crier !');
    $Perrine->change_profile_photo('public/test/perrine.jpeg');

    $Christopher->change_prenom('Christopher');
    $Christopher->change_nom('Nolan');
    $Christopher->change_bio('Y\'a pas de fumé sans feu !');
    $Christopher->change_profile_photo('public/test/christopher.jpeg');

    $Philippe->change_prenom('Philippe');
    $Philippe->change_nom('Bizou');
    $Philippe->change_bio('Un p\ti poutou ?');
    $Philippe->change_profile_photo('public/test/philippe.jpeg');

    // Ajout des images

    $image1 = new image('', 'public/images/tests/ambre.jpeg', 'Moi, Ambre', $Ambre->id, '2023-10-01', 'Je suis Ambre, je suis belle et je suis la !', 'Art', 'Ambre, bois', 1, 0);
    $image2 = new image('', 'public/images/tests/ambre.jpeg', 'PRIVEE', $Ambre->id, '2023-10-01', 'Je suis Ambre, je suis belle et je suis la !', 'Art', 'Ambre, bois', 0, 0);

    $image3 = new image('', 'public/images/tests/perrine.jpeg', 'Moi, perrine', $Perrine->id, '2023-10-01', 'Je suis Perrine, je suis belle et je suis la !', 'Art', 'Perrine, photo', 1, 0);
    $image4 = new image('', 'public/images/tests/perrine.jpeg', 'PRIVEE', $Perrine->id, '2023-10-01', 'Je suis Perrine, je suis belle et je suis la !', 'Art', 'Perrine, photo', 0, 0);

    $image5 = new image('', 'public/images/tests/christopher.jpeg', 'Moi, christopher', $Christopher->id, '2023-10-01', 'Je suis Christopher, je suis beau et je suis la !', 'Art', 'Christopher, selfie', 1, 0);
    $image6 = new image('', 'public/images/tests/christopher.jpeg', 'PRIVEE', $Christopher->id, '2023-10-01', 'Je suis Christopher, je suis beau et je suis la !', 'Art', 'Christopher, selfie', 0, 0);

    $image7 = new image('', 'public/images/tests/philippe.jpeg', 'Moi, philippe', $Philippe->id, '2023-10-01', 'Je suis Philippe, je suis beau et je suis la !', 'Art', 'Philippe, gsm', 1, 0);
    $image8 = new image('', 'public/images/tests/philippe.jpeg', 'PRIVEE', $Philippe->id, '2023-10-01', 'Je suis Philippe, je suis beau et je suis la !', 'Art', 'Philippe, gsm', 0, 0);

    $image1->put_in_bdd();
    $image2->put_in_bdd();
    $image3->put_in_bdd();
    $image4->put_in_bdd();
    $image5->put_in_bdd();
    $image6->put_in_bdd();
    $image7->put_in_bdd();
    $image8->put_in_bdd();

    // Ajout des likes

    add_like($image1, $Ambre);
    add_like($image1, $Perrine);
    add_like($image1, $Christopher);
    add_like($image1, $Philippe);

    add_like($image2, $Perrine);
    add_like($image2, $Christopher);
    add_like($image2, $Philippe);

    add_like($image3, $Christopher);
    add_like($image3, $Philippe);

    add_like($image4, $Philippe);


    // Ajout des commentaires

    $Personnes[] = [$Ambre, $Perrine, $Christopher, $Philippe];
    $Commentaires[] = ['Trop belle !', 'Trop moche !', 'Trop bien !', 'Trop nul !'];

    $Personnes.forall(function($personne) {
        $Commentaires.forall(function($commentaire) {
            $commentaire = new Comment($id, $linked_image_id, $id_author, $content, $upload_date);
            $commentaire->put_in_bdd();
        });
    });



    // ajout des annotations (1024 x 1024)

    $annotation1 = new Annotation('', $image1->id, 'Annotation 1', $Ambre->id, 0, 0, 50, 50, '#ff0000');
    $annotation2 = new Annotation('', $image1->id, 'Annotation 2', $Perrine->id, 50, 50, 50, 50, '#0000ff');
    $annotation3 = new Annotation('', $image1->id, 'Annotation 3', $Christopher->id, 100, 100, 50, 50, '#00ff00');
    $annotation4 = new Annotation('', $image1->id, 'Annotation 4', $Philippe->id, 150, 150, 50, 50, '#ffff00');

    $annotation1->put_in_bdd();
    $annotation2->put_in_bdd();
    $annotation3->put_in_bdd();
    $annotation4->put_in_bdd();

    // Changer le /database.sql au besoin,
    // Les deux premières lignes.
