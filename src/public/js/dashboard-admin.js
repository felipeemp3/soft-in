
// Función para actualizar estadísticas
function updateStats() {
  // Ya solo tienes usuarios válidos en allUsers
  const stats = {
    total: allUsers.length,
    aprendices: allUsers.filter((u) => u.rol === "aprendiz").length,
    enfermeras: allUsers.filter((u) => u.rol === "enfermera").length,
    vigilantes: allUsers.filter((u) => u.rol === "vigilante").length,
    bienestar: allUsers.filter((u) => u.rol === "bienestar").length,
    administrativos: allUsers.filter((u) => u.rol === "administrativo").length,
  }

  document.getElementById("totalUsers").textContent = stats.total
  document.getElementById("totalAprendices").textContent = stats.aprendices
  document.getElementById("totalEnfermeras").textContent = stats.enfermeras
  document.getElementById("totalVigilantes").textContent = stats.vigilantes
  // Si tienes campos para bienestar y administrativos, agrégalos así:
  // document.getElementById("totalBienestar").textContent = stats.bienestar
  // document.getElementById("totalAdministrativos").textContent = stats.administrativos
}

// Función para abrir modal de crear usuario
function openCreateUserModal() {
  document.getElementById("createUserModal").classList.add("active")
  document.getElementById("createUserForm").reset()
}

// Función para cerrar modal de crear usuario
function closeCreateUserModal() {
  document.getElementById("createUserModal").classList.remove("active")
}

// Función para actualizar opciones de programa según el rol
function updateProgramOptions() {
  const rolSelect = document.getElementById("rol")
  const programaSelect = document.getElementById("programa")
  const selectedRol = rolSelect.value

  // Limpiar opciones
  programaSelect.innerHTML = '<option value="">Seleccionar Programa</option>'

  if (selectedRol && programasPorRol[selectedRol]) {
    programasPorRol[selectedRol].forEach((programa) => {
      const option = document.createElement("option")
      option.value = programa
      option.textContent = programa
      programaSelect.appendChild(option)
    })
  }
}

// Función para alternar visibilidad de contraseña
function togglePassword() {
  const passwordInput = document.getElementById("contrasena")
  const toggleButton = document.querySelector(".toggle-password i")

  if (passwordInput.type === "password") {
    passwordInput.type = "text"
    toggleButton.classList.remove("fa-eye")
    toggleButton.classList.add("fa-eye-slash")
  } else {
    passwordInput.type = "password"
    toggleButton.classList.remove("fa-eye-slash")
    toggleButton.classList.add("fa-eye")
  }
}

// Función para manejar el envío del formulario de crear usuario
function handleCreateUserSubmit(e) {
  e.preventDefault()

  const formData = new FormData(e.target)
  const userData = {
    nombre_completo: `${formData.get("nombre")} ${formData.get("apellidos")}`,
    documento: formData.get("noDoc"),
    tipo_documento: formData.get("tipoDoc"),
    rol: formData.get("rol"),
    programa_formacion: formData.get("programa"),
    no_ficha: formData.get("noFicha") || `${formData.get("rol").toUpperCase()}${Date.now()}`,
    estado_formacion: formData.get("estado"),
    contrasena: formData.get("contrasena"),
  }

  // Validar datos
  if (!validateUserData(userData)) {
    return
  }

  showLoading()

  // Simular creación de usuario
  setTimeout(() => {
    // Agregar usuario a la base de datos simulada
    const newUser = {
      id_persona: allUsers.length + 1,
      ...userData,
    }

    allUsers.push(newUser)

    // Actualizar localStorage
    localStorage.setItem("soft_in_persona", JSON.stringify(allUsers))

    hideLoading()
    closeCreateUserModal()

    // Mostrar mensaje de éxito
    showSuccessModal("Usuario registrado correctamente")

    // Recargar tabla y estadísticas
    loadUsers()
  }, 2000)
}

