// Sends the contact form in the background and shows the result as a toast

document.getElementById("contact-form").addEventListener("submit", async function (event) {
  event.preventDefault();
  const form = event.target;

  try {
    const response = await fetch(form.action, {
      method: "POST",
      body: new FormData(form),
    });
    const result = await response.json();

    if (result.status === "success") {
      showToast("Email sent successfully!", "success");
    } else {
      showToast(result.message, "error");
    }
  } catch (error) {
    showToast("An error occurred. Please try again.", "error");
  }
});

function showToast(message, type) {
  const toast = document.createElement("div");
  toast.className = `toast ${type}`;
  toast.textContent = message;
  document.body.appendChild(toast);

  setTimeout(() => {
    toast.classList.add("hide");
    toast.addEventListener("transitionend", () => toast.remove());
  }, 3000);
}
