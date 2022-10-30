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
				//encrypting the password
				//2 parameters, the str and the hash (pass encapsulation) type
				$encrypPass = crypt($_POST['ingPassword'], '$2a$07$usesomesillystringforsalt$');

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
					if($response['usuario'] == $_POST['ingUsuario'] && $response['password'] == $encrypPass)
					{
						//this condition is added later, we will validate the user state (active or not active)
						if ($response['estado'] == 1) 
						{
							
							$_SESSION['sessionStarted'] = 'ok'; //the variable sessionStarted comes from template.php, remember to add session_start() on template.php because we are using sessions
							// if user and password match (session = ok), redirect to the dashboard

							//SESSION VARIABLES (this session variables can be use to display information of the user, for example on the menu.php, using
							// $_SESSION['nombre'] and $_SESSION['foto'] we echo the name and foto of the user who start the session (login))
							$_SESSION['usuario_id'] = $response['usuario_id'];
							$_SESSION['nombre'] = $response['nombre'];
							$_SESSION['usuario'] = $response['usuario'];
							$_SESSION['password'] = $response['password'];
							$_SESSION['perfil'] = $response['perfil'];
							$_SESSION['foto'] = $response['foto'];

							echo "<script>
								window.location = 'dashboard';
							</script>";

						}else
						{
							echo '<br><div class="alert alert-danger">El usuario no esta activado</div>';
						}


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
			// this preg_match let the user insert spanish characters
			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevoNombre"]) &&
				preg_match('/^[a-zA-Z0-9-]+$/', $_POST["nuevoUsuario"]) &&
				preg_match('/^[a-zA-Z0-9-]+$/', $_POST["nuevoPassword"]))
			{

				$route = ""; //initializing route is empty

				//validate image, remember that image is send by $_FILE not $_POST
				//"nuevaFoto" is the name of the input "SUBIR FOTO" 
				//"tmp_name" is the temporary file that is store on the browser when you upload a file, C:\xampp\tmp\filename
				if(isset($_FILES['nuevaFoto']["tmp_name"]))
				{
					// getimagesize get a list of information with the image size uploaded
					// saving getimagesize on a list with 2 parameters, on $width will save the index 0 which is width of the image and on index 1
					// will save the hight of the image
					list($width, $hight) = getimagesize($_FILES['nuevaFoto']["tmp_name"]);

					// var_dump($_FILES['nuevaFoto']["tmp_name"]); with this you can check the tmp_name route
					// var_dump(getimagesize($_FILES['nuevaFoto']["tmp_name"]); with this you can see the list of getimagesize info

					//resize image
					$newWidth = 200;
					$newhight = 200;

					// Creating folder where the user image will be store, it will create a folder with the name that comes with nuevoUsuario
					$folder = "views/img/users/".$_POST["nuevoUsuario"];

					//javascript code to create folder, first param "folder name", and second param the permissions (write and read)
					mkdir($folder, 0755);

					// Base of image type, we are going to apply the following default PHP functions
					if ($_FILES["nuevaFoto"]["type"] == "image/jpeg") 
					{
						//save image on the folder with the following name, including a ramdom number between 100 and 999
						$random = mt_rand(100,999);
						$route = "views/img/users/".$_POST["nuevoUsuario"]."/".$random.".jpeg";

						// image trim to 200x200 
						$source = imagecreatefromjpeg($_FILES['nuevaFoto']["tmp_name"]);
						$destination = imagecreatetruecolor($newWidth, $newhight);
						imagecopyresized($destination, $source, 0, 0, 0, 0, $newWidth, $newhight, $width, $hight);
						imagejpeg($destination, $route);  //saving the file

					}

					// Base of image type, we are going to apply the following default PHP functions
					if ($_FILES["nuevaFoto"]["type"] == "image/png") 
					{
						//save image on the folder with the following name, including a ramdom number between 100 and 999
						$random = mt_rand(100,999);
						$route = "views/img/users/".$_POST["nuevoUsuario"]."/".$random.".png";

						// image trim to 200x200 
						$source = imagecreatefrompng($_FILES['nuevaFoto']["tmp_name"]);
						$destination = imagecreatetruecolor($newWidth, $newhight);
						imagecopyresized($destination, $source, 0, 0, 0, 0, $newWidth, $newhight, $width, $hight);
						imagepng($destination, $route);  //saving the file

					}

				}

				$table = "usuarios";

				//encrypting the passwords that we send to the model using the php function crypt, this funcion will use
				// 2 parameters, the str and the hash (pass encapsulation) type
				$encrypPass = crypt($_POST["nuevoPassword"], '$2a$07$usesomesillystringforsalt$');

				// db column => input type "name"
				$data = array("nombre" => $_POST["nuevoNombre"],
							   "usuario" => $_POST["nuevoUsuario"],
							   "password" => $encrypPass,
							   "perfil" => $_POST["nuevoPerfil"],
							   "foto" => $route);

				//ask for response from the model, and we send to parameters
				$response = ModelUsuarios::mdlAddUser($table, $data);

				//if the model response ok, we send a sweetalert to the user confirming the the user was saved
				if($response == "ok")
				{
					echo "<script>

						Swal.fire({
						  icon: 'success',
						  title: 'El usuario a sido guardado correctamente!!',
						  showConfirmButton: true,
						  confirmButtonText: 'Cerrar',
						  closeOnConfirm: false
						}).then((result)=>{
							if(result.value)
							{
								window.location = 'usuarios';
							}
						});
						
					</script>";
				}

			}else
			{
				echo "<script>

					Swal.fire({
					  icon: 'error',
					  title: 'El usuario no puede ir vacio o llevar caracteres especiales!!',
					  showConfirmButton: true,
					  confirmButtonText: 'Cerrar',
					  closeOnConfirm: false
					}).then((result)=>{
						if(result.value)
						{
							window.location = 'usuarios';
						}
					});
					
				</script>";
			}

		}
	}

	// show users method - this function will connect to the MdlShowUsuarios() on usuarios.model.php, this is already created.
	public static function ctrShowUsers($item, $value)
	{

		$table = "usuarios";

		//response
		$response = ModelUsuarios::MdlShowUsuarios($table, $item, $value); //we saved the response (from the model) in the variable, so we can decice if we use it or not, remeber that MdlShowUsuarios requires 3 parameters

		//we are returning the $response to go back to the view
		return $response;
	}

	// edit user method
	public static function ctrEditarUsuario()
	{
		// if it comes a POST with information
		if(isset($_POST["editarUsuario"]))
		{

			// this preg_match to verify the information
			// note this, if editarPassword wont be modified, that means that I will let the id="currentPass" as a password, so, the name="editarPassword" will come empty, that will generate conflics with this preg_match('/^[a-zA-Z0-9-]+$/', $_POST["editarPassword"], so we will remove that preg_match, because the only role that is authorize to change pass is the admin
			// now, regarding editing the user nickname preg_match('/^[a-zA-Z0-9-]+$/', $_POST["editarUsuario"]) that will be disable to avoid conflic with users folders images which were created with the original nickname, so that preg_match will be removed
			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarNombre"]))
			{
				//validate image
				//if it comes the current picture (picture wont change), the variable $route will take $_POST["fotoActual"]
				$route = $_POST["fotoActual"];

				//if picture will change
				//validate image, remember that image is send by $_FILE not $_POST
				//"nuevaFoto" is the name of the input "SUBIR FOTO" 
				//"tmp_name" is the temporary file that is store on the browser when you upload a file, C:\xampp\tmp\filename
				if(isset($_FILES['editarFoto']["tmp_name"]) && !empty($_FILES["editarFoto"]["tmp_name"]))
				{
					// getimagesize get a list of information with the image size uploaded
					// saving getimagesize on a list with 2 parameters, on $width will save the index 0 which is width of the image and on index 1
					// will save the hight of the image
					list($width, $hight) = getimagesize($_FILES['editarFoto']["tmp_name"]);

					// var_dump($_FILES['nuevaFoto']["tmp_name"]); with this you can check the tmp_name route
					// var_dump(getimagesize($_FILES['nuevaFoto']["tmp_name"]); with this you can see the list of getimagesize info

					//resize image
					$newWidth = 200;
					$newhight = 200;

					// Creating folder where the user image will be store, it will create a folder with the name that comes with nuevoUsuario
					$folder = "views/img/users/".$_POST["editarUsuario"];

					// if we are going to change the picture, we will ask first if exist another picture in the DB
					if(!empty($_POST["fotoActual"]))
					{
						unlink($_POST["fotoActual"]); //this will delete the picture
					}else
					{
						//javascript code to create folder, first param "folder name", and second param the permissions (write and read)
						mkdir($folder, 0755);
					}

					// Base of image type, we are going to apply the following default PHP functions
					if ($_FILES["editarFoto"]["type"] == "image/jpeg") 
					{
						//save image on the folder with the following name, including a ramdom number between 100 and 999
						$random = mt_rand(100,999);
						$route = "views/img/users/".$_POST["editarUsuario"]."/".$random.".jpeg";

						// image trim to 200x200 
						$source = imagecreatefromjpeg($_FILES['editarFoto']["tmp_name"]);
						$destination = imagecreatetruecolor($newWidth, $newhight);
						imagecopyresized($destination, $source, 0, 0, 0, 0, $newWidth, $newhight, $width, $hight);
						imagejpeg($destination, $route);  //saving the file

					}

					// Base of image type, we are going to apply the following default PHP functions
					if ($_FILES["editarFoto"]["type"] == "image/png") 
					{
						//save image on the folder with the following name, including a ramdom number between 100 and 999
						$random = mt_rand(100,999);
						$route = "views/img/users/".$_POST["editarUsuario"]."/".$random.".png";

						// image trim to 200x200 
						$source = imagecreatefrompng($_FILES['editarFoto']["tmp_name"]);
						$destination = imagecreatetruecolor($newWidth, $newhight);
						imagecopyresized($destination, $source, 0, 0, 0, 0, $newWidth, $newhight, $width, $hight);
						imagepng($destination, $route);  //saving the file

					}

				}

				$table = "usuarios";

				if($_POST["editarPassword"] != "")
				{
					if(preg_match('/^[a-zA-Z0-9-]+$/', $_POST["editarPassword"]))
					{
						//encrypting the passwords that we send to the model using the php function crypt, this funcion will use
						// 2 parameters, the str and the hash (pass encapsulation) type
						$encrypPass = crypt($_POST["editarPassword"], '$2a$07$usesomesillystringforsalt$');
					}else
					{
						echo "
						<script>

							Swal.fire({
							  icon: 'error',
							  title: 'La contrasena no puede ir vacio o llevar caracteres especiales',
							  showConfirmButton: true,
							  confirmButtonText: 'Cerrar',
							  closeOnConfirm: false
							}).then((result)=>{
								if(result.value)
								{
									window.location = 'usuarios';
								}
							});
							
						</script>";
					}

				}else
				{
					$encrypPass = $_POST["currentPass"];
				}

				//sending data to the model
				// db column => input type "name"
				$data = array("nombre" => $_POST["editarNombre"],
							   "usuario" => $_POST["editarUsuario"],
							   "password" => $encrypPass,
							   "perfil" => $_POST["editarPerfil"],
							   "foto" => $route);

				//response
				$response = ModelUsuarios::mdlEditUser($table, $data); //we saved the response (from the model) in the variable, so we can decice if we use it or not, remeber that MdlShowUsuarios requires 3 parameters

				if($response == "ok")
				{
					echo "
					<script>

						Swal.fire({
						  icon: 'success',
						  title: 'El usuario a sido editado correctamente',
						  showConfirmButton: true,
						  confirmButtonText: 'Cerrar',
						  closeOnConfirm: false
						}).then((result)=>{
							if(result.value)
							{
								window.location = 'usuarios';
							}
						});
						
					</script>";
				}

			}else
			{
				echo "<script>

					Swal.fire({
					  icon: 'error',
					  title: 'El nombre no puede ir vacio o llevar caracteres especiales!!',
					  showConfirmButton: true,
					  confirmButtonText: 'Cerrar',
					  closeOnConfirm: false
					}).then((result)=>{
						if(result.value)
						{
							window.location = 'usuarios';
						}
					});
					
				</script>";
			}

		}
	}

}