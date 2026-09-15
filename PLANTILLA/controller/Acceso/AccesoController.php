<?php

include_once '../model/Acceso/AccesoModel.php';
include_once '../model/LogicaNegocio/Hash.php';

class AccesoController {

    public function login() {

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $obj = new AccesoModel();
        $documento = trim($_POST['documento'] ?? '');
        $password  = $_POST['password'] ?? '';

        if (strlen($documento) <= 7) {
            $_SESSION['error'] = "El documento debe tener mas de 7 caracteres";
            redirect("login.php");
            return;
        }

        if (strlen($password) <= 7) {
            $_SESSION['error'] = "La contrasena debe tener mas de 7 caracteres";
            redirect("login.php");
            return;
        }

        $usuario = $obj->buscarPorDocumento($documento);

        if ($usuario === null || !Hash::validarHash($password, $usuario['contraseña'])) {
            $_SESSION['error'] = "Usuario o contrasena incorrectos";
            redirect("login.php");
            return;
        }

        $_SESSION['auth'] = "ok";
        $_SESSION['id_usuario'] = $usuario['id_usuario'];
        $_SESSION['primer_nombre'] = $usuario['primer_nombre'];
        $_SESSION['documento']  = $usuario['documento'];
        $_SESSION['correo'] = $usuario['correo'];

        redirect("index.php");
    }

    public function logout() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION = [];
        session_destroy();
        redirect("login.php");
    }

}