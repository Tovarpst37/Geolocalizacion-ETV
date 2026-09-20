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


        $inicio = isset($_GET['comuna'] ) || isset($_GET['barrio'] ) || 
        isset($_GET['tipo_deposito'] ) || isset($_GET['hallazgo'] );

        // name de los input del formulario
        $filtroComuna  = $_GET['comuna'] ?? '';
        $filtroBarrio    = $_GET['barrio'] ?? '';
        $filtroDeposito  = $_GET['tipo_deposito'] ?? '';
        $filtroHallazgo     = $_GET['hallazgo'] ?? '';


        $errores = $this->validarFiltros($obj, $filtroComuna, $filtroBarrio, $filtroHallazgo);


        if ($limpiar || !$inicio ) {

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
        $totalDepositos=0;
        $vistos = [];





        foreach ($sitios as $s) {


            
            // el sitio solo esta una sola vez, aunque se encuentren varios depositos
            $vistos[$s['id_sitio']] = true;

            if ($s['tipo_deposito']!==null) {
                $totalDepositos++;
            }

            if ((int) $s['num_registros'] === 0) {
                $totalSinRegistros++;
            } elseif ((int) $s['con_larvas'] === 1) {
                $totalConLarvas++;
            }else{
                $totalSinLarvas++;
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
                    sd.id_sitio_deposito,
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
                GROUP BY s.id_sitio, sd.id_sitio_deposito, s.nombre_sitio, s.direccion,
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
    

     // Título de sección del Excel: texto azul con una línea gruesa debajo
    private function tituloSeccion($sheet, $fila, $texto)
    {
        $sheet->mergeCells("A$fila:F$fila");
        $sheet->setCellValue("A$fila", $texto);
        $sheet->getStyle("A$fila:F$fila")->getFont()->setBold(true)->setSize(11)->getColor()->setRGB('1B3B5F');
        $sheet->getStyle("A$fila:F$fila")->getBorders()->getBottom()
            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM)
            ->getColor()->setRGB('1B3B5F');
    }

 
    // Descarga el reporte en Excel con los mismos filtros de la pantalla
     public function exportarSitiosExcel()
    {
        // Se carga aqui para que la pantalla no dependa de Composer
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
            $url = getUrl('ReporteSitios', 'ReporteSitios', 'getReporteSitios');
            $separador = (strpos($url, '?') === false) ? '?' : '&';
 
            header('Location: ' . $url . $separador . http_build_query([
                'comuna'        => $filtroComuna,
                'barrio'        => $filtroBarrio,
                'tipo_deposito' => $filtroDeposito,
                'hallazgo'      => $filtroHallazgo,
            ]));
            exit;
        }
 
        // ---- Colores del proyecto (los mismos del reporte de tanques) ----
        $azulOscuro = '1B3B5F'; // banda superior
        $azulMedio  = '2F6690'; // franja secundaria
        $grisClaro  = 'F2F2F2'; // zebra
        $grisTexto  = '6B6B6B';
 
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Sitios');
 
        // ================== BANDA SUPERIOR ==================
        $sheet->mergeCells('A1:F1');
        $sheet->setCellValue('A1', 'REPORTE DE SITIOS REGISTRADOS');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(15)->getColor()->setRGB('FFFFFF');
        $sheet->getStyle('A1')->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_LEFT)
            ->setVertical(Alignment::VERTICAL_CENTER)
            ->setIndent(9); // deja espacio a la izquierda para el logo
        $sheet->getStyle('A1:F1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB($azulOscuro);
        $sheet->getRowDimension(1)->setRowHeight(46);
 
        $sheet->mergeCells('A2:F2');
        $sheet->setCellValue('A2', 'Proyecto de Control Biológico · Geolocalización ETV');
        $sheet->getStyle('A2')->getFont()->setItalic(true)->setSize(9)->getColor()->setRGB('FFFFFF');
        $sheet->getStyle('A2')->getAlignment()->setIndent(9);
        $sheet->getStyle('A2:F2')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB($azulMedio);
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
            $logoAlcaldia->setOffsetX(95);
            $logoAlcaldia->setOffsetY(10);
            $logoAlcaldia->setWorksheet($sheet);
        }
 
        // fila espaciadora
        $sheet->getRowDimension(3)->setRowHeight(8);
 
        // ================== INFORMACIÓN GENERAL ==================
        $this->tituloSeccion($sheet, 4, 'INFORMACIÓN GENERAL');
 
        $sheet->setCellValue('A5', 'Total de sitios:');
        $sheet->setCellValue('B5', count(array_unique(array_column($sitios, 'id_sitio'))));
        $sheet->setCellValue('A6', 'Fecha de generación:');
        $sheet->setCellValue('B6', date('d/m/Y H:i'));
        $sheet->getStyle('A5:A6')->getFont()->setBold(true)->getColor()->setRGB($grisTexto);
        $sheet->getStyle('B5:B6')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
 
        $sheet->getRowDimension(7)->setRowHeight(10);
 
        // ================== TABLA DE SITIOS ==================
        $this->tituloSeccion($sheet, 8, 'SITIOS REGISTRADOS');
 
        $filaEncabezado = 10;
        $encabezados = ['Sitio', 'Dirección', 'Barrio', 'Comuna', 'Tipo de Depósito', 'Hallazgo de Larvas'];
        foreach ($encabezados as $i => $texto) {
            $sheet->setCellValue(chr(65 + $i) . $filaEncabezado, $texto);
        }
 
        $sheet->getStyle("A$filaEncabezado:F$filaEncabezado")->getFont()->setBold(true)->getColor()->setRGB('FFFFFF');
        $sheet->getStyle("A$filaEncabezado:F$filaEncabezado")->getFill()
            ->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB($azulOscuro);
        $sheet->getStyle("A$filaEncabezado:F$filaEncabezado")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getRowDimension($filaEncabezado)->setRowHeight(20);
 
        // Colores del hallazgo
        $colores = [
            'Con larvas'    => 'F5B7B1',
            'Sin larvas'    => 'ABEBC6',
            'Sin registros' => 'D5D8DC',
        ];
 
        $fila = $filaEncabezado + 1;
        $primeraFilaDatos = $fila;
        foreach ($sitios as $s) {
            $texto = $this->textoHallazgo($s);
 
            $sheet->setCellValue("A$fila", $s['nombre_sitio']);
            $sheet->setCellValue("B$fila", $s['direccion']);
            $sheet->setCellValue("C$fila", $s['nombre_barrio']);
            $sheet->setCellValue("D$fila", $s['nombre_comuna']);
            $sheet->setCellValue("E$fila", $s['tipo_deposito'] ?? 'Sin depósito');
            $sheet->setCellValue("F$fila", $texto);
 
            // zebra striping
            if ((($fila - $primeraFilaDatos) % 2) === 1) {
                $sheet->getStyle("A$fila:F$fila")->getFill()
                    ->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB($grisClaro);
            }
 
            $sheet->getStyle("A$fila:F$fila")->getBorders()->getBottom()
                ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN)
                ->getColor()->setRGB('D9D9D9');
            $sheet->getStyle("C$fila:F$fila")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
 
            // color según el hallazgo
            $sheet->getStyle("F$fila")->getFill()
                ->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB($colores[$texto]);
            $sheet->getStyle("F$fila")->getFont()->setBold(true);
 
            $fila++;
        }
 
        // ================== ANCHOS DE COLUMNA ==================
        $sheet->getColumnDimension('A')->setWidth(28);
        $sheet->getColumnDimension('B')->setWidth(30);
        $sheet->getColumnDimension('C')->setWidth(22);
        $sheet->getColumnDimension('D')->setWidth(16);
        $sheet->getColumnDimension('E')->setWidth(26);
        $sheet->getColumnDimension('F')->setWidth(24);
 
        $sheet->setShowGridlines(false);
 
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
 



