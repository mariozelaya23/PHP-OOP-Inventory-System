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

  <!-- jQuery -->
  <script src="views/plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="views/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="views/dist/js/adminlte.min.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="views/dist/js/demo.js"></script>


</head>

<body class="hold-transition sidebar-mini login-page"> <!-- TEMP --> <!-- I added login-page -->
<!-- Site wrapper -->
<!-- <div class="wrapper"> --> <!-- TEMP --> <!-- This wrapper was moved inside the php tag to validate session -->
  <?php

    if(isset($_SESSION['sessionStarted']) && $_SESSION['sessionStarted'] ==  'ok'){

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

    }else 
    {
      include "moduls/login.php";
    };

  ?>

<!-- </div> --> <!-- This wrapper was moved inside the php tag to validate session -->
<!-- ./wrapper --> 

</body> <!-- TEMP -->
</html>
