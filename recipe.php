<?php
session_start();

// Protection : Rediriger vers login si pas connecté
if (!isset($_SESSION['user']) || $_SESSION['user']['logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

// Base de données simulée - Recettes
$recipes = [
    [
        'title' => 'Crêpes au chocolat',
        'recipe' => 'Mélanger la farine, les œufs et le lait. Ajouter le chocolat fondu. Cuire dans une poêle chaude.',
        'author' => 'test@example.com',
        'is_enabled' => true,
    ],
    [
        'title' => 'Salade César',
        'recipe' => 'Laver la salade, ajouter des croûtons, du parmesan et la sauce César. Mélanger délicatement.',
        'author' => 'admin@site.com',
        'is_enabled' => true,
    ],
    [
        'title' => 'Pasta Carbonara',
        'recipe' => 'Cuire les pâtes. Dans une poêle, faire revenir les lardons. Mélanger œufs et parmesan, ajouter aux pâtes chaudes.',
        'author' => 'test@example.com',
        'is_enabled' => true,
    ],
    [
        'title' => 'Tarte aux pommes',
        'recipe' => 'Préparer la pâte brisée. Éplucher et découper les pommes. Disposer sur la pâte et cuire 30min à 180°C.',
        'author' => 'admin@site.com',
        'is_enabled' => false, // Recette désactivée
    ],
];

// Utilisateurs pour afficher les auteurs
$users = [
    [
        'email' => 'test@example.com',
        'full_name' => 'David Bouhaben',
        'age' => 28,
    ],
    [
        'email' => 'admin@site.com',
        'full_name' => 'Marie Dupont',
        'age' => 35,
    ],
];

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
                            <h3 class="card-title"><?php echo htmlspecialchars($recipe['title']); ?></h3>
                            <div class="card-text">
                                <p><strong>Recette :</strong> <?php echo htmlspecialchars($recipe['recipe']); ?></p>
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