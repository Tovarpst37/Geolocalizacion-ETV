<?php
include_once '../lib/helpers.php';
include_once '../view/partials/head.php';
?>
<body class="d-flex align-items-center justify-content-center min-vh-100 bg-light">
    <div class="container" style="max-width: 900px;">
        <div class="row align-items-stretch shadow rounded-3 overflow-hidden bg-white mx-auto">
            <div class="col-md-6 p-0 d-none d-md-block">
                <img src="../web/assets/img/login/fondoazul.jpg" class="img-fluid h-100 w-100" style="object-fit: cover;" alt="imagen no cargada">
            </div>
            <div class="col-12 col-md-6 d-flex align-items-center">
                <div class="card-body py-5 px-4 px-md-5">
                    <h4 class="title text-center mt-4">
                        Login
                    </h4>
                    <form class="px-3" action="<?php echo getUrl("Acceso","Acceso","login",false,"ajax");?>" method="POST">

                        <div class="input-group mb-3">
                            <span class="input-group-text bg-white"><i class="fa fa-id-card"></i></span>
                            <input
                                type="text"
                                onpaste="return false;"
                                inputmode="numeric"
                                class="form-control"
                                id="documento"
                                name="documento"
                                placeholder="Numero de identificacion"
                                tabindex="1"
                                required
                            >
                        </div>

                        <div class="input-group mb-3">
                            <span class="input-group-text bg-white"><i class="fa fa-lock"></i></span>
                            <input
                                type="password"
                                class="form-control"
                                id="password"
                                name="password"
                                placeholder="Contraseña"
                                tabindex="2"
                                required
                            >
                        </div>

                        <div class = "container shadow rounded-3 overflow-hidden mb-3">
                            <p>
                              Que la contrasena cumpla con los siguientes parametro:  
                            </p>
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="cb1" name="remember">
                                <label class="form-check-label" for="cb1">Ver contrasena</label>
                            </div>                            
                        </div>

                        <a href="recuperarcontrasena.php" class="forget-link text-decoration-none small">
                                ¿Olvidaste tu contrasena?
                        </a>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-outline-primary">
                                Iniciar sesion
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php
    include_once '../view/partials/footer.php';
    ?>
    <script src="js/expre/letras.js"></script>
    <script src="js/expre/numeros.js"></script>
    <script src="js/expre/simbolos.js"></script>
    <script src="js/document.js"></script>
    <script src="js/password.js"></script>
    <script src="js/checkbox.js"></script>
</body>
</html>