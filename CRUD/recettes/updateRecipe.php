<?php
include_once __DIR__ . '/../../authentification/authentificationVerif.php';

// Inclusion du rate limiter
require_once __DIR__ . '/../../config/rateLimiter.php';
require_once __DIR__ . '/../../services/RecipeService.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérification rate limiting (100 modifications max par heure)
    rateLimitingValidation($userId, 'update_recipe', 100, 3600);

    include_once __DIR__ . '/../../assets/protection/protectionCsrfAndHoneypot.php';

    require_once __DIR__ . "/../../config/databaseConnect.php";

    try {
        // Récupération et validation des données
        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $author = $_SESSION['user']['email']; // Auteur = utilisateur connecté
        $is_enabled = isset($_POST['is_enabled']) ? 1 : 0;
        // Validation côté serveur
        serverValidation($title, $description, $author, $is_enabled);
        $pdo = getDatabaseConnection();
        $updateStmt = $pdo->prepare("UPDATE recipes SET title = :title, description = :description WHERE id = :id");
        $result = $updateStmt->execute([
            'id' => $_POST['id'],           // ✅ Utiliser POST au lieu de GET
            'title' => $title,              // ✅ Utiliser les variables validées
            'description' => $description   // ✅ Utiliser les variables validées
        ]);

        if ($result) {
            // Succès : redirection avec message
            error_log("Redirection vers recipe.php avec succès");
            header('Location: /php_openclassroom/recipe.php?success=1');
            exit;
        } else {
            throw new Exception('Erreur lors de la mise à jour de la recette.');
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
