<?php

include 'includes/funciones.php';
include 'includes/config/database.php';
$db = conectarDB();

estaAutenticado();

/**
 * Obtener examen_id
 */
$examen_id = $_GET['examenid'];
$examen_id = filter_var($examen_id, FILTER_VALIDATE_INT);

// Obtiene el ID del usuario actual
$user_id = intval($_SESSION['user_id']);

// Redireccionar si $id no es INT
if (!$examen_id) {
    header('Location: /admin/alumnos.php');
}

$query = "SELECT examen_id, examenes.nombre FROM usuarios_examenes INNER JOIN examenes ON usuarios_examenes.examen_id=examenes.id AND usuarios_examenes.usuario_id = {$user_id} AND usuarios_examenes.id={$examen_id}";
$examenContestar = mysqli_fetch_assoc( mysqli_query($db, $query) );

/**
 * A partir de $examenid se obtendran las preguntas y respuestas
 */
$examenid = intval($examenContestar['examen_id']);

$query = "SELECT * FROM examen_preguntas WHERE examen_id={$examenid}";
$resultado = mysqli_query($db, $query);

for ($i=0; $i < 5; $i++) { 
    $n = $i + 1;
    $preguntaNum = "pregunta_{$n}"; // Llamar a la pregunta como $pregunta_1, $pregunta_2

    $$preguntaNum = mysqli_fetch_assoc($resultado);
}

/**
 * Listar respuestas
 */
for ($i = 1; $i < 6; $i++) {
    $idpregunta = "pregunta_{$i}";
    $preguntaResp = "pregunta_{$i}_respuestas";
    $idpreg = intval($$idpregunta['id']);
    $query = "SELECT * FROM respuestas WHERE examen_id = {$examenid} AND pregunta_id = {$idpreg}";
    $resultado = mysqli_query($db, $query);

    while ($respuesta = mysqli_fetch_assoc($resultado)) {
        $$preguntaResp[] = $respuesta;
    }
}

/**
 * Respondido
 */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $preg1_correcta = $_POST['preg1_correcta'];
    $preg2_correcta = $_POST['preg2_correcta'];
    $preg3_correcta = $_POST['preg3_correcta'];
    $preg4_correcta = $_POST['preg4_correcta'];
    $preg5_correcta = $_POST['preg5_correcta'];

    $aciertos = 0;
    
    for ($i = 1; $i < 6; $i++) {
        $idpregunta = "pregunta_{$i}";
        $idpreg = intval($$idpregunta['id']);
        $preguntaRespUser = "preg{$i}_correcta";

        $query = "SELECT correcta FROM examen_preguntas WHERE examen_id={$examenid} AND id={$idpreg}";
        $resultado = mysqli_fetch_assoc(mysqli_query($db, $query));

        if ($resultado['correcta'] == $$preguntaRespUser) {
            $aciertos++;
        }
    }

    $query = "UPDATE usuarios_examenes SET aciertos = {$aciertos} WHERE id = {$examen_id}";
    $resultado = mysqli_query($db, $query);

    if ($resultado) {
        header('Location: /');
    }
}

?>

