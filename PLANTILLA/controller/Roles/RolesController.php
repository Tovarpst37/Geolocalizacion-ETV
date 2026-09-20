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

            if ($nombreRol === '') {
                header("Location: " . getUrl("Roles","Roles","getCreate") . "&error=nombre");
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
            header("Location: " . getUrl("Roles","Roles","list"));
        }

        public function getRoles(){
            $obj = new RolesModel();
            $sql = "SELECT * FROM rol";
            $roles = $obj->select($sql);
            include_once '../view/Roles/list.php';
        }

    }
?>