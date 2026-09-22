<style>
    #logoP {
        width: 40px;
        height: 40px;
        object-fit: contain;
    }
</style>
<aside class="sideMenu" id="sideMenu">

    <button class="toggleBtn" id="toggleBtn" type="button">
        <i class='bx bx-chevron-left' id="toggleIcon"></i>
    </button>

    <div class="sideMenuScroll">

        <h2 class="logo">
            <a href="index.php"><img src="../web/assets/img/login/logo.png" id="logoP" alt=""></a>
            <span class="name text">Geo-ETV</span>
        </h2>

        <div class="search">
            <i class="bx bx-search"></i>
            <input type="text" name="text" id="Buscar" class="text" placeholder="Buscar">
        </div>

        <nav class="menu">

            <span class="menu-tag text">Gestión de usuario</span>
            <ul>
                <?php if (in_array('Usuarios', $_SESSION['modulos'] ?? [])): ?>
                    <li class="nav-item">
                        <a href="#" class="nav-link" title="Usuarios">
                            <i class="bx bx-user-circle"></i>
                            <span class="text">Usuarios</span>
                            <i class="bx bx-chevron-down navCaret text"></i>
                        </a>
                        <ul class="submenu">

                        </ul>
                    </li>
                <?php endif; ?>
            </ul>
            <ul>
                <?php if (in_array('Roles', $_SESSION['modulos'] ?? [])): ?>
                    <li class="nav-item">
                        <a href="#" class="nav-link" title="Roles">
                            <i class="bx bx-user-circle"></i>
                            <span class="text">Roles</span>
                            <i class="bx bx-chevron-down navCaret text"></i>
                        </a>
                        <ul class="submenu">

                        </ul>
                    </li>
                <?php endif; ?>
            </ul>

            <span class="menu-tag text">Zoocriadero</span>
            <ul>
                <?php if (in_array('Zoocriadero', $_SESSION['modulos'] ?? [])): ?>
                    <li class="nav-item">
                        <a href="#" class="nav-link" title="Zoocriadero">
                            <i class="bx bx-water"></i>
                            <span class="text">Zoocriadero</span>
                            <i class="bx bx-chevron-down navCaret text"></i>
                        </a>
                        <ul class="submenu">

                        </ul>
                    </li>
                <?php endif; ?>

                <?php if (in_array('Tanques', $_SESSION['modulos'] ?? [])): ?>
                    <li class="nav-item">
                        <a href="#" class="nav-link" title="Tanques">
                            <i class="bx bx-cylinder"></i>
                            <span class="text">Tanques</span>
                            <i class="bx bx-chevron-down navCaret text"></i>
                        </a>
                        <ul class="submenu">

                        </ul>
                    </li>
                <?php endif; ?>

                <?php if (in_array('Actividades Zoocriadero', $_SESSION['modulos'] ?? [])): ?>
                    <li class="nav-item">
                        <a href="#" class="nav-link" title="Actividades">
                            <i class="bx bx-task"></i>
                            <span class="text">Actividades</span>
                            <i class="bx bx-chevron-down navCaret text"></i>
                        </a>
                        <ul class="submenu">

                        </ul>
                    </li>
                <?php endif; ?>

                <?php if (in_array('Seguimientos Zoocriadero', $_SESSION['modulos'] ?? [])): ?>
                    <li class="nav-item">
                        <a href="#" class="nav-link" title="Seguimientos">
                            <i class="bx bx-radar"></i>
                            <span class="text">Seguimientos</span>
                            <i class="bx bx-chevron-down navCaret text"></i>
                        </a>
                        <ul class="submenu">

                        </ul>
                    </li>
                <?php endif; ?>

                <?php if (in_array('Formularios Zoocriadero', $_SESSION['modulos'] ?? [])): ?>
                    <li class="nav-item">
                        <a href="#" class="nav-link" title="Formularios">
                            <i class="bx bx-file"></i>
                            <span class="text">Formularios</span>
                            <i class="bx bx-chevron-down navCaret text"></i>
                        </a>
                        <ul class="submenu">

                        </ul>
                    </li>
                <?php endif; ?>
            </ul>

            <span class="menu-tag text">Trabajo en terreno</span>
            <ul>
                <?php if (in_array('Sitios', $_SESSION['modulos'] ?? [])): ?>
                    <li class="nav-item">
                        <a href="#" class="nav-link" title="Sitios">
                            <i class="bx bx-map"></i>
                            <span class="text">Sitios</span>
                            <i class="bx bx-chevron-down navCaret text"></i>
                        </a>
                        <ul class="submenu">

                        </ul>
                    </li>
                <?php endif; ?>

                <?php if (in_array('Tipo de depósito', $_SESSION['modulos'] ?? [])): ?>
                    <li class="nav-item">
                        <a href="#" class="nav-link" title="Tipo de depósito">
                            <i class="bx bx-box"></i>
                            <span class="text">Tipo de depósito</span>
                            <i class="bx bx-chevron-down navCaret text"></i>
                        </a>
                        <ul class="submenu">

                        </ul>
                    </li>
                <?php endif; ?>

                <?php if (in_array('Actividades Terreno', $_SESSION['modulos'] ?? [])): ?>
                    <li class="nav-item">
                        <a href="#" class="nav-link" title="Actividades">
                            <i class="bx bx-clipboard"></i>
                            <span class="text">Actividades</span>
                            <i class="bx bx-chevron-down navCaret text"></i>
                        </a>
                        <ul class="submenu">

                        </ul>
                    </li>
                <?php endif; ?>

                <?php if (in_array('Seguimientos Terreno', $_SESSION['modulos'] ?? [])): ?>
                    <li class="nav-item">
                        <a href="#" class="nav-link" title="Seguimientos">
                            <i class="bx bx-route"></i>
                            <span class="text">Seguimientos</span>
                            <i class="bx bx-chevron-down navCaret text"></i>
                        </a>
                        <ul class="submenu">

                        </ul>
                    </li>
                <?php endif; ?>

                <?php if (in_array('Formularios Terreno', $_SESSION['modulos'] ?? [])): ?>
                    <li class="nav-item">
                        <a href="#" class="nav-link" title="Formularios">
                            <i class="bx bx-folder"></i>
                            <span class="text">Formularios</span>
                            <i class="bx bx-chevron-down navCaret text"></i>
                        </a>
                        <ul class="submenu">

                        </ul>
                    </li>
                <?php endif; ?>

                <?php if (in_array('Historial Terreno', $_SESSION['modulos'] ?? [])): ?>
                    <li class="nav-item">
                        <a href="#" class="nav-link" title="Historial">
                            <i class="bx bx-history"></i>
                            <span class="text">Historial</span>
                            <i class="bx bx-chevron-down navCaret text"></i>
                        </a>
                        <ul class="submenu">
