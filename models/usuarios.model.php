<?php

require_once 'conexion.php';

class ModelUsuarios
{
	//show users - add the word static before public to avoid issues with the php.ini on the hosting
	public static function MdlShowUsuarios($table, $item, $value)
	{

		//adding this new if because function ctrShowUsers on the controller, $item and $value will be send empty, so we need to compare with thi if
		// if $item is different a null, we are going to send just one user
		if($item != null)
		{
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $table WHERE $item = :$item"); //:item is a parameter
			$stmt->bindParam(":".$item, $value, PDO::PARAM_STR); //":".item is the colum, and will be compare with the variable $value, and the parameter will string
			$stmt->execute();

			return $stmt->fetch(); //fetch() will teturn just one ROW of our table, this fetch will be receive by the var_dump on usuarios.controller.php
		}else
		{
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $table"); // if $item is null, we need to send all the users, thats why we dont have parameters
			$stmt->execute();

			return $stmt->fetchAll(); //fetchAll() will return all the ROWS of our table, this fetch will be receive by the var_dump on usuarios.php
		}

		$stmt -> close(); //Closing connection

		$stmt -> null;
	}

	//add users
	public static function mdlAddUser($table, $data)
	{
		$stmt = Conexion::conectar()->prepare("INSERT INTO $table(nombre, usuario, password, perfil, foto)
												VALUES(:nombre, :usuario, :password, :perfil, :foto)");

		//connecting the parameters
		$stmt -> bindParam(":nombre", $data["nombre"], PDO::PARAM_STR);
		$stmt -> bindParam(":usuario", $data["usuario"], PDO::PARAM_STR);
		$stmt -> bindParam(":password", $data["password"], PDO::PARAM_STR);
		$stmt -> bindParam(":perfil", $data["perfil"], PDO::PARAM_STR);
		$stmt -> bindParam(":foto", $data["foto"], PDO::PARAM_STR);

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

	//edit user
	public static function mdlEditUser($table, $data)
	{
		$stmt = Conexion::conectar()->prepare("UPDATE $table SET nombre = :nombre, password = :password, perfil = :perfil, foto = :foto
												WHERE usuario = :usuario");

		//connecting the parameters
		$stmt -> bindParam(":nombre", $data["nombre"], PDO::PARAM_STR);
		$stmt -> bindParam(":usuario", $data["usuario"], PDO::PARAM_STR);
		$stmt -> bindParam(":password", $data["password"], PDO::PARAM_STR);
		$stmt -> bindParam(":perfil", $data["perfil"], PDO::PARAM_STR);
		$stmt -> bindParam(":foto", $data["foto"], PDO::PARAM_STR);

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

	//Update user
	public static function mdlActualizarUsuario($table, $item1, $valor1, $item2, $valor2)
	{

		$stmt = Conexion::conectar()->prepare("UPDATE $table SET $item1 = :$item1 WHERE $item2 = :$item2");

		//connecting the parameters
		$stmt -> bindParam(":".$item1, $valor1, PDO::PARAM_STR);
		$stmt -> bindParam(":".$item2, $valor2, PDO::PARAM_STR);

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