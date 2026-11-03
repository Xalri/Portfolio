// The search box and the type filters of /projects

const label = document.querySelector("label.search-tags-label");
const searchTagsContainer = document.querySelector(".search-tags-container");

label.addEventListener("click", () => {
  searchTagsContainer.classList.toggle("show");
});

document.addEventListener("click", (event) => {
  if (!searchTagsContainer.contains(event.target)) {
    searchTagsContainer.classList.remove("show");
  }
});

// Slides the cards from their old place to their new one when the filter changes
function animateReorder(container) {
  const cards = Array.from(container.children);
  const firstRects = new Map();

  cards.forEach((card) => {
    firstRects.set(card, card.getBoundingClientRect());
  });

  requestAnimationFrame(() => {
    cards.forEach((card) => {
      const first = firstRects.get(card);
      const last = card.getBoundingClientRect();
      const dx = first.left - last.left;
      const dy = first.top - last.top;

      if (dx !== 0 || dy !== 0) {
        card.style.transform = `translate(${dx}px, ${dy}px)`;
        card.style.transition = "transform 0s";

        requestAnimationFrame(() => {
          card.style.transform = "";
          card.style.transition = "transform 0.4s ease";
        });
      }
    });
  });
}

// Shows the cards matching one of the selected types (all when none is) and the search
function filterProjects() {
  const container = document.getElementById("list");
  animateReorder(container);

  const activeTags = Array.from(document.querySelectorAll(".search-tags .tag.selected"), (tag) =>
    tag.textContent.trim()
  );
  const searchInput = document.getElementById("search-input").value.toLowerCase();

  container.querySelectorAll(".project-card").forEach((card) => {
    const cardTags = (card.dataset.tags || "").split(",");
    const cardTitle = card.querySelector("h3").innerText.toLowerCase();
    const show =
      (activeTags.length === 0 || activeTags.some((tag) => cardTags.includes(tag))) &&
      (searchInput === "" || cardTitle.includes(searchInput));
    card.classList.toggle("hidden", !show);
  });
}

document.querySelectorAll(".search-tags .tag").forEach((tag) => {
  tag.addEventListener("click", () => {
    tag.classList.toggle("selected");
    filterProjects();
  });
});

document.getElementById("search-input").addEventListener("input", filterProjects);
