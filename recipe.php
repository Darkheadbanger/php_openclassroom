<?php
session_start();

// Protection : Rediriger vers login si pas connecté
if (!isset($_SESSION['user']) || $_SESSION['user']['logged_in'] !== true) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recettes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-4">
        <h1>Page des Recettes</h1>
        <p>Bonjour <strong><?php echo htmlspecialchars($_SESSION['user']['email']); ?></strong> !</p>
        <p>Bienvenue sur votre espace recettes.</p>
        
        <div class="mt-3">
            <a href="logout.php" class="btn btn-danger">Se déconnecter</a>
        </div>
    </div>
</body>

</html>