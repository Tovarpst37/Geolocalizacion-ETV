<div class="container mt-4">
  <div class="d-flex justify-content-center">
    <div class="card shadow" style="width: 100%; max-width: 700px;">
      <div class="card-header bg-primary text-white">
        <h4 class="mb-0">Registrar Seguimiento Zoocriadero </h4>
      </div>

      <div class="card-body p-4">
        <form action="<?php echo getUrl("SeguimientoZoocriadero","SeguimientoZoocriadero","postRegistrar")?>" method="POST" enctype="multipart/form-data">

          <div class="mb-3">
            <label for="codigo_tanque" class="form-label">Codigo del Seguimiento</label>
            <input type="text" class="form-control" id="codigo_Seguimiento" name="codigo_Seguimiento" placeholder="Ej: ZOO-MELENDEZ-02" required>
          </div>

          <div class="mb-4">
            <label for="id_estado" class="form-label">Zoocriadero*</label>
            <select class="form-select" id="select_zoo" name="select_zoo" required>
              <option value="" selected disabled>Selecciona un Zoocriadero</option>
              <?php foreach($zoocriaderos as $zoo){  ?>
                <option value="<?php echo $zoo['id_zoocriadero']; ?>">
                  <?php echo $zoo['cod_zoocriadero']; ?>
                </option>
              <?php }; ?>
            </select>
          </div>

          

          <div class="mb-3">
            <label class="form-label">Horario*</label>
            <select class="form-select" id="horario" name="horario" required>
                <option value="" selected disabled>Selecciona un horario</option>
                <option value="06:00-12:00">6:00AM - 12:00PM</option>
                <option value="12:00-17:00">12:00PM - 5:00PM</option>
            </select>
          </div>

          <div class="mb-4">
            <label for="id_estado" class="form-label">Tanque*</label>
            <select class="form-select" id="selectTanques" name="selectTanques" required disabled>
              <option value="" selected disabled>Primero selecciona un zoocriadero</option>
              
            </select>
          </div>


          <div class="mb-4">
            <label for="id_estado" class="form-label">Auxiliar Asignado*</label>
            <select class="form-select" id="selectUsuarios" name="selectUsuarios" required disabled>
              <option value="" selected >Primero selecciona un zoocriadero</option>
              
                
            </select>
          </div>

          <div class="mb-4">
            <label for="id_estado" class="form-label">Estado*</label>
            <select class="form-select" id="id_estado" name="id_estado" required>
              <option value="" selected disabled>Selecciona un estado</option>
              <?php foreach($estados as $est){  ?>
                <option value="<?php echo $est['id_estado']; ?>">
                  <?php echo $est['nombre_estado']; ?>
                </option>
              <?php }; ?>
            </select>
          </div>


          <div class="mb-4">
              <label class="form-label">Actividades a realizar</label>
              
              <?php foreach($actividades as $act){ ?>
                  <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="actividades[]"  style="width: 1.5em; height: 1.5em;"
                            value="<?php echo $act['id_actividad_zoo']; ?>" 
                            id="act<?php echo $act['id_actividad_zoo']; ?>">
                      <label class="form-check-label" for="act<?php echo $act['id_actividad_zoo']; ?>">
                          <?php echo $act['nombre_actividad']; ?>
                      </label>
                  </div>
              <?php } ?>
          </div>

          

          <div class="d-flex justify-content-end gap-2">
            <button type="reset" class="btn btn-outline-secondary">Limpiar</button>
            <button type="submit" class="btn btn-primary">Guardar zoocriadero</button>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>

<script>
document.querySelector('#select_zoo').addEventListener('change', function(e){
    
    const idZoocriadero = e.target.value;
    
    fetch('ajax.php?modulo=SeguimientoZoocriadero&controlador=SeguimientoZoocriadero&funcion=getTanquesPorZoo&id_zoocriadero=' + idZoocriadero)
        .then(response => response.json())
        .then(data => {
            
            const selectTanques = document.querySelector('#selectTanques');
            
            if(data.tanques.length === 0){
                selectTanques.innerHTML = '<option value="">No hay tanques disponibles</option>';
                selectTanques.disabled = true;
            } else {
                let opcionesTanques = '';
                data.tanques.forEach(tanque => {
                    opcionesTanques += `<option value="${tanque.id_tanque}">${tanque.codigo_tanque}</option>`;
                });
                selectTanques.innerHTML = opcionesTanques;
                selectTanques.disabled = false;
            }
            
            const selectUsuarios = document.querySelector('#selectUsuarios');
            
            if(data.usuarios.length === 0){
                selectUsuarios.innerHTML = '<option value="">No hay auxiliares disponibles</option>';
                selectUsuarios.disabled = true;
            } else {
                let opcionesUsuarios = '';
                data.usuarios.forEach(usuario => {
                    opcionesUsuarios += `<option value="${usuario.id_usuario}">${usuario.primer_nombre} ${usuario.primer_apellido}</option>`;
                });
                selectUsuarios.innerHTML = opcionesUsuarios;
                selectUsuarios.disabled = false;
            }
            
        });
    
});
</script>