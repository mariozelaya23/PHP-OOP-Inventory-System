<!-- Content Wrapper. Contains page content -->  <!-- CONTENT -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Administrar Usuarios</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="dashboard">Home</a></li>
            <li class="breadcrumb-item active">Administrar Usuarios</li>
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
        <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarUsuario">Agregar usuario</button> <!-- Modal means to open a window -->
      </div>

      <div class="card-body">
        
        <table id="tablaUsuarios" class="table table-bordered table-striped tables">
          
          <thead>
            <tr>
              <th style="width: 10px;">#</th>
              <th>Nombre</th>
              <th>Usuario</th>
              <th>Foto</th>
              <th>Perfil</th>
              <th>Estado</th>
              <th>Ultimo Login</th>
              <th>Acciones</th>
            </tr>  
          </thead>

          <tbody>

            <?php

              // we are re-using MdlShowUsuarios method from the model which fetch just one user, but we need all the user, so we are sending $item and $value as null, because we dont need just one user, later if we need to fetch one user we can use those variables
              $item =  null;
              $value = null;
              $users = ControllerUsuarios::ctrShowUsers($item, $value);

              // var_dump($users); //returns an array

              // due to $users return an array, we can use a foreach
              foreach ($users as $key => $value) {
                // var_dump($value["usuario_id"]);  //as a test showing in an array all the users id's

                //showing all the users on the users table
                echo '
                  <tr>
                    <td>'.($key+1).'</td>
                    <td>'.$value["nombre"].'</td>
                    <td>'.$value["usuario"].'</td>';

                    // if the user does not have an image, I apply the following condition
                    if ($value["usuario"] != "")
                    {
                      
                      echo '<td><img src="'.$value["foto"].'" class="img-thumbnail" width="40px"></td>';

                    }else
                    {
                      echo '<td><img src="views/img/users/default/user.png" class="img-thumbnail" width="40px"></td>';
                    }
                    
                    //with editarUsuario we are going to use AJAX - AJAX will helps us to connect to database through javascript, so this means that we will use the the file usuario.js, we are going to use the class btnEditarUsuario 
                    echo'
                    <td>'.$value["perfil"].'</td>';

                    if($value["estado"] != 0)
                    {
                      echo '<td><button class="btn btn-success btn-xs btnActivar" idUsuario="'.$value["usuario_id"].'" estadoUsuario="0">Activado</button></td>';
                    }else
                    {
                      echo '<td><button class="btn btn-danger btn-xs btnActivar" idUsuario="'.$value["usuario_id"].'" estadoUsuario="1">Desactivado</button></td>';
                    }
                    
                    echo '<td>'.$value["ultimo_login"].'</td>
                    <td>
                      <div class="btn-group">
                        <button class="btn btn-warning btnEditarUsuario" idUsuario="'.$value["usuario_id"].'" data-toggle="modal" data-target="#modalEditarUsuario"><i class="fa fa-pen"></i></button>
                        <button class="btn btn-danger btnEliminarUsuario" idUsuario="'.$value["usuario_id"].'" fotoUsuario="'.$value["foto"].'" usuario="'.$value["usuario"].'"><i class="fa fa-times"></i></button>
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


<!-- MODAL ADD USER -->
<div class="modal fade" id="modalAgregarUsuario">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <!-- FORM -->
      <form method="post" enctype="multipart/form-data">
        <!-- MODAL HEADER -->
        <div class="modal-header" style="background: #3d9970; color: white;">
          <h4 class="modal-title">Agregar usuario</h4>
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
                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                <input type="text" class="form-control input-lg" name="nuevoNombre" placeholder="Ingresar Nombre" id="nuevoNombre" required>
              </div>      
            </div>
            <!-- Textbox User-->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-key"></i></span>
                <input type="text" class="form-control input-lg" name="nuevoUsuario" placeholder="Ingresar Usuario" id="nuevoUsuario" required>
              </div>      
            </div>
            <!-- Textbox Password-->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                <input type="password" class="form-control input-lg" name="nuevoPassword" placeholder="Ingresar Contrasena" required>
              </div>      
            </div>
            <!-- Textbox Role-->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-users"></i></span>
                <select class="form-control input-lg" name="nuevoPerfil" required>
                  <option value="">Seleccionar perfil</option>
                  <option value="Administrador">Administrador</option>
                  <option value="Especial">Especial</option>
                  <option value="Vendedor">Vendedor</option>
                </select>
              </div>      
            </div>
            <!-- Upload picture -->
            <div class="form-group">
              <div class="panel">SUBIR FOTO</div>
              <input type="file" class="nuevaFoto" name="nuevaFoto">
              <p class="help-block">Peso maximo de la foto 5MB</p>
              <img src="views/img/users/default/user.png" class="img-thumbnail preview" width="100px">
            </div>
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Salir</button>
          <button type="submit" class="btn btn-primary">Guardar usuario</button>
        </div>

        <?php
          $crearUsuario = new ControllerUsuarios();
          $crearUsuario -> ctrCrearUsuario();
        ?>

      </form> <!-- /FORM -->
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- MODAL EDIT USER -->
<div class="modal fade" id="modalEditarUsuario">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <!-- FORM -->
      <form method="post" enctype="multipart/form-data">
        <!-- MODAL HEADER -->
        <div class="modal-header" style="background: #3d9970; color: white;">
          <h4 class="modal-title">Editar usuario</h4>
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
                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                <input type="text" class="form-control input-lg" id="editarNombre" name="editarNombre" value="" required>
              </div>      
            </div>
            <!-- Textbox User-->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-key"></i></span>
                <input type="text" class="form-control input-lg" id="editarUsuario" name="editarUsuario" value="" readonly>
              </div>      
            </div>
            <!-- Textbox Password-->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                <input type="password" class="form-control input-lg" name="editarPassword" placeholder="Escriba la nueva contrasena">
                <input type="hidden" id="currentPass" name="currentPass">
              </div>      
            </div>
            <!-- Textbox Role-->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-users"></i></span>
                <select class="form-control input-lg" name="editarPerfil" required>
                  <option value="" id="editarPerfil"></option>
                  <option value="Administrador">Administrador</option>
                  <option value="Especial">Especial</option>
                  <option value="Vendedor">Vendedor</option>
                </select>
              </div>      
            </div>
            <!-- Upload picture -->
            <div class="form-group">
              <div class="panel">SUBIR FOTO</div>
              <input type="file" class="nuevaFoto" name="editarFoto">
              <p class="help-block">Peso maximo de la foto 5MB</p>
              <img src="views/img/users/default/user.png" class="img-thumbnail preview" width="100px">
              <input type="hidden" name="fotoActual" id="fotoActual">
            </div>
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Salir</button>
          <button type="submit" class="btn btn-primary">Modificar cambios</button>
        </div>

        <?php
          $editarUsuario = new ControllerUsuarios();
          $editarUsuario -> ctrEditarUsuario();
        ?>

      </form> <!-- /FORM -->
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- EJECUTING CONTROLLER BorrarUsuario -->
<?php
  $borrarUsuario = new ControllerUsuarios();
  $borrarUsuario -> ctrBorrarUsuario();
?>




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