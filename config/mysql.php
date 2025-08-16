<?php
// Configuration de la base de données

const DB_HOST = 'localhost';
const DB_NAME = 'partage_de_recette';
const DB_USERNAME = 'root';
const DB_PASSWORD = 'root'; // Changez selon votre configuration WAMP
const DB_CHARSET = 'utf8mb4';

const DB_OPTIONS = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];
