// Main JavaScript file
document.addEventListener("DOMContentLoaded", function () {
  // Confirmation dialogs
  const deleteButtons = document.querySelectorAll("[data-confirm]");
  deleteButtons.forEach((button) => {
    button.addEventListener("click", function (e) {
      const message = this.getAttribute("data-confirm");
      if (!confirm(message)) {
        e.preventDefault();
      }
    });
  });

  // Auto-hide alerts
  const alerts = document.querySelectorAll(".alert");
  alerts.forEach((alert) => {
    setTimeout(() => {
      alert.style.opacity = "0";
      setTimeout(() => alert.remove(), 300);
    }, 5000);
  });

  // Form validation
  const forms = document.querySelectorAll("form[data-validate]");
  forms.forEach((form) => {
    form.addEventListener("submit", function (e) {
      const requiredFields = form.querySelectorAll("[required]");
      let isValid = true;

      requiredFields.forEach((field) => {
        if (!field.value.trim()) {
          isValid = false;
          field.style.borderColor = "var(--danger-color)";
        } else {
          field.style.borderColor = "var(--border-color)";
        }
      });

      if (!isValid) {
        e.preventDefault();
        alert("Please fill in all required fields");
      }
    });
  });
});

// Helper functions
function showAlert(message, type = "info") {
  const alert = document.createElement("div");
  alert.className = `alert alert-${type}`;
  alert.textContent = message;

  const container = document.querySelector(".container");
  if (container) {
    container.insertBefore(alert, container.firstChild);

    setTimeout(() => {
      alert.style.opacity = "0";
      setTimeout(() => alert.remove(), 300);
    }, 5000);
  }
}

function confirmAction(message) {
  return confirm(message);
}
