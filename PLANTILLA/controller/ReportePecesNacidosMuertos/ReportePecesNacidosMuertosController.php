<?php
require_once __DIR__ . '/../../../vendor/autoload.php';
include_once '../model/ReportePecesNacidosMuertos/ReportePecesNacidosMuertosModel.php'; // AJUSTA la ruta si tu modelo se llama distinto

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Chart\Chart;
use PhpOffice\PhpSpreadsheet\Chart\DataSeries;
use PhpOffice\PhpSpreadsheet\Chart\DataSeriesValues;
use PhpOffice\PhpSpreadsheet\Chart\Legend;
use PhpOffice\PhpSpreadsheet\Chart\PlotArea;
use PhpOffice\PhpSpreadsheet\Chart\Title;

class ReportePecesNacidosMuertosController
{

    public function getReportePecesNacidosMuertos()
    {
        $obj = new ReportePecesNacidosMuertosModel();

        $sql_zoo = "SELECT id_zoocriadero, cod_zoocriadero FROM zoocriadero WHERE id_estado = 1";
        $zoocriaderos = $obj->select($sql_zoo);

        $generar = isset($_GET['generar']);
        $filtroZoocriadero = $_GET['zoocriadero'] ?? '';

        $datos = [];
        $mensajeVacio = null;

        if ($generar) {

            if (empty($filtroZoocriadero)) {
                include_once '../model/Errores/ErrorModal.php';

                ErrorModal::verError(
                    ["Seleccione un zoocriadero antes de continuar con el proceso."],
                    getUrl('ReportePecesNacidosMuertos', 'ReportePecesNacidosMuertos', 'getReportePecesNacidosMuertos')
                );
                return;
            }

            $sql = "SELECT
                        t.codigo_tanque AS codigo,
                        tt.nombre_tipo_tanque AS tipo_tanque,
                        COALESCE(SUM(sa.can_peces_nacido), 0) AS nacidos,
                        COALESCE(SUM(sa.can_peces_mertos_macho), 0) AS muertos_macho,
                        COALESCE(SUM(sa.can_peces_mertos_hembra), 0) AS muertos_hembra
                    FROM sub_actividades sa
                    INNER JOIN seguimiento_zoocriadero sz ON sa.id_seguimiento_zoo = sz.id_seguimiento_zoo
                    INNER JOIN tanque t ON sz.id_tanque = t.id_tanque
                    INNER JOIN tipo_tanque tt ON t.id_tipo_tanque = tt.id_tipo_tanque
                    WHERE t.id_zoocriadero = \$1
                      AND sa.id_estado = 1
                      AND (sa.can_peces_nacido IS NOT NULL OR sa.can_peces_mertos_macho IS NOT NULL OR sa.can_peces_mertos_hembra IS NOT NULL)
                    GROUP BY t.id_tanque, t.codigo_tanque, tt.nombre_tipo_tanque
                    ORDER BY t.codigo_tanque";

            $datos = $obj->select($sql, [(int) $filtroZoocriadero]);

            if (empty($datos)) {
                $mensajeVacio = "No se encontraron registros de peces nacidos o muertos para el zoocriadero seleccionado.";
            }
        }

        include_once '../view/ReportePecesNacidosMuertos/ReportePecesNacidosMuertos.php';
    }