<!DOCTYPE html>
<html lang="es-MX">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responder examen: <?php echo $examenContestar['nombre']; ?></title>
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
            <h1 class="titulo-pagina no-mg"><?php echo $examenContestar['nombre']; ?></h1>

            <div class="conjunto-botones">
                <a href="/" class="btn-subrayado"><i class="icono fa-solid fa-arrow-left"></i> Regresar</a>
            </div>
        </div>
    </header>

    <main class="contenedor centrar-flex">
        <form class="form_examen" method="post">
            <p class="intrucciones-examen">Selecciona la opción que creas correcta.</p>

            <hr class="separador">

            <!-- Inicio Pregunta examen -->
            <div class="form_grupo form_grupo-pregunta">
                <div class="fila">
                    <label for="preg1" class="numero-pregunta">1</label>
                    <input class="pregunta" type="text" name="preg1" id="preg1" disabled value="<?php echo $pregunta_1['pregunta'] ;?>">
    
                    <!-- Seleccionar opcion correcta -->
                    <label for="preg1_correcta" class="opcion-correcta">Opción correcta</label>
                    <select name="preg1_correcta" id="preg1_correcta">
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                    </select>
                </div>

                <div class="fila">
                    <!-- Opciones -->
                    <div class="input-opciones">
                        <div class="opcion">
                            <label>A</label>
                            <input type="text" name="preg1_opcion_a" disabled value="<?php echo $pregunta_1_respuestas[0]['respuesta']; ?>">
                        </div>

                        <div class="opcion">
                            <label>B</label>
                            <input type="text" name="preg1_opcion_b" disabled value="<?php echo $pregunta_1_respuestas[1]['respuesta']; ?>">
                        </div>

                        <div class="opcion">
                            <label>C</label>
                            <input type="text" name="preg1_opcion_c" disabled value="<?php echo $pregunta_1_respuestas[2]['respuesta']; ?>">
                        </div>
                    </div>
                </div>
            </div>
            <!-- Fin Pregunta examen -->

            <!-- Inicio Pregunta examen -->
            <div class="form_grupo form_grupo-pregunta">
                <div class="fila">
                    <label for="preg2" class="numero-pregunta">2</label>
                    <input class="pregunta" type="text" name="preg2" id="preg2" disabled value="<?php echo $pregunta_2['pregunta'] ;?>">
    
                    <!-- Seleccionar opcion correcta -->
                    <label for="preg2_correcta" class="opcion-correcta">Opción correcta</label>
                    <select name="preg2_correcta" id="preg2_correcta">
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                    </select>
                </div>

                <div class="fila">
                    <!-- Opciones -->
                    <div class="input-opciones">
                        <div class="opcion">
                            <label>A</label>
                            <input type="text" name="preg2_opcion_a" disabled value="<?php echo $pregunta_2_respuestas[0]['respuesta']; ?>">
                        </div>

                        <div class="opcion">
                            <label>B</label>
                            <input type="text" name="preg2_opcion_b" disabled value="<?php echo $pregunta_2_respuestas[1]['respuesta']; ?>">
                        </div>

                        <div class="opcion">
                            <label>C</label>
                            <input type="text" name="preg2_opcion_c" disabled value="<?php echo $pregunta_2_respuestas[2]['respuesta']; ?>">
                        </div>
                    </div>
                </div>
            </div>
            <!-- Fin Pregunta examen -->

            <!-- Inicio Pregunta examen -->
            <div class="form_grupo form_grupo-pregunta">
                <div class="fila">
                    <label for="preg3" class="numero-pregunta">3</label>
                    <input class="pregunta" type="text" name="preg3" id="preg3" disabled value="<?php echo $pregunta_3['pregunta'] ;?>">
    
                    <!-- Seleccionar opcion correcta -->
                    <label for="preg3_correcta" class="opcion-correcta">Opción correcta</label>
                    <select name="preg3_correcta" id="preg3_correcta">
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                    </select>
                </div>

                <div class="fila">
                    <!-- Opciones -->
                    <div class="input-opciones">
                        <div class="opcion">
                            <label>A</label>
                            <input type="text" name="preg3_opcion_a" disabled value="<?php echo $pregunta_3_respuestas[0]['respuesta']; ?>">
                        </div>

                        <div class="opcion">
                            <label>B</label>
                            <input type="text" name="preg3_opcion_b" disabled value="<?php echo $pregunta_3_respuestas[1]['respuesta']; ?>">
                        </div>

                        <div class="opcion">
                            <label>C</label>
                            <input type="text" name="preg3_opcion_c" disabled value="<?php echo $pregunta_3_respuestas[2]['respuesta']; ?>">
                        </div>
                    </div>
                </div>
            </div>
            <!-- Fin Pregunta examen -->

            <!-- Inicio Pregunta examen -->
            <div class="form_grupo form_grupo-pregunta">
                <div class="fila">
                    <label for="preg4" class="numero-pregunta">4</label>
                    <input class="pregunta" type="text" name="preg4" id="preg4" disabled value="<?php echo $pregunta_4['pregunta'] ;?>">
    
                    <!-- Seleccionar opcion correcta -->
                    <label for="preg4_correcta" class="opcion-correcta">Opción correcta</label>
                    <select name="preg4_correcta" id="preg4_correcta">
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                    </select>
                </div>

                <div class="fila">
                    <!-- Opciones -->
                    <div class="input-opciones">
                        <div class="opcion">
                            <label>A</label>
                            <input type="text" name="preg4_opcion_a" disabled value="<?php echo $pregunta_4_respuestas[0]['respuesta']; ?>">
                        </div>

                        <div class="opcion">
                            <label>B</label>
                            <input type="text" name="preg4_opcion_b" disabled value="<?php echo $pregunta_4_respuestas[1]['respuesta']; ?>">
                        </div>

                        <div class="opcion">
                            <label>C</label>
                            <input type="text" name="preg4_opcion_c" disabled value="<?php echo $pregunta_4_respuestas[2]['respuesta']; ?>">
                        </div>
                    </div>
                </div>
            </div>
            <!-- Fin Pregunta examen -->

            <!-- Inicio Pregunta examen -->
            <div class="form_grupo form_grupo-pregunta">
                <div class="fila">
                    <label for="preg5" class="numero-pregunta">5</label>
                    <input class="pregunta" type="text" name="preg5" id="preg5" disabled value="<?php echo $pregunta_5['pregunta'] ;?>">
    
                    <!-- Seleccionar opcion correcta -->
                    <label for="preg5_correcta" class="opcion-correcta">Opción correcta</label>
                    <select name="preg5_correcta" id="preg5_correcta">
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                    </select>
                </div>

                <div class="fila">
                    <!-- Opciones -->
                    <div class="input-opciones">
                        <div class="opcion">
                            <label>A</label>
                            <input type="text" name="preg5_opcion_a" disabled value="<?php echo $pregunta_5_respuestas[0]['respuesta']; ?>">
                        </div>

                        <div class="opcion">
                            <label>B</label>
                            <input type="text" name="preg5_opcion_b" disabled value="<?php echo $pregunta_5_respuestas[1]['respuesta']; ?>">
                        </div>

                        <div class="opcion">
                            <label>C</label>
                            <input type="text" name="preg5_opcion_c" disabled value="<?php echo $pregunta_5_respuestas[2]['respuesta']; ?>">
                        </div>
                    </div>
                </div>
            </div>
            <!-- Fin Pregunta examen -->

            <input class="btn btn-principal btn-examen" type="submit" value="Terminar examen">
        </form>
    </main>

<?php get_footer(); ?>