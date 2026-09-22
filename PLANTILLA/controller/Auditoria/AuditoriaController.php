<?php
require_once __DIR__ . '/../../../vendor/autoload.php';
include_once '../model/Auditoria/AuditoriaModel.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class AuditoriaController
{


    private function construirFiltros(AuditoriaModel $obj)
    {
        $filtroUsuario = $_GET['usuario'] ?? '';
        $filtroModulo = $_GET['modulo_filtro'] ?? '';
        $filtroFecha = $_GET['fecha'] ?? '';

        $condiciones = [];
        $params = [];
        $i = 1;

        if (!empty($filtroUsuario)) {
            $condiciones[] = "a.id_usuario = $" . $i++;
            $params[] = (int) $filtroUsuario;
        }
        if (!empty($filtroModulo)) {
            $condiciones[] = "a.modulo = $" . $i++;
            $params[] = $filtroModulo;
        }
        if (!empty($filtroFecha)) {
            $condiciones[] = "a.fecha_hora::date = $" . $i++;
            $params[] = $filtroFecha;
        }

        return [
            'filtroUsuario' => $filtroUsuario,
            'filtroModulo' => $filtroModulo,
            'filtroFecha' => $filtroFecha,
            'condiciones' => $condiciones,
            'params' => $params,
        ];
    }

    public function getConsultar()
    {
     

        $obj = new AuditoriaModel();

        $f = $this->construirFiltros($obj);
        $filtroUsuario = $f['filtroUsuario'];
        $filtroModulo = $f['filtroModulo'];
        $filtroFecha = $f['filtroFecha'];

        $sql_usuarios = "SELECT id_usuario, primer_nombre, primer_apellido FROM usuarios ORDER BY primer_nombre";
        $usuarios = $obj->select($sql_usuarios);

        $sql_modulos = "SELECT DISTINCT modulo FROM auditoria ORDER BY modulo";
        $modulosDisponibles = $obj->select($sql_modulos);

        $where = !empty($f['condiciones']) ? "WHERE " . implode(" AND ", $f['condiciones']) : "";

        $sql = "SELECT
                    a.id_auditoria,
                    a.fecha_hora,
                    a.modulo,
                    a.accion,
                    a.tabla_afectada,
                    a.id_registro,
                    a.descripcion,
                    a.resultado,
                    TRIM(CONCAT(u.primer_nombre, ' ', u.primer_apellido)) AS nombre_usuario
                FROM auditoria a
                LEFT JOIN usuarios u ON a.id_usuario = u.id_usuario
                $where
                ORDER BY a.fecha_hora DESC
                LIMIT 300";

        $registros = $obj->select($sql, $f['params']);

        include_once '../view/partials/Auditoria/Consultar.php';
    }

    public function exportarAuditoriaExcel()
    {
       

        $obj = new AuditoriaModel();

        $f = $this->construirFiltros($obj);
        $filtroUsuario = $f['filtroUsuario'];
        $filtroModulo = $f['filtroModulo'];
        $filtroFecha = $f['filtroFecha'];

        $nombre_usuario_filtro = 'Todos los usuarios';
        if (!empty($filtroUsuario)) {
            $sql_u = "SELECT primer_nombre, primer_apellido FROM usuarios WHERE id_usuario = $1";
            $u_result = $obj->select($sql_u, [(int) $filtroUsuario]);
            if ($u_result) {
                $nombre_usuario_filtro = trim($u_result[0]['primer_nombre'] . ' ' . $u_result[0]['primer_apellido']);
            }
        }

        $where = !empty($f['condiciones']) ? "WHERE " . implode(" AND ", $f['condiciones']) : "";

        $sql = "SELECT
                    a.fecha_hora,
                    a.modulo,
                    a.accion,
                    a.tabla_afectada,
                    a.id_registro,
                    a.descripcion,
                    a.resultado,
                    TRIM(CONCAT(u.primer_nombre, ' ', u.primer_apellido)) AS nombre_usuario
                FROM auditoria a
                LEFT JOIN usuarios u ON a.id_usuario = u.id_usuario
                $where
                ORDER BY a.fecha_hora DESC
                LIMIT 300";

        $registros = $obj->select($sql, $f['params']);

        // ---- Colores del proyecto ----
        $azulOscuro = '1B3B5F';
        $azulMedio  = '2F6690';
        $grisClaro  = 'F2F2F2';
        $grisTexto  = '6B6B6B';

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Auditoría del Sistema');

        // ================== BANDA SUPERIOR ==================
        $sheet->mergeCells('A1:H1');
        $sheet->setCellValue('A1', 'REPORTE DE AUDITORÍA DEL SISTEMA');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(15)->getColor()->setRGB('FFFFFF');
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT)
            ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)
            ->setIndent(9);
        $sheet->getStyle('A1:H1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB($azulOscuro);
        $sheet->getRowDimension(1)->setRowHeight(46);

        $sheet->mergeCells('A2:H2');
        $sheet->setCellValue('A2', 'Proyecto de Control Biológico · Geolocalización ETV');
        $sheet->getStyle('A2')->getFont()->setItalic(true)->setSize(9)->getColor()->setRGB('FFFFFF');
        $sheet->getStyle('A2')->getAlignment()->setIndent(9);
        $sheet->getStyle('A2:H2')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB($azulMedio);
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
        $logoAlcaldia->setCoordinates('H1');
        $logoAlcaldia->setOffsetX(70);
        $logoAlcaldia->setOffsetY(10);
        $logoAlcaldia->setWorksheet($sheet);

        $sheet->getRowDimension(3)->setRowHeight(8);

        // ================== TÍTULO ==================
        $sheet->mergeCells('A4:H4');
        $sheet->setCellValue('A4', 'Auditoría del Sistema');
        $sheet->getStyle('A4')->getFont()->setBold(true)->setSize(22)->getColor()->setRGB($azulOscuro);
        $sheet->getStyle('A4')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getRowDimension(4)->setRowHeight(32);

        $sheet->getRowDimension(5)->setRowHeight(6);

        // ================== INFORMACIÓN GENERAL ==================
        $sheet->mergeCells('A6:H6');
        $sheet->setCellValue('A6', 'INFORMACIÓN GENERAL');
        $sheet->getStyle('A6')->getFont()->setBold(true)->setSize(11)->getColor()->setRGB($azulOscuro);
        $sheet->getStyle('A6')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM)->getColor()->setRGB($azulOscuro);

        $sheet->setCellValue('A7', 'Usuario filtrado:');
        $sheet->setCellValue('B7', $nombre_usuario_filtro);
        $sheet->setCellValue('A8', 'Módulo filtrado:');
        $sheet->setCellValue('B8', $filtroModulo ?: 'Todos');
        $sheet->setCellValue('A9', 'Fecha consultada:');
        $sheet->setCellValue('B9', $filtroFecha ?: 'Todas las fechas');
        $sheet->setCellValue('A10', 'Cantidad de registros:');
        $sheet->setCellValue('B10', count($registros));
        $sheet->getStyle('A7:A10')->getFont()->setBold(true)->getColor()->setRGB($grisTexto);

        $sheet->getRowDimension(11)->setRowHeight(10);

        // ================== TABLA DE REGISTROS ==================
        $sheet->mergeCells('A12:H12');
        $sheet->setCellValue('A12', 'REGISTROS DE AUDITORÍA');
        $sheet->getStyle('A12')->getFont()->setBold(true)->setSize(11)->getColor()->setRGB($azulOscuro);
        $sheet->getStyle('A12')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM)->getColor()->setRGB($azulOscuro);

        $filaEncabezado = 14;
        $encabezados = ['Fecha y hora', 'Usuario', 'Módulo', 'Acción', 'Tabla afectada', 'ID registro', 'Descripción', 'Resultado'];
        $sheet->fromArray($encabezados, null, "A$filaEncabezado");
        $sheet->getStyle("A$filaEncabezado:H$filaEncabezado")->getFont()->setBold(true)->getColor()->setRGB('FFFFFF');
        $sheet->getStyle("A$filaEncabezado:H$filaEncabezado")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB($azulOscuro);
        $sheet->getStyle("A$filaEncabezado:H$filaEncabezado")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getRowDimension($filaEncabezado)->setRowHeight(20);

        $fila = $filaEncabezado + 1;
        $primeraFilaDatos = $fila;
        foreach ($registros as $r) {
            $sheet->setCellValue("A$fila", $r['fecha_hora']);
            $sheet->setCellValue("B$fila", $r['nombre_usuario'] ?: 'Desconocido');
            $sheet->setCellValue("C$fila", $r['modulo']);
            $sheet->setCellValue("D$fila", $r['accion']);
            $sheet->setCellValue("E$fila", $r['tabla_afectada']);
            $sheet->setCellValue("F$fila", $r['id_registro'] ?? '—');
            $sheet->setCellValue("G$fila", $r['descripcion']);
            $sheet->setCellValue("H$fila", $r['resultado']);

            if ((($fila - $primeraFilaDatos) % 2) === 1) {
                $sheet->getStyle("A$fila:H$fila")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB($grisClaro);
            }
            $sheet->getStyle("A$fila:H$fila")->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN)->getColor()->setRGB('D9D9D9');
            $sheet->getStyle("A$fila:H$fila")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

            $fila++;
        }

        if (empty($registros)) {
            $sheet->mergeCells("A$fila:H$fila");
            $sheet->setCellValue("A$fila", 'No hay registros de auditoría con los filtros seleccionados.');
            $sheet->getStyle("A$fila")->getFont()->setItalic(true)->getColor()->setRGB($grisTexto);
            $sheet->getStyle("A$fila")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        }

        foreach (['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H'] as $col) {
            $sheet->getColumnDimension($col)->setWidth(18);
        }
        $sheet->getColumnDimension('G')->setWidth(35);
        $sheet->setShowGridlines(false);

        $nombre_archivo = "reporte_auditoria_" . date('Y-m-d_His') . ".xlsx";

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