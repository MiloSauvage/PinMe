<?php
    require_once('../../utils/bdd.php');

    
    $connexion = connection_database();

    $connexion->query(file_get_contents('../../database.sql'));

    $stmt = $connexion->prepare($query);

    $stmt->execute();
    disconnect_database($connexion);

    // Changer le /database.sql au besoin,
    // Les deux premières lignes.