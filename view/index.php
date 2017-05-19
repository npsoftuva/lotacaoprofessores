<?php
  require_once('verificaSessao.php');
  require_once('../controller/SalaController.php');

  $salaController = new SalaController();
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <link rel="icon" type="image/png" href="assets/img/favicon.ico">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

    <title>LotaProf | Dashboard</title>

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
    <div class="wrapper">
      <?php include ("sidebar.inc"); ?>

      <div class="main-panel">
        <?php include("navbar.inc"); ?>

        <div class="content">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-12">
                <div class="card card-plain">
                  <div class="header">
                    <h4 class="title">Index</h4>
                    <p class="category">
                      Página principal! Olá <?php echo $_SESSION['usuarioLog']; ?>
                    </p>
                  </div>
                </div>
              </div>
            </div>
						
						<button type="button" class="btn btn-success btn-fill" data-toggle="modal" data-target="#lot-prof">
            	Relatório de lotação de professores
            </button>

						<br><br>
						
						<button type="button" class="btn btn-success btn-fill" data-toggle="modal" data-target="#lot-sala">
            	Relatório de lotação de sala
            </button>
							
          </div>
        </div>
        <?php include("footer.inc"); ?>
      </div>
    </div>

		<!-- Modal Lotação Professores -->
    <div class="modal fade" id="lot-prof" tabindex="-1" role="dialog" aria-labelledby="add">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="add"><span class="pe-7s-file"></span> Número do Ofício</h4>
          </div>
          <div class="modal-body">
            <form role="form" method="POST" action="relatorioProf.php" target="_blank">
              <div class="form-group">
                <label>Ofício Nº *</label>
                <input class="form-control" placeholder="Número do Ofício" name="num_ofc" required autocomplete="off">
              </div>
          </div>
          <div class="modal-footer">
            <input type="submit" class="btn btn-success btn-fill" value="Gerar" name="GerarP" id="GerarP">
            <button type="reset" class="btn btn-warning btn-fill">Limpar</button>
            </form>
          </div>
        </div>
      </div>
    </div>
		
		<!-- Modal Lotação Sala -->
    <div class="modal fade" id="lot-sala" tabindex="-1" role="dialog" aria-labelledby="add">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="add"><span class="pe-7s-display2"></span> Sala</h4>
          </div>
          <div class="modal-body">
            <form role="form" method="POST" action="relatorioSala.php" target="_blank">
              <div class="form-group">
                <label>Escolha a Sala *</label>
								<select class="form-control" name="sla_cod" id="sla_cod">
                <?php foreach ($salaController->searchAll() as $sala) { ?>
                <option value="<?php echo $sala->__get("sla_cod"); ?>"><?php echo $sala->__get("sla_nom"); ?></option>
                <?php } ?>
              </select>
              </div>
          </div>
          <div class="modal-footer">
            <input type="submit" class="btn btn-success btn-fill" value="Gerar" name="GerarS" id="GerarS">
            </form>
          </div>
        </div>
      </div>
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
	
	<script type="text/javascript">
		$('#GerarP').on('click', function() {
			$('#lot-prof').modal('hide');
		});
	</script>
  
  <script type="text/javascript">
		$('#GerarS').on('click', function() {
			$('#lot-sala').modal('hide');
		});
	</script>
</html>