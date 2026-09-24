<?php 
include_once '../view/usuario/edit.php';
include_once '../view/usuario/habilitar.php';
include_once '../view/usuario/disable.php';
include_once '../view/usuario/verMas.php';
include_once '../view/partials/function.php';
?>
<style>
.usr-page {
  --blue-primary: #2563eb;
  --blue-hover: #1d4ed8;
  --blue-soft: #eff6ff;
  --blue-border: #bfdbfe;
  --ink: #1e293b;
  --muted: #64748b;
  --line: #e2e8f0;
  --bg-card: #ffffff;
  --success: #16a34a;
  --success-bg: #f0fdf4;
  --danger: #dc2626;
  --danger-bg: #fef2f2;
}

/* Header principal */
.usr-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  flex-wrap: wrap;
  gap: 1rem;
  margin-bottom: 1.5rem;
}
.usr-title-group {
  display: flex;
  align-items: center;
  gap: .75rem;
}
.usr-title-group h3 {
  color: var(--ink);
  font-weight: 700;
  margin: 0;
  font-size: 1.4rem;
}
.usr-title-group i {
  color: var(--blue-primary);
  font-size: 1.75rem;
}

/* Buscador */
.usr-search-wrap {
  width: 100%;
}
@media (min-width: 576px) {
  .usr-search-wrap {
    width: auto;
    min-width: 280px;
  }
}
.usr-search {
  position: relative;
  display: flex;
  align-items: center;
  width: 100%;
}
.usr-search .form-control {
  padding-left: 2.5rem;
  padding-right: 2.75rem;
  border-radius: 10px;
  border: 1px solid var(--line);
  background-color: #ffffff;
  height: 2.6rem;
  font-size: .9rem;
  transition: all .15s ease;
  width: 100%;
}
.usr-search .form-control:focus {
  border-color: var(--blue-primary);
  box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
}
.usr-search .usr-search-icon {
  position: absolute;
  left: .85rem;
  color: var(--muted);
  font-size: 1.1rem;
  pointer-events: none;
}
.usr-search .usr-btn-search {
  position: absolute;
  right: .25rem;
  border: 0;
  background: var(--blue-soft);
  color: var(--blue-primary);
  height: 2.1rem;
  width: 2.1rem;
  border-radius: 8px;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: background .15s ease;
}
.usr-search .usr-btn-search:hover {
  background: var(--blue-border);
}

/* Lista de tarjetas */
.usr-list-container {
  display: flex;
  flex-direction: column;
  gap: .85rem;
  width: 100%;
}

.usr-list-item {
  background: var(--bg-card);
  border: 1px solid var(--line);
  border-radius: 16px;
  padding: 1.1rem;
  display: flex;
  flex-direction: column;
  gap: 0.85rem;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
  transition: all .2s ease;
  width: 100%;
  min-width: 0;
  overflow: hidden;
}

@media (min-width: 768px) {
  .usr-list-item {
    flex-direction: row;
    align-items: center;
    justify-content: space-between;
    padding: 1rem 1.25rem;
    gap: 1.25rem;
  }
}

.usr-list-item:hover {
  border-color: var(--blue-border);
  box-shadow: 0 4px 14px rgba(37, 99, 235, 0.08);
}

/* Info del usuario */
.usr-info {
  display: flex;
  align-items: center;
  gap: .85rem;
  flex: 1;
  min-width: 0;
}

.usr-avatar {
  width: 42px;
  height: 42px;
  border-radius: 50%;
  background-color: var(--blue-primary);
  color: #ffffff;
  font-weight: 700;
  font-size: .9rem;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
}

.usr-info-text {
  min-width: 0;
  display: flex;
  flex-direction: column;
  gap: .15rem;
}

.usr-name {
  font-size: 1rem;
  font-weight: 700;
  color: var(--ink);
  margin: 0;
  word-wrap: break-word;
}

.usr-doc {
  font-size: .85rem;
  color: var(--muted);
  margin: 0;
  display: flex;
  align-items: center;
  gap: .35rem;
}
.usr-doc i {
  color: var(--muted);
  font-size: 1rem;
  flex-shrink: 0;
}

/* Lado derecho: badge + botones */
.usr-actions-wrap {
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  gap: .75rem;
  width: 100%;
  border-top: 1px dashed var(--line);
  padding-top: .85rem;
}

