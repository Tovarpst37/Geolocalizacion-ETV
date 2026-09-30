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

class AccesoLoginTest extends TestCase
{
    protected function tearDown(): void
    {
        \Mockery::close();
    }

    #[RunInSeparateProcess]
    #[PreserveGlobalState(false)]
    public function testTC001_InicioDeSesionExitoso()
    {
        $GLOBALS['url_redireccion'] = null;

        $_POST['documento'] = 'aprendiz01';
        $_POST['password']  = 'clave12345';

        $usuarioSimulado = [
            'id_usuario'    => 1,
            'documento'     => 'aprendiz01',
            'contraseña'    => 'hash_simulado',
            'primer_nombre' => 'Aprendiz',
            'correo'        => 'aprendiz01@correo.com',
            'id_rol'        => 2,
            'nombre_rol'    => 'Coordinador',
            'id_estado'     => 1,
        ];

        $modelo = \Mockery::mock('overload:AccesoModel');

        $modelo->shouldReceive('buscarPorDocumento')
            ->once()
            ->with('aprendiz01')
            ->andReturn($usuarioSimulado);

        $modelo->shouldReceive('select')
            ->once()
            ->with(
                \Mockery::on(fn($sql) => str_contains($sql, 'FROM rol_permiso')),
                [2]
            )
            ->andReturn([
                ['nombre_modulo' => 'Zoocriadero', 'nombre_permiso' => 'VER'],
            ]);

        $hash = \Mockery::mock('alias:Hash');
        $hash->shouldReceive('validarHash')
            ->once()
            ->with('clave12345', 'hash_simulado')
            ->andReturn(true);

        require_once __DIR__ . '/../controller/Acceso/AccesoController.php';

        ob_start();
        (new AccesoController())->login();
        $salida = ob_get_clean();

        $this->assertSame('index.php', $GLOBALS['url_redireccion']);
        $this->assertSame('ok', $_SESSION['auth']);
        $this->assertSame(1, $_SESSION['id_usuarioU']);
        $this->assertArrayNotHasKey('error', $_SESSION);
        $this->assertContains('Zoocriadero', $_SESSION['modulos']);
    }
}