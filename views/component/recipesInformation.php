<?php
// Base de données - Recettes depuis la nouvelle structure CRUD
$recipesAll = $recipesFetchedAll;
$recipes = $recipesFetched;
?>
<div>
    <div class="recipe-list">
        <?php foreach ($recipes as $recipe): ?>
            <!-- Container complet de la recette avec commentaires intégrés -->
            <div class="recipe-container mb-4 border rounded bg-white shadow-sm" data-recipe-id="<?php echo htmlspecialchars($recipe["id"]); ?>">

                <!-- En-tête de la recette -->
                <div class="recipe-header d-flex justify-content-between align-items-center p-3 bg-primary text-white rounded-top">
                    <div class="d-flex flex-column">
                        <h2 class="mb-1"><?php echo htmlspecialchars($recipe["title"]); ?></h2>
                        <p class="mb-0 opacity-75"><?php echo htmlspecialchars($recipe["author"]); ?></p>
                    </div>
                    <div class="d-flex gap-2">
                        <button class="btn btn-light btn-sm">Voir la recette</button>
                        <a href="./modifiedReicipe.php?id=<?php echo htmlspecialchars($recipe["id"]); ?>" class="btn btn-warning btn-sm">Modifier</a>

                        <form action="/php_openclassroom/CRUD/recettes/deleteRecipe.php" method="POST" class="d-inline">
                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($recipe["id"]) ?>" />
                            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']) ?>" />
                            <button class="btn btn-danger btn-sm delete-button" type="button">Supprimer</button>
                        </form>
                    </div>
                </div>

                <!-- Section commentaires intégrée -->
                <div class="recipe-comments p-3">
                    <?php
                    // Variables de contexte pour comments.php
                    $RECIPE_ID = $recipe["id"];
                    $RECIPE_TITLE = $recipe["title"];
                    // Inclusion des commentaires DANS le container de la recette
                    include __DIR__ . '/comments.php';
                    ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>