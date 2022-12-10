<?php
  session_start();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistema de Inventario</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="views/plugins/fontawesome-free/css/all.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="views/dist/css/adminlte.css">
      <!-- DataTables -->
    <link rel="stylesheet" href="views/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="views/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="views/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

    <!-- jQuery -->
    <script src="views/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="views/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="views/dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="views/dist/js/demo.js"></script>
    <!-- DataTables  & Plugins -->
    <script src="views/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="views/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="views/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="views/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="views/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="views/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="views/plugins/jszip/jszip.min.js"></script>
    <script src="views/plugins/pdfmake/pdfmake.min.js"></script>
    <script src="views/plugins/pdfmake/vfs_fonts.js"></script>
    <script src="views/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="views/plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="views/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    <!-- SweetAlert 2 -->
    <script src="views/plugins/sweetalert2/sweetalert2.all.js"></script>

  </head>

  <!-- <div class="wrapper"> --> <!-- TEMP --> <!-- This wrapper was moved inside the php tag to validate session -->
    <?php

      if(isset($_SESSION['sessionStarted']) && $_SESSION['sessionStarted'] ==  'ok'){

        echo '<body class="hold-transition sidebar-mini layout-fix">';

          echo '<div class="wrapper">';

            //header section
            include "moduls/header.php";

            //menu section
            include "moduls/menu.php";

            //content section - the "route" variable comes from .htaccess file, code section "index.php?route=$1"
            //friendly link route from the menu sidebar nav-item, dont need to write php extension
            if(isset($_GET['route']))
            {
              if($_GET['route'] == 'dashboard' ||
                 $_GET['route'] == 'usuarios' ||
                 $_GET['route'] == 'categorias' ||
                 $_GET['route'] == 'productos' ||
                 $_GET['route'] == 'clientes' ||
                 $_GET['route'] == 'ventas' ||
                 $_GET['route'] == 'crear-venta' ||
                 $_GET['route'] == 'reportes' ||
                 $_GET['route'] == 'salir')
              {
                include 'moduls/'.$_GET['route'].'.php';
              }else
              {
                include 'moduls/404.php'; //this will redirect the user to an error page if you type a page that is no included on moduls
              }
            }else
            {
              include 'moduls/dashboard.php';  //here you will be redirect to the dashboard if you type http://localhost/inventario/
            };

            //footer section
            include "moduls/footer.php";

          echo '</div>';

        echo '</body>';

      }else 
      {
        //I added another body tag, in this body I added the login-page class,the CSS properties of this class is different compared with the wrapper which is the dashboard
        echo '<body class="hold-transition sidebar-mini layout-fix login-page">';

          include "moduls/login.php";

        echo '</body>';  
      };

    ?>

  <script src="views/js/usuarios.js"></script>
  <script src="views/js/categorias.js"></script>

</html>
