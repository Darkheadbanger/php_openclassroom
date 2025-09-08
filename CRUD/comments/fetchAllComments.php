<?php
// Récupération des commentaires depuis la base de données
// Ce fichier ne gère PAS les sessions, il est juste inclus

require_once __DIR__ . '/../../config/databaseConnect.php';

try {
    $pdo = getDatabaseConnection();
    $commentStatement = $pdo->prepare("
    SELECT c.*, u.email as author_email
    FROM comments c
    LEFT JOIN users u ON c.author_id = u.id
    ORDER BY c.created_at DESC");
    $commentStatement->execute();
    $commentsFetchedAll = $commentStatement->fetchAll();
} catch (Exception $e) {
    // En cas d'erreur, on utilise un tableau vide
    error_log('Erreur récupération commentaires: ' . $e->getMessage());
    $commentsFetchedAll = [];
}
