<?php
include_once __DIR__ . '/../../authentification/authentificationVerif.php';

// Inclusion du rate limiter
require_once __DIR__ . '/../../config/rateLimiter.php';
require_once __DIR__ . '/../../services/RecipeService.php';
// Traitement uniquement si formulaire soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Vérification rate limiting (100 recettes max par heure)
    rateLimitingValidation($userId, 'add_recipe', 100, 3600);

    // Vérification honeypot anti-bot
    require_once __DIR__ . '/../../assets/protection/protectionCsrfAndHoneypot.php';

    // Inclusion de la connexion BDD
    require_once __DIR__ . '/../../config/databaseConnect.php';

    try {
        // Récupération et validation des données
        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $author = $_SESSION['user']['email']; // Auteur = utilisateur connecté
        $is_enabled = isset($_POST['is_enabled']) ? 1 : 0;

        // Validation côté serveur
        serverValidation($title, $description, $author, $is_enabled);

        // Connexion BDD et insertion
        $pdo = getDatabaseConnection();

        $sqlQuery = 'INSERT INTO recipes (title, description, author, is_enabled, created_at) VALUES (:title, :description, :author, :is_enabled, NOW())';

        $stmt = $pdo->prepare($sqlQuery);
        $result = $stmt->execute([
            'title' => $title,
            'description' => $description,
            'author' => $author,
            'is_enabled' => $is_enabled
        ]);

        if ($result) {
            // Succès : redirection avec message
            error_log("Redirection vers recipe.php avec succès");
            header('Location: /php_openclassroom/recipe.php?success=1');
            exit;
        } else {
            throw new Exception('Erreur lors de l\'ajout de la recette.');
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
