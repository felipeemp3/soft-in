# Documentación Técnica y Funcional del Proyecto **Soft-In**

Soft-In es un sistema web para la gestión de control de acceso, roles, permisos y registro de usuarios en ambientes institucionales. Incluye autenticación, dashboards por rol (administrador, aprendiz, bienestar, vigilante, enfermera), generación de códigos QR, historial de ingresos y más.

---

## Archivos del Sistema y Estructura

A continuación, se describe la finalidad, los flujos principales, seguridad, y detalles técnicos de cada archivo relevante en el sistema.

---

## Archivos de Configuración y Entorno

### `.env`

Contiene las variables de entorno necesarias para la conexión a la base de datos. **No debe subirse con datos sensibles a repositorios públicos.**

```bash
# Esto es un comentario: Configuración de mi BD
DB_HOST=db
DB_NAME=
DB_USER=
DB_PASSWORD=
DB_ROOT_PASSWORD=
DB_PORT=3306
```

- **DB_HOST:** Dirección del servicio de base de datos (en Docker suele ser "db").
- **DB_NAME, DB_USER, DB_PASSWORD:** Nombre, usuario y contraseña de la base de datos.
- **DB_PORT:** Puerto de conexión (por defecto 3306 para MySQL).

---

### `docker-compose.yml`

Define los servicios para el despliegue local/desarrollo:

```yaml
version: '3.8'
services:
  web:
    build: .
    ports:
      - "8080:80"
    volumes:
      - ./src:/var/www/html
    environment:
      DB_HOST: db
      DB_USER: ${DB_USER}
      DB_PASSWORD: ${DB_PASSWORD}
      DB_NAME: ${DB_NAME}
    depends_on:
      - db
  db:
    image: mysql:8.0
    restart: always
    environment:
      MYSQL_ROOT_PASSWORD: ${DB_PASSWORD}
      MYSQL_DATABASE: ${DB_NAME}
      MYSQL_USER: ${DB_USER}
      MYSQL_PASSWORD: ${DB_PASSWORD}
    volumes:
      - db_data:/var/lib/mysql
  phpmyadmin:
    image: phpmyadmin/phpmyadmin
    ports:
      - "8081:80"
    environment:
      PMA_HOST: db
      MYSQL_ROOT_PASSWORD: ${DB_PASSWORD}
volumes:
  db_data:
```

- **Servicios:**
  - **web:** Servidor Apache+PHP con el código fuente montado en `/var/www/html`.
  - **db:** MySQL 8, persistente en volumen local, configurado por variables de entorno.
  - **phpmyadmin:** Interfaz de gestión web para la base de datos.
- **Volúmenes:** Persistencia de datos MySQL.

---

### `dockerfile`

Instrucciones para construir la imagen del backend web:

```dockerfile
FROM php:8.2-apache
RUN docker-php-ext-install mysqli pdo pdo_mysql
COPY ./src /var/www/html/
```

- **Base:** PHP 8.2 con Apache.
- **Extensiones:** Soporte para MySQL/MariaDB.
- **Copia:** Código fuente al contenedor.

## Frontend Principal

### `index.html`

Pantalla inicial de carga ("splash screen") de la aplicación.

- **Estilos:** `./public/css/splash-loading.css`
- **Script:** `./public/js/splash-loading.js`
- **Efectos visuales:** Barra y puntos de carga animados.
- **Propósito:** Mejorar UX mientras se inicializa la app.

---

## Seguridad y Sesiones

### `seguridad.php`

Controla el inicio de sesión, acceso por rol y asegura que los datos principales del usuario están en sesión.

#### Funcionalidad:

- **Redirección automática** si el usuario no está autenticado o si su rol no corresponde con la página.
- **Carga de datos adicionales** en la sesión si faltan (ej. nombres, documento) consultando la base de datos.

---

## Conexión a Base de Datos

### `conexion.php`

Abre una conexión MySQL usando las variables de entorno del contenedor.

