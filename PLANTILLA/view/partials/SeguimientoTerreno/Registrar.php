<div class="container mt-4">
  <div class="d-flex justify-content-center">
    <div class="card shadow" style="width: 100%; max-width: 700px;">
      <div class="card-header bg-primary text-white">
        <h4 class="mb-0">Registrar Seguimiento terreno </h4>
      </div>

      <div class="card-body p-4">
        <form action="<?php echo getUrl("Seguimientoterreno","Seguimientoterreno","postRegistrar")?>" method="POST" enctype="multipart/form-data">

          <div class="mb-3">
            <label for="codigo_tanque" class="form-label">Codigo del Seguimiento</label>
            <input type="text" class="form-control" id="codigo_tanque" name="codigo_tanque" value = "SEGUIMIENTO# <?php echo $id_seg[0]['max'] + 1;  ?>" disabled>
            <input type="hidden" name="codigo" value = "SEGUIMIENTO# <?php echo $id_seg[0]['max'] + 1;  ?>">

          <div class="mb-4">
            <label for="id_estado" class="form-label">Sitio*</label>
            <select class="form-select" id="select_ter" name="select_ter" required>
              <option value="" selected disabled>Selecciona un Sitio</option>
              <?php foreach($sitio as $zoo){  ?>
                <option value="<?php echo $zoo['id_sitio']; ?>">
                  <?php echo $zoo['nombre_sitio']; ?>
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
            <label for="id_estado" class="form-label">Deposito*</label>
            <select class="form-select" id="selectTerreno" name="selectTerreno" required disabled>
              <option value="" selected disabled>Primero selecciona un Sitio</option>
              
            </select>
          </div>


          <div class="mb-4">
            <label for="id_estado" class="form-label">Auxiliar Asignado*</label>
            <select class="form-select" id="selectUsuarios" name="selectUsuarios" required disabled>
              <option value="" selected >Primero selecciona un Sitio</option>
              
                
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
                            value="<?php echo $act['id_actividad_terreno']; ?>" 
                            id="act<?php echo $act['id_actividad_terreno']; ?>">
                      <label class="form-check-label" for="act<?php echo $act['id_actividad_terreno']; ?>">
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
document.querySelector('#select_ter').addEventListener('change', function(e){
    
    const idsitio = e.target.value;
    
    fetch('ajax.php?modulo=SeguimientoTerreno&controlador=SeguimientoTerreno&funcion=getSitios&id_sitio=' + idsitio)
        .then(response => response.json())
        .then(data => {
            
            const selectTerreno = document.querySelector('#selectTerreno');
            
            if(data.terreno.length === 0){
                selectTerreno.innerHTML = '<option value="">No hay terreno disponibles</option>';
                selectTerreno.disabled = true;
            } else {
                let opcionesTerreno = '';
                data.terreno.forEach(terreno => {
                    opcionesTerreno += `<option value="${terreno.id_sitio_deposito}">${terreno.nombre}</option>`;
                });
                selectTerreno.innerHTML = opcionesTerreno;
                selectTerreno.disabled = false;
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