<?php

include '../includes/funciones.php';
require '../includes/config/database.php';
$db = conectarDB();

estaAutenticado();
esAdmin();

if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
    $nombre = $_POST['nombre'];
    $apellido_paterno = $_POST['apellido_paterno'];
    $apellido_materno = $_POST['apellido_materno'];
    $usuario = $_POST['usuario'];
    $email = $_POST['email'];
    $contrasena = password_hash($_POST['contrasena'], PASSWORD_DEFAULT);

    $query = "INSERT INTO usuarios (nombre, apellido_paterno, apellido_materno, usuario, email, contrasena) VALUES ('$nombre', '$apellido_paterno', '$apellido_materno', '$usuario', '$email', '$contrasena')";
    
    $resultado = mysqli_query($db, $query);

    if ($resultado) {
        header('Location: /admin/alumnos.php?alumnoRegistrado=ok');
    } else {
        header('Location: /admin/alumnos.php?alumnoRegistrado=error');
    }
}

?>

<!DOCTYPE html>
<html lang="es-MX">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar alumno</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;800&display=swap" rel="stylesheet">
    <link rel="preload" href="/assets/css/estilos.css" as="style">
    <link rel="stylesheet" href="/assets/css/estilos.css">
    <script src="https://kit.fontawesome.com/a25d0be30f.js" crossorigin="anonymous"></script>
</head>
<body>
    <header>
        <?php get_header(); ?>
        <div class="contenedor centrar-flex">
            <h1 class="titulo-pagina">Registrar alumno</h1>

            <div class="conjunto-botones">
                <a href="/admin/alumnos.php" class="btn-subrayado"><i class="icono fa-solid fa-arrow-left"></i> Regresar</a>
            </div>
        </div>
    </header>

    <main class="contenedor centrar-flex">
        <form action="registrar-alumno.php" class="form_registro" method="post">
            <div class="form__col">
                <div class="form__label">
                    <label for="nombre">Nombre</label>
                </div>
                <div class="form__input">
                    <input type="text" name="nombre" id="nombre" required placeholder="Luis">
                </div>
                
            </div>

            <div class="form__col">
                <div class="form__label">
                   <label for="apellido_paterno">Apellido paterno</label> 
                </div>
                <div class="form__input">
                    <input type="text" name="apellido_paterno" id="apellido_paterno" placeholder="Sánchez" required>
                </div>
            </div>

            <div class="form__col">
                <div class="form__label">
                   <label for="apellido_materno">Apellido materno</label> 
                </div>
                <div class="form__input">
                    <input type="text" name="apellido_materno" id="apellido_materno" placeholder="Gómez" required>
                </div>
            </div>

            <div class="form__col">
                <div class="form__label">
                   <label for="usuario">Usuario</label> 
                </div>
                <div class="form__input">
                    <input type="text" name="usuario" id="usuario" placeholder="luisjefe" required>
                </div>
            </div>

            <div class="form__col">
                <div class="form__label">
                   <label for="email">Correo electrónico</label> 
                </div>
                <div class="form__input">
                    <input type="text" name="email" id="email" placeholder="luis@correo.com" required>
                </div>
            </div>

            <div class="form__col">
                <div class="form__label">
                   <label for="contrasena">Contraseña</label> 
                </div>
                <div class="form__input">
                    <input type="password" name="contrasena" id="contrasena" placeholder="Contraseña" required>
                </div>
            </div>

            <div class="form__col">
                <input class="btn btn-principal" type="submit" value="Guardar">
            </div>
        </form>
    </main>
    
<?php get_footer(); ?>