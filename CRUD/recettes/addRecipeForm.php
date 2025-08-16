<?php
// Formulaire d'ajout de recette
// Ce fichier contient UNIQUEMENT le HTML du formulaire
?>

<div class="card mt-4">
    <div class="card-header">
        <h5>➕ Ajouter une nouvelle recette</h5>
    </div>
    <div class="card-body">
        <form method="POST" action="CRUD/recettes/addRecipes.php" class="needs-validation" novalidate>
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
            <input type="hidden" name="author" value="<?php echo htmlspecialchars($_SESSION['user']['email']); ?>" />

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