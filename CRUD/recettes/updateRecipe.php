<?php
require_once __DIR__ . "/../../config/databaseConnect.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    try {
        $pdo = getDatabaseConnection();
        $updateStmt = $pdo->prepare("UPDATE recipes SET title = :title, description = :description WHERE id = :id");
        $result = $updateStmt->execute([
            'id' => $_GET['id'],
            'title' => $_POST['title'],
            'description' => $_POST['description']
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
