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

	//add users
	public static function mdlAddUser($table, $data)
	{
		$stmt = Conexion::conectar()->prepare("INSERT INTO $table(nombre, usuario, password, perfil)
												VALUES(:nombre, :usuario, :password, :perfil)");

		//connecting the parameters
		$stmt -> bindParam(":nombre", $data["nombre"], PDO::PARAM_STR);
		$stmt -> bindParam(":usuario", $data["usuario"], PDO::PARAM_STR);
		$stmt -> bindParam(":password", $data["password"], PDO::PARAM_STR);
		$stmt -> bindParam(":perfil", $data["perfil"], PDO::PARAM_STR);

		//if execute we return an ok or an error
		if ($stmt->execute()) 
		{
			return "ok";
		}else
		{
			return "error";
		}

		//closing connection
		$stmt -> close();

		//empty the object
		$stmt -> null;
	}
}