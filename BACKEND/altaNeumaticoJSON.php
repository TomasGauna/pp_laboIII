<?php
/*Se recibe por POST la marca, las medidas y el precio. Invocar al método guardarJSON y
pasarle './archivos/neumaticos.json' cómo parámetro. */
require_once("./clases/neumatico.php");

use Gauna\Tomas\Neumatico;

$marca = isset($_POST["marca"]) ? $_POST["marca"] : NULL;
$medidas = isset($_POST["medidas"]) ? $_POST["medidas"] : NULL;
$precio = isset($_POST["precio"]) ? $_POST["precio"] : 0;

if($marca !== NULL && $medidas !== NULL && $precio !== 0)
{
    $neumatico = new Neumatico($marca, $medidas, $precio);
    echo $neumatico->guardarJSON("./archivos/neumaticos.json");
}