<?php
// Récupération des utilisateurs depuis la base de données
// Ce fichier ne gère PAS les sessions, il est juste inclus

require_once __DIR__ . '/config/database.php';

try {
    $pdo = getDatabaseConnection();
    $usersStatement = $pdo->prepare("SELECT * FROM users ORDER BY created_at DESC");
    $usersStatement->execute();
    $usersFetched = $usersStatement->fetchAll();
} catch (Exception $e) {
    // En cas d'erreur, on utilise un tableau vide
    error_log('Erreur récupération utilisateurs: ' . $e->getMessage());
    $usersFetched = [];
}
?>