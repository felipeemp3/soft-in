document.getElementById("loginForm").addEventListener("submit", async (e) => {
  e.preventDefault();

  const documento = document.getElementById("documento").value;
  const contrasena = document.getElementById("contrasena").value;

  try {
    const res = await fetch("/api/login", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ documento, contrasena }),
    });

    const data = await res.json();

    if (res.ok) {
      // Guardamos token en localStorage
      localStorage.setItem("token", data.token);

      // Redirigir según rol
      switch (data.rol) {
        case "aprendiz":
          window.location.href = "dashboard-aprendiz.html";
          break;
        case "bienestar":
          window.location.href = "dashboard-bienestar.html";
          break;
        case "vigilante":
          window.location.href = "dashboard-vigilante.html";
          break;
        case "enfermera":
          window.location.href = "dashboard-enfermera.html";
          break;
        case "administrativo":
          window.location.href = "dashboard-admin.html";
          break;
        default:
          document.getElementById("mensaje").textContent = "Rol no reconocido";
      }
    } else {
      document.getElementById("mensaje").textContent = data.error;
    }
  } catch (err) {
    console.error(err);
    document.getElementById("mensaje").textContent = "Error de conexión";
  }
});
