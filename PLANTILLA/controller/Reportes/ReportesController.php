<?php

include_once '../model/Reportes/ReporteSeguimientoModel.php';

// Los "use" van siempre arriba del archivo, fuera de la clase
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;


class ReportesController
{

    public function report()
    {

        $obj = new ReporteSeguimientoModel();

        // Lista para el select de la vista (la vista usa $zoocriaderos)
        $zoocriaderos = $obj->select("SELECT id_zoocriadero, cod_zoocriadero FROM
            zoocriadero ORDER BY cod_zoocriadero");

        $actividades = $obj->select("SELECT id_actividad_zoo, nombre_actividad FROM
            actividad_zoocriadero ORDER BY nombre_actividad");

        $limpiar = isset($_GET['limpiar']);

        // name de los input del formulario
        $filtroZoocriadero  = $_GET['zoocriadero'] ?? '';
        $filtroActividad    = $_GET['actividad'] ?? '';
        $filtroFechaInicio  = $_GET['fecha_inicio'] ?? '';
        $filtroFechaFin     = $_GET['fecha_fin'] ?? '';

        // llama al metodo de validar fechas
        $errores = $this->validarFiltros($filtroFechaInicio, $filtroFechaFin);


        if ($limpiar) {

            $seguimientos = [];
        } elseif (!empty($errores)) {

            // si hay errores no se consulta
            $seguimientos = [];
        } else {

            $seguimientos = $this->consultarSeguimiento(
                $obj,
                $filtroZoocriadero,
                $filtroActividad,
                $filtroFechaInicio,
                $filtroFechaFin
            );

            if (empty($seguimientos)) {
                $errores[] = "No se encontraron registros con los filtros de busqueda seleccionados.";
            }
        }



        $mensajeError = !empty($errores) ? implode(' ', $errores) : null;

        // nombre de los estados que estan en la tabla de bd
        $pendiente  = 'Pendiente';
        $enProceso  = 'En proceso';
        $finalizado = 'Finalizado';

        $totalActividades = count($seguimientos);
        $conteoEstado = [];

        $totalRetrasadas = 0;
        $hoy = date("Y-m-d");

        foreach ($seguimientos as $s) {
            $estado = $s['estado'];
            

            $retrasada = ($estado ==$pendiente || $estado ==$enProceso)
                            && $s['fecha_registro']< $hoy;

            if($retrasada){
                $totalRetrasadas++;
            }else{
                $conteoEstado[$estado] =($conteoEstado[$estado]?? 0)+ 1;
            }

            
            
        }


        

        // Fuera del foreach: asi siempre quedan definidos, aunque no haya filas
        $totalCompletas  = $conteoEstado[$finalizado] ?? 0;
        $totalEnProgreso = $conteoEstado[$enProceso] ?? 0;
        $totalPendientes = $conteoEstado[$pendiente] ?? 0;

        // Pendiente por definir: todavia no hay logica para calcular las retrasadas


        include_once '../view/reportes/reportes.php';
    }


    public function validarFiltros($fechaIni, $fechaFin)
    {

        $errores = [];

        if ($fechaIni != '' && $fechaFin != '' && $fechaIni > $fechaFin) {
            $errores[] = "La fecha de inicio no puede ser mayor que la fecha fin.";
        }

        return $errores;
    }


    public function consultarSeguimiento($obj, $zoocriadero, $actividad, $fechaIni, $fechaFin)
    {


        $sql = "SELECT
            az.nombre_actividad AS actividad,
            z.cod_zoocriadero   AS zoocriadero,
            t.codigo_tanque     AS tanque,
            s.fecha             AS fecha_registro,
            s.hora_inicio,
            s.hora_fin,
            TRIM(CONCAT_WS(' ', u.primer_nombre, u.primer_apellido)) AS responsable,
            e.nombre_estado     AS estado
        FROM seguimiento_zoocriadero s
        INNER JOIN usuarios u          ON s.id_usuario           = u.id_usuario
        INNER JOIN tanque t            ON s.id_tanque            = t.id_tanque
        INNER JOIN zoocriadero z       ON t.id_zoocriadero       = z.id_zoocriadero
        INNER JOIN estado e            ON s.id_estado            = e.id_estado
        INNER JOIN actividad_seg_zoo asz    ON asz.id_seguimiento_zoo = s.id_seguimiento_zoo
        INNER JOIN actividad_zoocriadero az ON az.id_actividad_zoo    = asz.id_actividad_zoo
        WHERE ($1::int  IS NULL OR z.id_zoocriadero    = $1)
          AND ($2::int  IS NULL OR az.id_actividad_zoo = $2)
          AND ($3::date IS NULL OR s.fecha            >= $3)
          AND ($4::date IS NULL OR s.fecha            <= $4)
        ORDER BY s.fecha DESC, s.hora_inicio DESC";

        $param = [
            $zoocriadero !== '' ? (int) $zoocriadero : null,
            $actividad   !== '' ? (int) $actividad   : null,
            $fechaIni    !== '' ? $fechaIni          : null,
            $fechaFin    !== '' ? $fechaFin          : null,
        ];

        return $obj->select($sql, $param) ?: [];
    }


    // Descarga el reporte en Excel con los mismos filtros de la pantalla
    public function exportarSeguimientosExcel()
    {

        // Se carga aqui para que la pantalla no dependa de Composer
        require_once __DIR__ . '/../../../vendor/autoload.php';

        $obj = new ReporteSeguimientoModel();

        $filtroZoocriadero  = $_GET['zoocriadero'] ?? '';
        $filtroActividad    = $_GET['actividad'] ?? '';
        $filtroFechaInicio  = $_GET['fecha_inicio'] ?? '';
        $filtroFechaFin     = $_GET['fecha_fin'] ?? '';

        $errores = $this->validarFiltros($filtroFechaInicio, $filtroFechaFin);

        if (!empty($errores)) {

            // Se vuelve a la pantalla del reporte, que muestra el mensaje de error
            $url = getUrl('Reportes', 'Reportes', 'report');
            $separador = (strpos($url, '?') === false) ? '?' : '&';

            header('Location: ' . $url . $separador . http_build_query([
                'zoocriadero'  => $filtroZoocriadero,
                'actividad'    => $filtroActividad,
                'fecha_inicio' => $filtroFechaInicio,
                'fecha_fin'    => $filtroFechaFin,
            ]));
            exit;
        }

        $seguimientos = $this->consultarSeguimiento(
            $obj,
            $filtroZoocriadero,
            $filtroActividad,
            $filtroFechaInicio,
            $filtroFechaFin
        );

        if (empty($seguimientos)) {

            // Se vuelve a la pantalla del reporte, que muestra el mensaje de error
            $url = getUrl('Reportes', 'Reportes', 'report');
            $separador = (strpos($url, '?') === false) ? '?' : '&';

            header('Location: ' . $url . $separador . http_build_query([
                'zoocriadero'  => $filtroZoocriadero,
                'actividad'    => $filtroActividad,
                'fecha_inicio' => $filtroFechaInicio,
                'fecha_fin'    => $filtroFechaFin,
            ]));
            exit;
        }



        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Seguimiento');

        // Titulo
        $sheet->mergeCells('A1:G1');
        $sheet->setCellValue('A1', 'REPORTE DE SEGUIMIENTO A ZOOCRIADEROS');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14)->getColor()->setRGB('FFFFFF');
        $sheet->getStyle('A1:G1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('1B3B5F');
        $sheet->getRowDimension(1)->setRowHeight(30);
        $sheet->getStyle('A1')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        // Informacion general
        $sheet->setCellValue('A2', 'Total de registros:');
        $sheet->setCellValue('B2', count($seguimientos));
        $sheet->setCellValue('A3', 'Fecha de generación:');
        $sheet->setCellValue('B3', date('d/m/Y H:i'));
        $sheet->getStyle('A2:A3')->getFont()->setBold(true);
        $sheet->getStyle('B2:B3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

        // Encabezados de la tabla
        $sheet->setCellValue('A5', 'Zoocriadero');
        $sheet->setCellValue('B5', 'Actividad');
        $sheet->setCellValue('C5', 'Tanque');
        $sheet->setCellValue('D5', 'Fecha Inicio');
        $sheet->setCellValue('E5', 'Fecha Fin');
        $sheet->setCellValue('F5', 'Responsable');
        $sheet->setCellValue('G5', 'Estado');
        $sheet->getStyle('A5:G5')->getFont()->setBold(true)->getColor()->setRGB('FFFFFF');
        $sheet->getStyle('A5:G5')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('2F6690');

        // Filas de datos
        $fila = 6;
        foreach ($seguimientos as $s) {
            $sheet->setCellValue("A$fila", $s['zoocriadero']);
            $sheet->setCellValue("B$fila", $s['actividad']);
            $sheet->setCellValue("C$fila", $s['tanque']);
            $fecha = date('d/m/Y', strtotime($s['fecha_registro']));
            $sheet->setCellValue("D$fila", $fecha . ($s['hora_inicio'] ? ' ' . substr($s['hora_inicio'], 0, 5) : ''));
            $sheet->setCellValue("E$fila", $s['hora_fin'] ? $fecha . ' ' . substr($s['hora_fin'], 0, 5) : '-');
            $sheet->setCellValue("F$fila", $s['responsable']);
            $sheet->setCellValue("G$fila", $s['estado']);
            $fila++;
        }

        if (empty($seguimientos)) {
            $sheet->mergeCells("A$fila:G$fila");
            $sheet->setCellValue("A$fila", 'No se encontraron registros con los filtros seleccionados.');
        }

        // Ancho automatico de columnas
        foreach (['A', 'B', 'C', 'D', 'E', 'F', 'G'] as $columna) {
            $sheet->getColumnDimension($columna)->setAutoSize(true);
        }

        // Descarga
        $nombreArchivo = 'reporte_seguimiento_' . date('Y-m-d') . '.xlsx';

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
