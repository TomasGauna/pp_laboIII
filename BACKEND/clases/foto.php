<?php
class Foto
{
	public static function subir(string $pathFoto) : bool
	{
		$uploadOk = TRUE;
		$archivoSubido = false;
		$tipoArchivo = pathinfo($pathFoto, PATHINFO_EXTENSION);

		$esImagen = getimagesize($_FILES["foto"]["tmp_name"]);
		if($esImagen === FALSE) 
		{
			if($tipoArchivo != "doc" && $tipoArchivo != "txt" && $tipoArchivo != "rar") 
			{
				$uploadOk = FALSE;
			}
		}
		else 
		{
			if($tipoArchivo != "jpg" && $tipoArchivo != "jpeg" && $tipoArchivo != "gif" && $tipoArchivo != "png")
			{
				$uploadOk = FALSE;
			}

		}

		if ($uploadOk === FALSE) 
		{
			echo "<br/>NO SE PUDO SUBIR EL ARCHIVO.";
		} 
		else 
		{
			if (move_uploaded_file($_FILES["foto"]["tmp_name"], $pathFoto)) 
			{
				$archivoSubido = true;
			}
		}
		
		return $archivoSubido;
	}

	public static function borrar(string $path) : bool
	{
		$rta = false;

		if(unlink($path))
		{
			$rta = true;
		}
				
		return $rta;
	}
}
