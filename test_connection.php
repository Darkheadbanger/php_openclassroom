<?php
// Test rapide de connexion BDD
require_once __DIR__ . '/config/database.php';

echo "<h2>🔌 Test de connexion à la base de données</h2>";

try {
    $pdo = getDatabaseConnection();
    echo "<div style='color: green; padding: 10px; border: 1px solid green; margin: 10px 0;'>";
    echo "✅ <strong>Connexion réussie !</strong><br>";
    echo "📊 Base de données : partage_de_recettes<br>";
    echo "🔗 MySQL connecté via PDO<br>";
    echo "</div>";
    
    // Test d'une requête simple
    $stmt = $pdo->query("SELECT 1 as test, NOW() as current_time");
    $result = $stmt->fetch();
    
    echo "<div style='color: blue; padding: 10px; border: 1px solid blue; margin: 10px 0;'>";
    echo "🧪 <strong>Test de requête :</strong><br>";
    echo "Heure MySQL : " . $result['current_time'] . "<br>";
    echo "</div>";
    
} catch (Exception $e) {
    echo "<div style='color: red; padding: 10px; border: 1px solid red; margin: 10px 0;'>";
    echo "❌ <strong>Erreur :</strong><br>";
    echo htmlspecialchars($e->getMessage()) . "<br><br>";
    echo "<strong>Solutions :</strong><br>";
    echo "1. Vérifiez que WAMP est démarré (icône verte)<br>";
    echo "2. Créez la base 'partage_de_recettes' dans phpMyAdmin<br>";
    echo "3. Vérifiez le mot de passe dans config/database.php<br>";
    echo "</div>";
}

echo "<hr>";
echo "<a href='login.php'>Retour au login</a> | ";
echo "<a href='recipe.php'>Voir les recettes</a>";
?>
