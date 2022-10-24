<?php

class ControllerUsuarios
{
	//User login method
	public static function ctrLoginUsuario()
	{
		if(isset($_POST['ingUsuario'])) //the variable ingUsuario comes from login.php, form using POST method
		{
			if(preg_match('/^[a-zA-Z0-9-]+$/', $_POST['ingUsuario']) &&  //preg_match is used to limit characters typed by the user, SQL injection
				preg_match('/^[a-zA-Z0-9-]+$/', $_POST['ingPassword'])) //preg_match no special characters allowed
			{
				//here we (controller) are going to ASK to the model
				$table = 'usuarios'; // table user from the database, preparing to send to the usuarios table the following info

				//info
				$item = 'usuario'; // ask for the item (column) usuario on table usuarios the following value

				//value
				$value = $_POST['ingUsuario']; // ask for the value that comes from the variable $_POST['ingUsuario'], we are going to ask to the MODEL a reponse 

				//response
				$response = ModelUsuarios::MdlShowUsuarios($table, $item, $value); //we saved the response (from the model) in the variable, so we can decice if we use it or not
				if(is_array($response))  //becasue response is an array I put this if
				{
					if($response['usuario'] == $_POST['ingUsuario'] && $response['password'] == $_POST['ingPassword'])
					{
						$_SESSION['sessionStarted'] = 'ok'; //the variable sessionStarted comes from template.php, remember to add session_start() on template.php because we are using sessions
						// if user and password match (session = ok), redirect to the dashboard
						echo "<script>
							window.location = 'dashboard';
						</script>";

					}else
					{
						echo '<br><div class="alert alert-danger">Error al ingresar, vuelve a intentarlo</div>';
					}
				}

				//show the response in a var dump when it trigger
				// var_dump($response['usuario']);  // this variable will recive the fetch() from usuarios.model.php, this has to bring an array with the row info

			}
		}
	}

	//create or add user method
	public static function ctrCrearUsuario()
	{
		if(isset($_POST["nuevoUsuario"]))
		{
			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevoNombre"]) &&
				preg_match('/^[a-zA-Z0-9-]+$/', $_POST["nuevoUsuario"]) &&
				preg_match('/^[a-zA-Z0-9-]+$/', $_POST["nuevoPassword"]))
			{

			}else
			{
				echo '<script>
				swal({
					type: "error",
					title: "El usuario no puede ir vacio o llevar caracteres especiales!!",
					showConfirmButton: true,
					confirmButtonText: "Cerrar",
					closeOnConfirm: false
					}).then((result)=>{
						if(result.value)
						{
							window.location = "usuarios";
						}
					});
				</script>';
			}

		}
	}

}