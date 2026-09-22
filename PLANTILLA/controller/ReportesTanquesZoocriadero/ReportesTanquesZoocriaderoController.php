<?php
require_once __DIR__ . '/../../../vendor/autoload.php';
include_once '../model/reportesTanquesZoocriadero/ReportesModel.php'; 

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ReportesTanquesZoocriaderoController
{

    public function getReporteTanques()
    {
        $obj = new ReportesModel();

        $sql_zoo = "SELECT id_zoocriadero, cod_zoocriadero FROM zoocriadero";
        $zoocriaderos = $obj->select($sql_zoo);

        $generar = isset($_GET['generar']);
        $filtroZoocriadero = $_GET['zoocriadero'] ?? '';

        $tanques = [];
        $encargado = null;
        $totalTanques = 0;
        $mensajeVacio = null;

        if ($generar) {

            if (empty($filtroZoocriadero)) {
                include_once '../model/Errores/ErrorModal.php';

                ErrorModal::verError(
                    ["Seleccione un zoocriadero antes de continuar con el proceso."],
                    getUrl('ReportesTanquesZoocriadero', 'ReportesTanquesZoocriadero', 'getReporteTanques')
                );
                return;
            }

            $sql = "SELECT t.codigo_tanque AS codigo, tt.nombre_tipo_tanque AS tipo_tanque
                    FROM tanque t
                    INNER JOIN tipo_tanque tt ON t.id_tipo_tanque = tt.id_tipo_tanque
                    WHERE t.id_zoocriadero = $1
                    ORDER BY t.codigo_tanque";
            $tanques = $obj->select($sql, [(int) $filtroZoocriadero]);
            $totalTanques = count($tanques);

            $sql_encargado = "SELECT primer_nombre, segundo_nombre, primer_apellido, segundo_apellido
                               FROM usuarios
                               WHERE id_zoocriadero = $1 AND id_rol = 2";
            $encargado_result = $obj->select($sql_encargado, [(int) $filtroZoocriadero]);
            $encargado = $encargado_result[0] ?? null;

            if (empty($tanques)) {
                $mensajeVacio = "El zoocriadero seleccionado no tiene tanques registrados actualmente.";
            }
        }

        include_once '../view/ReportesTanquesZoocriadero/TanquesZoocriadero.php';
    }


    public function exportarTanquesExcel()
    {
        $obj = new ReportesModel();

        $filtroZoocriadero = $_GET['zoocriadero'] ?? '';

        if (empty($filtroZoocriadero)) {
            include_once '../model/Errores/ErrorModal.php';

            ErrorModal::verError(
                ["Seleccione un zoocriadero antes de continuar con el proceso."],
                getUrl('ReportesTanquesZoocriadero', 'ReportesTanquesZoocriadero', 'getReporteTanques')
            );
            return;
        }

        $sql = "SELECT t.codigo_tanque AS codigo, tt.nombre_tipo_tanque AS tipo_tanque
            FROM tanque t
            INNER JOIN tipo_tanque tt ON t.id_tipo_tanque = tt.id_tipo_tanque
            WHERE t.id_zoocriadero = $1
            ORDER BY t.codigo_tanque";
        $tanques = $obj->select($sql, [(int) $filtroZoocriadero]);

        $sql_zoo = "SELECT cod_zoocriadero FROM zoocriadero WHERE id_zoocriadero = $1";
        $zoo_result = $obj->select($sql_zoo, [(int) $filtroZoocriadero]);
        $nombre_zoo = $zoo_result[0]['cod_zoocriadero'] ?? 'zoocriadero';

        $sql_encargado = "SELECT primer_nombre, segundo_nombre, primer_apellido, segundo_apellido
                       FROM usuarios
                       WHERE id_zoocriadero = $1 AND id_rol = 2";
        $encargado_result = $obj->select($sql_encargado, [(int) $filtroZoocriadero]);
        $encargado = $encargado_result[0] ?? null;
        $nombre_encargado = $encargado
            ? trim($encargado['primer_nombre'] . ' ' . $encargado['segundo_nombre'] . ' ' . $encargado['primer_apellido'] . ' ' . $encargado['segundo_apellido'])
            : 'Sin asignar';

        // ---- Colores del proyecto (tomados del logo Geolocalización ETV) ----
        $azulOscuro  = '1B3B5F'; // banda superior / navy principal
        $azulMedio   = '2F6690'; // franja secundaria
        $dorado      = 'E8A33D'; // acento (color del pez)
        $grisClaro   = 'F2F2F2'; // zebra
        $grisTexto   = '6B6B6B';

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Tanques por Zoocriadero');

        // ================== BANDA SUPERIOR ==================
        // Se mantiene el banner en A:D (como el original) para no achicar el
        // ancho total del reporte; lo que se ensancha son las columnas de datos.
        $sheet->mergeCells('A1:D1');
        $sheet->setCellValue('A1', 'REPORTE DE TANQUES POR ZOOCRIADERO');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(15)->getColor()->setRGB('FFFFFF');
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT)
            ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)
            ->setIndent(9); // deja espacio a la izquierda para el logo del guppy
        $sheet->getStyle('A1:D1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB($azulOscuro);
        $sheet->getRowDimension(1)->setRowHeight(46);

        $sheet->mergeCells('A2:D2');
        $sheet->setCellValue('A2', 'Proyecto de Control Biológico · Geolocalización ETV');
        $sheet->getStyle('A2')->getFont()->setItalic(true)->setSize(9)->getColor()->setRGB('FFFFFF');
        $sheet->getStyle('A2')->getAlignment()->setIndent(9);
        $sheet->getStyle('A2:D2')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB($azulMedio);
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
        $logoAlcaldia->setCoordinates('D1');
        $logoAlcaldia->setOffsetX(70);
        $logoAlcaldia->setOffsetY(10);
        $logoAlcaldia->setWorksheet($sheet);

        // fila espaciadora
        $sheet->getRowDimension(3)->setRowHeight(8);

        // ================== TÍTULO (nombre del zoocriadero) ==================
        $sheet->mergeCells('A4:D4');
        $sheet->setCellValue('A4', $nombre_zoo);
        $sheet->getStyle('A4')->getFont()->setBold(true)->setSize(24)->getColor()->setRGB($azulOscuro);
        $sheet->getStyle('A4')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getRowDimension(4)->setRowHeight(34);

        $sheet->getRowDimension(5)->setRowHeight(6);

        // ================== INFORMACIÓN GENERAL ==================
        $sheet->mergeCells('A6:D6');
        $sheet->setCellValue('A6', 'INFORMACIÓN GENERAL');
        $sheet->getStyle('A6')->getFont()->setBold(true)->setSize(11)->getColor()->setRGB($azulOscuro);
        $sheet->getStyle('A6')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM)->getColor()->setRGB($azulOscuro);

        $sheet->setCellValue('A7', 'Encargado del zoocriadero:');
        $sheet->setCellValue('B7', $nombre_encargado);
        $sheet->setCellValue('A8', 'Cantidad de tanques:');
        $sheet->setCellValue('B8', count($tanques));
        $sheet->setCellValue('A9', 'Fecha de generación:');
        $sheet->setCellValue('B9', date('d/m/Y H:i'));
        $sheet->getStyle('A7:A9')->getFont()->setBold(true)->getColor()->setRGB($grisTexto);

        $sheet->getRowDimension(10)->setRowHeight(10);

        // ================== TABLA DE TANQUES ==================
        $sheet->mergeCells('A11:D11');
        $sheet->setCellValue('A11', 'TANQUES REGISTRADOS');
        $sheet->getStyle('A11')->getFont()->setBold(true)->setSize(11)->getColor()->setRGB($azulOscuro);
        $sheet->getStyle('A11')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM)->getColor()->setRGB($azulOscuro);

        $filaEncabezado = 13;
        $sheet->setCellValue("A$filaEncabezado", 'Código del tanque');
        $sheet->setCellValue("B$filaEncabezado", 'Tipo de tanque');
        $sheet->getStyle("A$filaEncabezado:B$filaEncabezado")->getFont()->setBold(true)->getColor()->setRGB('FFFFFF');
        $sheet->getStyle("A$filaEncabezado:B$filaEncabezado")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB($azulOscuro);
        $sheet->getStyle("A$filaEncabezado:B$filaEncabezado")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getRowDimension($filaEncabezado)->setRowHeight(20);

        $fila = $filaEncabezado + 1;
        $primeraFilaDatos = $fila;
        foreach ($tanques as $t) {
            $sheet->setCellValue("A$fila", $t['codigo']);
            $sheet->setCellValue("B$fila", $t['tipo_tanque']);

            // zebra striping
            if ((($fila - $primeraFilaDatos) % 2) === 1) {
                $sheet->getStyle("A$fila:B$fila")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB($grisClaro);
            }

            $sheet->getStyle("A$fila:B$fila")->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN)->getColor()->setRGB('D9D9D9');
            $sheet->getStyle("A$fila:B$fila")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

            $fila++;
        }

        if (empty($tanques)) {
            $sheet->mergeCells("A$fila:B$fila");
            $sheet->setCellValue("A$fila", 'No hay tanques registrados para este zoocriadero.');
            $sheet->getStyle("A$fila")->getFont()->setItalic(true)->getColor()->setRGB($grisTexto);
            $sheet->getStyle("A$fila")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $fila++;
        }

        // ================== ANCHOS DE COLUMNA ==================
        // Se ensanchan A y B (las columnas con datos reales) para que la tabla
        // se vea más grande que antes; C y D se mantienen como en el original
        // para no perder el ancho total del banner.
        $sheet->getColumnDimension('A')->setWidth(28);
        $sheet->getColumnDimension('B')->setWidth(46);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(20);

        $sheet->setShowGridlines(false);

        $nombre_archivo = "reporte_tanques_" . preg_replace('/[^A-Za-z0-9_-]/', '_', $nombre_zoo) . "_" . date('Y-m-d') . ".xlsx";

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