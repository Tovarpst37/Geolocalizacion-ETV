<?php

    include_once '../model/Acceso/AccesoModel.php';
    include_once '../model/LogicaNegocio/Hash.php';

    class AccesoController {

        public function login() {
            $obj = new AccesoModel();
            $documento = trim($_POST['documento'] ?? '');
            $password  = $_POST['password'] ?? '';
            $mensaje = "";

            if (strlen($documento) <= 7 || strlen($password) <= 7) {
                $_SESSION['error'] = "Usuario o contrasena incorrectos";
                redirect("login.php");
                return;
            }

            $usuario = $obj->buscarPorDocumento($documento);

            if ($usuario === null || !Hash::validarHash($password, $usuario['contraseña'])) {
                $_SESSION['error'] = "Usuario o contrasena incorrectos";
                redirect("login.php");
                return;
            }
            if ($usuario['id_estado'] != 1) {
                $_SESSION['error'] = "Usuario Deshabilitado";
                redirect("login.php");
                return;
            }

            $_SESSION['auth'] = "ok";
            $_SESSION['id_usuarioU'] = $usuario['id_usuario'];
            $_SESSION['primer_nombre'] = $usuario['primer_nombre'];
            $_SESSION['documento']  = $usuario['documento'];
            $_SESSION['correo'] = $usuario['correo'];
            $_SESSION['id_rol'] = $usuario['id_rol'];

            $sql = "SELECT m.nombre_modulo, p.nombre_permiso
                    FROM rol_permiso rp
                    JOIN modulo_permisos mp ON mp.id_modulo_permiso = rp.id_modulo_permiso
                    JOIN modulos m ON m.id_modulo = mp.id_modulo
                    JOIN permisos p ON p.id_permiso = mp.id_permiso
                    WHERE rp.id_rol = $1";

            $filas = $obj->select($sql, [$usuario['id_rol']]);

            $permisosPorModulo = [];
            foreach ($filas as $fila) {
                $permisosPorModulo[$fila['nombre_modulo']][] = $fila['nombre_permiso'];
            }

            $modulosPermitidos = [];
            foreach ($permisosPorModulo as $modulo => $acciones) {
                if (in_array('VER', $acciones)) {
                    $modulosPermitidos[] = $modulo;
                }
            }

            $_SESSION['modulos'] = $modulosPermitidos;
            $_SESSION['permisos'] = $permisosPorModulo;

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
?>