<?php
// Récupération des recettes depuis la base de données
// Ce fichier ne gère PAS les sessions, il est juste inclus

require_once __DIR__ . '/config/database.php';

try {
    $pdo = getDatabaseConnection();
    $recipeStatement = $pdo->prepare("SELECT * FROM recipes WHERE is_enabled = 1");
    $recipeStatement->execute();
    $recipesFetched = $recipeStatement->fetchAll();
} catch (Exception $e) {
    // En cas d'erreur, on utilise un tableau vide
    error_log('Erreur récupération recettes: ' . $e->getMessage());
    $recipesFetched = [];
}
?>