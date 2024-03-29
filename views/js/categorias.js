
//check if category exist
// console.log("estamos aca");

$(".nuevaCategoria").on('change',function(){

	//when the input change remove the warning alert 
	// $(".alert").remove();

	//capture the value of the categoria that is being typing
	var categoria = $(this).val();

	// console.log("categoria", categoria);

	// return; //detiene el codigo y verifica

	//we will ask ajax to bring some information if match in the database
	var datos = new FormData();
	datos.append("validarCategoria", categoria);

	$.ajax
	({

		url:"ajax/categorias.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function (respuesta) 
		{
			//console to see back is the answer from the database
			// console.log("respuesta", respuesta);
			// return;
			
			if (respuesta != false) 
			{
				//sending message letting know the user that the username is already taken
				$(".msg").remove();
				$(".nuevaCategoria").parent().after('<div class="alert alert-warning msg">Esta categoria ya existe en el sistema</div>');

				//cleaning the value
				$(".nuevaCategoria").val("");
			}else
			{
				$(".msg").remove();
			}
		}

	})

})


//Category Edit
$(".btnEditarCategoria").click(function(){

	var idCategoria =$(this).attr("idCategoria");

	var datos = new FormData();
	datos.append("idCategoria", idCategoria);

	// console.log("idCategoria", idCategoria);

	$.ajax({

		url:"ajax/categorias.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function (respuesta)
		{

			// console.log("respuesta",respuesta);

			//due to respuesta returns a json with the category data we use this to print the category column on the ID of the modal form (id="editarCategoria")
			$("#editarCategoria").val(respuesta["categoria"]);

			//adding this to know what row we are going to edit on the table
			$("#idCategoria").val(respuesta["categoria_id"]);

		} 		                               


	})

	
})


//Deleting the category
$(document).on("click", ".btnEliminarCategoria", function(){

	//storing the user id in the idCategoria variable
	var idCategoria = $(this).attr("idCategoria");

	// console.log('idCategoria', idCategoria);

	//showing an alert that if you continue the category will be deleted
	Swal.fire({

		icon: 'warning',
        title: '¿Está seguro de borrar la categoria?',
        text: "¡Si no lo está puede cancelar la accíón!",
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          cancelButtonText: 'Cancelar',
          confirmButtonText: 'Si, borrar categoria!'
	}).then((result) => {

		if(result.value)
		{

			//bring any info related to the category and find it on the database
			var datos = new FormData();
			datos.append("idCategoriaEliminar", idCategoria);

			//ajax
			$.ajax({

				url: "ajax/categorias.ajax.php",
                method: "POST",
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                success: function(respuesta)
                {
                	//testing what respuesta bring, if yes is clicked, it bring in a json format the category information
                	// console.log("respuesta", respuesta);
                	// return;

                	if(respuesta == "ok")
                	{

                		Swal.fire({
                            icon: 'success',
                            title: 'La categoria ha sido borrada correctamente',
                            showConfirmButton: true,
                            confirmButtonText: 'Cerrar',
                            closeOnConfirm: false
                        }).then((result)=>{
                            if(result.value)
                            {
                                window.location = 'categorias';
                            }
                        });   

                	}

                }

			})


		}

	})



})
