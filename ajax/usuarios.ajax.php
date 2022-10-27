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

}

//creating the object "Edit user"
// the method ajaxEditarUsuarios() must nor be executed until we recived $_POST['idUsuario']

if(isset($_POST['idUsuario'])){

	$edit = new AjaxUsers();
	$edit -> idUsuario = $_POST['idUsuario'];
	$edit -> ajaxEditarUsuarios();

}


