document.addEventListener("DOMContentLoaded", function () {
  const searchForm = document.querySelector(".search-form form");

  if (searchForm) {
    const inputs = searchForm.querySelectorAll("input, select");

    inputs.forEach((input) => {
      input.addEventListener("change", function () {
        localStorage.setItem(this.name, this.value);
      });
    });

    inputs.forEach((input) => {
      const savedValue = localStorage.getItem(input.name);
      if (savedValue && !input.value) {
        input.value = savedValue;
      }
    });
  }
});
