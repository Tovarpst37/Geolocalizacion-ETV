<?php

const VIA_PRINCIPAL = [
    "Calle",
    "Carrera",
    "Avenida",
    "Diagonal",
    "Transversal",
    "Circular",
    "Circunvalar",
    "Autopista",
    "Avenida Calle",
    "Avenida Carrera"
];

const CRUCE_PREFIJO = [
    "D" => "Diagonal",
    "T" => "Transversal"
];

const SUFIJO_VIA = [
    "N" => "Norte",
    "S" => "Sur",
    "E" => "Este",
    "O" => "Oeste",
    "A" => "A",
    "B" => "B"
];

$numero_de_via = range(1, 200);
$numero_de_la_via_generadora = range(1, 200);
$numero_de_placa = range(0, 100);
function construirDireccion($via_principal, $numero_via, $sufijo_via, $cruce_prefijo, $via_generadora, $sufijo_generadora, $placa)
{
    $direccion = "$via_principal $numero_via" . ($sufijo_via ?: '');
    $direccion .= " # " . ($cruce_prefijo ?: '') . $via_generadora . ($sufijo_generadora ?: '');
    $direccion .= " - $placa";
    return $direccion;
}



function parsearDireccion($direccion)
{
    $direccion = trim($direccion);

    //  formato completo, con prefijo y sufijos opcionales
    $patronCompleto = '/^(.+?)\s+(\d+)([A-Z]?)\s*#\s*([DT]?)(\d+)([A-Z]?)\s*-\s*(\d+)$/';

    //  formato simple, sin prefijo ni sufijos (ej: "Calle 20 # 15 - 30")
    $patronSimple = '/^(.+?)\s+(\d+)\s*#\s*(\d+)\s*-\s*(\d+)$/';

    if (preg_match($patronCompleto, $direccion, $m)) {
        return [
            'via_principal'     => $m[1] ?? '',
            'numero_via'        => $m[2] ?? '',
            'sufijo_via'        => $m[3] ?? '',
            'cruce_prefijo'     => $m[4] ?? '',
            'via_generadora'    => $m[5] ?? '',
            'sufijo_generadora' => $m[6] ?? '',
            'placa'             => $m[7] ?? '',
        ];
    }

    if (preg_match($patronSimple, $direccion, $m)) {
        return [
            'via_principal'     => $m[1] ?? '',
            'numero_via'        => $m[2] ?? '',
            'sufijo_via'        => '',
            'cruce_prefijo'     => '',
            'via_generadora'    => $m[3] ?? '',
            'sufijo_generadora' => '',
            'placa'             => $m[4] ?? '',
        ];
    }

    // ppor si devuelve vacío para que el form quede sin preseleccionar
    return [
        'via_principal'     => '',
        'numero_via'        => '',
        'sufijo_via'        => '',
        'cruce_prefijo'     => '',
        'via_generadora'    => '',
        'sufijo_generadora' => '',
        'placa'             => '',
    ];
}
