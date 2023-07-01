<?php
require_once("./clases/neumaticoBD.php");
use Gauna\Tomas\NeumaticoBD;

$array = array();

foreach(NeumaticoBD::mostrarBorradosJSON("./archivos/neumaticos_eliminados.json") as $obj)
{
    $objStd = new stdClass();
    $objStd->marca = $obj->get_marca();
    $objStd->medidas = $obj->get_medidas();
    $objStd->precio = $obj->get_precio();
    $objStd->id = $obj->get_id();
    $objStd->pathFoto = $obj->get_pathFoto();

    array_push($array, $objStd);
}

echo json_encode($array);