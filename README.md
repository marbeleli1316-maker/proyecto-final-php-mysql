# 📚 Sistema de Gestión de Estudiantes y Notas

Proyecto Final - Desarrollo de Aplicación Web con PHP y MySQL.

Aplicación web CRUD (Crear, Leer, Actualizar, Eliminar) que permite a una institución
académica administrar el registro de estudiantes y sus notas finales, con validación
en dos capas (cliente y servidor) y conexión segura a MySQL mediante PDO.

## 🎯 Caso de uso

Un departamento académico necesita llevar un registro digital de sus estudiantes
(cédula, nombres, carrera, semestre y nota final), reemplazando hojas de cálculo
dispersas por un sistema centralizado, validado y accesible desde el navegador.

## 🗂️ Estructura del proyecto

```
proyecto-final/
├── config/
│   └── database.php       # Conexión segura a MySQL (PDO)
├── src/
│   └── functions.php      # Validaciones de backend y utilidades
├── public/
│   ├── css/style.css      # Estilos del sitio
│   └── js/validation.js   # Validación en el cliente (frontend)
├── backups/
│   └── schema.sql         # Script de creación de la base de datos
├── index.php               # Listado de estudiantes (READ)
├── create.php               # Registro de estudiante (CREATE)
├── edit.php                 # Edición de estudiante (UPDATE)
├── delete.php                # Eliminación de estudiante (DELETE)
├── .gitignore
└── README.md
```

## 🛠️ Tecnologías

- **Backend:** PHP 8+ con PDO (sentencias preparadas, previene inyección SQL)
- **Base de datos:** MySQL / MariaDB
- **Frontend:** HTML5, CSS3, JavaScript (validación en cliente)
- **Validación:** doble capa (HTML5/JS en el navegador + PHP en el servidor)

## ✅ Funcionalidades (CRUD completo)

| Acción | Archivo | Descripción |
|---|---|---|
| Crear | `create.php` | Formulario y registro de un nuevo estudiante |
| Leer | `index.php` | Listado de todos los estudiantes registrados |
| Actualizar | `edit.php` | Formulario y edición de un estudiante existente |
| Eliminar | `delete.php` | Eliminación de un estudiante (con confirmación) |

## 💻 Instalación local (XAMPP / Laragon / WAMP)

1. Clona este repositorio dentro de tu carpeta `htdocs` (XAMPP) o `www` (Laragon):
   ```bash
   git clone https://github.com/TU-USUARIO/TU-REPOSITORIO.git
   ```
2. Inicia Apache y MySQL desde tu panel de control (XAMPP/Laragon).
3. Abre phpMyAdmin e importa el archivo `backups/schema.sql`
   (esto crea la base `gestion_estudiantes` y la tabla `estudiantes`).
4. Si tu usuario/contraseña de MySQL no son los de por defecto (`root` sin contraseña),
   edita `config/database.php` o define variables de entorno:
   ```
   DB_HOST=localhost
   DB_NAME=gestion_estudiantes
   DB_USER=root
   DB_PASS=
   DB_PORT=3306
   ```
5. Abre en tu navegador: `http://localhost/TU-REPOSITORIO/index.php`

## ☁️ Guía de despliegue en la nube (recomendado)

Como no tenías un hosting definido, aquí tienes dos opciones gratuitas y sencillas,
compatibles con PHP + MySQL:

### Opción A: InfinityFree (recomendada, 100% gratis, sin tarjeta)
1. Crea una cuenta en https://infinityfree.net y crea un nuevo sitio (te da un subdominio
   gratis tipo `tuusuario.infinityfreeapp.com`).
2. En el panel, ve a **MySQL Databases**, crea una base de datos y anota host, usuario,
   contraseña y nombre de la base.
3. Entra a **phpMyAdmin** desde el panel e importa `backups/schema.sql`.
4. Sube los archivos del proyecto por **FTP** (usa FileZilla con las credenciales FTP del panel)
   dentro de la carpeta `htdocs`.
5. Edita `config/database.php` en el servidor y reemplaza los valores por los que te dio
   InfinityFree (host suele ser algo como `sqlXXX.infinityfree.com`).
6. Visita tu subdominio en el navegador para comprobar que todo funciona.

### Opción B: Railway o Render (con contenedor PHP + MySQL administrado)
1. Crea una cuenta en https://railway.app.
2. Crea un nuevo proyecto, agrega un servicio de **MySQL** (te da host, usuario,
   contraseña y puerto automáticamente).
3. Agrega otro servicio desde tu repositorio de GitHub (Railway detecta PHP con Nixpacks).
4. En la pestaña **Variables** del servicio PHP, agrega `DB_HOST`, `DB_NAME`, `DB_USER`,
   `DB_PASS`, `DB_PORT` con los datos del servicio MySQL.
5. Importa `backups/schema.sql` conectándote con un cliente MySQL (ej. TablePlus, DBeaver)
   usando las credenciales del servicio MySQL de Railway.
6. Railway te da una URL pública (`https://tuapp.up.railway.app`) — esa es la URL para
   tu entrega y sustentación.

> 💡 Para la entrega, usa la URL pública activa (paso 6 en cualquiera de las dos opciones)
> como el enlace de "sitio web en producción" que pide el proyecto.

## 🔒 Seguridad implementada

- Conexión a MySQL mediante **PDO con sentencias preparadas** (previene inyección SQL).
- Validación de datos vacíos, nulos e inconsistentes en **frontend y backend**.
- Escape de salida HTML con `htmlspecialchars()` (previene XSS).
- Restricciones de integridad a nivel de base de datos (`CHECK`, `UNIQUE`, `NOT NULL`).

## 👤 Autor

Estudiante: _(agrega tu nombre)_
Materia: _(agrega el nombre de la materia)_
Fecha: Julio 2026
