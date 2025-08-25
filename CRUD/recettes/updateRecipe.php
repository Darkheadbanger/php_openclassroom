<?php
require_once __DIR__ . "/../../config/databaseConnect.php";

try {
    $pdo = getDatabaseConnection();
    $updateStmt = $pdo->prepare("UPDATE recipes SET titre = :title, recipes = :description WHERE id = :id");
    $updateStmt->execute([
        'id' => $_GET['id'],
        'title' => $_POST['title'],
        'description' => $_POST['description']
    ]);
    $recipe = $updateStmt->fetch(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    error_log($e->getMessage());
    http_response_code(500);
    echo json_encode(["error" => "Une erreur est survenue lors de la mise à jour de la recette."]);
}
