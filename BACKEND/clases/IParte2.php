<?php
namespace Gauna\Tomas
{
    interface IParte2
    {
        public static function eliminar(int $id) : bool;
        public function modificar() : bool;
    }
}