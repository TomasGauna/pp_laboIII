<?php
/*(GET) Se mostrará el listado de todos los neumáticos en formato JSON (traerJSON).
Pasarle './archivos/neumaticos.json' cómo parámetro.*/
require_once("./clases/neumatico.php");
use Gauna\Tomas\Neumatico;
$array = array();

foreach(Neumatico::traerJSON("./archivos/neumaticos.json") as $obj)
{
    $objStd = new stdClass();
    $objStd->marca = $obj->get_marca();
    $objStd->medidas = $obj->get_medidas();
    $objStd->precio = $obj->get_precio();

    array_push($array, $objStd);
}

echo json_encode($array);