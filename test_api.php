<?php
require_once __DIR__ . '/app/models/ApiEscolar.php';

$api = new ApiEscolar();

// PRUEBA IGUAL QUE INSOMNIA
$respuesta = $api->buscarAlumnosAEBR('jared');

echo '<pre>';
print_r($respuesta);
