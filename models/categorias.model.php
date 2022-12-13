<?php

//asking for connection to the DB
require_once 'conexion.php';

//creating class
class ModelCategorias
{

	// Creating Category
	static public function mdlIngresarCategoria($tabla, $datos)
	{

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(categoria) VALUES(:categoria)");

		$stmt -> bindParam(":categoria", $datos, PDO::PARAM_STR);

		if ($stmt->execute()) 
		{
			return "ok";
		}else
		{
			return "error";
		}

		//empty the object
		$stmt -> null;

	}


	//Showing all Categories
	//add the word static before public to avoid issues with the php.ini on the hosting
	public static function mdlMostrarCategorias($tabla, $item, $value)
	{

		//$item and $value will be send empty, so we need to compare with thi if
		// if $item is different a null, we are going to send just one user
		if($item != null)
		{
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item"); //:item is a parameter
			$stmt->bindParam(":".$item, $value, PDO::PARAM_STR); //":".item is the colum, and will be compare with the variable $value, and the parameter will string
			$stmt->execute();

			return $stmt->fetch(); //fetch() will teturn just one ROW of our table, this fetch will be receive by the var_dump on usuarios.controller.php
		}else
		{
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla"); // if $item is null, we need to send all the users, thats why we dont have parameters
			$stmt->execute();

			return $stmt->fetchAll(); //fetchAll() will return all the ROWS of our table, this fetch will be receive by the var_dump on usuarios.php
		}


		$stmt -> null;
	}


	// Edit Category
	static public function mdlEditarCategoria($tabla, $datos)
	{

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET categoria = :categoria WHERE categoria_id = :categoria_id");

		$stmt -> bindParam(":categoria", $datos["categoria"], PDO::PARAM_STR);
		$stmt -> bindParam(":categoria_id", $datos["categoria_id"], PDO::PARAM_INT);

		if ($stmt->execute()) 
		{
			return "ok";
		}else
		{
			return "error";
		}

		//empty the object
		$stmt -> null;

	}


	//Delete User
	static public function mdlBorrarCategoria($tabla, $item, $valor)
	{

		$stmt = Conexion::conectar() -> prepare("DELETE FROM $tabla WHERE $item = :$item");

		$stmt -> bindParam(":".$item, $valor, PDO::PARAM_INT);


		if($stmt->execute())
        {
            return "ok";
        }else
        {
            return "error";
        }


        $stmt = null;


	}


}

