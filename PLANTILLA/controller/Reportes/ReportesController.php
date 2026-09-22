<?php

include_once '../model/Reportes/ReporteSeguimientoModel.php';


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


        //verificar si los campos tienen informacion, si se ha selec
        $inicio = isset($_GET['zoocriadero']) || isset($_GET['actividad']) ||
            isset($_GET['fecha_inicio']) || isset($_GET['fecha_fin']);


        // name de los input del formulario
        $filtroZoocriadero  = $_GET['zoocriadero'] ?? '';
        $filtroActividad    = $_GET['actividad'] ?? '';
        $filtroFechaInicio  = $_GET['fecha_inicio'] ?? '';
        $filtroFechaFin     = $_GET['fecha_fin'] ?? '';

        // llama al metodo de validar fechas
        $errores = $this->validarFiltros($filtroFechaInicio, $filtroFechaFin);



        // Limpiar: resetea filtros y muestra todos
        if ($limpiar) {
            $filtroZoocriadero = '';
            $filtroActividad   = '';
            $filtroFechaInicio = '';
            $filtroFechaFin    = '';
            $errores           = [];
        }

        if (!empty($errores)) {
            // Si hay errores de validación no se consulta
            $seguimientos = [];
        } else {
            // Sin filtros = todos los registros (así al entrar ya viene cargado)
            $seguimientos = $this->consultarSeguimiento(
                $obj,
                $filtroZoocriadero,
                $filtroActividad,
                $filtroFechaInicio,
                $filtroFechaFin
            );

            // Solo avisa “sin resultados” si el usuario aplicó filtros
            if (empty($seguimientos) && $inicio && !$limpiar) {
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


            $retrasada = ($estado == $pendiente || $estado == $enProceso)
                && $s['fecha_registro'] < $hoy;

            if ($retrasada) {
                $totalRetrasadas++;
            } else {
                $conteoEstado[$estado] = ($conteoEstado[$estado] ?? 0) + 1;
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

        // ---- Estados (los mismos de la pantalla) ----
        $pendiente  = 'Pendiente';
        $enProceso  = 'En proceso';
        $hoy        = date('Y-m-d');

        // ---- Colores del proyecto (los mismos del reporte de tanques) ----
        $azulOscuro = '1B3B5F'; // banda superior
        $azulMedio  = '2F6690'; // franja secundaria
        $grisClaro  = 'F2F2F2'; // zebra
        $grisTexto  = '6B6B6B';

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Seguimiento');

        // Título de sección: texto azul con una línea gruesa debajo
        $tituloSeccion = function ($fila, $texto) use ($sheet, $azulOscuro) {
            $sheet->mergeCells("A$fila:G$fila");
            $sheet->setCellValue("A$fila", $texto);
            $sheet->getStyle("A$fila:G$fila")->getFont()->setBold(true)->setSize(11)->getColor()->setRGB($azulOscuro);
            $sheet->getStyle("A$fila:G$fila")->getBorders()->getBottom()
                ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM)
                ->getColor()->setRGB($azulOscuro);
        };

        // ================== BANDA SUPERIOR ==================
        $sheet->mergeCells('A1:G1');
        $sheet->setCellValue('A1', 'REPORTE DE SEGUIMIENTO A ZOOCRIADEROS');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(15)->getColor()->setRGB('FFFFFF');
        $sheet->getStyle('A1')->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_LEFT)
            ->setVertical(Alignment::VERTICAL_CENTER)
            ->setIndent(9); // deja espacio a la izquierda para el logo
        $sheet->getStyle('A1:G1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB($azulOscuro);
        $sheet->getRowDimension(1)->setRowHeight(46);

        $sheet->mergeCells('A2:G2');
        $sheet->setCellValue('A2', 'Proyecto de Control Biológico · Geolocalización ETV');
        $sheet->getStyle('A2')->getFont()->setItalic(true)->setSize(9)->getColor()->setRGB('FFFFFF');
        $sheet->getStyle('A2')->getAlignment()->setIndent(9);
        $sheet->getStyle('A2:G2')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB($azulMedio);
        $sheet->getRowDimension(2)->setRowHeight(18);

        // ---- Logos (si la imagen no existe, se omite y el Excel se genera igual) ----
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
            $logoAlcaldia->setCoordinates('F1');
            $logoAlcaldia->setOffsetX(100);
            $logoAlcaldia->setOffsetY(10);
            $logoAlcaldia->setWorksheet($sheet);
        }

        // fila espaciadora
        $sheet->getRowDimension(3)->setRowHeight(8);

        // ================== INFORMACIÓN GENERAL ==================
        $tituloSeccion(4, 'INFORMACIÓN GENERAL');

        $sheet->setCellValue('A5', 'Total de registros:');
        $sheet->setCellValue('B5', count($seguimientos));
        $sheet->setCellValue('A6', 'Fecha de generación:');
        $sheet->setCellValue('B6', date('d/m/Y H:i'));
        $sheet->getStyle('A5:A6')->getFont()->setBold(true)->getColor()->setRGB($grisTexto);
        $sheet->getStyle('B5:B6')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

        $sheet->getRowDimension(7)->setRowHeight(10);

        // ================== TABLA DE SEGUIMIENTOS ==================
        $tituloSeccion(8, 'SEGUIMIENTO DE ACTIVIDADES');

        $filaEncabezado = 10;
        $encabezados = ['Zoocriadero', 'Actividad', 'Tanque', 'Fecha Inicio', 'Fecha Fin', 'Responsable', 'Estado'];
        foreach ($encabezados as $i => $texto) {
            $sheet->setCellValue(chr(65 + $i) . $filaEncabezado, $texto);
        }

        $sheet->getStyle("A$filaEncabezado:G$filaEncabezado")->getFont()->setBold(true)->getColor()->setRGB('FFFFFF');
        $sheet->getStyle("A$filaEncabezado:G$filaEncabezado")->getFill()
            ->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB($azulOscuro);
        $sheet->getStyle("A$filaEncabezado:G$filaEncabezado")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getRowDimension($filaEncabezado)->setRowHeight(20);

        // Colores del estado
        $coloresEstado = [
            'Finalizado' => 'ABEBC6',
            'En proceso' => 'FAD7A0',
            'Pendiente'  => 'F5B7B1',
            'Retrasada'  => 'F1948A',
        ];

        $fila = $filaEncabezado + 1;
        $primeraFilaDatos = $fila;
        foreach ($seguimientos as $s) {

            // Igual que en pantalla: pendiente o en proceso con fecha pasada = Retrasada
            $retrasada = ($s['estado'] == $pendiente || $s['estado'] == $enProceso)
                && $s['fecha_registro'] < $hoy;
            $textoEstado = $retrasada ? 'Retrasada' : $s['estado'];

            $sheet->setCellValue("A$fila", $s['zoocriadero']);
            $sheet->setCellValue("B$fila", $s['actividad']);
            $sheet->setCellValue("C$fila", $s['tanque']);
            $fecha = date('d/m/Y', strtotime($s['fecha_registro']));
            $sheet->setCellValue("D$fila", $fecha . ($s['hora_inicio'] ? ' ' . substr($s['hora_inicio'], 0, 5) : ''));
            $sheet->setCellValue("E$fila", $s['hora_fin'] ? $fecha . ' ' . substr($s['hora_fin'], 0, 5) : '-');
            $sheet->setCellValue("F$fila", $s['responsable']);
            $sheet->setCellValue("G$fila", $textoEstado);

            // zebra striping
            if ((($fila - $primeraFilaDatos) % 2) === 1) {
                $sheet->getStyle("A$fila:G$fila")->getFill()
                    ->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB($grisClaro);
            }

            $sheet->getStyle("A$fila:G$fila")->getBorders()->getBottom()
                ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN)
                ->getColor()->setRGB('D9D9D9');
            $sheet->getStyle("A$fila:G$fila")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("B$fila")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("F$fila")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

            // color según el estado
            $sheet->getStyle("G$fila")->getFill()
                ->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB($coloresEstado[$textoEstado] ?? 'D5D8DC');
            $sheet->getStyle("G$fila")->getFont()->setBold(true);

            $fila++;
        }

        // ================== ANCHOS DE COLUMNA ==================
        $sheet->getColumnDimension('A')->setWidth(18);
        $sheet->getColumnDimension('B')->setWidth(34);
        $sheet->getColumnDimension('C')->setWidth(14);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(20);
        $sheet->getColumnDimension('F')->setWidth(26);
        $sheet->getColumnDimension('G')->setWidth(16);

        $sheet->setShowGridlines(false);

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
