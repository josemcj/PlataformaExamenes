<?php

// Se inicia sesion
session_start();

// Se vacia el arreglo $_SESSION
// $_SESSION = [];
session_destroy();

header('Location: /login.php');

?>