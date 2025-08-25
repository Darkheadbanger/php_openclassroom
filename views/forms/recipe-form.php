<?php
// Formulaire d'ajout de recette
// Ce fichier contient UNIQUEMENT le HTML du formulaire

// Protection d'authentification (requis pour accéder au formulaire)
include_once __DIR__ . '/../../authentification/authentificationVerif.php';
include_once __DIR__ . '/../../assets/protection/contentSecurityPolicy.php';
include_once __DIR__ . '/../../assets/protection/protectionCsrfAndHoneypot.php';

// ✅ Utiliser les variables de contexte définies par la page parente
$isEditMode = isset($FORM_MODE) && $FORM_MODE === 'edit';
$recipeId = $isEditMode ? $FORM_RECIPE_ID : null;
$existingRecipe = [];

// Si mode édition, récupérer les données existantes
if ($isEditMode && $recipeId) {
    include_once __DIR__ . '/../../CRUD/recettes/fetchRecipesByAuthor.php';

    if (empty($existingRecipe)) {
        echo '<div class="alert alert-danger">Recette non trouvée ou accès non autorisé.</div>';
        $isEditMode = false;
    }
}

$pageTitle = $isEditMode ? "Modifier la recette" : "Ajouter une nouvelle recette";
$actionUrl = $isEditMode ? "/php_openclassroom/CRUD/recettes/updateRecipes.php" : "/php_openclassroom/CRUD/recettes/addRecipes.php";
$submitText = $isEditMode ? "Modifier la recette" : "Ajouter une nouvelle recette";
$submitIcon = $isEditMode ? "✏️" : "➕";
$submitClass = $isEditMode ? "btn-warning" : "btn-success";

?>

<div class="card mt-4">
    <div class="card-header">
        <h5><?php echo htmlspecialchars($pageTitle); ?></h5>
    </div>
    <div class="card-body">
        <form method="POST" action="<?php echo htmlspecialchars($actionUrl); ?>" class="needs-validation" novalidate>
            <!-- Token CSRF pour la sécurité -->
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
            <input type="text" name="honeypot" style="display:none;" tabindex="-1" autocomplete="off">
            <!-- ID en mode édition -->
            <?php if ($isEditMode && $recipeId): ?>
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($recipeId); ?>">
            <?php endif; ?>
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
                    value="<?php echo htmlspecialchars($existingRecipe['title'] ?? ''); ?>"
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
                    placeholder="Décrivez les étapes de préparation de votre recette..."><?php echo htmlspecialchars($existingRecipe['description'] ?? ''); ?></textarea>
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
                    📝 Recette <?php echo $isEditMode ? "modifiée" : "ajoutée"; ?> par : <strong><?php echo htmlspecialchars($_SESSION['user']['email']); ?></strong>
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
                    <?php echo ($existingRecipe['is_enabled'] ?? 1) ? 'checked' : ''; ?>>
                <label class="form-check-label" for="is_enabled">
                    <?php echo $isEditMode ? "Mettre à jour" : "Publier"; ?> immédiatement cette recette
                </label>
            </div>

            <!-- Boutons -->
            <div class="d-flex justify-content-between">
                <button type="button" class="btn btn-secondary" id="cancelButton">
                    Annuler
                </button>
                <button type="submit" class="btn btn-<?php echo htmlspecialchars($submitClass); ?>">
                    <?php echo $submitIcon; ?> <?php echo htmlspecialchars($submitText); ?>
                </button>
            </div>
        </form>
    </div>
</div>