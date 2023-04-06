<?php

include '../includes/funciones.php';
require '../includes/config/database.php';
$db = conectarDB();

estaAutenticado();
esAdmin();

$id = $_GET['id'];
$id = filter_var($id, FILTER_VALIDATE_INT);

// Redireccionar si $id no es INT
if (!$id) {
    header('Location: /admin/alumnos.php');
}

/**
 * CONSULTAR ID PASADO POR $_GET
 */
$query = "SELECT * FROM usuarios WHERE id=${id}";
$resultado = mysqli_query($db, $query);
$alumno = mysqli_fetch_assoc($resultado);

if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
    $nombre = $_POST['nombre'];
    $apellido_paterno = $_POST['apellido_paterno'];
    $apellido_materno = $_POST['apellido_materno'];
    $usuario = $_POST['usuario'];
    $email = $_POST['email'];

    if ( !empty($_POST['contrasena']) ) {
        $contrasena = password_hash($_POST['contrasena'], PASSWORD_DEFAULT);

        $query = "UPDATE usuarios SET nombre='$nombre', apellido_paterno='$apellido_paterno', apellido_materno='$apellido_materno', usuario='$usuario', email='$email', contrasena='$contrasena' WHERE id = $id";
    } else {
        $query = "UPDATE usuarios SET nombre='$nombre', apellido_paterno='$apellido_paterno', apellido_materno='$apellido_materno', usuario='$usuario', email='$email' WHERE id = $id";
    }
    
    $resultado = mysqli_query($db, $query);

    if ($resultado) {
        header('Location: /admin/alumnos.php?alumnoActualizado=ok');
    } else {
        header('Location: /admin/alumnos.php?alumnoActualizado=error');
    }
}

?>

<!DOCTYPE html>
<html lang="es-MX">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar alumno</title>
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
            <h1 class="titulo-pagina">Editar alumno</h1>

            <div class="conjunto-botones">
                <a href="/admin/alumnos.php" class="btn-subrayado"><i class="icono fa-solid fa-arrow-left"></i> Regresar</a>
            </div>
        </div>
    </header>

    <main class="contenedor centrar-flex">
        <form class="form_registro" method="post">
            <div class="form__col">
                <div class="form__label">
                    <label for="nombre">Nombre</label>
                </div>
                <div class="form__input">
                    <input type="text" name="nombre" id="nombre" placeholder="Luis" value="<?php echo $alumno['nombre']; ?>" required>
                </div>
                
            </div>

            <div class="form__col">
                <div class="form__label">
                   <label for="apellido_paterno">Apellido paterno</label> 
                </div>
                <div class="form__input">
                    <input type="text" name="apellido_paterno" id="apellido_paterno" placeholder="Sánchez" required value="<?php echo $alumno['apellido_paterno']; ?>">
                </div>
            </div>

            <div class="form__col">
                <div class="form__label">
                   <label for="apellido_materno">Apellido materno</label> 
                </div>
                <div class="form__input">
                    <input type="text" name="apellido_materno" id="apellido_materno" placeholder="Gómez" required value="<?php echo $alumno['apellido_materno']; ?>">
                </div>
            </div>

            <div class="form__col">
                <div class="form__label">
                   <label for="usuario">Usuario</label> 
                </div>
                <div class="form__input">
                    <input type="text" name="usuario" id="usuario" placeholder="luisjefe" required value="<?php echo $alumno['usuario']; ?>">
                </div>
            </div>

            <div class="form__col">
                <div class="form__label">
                   <label for="email">Correo electrónico</label> 
                </div>
                <div class="form__input">
                    <input type="text" name="email" id="email" placeholder="luis@correo.com" required value="<?php echo $alumno['email']; ?>">
                </div>
            </div>

            <div class="form__col">
                <div class="form__label">
                   <label for="contrasena">Contraseña</label> 
                </div>
                <div class="form__input">
                    <input type="password" name="contrasena" id="contrasena" placeholder="Contraseña">
                </div>
            </div>

            <div class="form__col">
                <input class="btn btn-principal" type="submit" value="Actualizar">
            </div>
        </form>
    </main>
    
<?php get_footer(); ?>