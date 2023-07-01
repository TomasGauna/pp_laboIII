<?php
/*modificarNeumaticoBD.php: Se recibirán por POST los siguientes valores: neumatico_json (id, marca, medidas y
precio, en formato de cadena JSON) para modificar un neumático en la base de datos. Invocar al método
modificar.*/
require_once("./clases/neumaticoBD.php");

use Gauna\Tomas\NeumaticoBD;

$neumaticoJSON = isset($_POST["neumatico_json"]) ? $_POST["neumatico_json"] : NULL;
$obj = new stdClass();
$obj->exito = false;
$obj->mensaje = "Error al modificar...";

if($neumaticoJSON !== NULL)
{
    $neumaticoParseado = json_decode($neumaticoJSON);
    $obj_neumatico = new NeumaticoBD($neumaticoParseado->marca, $neumaticoParseado->medidas, $neumaticoParseado->precio, $neumaticoParseado->id, $neumaticoParseado->pathFoto);
    if($obj_neumatico->modificar())
    {
        $obj->exito = true;
        $obj->mensaje = "Modificado correctamente...";
    }
}

echo json_encode($obj);