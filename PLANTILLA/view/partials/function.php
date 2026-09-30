<?php
function condicion($permiso, $modulo) {
    return in_array($permiso, $_SESSION['permisos'][$modulo] ?? []);
}
?>