@media (min-width: 768px) {
  .usr-actions-wrap {
    width: auto;
    border-top: none;
    padding-top: 0;
    flex-direction: row;
    align-items: center;
    justify-content: flex-end;
  }
}

.usr-btn-group {
  display: flex;
  flex-direction: column;
  gap: .5rem;
  width: 100%;
}

@media (min-width: 400px) {
  .usr-btn-group {
    flex-direction: row;
  }
}

@media (min-width: 768px) {
  .usr-btn-group {
    width: auto;
  }
}

.usr-btn-group .btn {
  font-size: .85rem;
  font-weight: 600;
  padding: .45rem .9rem;
  border-radius: 8px;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: .35rem;
  transition: all .15s ease;
  width: 100%;
  white-space: nowrap;
  box-sizing: border-box;
}

@media (min-width: 400px) {
  .usr-btn-group .btn {
    flex: 1;
  }
}

@media (min-width: 768px) {
  .usr-btn-group .btn {
    flex: initial;
    width: auto;
  }
}

.usr-btn-outline {
  background-color: #ffffff;
  color: var(--muted);
  border: 1px solid var(--line);
}
.usr-btn-outline:hover {
  background-color: #f8fafc;
  color: var(--ink);
}

.usr-btn-blue {
  background-color: var(--blue-primary);
  color: #ffffff;
  border: none;
}
.usr-btn-blue:hover {
  background-color: var(--blue-hover);
  color: #ffffff;
}

.usr-btn-green-soft {
  background-color: var(--success-bg);
  color: var(--success);
  border: 1px solid rgba(22, 163, 74, 0.2);
}
.usr-btn-green-soft:hover {
  background-color: var(--success);
  color: #ffffff;
}

.usr-btn-red-soft {
  background-color: var(--danger-bg);
  color: var(--danger);
  border: 1px solid rgba(220, 38, 38, 0.2);
}
.usr-btn-red-soft:hover {
  background-color: var(--danger);
  color: #ffffff;
}

.usr-self-lock {
  color: var(--muted);
  display: inline-flex;
  align-items: center;
}
</style>

