<?php
// Formulaire d'ajout de recette
// Ce fichier contient UNIQUEMENT le HTML du formulaire

// Protection d'authentification (requis pour accéder au formulaire)
include_once __DIR__ . '/../../authentification/authentificationVerif.php';

// CSP complet pour Bootstrap + sécurité
header("Content-Security-Policy: " .
    "default-src 'self'; " .
    "style-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net; " .
    "script-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net; " .
    "font-src 'self' https://fonts.gstatic.com; " .
    "img-src 'self' data:; " .
    "connect-src 'self'"
);

// Générer token CSRF si pas encore fait
if (empty($_SESSION["csrf_token"])) {
    $_SESSION["csrf_token"] = bin2hex(random_bytes(16));
}

if (!empty($_POST['honeypot'])) {
    die('🤖 Bot détecté !');
}
?>

<div class="card mt-4">
    <div class="card-header">
        <h5>➕ Ajouter une nouvelle recette</h5>
    </div>
    <div class="card-body">
        <form method="POST" action="CRUD/recettes/addRecipes.php" class="needs-validation" novalidate>
            <!-- Token CSRF pour la sécurité -->
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
            <input type="text" name="honeypot" style="display:none;" tabindex="-1" autocomplete="off">
            <!-- Titre de la recette -->
            <div class="mb-3">
                <label for="title" class="form-label">Titre de la recette</label>
                <input
                    type="text"
                    class="form-control"
                    id="title"
                    name="title"
                    required
                    maxlength="255"
                    placeholder="Ex: Tarte aux pommes de grand-mère">
                <div class="invalid-feedback">
                    Veuillez saisir un titre pour votre recette.
                </div>
            </div>

            <!-- Description/Instructions -->
            <div class="mb-3">
                <label for="description" class="form-label">Instructions</label>
                <textarea
                    class="form-control"
                    id="description"
                    name="description"
                    rows="6"
                    required
                    placeholder="Décrivez les étapes de préparation de votre recette..."></textarea>
                <div class="invalid-feedback">
                    Veuillez décrire les instructions de votre recette.
                </div>
            </div>

            <!-- Auteur (automatique selon l'utilisateur connecté) -->
            <!-- Note: L'email n'est pas visible dans le HTML pour plus de sécurité -->
            <input type="hidden" name="author" value="<?php echo htmlspecialchars($_SESSION['user']['email']); ?>" />

            <!-- Affichage sécurisé pour l'utilisateur -->
            <div class="mb-3">
                <small class="text-muted">
                    📝 Recette publiée par : <strong><?php echo htmlspecialchars($_SESSION['user']['email']); ?></strong>
                </small>
            </div>

            <!-- Statut (activée par défaut) -->
            <div class="mb-3 form-check">
                <input
                    type="checkbox"
                    class="form-check-input"
                    id="is_enabled"
                    name="is_enabled"
                    value="1"
                    checked>
                <label class="form-check-label" for="is_enabled">
                    Publier immédiatement cette recette
                </label>
            </div>

            <!-- Boutons -->
            <div class="d-flex justify-content-between">
                <button type="button" class="btn btn-secondary" id="cancelButton">
                    Annuler
                </button>
                <button type="submit" class="btn btn-success">
                    ➕ Ajouter la recette
                </button>
            </div>
        </form>
    </div>
</div>