<?php
// Configuration de la base de données
// ⚠️ IMPORTANT : Ce fichier ne doit JAMAIS être accessible depuis le web
// Placez-le en dehors du dossier web ou protégez-le avec .htaccess

// Configuration de la base de données
const DB_CONFIG = [
    'host' => 'localhost',
    'dbname' => 'partage_de_recette',
    'username' => 'root',
    'password' => 'root', // Changez selon votre configuration WAMP
    'charset' => 'utf8mb4',
    'options' => [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]
];

// Fonction sécurisée pour obtenir la connexion PDO
function getDatabaseConnection()
{
    static $pdo = null;

    if ($pdo === null) {
        try {
            // Data source name (DSN)
            $dsn = sprintf(
                'mysql:host=%s;dbname=%s;charset=%s',
                DB_CONFIG['host'],
                DB_CONFIG['dbname'],
                DB_CONFIG['charset']
            );

            // Création de la connexion PDO (PHP Data Objects)
            $pdo = new PDO(
                $dsn,
                DB_CONFIG['username'],
                DB_CONFIG['password'],
                DB_CONFIG['options']
            );
        } catch (PDOException $e) {
            // En production, ne jamais afficher les détails de l'erreur
            error_log('Erreur de connexion BDD: ' . $e->getMessage());
            throw new Exception('Erreur de connexion à la base de données');
        }
    }

    return $pdo;
}
?>
