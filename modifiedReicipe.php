<?php
if (session_start() === PHP_SESSION_NONE) {
    session_start();
}

include_once __DIR__ . '/authentification/authentificationVerif.php';
