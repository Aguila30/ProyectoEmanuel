<?php
    require_once './app/config/Connect.php';  
    $connect = new Connect();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>MTVAwards| Inicio Sesión</title>
  <!-- Icon -->
  <link rel="icon" href="./recursos/img/system/mtv-logo.jpg" type="image/x-icon">


  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="./recursos/recursos_panel/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="./recursos/recursos_panel/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="./recursos/recursos_panel/css/adminlte.min.css">
</head>
<body class="hold-transition login-page" style= "background-color: black">

  <?php
    if(isset($_GET['error']) && isset($_GET["type"])){
      echo '
        <div class="alert alert-'.$_GET["type"].'" role="alert">
          '.$_GET['error'].'
        </div>
      ';
    }//end if 
  ?>


<div class="login-box">
  <!-- /.login-logo -->
  <div class="card card-outline card-dark">
    <div class="card-header text-center">
      <a href="../../index2.html" class="h1" style= "color: black" ><b style= "color: yellow">MTV </b>Awards</a>
    </div>

    <div class="card-body">
      <p class="login-box-msg">Ingresa tus credenciales</p>

      <form action="./app/backend/panel/validate_user.php" method="post" class="" id="">
        <div class="input-group mb-3">
          <input type="email" class="form-control" placeholder="Email" name="email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Password" name="password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <!-- /.col -->
          <div class="col-12">
            <button type="submit" class="btn btn-dark btn-block">Ingresar</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="./recursos/recursos_panel/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="./recursos/recursos_panel/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="./recursos/recursos_panel/js/adminlte.min.js"></script>
</body>
</html>
