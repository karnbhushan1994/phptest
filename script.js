document.addEventListener("DOMContentLoaded", function () {
  const loginForm = document.getElementById("loginForm");
  const authorsList = document.getElementById("authorsList");

  loginForm.addEventListener("submit", function (e) {
    e.preventDefault();
    const email = loginForm.email.value;
    const password = loginForm.password.value;

    // Make a POST request to the login API endpoint to get the access token
    // Use Fetch API or another library for AJAX requests
    fetch("https://candidate-testing.api.royal-apps.io/login", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ email, password }),
    })
      .then((response) => response.json())
      .then((data) => {
        // Store the access token securely (e.g., in a session or local storage)
        const accessToken = data.access_token;

        // Display the list of authors after successful login
        fetchAuthors(accessToken);
      })
      .catch((error) => {
        console.error("Login failed:", error);
      });
  });

  function fetchAuthors(accessToken) {
    // Make an authenticated GET request to fetch authors
    fetch("https://candidate-testing.api.royal-apps.io/authors", {
      headers: {
        Authorization: `Bearer ${accessToken}`,
      },
    })
      .then((response) => response.json())
      .then((authors) => {
        // Display authors in a table or list format
        const authorsHTML = authors
          .map((author) => {
            return `<div>${author.name}</div>`;
          })
          .join("");
        authorsList.innerHTML = authorsHTML;
      })
      .catch((error) => {
        console.error("Failed to fetch authors:", error);
      });
  }
});
