<?php

include_once '../model/ActividadZoocriadero/ActividadZoocriaderoModel.php';

class ActividadZoocriaderoController
{


    public function getRegistrar()
{
    $obj = new ActividadZoocriaderoModel();
    $sql4 = "SELECT MAX(id_actividad_zoo) FROM actividad_zoocriadero";
    $id_seg = $obj->select($sql4);

    $actividades_proceso = [
        "AZ-1" => "ALIMENTACION",
        "AZ-2" => "RECOLECCION DE PECES MUERTOS Y NACIDOS",
        "AZ-3" => "LIMPIEZA",
        "AZ-4" => "AJUSTE DE NIVEL",
        "AZ-5" => "LAVADO"
    ];

    $sql2 = "SELECT cod_actividad FROM actividad_zoocriadero";
    $disponibles = $obj->select($sql2);

    $codigos_registrados = array_column($disponibles, 'cod_actividad');

    $actividades_faltantes = array_diff_key($actividades_proceso, array_flip($codigos_registrados));

    // [NUEVO] Si ya no hay actividades pendientes por registrar, mostrar modal y redirigir a Consultar
    if (empty($actividades_faltantes)) {
        $urlConsultar = getUrl('ActividadZoocriadero', 'ActividadZoocriadero', 'getConsultar');
        ?>
        <div class="modal fade" id="modalSinActividades" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border: 0; border-radius: 16px; overflow: hidden; box-shadow: 0 12px 40px rgba(31,41,55,.15);">
              <div class="modal-body text-center p-4">
                <div style="width: 56px; height: 56px; border-radius: 14px; background: #edf1ff; color: #3b5bdb; display: inline-flex; align-items: center; justify-content: center; font-size: 1.6rem; margin-bottom: 1rem;">
                  <i class="bx bx-check-circle"></i>
                </div>
                <h5 style="font-weight: 700; color: #1f2937; margin-bottom: .5rem;">Todas las actividades ya están registradas</h5>
                <p style="color: #6b7280; margin-bottom: 1.5rem;"><p style="color: #6b7280; margin-bottom: 1.5rem;">
  No hay actividades pendientes por crear. Si necesitas registrar una actividad nueva, comunícate con el Super Administrador del sistema.
</p></p>
                <a href="<?php echo $urlConsultar; ?>" class="btn btn-primary" style="border-radius: 10px; padding: .55rem 1.4rem; font-weight: 600;">
                  Ir a Consultar
                </a>
              </div>
            </div>
          </div>
        </div>

        <script>
          document.addEventListener('DOMContentLoaded', function () {
            var modal = new bootstrap.Modal(document.getElementById('modalSinActividades'), {
              backdrop: 'static',
              keyboard: false
            });
            modal.show();
          });
        </script>
        <?php
        // No se incluye la vista del formulario, ya que no hay nada que registrar
        return;
    }

    if (!empty($_SESSION['mensaje_exito'])): ?>
        <div id="alertaExito" class="alert d-flex align-items-center border-0 shadow-sm" role="alert" style="border-left: 5px solid #198754 !important; background-color: #fff;">
            <svg class="bi flex-shrink-0 me-2" width="24" height="24" style="color:#198754;">
            <use xlink:href="#check-circle-fill" />
            </svg>
            <div>
            <?php echo $_SESSION['mensaje_exito']; ?>
            </div>
        </div>
        

        <script>
            setTimeout(function() {
            var alerta = document.getElementById('alertaExito');
            if (alerta) {
                alerta.style.transition = "opacity 0.5s ease";
                alerta.style.opacity = "0";
                setTimeout(function() { alerta.remove(); }, 500);
            }
            }, 5000);
        </script>
        <?php endif;

    include_once '../view/partials/ActividadZoocriadero/Registrar.php';
}

    public function validarRegistro()
    {

        $obj = new ActividadZoocriaderoModel();

        $cont = 0;

        $id = $_POST['id'] ?? '';
        $codigo = mb_strtoupper($_POST['codigo'] ?? '');
        $nombre = mb_strtoupper($_POST['nombre_actividad'] ?? '');

        $errores = [];

        $sql_validar = "SELECT id_actividad_zoo FROM actividad_zoocriadero WHERE UPPER(nombre_actividad) = $1";

        $validar_exist = $obj->select($sql_validar, [$nombre]);
         
        if (count($validar_exist) > 0) {
           
            $errores[] = "Ya existe una actividad con este nombre";
        }

        if (empty($nombre)) {
            $errores[] = "El nombre de la actividad es obligatoria";
        }

        if (!preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/u', $nombre)) {

            $errores[] = "El nombre de la actividad solo debe contener letras y espacios (sin números ni símbolos).";
        }


        if (!empty($codigo)) {

            if (substr($codigo, 0, 2) !== 'AZ') {

                $errores[] = "Las primeras dos letras del codigo deben ser: AZ";
            }

            if (substr($codigo, 2, 1) !== '-') {

                $errores[] = "El codigo debe contener un guion, como el siguiente Ejemplo: 'AZ-'";
            }

        }

        if (!empty($errores)) {
            include_once '../model/Errores/ErrorModal.php';
            ErrorModal::verError($errores, getUrl('ActividadZoocriadero', 'ActividadZoocriadero', 'getRegistrar', array('id' => $id)));
            return;
        } else {
            $cont = 1;
        }

        if ($cont == 1) {
            $this->postRegistrar($obj);
        }
    }

