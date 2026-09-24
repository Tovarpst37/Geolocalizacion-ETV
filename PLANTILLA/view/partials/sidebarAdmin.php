<style>
    #logoP {
        width: 40px;
        height: 40px;
        object-fit: contain;
    }
</style>
<?php
function tienePermiso($modulo, $permiso) {
    return isset($_SESSION['permisos'][$modulo])
        && in_array($permiso, $_SESSION['permisos'][$modulo]);
}

function tieneAlgunPermiso($modulo, array $permisos) {
    if (!isset($_SESSION['permisos'][$modulo])) {
        return false;
    }
    foreach ($permisos as $permiso) {
        if (in_array($permiso, $_SESSION['permisos'][$modulo])) {
            return true;
        }
    }
    return false;
}
?>
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

            <?php if(tieneAlgunPermiso('Usuarios', ['VER','CREAR','EDITAR','ELIMINAR'])): ?>
                <span class="menu-tag text">Gestión de usuario</span>
                <ul>
                    <li class="nav-item">
                        <a href="#" class="nav-link" title="Usuarios">
                            <i class="bx bx-user-circle"></i>
                            <span class="text">Usuarios</span>
                            <i class="bx bx-chevron-down navCaret text"></i>
                        </a>
                        <ul class="submenu">
                            <?php if(tienePermiso('Usuarios', 'CREAR')): ?>
                                <li><a href="<?php echo getUrl("Usuario", "Usuario", "getCreate"); ?>"><span class="sub-item">Registrar Usuario</span></a></li>
                            <?php endif; ?>

                            <?php if(tieneAlgunPermiso('Usuarios', ['VER','EDITAR','ELIMINAR'])): ?>
                                <li><a href="<?php echo getUrl("Usuario", "Usuario", "getUsuario"); ?>"><span class="sub-item">Consultar Usuario</span></a></li>
                            <?php endif; ?>
                        </ul>
                    </li>
                </ul>
            <?php endif; ?>

            <?php if(tieneAlgunPermiso('Roles', ['VER','CREAR','EDITAR','ELIMINAR'])): ?>
                <span class="menu-tag text">Gestión de Roles</span>
                <ul>
                    <li class="nav-item">
                        <a href="#" class="nav-link" title="Roles">
                            <i class="bx bx-user-circle"></i>
                            <span class="text">Roles</span>
                            <i class="bx bx-chevron-down navCaret text"></i>
                        </a>
                        <ul class="submenu">
                            <?php if(tienePermiso('Roles', 'CREAR')): ?>
                                <li><a href="<?php echo getUrl("Roles", "Roles", "getCreate"); ?>"><span class="sub-item">Registrar Roles</span></a></li>
                            <?php endif; ?>

                            <?php if(tieneAlgunPermiso('Roles', ['VER','EDITAR','ELIMINAR'])): ?>
                                <li><a href="<?php echo getUrl("Roles", "Roles", "getRoles"); ?>"><span class="sub-item">Consultar Roles</span></a></li>
                            <?php endif; ?>
                        </ul>
                    </li>
                </ul>
            <?php endif; ?>

            <?php
            $mostrarZoocriadero = tieneAlgunPermiso('Zoocriadero', ['VER','CREAR','EDITAR','ELIMINAR'])
                || tieneAlgunPermiso('Tanques', ['VER','CREAR','EDITAR','ELIMINAR'])
                || tieneAlgunPermiso('Actividades Zoocriadero', ['VER','CREAR','EDITAR','ELIMINAR'])
                || tieneAlgunPermiso('Seguimientos Zoocriadero', ['VER','CREAR','EDITAR','ELIMINAR']);
            ?>
            <?php if($mostrarZoocriadero): ?>
                <span class="menu-tag text">Zoocriadero</span>
                <ul>
                    <?php if(tieneAlgunPermiso('Zoocriadero', ['VER','CREAR','EDITAR','ELIMINAR'])): ?>
                        <li class="nav-item">
                            <a href="#" class="nav-link" title="Zoocriadero">
                                <i class="bx bx-water"></i>
                                <span class="text">Zoocriadero</span>
                                <i class="bx bx-chevron-down navCaret text"></i>
                            </a>
                            <ul class="submenu">
                                <?php if(tienePermiso('Zoocriadero', 'CREAR')): ?>
                                    <li><a href="<?php echo getUrl("Zoocriadero", "Zoocriadero", "getRegistrar"); ?>"><span class="sub-item">Registrar Zoocriadero</span></a></li>
                                <?php endif; ?>
                                <?php if(tieneAlgunPermiso('Zoocriadero', ['VER','EDITAR','ELIMINAR'])): ?>
                                    <li><a href="<?php echo getUrl("Zoocriadero", "Zoocriadero", "getConsultar"); ?>"><span class="sub-item">Consultar Zoocriadero</span></a></li>
                                <?php endif; ?>
                            </ul>
                        </li>
                    <?php endif; ?>

                    <?php if(tieneAlgunPermiso('Tanques', ['VER','CREAR','EDITAR','ELIMINAR'])): ?>
                        <li class="nav-item">
                            <a href="#" class="nav-link" title="Tanques">
                                <i class="bx bx-cylinder"></i>
                                <span class="text">Tanques</span>
                                <i class="bx bx-chevron-down navCaret text"></i>
                            </a>
                            <ul class="submenu">
                                <li><a href="<?php echo getUrl("TipoTanque", "TipoTanque", "getCreate"); ?>"><span class="sub-item">Registrar Tipo Tanque</span></a></li>
                                <li><a href="<?php echo getUrl("TipoTanque", "TipoTanque", "getList"); ?>"><span class="sub-item">Consultar Tipo Tanque</span></a></li>
                                <?php if(tienePermiso('Tanques', 'CREAR')): ?>
                                    <li><a href="<?php echo getUrl("Tanque", "Tanque", "getRegistrar"); ?>"><span class="sub-item">Registrar Tanque</span></a></li>
                                <?php endif; ?>
                                <?php if(tieneAlgunPermiso('Tanques', ['VER','EDITAR','ELIMINAR'])): ?>
                                    <li><a href="<?php echo getUrl("Tanque", "Tanque", "getConsultar"); ?>"><span class="sub-item">Consultar Tanque</span></a></li>
                                <?php endif; ?>
                            </ul>
                        </li>
                    <?php endif; ?>

                    <?php if(tieneAlgunPermiso('Actividades Zoocriadero', ['VER','CREAR','EDITAR','ELIMINAR'])): ?>
                        <li class="nav-item">
                            <a href="#" class="nav-link" title="Actividades">
                                <i class="bx bx-task"></i>
                                <span class="text">Actividades</span>
                                <i class="bx bx-chevron-down navCaret text"></i>
                            </a>
                            <ul class="submenu">
                                <?php if(tienePermiso('Actividades Zoocriadero', 'CREAR')): ?>
                                    <li><a href="<?php echo getUrl("ActividadZoocriadero", "ActividadZoocriadero", "getRegistrar"); ?>"><span class="sub-item">Registrar actividad</span></a></li>
                                <?php endif; ?>
                                <?php if(tieneAlgunPermiso('Actividades Zoocriadero', ['VER','EDITAR','ELIMINAR'])): ?>
                                    <li><a href="<?php echo getUrl("ActividadZoocriadero", "ActividadZoocriadero", "getConsultar"); ?>"><span class="sub-item">Consultar actividad</span></a></li>
                                <?php endif; ?>
                            </ul>
                        </li>
                    <?php endif; ?>

                    <?php if(tieneAlgunPermiso('Seguimientos Zoocriadero', ['VER','CREAR','EDITAR','ELIMINAR'])): ?>
                        <li class="nav-item">
                            <a href="#" class="nav-link" title="Seguimientos">
                                <i class="bx bx-radar"></i>
                                <span class="text">Seguimientos</span>
                                <i class="bx bx-chevron-down navCaret text"></i>
                            </a>
                            <ul class="submenu">
                                <?php if(tienePermiso('Seguimientos Zoocriadero', 'CREAR')): ?>
                                    <li><a href="<?php echo getUrl("SeguimientoZoocriadero", "SeguimientoZoocriadero", "getRegistrar"); ?>"><span class="sub-item">Registrar seguimiento</span></a></li>
                                <?php endif; ?>
                                <?php if(tieneAlgunPermiso('Seguimientos Zoocriadero', ['VER','EDITAR','ELIMINAR'])): ?>
                                    <li><a href="<?php echo getUrl("SeguimientoZoocriadero", "SeguimientoZoocriadero", "getConsultar"); ?>"><span class="sub-item">Consultar seguimiento</span></a></li>
                                <?php endif; ?>
                            </ul>
                        </li>
                    <?php endif; ?>
                </ul>
            <?php endif; ?>

            <?php
            $mostrarTerreno = tieneAlgunPermiso('Sitios', ['VER','CREAR','EDITAR','ELIMINAR'])
                || tieneAlgunPermiso('Tipo de depósito', ['VER','CREAR','EDITAR','ELIMINAR'])
                || tieneAlgunPermiso('Actividades Terreno', ['VER','CREAR','EDITAR','ELIMINAR'])
                || tieneAlgunPermiso('Seguimientos Terreno', ['VER','CREAR','EDITAR','ELIMINAR']);
            ?>
            <?php if($mostrarTerreno): ?>
                <span class="menu-tag text">Trabajo en terreno</span>
                <ul>
                    <?php if(tieneAlgunPermiso('Sitios', ['VER','CREAR','EDITAR','ELIMINAR'])): ?>
                        <li class="nav-item">
                            <a href="#" class="nav-link" title="Sitios">
                                <i class="bx bx-map"></i>
                                <span class="text">Sitios</span>
                                <i class="bx bx-chevron-down navCaret text"></i>
                            </a>
                            <ul class="submenu">
                                <?php if(tienePermiso('Sitios', 'CREAR')): ?>
                                    <li><a href="<?php echo getUrl("Sitios", "Sitios", "getCreate2"); ?>"><span class="sub-item">Registrar sitio</span></a></li>
                                <?php endif; ?>
                                <?php if(tieneAlgunPermiso('Sitios', ['VER','EDITAR','ELIMINAR'])): ?>
                                    <li><a href="<?php echo getUrl("Sitios", "Sitios", "getConsultar"); ?>"><span class="sub-item">Consultar sitio</span></a></li>
                                <?php endif; ?>
                            </ul>
                        </li>
                    <?php endif; ?>

                    <?php if(tieneAlgunPermiso('Tipo de depósito', ['VER','CREAR','EDITAR','ELIMINAR'])): ?>
                        <li class="nav-item">
                            <a href="#" class="nav-link" title="Tipo de depósito">
                                <i class="bx bx-box"></i>
                                <span class="text">Tipo de depósito</span>
                                <i class="bx bx-chevron-down navCaret text"></i>
                            </a>
                            <ul class="submenu">
                                <?php if(tienePermiso('Tipo de depósito', 'CREAR')): ?>
                                    <li><a href="<?php echo getUrl("TipoDeDeposito", "TipoDeDeposito", "getRegistrar"); ?>"><span class="sub-item">Registrar depósito</span></a></li>
                                <?php endif; ?>
                                <?php if(tieneAlgunPermiso('Tipo de depósito', ['VER','EDITAR','ELIMINAR'])): ?>
                                    <li><a href="<?php echo getUrl("TipoDeDeposito", "TipoDeDeposito", "getConsultar"); ?>"><span class="sub-item">Consultar depósito</span></a></li>
                                <?php endif; ?>
                            </ul>
                        </li>
                    <?php endif; ?>

                    <?php if(tieneAlgunPermiso('Actividades Terreno', ['VER','CREAR','EDITAR','ELIMINAR'])): ?>
                        <li class="nav-item">
                            <a href="#" class="nav-link" title="Actividades">
                                <i class="bx bx-clipboard"></i>
                                <span class="text">Actividades</span>
                                <i class="bx bx-chevron-down navCaret text"></i>
                            </a>
                            <ul class="submenu">
                                <?php if(tienePermiso('Actividades Terreno', 'CREAR')): ?>
                                    <li><a href="<?php echo getUrl("ActividadTerreno", "ActividadTerreno", "getRegistrar"); ?>"><span class="sub-item">Registrar actividad</span></a></li>
                                <?php endif; ?>
                                <?php if(tieneAlgunPermiso('Actividades Terreno', ['VER','EDITAR','ELIMINAR'])): ?>
                                    <li><a href="<?php echo getUrl("ActividadTerreno", "ActividadTerreno", "getConsultar"); ?>"><span class="sub-item">Consultar actividad</span></a></li>
                                <?php endif; ?>
                            </ul>
                        </li>
                    <?php endif; ?>

                    <?php if(tieneAlgunPermiso('Seguimientos Terreno', ['VER','CREAR','EDITAR','ELIMINAR'])): ?>
                        <li class="nav-item">
                            <a href="#" class="nav-link" title="Seguimientos">
                                <i class="bx bx-route"></i>
                                <span class="text">Seguimientos</span>
                                <i class="bx bx-chevron-down navCaret text"></i>
                            </a>
                            <ul class="submenu">
                                <?php if(tienePermiso('Seguimientos Terreno', 'CREAR')): ?>
                                    <li><a href="<?php echo getUrl("SeguimientoTerreno", "SeguimientoTerreno", "getRegistrar"); ?>"><span class="sub-item">Registrar seguimiento</span></a></li>
                                <?php endif; ?>
                                <?php if(tieneAlgunPermiso('Seguimientos Terreno', ['VER','EDITAR','ELIMINAR'])): ?>
                                    <li><a href="<?php echo getUrl("SeguimientoTerreno", "SeguimientoTerreno", "getConsultar"); ?>"><span class="sub-item">Consultar seguimiento</span></a></li>
                                <?php endif; ?>
                            </ul>
                        </li>
                    <?php endif; ?>
                </ul>
            <?php endif; ?>

            <?php if(tieneAlgunPermiso('Reportes', ['VER','EXPORTAR'])): ?>
                <span class="menu-tag text">Reportes</span>
                <ul>
                    <li class="nav-item">
                        <a href="#" class="nav-link" title="Reportes">
                            <i class="bx bx-bar-chart-alt-2"></i>
                            <span class="text">Reportes</span>
                            <i class="bx bx-chevron-down navCaret text"></i>
                        </a>
                        <ul class="submenu">
                            <li><a href="<?php echo getUrl("Reportes", "Reportes", "report"); ?>"><span class="sub-item">Seguimiento de actividades</span></a></li>
                            <li><a href="<?php echo getUrl("ReportePecesNacidosMuertos", "ReportePecesNacidosMuertos", "getReportePecesNacidosMuertos"); ?>"><span class="sub-item">Peces nacidos/muertos por tanque</span></a></li>
                            <li><a href="<?php echo getUrl("ReportesTanquesZoocriadero", "ReportesTanquesZoocriadero", "getReporteTanques"); ?>"><span class="sub-item">Tanques por zoocriadero</span></a></li>
                            <li><a href="<?php echo getUrl("ReporteSitios", "ReporteSitios", "getReporteSitios"); ?>"><span class="sub-item">Sitios registrados</span></a></li>
                            <li><a href="<?php echo getUrl('ReporteActividadTerreno', 'ReporteActividadTerreno', 'getReporteActividadTerreno'); ?>"><span class="sub-item">Actividades de terreno por tipo</span></a></li>
                            <li><a href="<?php echo getUrl("Reporteactividadesauxiliar", "Reporteactividadesauxiliar", "getReporteActividadesAuxiliar"); ?>"><span class="sub-item">Actividades por auxiliar</span></a></li>
                            <li><a href="<?php echo getUrl("ReportesTipoDeposito", "ReportesTipoDeposito", "getReporteTipoDeposito"); ?>"><span class="sub-item">Tipo de depósitos</span></a></li>
                            <li><a href="<?php echo getUrl("Auditoria", "Auditoria", "getConsultar"); ?>"><span class="sub-item">Auditoria</span></a></li>
                        </ul>
                    </li>
                </ul>
            <?php endif; ?>

            <span class="menu-tag text">Configuracion</span>
            <li><a href="<?php echo getUrl("AcercaDe", "AcercaDe", "acercaDe"); ?>"><i class="bx bx-info-circle"></i><span class="sub-item">Acerca De</span></a></li>

        </nav>

        <?php
        $nombreUsuario = $_SESSION['primer_nombre'] ?? '';
        $inicial = $nombreUsuario !== '' ? strtoupper(mb_substr($nombreUsuario, 0, 1, 'UTF-8')) : '?';
        ?>
        <div class="sideBottomCard text" title="<?php echo htmlspecialchars($nombreUsuario); ?>">
            <div class="avatar"><?php echo $inicial; ?></div>
            <div class="info">
                <p><?php echo htmlspecialchars($nombreUsuario); ?></p>
                <span>CERRAR SESIÓN</span>
            </div>
            <div class="arrow">
                <a href="<?php echo getUrl("Acceso", "Acceso", "logout"); ?>"><i class="bx bx-right-arrow-alt cerrarsesion" role="button" tabindex="0"></i></a>
            </div>
        </div>

    </div>
</aside>