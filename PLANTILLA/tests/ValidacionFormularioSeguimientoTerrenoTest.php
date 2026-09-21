<?php

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\RunInSeparateProcess;
use PHPUnit\Framework\Attributes\PreserveGlobalState;

class ValidacionFormularioSeguimientoTerrenoTest extends TestCase
{
    private array $updates = [];

    protected function tearDown(): void
    {
        \Mockery::close();
    }

    private function ejecutarGetConsultar(array $actividades): void
    {
        $this->updates = [];

        // Reemplaza la clase real: el "new SeguimientoTerrenoModel()" del controlador recibe este mock
        $modelo = \Mockery::mock('overload:SeguimientoTerrenoModel');

        $modelo->shouldReceive('select')->andReturnUsing(function ($sql, $params = []) use ($actividades) {
            // Consulta del EXISTS: devuelve las actividades del escenario
            if (str_contains($sql, 'ya_registrada')) {
                return $actividades;
            }
            // Consulta del listado: un seguimiento en proceso
            return [[
                'id_seguimiento_terreno' => 8, 'cod_seguimiento' => 'SEGUIMIENTO# 8',
                'fecha' => date('Y-m-d'), 'hora_inicio' => '06:00:00', 'hora_fin' => '12:00:00',
                'id_estado' => 4, 'nombre_sitio' => 'Sitio Norte', 'cod_terreno' => 'Estanque',
                'primer_nombre' => 'Ana', 'primer_apellido' => 'Gómez', 'actividades' => 'alimentacion',
            ]];
        });

        // Guarda cada UPDATE que intenta hacer el controlador
        $modelo->shouldReceive('update')->andReturnUsing(function ($sql, $params = []) {
            $this->updates[] = ['sql' => $sql, 'params' => $params];
            return true;
        });

        require_once __DIR__ . '/../controller/SeguimientoTerreno/SeguimientoTerrenoController.php';

        ob_start();
        (new SeguimientoTerrenoController())->getConsultar();
        ob_end_clean();
    }

    private function huboUpdateA(int $estado): bool
    {
        foreach ($this->updates as $u) {
            if (preg_match('/SET\s+id_estado\s*=\s*' . $estado . '\b/', $u['sql'])
                && ($u['params'][0] ?? null) == 8) {
                return true;
            }
        }
        return false;
    }

    #[RunInSeparateProcess]
    #[PreserveGlobalState(false)]
    public function testTodasLasActividadesRegistradasPasaAFinalizado()
    {
        $this->ejecutarGetConsultar([
            ['id_actividad_terreno' => 1, 'nombre_actividad' => 'alimentacion', 'ya_registrada' => 't'],
            ['id_actividad_terreno' => 2, 'nombre_actividad' => 'limpieza',     'ya_registrada' => 't'],
        ]);

        $this->assertTrue($this->huboUpdateA(5), 'Debe pasar el seguimiento a Finalizado (5)');
        $this->assertFalse($this->huboUpdateA(4), 'No debe devolverlo a En proceso');
    }

    #[RunInSeparateProcess]
    #[PreserveGlobalState(false)]
    public function testActividadSinRegistrarNoFinalizaElSeguimiento()
    {
        $this->ejecutarGetConsultar([
            ['id_actividad_terreno' => 1, 'nombre_actividad' => 'alimentacion', 'ya_registrada' => 't'],
            ['id_actividad_terreno' => 2, 'nombre_actividad' => 'limpieza',     'ya_registrada' => 'f'],
        ]);

        $this->assertFalse($this->huboUpdateA(5), 'No debe pasar a Finalizado si falta una actividad');
        $this->assertTrue($this->huboUpdateA(4), 'Debe quedar o volver a En proceso (4)');
    }
}