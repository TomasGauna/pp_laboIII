<?php
namespace Gauna\Tomas
{

    use stdClass;

    class Neumatico
    {
        protected string $marca;
        protected string $medidas;
        protected int $precio;

        public function __construct(string $marca, string $medidas, float $precio = 0)
        {
            $this->marca = $marca;
            $this->medidas = $medidas;
            $this->precio = $precio;
        }

        public function get_marca() : string
        {
            return $this->marca;
        }

        public function get_medidas() : string
        {
            return $this->medidas;
        }

        public function get_precio() : float
        {
            return $this->precio;
        }

        public function toJSON() : string
        {
            $objStd = new stdClass();
            $objStd->marca = $this->marca;
            $objStd->medidas = $this->medidas;
            $objStd->precio = $this->precio;
            return json_encode($objStd);
        }

        public function guardarJSON(string $path) : string
        {
            $obj = new stdClass();
            $obj->exito = false;
            $obj->mensaje = "No se ha podido guardar el neumatico...";
            
            $ar = fopen($path, "a");

            $cant = fwrite($ar, "{$this->toJSON()}\n\r");

            if($cant > 0)
            {
                $obj->exito = true;
                $obj->mensaje = "Neumatico guardado correctamente...";
            }

            fclose($ar);

            return json_encode($obj);
        }

        public static function traerJSON(string $path) : array
        {
            $neumaticos = array();
            $contenido = "";
            $ar = fopen($path, "r");
    
            while(!feof($ar))
            {
                $contenido = fgets($ar);
                $obj = explode("\n\r", $contenido);
                $obj = $obj[0];
                $obj = trim($obj);
                if($obj !== "")
                {
                    $parseado = json_decode($obj);
                    $neumatico = new Neumatico($parseado->marca, $parseado->medidas,$parseado->precio);
                    array_push($neumaticos, $neumatico);
                }
            }
            fclose($ar);

            return $neumaticos;
        }

        public static function verificarNeumaticoJSON(Neumatico $param, string $path) : string
        {
            $obj = new stdClass();
            $obj->exito = false;
            $obj->mensaje = "No se han encontrado neumaticos en el listado...";
            $suma = 0;
            
            foreach(Neumatico::traerJSON($path) as $neumatico)
            {
                if($neumatico->get_marca() === $param->get_marca() && $neumatico->medidas === $param->get_medidas())
                {
                    $suma += $neumatico->precio;
                }
            }

            if($suma > 0)
            {
                $obj->exito = true;
                $obj->mensaje = "El neumatico esta registrado. La sumatoria de los neumaticos con las mismas medidas y marca es igual a $suma";
            }

            return json_encode($obj);
        }
    }
}
