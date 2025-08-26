<?php

include_once __DIR__ . '/../../authentification/authentificationVerif.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    include_once __DIR__ . '/../../assets/protection/contentSecurityPolicy.php';
    include_once __DIR__ . '/../../assets/protection/protectionCsrfAndHoneypot.php';

    include_once __DIR__ . '/../../config/databaseConnect.php';

    $recipeId = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    
    if (!$recipeId) {
        header('Location: /php_openclassroom/recipe.php?error=' . urlencode('ID invalide'));
        exit;
    }

    try {
        $pdo = getDatabaseConnection();
        $stmtDelete = $pdo->prepare("DELETE FROM recipes WHERE id = :id AND author = :author");
        $result = $stmtDelete->execute([
            'id' => $recipeId,  // ✅ Utiliser la variable validée
            'author' => $_SESSION['user']['email']
        ]);

        if ($result) {
            header('Location: /php_openclassroom/recipe.php?success=' . urlencode('Recette supprimée avec succès'));
        } else {
            header('Location: /php_openclassroom/recipe.php?error=' . urlencode('Erreur lors de la suppression'));
        }
    } catch (Exception $e) {
        $error = urlencode($e->getMessage());
        header('Location: /php_openclassroom/recipe.php?error=' . $error);
        exit;
    }
} else {
    // Accès direct interdit
    header('Location: /php_openclassroom/recipe.php');
    exit;
}
