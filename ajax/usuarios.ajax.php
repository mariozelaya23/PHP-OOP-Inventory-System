<?php

require_once "../controllers/usuarios.controller.php";
require_once "../models/usuarios.model.php";

class AjaxUsers{

	//Edit user
	// this $idUsuario is sent by javascript
	public $idUsuario;

	//getting value from the $idUsuario property which now belogs to the AjaxUsers class 
	public function ajaxEditarUsuarios(){

		//ask the model to show the users
		//remmeber that public static function ctrShowUsers($item, $value) from the controller ask for 2 parameters
		//item will be column of the data base wich is usuario_id, this will be evaluated
		$item = "usuario_id";

		//and the value will be the data that contains the property idUsuario
		//idUsuario was linked in the object below, now contains the value of $_POST['idUsuario'] which comes from javascript
		$value = $this->idUsuario;

		$respuesta = ControllerUsuarios::ctrShowUsers($item, $value);

		// return an echo encoded in json
		echo json_encode($respuesta);
	}

	//ACTIVATE USER
	// this variables comes from usuarios.js
	public $activarId;
	public $activarUsuario;

	public function ajaxActivarUsuario()
	{

		$table = "usuarios";

		// we need to update the user state
		$item1 = "estado";

		// which values (could be 0 or 1), if estado was on 1 it will be change to 0 and viceversa
		$valor1 = $this->activarUsuario;

		// this needs to match with a value of the database, in this case we will send the user id
		$item2	= "usuario_id";

		// that comes from
		$valor2 = $this->activarId;

		//this time we will ask a response DIRECTLY to the model, jumping the CONTROLER
		$respuesta = ModelUsuarios::mdlActualizarUsuario($table, $item1, $valor1, $item2, $valor2); 

	}

}

//creating the object "Edit user"
// the method ajaxEditarUsuarios() must nor be executed until we recived $_POST['idUsuario']

if(isset($_POST['idUsuario'])){

	$edit = new AjaxUsers();
	$edit -> idUsuario = $_POST['idUsuario'];
	$edit -> ajaxEditarUsuarios();

}


//creating the object "activate user"

if(isset($_POST['activarUsuario'])){

	$edit = new AjaxUsers();
	$edit -> activarId = $_POST['activarId'];
	$edit -> activarUsuario = $_POST['activarUsuario'];
	$edit -> ajaxActivarUsuario();

}
