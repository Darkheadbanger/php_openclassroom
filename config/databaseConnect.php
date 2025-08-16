<?php
include_once __DIR__ . '/mysql.php';

// Configuration de la base de données
// ⚠️ IMPORTANT : Ce fichier ne doit JAMAIS être accessible depuis le web
// Placez-le en dehors du dossier web ou protégez-le avec .htaccess

// Fonction sécurisée pour obtenir la connexion PDO
function getDatabaseConnection()
{
    static $pdo = null;

    if ($pdo === null) {
        try {
            // Data source name (DSN)
            $dsn = sprintf(
                'mysql:host=%s;dbname=%s;charset=%s',
                DB_HOST,
                DB_NAME,
                DB_CHARSET
            );

            // Création de la connexion PDO (PHP Data Objects)
            $pdo = new PDO(
                $dsn,
                DB_USERNAME,
                DB_PASSWORD,
                DB_OPTIONS
            );
        } catch (PDOException $e) {
            // En production, ne jamais afficher les détails de l'erreur
            error_log('Erreur de connexion BDD: ' . $e->getMessage());
            throw new Exception('Erreur de connexion à la base de données');
        }
    }

    return $pdo;
}
