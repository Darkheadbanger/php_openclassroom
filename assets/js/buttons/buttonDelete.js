(() => {
  "use strict";
  window.addEventListener(
    "DOMContentLoaded",
    () => {
      deleteButtonDanger();
    },
    false
  );
})();

const deleteButtonDanger = () => {
  // Sélectionner TOUS les boutons de suppression
  const deleteButtons = document.querySelectorAll(".delete-button");
  
  deleteButtons.forEach(deleteButton => {
    deleteButton.addEventListener("click", (event) => {
      event.preventDefault();
      
      // Récupérer l'ID de cette recette spécifique
      const recipeContainer = deleteButton.closest("[data-recipe-id]");
      const recipeId = recipeContainer.getAttribute("data-recipe-id");
      
      const confirmation = confirm(
        `Dangereux ! Êtes vous sûr de vouloir supprimer la recette #${recipeId} ?`
      );
      
      if (confirmation) {
        const form = deleteButton.closest("form");
        form.submit();
        
        // Optionnel : Supprimer visuellement du DOM pour UX fluide
        // recipeContainer.remove();
      }
    });
  });
};
