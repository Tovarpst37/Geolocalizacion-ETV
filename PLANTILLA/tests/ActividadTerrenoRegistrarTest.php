<?php

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\RunInSeparateProcess;
use PHPUnit\Framework\Attributes\PreserveGlobalState;

// Simulación de las funciones helper del proyecto
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

class ActividadTerrenoRegistrarTest extends TestCase
{
    protected function tearDown(): void
    {
        \Mockery::close();
    }

    #[RunInSeparateProcess]
    #[PreserveGlobalState(false)]
    public function testRegistroExitosoDeActividadDeTerreno()
    {
        $GLOBALS['url_redireccion'] = null;

        // Datos de entrada (el código se escribe en minúscula a propósito)
        $_POST['codigo'] = 'at-001';
        $_POST['nombre_actividad'] = 'Muestreo de agua';

        // Reemplaza la clase real: el "new ActividadTerrenoModel()" del controlador recibe este mock
        $modelo = \Mockery::mock('overload:ActividadTerrenoModel');
        $modelo->shouldReceive('insert')
            ->once()
            ->with(
                \Mockery::on(fn($sql) => str_contains($sql, 'INSERT INTO actividad_terreno')),
                ['AT-001', 'Muestreo de agua', 1]   // código en mayúscula, estado 1
            )
            ->andReturn(true);

        require_once __DIR__ . '/../controller/ActividadTerreno/ActividadTerrenoController.php';

        ob_start();
        (new ActividadTerrenoController())->postRegistrar();
        $salida = ob_get_clean();

        // Redirige a la consulta de actividades y no muestra mensaje de error
        $this->assertSame('ActividadTerreno/ActividadTerreno/getConsultar', $GLOBALS['url_redireccion']);
        $this->assertStringNotContainsString('No se pudo registrar', $salida);
    }
}