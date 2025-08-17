// Validation Bootstrap côté client
(() => {
  "use strict";
  window.addEventListener(
    "load",
    () => {
      openButton();
      closedSuccessButton();
    },
    false
  );
})();

openButton = () => {};

closedSuccessButton = () => {
  const closedButtons = document.querySelectorAll(".sucess-close-button");
  closedButtons.forEach((button) => {
    button.addEventListener("click", () => {
      const alert = button.closest(".alert");
      if (alert) {
        alert.remove();
      }
    });
  });
};
