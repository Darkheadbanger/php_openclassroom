<?php
session_start();

// Protection d'authentification centralisée
include_once __DIR__ . '/authentification/authentificationVerif.php';

$loggedUser = isset($_COOKIE["LOGGED_USER"]) ? $_COOKIE["LOGGED_USER"] : null;

// Protection CSRF et Honeypot
include_once __DIR__ . '/../../assets/protection/protectionCsrfAndHoneypot.php';

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Profil</title>
</head>

<body>
    <div class="container mt-4">
        <?php include_once 'header.php'; ?>

        <h1>Mon Profil</h1>

        <?php if ($loggedUser) : ?>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Informations de connexion</h5>
                    <p class="card-text">
                        <strong>Email (depuis le cookie) :</strong>
                        <?php echo htmlspecialchars($loggedUser); ?>
                    </p>
                    <p class="card-text">
                        <strong>Email (depuis la session) :</strong>
                        <?php echo htmlspecialchars($_SESSION['user']['email']); ?>
                    </p>
                </div>
            </div>

            <div class="alert alert-info mt-3" role="alert">
                <strong>Note :</strong> Ces deux valeurs devraient être identiques.
                Le cookie persiste même après fermeture du navigateur (1 an),
                tandis que la session expire à la fermeture.
            </div>
        <?php else : ?>
            <div class="alert alert-warning" role="alert">
                <strong>Attention :</strong> Aucun cookie trouvé.
                Cela peut arriver si les cookies sont désactivés dans votre navigateur.
            </div>
        <?php endif; ?>

        <div class="mt-4">
            <a href="recipe.php" class="btn btn-primary">Retour aux recettes</a>
            <a href="logout.php" class="btn btn-danger">Se déconnecter</a>
        </div>
    </div>
</body>

</html>