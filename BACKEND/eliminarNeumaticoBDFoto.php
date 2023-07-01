<?php
require_once("./clases/neumaticoBD.php");

use Gauna\Tomas\NeumaticoBD;

$neumatico_json = isset($_POST["neumatico_json"]) ? $_POST["neumatico_json"] : NULL;

$obj = new stdClass();
$obj->exito = false;
$obj->mensaje = "Error...";

if($neumatico_json !== NULL)
{
    $neumaticoParseado = json_decode($neumatico_json);
    $neumatico = new NeumaticoBD($neumaticoParseado->marca, $neumaticoParseado->medidas, $neumaticoParseado->precio, $neumaticoParseado->id, $neumaticoParseado->pathFoto);

    if(NeumaticoBD::eliminar($neumatico->get_id()))
    {
        $retornoJSON = $neumatico->guardarEnArchivo();
        $obj->exito = json_decode($retornoJSON)->exito;
        $obj->mensaje = json_decode($retornoJSON)->mensaje; 
    }

    echo json_encode($obj);
}
else
{
    $ar = fopen("./archivos/neumaticosbd_borrados.txt", "r");
    $cadena = "";
    $contenido = "";

    echo "<!DOCTYPE html>
    <html>
        <head><title>Listado de Usuarios</title></head>
        <body>
            <table>
                <thead>
                    <tr>
                    <td>ID</td>
                    <td>Marca</td>
                    <td>Medidas</td>
                    <td>Precio</td>
                    <td>Path Foto</td>
                    </tr>
                </thead>
                <tbody>";
                    while(!feof($ar))
                    {
                        $contenido = fgets($ar);
                        $array_linea = explode(",", $contenido);
                        $array_linea[0] = trim($array_linea[0]);
                
                        if($array_linea[0] != "")
                        { 
                            $id = trim($array_linea[0]);
                            $marcas = trim($array_linea[1]);
                            $medidas = trim($array_linea[2]);
                            $precio = trim($array_linea[3]);
                            $pathFoto = trim($array_linea[4]);
                            echo '<tr><td>' . $id . '</td><td>' . $marcas . '</td><td>'. $medidas . '</td><td>' . $precio . '</td><td>'. $pathFoto . '</td><td><img src=' . "./neumaticosBorrados/". $pathFoto . ' width="50" height="50"/></td></td></tr>';
                        }
                    }
                    echo "
                </tbody>
            </table>
        </body>
    </html>";


    fclose($ar);
}