// On phones, the project cards come in together with their container instead of one by one
document.addEventListener("DOMContentLoaded", function () {
  if (window.screen.width > 768) return;

  document.querySelector(".projects-container").classList.add("animate", "from-bottom");
  document.querySelectorAll(".project-card.animate.from-bottom").forEach((card) => {
    card.classList.remove("animate", "from-bottom");
  });
});
