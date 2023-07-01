<?php
/*Se recibe por POST la marca y las medidas.
Retornar un JSON que contendrá: éxito(bool) y mensaje(string) (agregar el mensaje obtenido del método
verificarNeumaticoJSON).*/
require_once("./clases/neumatico.php");
//echo "?";die();
use Gauna\Tomas\Neumatico;

$marca = isset($_POST["marca"]) ? $_POST["marca"] : NULL;
$medidas = isset($_POST["medidas"]) ? $_POST["medidas"] : NULL;

$obj = new stdClass();
$obj->exito = false;
$obj->mensaje = "";

if($marca !== NULL && $medidas !== NULL)
{
    $neumatico = new Neumatico($marca, $medidas);
    $respuesta = json_decode(Neumatico::verificarNeumaticoJSON($neumatico, "./archivos/neumaticos.json"));
    $obj->exito = $respuesta->exito;
    $obj->mensaje = $respuesta->mensaje;
}

echo json_encode($obj);