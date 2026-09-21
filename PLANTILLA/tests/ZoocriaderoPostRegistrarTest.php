<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../controller/Zoocriadero/ZoocriaderoController.php';
require_once __DIR__ . '/../model/Zoocriadero/ZoocriaderoModel.php';


class ZoocriaderoPostRegistrarTest extends TestCase
{
    public function testTC003_RegistroExitosoDeZoocriadero()
    {

        if (!function_exists('redirect')) {
            function redirect($url = null) {
             
            }
        }

        if (!function_exists('getUrl')) {
            function getUrl($ruta = '') {
               
                return 'http://localhost/' . ltrim($ruta, '/');
            }
        }

        $codigo = 'ZC-001';
        $nombre_direccion = 'Zoocriadero La Esperanza - Cali, Comuna 15';
        $estado = 1;
        $coordinador = '5';
        $auxiliares = [];

       
        $mock = $this->createMock(ZoocriaderoModel::class);

        $mock->expects($this->once())
             ->method('insert')
             ->with(
                 $this->stringContains('INSERT INTO zoocriadero'),
                 [$codigo, $nombre_direccion, $estado]
             )
             ->willReturn(true);

        $mock->method('select')->willReturn([['id_zoocriadero' => 1]]);
        $mock->method('update')->willReturn(true);

   
        $controller = new ZoocriaderoController();
        $controller->postRegistrar($codigo, $nombre_direccion, $estado, $auxiliares, $coordinador, $mock);

        $this->assertTrue(true);
    }
}