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