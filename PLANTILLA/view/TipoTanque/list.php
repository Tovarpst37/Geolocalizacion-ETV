<style>
.tanque-page {
  --blue-primary: #2563eb;
  --blue-hover: #1d4ed8;
  --blue-soft: #eff6ff;
  --blue-border: #bfdbfe;
  --ink: #1e293b;
  --muted: #64748b;
  --line: #e2e8f0;
  --bg-card: #ffffff;
}

.tanque-header {
  display: flex;
  justify-content: center;
  align-items: center;
  gap: .75rem;
  margin-bottom: 1.5rem;
}
.tanque-header h3 {
  color: var(--ink);
  font-weight: 700;
  margin: 0;
  font-size: 1.4rem;
}
.tanque-header i {
  color: var(--blue-primary);
  font-size: 1.75rem;
}

.tanque-list-container {
  display: flex;
  flex-direction: column;
  gap: .85rem;
  width: 100%;
}

.tanque-list-item {
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
}

@media (min-width: 768px) {
  .tanque-list-item {
    flex-direction: row;
    align-items: center;
    justify-content: space-between;
    padding: 1rem 1.25rem;
  }
}

.tanque-list-item:hover {
  border-color: var(--blue-border);
  box-shadow: 0 4px 14px rgba(37, 99, 235, 0.08);
}

.tanque-info {
  display: flex;
  flex-direction: column;
  gap: .35rem;
  flex: 1;
  min-width: 0;
}

.tanque-nombre {
  font-size: 1.05rem;
  font-weight: 700;
  color: var(--ink);
  margin: 0;
  display: flex;
  align-items: center;
  gap: .5rem;
}
.tanque-nombre i {
  color: var(--blue-primary);
  font-size: 1.15rem;
}

.tanque-descripcion {
  font-size: .875rem;
  color: var(--muted);
  margin: 0;
  display: flex;
  align-items: flex-start;
  gap: .4rem;
  line-height: 1.4;
}
.tanque-descripcion i {
  margin-top: .15rem;
  flex-shrink: 0;
}

.tanque-actions-wrap {
  display: flex;
  align-items: center;
  justify-content: flex-end;
  gap: .5rem;
  width: 100%;
  border-top: 1px dashed var(--line);
  padding-top: .85rem;
}

@media (min-width: 768px) {
  .tanque-actions-wrap {
    width: auto;
    border-top: none;
    padding-top: 0;
  }
}

.btn-blue {
  background-color: var(--blue-primary);
  color: #ffffff;
  border: none;
  font-size: .85rem;
  font-weight: 600;
  padding: .45rem .9rem;
  border-radius: 8px;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: .35rem;
  transition: all .15s ease;
  text-decoration: none;
  cursor: pointer;
}
.btn-blue:hover {
  background-color: var(--blue-hover);
  color: #ffffff;
}

.btn-outline-green {
  background-color: #ffffff;
  color: #16a34a;
  border: 1.5px solid #86efac;
  font-size: .85rem;
  font-weight: 600;
  padding: .43rem .9rem;
  border-radius: 8px;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: .35rem;
  transition: all .15s ease;
  cursor: pointer;
}
.btn-outline-green:hover {
  background-color: #f0fdf4;
}

.btn-outline-red {
  background-color: #ffffff;
  color: #dc2626;
  border: 1.5px solid #fca5a5;
  font-size: .85rem;
  font-weight: 600;
  padding: .43rem .9rem;
  border-radius: 8px;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: .35rem;
  transition: all .15s ease;
  cursor: pointer;
}
.btn-outline-red:hover {
  background-color: #fef2f2;
}
</style>

<div class="tanque-page container-fluid px-2 px-md-3">

  <div class="tanque-header">
    <i class="bx bxs-color-fill"></i>
    <h3>Tipos de Tanque</h3>
  </div>

  <div class="tanque-list-container">
    <?php foreach ($tipo_tanque as $tanque): ?>
      <div class="tanque-list-item">

        <div class="tanque-info">
          <h6 class="tanque-nombre">
            <i class="bx bx-water"></i>
            <span><?php echo $tanque['nombre_tipo_tanque']; ?></span>
          </h6>

          <?php if ($tanque['descripcion'] != ""): ?>
            <p class="tanque-descripcion">
              <i class="bx bx-align-left"></i>
              <span><?php echo $tanque['descripcion']; ?></span>
            </p>
          <?php endif; ?>
        </div>

        <div class="tanque-actions-wrap">
          <button
            type="button"
            class="btn-blue"
            data-bs-toggle="modal"
            data-bs-target="#modalEditarTanque"
            data-id="<?php echo $tanque['id_tipo_tanque']; ?>"
            data-nombre="<?= htmlspecialchars($item['nombre_tipo_tanque'] ?? '') ?>"
            data-descripcion="<?= htmlspecialchars($item['descripcion_tipo_tanque'] ?? '') ?>"
          >
            <i class="bx bx-edit-alt"></i> Editar
          </button>

          <?php if ((int)$tanque['estado'] === 1): ?>
            <button
              type="button"
              class="btn-outline-green"
              data-bs-toggle="modal"
              data-bs-target="#modalDeshabilitarTanque"
              data-id="<?php echo $tanque['id_tipo_tanque']; ?>"
              data-nombre="<?php echo htmlspecialchars($tanque['nombre_tipo_tanque'], ENT_QUOTES); ?>"
            >
              <i class="bx bx-check-circle"></i> Deshabilitar
            </button>
          <?php else: ?>
            <button
              type="button"
              class="btn-outline-red"
              data-bs-toggle="modal"
              data-bs-target="#modalHabilitarTanque"
              data-id="<?php echo $tanque['id_tipo_tanque']; ?>"
              data-nombre="<?php echo htmlspecialchars($tanque['nombre_tipo_tanque'], ENT_QUOTES); ?>"
            >
              <i class="bx bx-x-circle"></i> Habilitar
            </button>
          <?php endif; ?>
        </div>

      </div>
    <?php endforeach; ?>
  </div>

</div>

<?php include_once '../view/TipoTanque/edit.php'; ?>
<?php include_once '../view/TipoTanque/estado.php'; ?>
<script src="js/expre/letras.js"></script>
<script src="js/soloLetras.js"></script>