<?php
    include_once '../lib/helpers.php';
    include_once '../lib/persistlogin.php';
    include_once '../lib/helpersLogin.php';
    include_once '../view/partials/header.php';
?>
<body>

    <div class="main">
        
        <button id="themeToggle" class="theme-toggle" type="button" aria-label="Cambiar modo claro/oscuro">
            <i class='bx bx-moon' id="themeIcon"></i>
        </button>
        <?php include_once '../view/partials/sidebarAdmin.php'; ?>

        <main class="mainContent" id="mainContent">

            <div class="moduleContent">
               <div class='container'>
                    <div class='page-inner'>
                        <?php
                            if (isset($_GET['modulo'])) {
                                resolve();
                            } else {
                                include_once '../view/partials/content.php';
                            }
                        ?>
                    </div>
                </div>
            </div>

        </main>

    </div>

    <?php
        include_once '../view/partials/bootstrap.php';
    ?>

    <script src='https://code.jquery.com/jquery-3.7.1.min.js'></script>
    <script src='../web/assets/js/scriptindex.js'></script>
</body>
</html>