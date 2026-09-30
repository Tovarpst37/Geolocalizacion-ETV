<?php

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\RunInSeparateProcess;
use PHPUnit\Framework\Attributes\PreserveGlobalState;

class TanquesInhactivosTest extends TestCase
{
    protected function tearDown(): void
    {
        \Mockery::close();
    }

    #[RunInSeparateProcess]
    #[PreserveGlobalState(false)]
    public function testConsultaSoloPideTanquesHabilitados()
    {
        $_GET['id_zoocriadero'] = 10;
        $sqlTanques = null;

        $modelo = \Mockery::mock('overload:SeguimientoZoocriaderoModel');
        $modelo->shouldReceive('select')->andReturnUsing(function ($sql) use (&$sqlTanques) {
            if (str_contains($sql, 'FROM tanque')) {
                $sqlTanques = $sql;
                return [['id_tanque' => 1, 'codigo_tanque' => 'TQ-001']];
            }
            return [];
        });

        require_once __DIR__ . '/../controller/SeguimientoZoocriadero/SeguimientoZoocriaderoController.php';

        ob_start();
        (new SeguimientoZoocriaderoController())->getTanquesPorZoo();
        $json = json_decode(ob_get_clean(), true);

        
        $this->assertNotNull($sqlTanques, 'El método debe consultar la tabla tanque');
        $this->assertMatchesRegularExpression('/id_estado\s*=\s*1\b/', $sqlTanques);
        $this->assertStringContainsString("id_zoocriadero = '10'", $sqlTanques);
        $this->assertCount(1, $json['tanques']);
    }
}