<?php
require_once("./clases/neumaticoBD.php");
use Gauna\Tomas\NeumaticoBD;

$neumatico_json = isset($_POST["neumatico_json"]) ? $_POST["neumatico_json"] : NULL;
$foto = isset($_FILES["foto"]) ? $_FILES["foto"] : NULL;

$obj = new stdClass();
$obj->exito = false;
$obj->mensaje = "Error al modificar...";

if($neumatico_json !== NULL)
{
    $neumaticoParseado = json_decode($neumatico_json);
    $id = $neumaticoParseado->id;
    $marca = $neumaticoParseado->marca;
    $medidas = $neumaticoParseado->medidas;
    $precio = $neumaticoParseado->precio;


    if((new NeumaticoBD($marca, $medidas, 0))->existe(NeumaticoBD::traer()))
    {
        foreach(NeumaticoBD::traer() as $obj)
        {
            if($id === $obj->get_id())
            {
                $nuevoPath = $id . "." . $marca . ".modificado." . date("His") . "." . pathinfo($foto["name"], PATHINFO_EXTENSION);
                
                $neumatico = new NeumaticoBD($marca, $medidas, $precio, $id, $nuevoPath);
                
                if($neumatico->modificar())
                {
                    if(rename("./neumaticos/imagenes/" . $obj->get_pathFoto(), "./neumaticosModificados/" . $nuevoPath))
                    {
                        $obj->exito = true;
                        $obj->mensaje = "Modificado correctamente...";
                    }
                }
                break;
            }
        }
    }
}

echo json_encode($obj);