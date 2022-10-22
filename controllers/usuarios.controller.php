<?php

class ControllerUsuarios
{
	//User login method
	public function ctrLoginUsuario()
	{
		if(isset($_POST['ingUsuario'])) //the variable ingUsuario comes from login.php, form using POST method
		{
			if(preg_match('/^[a-ZA-Z0-9]+$/', $_POST['ingUsuario']) &&  //preg_match is used to limit characters typed by the user, SQL injection
				preg_match('/^[a-ZA-Z0-9]+$/', $_POST['ingPassword'])) //preg_match no special characters allowed
			{
				//here we (controller) are going to ASK to the model
				$table = 'usuarios'; // table user from the database, preparing to send to the usuarios table the following info

				//info
				$item = 'usuario'; // ask for the item (column) usuario on table usuarios the following value

				//value
				$value = $_POST['ingUsuario']; // ask for the value that comes from the variable $_POST['ingUsuario'], we are going to ask to the MODEL a reponse 

				//response
				$response = ModelUsuarios::MdlShowUsuarios($table, $item, $value); //we saved the response (from the model) in the variable, so we can decice if we use it or not

				//show the response in a var dump when it trigger
				var_dump($response);  // this variable will recive the fetch() from usuarios.model.php

			}
		}
	}

}