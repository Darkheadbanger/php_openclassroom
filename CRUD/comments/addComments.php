<?php

include_once __DIR__ . '/../../authentification/authentificationVerif.php';
require_once __DIR__ . '/../../config/rateLimiter.php';
// Traitement uniquement si le commentaire soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérification honeypot anti-bot
    require_once __DIR__ . '/../../assets/protection/protectionCsrfAndHoneypot.php';
    // Inclusion de la connexion BDD
    require_once __DIR__ . '/../../config/databaseConnect.php';

    try {
        // Récupération et validation des données
        $comment = trim($_POST['comment'] ?? '');
        $recipe_id = filter_input(INPUT_POST, 'recipe_id', FILTER_VALIDATE_INT);

        // Ajout ranking
        $ranking = filter_input(INPUT_POST, 'ranking', FILTER_VALIDATE_INT) ?? 0;

        // Validation côté serveur
        serverValidationComment($comment);

        if (!$recipe_id) {
            throw new Exception('ID de recette invalide.');
        }

        if ($ranking < 0 || $ranking > 5) {
            throw new Exception('Classement invalide. Doit être entre 0 et 5.');
        }

        checkAddRecipeLimit($_SESSION['user']['id'], "add_comment", 100, 3600);

        // Connexion BDD et insertion
        $pdo = getDatabaseConnection();

        $sqlQuery = 'INSERT INTO comments (comment, user_id, created_at, ranking, recipe_id) VALUES (:comment, :user_id, NOW(), :ranking, :recipe_id)';

        $stmt = $pdo->prepare($sqlQuery);
        $commentResult = $stmt->execute([
            'comment' => $comment,
            'user_id' => $_SESSION['user']['id'],
            'ranking' => $ranking,
            'recipe_id' => $recipe_id
        ]);

        if ($commentResult) {
            // Succès : redirection avec message
            error_log("Commentaire a été ajouté.");
            header('Location: /php_openclassroom/recipe.php?success=1');
            exit;
        } else {
            throw new Exception('Erreur lors de l\'ajout du commentaire.');
        }
    } catch (Exception $e) {
        // Erreur : redirection avec message d'erreur
        $error = urlencode($e->getMessage());
        header("Location: /php_openclassroom/recipe.php?error=$error");
        exit;
    }
} else {
    // Accès direct : redirection
    header('Location: /php_openclassroom/recipe.php');
    exit;
}
