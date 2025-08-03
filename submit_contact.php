<?php

/**
 * On ne traite pas les super globales provenant de l'utilisateur directement,
 * ces données doivent être testées et vérifiées.
 */
$postData = $_POST;
const MAX_FILE_SIZE = 1000000;
const ALLOWED_EXTENSIONS = ['png', 'jpg', 'jpeg', 'gif'];
const UPLOAD_PATH = __DIR__ . "/uploads/";

// Vérifier si un fichier a été uploadé pour éviter les erreurs
if (isset($_FILES["screenshot"]["name"]) && !empty($_FILES["screenshot"]["name"])) {
    $fileinfo = pathinfo($_FILES["screenshot"]["name"]);
    $extension = strtolower($fileinfo["extension"]); // Protection : normaliser l'extension
} else {
    $fileinfo = [];
    $extension = '';
}


if (
    !isset($postData["email"]) ||
    !filter_var($postData["email"], FILTER_VALIDATE_EMAIL) ||
    empty($postData["message"]) ||
    trim($postData["message"]) === ""
) { ?>
    <!DOCTYPE html>
    <html lang="fr">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Erreur - Formulaire</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>

    <body>
        <div class="container mt-4">
            <div class="alert alert-danger">
                <h4>Erreur !</h4>
                <p>Il faut un email et un message valides pour soumettre le formulaire.</p>
                <a href="contact.php" class="btn btn-primary">Retour au formulaire</a>
            </div>
        </div>
    </body>

    </html>
<?php return;
} elseif (
    !isset($_FILES["screenshot"]) ||
    !isset($_FILES["screenshot"]["error"]) ||
    $_FILES["screenshot"]["error"] !== 0 ||
    !isset($_FILES["screenshot"]["size"]) ||
    $_FILES["screenshot"]["size"] > MAX_FILE_SIZE ||
    !isset($_FILES["screenshot"]["type"]) ||
    !in_array($extension, ALLOWED_EXTENSIONS)
) { ?>
    <!DOCTYPE html>
    <html lang="fr">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Erreur - Formulaire</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <?php
    // Si la capture d'écran n'est pas valide, on affiche un message d'erreur
    ?>

    <body>
        <div class="container mt-4">
            <div class="alert alert-danger">
                <h4>Erreur !</h4>
                <p>Il faut une capture d'écran valide pour soumettre le formulaire.</p>
                <a href="contact.php" class="btn btn-primary">Retour au formulaire</a>
            </div>
        </div>
    </body>

    </html>
<?php return;
} else {
    // Protection : Générer un nom de fichier unique et sécurisé
    $safeName = uniqid('img_') . '.' . $extension;
    $uploadSuccess = false;

    if (
        isset($_FILES["screenshot"]) &&
        $_FILES["screenshot"]["error"] === 0
    ) {
        // Créer le dossier s'il n'existe pas
        if (!is_dir(UPLOAD_PATH)) {
            mkdir(UPLOAD_PATH, 0755, true);
        }

        // Déplacer le fichier avec le nom sécurisé
        if (move_uploaded_file($_FILES["screenshot"]["tmp_name"], UPLOAD_PATH . $safeName)) {
            $uploadSuccess = true;
        }
    }
?>

    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Site de Recettes - Contact reçu</title>
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
            rel="stylesheet">
    </head>

    <body>
        <div class="container">
            <?php require_once __DIR__ . "/header.php"; ?>
            <h1>Message bien reçu !</h1>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Rappel de vos informations</h5>
                    <p class="card-text"><b>Email</b> : <?php echo htmlspecialchars($postData["email"], ENT_QUOTES, 'UTF-8'); ?></p>
                    <p class="card-text"><b>Message</b> : <?php echo htmlspecialchars(strip_tags($postData["message"]), ENT_QUOTES, 'UTF-8'); ?></p>

                    <?php if ($uploadSuccess): ?>
                        <div class="mb-3">
                            <p class="card-text"><b>Fichier uploadé</b> : <?php echo htmlspecialchars($safeName, ENT_QUOTES, 'UTF-8'); ?></p>
                            <figure class="figure">
                                <img src="<?php echo htmlspecialchars('uploads/' . $safeName, ENT_QUOTES, 'UTF-8'); ?>"
                                    alt="<?php echo htmlspecialchars('Capture d\'écran - ' . (isset($fileinfo["filename"]) ? $fileinfo["filename"] : 'Image'), ENT_QUOTES, 'UTF-8'); ?>"
                                    class="img-fluid"
                                    style="max-width: 500px;">
                                <figcaption class="figure-caption">Votre capture d'écran</figcaption>
                            </figure>
                        </div>
                    <?php else: ?>
                        <div class="mb-3">
                            <p class="card-text text-warning"><b>Erreur</b> : Le fichier n'a pas pu être uploadé.</p>
                        </div>
                    <?php endif; ?>

                    <a href="contact.php" class="btn btn-primary">Retour au formulaire</a>
                </div>
            </div>
        </div>
    </body>

    </html>
<?php }
