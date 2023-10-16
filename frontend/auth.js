document.addEventListener("DOMContentLoaded", function () {
  const loginForm = document.getElementById("loginForm");
  const registerForm = document.getElementById("registerForm");

  if (loginForm) {
    loginForm.addEventListener("submit", login);
  }

  if (registerForm) {
    registerForm.addEventListener("submit", register);
  }
});

function login(event) {
  event.preventDefault();

  const username = document.getElementById("loginUsername").value;
  const password = document.getElementById("loginPassword").value;

  // Altere para o endpoint correto da sua API
  fetch("http://localhost/auth_api/auth_api/public/token", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: `username=${username}&password=${password}`,
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.token) {
        localStorage.setItem("jwt", data.token);
        window.location.replace("protected.html");
      } else {
        alert("Erro no login");
      }
    })
    .catch((error) => console.error("Erro:", error));
}

function register(event) {
  event.preventDefault();

  const username = document.getElementById("loginUsername").value;
  const password = document.getElementById("loginPassword").value;

  // Altere para o endpoint correto da sua API
  fetch("http://localhost/auth_api/auth_api/public/register", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: `username=${username}&password=${password}`,
  })
    .then((response) => {
      if (response.ok) {
        alert("Registrado com sucesso!");
        window.location.replace("index.html");
      } else {
        alert("Erro no registro");
      }
    })
    .catch((error) => console.error("Erro:", error));
}

function isLoggedIn() {
  const token = localStorage.getItem("jwt");
  return token ? true : false;
}
