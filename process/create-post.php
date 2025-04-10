<?php
// Testons si le fichier a bien été envoyé et s'il n'y a pas d'erreur
if (isset($_FILES['image']) AND $_FILES['image']['error'] == 0)
{
        // Testons si le fichier n'est pas trop gros
        if ($_FILES['image']['size'] <= 3145728)
        {
                // Testons si l'extension est autorisée
                $infosfichier = pathinfo($_FILES['image']['name']);
                $extension_upload = $infosfichier['extension'];
                $extensions_autorisees = array('jpg', 'jpeg', 'gif', 'png');
                if (in_array($extension_upload, $extensions_autorisees))
                {
                        // On peut valider le fichier et le stocker définitivement
                        move_uploaded_file($_FILES['image']['tmp_name'], __DIR__ . "/../images/uploads/" . basename($_FILES['image']['name']));
                        echo "L'envoi a bien été effectué !";
                }
                else
                {
                    echo 'extention non-autorisee';
                }
        }
        else
        {
            echo 'image trop grosse';
        }
}
elseif (isset($_FILES['image']) AND $_FILES['image']['error'] == UPLOAD_ERR_NO_FILE)
{
    echo 'fichier inexistant';
}
elseif (isset($_FILES['image']) AND $_FILES['image']['error'] == UPLOAD_ERR_PARTIAL)
{
    echo 'fichier uploadé que partiellement';
}
elseif (isset($_FILES['image']) AND $_FILES['image']['error'] == UPLOAD_ERR_INI_SIZE)
{
    echo 'fichier trop gros';
}
elseif (isset($_FILES['image']) AND $_FILES['image']['error'] == UPLOAD_ERR_FORM_SIZE)
{
    echo 'fichier trop gros';
}
elseif (!isset($_FILES['image']))
{
    echo 'pas de variable';
}
else
{
    echo 'probleme a l\'envoi';
}