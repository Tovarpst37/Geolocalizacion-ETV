<?php
require_once __DIR__ . '/../../../vendor/autoload.php';
include_once '../model/Reporteactividadesauxiliar/ReporteactividadesauxiliarModel.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class ReporteactividadesauxiliarController
{

   public function getReporteActividadesAuxiliar()
{
    $obj = new ReporteactividadesauxiliarModel();

    $generar = isset($_GET['generar']);
    $filtroDocumento = trim($_GET['usuario'] ?? '');
    $filtroFecha = $_GET['fecha'] ?? '';
    $filtroAuxiliar = '';   // id_usuario resuelto (lo usa el botón de exportar)

    $actividades = [];
    $mensajeVacio = null;

    if ($generar) {
        include_once '../model/Errores/ErrorModal.php';
        $urlVolver = getUrl('Reporteactividadesauxiliar', 'Reporteactividadesauxiliar', 'getReporteActividadesAuxiliar');

        if ($filtroDocumento === '') {
            ErrorModal::verError(["Debe ingresar el número de documento del auxiliar."], $urlVolver);
            return;
        }

        if (!ctype_digit($filtroDocumento)) {
            ErrorModal::verError(["El documento solo debe contener números."], $urlVolver);
            return;
        }

        $auxiliar = $this->buscarAuxiliarPorDocumento($obj, $filtroDocumento);

        if (!$auxiliar) {
            ErrorModal::verError(["No existe un auxiliar activo con el documento ingresado."], $urlVolver);
            return;
        }

        $filtroAuxiliar = $auxiliar['id_usuario'];
        $nombreAuxiliar = trim(
            $auxiliar['primer_nombre'] . ' ' . $auxiliar['segundo_nombre'] . ' ' .
            $auxiliar['primer_apellido'] . ' ' . $auxiliar['segundo_apellido']
        );

        $actividades = $this->obtenerActividades($obj, (int) $filtroAuxiliar, $filtroFecha);
        foreach ($actividades as &$act) {
            $act['nombre_auxiliar'] = $nombreAuxiliar;
        }
        unset($act);

        if (empty($actividades)) {
            $mensajeVacio = "El auxiliar seleccionado no registra actividades en la fecha consultada.";
        }
    }

    include_once '../view/Reporteactividadesauxiliar/Reporteactividadesauxiliar.php';
}

private function buscarAuxiliarPorDocumento($obj, string $documento)
{
    $sql = "SELECT id_usuario, primer_nombre, segundo_nombre, primer_apellido, segundo_apellido
            FROM usuarios
            WHERE documento = $1 AND id_rol = 3 AND id_estado = 1
            LIMIT 1";
    $res = $obj->select($sql, [$documento]);
    return $res ? $res[0] : null;
}

private function obtenerActividades($obj, int $idAuxiliar, string $fecha): array
{
    $params = [$idAuxiliar];
    $condFecha = '';
    if (!empty($fecha)) {
        $condFecha = " AND {COL}::date = \$2";
        $params[] = $fecha;
    }

    $ramaActividad = function (string $tipo, string $col) use ($condFecha) {
        $filtro = str_replace('{COL}', $col, $condFecha);
        return "SELECT
                    '$tipo' AS tipo_actividad,
                    $col AS fecha,
                    c.nombre_comuna AS comuna,
                    b.nombre_barrio AS barrio,
                    s.nombre_sitio AS sitio
                FROM sub_actividades_ter sat
                INNER JOIN seguimiento_terreno st ON sat.id_seguimiento_terreno = st.id_seguimiento_terreno
                INNER JOIN sitio s ON st.id_sitio = s.id_sitio
                INNER JOIN barrio b ON s.id_barrio = b.id_barrio
                INNER JOIN comuna c ON b.id_comuna = c.id_comuna
                WHERE $col IS NOT NULL
                  AND st.id_usuario = \$1
                  AND sat.id_estado = 1
                  $filtro";
    };

    $sql = $ramaActividad('Inspección', 'sat.fecha_inspeccion')
        . " UNION ALL " . $ramaActividad('Siembra', 'sat.fecha_siembra')
        . " UNION ALL " . $ramaActividad('Seguimiento', 'sat.fecha_seguimiento')
        . " UNION ALL " . $ramaActividad('Resiembra', 'sat.fecha_resiembra')
        . " ORDER BY fecha";

    return $obj->select($sql, $params);
}
    public function exportarActividadesExcel()
    {
           $obj = new ReporteactividadesauxiliarModel();

    $filtroAuxiliar = $_GET['auxiliar'] ?? '';
    $filtroFecha = $_GET['fecha'] ?? '';

    if (empty($filtroAuxiliar) || !ctype_digit((string) $filtroAuxiliar)) {
        include_once '../model/Errores/ErrorModal.php';
        ErrorModal::verError(
            ["Debe generar primero el reporte de un auxiliar."],
            getUrl('Reporteactividadesauxiliar', 'Reporteactividadesauxiliar', 'getReporteActividadesAuxiliar')
        );
        return;
    }

    $sql_aux = "SELECT primer_nombre, segundo_nombre, primer_apellido, segundo_apellido
                FROM usuarios WHERE id_usuario = $1 AND id_rol = 3";
    $aux_result = $obj->select($sql_aux, [(int) $filtroAuxiliar]);
    $nombre_auxiliar = $aux_result
        ? trim($aux_result[0]['primer_nombre'] . ' ' . $aux_result[0]['segundo_nombre'] . ' ' . $aux_result[0]['primer_apellido'] . ' ' . $aux_result[0]['segundo_apellido'])
        : 'Auxiliar';

    $actividades = $this->obtenerActividades($obj, (int) $filtroAuxiliar, $filtroFecha);
    foreach ($actividades as &$act) {
        $act['nombre_auxiliar'] = $nombre_auxiliar;
    }
    unset($act);

        // ---- Colores del proyecto (mismos que en el reporte de tanques) ----
        $azulOscuro = '1B3B5F';
        $azulMedio  = '2F6690';
        $grisClaro  = 'F2F2F2';
        $grisTexto  = '6B6B6B';

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Actividades por Auxiliar');

        // ================== BANDA SUPERIOR ==================
        $sheet->mergeCells('A1:F1');
        $sheet->setCellValue('A1', 'REPORTE DE ACTIVIDADES POR AUXILIAR');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(15)->getColor()->setRGB('FFFFFF');
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT)
            ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)
            ->setIndent(9);
        $sheet->getStyle('A1:F1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB($azulOscuro);
        $sheet->getRowDimension(1)->setRowHeight(46);

        $sheet->mergeCells('A2:F2');
        $sheet->setCellValue('A2', 'Proyecto de Control Biológico · Geolocalización ETV');
        $sheet->getStyle('A2')->getFont()->setItalic(true)->setSize(9)->getColor()->setRGB('FFFFFF');
        $sheet->getStyle('A2')->getAlignment()->setIndent(9);
        $sheet->getStyle('A2:F2')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB($azulMedio);
        $sheet->getRowDimension(2)->setRowHeight(18);

        $rutaImg = __DIR__ . '/../../web/assets/img/';

        $logoProyecto = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $logoProyecto->setName('Logo Geolocalización ETV');
        $logoProyecto->setDescription('Logo del proyecto');
        $logoProyecto->setPath($rutaImg . 'LogoProye.png');
        $logoProyecto->setHeight(58);
        $logoProyecto->setCoordinates('A1');
        $logoProyecto->setOffsetX(6);
        $logoProyecto->setOffsetY(4);
        $logoProyecto->setWorksheet($sheet);

        $logoAlcaldia = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $logoAlcaldia->setName('Logo Alcaldía de Santiago de Cali');
        $logoAlcaldia->setDescription('Logo institucional');
        $logoAlcaldia->setPath($rutaImg . 'logo_alcaldia.png');
        $logoAlcaldia->setHeight(26);
        $logoAlcaldia->setCoordinates('F1');
        $logoAlcaldia->setOffsetX(70);
        $logoAlcaldia->setOffsetY(10);
        $logoAlcaldia->setWorksheet($sheet);

        $sheet->getRowDimension(3)->setRowHeight(8);

        // ================== TÍTULO (nombre del auxiliar) ==================
        $sheet->mergeCells('A4:F4');
        $sheet->setCellValue('A4', $nombre_auxiliar);
        $sheet->getStyle('A4')->getFont()->setBold(true)->setSize(22)->getColor()->setRGB($azulOscuro);
        $sheet->getStyle('A4')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getRowDimension(4)->setRowHeight(32);

        $sheet->getRowDimension(5)->setRowHeight(6);

        // ================== INFORMACIÓN GENERAL ==================
        $sheet->mergeCells('A6:F6');
        $sheet->setCellValue('A6', 'INFORMACIÓN GENERAL');
        $sheet->getStyle('A6')->getFont()->setBold(true)->setSize(11)->getColor()->setRGB($azulOscuro);
        $sheet->getStyle('A6')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM)->getColor()->setRGB($azulOscuro);

        $sheet->setCellValue('A7', 'Fecha consultada:');
        $sheet->setCellValue('B7', $filtroFecha ?: 'Todas las fechas');
        $sheet->setCellValue('A8', 'Cantidad de actividades:');
        $sheet->setCellValue('B8', count($actividades));
        $sheet->setCellValue('A9', 'Fecha de generación:');
        $sheet->setCellValue('B9', date('d/m/Y H:i'));
        $sheet->getStyle('A7:A9')->getFont()->setBold(true)->getColor()->setRGB($grisTexto);

        $sheet->getRowDimension(10)->setRowHeight(10);

        // ================== TABLA DE ACTIVIDADES ==================
        $sheet->mergeCells('A11:F11');
        $sheet->setCellValue('A11', 'ACTIVIDADES REGISTRADAS');
        $sheet->getStyle('A11')->getFont()->setBold(true)->setSize(11)->getColor()->setRGB($azulOscuro);
        $sheet->getStyle('A11')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM)->getColor()->setRGB($azulOscuro);

        $filaEncabezado = 13;
        $encabezados = ['Auxiliar', 'Tipo de actividad', 'Fecha', 'Comuna', 'Barrio', 'Sitio'];
        $sheet->fromArray($encabezados, null, "A$filaEncabezado");
        $sheet->getStyle("A$filaEncabezado:F$filaEncabezado")->getFont()->setBold(true)->getColor()->setRGB('FFFFFF');
        $sheet->getStyle("A$filaEncabezado:F$filaEncabezado")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB($azulOscuro);
        $sheet->getStyle("A$filaEncabezado:F$filaEncabezado")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getRowDimension($filaEncabezado)->setRowHeight(20);

        $fila = $filaEncabezado + 1;
        $primeraFilaDatos = $fila;
        foreach ($actividades as $a) {
            $sheet->setCellValue("A$fila", $a['nombre_auxiliar']);
            $sheet->setCellValue("B$fila", $a['tipo_actividad']);
            $sheet->setCellValue("C$fila", $a['fecha']);
            $sheet->setCellValue("D$fila", $a['comuna']);
            $sheet->setCellValue("E$fila", $a['barrio']);
            $sheet->setCellValue("F$fila", $a['sitio']);

            if ((($fila - $primeraFilaDatos) % 2) === 1) {
                $sheet->getStyle("A$fila:F$fila")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB($grisClaro);
            }
            $sheet->getStyle("A$fila:F$fila")->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN)->getColor()->setRGB('D9D9D9');
            $sheet->getStyle("A$fila:F$fila")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

            $fila++;
        }

        if (empty($actividades)) {
            $sheet->mergeCells("A$fila:F$fila");
            $sheet->setCellValue("A$fila", 'El auxiliar seleccionado no registra actividades en la fecha consultada.');
            $sheet->getStyle("A$fila")->getFont()->setItalic(true)->getColor()->setRGB($grisTexto);
            $sheet->getStyle("A$fila")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $fila++;
        }

        foreach (['A', 'B', 'C', 'D', 'E'] as $col) {
            $sheet->getColumnDimension($col)->setWidth(20);
        }
        $sheet->getColumnDimension('F')->setWidth(30);
        $sheet->setShowGridlines(false);

        $nombre_archivo = "reporte_actividades_" . preg_replace('/[^A-Za-z0-9_-]/', '_', $nombre_auxiliar) . "_" . date('Y-m-d') . ".xlsx";

        while (ob_get_level() > 0) {
            ob_end_clean();
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $nombre_archivo . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
}
