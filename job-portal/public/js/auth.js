document.addEventListener("DOMContentLoaded", () => {
  const formIds = ["loginForm", "registerForm", "verifyForm", "forgotForm", "resetForm"];
  const baseUrl = "/job-portal/public/auth/";

  const routes = {
    loginForm: "login",
    registerForm: "register",
    verifyForm: "verify",
    forgotForm: "forgotPassword",
    resetForm: "resetPassword",
  };

  const redirects = {
    loginForm: "/job-portal/public/dashboard",
    registerForm: "/job-portal/public/auth/verify",
    verifyForm: "/job-portal/public/auth/login",
    resetForm: "/job-portal/public/auth/login",
  };

  formIds.forEach((formId) => {
    const form = document.getElementById(formId);
    if (!form) return;

    form.addEventListener("submit", async (e) => {
      e.preventDefault();

      const formData = new FormData(form);
      const action = baseUrl + (routes[formId] || "");
      if (!action) return;

      try {
        const response = await fetch(action, { method: "POST", body: formData });
        const data = await response.json();

        if (data?.message) {
          alert(data.message);
        }

        if (data?.status !== "success") return;

        if (formId === "registerForm") {
          const email = formData.get("email");
          if (email) localStorage.setItem("jobportal_email", String(email));
        }

        if (formId === "forgotForm") {
          if (data?.token) console.log("Reset Token:", data.token);
          return;
        }

        const redirectUrl = redirects[formId];
        if (redirectUrl) window.location.href = redirectUrl;
      } catch (err) {
        console.error(err);
        alert("Something went wrong. Please try again.");
      }
    });
  });
});
