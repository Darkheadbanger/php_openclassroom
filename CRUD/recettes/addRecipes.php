<?php

/**
 * Traitement d'ajout de recette
 * Ce fichier traite UNIQUEMENT les données POST du formulaire
 */

session_start();

// Protection : utilisateur connecté requis
if (!isset($_SESSION['user']) || !$_SESSION['user']['logged_in']) {
    header('Location: ../../login.php');
    exit;
}

// Traitement uniquement si formulaire soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Inclusion de la connexion BDD
    require_once __DIR__ . '/../../config/databaseConnect.php';

    try {
        // Récupération et validation des données
        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $author = $_SESSION['user']['email']; // Auteur = utilisateur connecté
        $is_enabled = isset($_POST['is_enabled']) ? 1 : 0;

        // Validation côté serveur
        if (empty($title) || empty($description)) {
            throw new Exception('Le titre et la description sont obligatoires.');
        }
        if( !is_string($author) || !is_int($is_enabled)){
            throw new Exception('Auteur ou statut invalide.');
        }
        if (strlen($title) > 255 || strlen($title) === 0 || strlen($description) === 0) {
            throw new Exception('Le titre ne peut pas dépasser 255 caractères et la description ne peut pas être vide.');
        }

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
            header('Location: ../../recipe.php?success=1');
            exit;
        } else {
            throw new Exception('Erreur lors de l\'ajout de la recette.');
        }
    } catch (Exception $e) {
        // Erreur : redirection avec message d'erreur
        $error = urlencode($e->getMessage());
        header("Location: ../../recipe.php?error=$error");
        exit;
    }
} else {
    // Accès direct : redirection
    header('Location: ../../recipe.php');
    exit;
}
