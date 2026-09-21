<?php
require_once __DIR__ . '/../../../vendor/autoload.php';
include_once '../model/ReportesTipoDeposito/ReportesTipoDepositoModel.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Chart\Chart;
use PhpOffice\PhpSpreadsheet\Chart\DataSeries;
use PhpOffice\PhpSpreadsheet\Chart\DataSeriesValues;
use PhpOffice\PhpSpreadsheet\Chart\Legend;
use PhpOffice\PhpSpreadsheet\Chart\PlotArea;
use PhpOffice\PhpSpreadsheet\Chart\Title;

class ReportesTipoDepositoController
{

   public function getReporteTipoDeposito()
{
    $obj = new ReportesTipoDepositoModel();

    $sql_tipo_de_deposito = "SELECT id_tipo_deposito, nombre FROM tipo_de_deposito ORDER BY nombre";
    $tipoDeposito = $obj->select($sql_tipo_de_deposito);

    $generar = isset($_GET['generar']);
    $filtroTipoDeposito = $_GET['tipo_deposito'] ?? '';

    $datosReporte = [];
    $mensajeVacio = null;

    if ($generar) {

        if (empty($filtroTipoDeposito)) {
            include_once '../model/Errores/ErrorModal.php';

            ErrorModal::verError(
                ["Seleccione un tipo de deposito antes de generar el reporte."],
                getUrl('ReportesTipoDeposito', 'ReportesTipoDeposito', 'getReporteTipoDeposito')
            );
            return;
        }

        $sql = "SELECT td.id_tipo_deposito, td.nombre AS tipo_deposito,
                    COUNT(sd.id_sitio_deposito) AS cantidad
                FROM tipo_de_deposito td
                LEFT JOIN sitio_deposito sd
                    ON td.id_tipo_deposito = sd.id_tipo_deposito
                    AND sd.id_estado = 1
                WHERE td.id_tipo_deposito = $1
                GROUP BY td.id_tipo_deposito, td.nombre
                ORDER BY td.nombre";
        $datosReporte = $obj->select($sql, [(int) $filtroTipoDeposito]);

        if (empty($datosReporte)) {
            $mensajeVacio = "No hay registros de sitios de depositos actualmente.";
        }
    }

    include_once '../view/ReportesTipoDeposito/ReportesTipoDeposito.php';
}

public function exportarTipoDepositoExcel()
{
    $obj = new ReportesTipoDepositoModel();

    $filtroTipoDeposito = $_GET['tipo_deposito'] ?? '';

    if (empty($filtroTipoDeposito)) {
        include_once '../model/Errores/ErrorModal.php';

        ErrorModal::verError(
            ["Seleccione un tipo de deposito antes de descargar el reporte."],
            getUrl('ReportesTipoDeposito', 'ReportesTipoDeposito', 'getReporteTipoDeposito')
        );
        return;
    }

    $sql = "SELECT td.id_tipo_deposito, td.nombre AS tipo_deposito,
                COUNT(sd.id_sitio_deposito) AS cantidad
            FROM tipo_de_deposito td
            LEFT JOIN sitio_deposito sd
                ON td.id_tipo_deposito = sd.id_tipo_deposito
                AND sd.id_estado = 1
            WHERE td.id_tipo_deposito = $1
            GROUP BY td.id_tipo_deposito, td.nombre
            ORDER BY td.nombre";

    $datosReporte = $obj->select($sql, [(int) $filtroTipoDeposito]);


        if (empty($datosReporte)) {
            include_once '../model/Errores/ErrorModal.php';

            ErrorModal::verError(
                ["No se encontraron sitios de deposito para los tipos seleccionados."],
                getUrl('ReportesTipoDeposito', 'ReportesTipoDeposito', 'getReporteTipoDeposito')
            );
            return;
        }

        // ---- Colores del proyecto ----
        $azulOscuro  = '1B3B5F';
        $azulMedio   = '2F6690';
        $grisClaro   = 'F2F2F2';
        $grisTexto   = '6B6B6B';

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Tipo de Deposito');

        // ================== BANDA SUPERIOR ==================
        $sheet->mergeCells('A1:C1');
        $sheet->setCellValue('A1', 'REPORTE DE SITIOS POR TIPO DE DEPÓSITO');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(15)->getColor()->setRGB('FFFFFF');
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT)
            ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)
            ->setIndent(9);
        $sheet->getStyle('A1:C1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB($azulOscuro);
        $sheet->getRowDimension(1)->setRowHeight(46);

        $sheet->mergeCells('A2:C2');
        $sheet->setCellValue('A2', 'Proyecto de Control Biológico · Geolocalización ETV');
        $sheet->getStyle('A2')->getFont()->setItalic(true)->setSize(9)->getColor()->setRGB('FFFFFF');
        $sheet->getStyle('A2')->getAlignment()->setIndent(9);
        $sheet->getStyle('A2:C2')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB($azulMedio);
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
        $logoAlcaldia->setCoordinates('C1');
        $logoAlcaldia->setOffsetX(70);
        $logoAlcaldia->setOffsetY(10);
        $logoAlcaldia->setWorksheet($sheet);

        $sheet->getRowDimension(3)->setRowHeight(8);

        // ================== TÍTULO ==================
        $sheet->mergeCells('A4:C4');
        $sheet->setCellValue('A4', 'TIPOS DE DEPÓSITO');
        $sheet->getStyle('A4')->getFont()->setBold(true)->setSize(24)->getColor()->setRGB($azulOscuro);
        $sheet->getStyle('A4')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getRowDimension(4)->setRowHeight(34);

        $sheet->getRowDimension(5)->setRowHeight(6);

        // ================== INFORMACIÓN GENERAL ==================
        $sheet->mergeCells('A6:C6');
        $sheet->setCellValue('A6', 'INFORMACIÓN GENERAL');
        $sheet->getStyle('A6')->getFont()->setBold(true)->setSize(11)->getColor()->setRGB($azulOscuro);
        $sheet->getStyle('A6')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM)->getColor()->setRGB($azulOscuro);

        $sheet->setCellValue('A7', 'Tipos de depósito seleccionados:');
        $sheet->setCellValue('B7', count($datosReporte));
        $sheet->setCellValue('A8', 'Fecha de generación:');
        $sheet->setCellValue('B8', date('d/m/Y H:i'));
        $sheet->getStyle('A7:A8')->getFont()->setBold(true)->getColor()->setRGB($grisTexto);

        $sheet->getRowDimension(10)->setRowHeight(10);

        // ================== TABLA DE DATOS ==================
        $sheet->mergeCells('A11:C11');
        $sheet->setCellValue('A11', 'SITIOS POR TIPO DE DEPÓSITO');
        $sheet->getStyle('A11')->getFont()->setBold(true)->setSize(11)->getColor()->setRGB($azulOscuro);
        $sheet->getStyle('A11')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM)->getColor()->setRGB($azulOscuro);

        $filaEncabezado = 13;
        $encabezados = ['ID tipo de depósito', 'Tipo de depósito', 'Cantidad de sitios'];
        $sheet->fromArray($encabezados, null, "A$filaEncabezado");
        $sheet->getStyle("A$filaEncabezado:C$filaEncabezado")->getFont()->setBold(true)->getColor()->setRGB('FFFFFF');
        $sheet->getStyle("A$filaEncabezado:C$filaEncabezado")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB($azulOscuro);
        $sheet->getStyle("A$filaEncabezado:C$filaEncabezado")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getRowDimension($filaEncabezado)->setRowHeight(20);

        $fila = $filaEncabezado + 1;
        $primeraFilaDatos = $fila;
        foreach ($datosReporte as $t) {
            $sheet->setCellValue("A$fila", $t['id_tipo_deposito']);
            $sheet->setCellValue("B$fila", $t['tipo_deposito']);
            $sheet->setCellValue("C$fila", $t['cantidad']);

            if ((($fila - $primeraFilaDatos) % 2) === 1) {
                $sheet->getStyle("A$fila:C$fila")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB($grisClaro);
            }

            $sheet->getStyle("A$fila:C$fila")->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN)->getColor()->setRGB('D9D9D9');
            $sheet->getStyle("A$fila:C$fila")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

            $fila++;
        }
        $ultimaFilaDatos = $fila - 1;

        // ================== GRÁFICA ESTADÍSTICA ==================
        $categorias = new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_STRING, "'Tipo de Deposito'!\$B\${$primeraFilaDatos}:\$B\${$ultimaFilaDatos}", null, count($datosReporte));
        $valoresCantidad = new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_NUMBER, "'Tipo de Deposito'!\$C\${$primeraFilaDatos}:\$C\${$ultimaFilaDatos}", null, count($datosReporte));
        $etiquetaCantidad = new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_STRING, "'Tipo de Deposito'!\$C\${$filaEncabezado}", null, 1);

        $series = new DataSeries(
            DataSeries::TYPE_BARCHART,
            DataSeries::GROUPING_CLUSTERED,
            [0],
            [$etiquetaCantidad],
            [$categorias],
            [$valoresCantidad]
        );
        $series->setPlotDirection(DataSeries::DIRECTION_COL);

        $plotArea = new PlotArea(null, [$series]);
        $legend = new Legend(Legend::POSITION_BOTTOM, null, false);
        $titulo = new Title('Cantidad de sitios por tipo de depósito');

        $chart = new Chart(
            'graficaTipoDeposito',
            $titulo,
            $legend,
            $plotArea
        );

        $filaGrafica = $fila + 3;
        $chart->setTopLeftPosition("A$filaGrafica");
        $chart->setBottomRightPosition('H' . ($filaGrafica + 18));

        $sheet->addChart($chart);

        // ================== ANCHOS DE COLUMNA ==================
        $sheet->getColumnDimension('A')->setWidth(20);
        $sheet->getColumnDimension('B')->setWidth(30);
        $sheet->getColumnDimension('C')->setWidth(20);

        $sheet->setShowGridlines(false);

        $nombre_archivo = "reporte_tipo_deposito_" . date('Y-m-d') . ".xlsx";

        while (ob_get_level() > 0) {
            ob_end_clean();
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $nombre_archivo . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->setIncludeCharts(true);
        $writer->save('php://output');
        exit;
    }
}