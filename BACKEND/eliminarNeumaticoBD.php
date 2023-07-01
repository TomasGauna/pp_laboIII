<?php
/*eliminarNeumaticoBD.php: Recibe el parámetro neumatico_json (id, marca, medidas y precio, en formato de
cadena JSON) por POST y se deberá borrar el neumático (invocando al método eliminar).
Si se pudo borrar en la base de datos, invocar al método guardarJSON y pasarle cómo parámetro el valor
'./archivos/neumaticos_eliminados.json'.
Retornar un JSON que contendrá: éxito(bool) y mensaje(string) indicando lo acontecido.*/
require_once("./clases/neumaticoBD.php");

use Gauna\Tomas\NeumaticoBD;

$neumaticoJSON = isset($_POST["neumatico_json"]) ? $_POST["neumatico_json"] : NULL;
$obj = new stdClass();
$obj->exito = false;
$obj->mensaje = "Error al eliminar...";

if($neumaticoJSON !== NULL)
{
    $neumaticoParseado = json_decode($neumaticoJSON);
    if(NeumaticoBD::eliminar($neumaticoParseado->id))
    {
        $obj_neumatico = new NeumaticoBD($neumaticoParseado->marca, $neumaticoParseado->medidas, $neumaticoParseado->precio, $neumaticoParseado->id);
        $resultado = json_decode($obj_neumatico->guardarJSON("./archivos/neumaticos_eliminados.json"));
        if($resultado->exito)
        {
            $obj->exito = true;
            $obj->mensaje = "Eliminado correctamente...";
        }
    }
}

echo json_encode($obj);