<?php
/*(GET) Se mostrará el listado completo de los neumáticos (obtenidos de la base de
datos) en una tabla (HTML con cabecera). Invocar al método traer. */
require_once("./clases/neumaticoBD.php");
use Gauna\Tomas\NeumaticoBD;

$tabla = isset($_GET["tabla"]) ? $_GET["tabla"] : NULL;

if($tabla !== NULL)
{   
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
        foreach(NeumaticoBD::traer() as $obj)
        {
            echo "<tr><td>{$obj->get_id()}</td><td>{$obj->get_marca()}</td><td>{$obj->get_medidas()}</td><td>{$obj->get_precio()}</td><td>{$obj->get_pathFoto()}</td></tr>";
        }
    echo "
                </tbody>
            </table>
        </body>
    </html>";
}
else
{
    $array = array();

    foreach(NeumaticoBD::traer() as $obj)
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
}
?>



