<?php
include_once __DIR__ . '/../../assets/protection/protectionCsrfAndHoneypot.php';
include_once __DIR__ . '/../../assets/protection/contentSecurityPolicy.php';

// Générer des IDs uniques
$uniqueId = 'comments-section-' . ($RECIPE_ID ?? 'default');
$textareaId = 'comment-textarea-' . ($RECIPE_ID ?? 'default');
?>

<!-- Section commentaires sans bordures supplémentaires -->
<div id="<?php echo htmlspecialchars($uniqueId); ?>" class="comments-section">
    <h6 class="border-bottom pb-2 mb-3">
        <i class="fas fa-comments"></i> Commentaires
    </h6>

    <!-- Formulaire de commentaire compact -->
    <form action="/php_openclassroom/CRUD/comments/addComment.php" method="POST" class="mb-3">
        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>" />
        <input type="text" name="honeypot" style="display:none;" tabindex="-1" autocomplete="off">
        <input type="hidden" name="recipe_id" value="<?php echo htmlspecialchars($RECIPE_ID ?? 0); ?>">

        <div class="d-flex gap-2">
            <textarea
                id="<?php echo htmlspecialchars($textareaId); ?>"
                name="comment"
                class="form-control form-control-sm"
                rows="1"
                placeholder="Ajouter un commentaire..."
                required
                maxlength="500"
                style="resize: none;"></textarea>
            <button type="submit" class="btn btn-primary btn-sm">
                Commenter
            </button>
        </div>
    </form>

    <!-- Placeholder pour les commentaires existants -->
    <div class="comments-list">
        <small class="text-muted">
            <i class="fas fa-comment-dots"></i>
            Aucun commentaire pour le moment
        </small>
    </div>
</div>