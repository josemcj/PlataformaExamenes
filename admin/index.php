<?php

include '../includes/funciones.php';
include '../includes/config/database.php';
$db = conectarDB();

estaAutenticado();
esAdmin();

// Recibe el resultado de la creacion de gastos
$examenCreado = $_GET['examenCreado'] ?? null;
$eliminarExamen = $_GET['eliminarExamen'] ?? null;

/**
 * Listar examenes
 */
$query = "SELECT * FROM examenes";
$resultado = mysqli_query($db, $query);

/**
 * Eliminar examen
 */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $id = $_POST['id'];
    
    $query = "DELETE FROM usuarios_examenes WHERE examen_id = {$id}";
    $resultado = mysqli_query($db, $query);

    $query = "DELETE FROM respuestas WHERE examen_id = {$id}";
    $resultado = mysqli_query($db, $query);

    $query = "DELETE FROM examen_preguntas WHERE examen_id = {$id}";
    $resultado = mysqli_query($db, $query);

    $query = "DELETE FROM examenes WHERE id = {$id}";
    $resultado = mysqli_query($db, $query);

    if ($resultado) {
        header('Location: /admin?eliminarExamen=ok');
    } else {
        header('Location: /admin?eliminarExamen=error');
    }
}

?>

<!DOCTYPE html>
<html lang="es-MX">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de control</title>
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
            <h1 class="titulo-pagina">Hola, <?php echo $_SESSION['nombre']; ?></h1>

            <div class="conjunto-botones">
                <a href="/admin/crear-examen.php" class="btn">Crear examen</a>
                <a href="/admin/alumnos.php" class="btn-subrayado">Alumnos</a>
            </div>
        </div>
    </header>

    <!-- Mensajes -->
    <div class="contenedor mensajesGET">
        <!-- Examen registrado -->
        <?php if ($examenCreado == 'ok'): ?>
            <p class="alerta exito">Examen registrado correctamente</p>
        <?php elseif ($examenCreado == 'error'): ?>
            <p class="alerta error">No se pudo registrar el examen</p>
        <?php endif; ?>

        <!-- Examen registrado -->
        <?php if ($eliminarExamen == 'ok'): ?>
            <p class="alerta exito">Examen eliminado correctamente</p>
        <?php elseif ($eliminarExamen == 'error'): ?>
            <p class="alerta error">No se pudo eliminar el examen</p>
        <?php endif; ?>
    </div>

    <main class="contenedor">
        <table>
            <thead>
                <tr>
                    <th class="t-lg">Nombre</th>
                    <th class="t-center">Acciones</th>
                </tr>
            </thead>

            <tbody>
            <?php if ($resultado->num_rows >= 1): ?>
                <?php while ( $examen = mysqli_fetch_assoc($resultado) ): ?>
                <tr>
                    <td><?php echo $examen['nombre']; ?></td>
                    <td class="t-center">
                        <a href="/admin/editar-examen.php?id=<?php echo $examen['id']; ?>">
                            <i class="icono icono-editar fa-solid fa-pen-to-square"></i>
                        </a>
                        <!-- Eliminar examen -->
                        <form method="post" id="eliminarRegistro">
                            <input type="hidden" name="id" value="<?php echo $examen['id']; ?>">
                            <button class="btn-eliminar" type="submit">
                                <i class="icono icono-borrar fa-solid fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="2" class="no-registros">No hay registros.</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </main>
    
<?php get_footer(); ?>