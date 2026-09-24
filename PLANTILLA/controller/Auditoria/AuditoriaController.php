<?php
require_once __DIR__ . '/../../../vendor/autoload.php';
include_once '../model/Auditoria/AuditoriaModel.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class AuditoriaController
//auditoria
{
    private function construirFiltros(AuditoriaModel $obj)
    {
        $filtroUsuario = $_POST['usuario'] ?? '';
        $filtroModulo  = $_POST['modulo_filtro'] ?? '';
        $filtroFecha   = $_POST['fecha'] ?? '';

        $condiciones = [];
        $params = [];
        $i = 1;

        if (!empty($filtroUsuario)) {
            $condiciones[] = "u.documento = $" . $i++;
            $params[] = $filtroUsuario; // quita el (int) si documento es varchar en tu BD
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
            'filtroModulo'  => $filtroModulo,
            'filtroFecha'   => $filtroFecha,
            'condiciones'   => $condiciones,
            'params'        => $params,
        ];
    }

    public function getConsultar()
    {
        $obj = new AuditoriaModel();
        $f = $this->construirFiltros($obj);

        $filtroUsuario = $f['filtroUsuario'];
        $filtroModulo  = $f['filtroModulo'];
        $filtroFecha   = $f['filtroFecha'];

        $sql_usuarios = "SELECT id_usuario, primer_nombre, primer_apellido FROM usuarios ORDER BY primer_nombre";
        $usuarios = $obj->select($sql_usuarios) ?: [];

        $sql_modulos = "SELECT DISTINCT modulo FROM auditoria ORDER BY modulo";
        $modulosDisponibles = $obj->select($sql_modulos) ?: [];

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

        $registros = $obj->select($sql, $f['params']) ?: [];

        include_once '../view/partials/Auditoria/Consultar.php';
    }

    public function exportarAuditoriaExcel()
    {
        require_once __DIR__ . '/../../../vendor/autoload.php';

        $obj = new AuditoriaModel();

        $f = $this->construirFiltros($obj);
        $filtroUsuario = $f['filtroUsuario'];
        $filtroModulo  = $f['filtroModulo'];
        $filtroFecha   = $f['filtroFecha'];

        $nombre_usuario_filtro = 'Todos los usuarios';
        if (!empty($filtroUsuario)) {
            $sql_u = "SELECT primer_nombre, primer_apellido FROM usuarios WHERE documento = $1";
            $u_result = $obj->select($sql_u, [$filtroUsuario]);
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

        $registros = $obj->select($sql, $f['params']) ?: [];

    // ---- Colores del proyecto (iguales que seguimiento) ----
    $azulOscuro = '1B3B5F';
    $azulMedio  = '2F6690';
    $grisClaro  = 'F2F2F2';
    $grisTexto  = '6B6B6B';

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setTitle('Auditoría');

    // Título de sección: texto azul con línea gruesa debajo
    $tituloSeccion = function ($fila, $texto) use ($sheet, $azulOscuro) {
        $sheet->mergeCells("A$fila:H$fila");
        $sheet->setCellValue("A$fila", $texto);
        $sheet->getStyle("A$fila:H$fila")->getFont()->setBold(true)->setSize(11)->getColor()->setRGB($azulOscuro);
        $sheet->getStyle("A$fila:H$fila")->getBorders()->getBottom()
            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM)
            ->getColor()->setRGB($azulOscuro);
    };

    // ================== BANDA SUPERIOR ==================
    $sheet->mergeCells('A1:H1');
    $sheet->setCellValue('A1', 'REPORTE DE AUDITORÍA DEL SISTEMA');
    $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(15)->getColor()->setRGB('FFFFFF');
    $sheet->getStyle('A1')->getAlignment()
        ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT)
        ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)
        ->setIndent(9);
    $sheet->getStyle('A1:H1')->getFill()
        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        ->getStartColor()->setRGB($azulOscuro);
    $sheet->getRowDimension(1)->setRowHeight(46);

    $sheet->mergeCells('A2:H2');
    $sheet->setCellValue('A2', 'Proyecto de Control Biológico · Geolocalización ETV');
    $sheet->getStyle('A2')->getFont()->setItalic(true)->setSize(9)->getColor()->setRGB('FFFFFF');
    $sheet->getStyle('A2')->getAlignment()->setIndent(9);
    $sheet->getStyle('A2:H2')->getFill()
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
        $logoAlcaldia->setCoordinates('H1');
        $logoAlcaldia->setOffsetX(5);
        $logoAlcaldia->setOffsetY(10);
        $logoAlcaldia->setWorksheet($sheet);
    }

    $sheet->getRowDimension(3)->setRowHeight(8);

    // ================== INFORMACIÓN GENERAL ==================
    $tituloSeccion(4, 'INFORMACIÓN GENERAL');

    $sheet->setCellValue('A5', 'Usuario filtrado:');
    $sheet->setCellValue('B5', $nombre_usuario_filtro);
    $sheet->setCellValue('A6', 'Módulo filtrado:');
    $sheet->setCellValue('B6', $filtroModulo !== '' ? $filtroModulo : 'Todos');
    $sheet->setCellValue('A7', 'Fecha consultada:');
    $sheet->setCellValue('B7', $filtroFecha !== '' ? $filtroFecha : 'Todas las fechas');
    $sheet->setCellValue('A8', 'Total de registros:');
    $sheet->setCellValue('B8', count($registros));
    $sheet->setCellValue('A9', 'Fecha de generación:');
    $sheet->setCellValue('B9', date('d/m/Y H:i'));

    $sheet->getStyle('A5:A9')->getFont()->setBold(true)->getColor()->setRGB($grisTexto);
    $sheet->getStyle('B5:B9')->getAlignment()
        ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

    $sheet->getRowDimension(10)->setRowHeight(10);

    // ================== TABLA DE REGISTROS ==================
    $tituloSeccion(11, 'REGISTROS DE AUDITORÍA');

    $filaEncabezado = 13;
    $encabezados = [
        'Fecha y hora',
        'Usuario',
        'Módulo',
        'Acción',
        'Tabla afectada',
        'ID registro',
        'Descripción',
        'Resultado'
    ];
    foreach ($encabezados as $i => $texto) {
        $sheet->setCellValue(chr(65 + $i) . $filaEncabezado, $texto);
    }

    $sheet->getStyle("A$filaEncabezado:H$filaEncabezado")->getFont()->setBold(true)->getColor()->setRGB('FFFFFF');
    $sheet->getStyle("A$filaEncabezado:H$filaEncabezado")->getFill()
        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        ->getStartColor()->setRGB($azulOscuro);
    $sheet->getStyle("A$filaEncabezado:H$filaEncabezado")->getAlignment()
        ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    $sheet->getRowDimension($filaEncabezado)->setRowHeight(20);

    $fila = $filaEncabezado + 1;
    $primeraFilaDatos = $fila;

    if (empty($registros)) {
        $sheet->mergeCells("A$fila:H$fila");
        $sheet->setCellValue("A$fila", 'No hay registros de auditoría con los filtros seleccionados.');
        $sheet->getStyle("A$fila")->getFont()->setItalic(true)->getColor()->setRGB($grisTexto);
        $sheet->getStyle("A$fila")->getAlignment()
            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    } else {
        foreach ($registros as $r) {
            $sheet->setCellValue("A$fila", $r['fecha_hora']);
            $sheet->setCellValue("B$fila", $r['nombre_usuario'] ?: 'Desconocido');
            $sheet->setCellValue("C$fila", $r['modulo']);
            $sheet->setCellValue("D$fila", $r['accion']);
            $sheet->setCellValue("E$fila", $r['tabla_afectada']);
            $sheet->setCellValue("F$fila", $r['id_registro'] ?? '—');
            $sheet->setCellValue("G$fila", $r['descripcion']);
            $sheet->setCellValue("H$fila", $r['resultado']);

            // zebra
            if ((($fila - $primeraFilaDatos) % 2) === 1) {
                $sheet->getStyle("A$fila:H$fila")->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setRGB($grisClaro);
            }

            $sheet->getStyle("A$fila:H$fila")->getBorders()->getBottom()
                ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN)
                ->getColor()->setRGB('D9D9D9');

            $sheet->getStyle("A$fila:H$fila")->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("B$fila")->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("G$fila")->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

            $fila++;
        }
    }

    // ================== ANCHOS DE COLUMNA ==================
    $sheet->getColumnDimension('A')->setWidth(20);
    $sheet->getColumnDimension('B')->setWidth(22);
    $sheet->getColumnDimension('C')->setWidth(16);
    $sheet->getColumnDimension('D')->setWidth(14);
    $sheet->getColumnDimension('E')->setWidth(18);
    $sheet->getColumnDimension('F')->setWidth(12);
    $sheet->getColumnDimension('G')->setWidth(40);
    $sheet->getColumnDimension('H')->setWidth(20);

    $sheet->setShowGridlines(false);

    // Descarga
    $nombreArchivo = 'reporte_auditoria_' . date('Y-m-d_His') . '.xlsx';

    while (ob_get_level() > 0) {
        ob_end_clean();
    }

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $nombreArchivo . '"');
    header('Cache-Control: max-age=0');

    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;
}
}