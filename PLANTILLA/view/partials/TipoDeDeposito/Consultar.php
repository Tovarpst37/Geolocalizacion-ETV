<style>
  /* Contenedor principal */
  .consult-container {
    width: 100%;
    max-width: 1200px;
    margin: 0 auto;
    padding: 1rem 0.5rem;
    box-sizing: border-box;
  }

  /* Alerta de Éxito */
  .alert-original-custom {
    background-color: #ffffff;
    border: none;
    border-left: 5px solid #059669; /* Borde lateral verde */
    border-radius: 12px;
    padding: 1rem 1.25rem;
    color: #1e293b;
    font-size: 0.95rem;
    font-weight: 500;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
  }

  /* Encabezado */
  .header-section {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    margin-bottom: 1.5rem;
  }

  @media (min-width: 640px) {
    .header-section {
      flex-direction: row;
      justify-content: space-between;
      align-items: center;
    }
  }

  .header-title-group {
    display: flex;
    align-items: center;
    gap: 0.75rem;
  }

  .header-icon {
    color: #2563eb;
    font-size: 1.8rem;
    display: flex;
    align-items: center;
  }

  .header-title {
    font-size: 1.35rem;
    font-weight: 700;
    color: #0f172a;
    margin: 0;
  }

  /* Formulario de Búsqueda */
  .search-form {
    margin: 0;
    width: 100%;
  }

  @media (min-width: 640px) {
    .search-form {
      width: auto;
    }
  }

  .search-box-wrapper {
    background-color: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 50px;
    padding: 0.35rem 0.5rem 0.35rem 1rem;
    display: flex;
    align-items: center;
    width: 100%;
    box-sizing: border-box;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
    transition: all 0.2s ease;
  }

  @media (min-width: 640px) {
    .search-box-wrapper {
      width: 320px;
    }
  }

  .search-box-wrapper:focus-within {
    border-color: #2563eb;
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
  }

  .search-box-wrapper i.search-icon {
    color: #94a3b8;
    font-size: 1.15rem;
    margin-right: 0.5rem;
  }

  .search-input {
    border: none !important;
    outline: none !important;
    box-shadow: none !important;
    background: transparent;
    font-size: 0.88rem;
    color: #1e293b;
    width: 100%;
    min-width: 0;
  }

  .search-btn {
    background-color: #eff6ff;
    border: none;
    color: #2563eb;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s ease;
    flex-shrink: 0;
  }

  .search-btn:hover {
    background-color: #2563eb;
    color: #ffffff;
  }

  /* Tarjetas de Registros */
  .item-card {
    background-color: #ffffff;
    border-radius: 18px;
    border: 1px solid #f1f5f9;
    padding: 1.1rem;
    margin-bottom: 0.85rem;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.03), 0 2px 4px -2px rgba(0, 0, 0, 0.03);
    display: flex;
    flex-direction: column;
    gap: 1rem;
    transition: all 0.2s ease;
    box-sizing: border-box;
    width: 100%;
  }

  @media (min-width: 850px) {
    .item-card {
      flex-direction: row;
      align-items: center;
      justify-content: space-between;
      padding: 1rem 1.5rem;
    }
  }

  .item-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -4px rgba(0, 0, 0, 0.02);
  }

  .item-info {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
  }

  .item-title-row {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #1e293b;
    font-weight: 700;
    font-size: 1rem;
    word-break: break-word;
  }

  .item-title-row i {
    color: #2563eb;
    font-size: 1.1rem;
    flex-shrink: 0;
  }

  .item-subtitle {
    display: flex;
    align-items: center;
    gap: 0.35rem;
    color: #64748b;
    font-size: 0.85rem;
  }

  /* Bloque de Acciones */
  .item-actions-wrapper {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 0.75rem;
    width: 100%;
    border-top: 1px solid #f8fafc;
    padding-top: 0.75rem;
  }

  @media (min-width: 850px) {
    .item-actions-wrapper {
      width: auto;
      border-top: none;
      padding-top: 0;
    }
  }

  /* Botón Editar */
  .btn-action-edit {
    background-color: #2563eb;
    color: #ffffff;
    border: none;
    font-size: 0.85rem;
    font-weight: 600;
    padding: 0.45rem 0.9rem;
    border-radius: 10px;
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    text-decoration: none;
    transition: all 0.2s ease;
    white-space: nowrap;
  }

  .btn-action-edit:hover {
    background-color: #1d4ed8;
    color: #ffffff;
  }

  /* Estado vacío */
  .empty-card {
    background-color: #ffffff;
    border-radius: 18px;
    padding: 3rem 1.5rem;
    text-align: center;
    color: #64748b;
    border: 1px solid #f1f5f9;
  }

  .empty-card i {
    font-size: 3rem;
    color: #cbd5e1;
    margin-bottom: 0.5rem;
  }
