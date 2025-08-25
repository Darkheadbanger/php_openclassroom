<?php

// Générer token CSRF si pas encore fait
if (empty($_SESSION["csrf_token"])) {
    $_SESSION["csrf_token"] = bin2hex(random_bytes(16));
}

if (!empty($_POST['honeypot'])) {
    die('🤖 Bot détecté !');
}
