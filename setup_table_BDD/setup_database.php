<?php
/**
 * Script de création des tables et données de test
 * Usage: php cli_setup_database.php
 * 
 * Ce script peut être exécuté directement depuis le terminal
 */

// Vérifier qu'on est bien en ligne de commande
if (php_sapi_name() !== 'cli') {
    die("❌ Ce script doit être exécuté en ligne de commande uniquement!\n");
}

echo "🏗️  Initialisation de la base de données...\n";
echo "=====================================\n\n";

try {
    // Inclusion de la configuration
    require_once __DIR__ . '/config/database.php';
    
    $pdo = getDatabaseConnection();
    echo "✅ Connexion à la base de données réussie\n";
    
    // 1. Création de la table users
    echo "\n📋 Création de la table 'users'...\n";
    $createUsers = "
    CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        email VARCHAR(255) NOT NULL UNIQUE,
        full_name VARCHAR(255) NOT NULL,
        age INT NOT NULL,
        password VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ";
    
    $pdo->exec($createUsers);
    echo "✅ Table 'users' créée avec succès\n";
    
    // 2. Création de la table recipes
    echo "\n🍽️  Création de la table 'recipes'...\n";
    $createRecipes = "
    CREATE TABLE IF NOT EXISTS recipes (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        description TEXT NOT NULL,
        author VARCHAR(255) NOT NULL,
        is_enabled BOOLEAN DEFAULT TRUE,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ";
    
    $pdo->exec($createRecipes);
    echo "✅ Table 'recipes' créée avec succès\n";
    
    // 3. Insertion d'utilisateurs de test
    echo "\n👥 Ajout des utilisateurs de test...\n";
    $insertUsers = "
    INSERT IGNORE INTO users (email, full_name, age, password) VALUES 
    ('test@example.com', 'David Bouhaben', 28, :password1),
    ('admin@site.com', 'Marie Dupont', 35, :password2);
    ";
    
    $stmt = $pdo->prepare($insertUsers);
    $result = $stmt->execute([
        'password1' => password_hash('123456', PASSWORD_DEFAULT),
        'password2' => password_hash('admin123', PASSWORD_DEFAULT)
    ]);
    
    if ($result) {
        echo "✅ Utilisateurs de test ajoutés\n";
        echo "   • test@example.com (mot de passe: 123456)\n";
        echo "   • admin@site.com (mot de passe: admin123)\n";
    }
    
    // 4. Insertion de recettes de test
    echo "\n🍽️  Ajout des recettes de test...\n";
    $insertRecipes = "
    INSERT IGNORE INTO recipes (title, description, author, is_enabled) VALUES 
    ('Crêpes au chocolat', 'Mélanger la farine, les œufs et le lait. Ajouter le chocolat fondu. Cuire dans une poêle chaude.', 'test@example.com', 1),
    ('Salade César', 'Laver la salade, ajouter des croûtons, du parmesan et la sauce César. Mélanger délicatement.', 'admin@site.com', 1),
    ('Pasta Carbonara', 'Cuire les pâtes. Dans une poêle, faire revenir les lardons. Mélanger œufs et parmesan, ajouter aux pâtes chaudes.', 'test@example.com', 1),
    ('Tarte aux pommes', 'Préparer la pâte brisée. Éplucher et découper les pommes. Disposer sur la pâte et cuire 30min à 180°C.', 'admin@site.com', 0);
    ";
    
    $pdo->exec($insertRecipes);
    echo "✅ Recettes de test ajoutées\n";
    
    // 5. Vérification des données créées
    echo "\n📊 Vérification des données...\n";
    
    $userCount = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
    $recipeCount = $pdo->query("SELECT COUNT(*) FROM recipes")->fetchColumn();
    
    echo "👥 Utilisateurs dans la BDD: {$userCount}\n";
    echo "🍽️  Recettes dans la BDD: {$recipeCount}\n";
    
    echo "\n" . str_repeat("=", 50) . "\n";
    echo "🎉 BASE DE DONNÉES INITIALISÉE AVEC SUCCÈS !\n";
    echo str_repeat("=", 50) . "\n";
    echo "\n💡 Vous pouvez maintenant :\n";
    echo "   • Tester la connexion avec: php test_connection.php\n";
    echo "   • Lancer votre serveur WAMP et aller sur login.php\n";
    echo "   • Vous connecter avec test@example.com / 123456\n\n";
    
} catch (Exception $e) {
    echo "\n❌ ERREUR lors de l'initialisation :\n";
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
    echo $e->getMessage() . "\n\n";
    echo "🔧 Vérifications à faire :\n";
    echo "   1. WAMP est-il démarré et vert ?\n";
    echo "   2. La base 'partage_de_recette' existe-t-elle ?\n";
    echo "   3. Les paramètres dans config/database.php sont-ils corrects ?\n\n";
    exit(1);
}
?>