// Función para validar datos del usuario
function validateUserData(userData) {
  const errors = []

  if (!userData.nombre_completo || userData.nombre_completo.trim().length < 3) {
    errors.push("El nombre completo debe tener al menos 3 caracteres")
  }

  if (!userData.documento || !/^\d+$/.test(userData.documento)) {
    errors.push("El documento debe contener solo números")
  }

  // Verificar si el documento ya existe
  if (allUsers.some((u) => u.documento === userData.documento)) {
    errors.push("Ya existe un usuario con este documento")
  }

  if (!userData.rol) {
    errors.push("Debe seleccionar un rol")
  }

  if (!userData.programa_formacion) {
    errors.push("Debe seleccionar un programa de formación")
  }

  if (!userData.contrasena || userData.contrasena.length < 6) {
    errors.push("La contraseña debe tener al menos 6 caracteres")
  }

  if (errors.length > 0) {
    alert("Errores en el formulario:\n" + errors.join("\n"))
    return false
  }

  return true
}

// Función para editar usuario
function editUser(userId) {
  const user = allUsers.find((u) => u.id_persona === userId)
  if (!user) return

  // Llenar formulario de edición
  document.getElementById("editUserId").value = user.id_persona
  document.getElementById("editNombre").value = user.nombre_completo
  document.getElementById("editRol").value = user.rol
  document.getElementById("editEstado").value = user.estado_formacion

  // Mostrar modal de edición
  document.getElementById("editUserModal").classList.add("active")
}

// Función para cerrar modal de editar usuario
function closeEditUserModal() {
  document.getElementById("editUserModal").classList.remove("active")
}

// Función para eliminar usuario
function deleteUser(userId) {
  const user = allUsers.find((u) => u.id_persona === userId)
  if (!user) return

  if (confirm(`¿Está seguro de eliminar al usuario ${user.nombre_completo}?`)) {
    showLoading()

    setTimeout(() => {
      // Eliminar usuario
      allUsers = allUsers.filter((u) => u.id_persona !== userId)

      // Actualizar localStorage
      localStorage.setItem("soft_in_persona", JSON.stringify(allUsers))

      hideLoading()
      showSuccessModal("Usuario eliminado correctamente")

      // Recargar tabla y estadísticas
      loadUsers()
    }, 1000)
  }
}

// Función para mostrar lista de usuarios
function showUsersList() {
  document.getElementById("usersSection").scrollIntoView({
    behavior: "smooth",
  })
}

// Función para mostrar reportes
function showReports() {
  showNotification("Módulo de reportes en desarrollo...")
}

// Función para buscar usuarios
function searchUsers(query) {
  if (!query.trim()) {
    filteredUsers = [...allUsers]
  } else {
    filteredUsers = allUsers.filter(
      (user) =>
        user.nombre_completo.toLowerCase().includes(query.toLowerCase()) ||
        user.documento.includes(query) ||
        user.rol.toLowerCase().includes(query.toLowerCase()),
    )
  }
  renderUsersTable()
}

// Función para mostrar menú de usuario
function showUserMenu() {
  const currentUser = window.getCurrentUser()

  const userMenu = document.createElement("div")
  userMenu.style.cssText = `
        position: fixed;
        top: 90px;
        right: 20px;
        background: white;
        border-radius: 15px;
        padding: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        z-index: 1000;
        min-width: 250px;
    `

  userMenu.innerHTML = `
        <div style="text-align: center; margin-bottom: 15px;">
            <div style="font-weight: 600; color: #2c3e50;">${currentUser.nombre}</div>
            <div style="font-size: 12px; color: #7f8c8d; text-transform: uppercase;">${currentUser.rol}</div>
        </div>
        <hr style="margin: 15px 0; border: none; border-top: 1px solid #eee;">
        <button onclick="showProfile()" style="
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: none;
            background: #f8f9fa;
            border-radius: 8px;
            cursor: pointer;
            text-align: left;
        ">
            <i class="fas fa-user" style="margin-right: 10px;"></i>Mi Perfil
        </button>
        <button onclick="showSettings()" style="
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: none;
            background: #f8f9fa;
            border-radius: 8px;
            cursor: pointer;
            text-align: left;
        ">
            <i class="fas fa-cog" style="margin-right: 10px;"></i>Configuración
        </button>
        <button onclick="logout()" style="
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: none;
            background: #fee;
            color: #e74c3c;
            border-radius: 8px;
            cursor: pointer;
            text-align: left;
        ">
            <i class="fas fa-sign-out-alt" style="margin-right: 10px;"></i>Cerrar Sesión
        </button>
        <button onclick="closeUserMenu()" style="
            position: absolute;
            top: 10px;
            right: 10px;
            background: none;
            border: none;
            font-size: 16px;
            cursor: pointer;
            color: #7f8c8d;
        ">×</button>
    `

  document.body.appendChild(userMenu)
  window.currentUserMenu = userMenu
}

