<?php

require_once "../controllers/categorias.controller.php";
require_once "../models/categorias.model.php";

class AjaxCategorias
{


	//Validate nuevaCategoria if exists
	//creating the public variable and the method
	//outside this class create the object
	public $validarCategoria;


	public function ajaxValidarCategoria()
	{
		
		$item = "categoria";
		$value = $this->validarCategoria;

		$respuesta = ControladorCategorias::ctrMostrarCategorias($item, $value);

		echo json_encode($respuesta);

	}



}


//creating the object "validarUsuario" if it comes a POST variable.
if(isset($_POST["validarCategoria"]))
{
	
	$valCategoria = new AjaxCategorias();
	$valCategoria -> validarCategoria = $_POST["validarCategoria"];  //here we match the variable that is above with the one that comes in the post
	$valCategoria -> ajaxValidarCategoria();

}