```php
$servername = getenv ('DB_HOST');
$username = getenv('DB_USER');
$password = getenv('DB_PASSWORD');
$dbname = getenv('DB_NAME');
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) { die("Error al conectar la base de datos: " . $conn->connect_error); }
```

---

## Base de Datos y Esquema

### `soft.sql`

Contiene la definición y poblado de todas las tablas necesarias:
- `personas`: Usuarios del sistema (aprendices, administrativos, bienestar, etc.).
- `codigos_qr`: Almacena códigos QR generados, su estado y vigencia.
- `registro_ingreso`, `historial_ingreso`, `bienestar_leer_qr`, `enfermera_valoracion`, `permiso`, etc.: Tablas de registro de actividades, permisos, valoraciones médicas.

---

## Dashboards por Rol

### `admin.php`

Dashboard administrativo para la gestión de usuarios, roles y visualización de estadísticas.

#### Funcionalidades:
- **Visualización de estadísticas** por tipo de usuario.
- **Registro y edición de usuarios** mediante formularios modales.
- **Búsqueda de usuarios** en tabla.
- **Eliminación de usuarios** con confirmación.
- **Integración con scripts de backend** para CRUD.

---

## Dashboard Aprendiz

### `aprendiz.php`

Panel principal para aprendices:
- **Generación de QR:** Para el control de acceso.
- **Solicitud de permisos:** Formulario para justificar salidas.
- **Historial QR:** Consulta de registros anteriores.
- **Estadísticas personales:** Códigos generados, permisos activos, días activo.

---

### `permiso_form.php`

Formulario para que el aprendiz solicite un permiso de formación, con opción de adjuntar archivo PDF.

---
## Dashboard Vigilante

### `vigilante.php`

Panel exclusivo para el rol "vigilante":

- **Lectura de QR:** Usando la cámara y procesamiento vía JavaScript.
- **Historial de ingresos:** Listado con búsqueda y filtros.
- **Estadísticas:** Mostrando ingresos del día.
- **Registro de ingreso/salida:** Al leer un QR, se realiza una petición a `procesar_qr_vigilante.php` y se registra el evento.
---

## Dashboard Bienestar

### `bienestar.php`

Dashboard para el área de bienestar:
- **Lectura de QR y registro de atención.**
- **Historial de ingresos:** Consulta avanzada, búsqueda y descarga (PDF no implementado).
- **Estadísticas del día:** Conteo de ingresos.
---

### `enfermera.php`

Dashboard para el rol enfermera:
- **Visualización de aprendices pendientes de valoración médica.**
- **Tarjetas de estadísticas:** aprendices totales, pendientes, evaluados.
- **Formulario modal para registrar valoración médica.**
---

## Otros Archivos y Utilidades

- **`debug_sesion.php`:** Muestra el estado actual de la sesión y prueba la conexión a BD.
- **Hooks Git** (`pre-commit.sample`, `post-update.sample`, etc.): Scripts de ejemplo para automatizar procesos en Git. No afectan el funcionamiento del sistema.
- **Archivos CSS:** (`dashboard-admin.css`, `dashboard-aprendiz.css`): Estilos visuales para los dashboards.

---

## Resumen de Seguridad

- **Todas las páginas importantes usan `seguridad.php`** para proteger el acceso por sesión y rol.
- **Las operaciones críticas** (registro, edición, eliminación) usan declaraciones preparadas para evitar inyección SQL.
- **Las rutas de archivos subidos** son sanitizadas y almacenadas en carpetas protegidas.
- **Las sesiones se destruyen completamente al cerrar sesión** (`logout.php`).

---

## Observaciones finales

- El sistema es modular y fácilmente ampliable.
- El backend está preparado para conectar con un frontend moderno o para migrar a una API REST completa.
- El manejo de roles y la segregación de vistas lo hace apropiado para contextos institucionales y de seguridad.

---

## Creditos a los demas desarrolladores 
- Jesus David Garcia
- Josue David
- Cristian Marquez
- Kelly Barrios