// Función para cerrar menú de usuario
function closeUserMenu() {
  if (window.currentUserMenu) {
    document.body.removeChild(window.currentUserMenu)
    window.currentUserMenu = null
  }
}

// Función para mostrar menú principal
function showMainMenu() {
  showNotification("Menú principal en desarrollo...")
}

// Función para mostrar perfil
function showProfile() {
  closeUserMenu()
  showNotification("Perfil de usuario en desarrollo...")
}

// Función para mostrar configuración
function showSettings() {
  closeUserMenu()
  showNotification("Configuración en desarrollo...")
}



// Función para mostrar loading
function showLoading() {
  document.getElementById("loadingOverlay").classList.add("active")
}

// Función para ocultar loading
function hideLoading() {
  document.getElementById("loadingOverlay").classList.remove("active")
}

// Función para mostrar modal de éxito
function showSuccessModal(message) {
  document.getElementById("successMessage").textContent = message
  document.getElementById("successModal").classList.add("active")
}

// Función para cerrar modal de éxito
function closeSuccessModal() {
  document.getElementById("successModal").classList.remove("active")
}

// Función para mostrar notificaciones
function showNotification(message) {
  const existingNotification = document.querySelector(".notification")
  if (existingNotification) {
    existingNotification.remove()
  }

  const notification = document.createElement("div")
  notification.className = "notification"
  notification.innerHTML = `
        <i class="fas fa-info-circle" style="margin-right: 10px;"></i>
        ${message}
    `

  Object.assign(notification.style, {
    position: "fixed",
    top: "20px",
    right: "20px",
    background: "#3498db",
    color: "white",
    padding: "15px 20px",
    borderRadius: "10px",
    boxShadow: "0 5px 15px rgba(0,0,0,0.2)",
    zIndex: "1001",
    display: "flex",
    alignItems: "center",
    animation: "slideInRight 0.3s ease-out",
    fontSize: "14px",
    fontWeight: "500",
  })

  document.body.appendChild(notification)

  setTimeout(() => {
    notification.style.animation = "slideOutRight 0.3s ease-in forwards"
    setTimeout(() => {
      if (notification.parentNode) {
        notification.remove()
      }
    }, 300)
  }, 3000)
}

// Función para inicializar eventos
function initializeEvents() {
  // Formulario de crear usuario
  document.getElementById("createUserForm").addEventListener("submit", handleCreateUserSubmit)

  // Formulario de editar usuario
  document.getElementById("editUserForm").addEventListener("submit", (e) => {
    e.preventDefault()
    // Lógica para editar usuario
    showNotification("Función de edición en desarrollo...")
  })

  // Búsqueda de usuarios
  document.getElementById("searchInput").addEventListener("input", (e) => {
    searchUsers(e.target.value)
  })

  // Cerrar modales al hacer clic fuera
  document.addEventListener("click", (e) => {
    if (e.target.classList.contains("modal-overlay")) {
      if (e.target.id === "createUserModal") {
        closeCreateUserModal()
      } else if (e.target.id === "editUserModal") {
        closeEditUserModal()
      } else if (e.target.id === "successModal") {
        closeSuccessModal()
      }
    }

    if (!e.target.closest(".user-avatar") && window.currentUserMenu) {
      closeUserMenu()
    }
  })

  // Tecla Escape para cerrar modales
  document.addEventListener("keydown", (e) => {
    if (e.key === "Escape") {
      closeCreateUserModal()
      closeEditUserModal()
      closeSuccessModal()
      closeUserMenu()
    }
  })
}

// Agregar estilos de animación
document.addEventListener("DOMContentLoaded", () => {
  const style = document.createElement("style")
  style.textContent = `
        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(100%);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        @keyframes slideOutRight {
            to {
                opacity: 0;
                transform: translateX(100%);
            }
        }
    `
  document.head.appendChild(style)
})

