<?php

include_once '../model/Acceso/AccesoModel.php';
include_once '../model//';
include_once '../model/LogicaNegocio/Hash.php';

class AccesoController {

    public function login() {
        header('Content-Type: application/json');

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $obj = new AccesoModel();
        $documento = trim($_POST['documento'] ?? '');
        $password  = $_POST['password'] ?? '';

        if (strlen($documento) <= 7 || strlen($password) <= 7) {
            echo json_encode([
                'success' => false,
                'message' => 'Usuario o contrasena incorrectos'
            ]);
            return;
        }

        $usuario = $obj->buscarPorDocumento($documento);

        if ($usuario === null || !Hash::validarHash($password, $usuario['contraseña'])) {
            echo json_encode([
                'success' => false,
                'message' => 'Usuario o contrasena incorrectos'
            ]);
            return;
        }

        session_regenerate_id(true);

        $_SESSION['auth']       = "ok";
        $_SESSION['id_usuario'] = $usuario['id_usuario'];
        $_SESSION['documento']  = $usuario['documento'];

        echo json_encode(['success' => true]);
    }

    public function logout() {
        session_destroy();
        redirect("login.php");
    }

}

?>