// Form Validation Script
document.addEventListener("DOMContentLoaded", function () {
  // Email validation
  function validateEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
  }

  // Password validation (min 8 chars, 1 uppercase, 1 lowercase, 1 number)
  function validatePassword(password) {
    const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/;
    return passwordRegex.test(password);
  }

  // Phone validation (basic format)
  function validatePhone(phone) {
    const phoneRegex = /^[\d\s\-\+\(\)]{10,}$/;
    return phoneRegex.test(phone);
  }

  // File validation
  function validateFile(file, allowedTypes, maxSize) {
    if (!file) return { valid: false, message: "Please select a file" };

    const fileType = file.type;
    const fileSize = file.size;

    if (!allowedTypes.includes(fileType)) {
      return {
        valid: false,
        message: `Invalid file type. Allowed: ${allowedTypes.join(", ")}`,
      };
    }

    if (fileSize > maxSize) {
      return {
        valid: false,
        message: `File size exceeds ${maxSize / (1024 * 1024)}MB`,
      };
    }

    return { valid: true };
  }

  // Show error message
  function showError(input, message) {
    const formGroup = input.closest(".form-group");
    let errorElement = formGroup.querySelector(".error-message");

    if (!errorElement) {
      errorElement = document.createElement("span");
      errorElement.className = "error-message";
      errorElement.style.color = "red";
      errorElement.style.fontSize = "0.875rem";
      errorElement.style.display = "block";
      errorElement.style.marginTop = "5px";
      formGroup.appendChild(errorElement);
    }

    errorElement.textContent = message;
    input.style.borderColor = "red";
  }

  // Clear error message
  function clearError(input) {
    const formGroup = input.closest(".form-group");
    const errorElement = formGroup.querySelector(".error-message");

    if (errorElement) {
      errorElement.textContent = "";
    }
    input.style.borderColor = "";
  }

  // Validate Registration Form
  const registerForm = document.querySelector(
    'form[action*="register"], form[action*="candidate&action=register"]'
  );
  if (registerForm) {
    const nameInput = registerForm.querySelector('input[name="name"]');
    const emailInput = registerForm.querySelector('input[name="email"]');
    const phoneInput = registerForm.querySelector('input[name="phone"]');
    const passwordInput = registerForm.querySelector('input[name="password"]');

    // Real-time validation
    if (emailInput) {
      emailInput.addEventListener("blur", function () {
        if (!validateEmail(this.value)) {
          showError(this, "Please enter a valid email address");
        } else {
          clearError(this);
        }
      });
    }

    if (passwordInput) {
      passwordInput.addEventListener("input", function () {
        const password = this.value;
        if (password.length > 0) {
          if (password.length < 8) {
            showError(this, "Password must be at least 8 characters");
          } else if (!/[A-Z]/.test(password)) {
            showError(
              this,
              "Password must contain at least one uppercase letter"
            );
          } else if (!/[a-z]/.test(password)) {
            showError(
              this,
              "Password must contain at least one lowercase letter"
            );
          } else if (!/\d/.test(password)) {
            showError(this, "Password must contain at least one number");
          } else {
            clearError(this);
          }
        }
      });
    }

    if (phoneInput) {
      phoneInput.addEventListener("blur", function () {
        if (this.value && !validatePhone(this.value)) {
          showError(this, "Please enter a valid phone number");
        } else {
          clearError(this);
        }
      });
    }

    // Form submission validation
    registerForm.addEventListener("submit", function (e) {
      let isValid = true;

      // Validate name
      if (nameInput && nameInput.value.trim().length < 2) {
        showError(nameInput, "Name must be at least 2 characters");
        isValid = false;
      }

      // Validate email
      if (emailInput && !validateEmail(emailInput.value)) {
        showError(emailInput, "Please enter a valid email address");
        isValid = false;
      }

      // Validate phone
      if (phoneInput && phoneInput.value && !validatePhone(phoneInput.value)) {
        showError(phoneInput, "Please enter a valid phone number");
        isValid = false;
      }

      // Validate password
      if (passwordInput && !validatePassword(passwordInput.value)) {
        showError(
          passwordInput,
          "Password must be 8+ characters with uppercase, lowercase, and number"
        );
        isValid = false;
      }

      if (!isValid) {
        e.preventDefault();
      }
    });
  }

  // Validate Login Form
  const loginForm = document.querySelector(
    'form[action*="login"], form[action*="candidate&action=login"]'
  );
  if (loginForm) {
    const emailInput = loginForm.querySelector('input[name="email"]');
    const passwordInput = loginForm.querySelector('input[name="password"]');

    if (emailInput) {
      emailInput.addEventListener("blur", function () {
        if (!validateEmail(this.value)) {
          showError(this, "Please enter a valid email address");
        } else {
          clearError(this);
        }
      });
    }

    loginForm.addEventListener("submit", function (e) {
      let isValid = true;

      if (emailInput && !validateEmail(emailInput.value)) {
        showError(emailInput, "Please enter a valid email address");
        isValid = false;
      }

      if (passwordInput && passwordInput.value.trim().length === 0) {
        showError(passwordInput, "Please enter your password");
        isValid = false;
      }

      if (!isValid) {
        e.preventDefault();
      }
    });
  }

  // Validate Application Form
  const applicationForm = document.querySelector(
    'form[action*="application"], form[action*="apply"]'
  );
  if (applicationForm) {
    const emailInput = applicationForm.querySelector('input[name="email"]');
    const passwordInput = applicationForm.querySelector(
      'input[name="password"]'
    );

    if (emailInput) {
      emailInput.addEventListener("blur", function () {
        if (!validateEmail(this.value)) {
          showError(this, "Please enter a valid email address");
        } else {
          clearError(this);
        }
      });
    }

    applicationForm.addEventListener("submit", function (e) {
      let isValid = true;

      if (emailInput && !validateEmail(emailInput.value)) {
        showError(emailInput, "Please enter a valid email address");
        isValid = false;
      }

      if (passwordInput && passwordInput.value.trim().length === 0) {
        showError(passwordInput, "Please enter your password");
        isValid = false;
      }

      if (!isValid) {
        e.preventDefault();
      }
    });
  }

  // Validate Resume Upload Form
  const resumeForm = document.querySelector('form[action*="resume"]');
  if (resumeForm) {
    const resumeInput = resumeForm.querySelector('input[name="resume"]');

    if (resumeInput) {
      resumeInput.addEventListener("change", function () {
        if (this.files.length > 0) {
          const file = this.files[0];
          const validation = validateFile(
            file,
            ["application/pdf"],
            5 * 1024 * 1024 // 5MB
          );

          if (!validation.valid) {
            showError(this, validation.message);
            this.value = ""; // Clear the file input
          } else {
            clearError(this);
          }
        }
      });
    }

    resumeForm.addEventListener("submit", function (e) {
      if (resumeInput && resumeInput.files.length > 0) {
        const file = resumeInput.files[0];
        const validation = validateFile(
          file,
          ["application/pdf"],
          5 * 1024 * 1024 // 5MB
        );

        if (!validation.valid) {
          showError(resumeInput, validation.message);
          e.preventDefault();
        }
      }
    });
  }

  // Clear errors on input
  const allInputs = document.querySelectorAll(
    'input[type="text"], input[type="email"], input[type="password"], input[type="tel"], input[type="file"]'
  );
  allInputs.forEach((input) => {
    input.addEventListener("input", function () {
      if (this.value.length > 0) {
        clearError(this);
      }
    });
  });
});
