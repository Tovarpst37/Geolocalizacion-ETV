<?php


// Los "use" van siempre arriba del archivo, fuera de la clase
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
 
 

include_once '../model/ReporteSitios/ReporteSitiosModel.php';



class ReporteSitiosController
{



    public function getReporteSitios()
    {


        $obj = new ReporteSitiosModel();

        //listar los select de la vista
        $comunas = $obj->select("SELECT id_comuna, nombre_comuna
    FROM comuna WHERE id_estado = 1 ORDER BY nombre_comuna");

        $barrios = $obj->select("SELECT id_barrio, nombre_barrio, id_comuna
    FROM barrio WHERE id_estado = 1 ORDER BY nombre_barrio");

        $tiposDeposito = $obj->select("SELECT id_tipo_deposito, nombre
    FROM tipo_de_deposito ORDER BY nombre");
        $limpiar = isset($_GET['limpiar']);

        // name de los input del formulario
        $filtroComuna  = $_GET['comuna'] ?? '';
        $filtroBarrio    = $_GET['barrio'] ?? '';
        $filtroDeposito  = $_GET['tipo_deposito'] ?? '';
        $filtroHallazgo     = $_GET['hallazgo'] ?? '';


        $errores = $this->validarFiltros($obj, $filtroComuna, $filtroBarrio, $filtroHallazgo);


        if ($limpiar) {

            $sitios = [];
        } elseif (!empty($errores)) {

            // si hay errores no se consulta
            $sitios = [];
        } else {

            $sitios = $this->consultarSitios(
                $obj,
                $filtroComuna,
                $filtroBarrio,
                $filtroDeposito,
                $filtroHallazgo
            );

            if (empty($sitios)) {
                $errores[] = "No se encontraron registros con los filtros de busqueda seleccionados.";
            }
        }



        $mensajeError = !empty($errores) ? implode(' ', $errores) : null;

        // conteo 
        $totalConLarvas  = 0;
        $totalSinLarvas  = 0;
        $totalSinRegistros = 0;

        $vistos = [];





        foreach ($sitios as $s) {


            if (isset($vistos[$s['id_sitio']])) {
                continue;
            }

            $vistos[$s['id_sitio']] = true;

            if ((int) $s['num_registros'] === 0) {
                $totalSinRegistros++;
            } elseif ((int) $s['con_larvas'] === 1) {
                $totalConLarvas++;
            }
        }

        $totalSitios = count($vistos);

        include_once '../view/ReporteSitios/ReporteSitios.php';
    }


    public function validarFiltros($obj, $comuna, $barrio, $hallazgo)
    {

        $errores = [];


        $hallazgosValidos = ['', 'todas', 'inspeccion', 'siembra', 'seguimiento', 'resiembra'];

        if (!in_array($hallazgo, $hallazgosValidos, true)) {
            $errores[] = "El filtro de hallazgo de larvas no es valido";
        }

        if ($comuna !== '' && $barrio !== '') {
            $relacion = $obj->select(
                "SELECT 1 FROM barrio WHERE id_barrio = $1 AND id_comuna = $2",
                [(int) $barrio, (int) $comuna]
            );


            if (empty($relacion)) {
                $errores[] = "El barrio seleccionado no se encuentra en la comuna";
            }
        }


        return $errores;
    }


    public function consultarSitios($obj, $comuna, $barrio, $deposito, $hallazgo)
    {

        //opciones validas 
        $campoHallazgo = [
            'inspeccion'  => 'presencia_larvas_inspeccion',
            'siembra'     => 'presencia_larvas_siembra',
            'seguimiento' => 'presencia_larvas_seguimiento',
            'resiembra'   => 'presencia_larvas_resiembra',
        ];

        $condicionHallazgo = '';
        if ($hallazgo === 'Todas') {


            $condicionHallazgo = "AND (sat.presencia_larvas_inspeccion OR sat.presencia_larvas_siembra
        OR sat.presencia_larvas_seguimiento OR sat.presencia_larvas_resiembra)";
        } elseif (isset($campoHallazgo[$hallazgo])) {
            $condicionHallazgo = "AND sat." . $campoHallazgo[$hallazgo] . " = true";
        }

        $sql = "SELECT
                    s.id_sitio,
                    s.nombre_sitio,
                    s.direccion,
                    b.nombre_barrio,
                    c.nombre_comuna,
                    td.nombre AS tipo_deposito,
                    COALESCE(bool_or(
                        sat.presencia_larvas_inspeccion OR sat.presencia_larvas_siembra
                        OR sat.presencia_larvas_seguimiento OR sat.presencia_larvas_resiembra
                    ), false)::int AS con_larvas,
                    COUNT(sat.id_sub_actividad) AS num_registros
                FROM sitio s
                INNER JOIN barrio b ON s.id_barrio = b.id_barrio
                INNER JOIN comuna c ON b.id_comuna = c.id_comuna
                LEFT JOIN sitio_deposito sd ON sd.id_sitio = s.id_sitio
                LEFT JOIN tipo_de_deposito td ON sd.id_tipo_deposito = td.id_tipo_deposito
                LEFT JOIN seguimiento_terreno st ON st.id_sitio = s.id_sitio
                LEFT JOIN sub_actividades_ter sat ON sat.id_seguimiento_terreno = st.id_seguimiento_terreno
                WHERE ($1::int IS NULL OR c.id_comuna = $1)
                  AND ($2::int IS NULL OR b.id_barrio = $2)
                  AND ($3::int IS NULL OR td.id_tipo_deposito = $3)
                  $condicionHallazgo
                GROUP BY s.id_sitio, s.nombre_sitio, s.direccion,
                         b.nombre_barrio, c.nombre_comuna, td.nombre
                ORDER BY s.nombre_sitio";


        $param = [
            $comuna !== '' ? (int) $comuna : null,
            $barrio   !== '' ? (int) $barrio   : null,
            $deposito   !== '' ? (int) $deposito   : null,
        ];

        return $obj->select($sql, $param) ?: [];
    }

    private function textoHallazgo($fila)
    {
        if ((int) $fila['num_registros'] === 0) {
            return 'Sin registros';
        }
        return (int) $fila['con_larvas'] === 1 ? 'Con larvas' : 'Sin larvas';
    }
 
 
    // Descarga el reporte en Excel con los mismos filtros de la pantalla
    public function exportarSitiosExcel()
    {
        // Se carga aqui para que la pantalla no dependa de Composer
        // (deja la misma ruta que usa tu ReportesController)
        require_once __DIR__ . '/../../../vendor/autoload.php';
 
        $obj = new ReporteSitiosModel();
 
        $filtroComuna   = $_GET['comuna'] ?? '';
        $filtroBarrio   = $_GET['barrio'] ?? '';
        $filtroDeposito = $_GET['tipo_deposito'] ?? '';
        $filtroHallazgo = $_GET['hallazgo'] ?? '';
 
        $errores = $this->validarFiltros($obj, $filtroComuna, $filtroBarrio, $filtroHallazgo);
 
        $sitios = empty($errores)
            ? $this->consultarSitios($obj, $filtroComuna, $filtroBarrio, $filtroDeposito, $filtroHallazgo)
            : [];
 
        // Con errores o sin datos se vuelve a la pantalla del reporte
        if (!empty($errores) || empty($sitios)) {
            $url = getUrl('Reportes', 'ReporteSitios', 'report');
            $separador = (strpos($url, '?') === false) ? '?' : '&';
 
            header('Location: ' . $url . $separador . http_build_query([
                'comuna'        => $filtroComuna,
                'barrio'        => $filtroBarrio,
                'tipo_deposito' => $filtroDeposito,
                'hallazgo'      => $filtroHallazgo,
            ]));
            exit;
        }
 
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Sitios');
 
        // Titulo
        $sheet->mergeCells('A1:F1');
        $sheet->setCellValue('A1', 'REPORTE DE SITIOS REGISTRADOS');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14)->getColor()->setRGB('FFFFFF');
        $sheet->getStyle('A1:F1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('1B3B5F');
        $sheet->getRowDimension(1)->setRowHeight(30);
        $sheet->getStyle('A1')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
 
        // Informacion general
        $sheet->setCellValue('A2', 'Total de sitios:');
        $sheet->setCellValue('B2', count(array_unique(array_column($sitios, 'id_sitio'))));
        $sheet->setCellValue('A3', 'Fecha de generación:');
        $sheet->setCellValue('B3', date('d/m/Y H:i'));
        $sheet->getStyle('A2:A3')->getFont()->setBold(true);
        $sheet->getStyle('B2:B3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
 
        // Encabezados de la tabla
        $sheet->setCellValue('A5', 'Sitio');
        $sheet->setCellValue('B5', 'Dirección');
        $sheet->setCellValue('C5', 'Barrio');
        $sheet->setCellValue('D5', 'Comuna');
        $sheet->setCellValue('E5', 'Tipo de Depósito');
        $sheet->setCellValue('F5', 'Hallazgo de Larvas');
        $sheet->getStyle('A5:F5')->getFont()->setBold(true)->getColor()->setRGB('FFFFFF');
        $sheet->getStyle('A5:F5')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('2F6690');
 
        // Colores del hallazgo
        $colores = [
            'Con larvas'    => 'F5B7B1',
            'Sin larvas'    => 'ABEBC6',
            'Sin registros' => 'D5D8DC',
        ];
 
        // Filas de datos
        $fila = 6;
        foreach ($sitios as $s) {
            $texto = $this->textoHallazgo($s);
 
            $sheet->setCellValue("A$fila", $s['nombre_sitio']);
            $sheet->setCellValue("B$fila", $s['direccion']);
            $sheet->setCellValue("C$fila", $s['nombre_barrio']);
            $sheet->setCellValue("D$fila", $s['nombre_comuna']);
            $sheet->setCellValue("E$fila", $s['tipo_deposito'] ?? 'Sin depósito');
            $sheet->setCellValue("F$fila", $texto);
            $sheet->getStyle("F$fila")->getFill()->setFillType(Fill::FILL_SOLID)
                  ->getStartColor()->setRGB($colores[$texto]);
            $fila++;
        }
 
        // Ancho automatico de columnas
        foreach (['A', 'B', 'C', 'D', 'E', 'F'] as $columna) {
            $sheet->getColumnDimension($columna)->setAutoSize(true);
        }
 
        // Descarga
        $nombreArchivo = 'reporte_sitios_' . date('Y-m-d') . '.xlsx';
 
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
 



