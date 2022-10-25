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