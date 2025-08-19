<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once __DIR__ . '/../../authentification/authentificationVerif.php';
include_once __DIR__ . '/../../config/databaseConnect.php';

try {
    $pdo = getDatabaseConnection();
    // Préparation de la requête pour récupérer l'ID de l'utilisateur
    $getIdStatement = $pdo->prepare("SELECT id FROM users WHERE email = :email");
    $getIdStatement->bindParam(':email', $_SESSION['user']['email']);
    $getIdStatement->execute();
    $userId = $getIdStatement->fetchColumn();
} catch (Exception $e) {
    // En cas d'erreur, on utilise un tableau vide
    error_log('Erreur récupération ID utilisateur: ' . $e->getMessage());
    $userId = null;
}
