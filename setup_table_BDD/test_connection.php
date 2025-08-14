<?php
/**
 * Test de connexion à la base de données en ligne de commande
 * Usage: php cli_test_connection.php
 */

// Vérifier qu'on est bien en ligne de commande
if (php_sapi_name() !== 'cli') {
    die("❌ Ce script doit être exécuté en ligne de commande uniquement!\n");
}

echo "🔌 Test de connexion à la base de données\n";
echo "========================================\n\n";

try {
    require_once __DIR__ . '/config/database.php';
    
    $pdo = getDatabaseConnection();
    echo "✅ Connexion PDO réussie\n";
    
    // Test d'une requête simple
    $stmt = $pdo->query("SELECT 1 as test, NOW() as current_time, VERSION() as mysql_version");
    $result = $stmt->fetch();
    
    echo "🔗 Serveur MySQL: " . $result['mysql_version'] . "\n";
    echo "🕒 Heure MySQL: " . $result['current_time'] . "\n";
    
    // Test des tables
    echo "\n📋 Vérification des tables...\n";
    
    $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
    
    if (empty($tables)) {
        echo "⚠️  Aucune table trouvée. Exécutez d'abord:\n";
        echo "   php cli_setup_database.php\n\n";
    } else {
        // Implode means to join array elements into a string
        echo "✅ Tables trouvées: " . implode(', ', $tables) . "\n";
        
        // Compter les données
        foreach ($tables as $table) {
            $count = $pdo->query("SELECT COUNT(*) FROM `$table`")->fetchColumn();
            echo "   📊 $table: $count enregistrements\n";
        }
    }
    
    echo "\n🎉 Tout fonctionne parfaitement !\n";
    
} catch (Exception $e) {
    echo "❌ ERREUR de connexion:\n";
    echo "━━━━━━━━━━━━━━━━━━━━━━━\n";
    echo $e->getMessage() . "\n\n";
    echo "🔧 Solutions:\n";
    echo "   1. Vérifiez que WAMP est démarré\n";
    echo "   2. Créez la base 'partage_de_recette' dans phpMyAdmin\n";
    echo "   3. Vérifiez config/database.php\n\n";
    exit(1);
}
?>
