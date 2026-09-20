<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../controller/Zoocriadero/ZoocriaderoController.php';
require_once __DIR__ . '/../model/Zoocriadero/ZoocriaderoModel.php';

/**
 * TC-003 - Registro exitoso de zoocriadero
 * Objetivo: Validar que se cree correctamente un zoocriadero en el sistema.
 * Tipo: Funcional (Caja Negra)
 * Módulo: Zoocriadero
 * Funcionalidad: Registrar Zoocriadero
 * Precondición: El usuario debe estar autenticado con permisos de registro.
 */
class ZoocriaderoPostRegistrarTest extends TestCase
{
    public function testTC003_RegistroExitosoDeZoocriadero()
    {
        // Datos de entrada (según el caso de prueba)
        $codigo = 'ZC-001';
        $nombre_direccion = 'Zoocriadero La Esperanza - Cali, Comuna 15';
        $estado = 1;
        $coordinador = '5';
        $auxiliares = [];

        // Simulamos el modelo (la base de datos) para no depender de PostgreSQL
        $mock = $this->createMock(ZoocriaderoModel::class);

        // Resultado esperado: el sistema debe intentar crear el zoocriadero
        // con exactamente estos datos (paso 5 del caso: "Guardar el registro")
        $mock->expects($this->once())
             ->method('insert')
             ->with(
                 $this->stringContains('INSERT INTO zoocriadero'),
                 [$codigo, $nombre_direccion, $estado]
             )
             ->willReturn(true);

        // El resto de la simulación no es el foco de este caso, así que
        // solo dejamos que el flujo continúe sin errores
        $mock->method('select')->willReturn([['id_zoocriadero' => 1]]);
        $mock->method('update')->willReturn(true);

        // Ejecución (pasos 1-5 del caso, simulados directamente sobre el controlador)
        $controller = new ZoocriaderoController();
        $controller->postRegistrar($codigo, $nombre_direccion, $estado, $auxiliares, $coordinador, $mock);

        // Si llegamos hasta aquí sin que PHPUnit reporte fallos en las
        // expectativas de arriba, el resultado esperado se cumplió:
        // "El sistema crea el zoocriadero correctamente"
    }
}