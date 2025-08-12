<?php
// En-tête simple pour le site
// Demarrer la session si elle n'est pas déjà démarrée
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$isUserLoggedIn = isset($_SESSION['user']) && $_SESSION['user']['logged_in'] === true;
?>
<header class="mb-4">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="index.php">Mon Site PHP</a>
            <div class="navbar-nav">
                <a class="nav-link" href="index.php">Accueil</a>
                <a class="nav-link" href="contact.php">Contact</a>
                <a class="nav-link" href="bonjour.php">Bonjour</a>
                <?php if ($isUserLoggedIn) { ?>
                    <a class="nav-link" href="profil.php">Mon Profil</a>
                    <a class="nav-link" href="logout.php">Se déconnecter</a>
                <?php } ?>
            </div>
        </div>
    </nav>
</header>