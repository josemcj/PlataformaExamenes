<?php

require 'app.php';

/**
 * Incluir Templates
 */
function get_footer() {
    include TEMPLATES_URL . "/footer.php";
}

function get_header() {
    include TEMPLATES_URL . "/header.php";
}

/**
 * Saber si el usuario esta autenticado
 */
function estaAutenticado() {
    session_start();
    $auth = isset($_SESSION['login']) ? $_SESSION['login'] : false;

    if (!$auth) {
        header('Location: /login.php');
    }
}

/**
 * No es admin (solo para alumnos)
 */
function esAdmin() {
    $es_admin = (isset($_SESSION['es_admin'])) ? $_SESSION['es_admin'] : false;

    if (!$es_admin) {
        header('Location: /');
    }
}

/**
 * Previsualizar datos
 */
function debug($dato) {
    echo "<pre>";
    var_dump($dato);
    echo "</pre>";
    exit;
}

function debug_noexit($dato) {
    echo "<pre>";
    var_dump($dato);
    echo "</pre>";
}

?>