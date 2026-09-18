<div class="container mt-2">
    <div class="card mx-auto" style="max-width: 700px;">
        <div class="card-body p-3">
      <form action="<?php echo getUrl('Zoocriadero', 'Zoocriadero', 'validarUpdate'); ?>" method="POST" enctype="multipart/form-data">
        <div class="modal-header">
          <h5 class="modal-title">Editar Zoocriadero</h5>
          <a href="<?php echo getUrl('Zoocriadero', 'Zoocriadero', 'getConsultar') ?>" class="btn btn-close"></a>
        </div>
        
          <div class="border-top my-4"></div>

        <div class="modal-body">
          <?php
          foreach ($datos as $d) {
          ?>

            <input type="hidden" name="id" value="<?php echo $d['id_zoocriadero']; ?>">

            <div class="mb-3">
              <label class="form-label">Código del Zoocriadero</label>

              <input type="text" class="form-control" id="cod_zoocriadero" name="codigo_zoocriadero" value="<?php echo $d['cod_zoocriadero']; ?>" disabled>
            <input type="hidden" name="codigo" value="<?php echo $d['cod_zoocriadero']; ?>">
            </div>

<?php

$todosCoordinadores = array_merge($coord, $coordS);

$todosCoordinadores = array_unique($todosCoordinadores, SORT_REGULAR);

$idCoordinadorActual = !empty($coordS) ? $coordS[0]['id_usuario'] : null;

?>

<div class="mb-4">
    <label for="id_usuario" class="form-label">Coordinador Asignado <span class="text-danger">*</span></label>
    <select class="form-select" id="id_usuario" name="id_coor" required>
        <option value="" disabled <?= empty($idCoordinadorActual) ? 'selected' : '' ?>>
            Selecciona un Coordinador
        </option>

        <?php foreach ($todosCoordinadores as $usu): ?>
            <option value="<?php echo $usu['id_usuario']; ?>"
                <?php echo ($usu['id_usuario'] == $idCoordinadorActual) ? 'selected' : ''; ?>>
                <?php 
                echo $usu['primer_nombre'] . " " . 
                     $usu['segundo_nombre'] . " " . 
                     $usu['primer_apellido'] . " " . 
                     $usu['segundo_apellido']; 
                ?>
                <?php if ($usu['id_usuario'] == $idCoordinadorActual): ?>
                    (Actualmente asignado)
                <?php endif; ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>

          <div class="mb-4">
    <div class="mb-4">Auxiliares asignados</label>

    <div class="border rounded p-3 overflow-auto" style="max-height: 250px;">
      <?php

$todosAuxiliares = array_merge($auxi, $auxiS);

$todosAuxiliares = array_unique($todosAuxiliares, SORT_REGULAR);

$idsAsignados = array_column($auxiS, 'id_usuario');
?>

<?php foreach ($todosAuxiliares as $usu): ?>
    <div class="form-check">
        <input class="form-check-input" type="checkbox"
               name="usuarios_asignados[]"
               value="<?php echo $usu['id_usuario']; ?>"
               id="user<?php echo $usu['id_usuario']; ?>"
               <?php echo in_array($usu['id_usuario'], $idsAsignados) ? 'checked' : ''; ?>>

        <label class="form-check-label" for="user<?php echo $usu['id_usuario']; ?>">
            <?php 
            echo $usu['primer_nombre'] . " " . 
                 $usu['segundo_nombre'] . " " . 
                 $usu['primer_apellido'] . " " . 
                 $usu['segundo_apellido']; 
            ?>
            <?php if (in_array($usu['id_usuario'], $idsAsignados)): ?>
                <small class="text-success">(Actualmente asignado)</small>
            <?php endif; ?>
        </label>
    </div>
<?php endforeach; ?>
    </div>
</div>

<label class="form-label">Nueva dirección</label>
                        <div class="row g-2 mb-3 align-items-center">
                            <div class="col-md-3">
                                <select class="form-select" id="via_principal" name="via_principal" required>
                                    <option value="" disabled <?php echo empty($partes['via_principal']) ? 'selected' : ''; ?>>Vía principal *</option>
                                    <?php
                                    include_once '../controller/Sitios/direcciones.php';
                                    foreach (VIA_PRINCIPAL as $v): ?>
                                        <option value="<?php echo $v; ?>" <?php echo ($partes['via_principal'] == $v) ? 'selected' : ''; ?>><?php echo $v; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select class="form-select" id="numero_via" name="numero_via" required>
                                    <option value="" disabled <?php echo empty($partes['numero_via']) ? 'selected' : ''; ?>>Número *</option>
                                    <?php foreach ($numero_de_via as $v): ?>
                                        <option value="<?php echo $v; ?>" <?php echo ($partes['numero_via'] == $v) ? 'selected' : ''; ?>><?php echo $v; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select class="form-select" id="sufijo_via" name="sufijo_via">
                                    <option value="" disabled <?php echo empty($partes['sufijo_via']) ? 'selected' : ''; ?>>Sufijo</option>
                                    <?php foreach (SUFIJO_VIA as $key => $label): ?>
                                        <option value="<?php echo $key; ?>" <?php echo ($partes['sufijo_via'] == $key) ? 'selected' : ''; ?>><?php echo $key; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-1 text-center">
                                <span class="fs-4 fw-bold">#</span>
                            </div>
                            <div class="col-md-2">
                                <select class="form-select" id="cruce_prefijo" name="cruce_prefijo">
                                    <option value="" disabled <?php echo empty($partes['cruce_prefijo']) ? 'selected' : ''; ?>>Prefijo</option>
                                    <?php foreach (CRUCE_PREFIJO as $key => $label): ?>
                                        <option value="<?php echo $key; ?>" <?php echo ($partes['cruce_prefijo'] == $key) ? 'selected' : ''; ?>><?php echo $label; ?> (<?php echo $key; ?>)</option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>


                          <div class="row g-2 mb-3 align-items-center">
                            <div class="col-md-4">
                                <select class="form-select" id="via_generadora" name="via_generadora" required>
                                    <option value="" disabled <?php echo empty($partes['via_generadora']) ? 'selected' : ''; ?>>Vía generadora *</option>
                                    <?php foreach ($numero_de_la_via_generadora as $v): ?>
                                        <option value="<?php echo $v; ?>" <?php echo ($partes['via_generadora'] == $v) ? 'selected' : ''; ?>><?php echo $v; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select class="form-select" id="sufijo_generadora" name="sufijo_generadora">
                                    <option value="" disabled <?php echo empty($partes['sufijo_generadora']) ? 'selected' : ''; ?>>Sufijo</option>
                                    <?php foreach (SUFIJO_VIA as $key => $label): ?>
                                        <option value="<?php echo $key; ?>" <?php echo ($partes['sufijo_generadora'] == $key) ? 'selected' : ''; ?>><?php echo $key; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-1 text-center">
                                <span class="fs-4 fw-bold">-</span>
                            </div>
                            <div class="col-md-4">
                                <select class="form-select" id="placa" name="placa" required>
                                    <option value="" disabled <?php echo empty($partes['placa']) ? 'selected' : ''; ?>>Placa *</option>
                                    <?php foreach ($numero_de_placa as $v): ?>
                                        <option value="<?php echo $v; ?>" <?php echo ($partes['placa'] == $v) ? 'selected' : ''; ?>><?php echo $v; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="row g-2 mb-3">
                            <div class="col-md-6">
                                <select class="form-select" id="barrio" name="barrio" required>
                                    <option value="" selected disabled>Barrio *</option>
                                    <?php foreach ($barrios as $b) {
                                        $selected = ($d['id_barrio'] == $b['id_barrio']) ? "selected" : "";
                                        echo "<option value='" . $b['id_barrio'] . "' $selected>" . $b['nombre_barrio'] . "</option>";
                                    } ?>
                                </select>
                            </div>
            

            

            <div class="mb-4">
              <label for="id_estado" class="form-label">Estado</label>
              <select class="form-select" id="id_estado" name="id_estado" required>
                <option value="">Selecciona un estado</option>
                <?php foreach ($estados as $est) {
                  if ($d['id_estado'] == $est['id_estado']) {
                    $selected = "selected";
                  } else {
                    $selected = "";
                  }
                  print_r($d);
                  echo "<option value='" . $est['id_estado'] . "' $selected>" . $est['nombre_estado'] . "</option>";
                }; ?>
              </select>
            </div>


        </div>
      <?php
          };
      ?>
      <div class="modal-footer gap-2">
        <a href="<?php echo getUrl('Zoocriadero', 'Zoocriadero', 'getConsultar') ?>" class="btn btn-secondary">Cancelar</a>
        <button type="submit" class="btn btn-primary">Guardar cambios</button>
      </div>
      </form>
    </div>
  </div>
</div>