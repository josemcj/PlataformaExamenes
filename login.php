<?php

include 'includes/funciones.php';
require 'includes/config/database.php';
$db = conectarDB();

$errores = [];

if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
    $email = $_POST['email'];
    $contrasena = $_POST['contrasena'];

    /**
     * Revisa que el usuario exista
     */
    $query = "SELECT * FROM usuarios WHERE email = '$email'";
    $resultado = mysqli_query($db, $query);

    if ($resultado->num_rows) {
        // Si existe el usuario
        $usuario = mysqli_fetch_assoc($resultado);

        // Verificar que la contrasena sea correcta
        $auth = password_verify($contrasena, $usuario['contrasena']);

        // Si la contrasena corresponde
        if ($auth) {
            session_start();
            $_SESSION['nombre'] = $usuario['nombre'];
            $_SESSION['user_id'] = $usuario['id'];
            $_SESSION['login'] = true;
            $_SESSION['es_admin'] = $usuario['es_admin'];

            // debug($_SESSION);

            // Valida que sea admin
            if ( $_SESSION['es_admin'] == 1 ) {
                header('Location: /admin');
            } else {
                header('Location: /');
            }
        } else {
            $errores[] = 'Contraseña incorrecta';
        }
    } else {
        $errores[] = 'El usuario no existe';
    }
}

?>

<!DOCTYPE html>
<html lang="es-MX">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;800&display=swap" rel="stylesheet">
    <link rel="preload" href="/assets/css/estilos.css" as="style">
    <link rel="stylesheet" href="/assets/css/estilos.css">
    <script src="https://kit.fontawesome.com/a25d0be30f.js" crossorigin="anonymous"></script>
</head>
<body>
    <header>
        <div class="contenedor centrar-flex">
            <h1 class="titulo-pagina no-mg">Inicia sesión para comenzar</h1>
        </div>
    </header>

    <?php foreach ($errores as $error): ?>
        <div class="contenedor">
            <div class="alerta error">
              <?php echo $error; ?>
            </div>
        </div>
    <?php endforeach; ?>

    <main class="contenedor centrar-flex">
        <form action="login.php" class="form_registro" method="post">
            <div class="form__col">
                <div class="form__label">
                   <label for="email">Correo electrónico</label> 
                </div>
                <div class="form__input">
                    <input type="text" name="email" id="email" placeholder="usuario@correo.com" required>
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
                <input class="btn btn-principal" type="submit" value="Acceder">
            </div>
        </form>
    </main>

<?php get_footer(); ?>