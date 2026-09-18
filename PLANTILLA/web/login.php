<?php
include_once '../lib/helpers.php';
include_once '../view/partials/head.php';
?>
<body>
    <div class="container shadow-lg">
        <div class="container-form">
            <form action="<?php echo getUrl("Acceso","Acceso","login",false,"ajax");?>" method="POST" id="loginForm" class="sign-in">
                <img src="../web/assets/img/login/alcaldia.png" alt="" id="alcaldia">
                <h2>Iniciar sesion</h2>
                <div class="container-input">
                    <ion-icon name="person-circle-outline"></ion-icon>
                        <input
                            type="text"
                            onpaste="return false;"
                            inputmode="numeric"
                            id="documento"
                            name="documento"
                            placeholder="Numero de identificacion"
                            tabindex="1"
                            required
                        >
                </div>

                <small id="documentoError" class="text-danger d-none mb-3 d-block"></small>
            
                <div class="container-input mb-3">
                    <ion-icon name="key-outline"></ion-icon>
                        <input
                            type="password"
                            onpaste="return false;"
                            id="password"
                            name="password"
                            placeholder="Contrasena"
                            tabindex="2"
                            required
                        >
                </div>

                <small id="passwordError" class="text-danger d-none mb-3 d-block"></small>

                <?php include_once '../view/partials/contentPassword.php';?>

                <div class="justify-content-between  mb-3">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="cb1" name="remember">
                        <label class="form-check-label" for="cb1">Ver contrasena</label>
                    </div>
                    <a href="recuperarcontrasena.php" class="forget-link text-decoration-none small">
                        ¿Olvidaste tu contrasena?
                    </a>
                </div>

                <div>
                    <button type="submit" class="button">
                        INICIAR SESION
                    </button>
                </div>
            </form>
        </div>
        <div class="container-form">
            <div>

            </div>
        </div>
        <div class="container-welcome">
            <div class="welcome-sign-up welcome">
                <img src="../web/assets/img/login/logo.png" alt="" id="logo">
                <h1>!Bienvenido!</h1>
                <p>Solo personal autorizado tiene permiso para acceder a las funciones del sitio.</p>
            </div>
        </div>
    </div>
    <?php
    include_once '../view/partials/footer.php';
    ?>
    <script type="module" src="https://unpkg.com/ionicons@8.0.13/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@8.0.13/dist/ionicons/ionicons.js"></script>
    <script src="js/expre/letras.js"></script>
    <script src="js/expre/numeros.js"></script>
    <script src="js/expre/simbolos.js"></script>
    <script src="js/document.js"></script>
    <script src="js/password.js"></script>
    <script src="js/checkbox.js"></script>
    <script src="js/login.js"></script>
</body>
</html>