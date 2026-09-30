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

class UsuarioPostCreateTest extends TestCase
{
    protected function tearDown(): void
    {
        \Mockery::close();
    }

    #[RunInSeparateProcess]
    #[PreserveGlobalState(false)]
    public function testTC002_RegistroExitosoDeUsuario()
    {
        $GLOBALS['url_redireccion'] = null;

        $_POST['primer_nombre']    = 'Juan';
        $_POST['segundo_nombre']   = '';
        $_POST['primer_apellido']  = 'Pérez';
        $_POST['segundo_apellido'] = '';
        $_POST['tipo_documento']   = 1;
        $_POST['documento']        = '1023456789';
        $_POST['fecha_nacimiento'] = '1998-05-10';
        $_POST['correo']           = 'juan.perez@correo.com';
        $_POST['password']         = 'Segura123';
        $_POST['genero']           = 2;
        $_POST['rol']              = 2;
        $_POST['rh']               = 1;

        $modelo = \Mockery::mock('overload:UsuarioModel');

        $modelo->shouldReceive('exists')
            ->once()
            ->with(
                \Mockery::on(fn($sql) => str_contains($sql, 'FROM usuarios WHERE documento')),
                '1023456789'
            )
            ->andReturn(false);

        $modelo->shouldReceive('autoincrement')
            ->once()
            ->with('usuarios', 'id_usuario')
            ->andReturn(50);

        $modelo->shouldReceive('insert')
            ->once()
            ->with(\Mockery::on(function ($sql) {
                return str_contains($sql, 'INSERT INTO usuarios')
                    && str_contains($sql, "'Juan'")
                    && str_contains($sql, "'Pérez'")
                    && str_contains($sql, "'1023456789'")
                    && str_contains($sql, "'juan.perez@correo.com'")
                    && str_contains($sql, "'hash_simulado'");
            }))
            ->andReturn(true);

        $hash = \Mockery::mock('alias:Hash');
        $hash->shouldReceive('encripHash')
            ->once()
            ->with('Segura123')
            ->andReturn('hash_simulado');

        require_once __DIR__ . '/../controller/Usuario/UsuarioController.php';

        ob_start();
        (new UsuarioController())->postCreate();
        $salida = ob_get_clean();

        $this->assertSame('Usuario/Usuario/getUsuario', $GLOBALS['url_redireccion']);
        $this->assertStringNotContainsString('Hubo un error', $salida);
        $this->assertStringNotContainsString('ya existe un usuario', $salida);
    }
}