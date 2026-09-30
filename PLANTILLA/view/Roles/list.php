<style>
.roles-page {
  --blue-primary: #2563eb;
  --blue-hover: #1d4ed8;
  --blue-soft: #eff6ff;
  --blue-border: #bfdbfe;
  --ink: #1e293b;
  --muted: #64748b;
  --line: #e2e8f0;
  --bg-card: #ffffff;
}

.roles-header {
  display: flex;
  justify-content: center;
  align-items: center;
  gap: .75rem;
  margin-bottom: 1.5rem;
}
.roles-header h3 {
  color: var(--ink);
  font-weight: 700;
  margin: 0;
  font-size: 1.4rem;
}
.roles-header i {
  color: var(--blue-primary);
  font-size: 1.75rem;
}

.roles-list-container {
  display: flex;
  flex-direction: column;
  gap: .85rem;
  width: 100%;
}

.roles-list-item {
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
  .roles-list-item {
    flex-direction: row;
    align-items: center;
    justify-content: space-between;
    padding: 1rem 1.25rem;
  }
}

.roles-list-item:hover {
  border-color: var(--blue-border);
  box-shadow: 0 4px 14px rgba(37, 99, 235, 0.08);
}

.roles-info {
  display: flex;
  flex-direction: column;
  gap: .35rem;
  flex: 1;
  min-width: 0;
}

.roles-name {
  font-size: 1.05rem;
  font-weight: 700;
  color: var(--ink);
  margin: 0;
  display: flex;
  align-items: center;
  gap: .5rem;
}
.roles-name i {
  color: var(--blue-primary);
  font-size: 1.15rem;
}

.roles-id {
  font-size: .875rem;
  color: var(--muted);
  margin: 0;
  display: flex;
  align-items: center;
  gap: .4rem;
}

.roles-actions-wrap {
  display: flex;
  align-items: center;
  justify-content: flex-end;
  width: 100%;
  border-top: 1px dashed var(--line);
  padding-top: .85rem;
}

@media (min-width: 768px) {
  .roles-actions-wrap {
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
}
.btn-blue:hover {
  background-color: var(--blue-hover);
  color: #ffffff;
}
</style>
<?php include_once '../view/partials/function.php'; ?>

<div class="roles-page container-fluid px-2 px-md-3">

  <div class="roles-header">
    <i class="bx bxs-user-detail"></i>
    <h3>Roles</h3>
  </div>

  <div class="roles-list-container">
    <?php foreach($roles as $rol): ?>
      <div class="roles-list-item">

        <div class="roles-info">
          <h6 class="roles-name">
            <i class="bx bx-id-card"></i>
            <span><?php echo $rol['nombre_rol']; ?></span>
          </h6>
          <p class="roles-id">
            <i class="bx bx-hash"></i>
            <span>ID: <?php echo $rol['id_rol']; ?></span>
          </p>
        </div>

        <div class="roles-actions-wrap">
          <?php if (condicion('EDITAR','Roles')): ?>
            <a href="<?php echo getUrl("Roles","Roles","getEdit") . "&id_rol=" . $rol['id_rol']; ?>"
               class="btn btn-blue">
              <i class="bx bx-edit-alt"></i> Editar
            </a>
          <?php endif; ?>
        </div>

      </div>
    <?php endforeach; ?>
  </div>

</div>