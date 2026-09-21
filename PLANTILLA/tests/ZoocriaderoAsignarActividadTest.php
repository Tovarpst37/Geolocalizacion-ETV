<?php

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\RunInSeparateProcess;
use PHPUnit\Framework\Attributes\PreserveGlobalState;

if (!function_exists('getUrl')) {
    function getUrl($modulo, $controlador, $funcion, $params = [])
    {
        return "$modulo/$controlador/$funcion";
    }
}
if (!function_exists('redirect')) {
    function redirect($url)
    {
        $GLOBALS['url_redireccion'] = $url;
    }
}

class SeguimientoZoocriaderoAsignarActividadTest extends TestCase
{
    protected function tearDown(): void
    {
        \Mockery::close();
    }

    #[RunInSeparateProcess]
    #[PreserveGlobalState(false)]
    public function testAsignaLaActividadControlBiologicoAlTanqueTQ005()
    {
        $GLOBALS['url_redireccion'] = null;
        $_POST['codigo']         = 'seg-002';
        $_POST['select_zoo']     = '1';
        $_POST['id_estado']      = '1';
        $_POST['selectUsuarios'] = '2';
        $_POST['selectTanques']  = '';
        $_POST['horario']        = '08:00';
        $_POST['actividades']    = ['2'];

        $modelo = \Mockery::mock('overload:SeguimientoZoocriaderoModel');

        $modelo->shouldReceive('select')
            ->twice()
            ->andReturnUsing(function ($sql) {
                if (str_contains($sql, 'INSERT INTO seguimiento_zoocriadero')) {
                    return [['id_seguimiento_zoo' => 10]];
                }
                return [];
            });

        $modelo->shouldReceive('insert')->andReturn(true);

        $this->assertNotEmpty($_POST['actividades']);
        $this->assertNotEmpty($_POST['selectTanques']);
    }
}