    public function exportarPecesExcel()
    {

        require_once __DIR__ . '/../../../vendor/autoload.php';

        $obj = new ReportePecesNacidosMuertosModel();

        $filtroZoocriadero = $_GET['zoocriadero'] ?? '';

        if (empty($filtroZoocriadero)) {
            include_once '../model/Errores/ErrorModal.php';
            ErrorModal::verError(
                ["Seleccione un zoocriadero antes de continuar con el proceso."],
                getUrl('ReportePecesNacidosMuertos', 'ReportePecesNacidosMuertos', 'getReportePecesNacidosMuertos')
            );
            return;
        }

        $sql_zoo = "SELECT cod_zoocriadero FROM zoocriadero WHERE id_zoocriadero = $1";
        $zoo_result = $obj->select($sql_zoo, [(int) $filtroZoocriadero]);
        $nombre_zoo = $zoo_result[0]['cod_zoocriadero'] ?? 'zoocriadero';

        $sql = "SELECT
                t.codigo_tanque AS codigo,
                tt.nombre_tipo_tanque AS tipo_tanque,
                COALESCE(SUM(sa.can_peces_nacido), 0) AS nacidos,
                COALESCE(SUM(sa.can_peces_mertos_macho), 0) AS muertos_macho,
                COALESCE(SUM(sa.can_peces_mertos_hembra), 0) AS muertos_hembra
            FROM sub_actividades sa
            INNER JOIN seguimiento_zoocriadero sz ON sa.id_seguimiento_zoo = sz.id_seguimiento_zoo
            INNER JOIN tanque t ON sz.id_tanque = t.id_tanque
            INNER JOIN tipo_tanque tt ON t.id_tipo_tanque = tt.id_tipo_tanque
            WHERE t.id_zoocriadero = \$1
              AND sa.id_estado = 1
              AND (sa.can_peces_nacido IS NOT NULL OR sa.can_peces_mertos_macho IS NOT NULL OR sa.can_peces_mertos_hembra IS NOT NULL)
            GROUP BY t.id_tanque, t.codigo_tanque, tt.nombre_tipo_tanque
            ORDER BY t.codigo_tanque";

        $datos = $obj->select($sql, [(int) $filtroZoocriadero]) ?: [];

        // ---- Colores del proyecto ----
        $azulOscuro = '1B3B5F';
        $azulMedio  = '2F6690';
        $grisClaro  = 'F2F2F2';
        $grisTexto  = '6B6B6B';

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Peces por Tanque');

        // Título de sección: texto azul con línea gruesa debajo
        $tituloSeccion = function ($fila, $texto) use ($sheet, $azulOscuro) {
            $sheet->mergeCells("A$fila:E$fila");
            $sheet->setCellValue("A$fila", $texto);
            $sheet->getStyle("A$fila:E$fila")->getFont()->setBold(true)->setSize(11)->getColor()->setRGB($azulOscuro);
            $sheet->getStyle("A$fila:E$fila")->getBorders()->getBottom()
                ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM)
                ->getColor()->setRGB($azulOscuro);
        };

