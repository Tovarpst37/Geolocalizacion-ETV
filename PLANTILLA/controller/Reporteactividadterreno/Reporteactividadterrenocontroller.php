<?php
require_once __DIR__ . '/../../../vendor/autoload.php';
include_once '../model/ReporteActividadTerreno/ReporteActividadTerrenoModel.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ReporteActividadTerrenoController
{
  


    private function tiposValidos(): array
    {
        return [
            'inspeccion'  => ['col' => 'sat.fecha_inspeccion', 'label' => 'Inspección'],
            'siembra'     => ['col' => 'sat.fecha_siembra', 'label' => 'Siembra'],
            'seguimiento' => ['col' => 'sat.fecha_seguimiento', 'label' => 'Seguimiento'],
            'resiembra'   => ['col' => 'sat.fecha_resiembra', 'label' => 'Resiembra'],
        ];
    }

   
  

    private function consultarActividades(ReporteActividadTerrenoModel $obj, string $col): array
    {
        $sql = "SELECT
                    TRIM(CONCAT(u.primer_nombre, ' ', u.primer_apellido)) AS nombre_auxiliar,
                    $col AS fecha,
                    c.nombre_comuna AS comuna,
                    b.nombre_barrio AS barrio,
                    s.nombre_sitio AS sitio
                FROM sub_actividades_ter sat
                INNER JOIN seguimiento_terreno st ON sat.id_seguimiento_terreno = st.id_seguimiento_terreno
                INNER JOIN usuarios u ON st.id_usuario = u.id_usuario
                INNER JOIN sitio s ON st.id_sitio = s.id_sitio
                INNER JOIN barrio b ON s.id_barrio = b.id_barrio
                INNER JOIN comuna c ON b.id_comuna = c.id_comuna
                WHERE $col IS NOT NULL
                  AND sat.id_estado = 1
                ORDER BY $col DESC";

        return $obj->select($sql);
    }

    public function getReporteActividadTerreno()
    {
    

        $obj = new ReporteActividadTerrenoModel();
        $tipos = $this->tiposValidos();

        $generar = isset($_GET['generar']);
        $filtroTipo = $_GET['tipo'] ?? '';

        $actividades = [];
        $mensajeVacio = null;

        if ($generar) {

            // Excepción 1: sin tipo seleccionado
            if (empty($filtroTipo) || !isset($tipos[$filtroTipo])) {
                include_once '../model/Errores/ErrorModal.php';
                ErrorModal::verError(
                    ["Debe seleccionar un tipo de actividad antes de continuar con el proceso."],
                    getUrl('ReporteActividadTerreno', 'ReporteActividadTerreno', 'getReporteActividadTerreno')
                );
                return;
            }

            $actividades = $this->consultarActividades($obj, $tipos[$filtroTipo]['col']);

            // Excepción 2: sin actividades de ese tipo
            if (empty($actividades)) {
                $mensajeVacio = "No se encontraron actividades registradas para el tipo seleccionado.";
            }
        }

        include_once '../view/ReporteActividadTerreno/ReporteActividadTerreno.php';
    }

    public function exportarActividadTerrenoExcel()
    {
        if (!$this->verificarAcceso()) {
            return;
        }

        $obj = new ReporteActividadTerrenoModel();
        $tipos = $this->tiposValidos();

        $filtroTipo = $_GET['tipo'] ?? '';

        if (empty($filtroTipo) || !isset($tipos[$filtroTipo])) {
            include_once '../model/Errores/ErrorModal.php';
            ErrorModal::verError(
                ["Debe seleccionar un tipo de actividad antes de continuar con el proceso."],
                getUrl('ReporteActividadTerreno', 'ReporteActividadTerreno', 'getReporteActividadTerreno')
            );
            return;
        }

        $etiquetaTipo = $tipos[$filtroTipo]['label'];
        $actividades = $this->consultarActividades($obj, $tipos[$filtroTipo]['col']);

        // ---- Colores del proyecto (mismos que en los demás reportes) ----
        $azulOscuro = '1B3B5F';
        $azulMedio  = '2F6690';
        $grisClaro  = 'F2F2F2';
        $grisTexto  = '6B6B6B';

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Actividades de Terreno');

        // ================== BANDA SUPERIOR ==================
        $sheet->mergeCells('A1:E1');
        $sheet->setCellValue('A1', 'REPORTE DE ACTIVIDADES DE TERRENO POR TIPO');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(15)->getColor()->setRGB('FFFFFF');
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT)
            ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)
            ->setIndent(9);
        $sheet->getStyle('A1:E1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB($azulOscuro);
        $sheet->getRowDimension(1)->setRowHeight(46);

        $sheet->mergeCells('A2:E2');
        $sheet->setCellValue('A2', 'Proyecto de Control Biológico · Geolocalización ETV');
        $sheet->getStyle('A2')->getFont()->setItalic(true)->setSize(9)->getColor()->setRGB('FFFFFF');
        $sheet->getStyle('A2')->getAlignment()->setIndent(9);
        $sheet->getStyle('A2:E2')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB($azulMedio);
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
        $logoAlcaldia->setCoordinates('E1');
        $logoAlcaldia->setOffsetX(70);
        $logoAlcaldia->setOffsetY(10);
        $logoAlcaldia->setWorksheet($sheet);

        $sheet->getRowDimension(3)->setRowHeight(8);

        // ================== TÍTULO (tipo de actividad) ==================
        $sheet->mergeCells('A4:E4');
        $sheet->setCellValue('A4', $etiquetaTipo);
        $sheet->getStyle('A4')->getFont()->setBold(true)->setSize(22)->getColor()->setRGB($azulOscuro);
        $sheet->getStyle('A4')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getRowDimension(4)->setRowHeight(32);

        $sheet->getRowDimension(5)->setRowHeight(6);

        // ================== INFORMACIÓN GENERAL ==================
        $sheet->mergeCells('A6:E6');
        $sheet->setCellValue('A6', 'INFORMACIÓN GENERAL');
        $sheet->getStyle('A6')->getFont()->setBold(true)->setSize(11)->getColor()->setRGB($azulOscuro);
        $sheet->getStyle('A6')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM)->getColor()->setRGB($azulOscuro);

        $sheet->setCellValue('A7', 'Tipo de actividad:');
        $sheet->setCellValue('B7', $etiquetaTipo);
        $sheet->setCellValue('A8', 'Cantidad de actividades:');
        $sheet->setCellValue('B8', count($actividades));
        $sheet->setCellValue('A9', 'Fecha de generación:');
        $sheet->setCellValue('B9', date('d/m/Y H:i'));
        $sheet->getStyle('A7:A9')->getFont()->setBold(true)->getColor()->setRGB($grisTexto);

        $sheet->getRowDimension(10)->setRowHeight(10);

        // ================== TABLA DE ACTIVIDADES ==================
        $sheet->mergeCells('A11:E11');
        $sheet->setCellValue('A11', 'ACTIVIDADES REGISTRADAS');
        $sheet->getStyle('A11')->getFont()->setBold(true)->setSize(11)->getColor()->setRGB($azulOscuro);
        $sheet->getStyle('A11')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM)->getColor()->setRGB($azulOscuro);

        $filaEncabezado = 13;
        $encabezados = ['Auxiliar', 'Fecha', 'Comuna', 'Barrio', 'Sitio'];
        $sheet->fromArray($encabezados, null, "A$filaEncabezado");
        $sheet->getStyle("A$filaEncabezado:E$filaEncabezado")->getFont()->setBold(true)->getColor()->setRGB('FFFFFF');
        $sheet->getStyle("A$filaEncabezado:E$filaEncabezado")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB($azulOscuro);
        $sheet->getStyle("A$filaEncabezado:E$filaEncabezado")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getRowDimension($filaEncabezado)->setRowHeight(20);

        $fila = $filaEncabezado + 1;
        $primeraFilaDatos = $fila;
        foreach ($actividades as $a) {
            $sheet->setCellValue("A$fila", $a['nombre_auxiliar']);
            $sheet->setCellValue("B$fila", $a['fecha']);
            $sheet->setCellValue("C$fila", $a['comuna']);
            $sheet->setCellValue("D$fila", $a['barrio']);
            $sheet->setCellValue("E$fila", $a['sitio']);

            if ((($fila - $primeraFilaDatos) % 2) === 1) {
                $sheet->getStyle("A$fila:E$fila")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB($grisClaro);
            }
            $sheet->getStyle("A$fila:E$fila")->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN)->getColor()->setRGB('D9D9D9');
            $sheet->getStyle("A$fila:E$fila")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

            $fila++;
        }

        if (empty($actividades)) {
            $sheet->mergeCells("A$fila:E$fila");
            $sheet->setCellValue("A$fila", 'No se encontraron actividades registradas para el tipo seleccionado.');
            $sheet->getStyle("A$fila")->getFont()->setItalic(true)->getColor()->setRGB($grisTexto);
            $sheet->getStyle("A$fila")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $fila++;
        }

        foreach (['A', 'B', 'C', 'D', 'E'] as $col) {
            $sheet->getColumnDimension($col)->setWidth(22);
        }
        $sheet->setShowGridlines(false);

        $nombre_archivo = "reporte_actividades_terreno_" . preg_replace('/[^A-Za-z0-9_-]/', '_', $etiquetaTipo) . "_" . date('Y-m-d') . ".xlsx";

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