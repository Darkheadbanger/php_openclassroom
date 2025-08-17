<?php

function checkAddRecipeLimit($userId, $action, $maxAttempts, $timeWindow)
{
    // $userId = id de l'utilisateur
    // $action = "add_recipe", "login", etc.
    // $maxAttempts = nombre maximum de tentatives autorisées
    // $timeWindow = période de temps pour les tentatives (en secondes)

    $key = "rate_limit_{$action}_{$userId}";

    // Récuperer les tentatives de l'utilisateur
    if (!isset($_SESSION[$key])) {
        $_SESSION[$key] = [];
    }

    $now = time();
    $attempts = $_SESSION[$key];

    // Nettoyer les anciennes tentatives (hors fenetre de temps)
    $attempts = array_filter($attempts, function ($timestamp) use ($now, $timeWindow) {
        return ($now - $timestamp) < $timeWindow;
    });

    // érifier si on dépasse la limite
    if (count($attempts) >= $maxAttempts) {
        return false; // Bloqué !
    }

    // Enregistrer la nouvelle tentative
    $attempts[] = $now;
    $_SESSION[$key] = $attempts;

    return true; // Limite non atteinte - AUTORISÉ
}
