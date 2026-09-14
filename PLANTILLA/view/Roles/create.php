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

        <div class="mb-2">
            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="cb1" name="remember">
                <label class="form-check-label" for="cb1">Zoocriadero</label>
            </div>
            <div class="container text-center mb-3 d-none" id="moduloszoocriadero">
                <div class="row shadow round-3">
                    <div class="col mb-1">
                        <input type="checkbox" class="form-check-input">
                        <label for="from-check-label" for="">IN</label>
                    </div>
                    <div class="col mb-1">
                        <input type="checkbox" class="form-check-input">
                        <label for="from-check-label" for="">SE</label>
                    </div>
                    <div class="col mb-1">
                        <input type="checkbox" class="form-check-input">
                        <label for="from-check-label" for="">UP</label>
                    </div>
                    <div class="col mb-1">
                        <input type="checkbox" class="form-check-input">
                        <label for="from-check-label" for="">DEL</label>
                    </div>
                    <div class="col mb-1">
                        <input type="checkbox" class="form-check-input">
                        <label for="from-check-label" for="">?</label>
                    </div>
                </div>
            </div>
        </div>

         <div class="mb-2">
            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="cb2" name="remember">
                <label class="form-check-label" for="cb2">Seguimiento</label>
            </div>
            <div class="container text-center mb-3 d-none" id="modulosseguimiento" >
                <div class="row shadow round-3">
                    <div class="col mb-1">
                        <input type="checkbox" class="form-check-input">
                        <label for="from-check-label" for="">?</label>
                    </div>
                    <div class="col mb-1">
                        <input type="checkbox" class="form-check-input">
                        <label for="from-check-label" for="">?</label>
                    </div>
                    <div class="col mb-1">
                        <input type="checkbox" class="form-check-input">
                        <label for="from-check-label" for="">?</label>
                    </div>
                    <div class="col mb-1">
                        <input type="checkbox" class="form-check-input">
                        <label for="from-check-label" for="">?</label>
                    </div>
                    <div class="col mb-1">
                        <input type="checkbox" class="form-check-input">
                        <label for="from-check-label" for="">?</label>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end gap-2">
            <button type="reset" class="btn btn-outline-secondary">Limpiar</button>
            <button type="submit" value="Registrar" class="btn btn-primary">Guardar</button>
        </div>

    </form>
<?php include_once '../view/partials/formulari/footer.php';?>   
<script src="../view/Roles/js/checkbox.js"></script>
