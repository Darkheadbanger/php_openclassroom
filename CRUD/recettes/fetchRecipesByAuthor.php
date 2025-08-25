<?php
require_once __DIR__ . '/../../config/databaseConnect.php';

// Exemple concret avec marqueurs PDO
try {
    $pdo = getDatabaseConnection();

    if (isset($recipeId) && $recipeId) {
        // On cherche une recette spécifique
        $sqlQuery = "SELECT id, title, author FROM recipes WHERE is_enabled = 1 AND author = :author AND id = :id";
        $recipeStatement = $pdo->prepare($sqlQuery);
        $recipeStatement->execute([
            'author' =>
            $_SESSION['user']['email'],
            'id' => $recipeId
        ]);
        $existingRecipe = $recipeStatement->fetch() ?: [];
        $recipesFetched = [$existingRecipe];
    } else {
        // Si pas d'ID, on récupère toutes les recettes de l'auteur
        $sqlQuery = "SELECT id, title, author FROM recipes WHERE is_enabled = 1 AND author = :author";
        $recipeStatement = $pdo->prepare($sqlQuery);
        $recipeStatement->execute(['author' => $_SESSION['user']['email']]);
        $recipesFetched = $recipeStatement->fetchAll();
    }
} catch (Exception $e) {
    // En cas d'erreur, on utilise un tableau vide
    error_log('Erreur récupération recettes: ' . $e->getMessage());
    $recipesFetched = [];
    $existingRecipe = [];
}
