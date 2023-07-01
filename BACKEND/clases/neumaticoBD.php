<?php
namespace Gauna\Tomas
{
    require_once("./clases/IParte4.php");
    require_once("./clases/IParte3.php");
    require_once("./clases/IParte2.php");
    require_once("./clases/IParte1.php");
    require_once("./clases/accesoDato.php");
    require_once("./clases/foto.php");
    require_once("./clases/neumatico.php");
    use AccesoDatos;
    use Exception;
    use PDO;
    use PDOException;
    use stdClass;

    class NeumaticoBD extends Neumatico implements IParte1, IParte2, IParte3, IParte4
    {
        protected int $id;
        protected string $pathFoto;
        
        public function __construct(string $marca, string $medidas, float $precio, int $id = 0, string $pathFoto = "")
        {
            $this->marca = $marca;
            $this->medidas = $medidas;
            $this->precio = $precio;
            $this->id = $id;
            $this->pathFoto = $pathFoto;
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

        public function get_pathFoto() : string
        {
            return $this->pathFoto;
        }

        public function get_id() : int
        {
            return $this->id;
        }

        public function toJSON(): string
        {
            $objStd = new stdClass();
            $objStd->marca = $this->marca;
            $objStd->medidas = $this->medidas;
            $objStd->precio = $this->precio;
            $objStd->id = $this->id;
            $objStd->pathFoto = $this->pathFoto;
            return json_encode($objStd);
        }

        public function agregar() : bool
        {

            $rta = false;
            
            try
            {
                $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
                $consulta =$objetoAccesoDato->retornarConsulta("INSERT INTO neumaticos (marca, medidas, precio, foto)"
                                                            . "VALUES(:marca, :medidas, :precio, :foto)");
                $consulta->bindValue(':marca', $this->marca, PDO::PARAM_STR);
                $consulta->bindValue(':medidas', $this->medidas, PDO::PARAM_STR);
                $consulta->bindValue(':precio', $this->precio, PDO::PARAM_INT);
                $consulta->bindValue(':foto', $this->pathFoto, PDO::PARAM_STR);

                $consulta->execute();

                $cant = $consulta->rowCount();
                
                if ($cant>0) 
                {
                    $rta = true;
                }
                else
                {
                    $rta = false;
                }
            }
            catch(PDOException)
            {
                $rta = false;
            }

            return $rta;
        }

        public static function traer() : array
        {
            try
            {
                $db = AccesoDatos::dameUnObjetoAcceso();
                $sql = $db->retornarConsulta('SELECT * FROM neumaticos');
                $array = array();

                if (!$sql->execute()) 
                {
                    throw new Exception($sql->errorInfo()[2]);
                }

                $resultado = $sql->fetchall();
                
                foreach ($resultado as $fila) 
                {
                    $neumatico = new NeumaticoBD($fila["marca"], $fila["medidas"], $fila["precio"],$fila["id"], $fila["foto"]);

                    array_push($array, $neumatico);
                }
            }
            catch(PDOException $e)
            {
                echo "Error al traer todos..." . $e->getMessage();
            }                                          

            return $array;
        }

        public static function eliminar(int $id) : bool
        {
            try
            {
                $rta = false;
                $db = AccesoDatos::dameUnObjetoAcceso();
                $sql = $db->retornarConsulta('DELETE FROM neumaticos WHERE id = :id');
                $sql->bindValue(':id', $id, PDO::PARAM_INT);
                $sql->execute();
                
                $cant = $sql->rowCount();
                
                if ($cant>0) 
                {
                    $rta = true;
                }
                else
                {
                    $rta = false;
                }
            }
            catch(PDOException)
            {
                $rta = false;
            }

            return $rta;
        }

        public function modificar() : bool
        {
            try
            {
                $rta = false;
                $db = AccesoDatos::dameUnObjetoAcceso();
    
                $sql = $db->retornarConsulta('UPDATE neumaticos SET marca = :marca, medidas = :medidas, precio = :precio, foto = :foto WHERE id = :id');
                
                $sql->bindValue(':id', $this->id, PDO::PARAM_INT);
                $sql->bindValue(':marca', $this->marca, PDO::PARAM_STR);
                $sql->bindValue(':medidas', $this->medidas, PDO::PARAM_STR);
                $sql->bindValue(':precio', $this->precio, PDO::PARAM_INT);
                $sql->bindValue(':foto', $this->pathFoto, PDO::PARAM_STR);
                    
                $sql->execute();

                $cant = $sql->rowCount();
                
                if ($cant>0) 
                {
                    $rta = true;
                }
                else
                {
                    $rta = false;
                }
            }
            catch(PDOException)
            {
                $rta = false;
            }
    
            return $rta;
        }

        public function existe(array $neumaticosBD) : bool
        {
            $rta = false;

            foreach($neumaticosBD as $obj)
            {
                if($obj->get_marca() === $this->marca && $obj->get_medidas() === $this->medidas)
                {
                    $rta = true;
                    break;
                }
            }

            return $rta;
        }

        public function guardarEnArchivo() : string
        {
            $obj = new stdClass();
            $obj->exito = false;
            $obj->mensaje = "Error...";

            $arrayAux = explode(".", $this->pathFoto);
            $nuevoPath = "$this->id.$this->marca.borrado." . date("His") . ".$arrayAux[2]";
            
            $ar = fopen("./archivos/neumaticosbd_borrados.txt", "a");

            $cant = fwrite($ar, "$this->id, $this->marca, $this->medidas, $this->precio, $nuevoPath\r\n");

            if($cant > 0)
            {
                if(rename("./neumaticos/imagenes/" . $this->pathFoto, "./neumaticosBorrados/" . $nuevoPath))
                {
                    $obj->exito = true;
                    $obj->mensaje = "Se guardo el neumatico eliminado...";
                }
            }

            fclose($ar);

            return json_encode($obj);
        }

        public static function mostrarBorradosJSON(string $path) : array
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
                    $neumatico = new NeumaticoBD($parseado->marca, $parseado->medidas,$parseado->precio, $parseado->id, $parseado->pathFoto);
                    array_push($neumaticos, $neumatico);
                }
            }
            fclose($ar);

            return $neumaticos;
        }

        public static function mostrarModificados() : void
        {
            $directorio = "./neumaticosModificados/";
            $imagenes = glob($directorio . "*.jpg"); // Obtener todas las imágenes con extensión .jpg

            echo "
            <html>
                <head><title>Listado de Fotos modificadas</title></head>
                <body>
                    <table>
                        <thead>
                            <tr>
                            <td>Foto</td>
                            </tr>
                        </thead>
                        <tbody>";
                        foreach ($imagenes as $imagen) 
                        {
                            echo '<tr><td>';
                            echo '<img src="' . $imagen . '" width="50" height="50">';
                            echo '</tr></td>';
                        }
            echo "
                        </tbody>
                    </table>
                </body>
            </html>";
        }
    }
}