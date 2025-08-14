<?php
session_start();

// Protection : Rediriger vers login si pas connecté
if (!isset($_SESSION['user']) || $_SESSION['user']['logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

// Base de données simulée - Recettes
include_once 'config/requetteRecipe.php';
$recipes = $recipesFetched;

// Utilisateurs pour afficher les auteurs
include_once 'requetteUsers.php';
$users = $usersFetched;

// Fonction pour récupérer seulement les recettes activées
function getRecipes($recipes)
{
    $resultRecipes = [];

    foreach ($recipes as $recipe) {
        if ($recipe['is_enabled'] === true) {
            $resultRecipes[] = $recipe;
        }
    }
    return $resultRecipes;
}

// Fonction pour afficher l'auteur
function displayAuthor($authorEmail, $users)
{
    foreach ($users as $user) {
        if ($user['email'] === $authorEmail) {
            return $user['full_name'] . ' (' . $user['age'] . ' ans)';
        }
    }

    return $authorEmail; // Si pas trouvé, afficher l'email
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recettes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-4">
        <?php include_once 'header.php'; ?>

        <div class="row">
            <div class="col-md-8">
                <h1>Nos délicieuses recettes</h1>
                <p>Bonjour <strong><?php echo htmlspecialchars($_SESSION['user']['email']); ?></strong> !</p>
                <p>Voici la liste de nos recettes disponibles :</p>

                <!-- Affichage des recettes -->
                <?php foreach (getRecipes($recipes) as $recipe) { ?>
                    <article class="card mb-4">
                        <div class="card-body">
                            <div>
                                <h3><?php echo htmlspecialchars($recipe['title']); ?></h3>
                                <p><?php echo nl2br(htmlspecialchars($recipe['description'])); ?></p>
                            </div>
                            <footer class="text-muted">
                                Par <?php echo htmlspecialchars(displayAuthor($recipe['author'], $users)); ?>
                            </footer>
                        </div>
                    </article>
                <?php } ?>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5>Navigation</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="contact.php" class="btn btn-info">Formulaire de contact</a>
                            <a href="login.php" class="btn btn-secondary">Retour au login</a>
                            <a href="logout.php" class="btn btn-danger">Se déconnecter</a>
                        </div>
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-header">
                        <h5>Statistiques</h5>
                    </div>
                    <div class="card-body">
                        <p><strong><?php echo count(getRecipes($recipes)); ?></strong> recettes disponibles</p>
                        <p>Connecté en tant que :<br>
                            <strong><?php echo htmlspecialchars($_SESSION['user']['email']); ?></strong>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>