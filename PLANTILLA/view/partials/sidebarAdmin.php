<style>
    #logoP {
        width: 90px;
        height: 50px;
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
                        <a href="#" class="nav-link">
                            <i class="bx bx-user-circle"></i>
                            <span class="text">Usuarios</span>
                            <i class="bx bx-chevron-down navCaret text"></i>
                        </a>
                        <ul class="submenu">
                            <li><a href="<?php echo getUrl("Usuario", "Usuario", "getCreate"); ?>"><span
                                        class="sub-item">Registrar Usuario</span></a></li>
                            <li><a href="<?php echo getUrl("Usuario", "Usuario", "getUsuario"); ?>"><span
                                        class="sub-item">Consultar Usuario</span></a></li>
                        </ul>
                    </li>
                <?php endif; ?>
            </ul>
            <ul>
                <?php if (in_array('Roles', $_SESSION['modulos'] ?? [])): ?>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="bx bx-user-circle"></i>
                            <span class="text">Roles</span>
                            <i class="bx bx-chevron-down navCaret text"></i>
                        </a>
                        <ul class="submenu">
                            <li><a href="<?php echo getUrl("Roles", "Roles", "getCreate"); ?>"><span
                                        class="sub-item">Registrar Usuario</span></a></li>
                            <li><a href="<?php echo getUrl("Roles", "Roles", "getRoles"); ?>"><span
                                        class="sub-item">Consultar Usuario</span></a></li>
                        </ul>
                    </li>
                <?php endif; ?>
            </ul>

            <span class="menu-tag text">Zoocriadero</span>
            <ul>
                <?php if (in_array('Zoocriadero', $_SESSION['modulos'] ?? [])): ?>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="bx bx-water"></i>
                            <span class="text">Zoocriadero</span>
                            <i class="bx bx-chevron-down navCaret text"></i>
                        </a>
                        <ul class="submenu">
                            <li><a href="<?php echo getUrl("Zoocriadero", "Zoocriadero", "getRegistrar"); ?>"><span
                                        class="sub-item">Registrar Zoocriadero</span></a></li>
                            <li><a href="<?php echo getUrl("Zoocriadero", "Zoocriadero", "getConsultar"); ?>"><span
                                        class="sub-item">Consultar Zoocriadero</span></a></li>
                        </ul>
                    </li>
                <?php endif; ?>

                <?php if (in_array('Tanques', $_SESSION['modulos'] ?? [])): ?>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="bx bx-cylinder"></i>
                            <span class="text">Tanques</span>
                            <i class="bx bx-chevron-down navCaret text"></i>
                        </a>
                        <ul class="submenu">
                            <li><a href="<?php echo getUrl("Tanque", "Tanque", "getRegistrar"); ?>"><span
                                        class="sub-item">Registrar tanque</span></a></li>
                            <li><a href="<?php echo getUrl("Tanque", "Tanque", "getConsultar"); ?>"><span
                                        class="sub-item">Consultar tanque</span></a></li>
                        </ul>
                    </li>
                <?php endif; ?>

                <?php if (in_array('Actividades Zoocriadero', $_SESSION['modulos'] ?? [])): ?>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="bx bx-task"></i>
                            <span class="text">Actividades</span>
                            <i class="bx bx-chevron-down navCaret text"></i>
                        </a>
                        <ul class="submenu">
                            <li><a
                                    href="<?php echo getUrl("ActividadZoocriadero", "ActividadZoocriadero", "getRegistrar"); ?>"><span
                                        class="sub-item">Registrar actividad</span></a></li>
                            <li><a
                                    href="<?php echo getUrl("ActividadZoocriadero", "ActividadZoocriadero", "getConsultar"); ?>"><span
                                        class="sub-item">Consultar actividad</span></a></li>
                        </ul>
                    </li>
                <?php endif; ?>

                <?php if (in_array('Seguimientos Zoocriadero', $_SESSION['modulos'] ?? [])): ?>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="bx bx-radar"></i>
                            <span class="text">Seguimientos</span>
                            <i class="bx bx-chevron-down navCaret text"></i>
                        </a>
                        <ul class="submenu">
                            <li><a
                                    href="<?php echo getUrl("SeguimientoZoocriadero", "SeguimientoZoocriadero", "getRegistrar"); ?>"><span
                                        class="sub-item">Registrar seguimiento</span></a></li>
                            <li><a href="<?php echo getUrl("Historial", "Historial", "getConsultar"); ?>"><span
                                        class="sub-item">Consultar seguimiento</span></a></li>
                        </ul>
                    </li>
                <?php endif; ?>

                <?php if (in_array('Formularios Zoocriadero', $_SESSION['modulos'] ?? [])): ?>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="bx bx-file"></i>
                            <span class="text">Formularios</span>
                            <i class="bx bx-chevron-down navCaret text"></i>
                        </a>
                        <ul class="submenu">
                            <li><a href="<?php echo getUrl("FormularioZ", "FormularioZ", "getRegistrar"); ?>"><span
                                        class="sub-item">Registrar Alimentación</span></a></li>
                            <li><a href="<?php echo getUrl("FormularioM", "FormularioM", "getRegistrar"); ?>"><span
                                        class="sub-item">Registrar Peces Muertos y nacidos</span></a></li>
                            <li><a href="<?php echo getUrl("FormularioLi", "FormularioLi", "getRegistrar"); ?>"><span
                                        class="sub-item">Registrar Limpieza</span></a></li>
                            <li><a href="<?php echo getUrl("FormularioAj", "FormularioAj", "getRegistrar"); ?>"><span
                                        class="sub-item">Registrar Ajuste de Nivel</span></a></li>
                            <li><a href="<?php echo getUrl("FormularioLa", "FormularioLa", "getRegistrar"); ?>"><span
                                        class="sub-item">Registrar Lavado</span></a></li>
                        </ul>
                    </li>
                <?php endif; ?>

                <?php if (in_array('Historial Zoocriadero', $_SESSION['modulos'] ?? [])): ?>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="bx bx-history"></i>
                            <span class="text">Historial</span>
                            <i class="bx bx-chevron-down navCaret text"></i>
                        </a>
                        <ul class="submenu">
                            <li><a href="<?php echo getUrl("Historial", "Historial", "getConsultar"); ?>"><span
                                        class="sub-item">Consultar Historial</span></a></li>
                        </ul>
                    </li>
                <?php endif; ?>
            </ul>

            <span class="menu-tag text">Trabajo en terreno</span>
            <ul>
                <?php if (in_array('Sitios', $_SESSION['modulos'] ?? [])): ?>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="bx bx-map"></i>
                            <span class="text">Sitios</span>
                            <i class="bx bx-chevron-down navCaret text"></i>
                        </a>
                        <ul class="submenu">
                            <li><a href="<?php echo getUrl("Sitios", "Sitios", "getCreate2"); ?>"><span
                                        class="sub-item">Registrar sitio</span></a></li>
                            <li><a href="<?php echo getUrl("Sitios", "Sitios", "getConsultar"); ?>"><span
                                        class="sub-item">Consultar sitio</span></a></li>
                        </ul>
                    </li>
                <?php endif; ?>

                <?php if (in_array('Tipo de depósito', $_SESSION['modulos'] ?? [])): ?>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="bx bx-box"></i>
                            <span class="text">Tipo de depósito</span>
                            <i class="bx bx-chevron-down navCaret text"></i>
                        </a>
                        <ul class="submenu">
                            <li><a href="<?php echo getUrl("TipoDeDeposito", "TipoDeDeposito", "getRegistrar"); ?>"><span
                                        class="sub-item">Registrar tipo de depósito</span></a></li>
                            <li><a href="<?php echo getUrl("TipoDeDeposito", "TipoDeDeposito", "getConsultar"); ?>"><span
                                        class="sub-item">Consultar tipo de depósito</span></a></li>
                        </ul>
                    </li>
                <?php endif; ?>

                <?php if (in_array('Actividades Terreno', $_SESSION['modulos'] ?? [])): ?>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="bx bx-clipboard"></i>
                            <span class="text">Actividades</span>
                            <i class="bx bx-chevron-down navCaret text"></i>
                        </a>
                        <ul class="submenu">
                            <li><a href="<?php echo getUrl("ActividadTerreno", "ActividadTerreno", "getRegistrar"); ?>"><span
                                        class="sub-item">Registrar actividad</span> </a></li>
                            <li><a href="<?php echo getUrl("ActividadTerreno", "ActividadTerreno", "getConsultar"); ?>"><span
                                        class="sub-item">Consultar actividad</span> </a></li>
                        </ul>
                    </li>
                <?php endif; ?>

                <?php if (in_array('Seguimientos Terreno', $_SESSION['modulos'] ?? [])): ?>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="bx bx-route"></i>
                            <span class="text">Seguimientos</span>
                            <i class="bx bx-chevron-down navCaret text"></i>
                        </a>
                        <ul class="submenu">
                            <li><a href="<?php echo getUrl("SeguimientoTerreno", "SeguimientoTerreno", "getRegistrar"); ?>"><span
                                        class="sub-item">Registrar seguimiento</span></a></li>
                            <li><a href="<?php echo getUrl("SeguimientoTerreno", "SeguimientoTerreno", "getConsultar"); ?>"><span
                                        class="sub-item">Consultar seguimiento</span></a></li>
                        </ul>
                    </li>
                <?php endif; ?>

                <?php if (in_array('Formularios Terreno', $_SESSION['modulos'] ?? [])): ?>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="bx bx-folder"></i>
                            <span class="text">Formularios</span>
                            <i class="bx bx-chevron-down navCaret text"></i>
                        </a>
                        <ul class="submenu">
                            <li><a href="<?php echo getUrl("FormularioInsp", "FormularioInsp", "getRegistrar"); ?>"><span
                                        class="sub-item">Registrar Inspección</span></a></li>
                            <li><a href="<?php echo getUrl("FormularioSiem", "FormularioSiem", "getRegistrar"); ?>"><span
                                        class="sub-item">Registrar Siembra</span></a></li>
                            <li><a href="<?php echo getUrl("FormularioSegT", "FormularioSegT", "getRegistrar"); ?>"><span
                                        class="sub-item">Registrar Seguimiento</span></a></li>
                            <li><a href="<?php echo getUrl("FormularioResi", "FormularioResi", "getRegistrar"); ?>"><span
                                        class="sub-item">Registrar Resiembra</span></a></li>
                        </ul>
                    </li>
                <?php endif; ?>

                <?php if (in_array('Historial Terreno', $_SESSION['modulos'] ?? [])): ?>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="bx bx-history"></i>
                            <span class="text">Historial</span>
                            <i class="bx bx-chevron-down navCaret text"></i>
                        </a>
                        <ul class="submenu">
                            <li><a href="<?php echo getUrl("HistorialTerreno", "HistorialTerreno", "getConsultar"); ?>"><span
                                        class="sub-item">Consultar Historial</span></a></li>
                        </ul>
                    </li>
                <?php endif; ?>
            </ul>

            <span class="menu-tag text">Reportes</span>
            <ul>
                <?php if (in_array('Reportes', $_SESSION['modulos'] ?? [])): ?>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="bx bx-bar-chart-alt-2"></i>
                            <span class="text">Reportes</span>
                            <i class="bx bx-chevron-down navCaret text"></i>
                        </a>
                        <ul class="submenu">
                            <li><a href="<?php echo getUrl("Reportes", "Reportes", "report"); ?>"><span
                                        class="sub-item">Seguimiento de actividades</span> </a></li>
                            <li><a
                                    href="<?php echo getUrl("ReportePecesNacidosMuertos", "ReportePecesNacidosMuertos", "getReportePecesNacidosMuertos"); ?>"><span
                                        class="sub-item">Peces nacidos/muertos por tanque</span> </a></li>
                            <li><a
                                    href="<?php echo getUrl("ReportesTanquesZoocriadero", "ReportesTanquesZoocriadero", "getReporteTanques"); ?>"><span
                                        class="sub-item">Tanques por zoocriadero</span> </a></li>
                            <li><a href=""><span class="sub-item">Sitios registrados</span> </a></li>
                            <li><a href="#"><span class="sub-item">Actividades de terreno por tipo</span> </a></li>
                            <li><a
                                    href="<?php echo getUrl("Reporteactividadesauxiliar", "Reporteactividadesauxiliar", "getReporteActividadesAuxiliar"); ?>"><span
                                        class="sub-item">Actividades por auxiliar</span> </a></li>
                            <li><a href="#"><span class="sub-item">Tipo de depósitos</span> </a></li>

                        </ul>
                    </li>
                <?php endif; ?>
            </ul>

            <span class="menu-tag text">Configuracion</span>
            <ul>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="bx bx-cog"></i>
                        <span class="text">config</span>
                        <i class="bx bx-chevron-down navCaret text"></i>
                    </a>
                    <ul class="submenu">
                        <li><a href="<?php echo getUrl("AcercaDe", "AcercaDe", "acercaDe"); ?>"><i
                                    class="bx bx-info-circle"></i><span class="sub-item">Acerca De</span></a></li>
                    </ul>
                </li>
            </ul>
        </nav>

        <div class="sideBottomCard text">
            <p>CERRAR SESION</p>
            <span><?php echo $_SESSION['primer_nombre']; ?></span>
            <div class="arrow">
                <a href="<?php echo getUrl("Acceso", "Acceso", "logout"); ?>"><i
                        class="bx bx-right-arrow-alt cerrarsesion" role="button" tabindex="0"></i></a>
            </div>
        </div>

    </div>
</aside>