<?php

    /**
     * persistlogin.php
     * Control de sesion. Aqui se valida que el usuario tenga
     * una sesion activa antes de mostrar el panel (index.php).
     */

    if(session_status() === PHP_SESSION_NONE){
        session_start();
    }

    // Descomenta cuando tengas el login listo, para proteger el panel:
    //
    // if(!isset($_SESSION['usuario'])){
    //     header('Location: login.php');
    //     exit;
    // }

?>
