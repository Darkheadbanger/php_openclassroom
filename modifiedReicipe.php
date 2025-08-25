<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once __DIR__ . '/authentification/authentificationVerif.php';
$recipeId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$recipeId) {
    header('Location: recipe.php?error=' . urlencode('ID de recette invalide.'));
    exit;
}

$FORM_MODE = 'edit';
$FORM_RECIPE_ID = $recipeId;
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier vos recettes</title>
</head>

<body>
    <?php include_once './views/forms/recipe-form.php'; ?>
</body>

</html>