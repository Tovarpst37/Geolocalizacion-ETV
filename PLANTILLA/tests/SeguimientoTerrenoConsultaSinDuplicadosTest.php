<?php

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\RunInSeparateProcess;
use PHPUnit\Framework\Attributes\PreserveGlobalState;

class SeguimientoTerrenoConsultaSinDuplicadosTest extends TestCase
{
    protected function tearDown(): void
    {
        \Mockery::close();
    }

    #[RunInSeparateProcess]
    #[PreserveGlobalState(false)]
    public function testListadoAgrupaPorSeguimientoSinDuplicados()
    {
        $consultasListado = [];

        // Reemplaza la clase real: el "new SeguimientoTerrenoModel()" del controlador recibe este mock
        $modelo = \Mockery::mock('overload:SeguimientoTerrenoModel');

        $modelo->shouldReceive('select')->andReturnUsing(function ($sql, $params = []) use (&$consultasListado) {
            // Consulta de estados (EXISTS): sin actividades asignadas, no se cambia nada
            if (str_contains($sql, 'ya_registrada')) {
                return [];
            }
            // Consulta del listado: se guarda el SQL para revisarlo
            $consultasListado[] = $sql;

            // Una sola fila por seguimiento, con las actividades unidas en un texto
            return [
                [
                    'id_seguimiento_terreno' => 1, 'cod_seguimiento' => 'ST-001',
                    'fecha' => date('Y-m-d'), 'hora_inicio' => '06:00:00', 'hora_fin' => '12:00:00',
                    'id_estado' => 4, 'nombre_sitio' => 'Sitio Norte', 'cod_terreno' => 'Estanque',
                    'primer_nombre' => 'Ana', 'primer_apellido' => 'Gómez',
                    'actividades' => 'alimentacion, limpieza',
                ],
                [
                    'id_seguimiento_terreno' => 2, 'cod_seguimiento' => 'ST-002',
                    'fecha' => date('Y-m-d'), 'hora_inicio' => '06:00:00', 'hora_fin' => '12:00:00',
                    'id_estado' => 3, 'nombre_sitio' => 'Sitio Sur', 'cod_terreno' => 'Estanque',
                    'primer_nombre' => 'Luis', 'primer_apellido' => 'Pérez',
                    'actividades' => 'alimentacion',
                ],
            ];
        });

        $modelo->shouldReceive('update')->andReturn(true);

        require_once __DIR__ . '/../controller/SeguimientoTerreno/SeguimientoTerrenoController.php';

        ob_start();
        (new SeguimientoTerrenoController())->getConsultar();
        ob_end_clean();

        $this->assertNotEmpty($consultasListado, 'El método debe ejecutar la consulta del listado');

        foreach ($consultasListado as $sql) {
            // Una fila por seguimiento: se agrupa por su id
            $this->assertMatchesRegularExpression('/GROUP\s+BY\s+s\.id_seguimiento_terreno\b/i', $sql);
            // Las actividades del seguimiento se unen en una sola columna
            $this->assertStringContainsString('STRING_AGG', $sql);
        }
    }
}