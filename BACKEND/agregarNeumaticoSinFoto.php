<?php
require_once("./clases/neumaticoBD.php");
use Gauna\Tomas\NeumaticoBD;

$neumaticoJSON = isset($_POST["neumatico_json"]) ? $_POST["neumatico_json"] : NULL;
$obj = new stdClass();
$obj->exito = false;
$obj->mensaje = "Error al agregar...";

if($neumaticoJSON !== NULL)
{
    $neumaticoParseado = json_decode($neumaticoJSON);

    $obj_neumatico = new NeumaticoBD($neumaticoParseado->marca, $neumaticoParseado->medidas, $neumaticoParseado->precio);

    if($obj_neumatico->agregar())
    {
        $obj->exito = true;
        $obj->mensaje = "Agregado con exito";    
    }
}

echo json_encode($obj);