<style>
#table{
    box-shadow: 0 0 10px rgba(0 0 0 / 30%);
}
</style>
<div class="page-header">
    <div class="mb-3 contenedortext rounded-4">
        <br>
        <div>
            <h1 class="fw-bold text-center ">CAMBIAR CONTRASENA</h1>
        </div>
        <br>
    </div>
    <form action="<?php echo getUrl("CambiarContrasena","CambiarContrasena","updatePassword");?>" method="POST" id="formRecuperar">
        <div class="card">
            <div class="card-body">
                <label for="segundo_apellido" class="form-label">Nueva Contraena</label>
                <input
                    type="password"
                    onpaste="return false;"
                    id="password"
                    name="password"
                    class ="form-control"
                    placeholder="Contrasena"
                    required
                >
                <small id="passwordError" class="text-danger d-none mb-3 d-block"></small>
                
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="cb1" >
                    <label class="form-check-label" for="cb1">Ver contrasena</label>
                </div>

                <?php include_once '../view/partials/contentPassword.php';?>
            </div>
        </div>
        <div class="d-flex justify-content-end gap-2">
            <button type="submit" value="Registrar" class="btn btn-primary">Guardar</button>
        </div>
    </form>
</div>
<script src="js/expre/letras.js"></script>
<script src="js/expre/numeros.js"></script>
<script src="js/expre/simbolos.js"></script>
<script src="js/password.js"></script>
<script src="js/checkbox.js"></script>
<script src="../view/CambiarContrasena/js/cambiarContrasena.js"></script>
