<?php

include 'includes/funciones.php';
include 'includes/config/database.php';
$db = conectarDB();

estaAutenticado();

// Obtiene el ID del usuario actual
$user_id = intval($_SESSION['user_id']);

/**
 * Lista de examenes de usuario
 */
$query = "SELECT usuarios_examenes.id, examenes.nombre, usuarios_examenes.aciertos FROM usuarios_examenes INNER JOIN examenes ON usuarios_examenes.examen_id=examenes.id AND usuarios_examenes.usuario_id = {$user_id}";
$resultado = mysqli_query($db, $query);

?>

<!DOCTYPE html>
<html lang="es-MX">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de control de <?php echo $_SESSION['nombre']; ?></title>
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
            <h1 class="titulo-pagina no-mg">Hola, <?php echo $_SESSION['nombre']; ?></h1>
        </div>
    </header>

    <main class="contenedor">
        <h1>Mis exámenes</h1>

        <table>
            <thead>
                <tr>
                    <th class="t-lg">Nombre</th>
                    <th class="t-center">Aciertos</th>
                    <th class="t-center">Acciones</th>
                </tr>
            </thead>

            <tbody>
            <?php if ($resultado->num_rows >= 1): ?>
                <?php while ( $examen = mysqli_fetch_assoc($resultado) ): ?>
                <tr>
                    <td><?php echo $examen['nombre']; ?></td>
                    <td class="t-center"><?php echo isset($examen['aciertos']) ? $examen['aciertos'] : 0; ?>/5</td>
                    <td class="t-center">
                        <a href="/responder.php?examenid=<?php echo $examen['id']; ?>" class="btn-responder-examen">Responder</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3" class="no-registros">No hay registros.</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </main>

<?php get_footer(); ?>