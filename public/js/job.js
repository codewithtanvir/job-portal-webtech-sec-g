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

    searchForm.addEventListener("submit", function (e) {
      e.preventDefault();

      const keyword = searchForm.querySelector('[name="keyword"]').value;
      const location = searchForm.querySelector('[name="location"]').value;
      const category = searchForm.querySelector('[name="category"]').value;

      const url = `index.php?page=ajax-search&action=ajax-search&keyword=${keyword}&location=${location}&category=${category}`;

      const jobsContainer = document.querySelector(".jobs-container");
      jobsContainer.innerHTML = "<p>Loading...</p>";

      const xhr = new XMLHttpRequest();
      xhr.open("GET", url, true);

      xhr.onload = function () {
        if (xhr.status === 200) {
          const jobs = JSON.parse(xhr.responseText);
          displayJobs(jobs);
        } else {
          jobsContainer.innerHTML = "<p>Error loading jobs</p>";
        }
      };

      xhr.onerror = function () {
        jobsContainer.innerHTML = "<p>Error loading jobs</p>";
      };

      xhr.send();
    });
  }
});

function displayJobs(jobs) {
  const jobsContainer = document.querySelector(".jobs-container");

  if (jobs.length === 0) {
    jobsContainer.innerHTML = "<p>No jobs found</p>";
    return;
  }

  let html = "";
  jobs.forEach((job) => {
    html += `
      <div class="job-card">
        <h3>${job.title}</h3>
        <p><strong>Company:</strong> ${job.company}</p>
        <p><strong>Location:</strong> ${job.location}</p>
        <p><strong>Category:</strong> ${job.category}</p>
        <p><strong>Salary:</strong> ${job.salary}</p>
        <p><strong>Job Type:</strong> ${job.job_type}</p>
        <a href="index.php?page=job-details&action=details&id=${job.id}">View Details</a>
      </div>
    `;
  });

  jobsContainer.innerHTML = html;
}
