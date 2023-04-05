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
Pruebalo tú mismo desde el [siguiente enlace](https://josemcj.000webhostapp.com/examenes) e inicia sesión con los siguientes datos de acceso:

**Administrador**
- Correo electrónico: `admin@mail.com`
- Contraseña: `admin123#`

**Estudiante**
- Correo electrónico: `student@mail.com`
- Contraseña: `student123#`

**NOTA: Solo el usuario administrador puede registrar nuevos usuarios, que serán alumnos.**
Veamos ahora su funcionamiento.

### Administrador

La pantalla inicial es el inicio de sesión, como se muestra en la siguiente imagen. Veamos primero como funciona por parte del administrador.

![Inicio de sesión](https://raw.githubusercontent.com/josemcj/PlataformaExamenes/main/screenshots/01.png)

Al iniciar sesión veremos un panel de control como el siguiente. Tenemos dos botones que nos ayudarán para registrar exámenes o alumnos. Debajo, veremos la lista de examenes creados.

![Panel de control del administrador](https://raw.githubusercontent.com/josemcj/PlataformaExamenes/main/screenshots/02.png)

Si damos clic en el botón "Alumnos", veremos una lista de alumno y a su vez, los respectivos botones para editar o eliminar alumnos (usuarios). Tenemos también un botón para registrar a un nuevo alumno.

![Lista de alumnos](https://raw.githubusercontent.com/josemcj/PlataformaExamenes/main/screenshots/03.png)

Si registramos un nuevo alumno se nos pedirán los datos generales, así como el correo electrónico, usuario y contraseña que servirán para que ese usuario pueda acceder a la plataforma.

![Registro de alumnos](https://raw.githubusercontent.com/josemcj/PlataformaExamenes/main/screenshots/04.png)

Por otro lado, si deseamos registrar un examen, debemos dar clic en el botón "Crear examen" en el panel de control inicial.

![Panel de control del administrador](https://raw.githubusercontent.com/josemcj/PlataformaExamenes/main/screenshots/02.png)

Nos llevará a la siguiente página en donde podremos registra el examen, asignando un nombre y 5 preguntas de 3 incisos. Ahí mismo elegimos la respuesta correcta a cada pregunta.

![Registro de examen](https://raw.githubusercontent.com/josemcj/PlataformaExamenes/main/screenshots/05.png)

Una vez registrado lo veremos en la lista de examenes en el panel de control.

![Lista de exámenes](https://raw.githubusercontent.com/josemcj/PlataformaExamenes/main/screenshots/06.png)

Podemos eliminar un examen, como se muestra en la siguiente imagen.

![Eliminando examen](https://raw.githubusercontent.com/josemcj/PlataformaExamenes/main/screenshots/07.png)

### Alumno

Primero iniciamos sesión con una cuenta de alumno.

![Inicio de sesión](https://raw.githubusercontent.com/josemcj/PlataformaExamenes/main/screenshots/01.png)

A continuación, podremos ver la lista de exámenes que tenemos listos para responder, con el puntaje que hemos obtenido. En este caso tenemos un puntaje de 0, pues aún no ha sido contestado.
Para contestar el examen damos clic en el botón "Responder".

![Lista de examenes por parte del alumno](https://raw.githubusercontent.com/josemcj/PlataformaExamenes/main/screenshots/09.png)

El usuario alumno solo tiene que elegir la opción que le parezca correcta.

![Respondiendo el examen](https://raw.githubusercontent.com/josemcj/PlataformaExamenes/main/screenshots/10.png)

Una vez respondido el examen, tendremos los aciertos obtenido, como se muestra a continuación.

![Aciertos obtenidos en el examen](https://raw.githubusercontent.com/josemcj/PlataformaExamenes/main/screenshots/11.png)