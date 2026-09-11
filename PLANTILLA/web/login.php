<?php
include_once '../lib/helpers.php';
include_once '../view/partials/head.php';
?>

<body class="min-vh-100">
    <div class="row g-0 min-vh-100">

        <div class="col-md-6 d-none d-md-block p-0">
            <img src="../web/assets/img/login/fondoLogin.jpg" class="img-fluid h-100 w-100" style="object-fit: cover;" alt="imagen no cargada">
        </div>

        <div class="col-12 col-md-6 d-flex align-items-center justify-content-center bg-white">
            <div class="w-100 px-4 px-md-5" style="max-width: 420px;">

                <h2 class="title text-center mb-4">
                    Login
                </h2>

                <form action="<?php echo getUrl("Acceso","Acceso","login",false,"ajax");?>" method="POST" id="loginForm">

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
                <small id="documentoError" class="text-danger d-none mb-3 d-block"></small>

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

                    <div class="password-requirements shadow-sm rounded-3 p-3 mb-3 bg-light d-none" id="passwordRequirements">
                        <p class="mb-2 small text-muted">La contraseña debe cumplir con:</p>
                        <ul class="list-unstyled mb-0 small">
                            <li id="req-length">
                                <i class="fa fa-circle text-secondary me-2"></i>Entre 8 y 15 caracteres
                            </li>
                            <li id="req-mayuscula">
                                <i class="fa fa-circle text-secondary me-2"></i>Al menos una letra mayúscula
                            </li>
                            <li id="req-numero">
                                <i class="fa fa-circle text-secondary me-2"></i>Al menos un número
                            </li>
                            <li id="req-simbolo">
                                <i class="fa fa-circle text-secondary me-2"></i>Al menos un símbolo especial
                            </li>
                        </ul>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="cb1" name="remember">
                            <label class="form-check-label" for="cb1">Ver contrasena</label>
                        </div>
                        <a href="recuperarcontrasena.php" class="forget-link text-decoration-none small">
                            ¿Olvidaste tu contrasena?
                        </a>
                    </div>

                    <?php
                        if(isset($_SESSION['error'])){
                            echo "<div class='alert alert-danger'>".$_SESSION['error']."</div>";
                            unset($_SESSION['error']);
                        }
                    ?>

                    <div class="d-grid mb-3">
                        <button type="submit" class="btn btn-primary">
                            Iniciar sesion
                        </button>
                    </div>

                    <div class="d-flex align-items-center my-3">
                        <hr class="flex-grow-1">
                        <span class="px-2 text-muted small">o</span>
                        <hr class="flex-grow-1">
                    </div>

                    <div class="d-grid">
                        <button type="button" class="btn btn-outline-dark">
                            <svg width="18" height="18" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
                                <path fill="#4285F4" d="M17.64 9.2c0-.64-.06-1.25-.16-1.84H9v3.48h4.84c-.21 1.13-.84 2.09-1.8 2.73v2.27h2.91c1.7-1.57 2.69-3.88 2.69-6.64z"/>
                                <path fill="#34A853" d="M9 18c2.43 0 4.47-.81 5.96-2.18l-2.91-2.27c-.81.54-1.84.86-3.05.86-2.35 0-4.34-1.59-5.05-3.72H.96v2.34C2.44 15.98 5.48 18 9 18z"/>
                                <path fill="#FBBC05" d="M3.95 10.69c-.18-.54-.28-1.11-.28-1.69s.1-1.15.28-1.69V4.97H.96C.35 6.19 0 7.55 0 9s.35 2.81.96 4.03l2.99-2.34z"/>
                                <path fill="#EA4335" d="M9 3.58c1.32 0 2.51.45 3.44 1.35l2.58-2.58C13.46.89 11.43 0 9 0 5.48 0 2.44 2.02.96 4.97l2.99 2.34C4.66 5.17 6.65 3.58 9 3.58z"/>
                            </svg>
                            <span>Continuar con Google</span>
                        </button>
                    </div>

                </form>
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
    <script src="js/login.js"></script>
</body>
</html>