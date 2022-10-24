<?php

require_once 'conexion.php';

class ModelUsuarios
{
	//show users - add the word static before public to avoid issues with the php.ini on the hosting
	public static function MdlShowUsuarios($table, $item, $value)
	{
		$stmt = Conexion::conectar()->prepare("SELECT * FROM $table WHERE $item = :$item"); //:item is a parameter
		$stmt->bindParam(":".$item, $value, PDO::PARAM_STR); //":".item is the colum, and will be compare with the variable $value, and the parameter will string
		$stmt->execute();

		return $stmt->fetch(); //fetch() will teturn just one ROW of our table, this fetch will be receive by the var_dump on usuarios.controller.php

		$stmt -> close(); //Closing connection

		$stmt -> null;
	}
}