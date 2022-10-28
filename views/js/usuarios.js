/*
uploading user foto
*/

$(".nuevaFoto").change(function(){
	var image = this.files[0];  //files is a javascript property, this ONLY works on the inputs "file" types, the property 
	//files return on it index 0 some properties of th file
	// console.log("image", image);

	//image ext validation, type comes from the files property
	if(image["type"] != "image/jpeg" && image["type"] != "image/jpg" && image["type"] != "image/png")
	{
		$(".nuevaFoto").val("");  //clear the input, anything that is uploaded it will be clear it

		Swal.fire({
		  icon: 'error',
		  title: 'Error al subir la imagen!!',
		  text: 'La imagen debe estar en formato JPEG, JPG o PNG!!',
		  showConfirmButton: true,
		  confirmButtonText: 'Cerrar'
		});
	}else if (image["size"] > 5000000) 
	{
		$(".nuevaFoto").val("");  //clear the input, anything that is uploaded it will be clear it

		Swal.fire({
		  icon: 'error',
		  title: 'Error al subir la imagen!!',
		  text: 'La imagen no debe pesar mas de 5 MB!!',
		  showConfirmButton: true,
		  confirmButtonText: 'Cerrar'
		});
	}else
	{
		// if all the filter pass, FileReader is a javascript class to read a file
		var imageData = new FileReader;

		//read the image as a URL
		imageData.readAsDataURL(image);

		// "on" comes from JQuery, when load, we apply a funcion with "event" parameter this means that is loaded
		$(imageData).on("load", function(event) {
			
			//save image route on the variable
			var imageRoute = event.target.result;

			//the class "preview" comes from usuarios.php, where you upload the picture, class="img-thumbnail preview", 
			//on the attribute src you can link the imageRoute variable
			$(".preview").attr("src", imageRoute);
		})
	}
})


/*
Edit User
*/

$(".btnEditarUsuario").click(function(){

	//we are getting in a variable what brings in the attribute of this button btnEditarUsuario, with class idUsuario, 
	//idUsuario comes from the modalEditarUsuario window and this class has the user id from the database
	var idUsuario = $(this).attr("idUsuario");

	//trying this the console (attr, variable)
	// console.log("idUsuario", idUsuario);

	//now that we are storing the user id that comes from the database we can use AJAX
	//FormData() - class from javascript
	//post variable idUsuario, idUsuario which is the variable that is above
	var datos = new FormData();
	datos.append("idUsuario", idUsuario);

	$.ajax({

		url:"ajax/usuarios.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function(respuesta){

			// console.log("respuesta", respuesta);
			$("#editarNombre").val(respuesta["nombre"]);
			$("#editarUsuario").val(respuesta["usuario"]);
			// due to editarPerfil is a select we use html instead of val
			$("#editarPerfil").html(respuesta["perfil"]);
			//due to sql UPDATE will update all the columns, in case the user does not change the role
			$("#editarPerfil").val(respuesta["perfil"]);

			//due to sql UPDATE will update all the columns, in case the user does not change the password, we need to send it hidden 
			$("#currentPass").val(respuesta["password"]);

			//due to sql UPDATE will update all the columns, in case the user does not change the picture
			$("#fotoActual").val(respuesta["foto"]);

			//showing the user picture
			if(respuesta["foto"] != "")
			{
				$(".preview").attr("src", respuesta["foto"]);
			}

		}

	});


})





