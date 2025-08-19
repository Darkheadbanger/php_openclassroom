<?php
require_once __DIR__ . '/../../config/databaseConnect.php';

// Exemple concret avec marqueurs PDO
try {
    $pdo = getDatabaseConnection();

    // ✅ Requête sécurisée avec marqueurs
    $sqlQuery = "SELECT id, title, author FROM recipes WHERE is_enabled = 1";
    $recipeStatement = $pdo->prepare($sqlQuery);
    $recipeStatement->execute();

    $recipesFetched = $recipeStatement->fetchAll();
} catch (Exception $e) {
    // En cas d'erreur, on utilise un tableau vide
    error_log('Erreur récupération recettes: ' . $e->getMessage());
    $recipesFetched = [];
}