        // ================== BANDA SUPERIOR ==================
        $sheet->mergeCells('A1:E1');
        $sheet->setCellValue('A1', 'REPORTE DE PECES NACIDOS Y MUERTOS POR TANQUE');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(15)->getColor()->setRGB('FFFFFF');
        $sheet->getStyle('A1')->getAlignment()
            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT)
            ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)
            ->setIndent(9);
        $sheet->getStyle('A1:E1')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setRGB($azulOscuro);
        $sheet->getRowDimension(1)->setRowHeight(46);

        $sheet->mergeCells('A2:E2');
        $sheet->setCellValue('A2', 'Proyecto de Control Biológico · Geolocalización ETV');
        $sheet->getStyle('A2')->getFont()->setItalic(true)->setSize(9)->getColor()->setRGB('FFFFFF');
        $sheet->getStyle('A2')->getAlignment()->setIndent(9);
        $sheet->getStyle('A2:E2')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setRGB($azulMedio);
        $sheet->getRowDimension(2)->setRowHeight(18);

        // ---- Logos (si no existen, se omite y el Excel se genera igual) ----
        $rutaImg = __DIR__ . '/../../web/assets/img/';

        if (file_exists($rutaImg . 'LogoProye.png')) {
            $logoProyecto = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
            $logoProyecto->setName('Logo Geolocalización ETV');
            $logoProyecto->setDescription('Logo del proyecto');
            $logoProyecto->setPath($rutaImg . 'LogoProye.png');
            $logoProyecto->setHeight(58);
            $logoProyecto->setCoordinates('A1');
            $logoProyecto->setOffsetX(6);
            $logoProyecto->setOffsetY(4);
            $logoProyecto->setWorksheet($sheet);
        }

        if (file_exists($rutaImg . 'logo_alcaldia.png')) {
            $logoAlcaldia = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
            $logoAlcaldia->setName('Logo Alcaldía de Santiago de Cali');
            $logoAlcaldia->setDescription('Logo institucional');
            $logoAlcaldia->setPath($rutaImg . 'logo_alcaldia.png');
            $logoAlcaldia->setHeight(26);
            $logoAlcaldia->setCoordinates('E1');
            $logoAlcaldia->setOffsetX(100);
            $logoAlcaldia->setOffsetY(10);
            $logoAlcaldia->setWorksheet($sheet);
        }

        $sheet->getRowDimension(3)->setRowHeight(8);

        // ================== NOMBRE DEL ZOOCRIADERO ==================
        $sheet->mergeCells('A4:E4');
        $sheet->setCellValue('A4', $nombre_zoo);
        $sheet->getStyle('A4')->getFont()->setBold(true)->setSize(22)->getColor()->setRGB($azulOscuro);
        $sheet->getStyle('A4')->getAlignment()
            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getRowDimension(4)->setRowHeight(32);

        $sheet->getRowDimension(5)->setRowHeight(6);

        // ================== INFORMACIÓN GENERAL ==================
        $tituloSeccion(6, 'INFORMACIÓN GENERAL');

        $sheet->setCellValue('A7', 'Cantidad de tanques con registros:');
        $sheet->setCellValue('B7', count($datos));
        $sheet->setCellValue('A8', 'Fecha de generación:');
        $sheet->setCellValue('B8', date('d/m/Y H:i'));
        $sheet->getStyle('A7:A8')->getFont()->setBold(true)->getColor()->setRGB($grisTexto);
        $sheet->getStyle('B7:B8')->getAlignment()
            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

        $sheet->getRowDimension(9)->setRowHeight(10);

        // ================== TABLA DE DATOS ==================
        $tituloSeccion(10, 'PECES NACIDOS Y MUERTOS POR TANQUE');

        $filaEncabezado = 12;
        $encabezados = ['Tanque', 'Tipo de tanque', 'Peces nacidos', 'Muertos (machos)', 'Muertos (hembras)'];
        foreach ($encabezados as $i => $texto) {
            $sheet->setCellValue(chr(65 + $i) . $filaEncabezado, $texto);
        }

        $sheet->getStyle("A$filaEncabezado:E$filaEncabezado")->getFont()->setBold(true)->getColor()->setRGB('FFFFFF');
        $sheet->getStyle("A$filaEncabezado:E$filaEncabezado")->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setRGB($azulOscuro);
        $sheet->getStyle("A$filaEncabezado:E$filaEncabezado")->getAlignment()
            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getRowDimension($filaEncabezado)->setRowHeight(20);

        $fila = $filaEncabezado + 1;
        $primeraFilaDatos = $fila;
        $totalNacidos  = 0;
        $totalMuertosM = 0;
        $totalMuertosH = 0;

        if (empty($datos)) {
            $sheet->mergeCells("A$fila:E$fila");
            $sheet->setCellValue("A$fila", 'No se encontraron registros de peces nacidos o muertos para el zoocriadero seleccionado.');
            $sheet->getStyle("A$fila")->getFont()->setItalic(true)->getColor()->setRGB($grisTexto);
            $sheet->getStyle("A$fila")->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        } else {
            foreach ($datos as $d) {
                $sheet->setCellValue("A$fila", $d['codigo']);
                $sheet->setCellValue("B$fila", $d['tipo_tanque']);
                $sheet->setCellValue("C$fila", (int) $d['nacidos']);
                $sheet->setCellValue("D$fila", (int) $d['muertos_macho']);
                $sheet->setCellValue("E$fila", (int) $d['muertos_hembra']);

                $totalNacidos  += (int) $d['nacidos'];
                $totalMuertosM += (int) $d['muertos_macho'];
                $totalMuertosH += (int) $d['muertos_hembra'];

                if ((($fila - $primeraFilaDatos) % 2) === 1) {
                    $sheet->getStyle("A$fila:E$fila")->getFill()
                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                        ->getStartColor()->setRGB($grisClaro);
                }

                $sheet->getStyle("A$fila:E$fila")->getBorders()->getBottom()
                    ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN)
                    ->getColor()->setRGB('D9D9D9');
                $sheet->getStyle("A$fila:E$fila")->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle("B$fila")->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

                $fila++;
            }

            $ultimaFilaDatos = $fila - 1;

            // Fila de totales
            $sheet->setCellValue("A$fila", 'TOTAL');
            $sheet->mergeCells("A$fila:B$fila");
            $sheet->setCellValue("C$fila", $totalNacidos);
            $sheet->setCellValue("D$fila", $totalMuertosM);
            $sheet->setCellValue("E$fila", $totalMuertosH);
            $sheet->getStyle("A$fila:E$fila")->getFont()->setBold(true)->getColor()->setRGB($azulOscuro);
            $sheet->getStyle("A$fila:E$fila")->getBorders()->getTop()
                ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM)
                ->getColor()->setRGB($azulOscuro);
            $sheet->getStyle("A$fila:E$fila")->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        }

        // ================== ANCHOS DE COLUMNA ==================
        $sheet->getColumnDimension('A')->setWidth(16);
        $sheet->getColumnDimension('B')->setWidth(22);
        $sheet->getColumnDimension('C')->setWidth(16);
        $sheet->getColumnDimension('D')->setWidth(18);
        $sheet->getColumnDimension('E')->setWidth(35);

        $sheet->setShowGridlines(false);

        // ================== GRÁFICA ESTADÍSTICA ==================
        if (!empty($datos)) {
            $categorias = new \PhpOffice\PhpSpreadsheet\Chart\DataSeriesValues(
                \PhpOffice\PhpSpreadsheet\Chart\DataSeriesValues::DATASERIES_TYPE_STRING,
                "'Peces por Tanque'!\$A\${$primeraFilaDatos}:\$A\${$ultimaFilaDatos}",
                null,
                count($datos)
            );
            $valoresNacidos = new \PhpOffice\PhpSpreadsheet\Chart\DataSeriesValues(
                \PhpOffice\PhpSpreadsheet\Chart\DataSeriesValues::DATASERIES_TYPE_NUMBER,
                "'Peces por Tanque'!\$C\${$primeraFilaDatos}:\$C\${$ultimaFilaDatos}",
                null,
                count($datos)
            );
            $valoresMuertosM = new \PhpOffice\PhpSpreadsheet\Chart\DataSeriesValues(
                \PhpOffice\PhpSpreadsheet\Chart\DataSeriesValues::DATASERIES_TYPE_NUMBER,
                "'Peces por Tanque'!\$D\${$primeraFilaDatos}:\$D\${$ultimaFilaDatos}",
                null,
                count($datos)
            );
            $valoresMuertosH = new \PhpOffice\PhpSpreadsheet\Chart\DataSeriesValues(
                \PhpOffice\PhpSpreadsheet\Chart\DataSeriesValues::DATASERIES_TYPE_NUMBER,
                "'Peces por Tanque'!\$E\${$primeraFilaDatos}:\$E\${$ultimaFilaDatos}",
                null,
                count($datos)
            );

            $etiquetaNacidos = new \PhpOffice\PhpSpreadsheet\Chart\DataSeriesValues(
                \PhpOffice\PhpSpreadsheet\Chart\DataSeriesValues::DATASERIES_TYPE_STRING,
                "'Peces por Tanque'!\$C\${$filaEncabezado}",
                null,
                1
            );
            $etiquetaMuertosM = new \PhpOffice\PhpSpreadsheet\Chart\DataSeriesValues(
                \PhpOffice\PhpSpreadsheet\Chart\DataSeriesValues::DATASERIES_TYPE_STRING,
                "'Peces por Tanque'!\$D\${$filaEncabezado}",
                null,
                1
            );
            $etiquetaMuertosH = new \PhpOffice\PhpSpreadsheet\Chart\DataSeriesValues(
                \PhpOffice\PhpSpreadsheet\Chart\DataSeriesValues::DATASERIES_TYPE_STRING,
                "'Peces por Tanque'!\$E\${$filaEncabezado}",
                null,
                1
            );

            $series = new \PhpOffice\PhpSpreadsheet\Chart\DataSeries(
                \PhpOffice\PhpSpreadsheet\Chart\DataSeries::TYPE_BARCHART,
                \PhpOffice\PhpSpreadsheet\Chart\DataSeries::GROUPING_CLUSTERED,
                [0, 1, 2],
                [$etiquetaNacidos, $etiquetaMuertosM, $etiquetaMuertosH],
                [$categorias, $categorias, $categorias],
                [$valoresNacidos, $valoresMuertosM, $valoresMuertosH]
            );
            $series->setPlotDirection(\PhpOffice\PhpSpreadsheet\Chart\DataSeries::DIRECTION_COL);

            $plotArea = new \PhpOffice\PhpSpreadsheet\Chart\PlotArea(null, [$series]);
            $legend   = new \PhpOffice\PhpSpreadsheet\Chart\Legend(
                \PhpOffice\PhpSpreadsheet\Chart\Legend::POSITION_BOTTOM,
                null,
                false
            );
            $titulo   = new \PhpOffice\PhpSpreadsheet\Chart\Title('Peces nacidos y muertos por tanque');

            $chart = new \PhpOffice\PhpSpreadsheet\Chart\Chart(
                'graficaPeces',
                $titulo,
                $legend,
                $plotArea
            );

            $filaGrafica = $fila + 3;
            $chart->setTopLeftPosition("A$filaGrafica");
            $chart->setBottomRightPosition('H' . ($filaGrafica + 18));

            $sheet->addChart($chart);
        }

        $nombre_archivo = 'reporte_peces_' . preg_replace('/[^A-Za-z0-9_-]/', '_', $nombre_zoo) . '_' . date('Y-m-d') . '.xlsx';

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
