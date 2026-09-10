<?php

/**
 * ajax.php
 * Punto de entrada para las peticiones AJAX (fetch/$.ajax) del panel.
 * Recibe una accion y responde en JSON.
 */

include_once '../lib/helpers.php';
include_once '../lib/persistlogin.php';

header('Content-Type: application/json; charset=utf-8');

$accion = isset($_POST['accion']) ? $_POST['accion'] : (isset($_GET['accion']) ? $_GET['accion'] : '');

switch ($accion) {

    case 'ejemplo':
        echo json_encode(['ok' => true, 'mensaje' => 'Respuesta de ejemplo']);
        break;

    default:
        echo json_encode(['ok' => false, 'mensaje' => 'Accion no reconocida']);
        break;
}

?>