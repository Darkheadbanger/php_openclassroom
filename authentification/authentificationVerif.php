<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Vérification de l'authentification
if (!isset($_SESSION['user']) || !$_SESSION['user']['logged_in']) {
    http_response_code(401);
    echo 'Unauthorized access - Requête refusée';
    sleep(2); // Délai pour ralentir les attaques par force brute
    header('Location: ./login.php');
    exit();
}

// Validation du token CSRF
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        http_response_code(403);
        echo 'Invalid CSRF token - Requête refusée';
        sleep(2); // Délai pour ralentir les attaques par force brute
        header('Location: ./login.php');
        exit();
    }
}
