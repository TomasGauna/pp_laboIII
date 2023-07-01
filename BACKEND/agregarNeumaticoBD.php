<?php
/*agregarNeumaticoBD.php: Se recibirán por POST los valores: marca, medidas, precio y la foto para registrar un
neumático en la base de datos.
Verificar la previa existencia del neumático invocando al método existe. Se le pasará como parámetro el array que
retorna el método traer.
Si el neumático ya existe en la base de datos, se retornará un mensaje que indique lo acontecido.
Si el neumático no existe, se invocará al método agregar. La imagen se guardará en “./neumaticos/imagenes/”,
con el nombre formado por el marca punto hora, minutos y segundos del alta (Ejemplo: pirelli.105905.jpg).
Se retornará un JSON que contendrá: éxito(bool) y mensaje(string) indicando lo acontecido.*/

require_once("./clases/neumaticoBD.php");

use Gauna\Tomas\NeumaticoBD;

$marca = isset($_POST["marca"]) ? $_POST["marca"] : NULL;
$medidas = isset($_POST["medidas"]) ? $_POST["medidas"] : NULL;
$precio = isset($_POST["precio"]) ? $_POST["precio"] : 0;
$foto = isset($_FILES["foto"]) ? $_FILES["foto"]["name"] : NULL;

$obj = new stdClass();
$obj->exito = false;
$obj->mensaje = "Error...";


if($marca !== NULL && $medidas !== NULL && $foto !== NULL && $precio !== 0)
{
    $aux = explode(".", $foto);
    $pathFoto = $marca . "." . date('His') . "." . $aux[1];
    $neumatico = new NeumaticoBD($marca, $medidas, $precio, 0, $pathFoto);
    if($neumatico->existe(NeumaticoBD::traer()))
    {
        $obj->exito = true;
        $obj->mensaje = "Existe en la base de datos...";
    }
    else
    {
        if($neumatico->agregar() && Foto::subir("./neumaticos/imagenes/" . $neumatico->get_pathFoto()))
        {
            $obj->exito = true;
            $obj->mensaje = "No existia en la base de datos y ahora se guardo...";
        }
    }
}

echo json_encode($obj);