<div class="usr-page container-fluid px-2 px-md-3">

  <!-- Cabecera y Buscador -->
  <div class="usr-header">
    <div class="usr-title-group">
      <i class="bx bxs-user-detail"></i>
      <h3>Usuarios</h3>
    </div>

    <div class="usr-search-wrap">
      <form action="index.php" method="GET" class="m-0">
        <input type="hidden" name="modulo" value="Usuario">
        <input type="hidden" name="controlador" value="Usuario">
        <input type="hidden" name="funcion" value="getBuscar">

        <div class="usr-search">
          <i class="bx bx-search usr-search-icon"></i>
          <input type="txt" name="busqueda" placeholder="Buscar por documento..." class="form-control" value="<?php echo $palabra ?? ''; ?>">
          <button type="submit" class="usr-btn-search soloNumeros" aria-label="Buscar">
            <i class="bx bx-right-arrow-alt fs-5"></i>
          </button>
        </div>
      </form>
    </div>
  </div>

  <!-- Lista de tarjetas -->
  <div class="usr-list-container">
    <?php foreach ($usuarios as $usu) {
        $nombreCompleto = trim($usu['primer_nombre'] . ' ' . $usu['segundo_nombre'] . ' ' . $usu['primer_apellido'] . ' ' . $usu['segundo_apellido']);
        $iniciales = mb_strtoupper(mb_substr($usu['primer_nombre'], 0, 1) . mb_substr($usu['primer_apellido'], 0, 1));
    ?>
      <div class="usr-list-item">

        <!-- Datos del usuario -->
        <div class="usr-info">
          <div class="usr-avatar"><?php echo $iniciales; ?></div>
          <div class="usr-info-text">
            <p class="usr-name"><?php echo $nombreCompleto; ?></p>
            <p class="usr-doc"><i class="bx bx-id-card"></i><?php echo $usu['documento']; ?></p>
          </div>
        </div>

        <!-- Acciones -->
        <div class="usr-actions-wrap">
          <div class="usr-btn-group">
          <?php if (condicion('VER', 'Usuarios')): ?>
              <button type="button"
                  class="btn usr-btn-outline"
                  data-bs-toggle="modal"
                  data-bs-target="#modalVerMas"
                  data-vm-id-usuario="<?php echo $usu['id_usuario']; ?>"
                  data-vm-primer-nombre="<?php echo $usu['primer_nombre']; ?>"
                  data-vm-segundo-nombre="<?php echo $usu['segundo_nombre']; ?>"
                  data-vm-primer-apellido="<?php echo $usu['primer_apellido']; ?>"
                  data-vm-segundo-apellido="<?php echo $usu['segundo_apellido']; ?>"
                  data-vm-tipo-documento="<?php echo $usu['tipo_documento']; ?>"
                  data-vm-documento="<?php echo $usu['documento']; ?>"
                  data-vm-fecha-nacimiento="<?php echo $usu['fecha_nacimiento']; ?>"
                  data-vm-correo="<?php echo $usu['correo']; ?>"
                  data-vm-genero="<?php echo $usu['genero_usuario']; ?>"
                  data-vm-rol="<?php echo $usu['rol_usuario']; ?>"
                  data-vm-rh="<?php echo $usu['rh_usuario']; ?>">
                  <i class="bi bi-eye"></i> Ver más
              </button>
          <?php endif; ?>

          <?php if (condicion('EDITAR', 'Usuarios')): ?>
              <button type="button"
                  class="btn usr-btn-blue"
                  data-bs-toggle="modal"
                  data-bs-target="#modalEditar"
                  data-id-usuario="<?php echo $usu['id_usuario']; ?>"
                  data-primer-nombre="<?php echo $usu['primer_nombre']; ?>"
                  data-segundo-nombre="<?php echo $usu['segundo_nombre']; ?>"
                  data-primer-apellido="<?php echo $usu['primer_apellido']; ?>"
                  data-segundo-apellido="<?php echo $usu['segundo_apellido']; ?>"
                  data-id-tipo-documento="<?php echo $usu['id_tipo_documento']; ?>"
                  data-documento="<?php echo $usu['documento']; ?>"
                  data-fecha-nacimiento="<?php echo $usu['fecha_nacimiento']; ?>"
                  data-correo="<?php echo $usu['correo']; ?>"
                  data-id-genero="<?php echo $usu['id_genero']; ?>"
                  data-id-rol="<?php echo $usu['id_rol']; ?>"
                  data-id-rh="<?php echo $usu['id_rh']; ?>">
                  <i class="bi bi-pencil-square"></i> Editar
              </button>
          <?php endif; ?>

          <?php if ((int)$usu['id_usuario'] === (int)$_SESSION['id_usuarioU']): ?>
              <span class="usr-self-lock" title="No puedes cambiar tu propio estado">
                  <i class="bx bxs-x-circle" style="font-size: 26px;"></i>
              </span>
          <?php elseif (condicion('ELIMINAR', 'Usuarios')): ?>
              <?php if ((int)$usu['id_estado'] === 1): ?>
                  <button type="button" class="btn usr-btn-green-soft" data-bs-toggle="modal" data-bs-target="#modalEstado"
                      data-id-usuario="<?php echo $usu['id_usuario']; ?>"
                      data-id-estado-actual="<?php echo $usu['id_estado']; ?>">
                      <i class="bi bi-check-circle"></i> Habilitado
                  </button>
              <?php else: ?>
                  <button type="button" class="btn usr-btn-red-soft" data-bs-toggle="modal" data-bs-target="#modalEstadoH"
                      data-id-usuario="<?php echo $usu['id_usuario']; ?>"
                      data-id-estado-actual="<?php echo $usu['id_estado']; ?>">
                      <i class="bi bi-x-circle"></i> Deshabilitado
                  </button>
              <?php endif; ?>
          <?php else: ?>
              <span class="badge <?php echo ((int)$usu['id_estado'] === 1) ? 'bg-success' : 'bg-danger'; ?>">
                  <?php echo ((int)$usu['id_estado'] === 1) ? 'Habilitado' : 'Deshabilitado'; ?>
              </span>
          <?php endif; ?>

          </div>
        </div>

      </div>
    <?php } ?>
  </div>

</div>

<script src="../view/usuario/js/list.js"></script>