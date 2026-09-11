<?php

/**
 * ajax.php
 * Punto de entrada para las peticiones AJAX (fetch/$.ajax) del panel.
 * Recibe una accion y responde en JSON.
 */

include_once '../lib/helpers.php';

if(isset($_GET['modulo'])){
    resolve();
}

?>