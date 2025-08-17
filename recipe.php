<?php
session_start();

// Protection d'authentification centralisée
include_once __DIR__ . '/authentification/authentificationVerif.php';

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
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico">
    <script type="text/javascript" src="./assets/js/forms/addRecipeForm.js"></script>
    <script type="text/javascript" src="./assets/js/buttons/buttonOpenClosed.js"></script>
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

                <!-- Messages de succès/erreur -->
                <?php if (isset($_GET['success'])): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        ✅ Votre recette a été ajoutée avec succès !
                        <button type="button" class="btn-close sucess-close-button" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if (isset($_GET['error'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        ❌ Erreur : <?php echo htmlspecialchars($_GET['error']); ?>
                        <button type="button" class="btn-danger-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <!-- Formulaire d'ajout de recette -->
                <?php include_once './CRUD/recettes/addRecipeForm.php'; ?>

                <hr class="my-4">

                <h2>Liste des recettes disponibles :</h2>

                <!-- Affichage des recettes -->
                <?php
                // Base de données - Recettes depuis la nouvelle structure CRUD
                include_once './CRUD/recettes/fetchAllRecipes.php';
                include_once './CRUD/recettes/fetchTitleAndAuthorRecipes.php';
                $recipesAll = $recipesFetchedAll;
                $recipes = $recipesFetched;
                ?>
                <div class="recipe-list">
                    <?php foreach ($recipes as $recipe) : ?>
                        <div class="recipe d-flex justify-content-between align-items-center p-3 mb-2 bg-primary text-white rounded">
                            <div class="d-flex flex-column">
                                <h2><?php echo htmlspecialchars($recipe['title']); ?></h2>
                                <p><?php echo htmlspecialchars($recipe['author']); ?></p>
                            </div>
                            <div class="d-flex">
                                <button class="btn btn-light btn-sm m-2">Voir la recette</button>
                                <a href="" id="modifier <?php echo $recipe["id"] ?>"><button class="btn btn-warning btn-sm m-2">Modifier</button></a>
                                <button class="btn btn-danger btn-sm m-2">Supprimer</button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
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
                        <p><strong><?php echo count(getRecipes($recipesAll)); ?></strong> recettes disponibles</p>
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