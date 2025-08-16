<?php
require_once __DIR__ . '/../../config/databaseConnect.php';

// Exemple concret avec marqueurs PDO
try {
    $pdo = getDatabaseConnection();

    // ✅ Requête sécurisée avec marqueurs
    $sqlQuery = "SELECT title, author FROM recipes WHERE author = :author AND is_enabled = :is_enabled";
    $recipeStatement = $pdo->prepare($sqlQuery);

    // ✅ Exécution avec valeurs DYNAMIQUES selon les besoins

    // Cas 1 : Si on veut les recettes d'un auteur spécifique (depuis URL par exemple)
    $authorToSearch = $_GET["author"] ?? "davidbouhaben@yahoo.co.id";

    $recipeStatement->execute([
        "author" => $authorToSearch,
        "is_enabled" => true,
    ]);


    $recipesFetched = $recipeStatement->fetchAll();
} catch (Exception $e) {
    // En cas d'erreur, on utilise un tableau vide
    error_log('Erreur récupération recettes: ' . $e->getMessage());
    $recipesFetched = [];
}
