<?php

include '../includes/funciones.php';
include '../includes/config/database.php';
$db = conectarDB();

estaAutenticado();
esAdmin();

// Recibe el resultado de la creacion de gastos
$alumnoRegistrado = $_GET['alumnoRegistrado'] ?? null;
$eliminarAlumno = $_GET['eliminarAlumno'] ?? null;
$alumnoActualizado = $_GET['alumnoActualizado'] ?? null;

/**
 * Recibe los datos de la base de datos
 */
$query = "SELECT * FROM usuarios WHERE es_admin IS NULL";
$resultado = mysqli_query($db, $query);

/**
 * Eliminar alumno
 */
if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
    $id = $_POST['id'];

    $query = "DELETE FROM usuarios WHERE id=${id}";
    $resultado = mysqli_query($db, $query);

    if ($resultado) {
        header('Location: /admin/alumnos.php?eliminarAlumno=ok');
    } else {
        header('Location: /admin/alumnos.php?eliminarAlumno=error');
    }
}

?>

<!DOCTYPE html>
<html lang="es-MX">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alumnos</title>
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
            <h1 class="titulo-pagina">Alumnos</h1>

            <div class="conjunto-botones">
                <a href="/admin" class="btn-subrayado"><i class="icono fa-solid fa-arrow-left"></i> Regresar</a>
                <a href="/admin/registrar-alumno.php" class="btn">Registrar alumno</a>
            </div>
        </div>
    </header>

    <!-- Mensajes -->
    <div class="contenedor mensajesGET">
        <!-- Alumno registrado -->
        <?php if ($alumnoRegistrado == 'ok'): ?>
            <p class="alerta exito">Alumno registrado correctamente</p>
        <?php elseif ($alumnoRegistrado == 'error'): ?>
            <p class="alerta error">No se pudo registrar al alumno</p>
        <?php endif; ?>

        <!-- Alumno eliminado -->
        <?php if ($eliminarAlumno == 'ok'): ?>
            <p class="alerta exito">Alumno eliminado correctamente</p>
        <?php elseif ($eliminarAlumno == 'error'): ?>
            <p class="alerta error">No se pudo eliminar al alumno</p>
        <?php endif; ?>

        <!-- Alumno actualizado -->
        <?php if ($alumnoActualizado == 'ok'): ?>
            <p class="alerta exito">Alumno actualizado correctamente</p>
        <?php elseif ($alumnoActualizado == 'error'): ?>
            <p class="alerta error">No se pudo actualizar al alumno</p>
        <?php endif; ?>
    </div>

    <main class="contenedor">
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Apellidos</th>
                    <th class="t-center">Usuario</th>
                    <th class="t-center">Acciones</th>
                </tr>
            </thead>

            <tbody>
            <?php if ($resultado->num_rows >= 1): ?>
                <?php while ( $alumno = mysqli_fetch_assoc($resultado) ): ?>
                <tr>
                    <td><?php echo $alumno['nombre']; ?></td>
                    <td><?php echo $alumno['apellido_paterno'] . " " . $alumno['apellido_materno']; ?></td>
                    <td class="t-center"><?php echo $alumno['usuario']; ?></td>
                    <td class="t-center">
                        <!-- Editar registro -->
                        <a href="/admin/editar-alumno.php?id=<?php echo $alumno['id']; ?>">
                            <i class="icono icono-editar fa-solid fa-pen-to-square"></i>
                        </a>
                        <!-- Eliminar -->
                        <form method="post" id="eliminarRegistro">
                            <input type="hidden" name="id" value="<?php echo $alumno['id']; ?>">
                            <button class="btn-eliminar" type="submit">
                                <i class="icono icono-borrar fa-solid fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" class="no-registros">No hay registros.</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </main>
    
<?php get_footer(); ?>