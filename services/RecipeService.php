<?php

/**
 * Service de gestion des recettes
 * Contient la logique métier réutilisable
 */

function limitRate($userId, $action, $maxAttempts, $time)
{
    // Vérification rate limiting
    if (!checkAddRecipeLimit($userId, $action, $maxAttempts, $time)) {
        $error = urlencode("Limite de $maxAttempts $action par heure atteinte. Veuillez patienter.");
        header("Location: /php_openclassroom/recipe.php?error=$error");
        exit;
    }
}

function rateLimitingValidation($userId, $action, $maxAttempts, $timeWindow)
{
    // Vérification rate limiting réutilisable
    if (!checkAddRecipeLimit($userId, $action, $maxAttempts, $timeWindow)) {
        $actionText = $action === 'add_recipe' ? 'recettes' : 'modifications';
        $error = urlencode("Limite de $maxAttempts $actionText par heure atteinte. Veuillez patienter.");
        header("Location: /php_openclassroom/recipe.php?error=$error");
        exit;
    }
}

function serverValidation($title, $description, $author, $is_enabled)
{
    // Validation côté serveur
    if (empty($title) || empty($description)) {
        throw new Exception('Le titre et la description sont obligatoires.');
    }
    if (!is_string($author) || !is_int($is_enabled)) {
        throw new Exception('Auteur ou statut invalide.');
    }
    if (strlen($title) > 255 || strlen($title) === 0 || strlen($description) === 0) {
        throw new Exception('Le titre ne peut pas dépasser 255 caractères et la description ne peut pas être vide.');
    }
}
