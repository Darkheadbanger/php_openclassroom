                <?php
                // Base de données - Recettes depuis la nouvelle structure CRUD
                $recipesAll = $recipesFetchedAll;
                $recipes = $recipesFetched;
                ?>
                <div class="recipe-list">
                    <?php foreach ($recipes as $recipe): ?>
                        <div class="recipe d-flex justify-content-between align-items-center p-3 mb-2 bg-primary text-white rounded">
                            <div class="d-flex flex-column">
                                <h2><?php echo htmlspecialchars(
                                        $recipe["title"]
                                    ); ?></h2>
                                <p><?php echo htmlspecialchars(
                                        $recipe["author"]
                                    ); ?></p>
                            </div>
                            <div class="d-flex">
                                <button class="btn btn-light btn-sm m-2">Voir la recette</button>
                                <button class="btn btn-warning btn-sm m-2"><a href="./modifiedReicipe.php?id=<?php echo htmlspecialchars(
                                                                                                                    $recipe["id"]
                                                                                                                ); ?>">Modifier</a></button>
                                <form action="../../CRUD/recettes/deleteReicipe.php" method="POST">
                                    <input type="hidden" id="id" name="id" value="<?php echo htmlspecialchars($recipe["id"]) ?>" />
                                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']) ?>" />
                                    <button class="btn btn-danger btn-sm m-2" id="delete_button">Supprimer</button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>