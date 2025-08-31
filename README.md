# 📘 Proyecto Soft-In

## 📌 Descripción
**Soft-In** es un sistema web para la gestión de aprendices, personal de bienestar, enfermería, vigilancia y administrativo.  
El sistema permite realizar autenticación, gestionar usuarios, permisos, reportes médicos e historial de ingreso.  

Está desarrollado en **Node.js + Express** con base de datos en **PostgreSQL** y un frontend en **HTML, CSS y JavaScript**.

---

## ⚙️ Tecnologías usadas
- **Node.js** con Express  
- **PostgreSQL**  
- **HTML5, CSS3, JavaScript**  
- **JWT** para autenticación  
- **Bcrypt** para encriptar contraseñas  
- **Dotenv** para variables de entorno  

---

## 🚀 Instalación

### 1. Clonar el repositorio
```bash
git clone https://github.com/TU_USUARIO/TU_REPOSITORIO.git
cd TU_REPOSITORIO
```

### 2. Instalar dependencias
```bash
npm install
```

### 3. Configurar variables de entorno
Crea un archivo `.env` en la raíz del proyecto con lo siguiente (ajusta valores según tu BD):

```env
PORT=3000
DB_HOST=localhost
DB_PORT=5432
DB_USER=postgres
DB_PASSWORD=tu_contraseña
DB_NAME=soft_in
JWT_SECRET=mi_super_secreto
```

### 4. Importar la base de datos
Ejecuta en PostgreSQL:
```bash
psql -U postgres -d soft_in -f "soft in.sql"
```

### 5. Iniciar el servidor
```bash
npm run dev
```
Servidor disponible en:  
👉 `http://localhost:3000`

---

## 📂 Estructura del proyecto
```
soft-in/
 ├─ server.js          # Servidor principal
 ├─ db.js              # Conexión a PostgreSQL
 ├─ routes/            # Rutas de la API
 ├─ index-inicio-sesion.html  # Página de login
 ├─ dashboard-*.html   # Dashboards según rol
 ├─ js/                # Scripts frontend
 ├─ css/               # Estilos
 └─ .env               # Configuración privada
```

---

## 🔑 Roles del sistema
- **Aprendiz** → Consulta permisos y reportes.  
- **Vigilante** → Gestiona ingresos y salidas.  
- **Enfermera** → Registra reportes médicos.  
- **Bienestar** → Supervisa estado de aprendices.  
- **Administrativo** → Administración general del sistema.  

---

## 🧪 Rutas principales de la API
- `POST /api/login` → Autenticación (JWT)  
- `GET /api/personas` → Listar personas  
- `POST /api/personas` → Crear persona  
- `PUT /api/personas/:id` → Actualizar persona  
- `DELETE /api/personas/:id` → Eliminar persona  

*(Se pueden agregar más rutas: permisos, reportes, historial de ingreso)*  

---

## ✅ Lista de pendientes
- [ ] Implementar middleware JWT en todas las rutas  
- [ ] Conectar dashboards con la API  
- [ ] Agregar validaciones de datos en backend  
- [ ] Documentación de pruebas en Postman  

---

📌 Autor: *Andrés Felipe Montiel G*  
📅 Año: 2025  
