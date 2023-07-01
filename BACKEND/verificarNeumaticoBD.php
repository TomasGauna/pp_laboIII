<?php
/*verificarNeumaticoBD.php: Se recibe por POST el parámetro obj_neumatico, que será una cadena JSON (marca y
medidas), si coincide con algún registro de la base de datos (invocar al método traer) retornará los datos del
objeto (invocar al toJSON). Caso contrario, un JSON vacío ({}). */
require_once("./clases/neumaticoBD.php");

use Gauna\Tomas\NeumaticoBD;

$obj_neumatico = isset($_POST["obj_neumatico"]) ? $_POST["obj_neumatico"] : NULL;

if($obj_neumatico !== null)
{
    $neumaticoParseado = json_decode($obj_neumatico);
    $neumaticosBD = NeumaticoBD::traer();
    $neumatico = new NeumaticoBD($neumaticoParseado->marca, $neumaticoParseado->medidas, 0);

    if($neumatico->existe($neumaticosBD))
    {
        foreach($neumaticosBD as $obj)
        {
            if($obj->get_marca() === $neumaticoParseado->marca && $obj->get_medidas() === $neumaticoParseado->medidas)
            {
                echo $obj->toJSON();
            }
        }
    }
    else
    {
        echo "{}";
    }
}