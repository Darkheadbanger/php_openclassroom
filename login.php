<?php
session_start();

// Redirection automatique si déjà connecté
if (isset($_SESSION["user"]) && $_SESSION["user"]["logged_in"] === true) {
    header("location: recipe.php");
    exit;
}

// Utilisateurs factices pour le test
$users = [
    [
        'email' => 'test@example.com',
        'password' => password_hash('123456', PASSWORD_DEFAULT)
    ],
    [
        'email' => 'admin@site.com',
        'password' => password_hash('admin123', PASSWORD_DEFAULT)
    ]
];

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = htmlspecialchars(isset($_POST['email']) ? $_POST['email'] : '');
    $motDePasse = isset($_POST['password']) ? $_POST['password'] : '';
    $userFound = false;

    // Validation basique
    if (empty($email) || empty($motDePasse) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        include_once 'login_failed.php';
        exit;
    } else {
        // Rechercher l'utilisateur
        $userFound = false;
        foreach ($users as $user) {
            if ($user['email'] === $email && password_verify($motDePasse, $user['password'])) {
                // Utilisateur trouvé et mot de passe correct
                $_SESSION['user'] = [
                    'email' => $email,
                    'logged_in' => true
                ];
                
                // Créer un cookie sécurisé pour mémoriser l'utilisateur
                setcookie(
                    'LOGGED_USER',
                    $email,
                    [
                        'expires' => time() + 365*24*3600, // 1 an
                        'secure' => true,
                        'httponly' => true,
                    ]
                );
                
                $userFound = true;
                break;
            }
        }

        if ($userFound) {
            header('Location: recipe.php');
            exit;
        } else {
            header('Location: login_failed.php');
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Login</title>
</head>

<body>
    <?php include_once 'header.php'; ?>
    <div class="container d-flex justify-content-center flex-column">
        <h1 class="text-center mb-4"><b>Connexion</b></h1>
        <div class="container d-flex justify-content-center flex-column mx-auto" style="width: 500px;">
            <form action="login.php" method="POST">
                <div class="mb-3">
                    <label for="email" class="form-label">Email d'utilisateur:</label>
                    <input type="email" name="email" id="email" class="form-control" required />
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Mot de passe:</label>
                    <input type="password" name="password" id="password" class="form-control" required />
                </div>
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Se connecter</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>