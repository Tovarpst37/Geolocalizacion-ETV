<?php include_once '../view/partials/formulari/headFormulari.php';?>
    <h2 class="mb-0 ">CREAR ROL</h2>
<?php include_once '../view/partials/formulari/body.php';?>           
    <form action="<?php echo getUrl("Roles","Roles","postCreate")?>" method="POST">

        <div class ="mb-2">
            <div class=" mb-3">
                <label for="codigo_tanque" class="form-label">Nombre de rol</label>
                <input type="text" class="form-control" id="segundo_apellido" name="segundo_apellido" required>
            </div>
        </div>

        <h4 class="mb-0">Modulos</h4>


        <div class="d-flex justify-content-end gap-2">
            <button type="reset" class="btn btn-outline-secondary">Limpiar</button>
            <button type="submit" value="Registrar" class="btn btn-primary">Guardar</button>
        </div>

    </form>
<?php include_once '../view/partials/formulari/footer.php';?>   
