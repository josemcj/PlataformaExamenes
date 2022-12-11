<?php

function conectarDB() : mysqli {
    $db = mysqli_connect('localhost', 'root', '', 'examenes');

    if (!$db) {
        echo "No se pudo conectar.";
        exit; // Evita que el demas codigo de ejecute
    }

    return $db;
}

?>