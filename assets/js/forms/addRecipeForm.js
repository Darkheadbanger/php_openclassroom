// Validation Bootstrap côté client
(() => {
  "use strict";
  window.addEventListener(
    "load",
    () => {
      addButton();
      cancelButton();
    },
    false
  );
})();
// Solution simple: boucle for classique sur HTMLCollection
let formCache = [];
const getForms = () => {
  if (!formCache.length) {
    formCache = Array.from(document.getElementsByClassName("needs-validation"));
  }
  return formCache;
};

function addButton() {
  // Récupérer les formulaires à chaque fois (toujours frais)
  const forms = getForms();

  // Parcourir chaque formulaire individuellement
  forms.forEach((form) => {
    form.addEventListener(
      "submit",
      function (event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        } else {
          event.stopPropagation();
          fetch(form.action, {
            method: "POST",
            body: new FormData(form),
          })
            .then((response) => {
              if (response.ok) {
                // Traitement en cas de succès
                console.log("Recette ajoutée avec succès !");
              } else {
                // Traitement en cas d'erreur
                console.error("Erreur lors de l'ajout de la recette.");
              }
            })
            .catch((error) => {
              console.error("Erreur réseau :", error);
            });
        }
      },
      false
    );
  });
}

function cancelButton() {
  // Trouver le bouton Cancel
  let cancelButton = document.getElementById("cancelButton");
  if (cancelButton) {
    cancelButton.addEventListener("click", () => {
      form.reset(); // Réinitialiser le formulaire
      // Optionnel : retirer la validation Bootstrap
      form.classList.remove("was-validated");

      // Remove error classe from all fields
      let inputs = form.querySelectorAll(".form-control");
      inputs.forEach((input) =>
        input.classList.remove("is-invalid", "is-valid")
      );
    });
  }
}
