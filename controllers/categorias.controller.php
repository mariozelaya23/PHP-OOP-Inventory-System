<?php

//creating class
class ControladorCategorias
{

	// Creating Categories Method
	static public function ctrCrearCategoria()
	{

		//if it comes a POST variable nuevaCategoria, that means that we are going to create a category
		if(isset($_POST["nuevaCategoria"]))
		{
			//allowing just the following characters, including spanish characters
			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevaCategoria"]))
			{

				$tabla = "categorias";
				
				$datos = $_POST["nuevaCategoria"];

				$respuesta = ModelCategorias::mdlIngresarCategoria($tabla, $datos);

				if($respuesta == "ok")
				{

					echo "<script>

						Swal.fire({
						  icon: 'success',
						  title: 'La categoria a sido guardada correctamente!!',
						  showConfirmButton: true,
						  confirmButtonText: 'Cerrar',
						  closeOnConfirm: false
						}).then((result)=>{
							if(result.value)
							{
								window.location = 'categorias';
							}
						});
					
					</script>";

				}

			}else
			{

				echo "<script>

					Swal.fire({
					  icon: 'error',
					  title: 'La categoria no puede ir vacia o llevar caracteres especiales!!',
					  showConfirmButton: true,
					  confirmButtonText: 'Cerrar',
					  closeOnConfirm: false
					}).then((result)=>{
						if(result.value)
						{
							window.location = 'categorias';
						}
					});
					
				</script>";

			}
		}

	}


	//Showing all categories
	static public function ctrMostrarCategorias($item, $value)
	{

		$tabla = "categorias";

		//response
		$response = ModelCategorias::mdlMostrarCategorias($tabla, $item, $value); //we saved the response (from the model) in the variable, so we can decice if we use it or not, remeber that mdlMostrarCategorias requires 3 parameters

		//we are returning the $response to go back to the view
		return $response;

	}

}

