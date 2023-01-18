<!-- Content Wrapper. Contains page content -->  <!-- CONTENT -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Administrar Productos</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="dashboard">Home</a></li>
            <li class="breadcrumb-item active">Administrar Productos</li>
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
        <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarProducto">Agregar producto</button> <!-- Modal means to open a window -->
      </div>

      <div class="card-body">
        
        <table id="tablaProductos" class="table table-bordered table-striped tables"> <!-- tables is the class name, I use this name on tamplate.js to activate the DataTable plugin -->
          
          <thead>
            <tr>
              <th style="width: 10px;">#</th>
              <th>Imagen</th>
              <th>Codigo</th>
              <th>Descripcion</th>
              <th>Categoria</th>
              <th>Stock</th>
              <th>Precio de compra</th>
              <th>Fecha Agregado</th>
              <th>Acciones</th> 
            </tr>  
          </thead>

          <tbody>
            <tr>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td>
                <div class="btn-group">
                  <button class="btn btn-warning"><i class="fa fa-pen"></i></button>
                  <button class="btn btn-danger"><i class="fa fa-times"></i></button>
                </div>
              </td>
            </tr>
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


<!-- MODAL ADD PRODUCT -->
<div class="modal fade" id="modalAgregarProducto">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <!-- FORM -->
      <form role="form" method="post" enctype="multipart/form-data">
        <!-- MODAL HEADER -->
        <div class="modal-header" style="background: #3d9970; color: white;">
          <h4 class="modal-title">Agregar producto</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <!-- MODAL BODY -->
        <div class="modal-body">
          <div class="card-body">
            <!-- Textbox Codigo -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-code"></i></span>
                <input type="text" class="form-control input-lg" name="nuevoCodigo" placeholder="Ingresar Codigo" required>
              </div>      
            </div>
            <!-- Textbox Descripcion-->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fab fa-product-hunt"></i></span>
                <input type="text" class="form-control input-lg" name="nuevaDescripcion" placeholder="Ingresar Descripcion" required>
              </div>      
            </div>
            <!-- Select Categoria-->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-th"></i></span>
                <select class="form-control input-lg" name="nuevaCategoria">
                  <option value="">Seleccionar categorias</option>
                  <option value="Taladros">Taladros</option>
                  <option value="Andamios">Andamios</option>
                </select>
              </div>      
            </div>
            <!-- Textbox Stock-->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-check"></i></span>
                <input type="number" class="form-control input-lg" name="nuevoStock" min="0" placeholder="Stock" required>
              </div>      
            </div>
            <!-- Textbox Precio Compra-->
            <div class="form-group row">
              <div class="col-sm-6">
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-arrow-up"></i></span>
                  <input type="text" class="form-control input-lg" name="nuevoPrecioCompra" placeholder="Precio de compra" required>
                </div>   
              </div>   
              <!-- Textbox Precio Venta-->
              <div class="col-sm-6">
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-arrow-down"></i></span>
                  <input type="text" class="form-control input-lg" name="nuevoPrecioVenta" placeholder="Precio de Venta" required>
                </div>
                <br>
                <!-- Checkbox Porcentaje-->
                <div class="col-sm-6">
                  <div class="form-group">
                    <label>
                      <input type="checkbox" class="minimal porcentaje" checked >
                      Utilizar porcentaje
                    </label>
                  </div>
                </div>
                <!-- Textbox para Porcentaje-->
                <div class="col-xs-6" style="padding: 0;">
                  <div class="input-group">
                    <input type="number" class="form-control input-lg nuevoPorcentaje" min="0" value="40" required>
                    <span class="input-group-addon"><i class="fa fa-percent"></i></span>
                  </div>
                </div>
              </div>  
            </div>
            <!-- Upload picture -->
            <div class="form-group">
              <div class="panel">SUBIR IMAGEN</div>
              <input type="file" id="nuevaFoto" name="nuevaFoto">
              <p class="help-block">Peso maximo de la foto 5MB</p>
            </div>
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Salir</button>
          <button type="submit" class="btn btn-primary">Guardar producto</button>
        </div>
      </form> <!-- /FORM -->
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->


<script>
  $(function () {
    $("#tablaProductos").DataTable({
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