</style>

<div class="consult-container">

  <!-- Mensaje de éxito -->
  <?php if (!empty($_SESSION['mensaje_exito'])): ?>
    <div id="alertaExito" class="alert-original-custom" role="alert">
      <span><?php echo $_SESSION['mensaje_exito']; ?></span>
      <button type="button" class="btn-close ms-3" onclick="document.getElementById('alertaExito').remove();" aria-label="Cerrar"></button>
    </div>
    <?php unset($_SESSION['mensaje_exito']); ?>

    <script>
      setTimeout(function() {
        var alerta = document.getElementById('alertaExito');
        if (alerta) {
          alerta.style.transition = "opacity 0.4s ease, transform 0.4s ease";
          alerta.style.opacity = "0";
          alerta.style.transform = "translateY(-10px)";
          setTimeout(function() { alerta.remove(); }, 400);
        }
      }, 4000);
    </script>
  <?php endif; ?>

  <!-- Encabezado con buscador -->
  <div class="header-section">
    <div class="header-title-group">
      <div class="header-icon">
        <i class="bx bx-box"></i>
      </div>
      <h3 class="header-title">Tipo de Depósito</h3>
    </div>

    <form action="index.php" method="GET" class="search-form">
      <input type="hidden" name="modulo" value="TipoDeDeposito">
      <input type="hidden" name="controlador" value="TipoDeDeposito">
      <input type="hidden" name="funcion" value="getBuscar">

      <div class="search-box-wrapper">
        <i class="bx bx-search search-icon"></i>
        <input type="text" name="busqueda" placeholder="Buscar tipo de depósito..." class="search-input" value="<?= htmlspecialchars($palabra ?? '') ?>">
        <button type="submit" class="search-btn" title="Buscar">
          <i class="bx bx-right-arrow-alt fs-5"></i>
        </button>
      </div>
    </form>
  </div>

  <!-- Lista de Registros -->
  <div class="d-flex flex-column gap-2">
    <?php if (!empty($tipos)): ?>
      <?php foreach ($tipos as $t): ?>
        <div class="item-card">
          
          <!-- Información del registro -->
          <div class="item-info">
            <div class="item-title-row">
              <i class="bx bx-box"></i>
              <span><?= htmlspecialchars($t['nombre']) ?></span>
            </div>
            <div class="item-subtitle">
              <i class="bx bx-hash"></i>
              <span>ID Registro: <?= $t['id_tipo_deposito'] ?></span>
            </div>
          </div>

          <!-- Botones de Acción -->
          <div class="item-actions-wrapper">
            <a href="<?= getUrl("TipoDeDeposito", "TipoDeDeposito", "getEditar", array('id' => $t['id_tipo_deposito'])) ?>" class="btn-action-edit">
              <i class="bx bx-edit-alt"></i> Editar
            </a>
          </div>

        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <!-- Estado vacío -->
      <div class="empty-card">
        <i class="bx bx-search-alt-2"></i>
        <h6 class="fw-bold mb-1">No se encontraron tipos de depósito</h6>
        <p class="small mb-0">Intenta buscar con otra palabra clave o agrega un nuevo registro.</p>
      </div>
    <?php endif; ?>
  </div>

</div>