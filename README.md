# Plataforma Exámenes

Plataforma para crear y responder exámenes con PHP y MySQL.
CRUD de usuarios y exámenes. Usa Gulp.js para para compilar SCSS y minificar JavaScript.

Video de su funcionamiento:
https://youtu.be/-qjY6ueHYEE

## Configuración inicial del proyecto

1. Importa la base de datos desde el archivo `plataforma_examenes.sql`.
2. Accede a la carpeta **includes/config** y edita el archivo **database.php** con tus respectivos datos de conexión a la base de datos (host, usuario, contraseña y base de datos).
3. Situate en la carpeta raíz del proyecto y abre la terminal. Ejecuta el comando `npm i`.
4. Ejecuta el servidor web con XAMPP (u otro) o el servidor de desarrollo de PHP. Para este último, abre la terminal y ejecuta el comando `php -S localhost:<PUERTO>`.

## ¿Cómo funciona el proyecto?

La base de datos ya tiene registrados dos usuarios: un usuario administrador y un usuario alumno.
Inicia sesión con los siguientes datos de acceso:

**Administrador**
- Correo electrónico: `admin@mail.com`
- Contraseña: `admin123#`

**Estudiante**
- Correo electrónico: `student@mail.com`
- Contraseña: `student123#`