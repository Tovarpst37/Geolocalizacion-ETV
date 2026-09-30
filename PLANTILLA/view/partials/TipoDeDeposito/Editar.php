<style>
  /* Overlay oscuro fijo para modals en vista independiente */
  .modal-backdrop-custom {
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    background-color: rgba(15, 23, 42, 0.4);
    backdrop-filter: blur(4px);
    z-index: 1050;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 1rem;
    box-sizing: border-box;
  }

  /* Tarjeta Modal */
  .modal-card-custom {
    background-color: #ffffff;
    border-radius: 24px;
    border: none;
    width: 100%;
    max-width: 500px;
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
    overflow: hidden;
    animation: modalAppear 0.25 ease-out;
  }

  @keyframes modalAppear {
    from {
      opacity: 0;
      transform: scale(0.95);
    }
    to {
      opacity: 1;
      transform: scale(1);
    }
  }

  /* Cabecera */
  .modal-header-custom {
    padding: 1.25rem 1.5rem 1rem 1.5rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    border-bottom: 1px solid #f1f5f9;
  }

  .modal-title-custom {
    font-size: 1.15rem;
    font-weight: 700;
    color: #0f172a;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }

  .modal-title-custom i {
    color: #2563eb;
    font-size: 1.3rem;
  }

  .btn-close-custom {
    background: transparent;
    border: none;
    color: #94a3b8;
    font-size: 1.25rem;
    border-radius: 50%;
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    transition: all 0.2s ease;
  }

  .btn-close-custom:hover {
    background-color: #f1f5f9;
    color: #334155;
  }

  /* Cuerpo */
  .modal-body-custom {
    padding: 1.5rem;
  }

  .form-label-custom {
    display: block;
    font-size: 0.88rem;
    font-weight: 600;
    color: #334155;
    margin-bottom: 0.5rem;
  }

  .input-custom-wrapper {
    position: relative;
    display: flex;
    align-items: center;
  }

  .input-custom-wrapper i {
    position: absolute;
    left: 1rem;
    color: #94a3b8;
    font-size: 1.15rem;
  }

  .input-custom {
    width: 100%;
    padding: 0.7rem 1rem 0.7rem 2.6rem;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    font-size: 0.9rem;
    color: #0f172a;
    background-color: #ffffff;
    outline: none;
    transition: all 0.2s ease;
    box-sizing: border-box;
  }

  .input-custom:focus {
    border-color: #2563eb;
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
  }

  /* Pie del modal */
  .modal-footer-custom {
    padding: 1rem 1.5rem 1.25rem 1.5rem;
    background-color: #f8fafc;
    border-top: 1px solid #f1f5f9;
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 0.75rem;
  }

  .btn-custom-cancel {
    background-color: #ffffff;
    border: 1px solid #cbd5e1;
    color: #475569;
    font-weight: 600;
    padding: 0.55rem 1.25rem;
    border-radius: 12px;
    font-size: 0.88rem;
    text-decoration: none;
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
  }

  .btn-custom-cancel:hover {
    background-color: #f1f5f9;
    color: #1e293b;
  }

  .btn-custom-save {
    background-color: #2563eb;
    border: none;
    color: #ffffff;
    font-weight: 600;
    padding: 0.55rem 1.25rem;
    border-radius: 12px;
    font-size: 0.88rem;
    transition: all 0.2s ease;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
  }

  .btn-custom-save:hover {
    background-color: #1d4ed8;
    color: #ffffff;
  }
</style>

<div class="modal-backdrop-custom">
  <div class="modal-card-custom">
    
    <form action="<?php echo getUrl('TipoDeDeposito', 'TipoDeDeposito', 'postUpdate'); ?>" method="POST" style="margin:0;">
      
      <!-- Cabecera -->
      <div class="modal-header-custom">
        <h5 class="modal-title-custom">
          <i class="bx bx-edit-alt"></i> Editar Tipo de Depósito
        </h5>
        <a href="<?php echo getUrl('TipoDeDeposito', 'TipoDeDeposito', 'getConsultar') ?>" class="btn-close-custom" title="Cerrar">
          <i class="bx bx-x fs-4"></i>
        </a>
      </div>

      <!-- Cuerpo del Formulario -->
      <div class="modal-body-custom">
        <?php foreach ($datos as $d) { ?>
          
          <input type="hidden" name="id" value="<?php echo $d['id_tipo_deposito']; ?>">

          <div>
            <label class="form-label-custom">Nombre del Tipo de Depósito *</label>
            <div class="input-custom-wrapper">
              <i class="bx bx-box"></i>
              <input type="text" 
                     class="input-custom" 
                     name="nombre" 
                     value="<?php echo htmlspecialchars($d['nombre']); ?>" 
                     placeholder="Ej. Tanque de almacenamiento"
                     required
                     maxlength="100">
            </div>
          </div>

        <?php } ?>
      </div>

      <!-- Pie con acciones -->
      <div class="modal-footer-custom">
        <a href="<?php echo getUrl('TipoDeDeposito', 'TipoDeDeposito', 'getConsultar') ?>" class="btn-custom-cancel">
          Cancelar
        </a>
        <button type="submit" class="btn-custom-save">
          <i class="bx bx-save fs-5"></i> Guardar cambios
        </button>
      </div>

    </form>

  </div>
</div>