    public function postRegistrar(ActividadZoocriaderoModel $obj)
    {



        $codigo = mb_strtoupper($_POST['codigo']);
        $nombre = mb_strtoupper($_POST['nombre_actividad']);
        $estado = 1;

        $sql = "INSERT INTO actividad_zoocriadero (cod_actividad, nombre_actividad, id_estado) VALUES
    ($1,$2,$3)";

        $ejecutar = $obj->insert($sql, [$codigo, $nombre, $estado]);

        if ($ejecutar) {
            redirect(getUrl("ActividadZoocriadero", "ActividadZoocriadero", "getConsultar"));
        } else {
            echo "No se pudo registrar la actividad";
        }
    }

    public function getConsultar()
    {

        include_once '../view/partials/ActividadZoocriadero/Consultar.php';
    }


    public function getDatos()
    {

        $obj = new ActividadZoocriaderoModel();

        $sql = "SELECT a.id_actividad_zoo,
            a.cod_actividad,
            a.nombre_actividad,
            e.nombre_estado
            
            FROM actividad_zoocriadero a
            INNER JOIN estado e 
            ON a.id_estado=e.id_estado 
            WHERE e.tipo_estado = 'general'
            ORDER BY a.id_actividad_zoo  ";

        $datos = $obj->select($sql);

        return $datos;
    }

    public function postDelete()
    {

        $obj = new ActividadZoocriaderoModel();

        $id = $_GET['id'];


        $sqlEstado = "SELECT id_estado FROM actividad_zoocriadero WHERE id_actividad_zoo= $id";

        $ejecutarR = $obj->select($sqlEstado);

        foreach ($ejecutarR as $rec) {

            if ($rec['id_estado'] == 2) {
                echo '<script>alert("¡Este taque ya esta inhabilitado!");</script>';
                redirect(getUrl("ActividadZoocriadero", "ActividadZoocriadero", "getConsultar"));
            } else if ($rec['id_estado'] == 1) {

                $sql = "UPDATE actividad_zoocriadero SET id_estado = 2 WHERE id_actividad_zoo = $id";
                $ejecutar = $obj->delete($sql);
                if ($ejecutar) {
                    $_SESSION['mensaje_exito'] = "La actividad se inhabilito correctamente.";
                    redirect(getUrl("ActividadZoocriadero", "ActividadZoocriadero", "getConsultar"));
                } else {
                    echo "No se pudo inhabilitar la actividad";
                }
            }
        }
    }


    public function postHabilitar()
    {

        $obj = new ActividadZoocriaderoModel();

        $id = $_GET['id'];

        $sqlEstado = "SELECT id_estado FROM actividad_zoocriadero WHERE id_actividad_zoo= $id";



        $ejecutarR = $obj->select($sqlEstado);

        foreach ($ejecutarR as $rec) {
            if ($rec['id_estado'] == 2) {

                $sql = "UPDATE actividad_zoocriadero SET id_estado = 1 WHERE id_actividad_zoo = $id";
                $ejecutar = $obj->delete($sql);
                if ($ejecutar) {
                    $_SESSION['mensaje_exito'] = "La actividad se habilito correctamente.";
                    redirect(getUrl("ActividadZoocriadero", "ActividadZoocriadero", "getConsultar"));
                } else {
                    echo "No se pudo inhabilitar la actividad";
                }
            }
        }
    }


    public function getEditar()
    {

        $obj = new ActividadZoocriaderoModel();

        $id = $_GET['id'];

        $sql = "SELECT * FROM actividad_zoocriadero WHERE id_actividad_zoo=$1";
        $datos = $obj->select($sql, [$id]);

        include_once '../view/partials/ActividadZoocriadero/Editar.php';
    }



    public function validarUpdate()
    {

        $obj = new ActividadZoocriaderoModel();

        $cont = 0;

        $id = $_POST['id'] ?? '';
        $nombre = $_POST['nombre_actividad'] ?? '';


        if (empty($nombre)) {
            $errores[] = "El nombre de la actividad es obligatoria";
        }

        if (!preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/u', $nombre)) {
            $errores[] = "El nombre de la actividad solo debe contener letras y espacios (sin números ni símbolos).";
        }


        if (!empty($errores)) {
            include_once '../model/Errores/ErrorModal.php';
            ErrorModal::verError($errores, getUrl('ActividadZoocriadero', 'ActividadZoocriadero', 'getEditar', array('id' => $id)));
            return;
        } else {
            $cont = 1;
        }

        if ($cont == 1) {
            $this->postUpdate($obj);
        }
    }

    public function postUpdate(ActividadZoocriaderoModel $obj)
    {



        $nombre = $_POST['nombre_actividad'];
        $id = $_POST['id'];

        $sql = "UPDATE actividad_zoocriadero SET nombre_actividad = $1 WHERE id_actividad_zoo = $2";

        $ejecutar = $obj->update($sql, [$nombre, $id]);

        if ($ejecutar) {
            $_SESSION['mensaje_exito'] = "la Actividad se actualizó correctamente.";
            redirect(getUrl("ActividadZoocriadero", "ActividadZoocriadero", "getConsultar"));
        } else {
            echo "No se pudo Actualizar la actividad";
        }
    }


    public function getBuscar()
    {

        $tex = $_GET['busqueda'] ?? '';
        $obj = new ActividadZoocriaderoModel();
        $busqueda = mb_strtoupper($tex);
        $valor = "%$busqueda%";

        $sql = "SELECT a.id_actividad_zoo, a.cod_actividad, a.nombre_actividad,
    e.nombre_estado FROM actividad_zoocriadero a
    INNER JOIN estado e ON  a.id_estado= e.id_estado
    WHERE UPPER(a.cod_actividad) LIKE $1 
    OR UPPER(a.nombre_actividad) LIKE $1";

        $actividad2 = $obj->select($sql, [$valor]);

        include_once "../view/partials/ActividadZoocriadero/Busqueda.php";
    }
}
