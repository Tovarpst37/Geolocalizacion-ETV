<?php

    include_once '../model/Roles/RolesModel.php';

    class RolesController{

        public function getCreate(){
            $obj = new RolesModel();

            $sql = "SELECT * FROM modulos WHERE id_estado = 1";
            $modulos = $obj->select($sql);

            $sql = "SELECT * FROM permisos WHERE id_estado = 1";
            $acciones = $obj->select($sql);

            $sql = "SELECT id_modulo, id_permiso, id_modulo_permiso FROM modulo_permisos";
            $moduloPermisos = $obj->select($sql);

            $mapa = [];
            foreach ($moduloPermisos as $mp) {
                $mapa[$mp['id_modulo']][$mp['id_permiso']] = $mp['id_modulo_permiso'];
            }

            include_once '../view/Roles/create.php';
        }

        public function postCreate(){
            $obj = new RolesModel();

            $nombreRol = trim($_POST['nombre_rol'] ?? '');
            $permisosMarcados = $_POST['permisos'] ?? [];

            if ($nombreRol === '' || empty($permisosMarcados)) {
                header("Location: " . getUrl("Roles","Roles","getCreate") . "&error=datos");
                return;
            }

            $obj->insert("BEGIN");

            $sql = "INSERT INTO rol (nombre_rol) VALUES ($1) RETURNING id_rol";
            $result = $obj->insert($sql, [$nombreRol]);

            if ($result === false) {
                $obj->insert("ROLLBACK");
                header("Location: " . getUrl("Roles","Roles","getCreate") . "&error=bd");
                return;
            }

            $idRol = pg_fetch_result($result, 0, 'id_rol');

            $modulosYaInsertados = [];
            $huboError = false;

            foreach ($permisosMarcados as $idModuloPermiso) {
                $idModuloPermiso = (int) $idModuloPermiso;

                $sql = "SELECT id_modulo FROM modulo_permisos WHERE id_modulo_permiso = $1";
                $fila = $obj->select($sql, [$idModuloPermiso]);

                if (empty($fila)) {
                    $huboError = true;
                    break;
                }

                $idModulo = $fila[0]['id_modulo'];

                if (!in_array($idModulo, $modulosYaInsertados)) {
                    $sql = "INSERT INTO modulo_rol (id_rol, id_modulo) VALUES ($1, $2)";
                    $r = $obj->insert($sql, [$idRol, $idModulo]);

                    if ($r === false) { $huboError = true; break; }
                    $modulosYaInsertados[] = $idModulo;
                }

                $sql = "INSERT INTO rol_permiso (id_rol, id_modulo_permiso) VALUES ($1, $2)";
                $r = $obj->insert($sql, [$idRol, $idModuloPermiso]);

                if ($r === false) { $huboError = true; break; }
            }

            if ($huboError) {
                $obj->insert("ROLLBACK");
                header("Location: " . getUrl("Roles","Roles","getCreate") . "&error=bd");
                return;
            }

            $obj->insert("COMMIT");
            header("Location: " . getUrl("Roles","Roles","getRoles"));
        }

        public function getRoles(){
            $obj = new RolesModel();
            $sql = "SELECT * FROM rol ORDER BY id_rol;";
            $roles = $obj->select($sql);
            include_once '../view/Roles/list.php';
        }

        public function getEdit(){
            $obj = new RolesModel();
            $idRol = (int)($_GET['id_rol'] ?? 0);

            $sql = "SELECT * FROM rol WHERE id_rol = $1";
            $rolData = $obj->select($sql, [$idRol]);
            $rol = $rolData[0] ?? null;

            if (!$rol) {
                header("Location: " . getUrl("Roles","Roles","getRoles") . "&error=noexiste");
                return;
            }

            $sql = "SELECT * FROM modulos WHERE id_estado = 1";
            $modulos = $obj->select($sql);

            $sql = "SELECT * FROM permisos WHERE id_estado = 1";
            $acciones = $obj->select($sql);

            $sql = "SELECT id_modulo, id_permiso, id_modulo_permiso FROM modulo_permisos";
            $moduloPermisos = $obj->select($sql);

            $mapa = [];
            foreach ($moduloPermisos as $mp) {
                $mapa[$mp['id_modulo']][$mp['id_permiso']] = $mp['id_modulo_permiso'];
            }

            $sql = "SELECT id_modulo_permiso FROM rol_permiso WHERE id_rol = $1";
            $permisosRolData = $obj->select($sql, [$idRol]);
            $permisosMarcados = array_column($permisosRolData, 'id_modulo_permiso');

            include_once '../view/Roles/edit.php';
        }

        public function postEdit(){
            $obj = new RolesModel();

            $idRol = (int)($_POST['id_rol'] ?? 0);
            $nombreRol = trim($_POST['nombre_rol'] ?? '');
            $permisosMarcados = $_POST['permisos'] ?? [];

            if ($idRol <= 0 || $nombreRol === '' || empty($permisosMarcados)) {
                header("Location: " . getUrl("Roles","Roles","getEdit") . "&id_rol=$idRol&error=datos");
                return;
            }

            $obj->insert("BEGIN");

            $sql = "UPDATE rol SET nombre_rol = $1 WHERE id_rol = $2";
            $result = $obj->insert($sql, [$nombreRol, $idRol]);

            if ($result === false) {
                $obj->insert("ROLLBACK");
                header("Location: " . getUrl("Roles","Roles","getEdit") . "&id_rol=$idRol&error=bd");
                return;
            }

            $obj->insert("DELETE FROM rol_permiso WHERE id_rol = $1", [$idRol]);
            $obj->insert("DELETE FROM modulo_rol WHERE id_rol = $1", [$idRol]);

            $modulosYaInsertados = [];
            $huboError = false;

            foreach ($permisosMarcados as $idModuloPermiso) {
                $idModuloPermiso = (int) $idModuloPermiso;

                $sql = "SELECT id_modulo FROM modulo_permisos WHERE id_modulo_permiso = $1";
                $fila = $obj->select($sql, [$idModuloPermiso]);

                if (empty($fila)) { $huboError = true; break; }

                $idModulo = $fila[0]['id_modulo'];

                if (!in_array($idModulo, $modulosYaInsertados)) {
                    $sql = "INSERT INTO modulo_rol (id_rol, id_modulo) VALUES ($1, $2)";
                    $r = $obj->insert($sql, [$idRol, $idModulo]);
                    if ($r === false) { $huboError = true; break; }
                    $modulosYaInsertados[] = $idModulo;
                }

                $sql = "INSERT INTO rol_permiso (id_rol, id_modulo_permiso) VALUES ($1, $2)";
                $r = $obj->insert($sql, [$idRol, $idModuloPermiso]);
                if ($r === false) { $huboError = true; break; }
            }

            if ($huboError) {
                $obj->insert("ROLLBACK");
                header("Location: " . getUrl("Roles","Roles","getEdit") . "&id_rol=$idRol&error=bd");
                return;
            }

            $obj->insert("COMMIT");
            header("Location: " . getUrl("Roles","Roles","getRoles"));
        }

    }
?>