<!-- Content Wrapper. Contains page content -->  <!-- CONTENT -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Administrar Categorias</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="dashboard">Home</a></li>
            <li class="breadcrumb-item active">Administrar Categorias</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">

    <!-- Default box -->
    <div class="card">
      <div class="card-header">
        <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarCategoria">Agregar Categoria</button> <!-- Modal means to open a window -->
      </div>

      <div class="card-body">
        
        <table id="tablaUsuarios" class="table table-bordered table-striped tables"> <!-- tables is the class name, I use this name on tamplate.js to activate the DataTable plugin -->
          
          <thead>
            <tr>
              <th style="width: 10px;">#</th>
              <th>Categoria</th>
              <th>Acciones</th>
            </tr>  
          </thead>

          <tbody>

            <!-- Showing Categories -->
            <?php

              //sending this values null due to I want to bring all the data
              $item = null;
              $valor = null;
              
              $categorias = ControladorCategorias::ctrMostrarCategorias($item, $valor);

              //this brings an array of the categories table
              // var_dump($categorias);

              //using FOR EACH to show the array
              foreach ($categorias as $key => $value) {
                
                //I'm using KEY here, this is the rows count from the array NOT from the database, incrementing by one to show from 1 instead from 0
                echo '
                <tr>
                  <td>'.($key+1).'</td>
                  <td>'.$value["categoria"].'</td>
                  <td>
                    <div class="btn-group">
                      <button class="btn btn-warning btnEditarCategoria" idCategoria="'.$value["categoria_id"].'" data-toggle="modal" data-target="#modalEditarCategoria"><i class="fa fa-pen"></i></button>
                      <button class="btn btn-danger btnEliminarCategoria" idCategoria="'.$value["categoria_id"].'"><i class="fa fa-times"></i></button>
                    </div>
                  </td>
                </tr>
                ';

              }

            ?>

          </tbody>
        
        </table>

      </div>
      <!-- /.card-body -->

    </div>
    <!-- /.card -->

  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->


<!-- MODAL ADD CATEGORY -->
<div class="modal fade" id="modalAgregarCategoria">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <!-- FORM -->
      <form role="form" method="post" >
        <!-- MODAL HEADER -->
        <div class="modal-header" style="background: #3d9970; color: white;">
          <h4 class="modal-title">Agregar Categoria</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <!-- MODAL BODY -->
        <div class="modal-body">
          <div class="card-body">
            <!-- Textbox Name -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-th"></i></span>
                <input type="text" class="form-control input-lg nuevaCategoria" name="nuevaCategoria" placeholder="Ingresar Categoria" required>
              </div>      
            </div>
            
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Salir</button>
          <button type="submit" class="btn btn-primary">Guardar categoria</button>
        </div>

        <!-- capturing nuevaCategoria in a POST variable to send this to the controller -->

        <?php 

          //creating object that will execute the controller
          $crearCategoria = new ControladorCategorias();
          $crearCategoria -> ctrCrearCategoria();

        ?>

      </form> <!-- /FORM -->
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->


<!-- MODAL EDIT CATEGORY -->
<div class="modal fade" id="modalEditarCategoria">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <!-- FORM -->
      <form role="form" method="post" >
        <!-- MODAL HEADER -->
        <div class="modal-header" style="background: #3d9970; color: white;">
          <h4 class="modal-title">Editar Categoria</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <!-- MODAL BODY -->
        <div class="modal-body">
          <div class="card-body">
            <!-- Textbox Name -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-th"></i></span>
                <input type="text" class="form-control input-lg editarCategoria" name="editarCategoria" id="editarCategoria" required>
                <input type="hidden" name="idCategoria" id="idCategoria" required>
              </div>      
            </div>
            
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Salir</button>
          <button type="submit" class="btn btn-primary">Guardar cambios</button>
        </div>

        <!-- capturing editarCategoria in a POST variable, now, if we want to make a change, the function below will send this to the controller -->

        <?php 

          //creating object that will execute the controller
          $editarCategoria = new ControladorCategorias();
          $editarCategoria -> ctrEditarCategoria();

        ?>

      </form> <!-- /FORM -->
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->



<script>
  $(function () {
    $("#tablaUsuarios").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
    }).buttons().container().appendTo('#tablaUsuarios_wrapper .col-md-6:eq(0)');
    // $('#example2').DataTable({
    //   "paging": false,
    //   "lengthChange": false,
    //   "searching": false,
    //   "ordering": true,
    //   "info": true,
    //   "autoWidth": false,
    //   "responsive": true,
    // });
  });
</script>