<?php

include '../includes/funciones.php';
require '../includes/config/database.php';
$db = conectarDB();

estaAutenticado();
esAdmin();

/**
 * CONSULTAR ID PASADO POR $_GET
 */
$id = $_GET['id'];
$id = filter_var($id, FILTER_VALIDATE_INT);

// Redireccionar si $id no es INT
if (!$id) {
    header('Location: /admin/alumnos.php');
}

$query = "SELECT * FROM examenes WHERE id=${id}";
$resultado = mysqli_query($db, $query);
$examen = mysqli_fetch_assoc($resultado);
$examen_id = intval($examen['id']);

$query = "SELECT * FROM examen_preguntas WHERE examen_id={$examen_id}";
$resultado = mysqli_query($db, $query);

for ($i=0; $i < 5; $i++) { 
    $n = $i + 1;
    $preguntaNum = "pregunta_{$n}"; // Llamar a la pregunta como $pregunta_1, $pregunta_2

    $$preguntaNum = mysqli_fetch_assoc($resultado);
}

// Respuestas
for ($i=0; $i < 5; $i++) {
    $n = $i + 1;
    $preguntaNum = "pregunta_{$n}";
    $idPregunta = $$preguntaNum['id'];
    debug_noexit($$preguntaNum);

    for ($i=0; $i < 4; $i++) { 
        $query = "SELECT * FROM respuestas WHERE examen_id={$examen_id} AND pregunta_id = {$idPregunta}";
        $resultado = mysqli_query($db, $query);
        debug_noexit(mysqli_fetch_assoc($resultado));
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo_examen = $_POST['titulo_examen'];

    /**
     * Preguntas
     */
    $pregunta1 = $_POST['preg1'];
    $pregunta2 = $_POST['preg2'];
    $pregunta3 = $_POST['preg3'];
    $pregunta4 = $_POST['preg4'];
    $pregunta5 = $_POST['preg5'];

    /**
     * Opciones
     */
    $preg1_opcion_a = $_POST['preg1_opcion_a'];
    $preg1_opcion_b = $_POST['preg1_opcion_b'];
    $preg1_opcion_c = $_POST['preg1_opcion_c'];

    $preg2_opcion_a = $_POST['preg2_opcion_a'];
    $preg2_opcion_b = $_POST['preg2_opcion_b'];
    $preg2_opcion_c = $_POST['preg2_opcion_c'];

    $preg3_opcion_a = $_POST['preg3_opcion_a'];
    $preg3_opcion_b = $_POST['preg3_opcion_b'];
    $preg3_opcion_c = $_POST['preg3_opcion_c'];

    $preg4_opcion_a = $_POST['preg4_opcion_a'];
    $preg4_opcion_b = $_POST['preg4_opcion_b'];
    $preg4_opcion_c = $_POST['preg4_opcion_c'];

    $preg5_opcion_a = $_POST['preg5_opcion_a'];
    $preg5_opcion_b = $_POST['preg5_opcion_b'];
    $preg5_opcion_c = $_POST['preg5_opcion_c'];

    /**
     * Respuestas correctas
     */
    $preg1_correcta = $_POST['preg1_correcta'];
    $preg2_correcta = $_POST['preg2_correcta'];
    $preg3_correcta = $_POST['preg3_correcta'];
    $preg4_correcta = $_POST['preg4_correcta'];
    $preg5_correcta = $_POST['preg5_correcta'];

    /**
     * Insertar nombre del examen
     */
    $query = "INSERT INTO examenes (nombre) VALUES ('$titulo_examen')";
    $resultado = mysqli_query($db, $query);

    // Obtener el ID del examen
    $query = "SELECT MAX(id) AS id FROM examenes";
    $resultado = mysqli_fetch_assoc(mysqli_query($db, $query));
    $ultimoexamen = $resultado['id'];

    /**
     * Insertar preguntas en tabla examen_preguntas
     */
    for ($i=1; $i < 6; $i++) {
        $pregunta = "pregunta{$i}";
        $correcta = "preg{$i}_correcta";
        $query = "INSERT INTO examen_preguntas (pregunta, correcta, examen_id) VALUES ('{$$pregunta}', '{$$correcta}', '{$ultimoexamen}')";

        $resultado = mysqli_query($db, $query);

        // Obtener el ID de la pregunta
        $query = "SELECT MAX(id) AS id FROM examen_preguntas";
        $pregunta = mysqli_fetch_assoc(mysqli_query($db, $query));
        $ultimapregunta = $pregunta['id'];

        /**
         * Insertar incisos en tabla respuestas
         */
        $opcion_a = "preg{$i}_opcion_a";
        $opcion_b = "preg{$i}_opcion_b";
        $opcion_c = "preg{$i}_opcion_c";

        $query = "INSERT INTO respuestas (inciso, respuesta, pregunta_id, examen_id) VALUES ('A', '{$$opcion_a}', '{$ultimapregunta}', '{$ultimoexamen}')";
        $resultado = mysqli_query($db, $query);

        $query = "INSERT INTO respuestas (inciso, respuesta, pregunta_id, examen_id) VALUES ('B', '{$$opcion_b}', '{$ultimapregunta}', '{$ultimoexamen}')";
        $resultado = mysqli_query($db, $query);

        $query = "INSERT INTO respuestas (inciso, respuesta, pregunta_id, examen_id) VALUES ('C', '{$$opcion_c}', '{$ultimapregunta}', '{$ultimoexamen}')";
        $resultado = mysqli_query($db, $query);
    }

    header('Location: /admin?examenCreado=ok');
}

?>

<!DOCTYPE html>
<html lang="es-MX">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear examen</title>
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
            <h1 class="titulo-pagina">Crear examen</h1>

            <div class="conjunto-botones">
                <a href="/admin" class="btn-subrayado"><i class="icono fa-solid fa-arrow-left"></i> Regresar</a>
            </div>
        </div>
    </header>

    <main class="contenedor centrar-flex">
        <form action="crear-examen.php" class="form_examen" method="post">
            <p class="intrucciones-examen">Asigna un nombre al examen.</p>
            <hr class="separador">
            
            <div class="form_grupo">
                <label for="titulo_examen">Nombre</label>
                <input class="form_title" type="text" name="titulo_examen" id="titulo_examen" value="<?php echo $examen['nombre']; ?>">
            </div>

            <hr class="separador">
            <p class="intrucciones-examen">Redacta las preguntas y sus respuestas.</p>

            <!-- Inicio Pregunta examen -->
            <div class="form_grupo form_grupo-pregunta">
                <div class="fila">
                    <label for="preg1" class="numero-pregunta">1</label>
                    <input class="pregunta" type="text" name="preg1" id="preg1" value="<?php echo $pregunta_1['pregunta'] ;?>">
    
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
                            <input type="text" name="preg1_opcion_a">
                        </div>

                        <div class="opcion">
                            <label>B</label>
                            <input type="text" name="preg1_opcion_b">
                        </div>

                        <div class="opcion">
                            <label>C</label>
                            <input type="text" name="preg1_opcion_c">
                        </div>
                    </div>
                </div>
            </div>
            <!-- Fin Pregunta examen -->

            <!-- Inicio Pregunta examen -->
            <div class="form_grupo form_grupo-pregunta">
                <div class="fila">
                    <label for="preg2" class="numero-pregunta">2</label>
                    <input class="pregunta" type="text" name="preg2" id="preg2" value="<?php echo $pregunta_2['pregunta'] ;?>">
    
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
                            <input type="text" name="preg2_opcion_a">
                        </div>

                        <div class="opcion">
                            <label>B</label>
                            <input type="text" name="preg2_opcion_b">
                        </div>

                        <div class="opcion">
                            <label>C</label>
                            <input type="text" name="preg2_opcion_c">
                        </div>
                    </div>
                </div>
            </div>
            <!-- Fin Pregunta examen -->

            <!-- Inicio Pregunta examen -->
            <div class="form_grupo form_grupo-pregunta">
                <div class="fila">
                    <label for="preg3" class="numero-pregunta">3</label>
                    <input class="pregunta" type="text" name="preg3" id="preg3" value="<?php echo $pregunta_3['pregunta'] ;?>">
    
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
                            <input type="text" name="preg3_opcion_a">
                        </div>

                        <div class="opcion">
                            <label>B</label>
                            <input type="text" name="preg3_opcion_b">
                        </div>

                        <div class="opcion">
                            <label>C</label>
                            <input type="text" name="preg3_opcion_c">
                        </div>
                    </div>
                </div>
            </div>
            <!-- Fin Pregunta examen -->

            <!-- Inicio Pregunta examen -->
            <div class="form_grupo form_grupo-pregunta">
                <div class="fila">
                    <label for="preg4" class="numero-pregunta">4</label>
                    <input class="pregunta" type="text" name="preg4" id="preg4" value="<?php echo $pregunta_4['pregunta'] ;?>">
    
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
                            <input type="text" name="preg4_opcion_a">
                        </div>

                        <div class="opcion">
                            <label>B</label>
                            <input type="text" name="preg4_opcion_b">
                        </div>

                        <div class="opcion">
                            <label>C</label>
                            <input type="text" name="preg4_opcion_c">
                        </div>
                    </div>
                </div>
            </div>
            <!-- Fin Pregunta examen -->

            <!-- Inicio Pregunta examen -->
            <div class="form_grupo form_grupo-pregunta">
                <div class="fila">
                    <label for="preg5" class="numero-pregunta">5</label>
                    <input class="pregunta" type="text" name="preg5" id="preg5" value="<?php echo $pregunta_5['pregunta'] ;?>">
    
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
                            <input type="text" name="preg5_opcion_a">
                        </div>

                        <div class="opcion">
                            <label>B</label>
                            <input type="text" name="preg5_opcion_b">
                        </div>

                        <div class="opcion">
                            <label>C</label>
                            <input type="text" name="preg5_opcion_c">
                        </div>
                    </div>
                </div>
            </div>
            <!-- Fin Pregunta examen -->

            <input class="btn btn-principal btn-examen" type="submit" value="Guardar">
        </form>
    </main>

<?php get_footer(); ?>