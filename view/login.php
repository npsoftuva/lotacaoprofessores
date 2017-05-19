<?php
  require_once('../controller/UsuarioController.php');
  session_start();

  if (isset($_SESSION['usuarioCod'])) header('Location: index.php');
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <link rel="icon" type="image/png" href="assets/img/favicon.ico">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

    <title>LotaProf</title>

    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />

    <!-- Bootstrap core CSS     -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Animation library for notifications   -->
    <link href="assets/css/animate.min.css" rel="stylesheet"/>

    <!--  Light Bootstrap Table core CSS    -->
    <link href="assets/css/light-bootstrap-dashboard.css" rel="stylesheet"/>

    <!--  CSS for Demo Purpose, don't include it in your project     -->
    <link href="assets/css/demo.css" rel="stylesheet" />

    <!--     Fonts and icons     -->
    <link href="assets/css/pe-icon-7-stroke.css" rel="stylesheet" />
  </head>
  <body>
    <div class="container">
      <form class="form-horizontal" id="frmLogin" action="controle.php" method="POST">
        <div class="form-group">
          <label for="usu_log" class="col-sm-4 control-label">Login</label>
          <div class="col-sm-3">
            <input class="form-control col-sm-10" placeholder="Login" name="usu_log" id="usu_log" required autocomplete="off">
          </div>
        </div>

        <div class="form-group">
          <label for="usu_sen" class="col-sm-4 control-label">Senha</label>
          <div class="col-sm-3">
            <input type="password" class="form-control" placeholder="Senha" name="usu_sen" id="usu_sen" required autocomplete="off">
          </div>
        </div>

        <div class="mensagem-erro col-sm-offset-4"></div>
        
        <div class="col-sm-offset-4 col-sm-8">
          <input type="submit" class="btn btn-success btn-fill" value="Entrar" name="Entrar" id="Entrar">
        </div>
      </form>
    </div>
  </body>

  <!--   Core JS Files   -->
  <script src="assets/js/jquery-1.10.2.js" type="text/javascript"></script>
  <script src="assets/js/bootstrap.min.js" type="text/javascript"></script>

  <!--  Checkbox, Radio & Switch Plugins -->
  <script src="assets/js/bootstrap-checkbox-radio-switch.js"></script>

  <!--  Charts Plugin -->
  <script src="assets/js/chartist.min.js"></script>

  <!--  Notifications Plugin    -->
  <script src="assets/js/bootstrap-notify.js"></script>

  <!-- Light Bootstrap Table Core javascript and methods for Demo purpose -->
  <script src="assets/js/light-bootstrap-dashboard.js"></script>

  <!-- Light Bootstrap Table DEMO methods, don't include it in your project! -->
  <script src="assets/js/demo.js"></script>
  
  <!-- Plugin of jQuery, the jQuery Form -->
  <script src="assets/js/jquery.form.js"></script>
  
  <script type="text/javascript">
    $(function($) {
      $('#frmLogin').submit(function() {
        $('div.mensagem-erro').html('');
 
        $(this).ajaxSubmit(function(resposta) {
          if (resposta) {
            window.location.href = 'index.php';
          } else {
            $('div.mensagem-erro').html(resposta);
          }
        });
        
        // Retornando false para que o formulário não envie as informações da forma convencional
        return false;
      });
    });
  </script>
</html>