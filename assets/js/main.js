// Main JavaScript file for Job Portal

// Form validation
function validateForm(formId) {
  const form = document.getElementById(formId);
  const inputs = form.querySelectorAll(
    "input[required], textarea[required], select[required]"
  );

  for (let input of inputs) {
    if (!input.value.trim()) {
      alert("Please fill in all required fields");
      input.focus();
      return false;
    }
  }

  return true;
}

// Confirm action
function confirmAction(message) {
  return confirm(message);
}

// Show alert message
function showAlert(message, type) {
  const alertDiv = document.createElement("div");
  alertDiv.className = `alert alert-${type}`;
  alertDiv.textContent = message;

  const container = document.querySelector(".container");
  container.insertBefore(alertDiv, container.firstChild);

  setTimeout(() => {
    alertDiv.remove();
  }, 3000);
}
