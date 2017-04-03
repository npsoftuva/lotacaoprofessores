<?php
  require_once('../controller/SalaController.php');

  $salaController = new SalaController();

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <link rel="icon" type="image/png" href="assets/img/favicon.ico">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

    <title>LotaProf | Sala</title>

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
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>
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
                  <?php
                    if (isset($_POST["Adicionar"])) {
                      $sala = new Sala();
											$sala->__set("sla_cod", $_POST["sla_cod"]);	
                      $sala->__set("sla_nom", $_POST["sla_nom"]);
                      $sala->__set("sla_cap", $_POST["sla_cap"]);
                      if ($salaController->register($sala)) { ?>
                      <div class="alert alert-success alert-with-icon" data-notify="container">
                        <span data-notify="icon" class="pe-7s-date"></span>
                        <span data-notify="message">Sala adicionada com sucesso!</span>
                      </div>
                    <?php } else { ?>
                      <div class="alert alert-danger alert-with-icon" data-notify="container">
                        <span data-notify="icon" class="pe-7s-date"></span>
                        <span data-notify="message">Ocorreu um erro ao tentar adicionar a sala.</span>
                      </div>
                    <?php }
                    } else
                    if (isset($_POST["Excluir"])) {
                      if ($salaController->remove($_POST["sla_codx"])) { ?>
                      <div class="alert alert-success alert-with-icon" data-notify="container">
                        <span data-notify="icon" class="pe-7s-date"></span>
                        <span data-notify="message">Sala excluída com sucesso!</span>
                      </div>
                    <?php } else { ?>
                      <div class="alert alert-danger alert-with-icon" data-notify="container">
                        <span data-notify="icon" class="pe-7s-date"></span>
                        <span data-notify="message">Ocorreu um erro ao tentar excluir a sala.</span>
                      </div>
                    <?php }
                    } else
                    if (isset($_POST["Editar"])) {
                      $sala = new Sala();
                      $sala->__set("sla_cod", $_POST["sla_cod"]);
                      $sala->__set("sla_cap", $_POST["sla_cap"]);
                      $sala->__set("sla_nom", $_POST["sla_nom"]);
                      if ($salaController->update($sala)) { ?>
                      <div class="alert alert-success alert-with-icon" data-notify="container">
                        <span data-notify="icon" class="pe-7s-date"></span>
                        <span data-notify="message">Sala editada com sucesso!</span>
                      </div>
                    <?php } else { ?>
                      <div class="alert alert-danger alert-with-icon" data-notify="container">
                        <span data-notify="icon" class="pe-7s-date"></span>
                        <span data-notify="message">Ocorreu um erro ao tentar editar a sala.</span>
                      </div>
                    <?php }
                    }

                    $salas = $salaController->searchAll();
                  ?>

                  <div class="header">
                    <h4 class="title">Salas</h4>
                    <p class="category">
                      Lista de salas cadastradas
                      <span class="pull-right">
                        <button type="button" class="btn btn-success btn-fill" data-toggle="modal" data-target="#add">
                          Adicionar
                        </button>
                      </span>
                    </p>
                  </div>
                  <div class="content table-responsive table-full-width">
                    <table class="table table-striped table-hover" id="dataTables-example">
                      <thead>
                        <th class="col-xs-3 col-sm-3 col-md-3 col-lg-3">Código</th>
                        <th class="col-xs-4 col-sm-4 col-md-4 col-lg-4">Nome</th>
                        <th class="col-xs-3 col-sm-3 col-md-3 col-lg-3">Capacidade</th>
                        <th class="col-xs-2 col-sm-2 col-md-2 col-lg-2">Ações</th>
                      </thead>
                      <tbody>
<?php foreach ($salas as $sala) { ?>
                        <tr>
                          <td><?php echo $sala->__get("sla_cod"); ?></td>
                          <td><?php echo $sala->__get("sla_nom"); ?></td>
                          <td><?php echo $sala->__get("sla_cap"); ?></td>
                          <td>
                            <a data-toggle="modal" data-cod="<?php echo $sala->__get("sla_cod"); ?>" data-nom="<?php echo $sala->__get("sla_nom"); ?>" data-cap="<?php echo $sala->__get("sla_cap"); ?>" title="Editar" class="openEdit btn btn-warning" href="#edit"><span class="pe-7s-note" aria-hidden="true"></span></a>

                            <a data-toggle="modal" data-cod="<?php echo $sala->__get("sla_cod"); ?>" data-nom="<?php echo $sala->__get("sla_nom"); ?>" title="Excluir" class="openDelete btn btn-danger" href="#delete"><span class="pe-7s-trash" aria-hidden="true"></span></a>
                          </td>
                        </tr>
<?php } ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <?php include("footer.inc"); ?>
      </div>
    </div>

    <!-- Modal Excluir -->
    <div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="delete">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"><span class="pe-7s-display2"></span> Excluir Sala</h4>
          </div>
          <div class="modal-footer">
            <form role="form" method="POST">
              <input type="hidden" name="sla_codx" id="sla_codx" value="">
              <p>Você deseja excluir a sala <b id="sla_nomx"></b>?</p>
              <input type="button" class="btn btn-danger btn-fill" data-dismiss="modal" value="Não">
              <input type="submit" class="btn btn-success btn-fill" value="Sim" name="Excluir">
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal Editar -->
    <div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="edit">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="edit"><span class="pe-7s-display2"></span> Editar Sala</h4>
          </div>
          <div class="modal-body">
            <form role="form" method="POST">
              <div class="form-group">
								<div class="form-group">
                  <label>Código</label>
                  <input class="form-control" type="text" name="sla_cod" id="sla_cod" value="" readonly>
                </div>
                <div class="form-group">
                  <label>Nome</label>
                  <input class="form-control" type="text" name="sla_nom" id="sla_nom" value="" required autocomplete="off">
                </div>
                <div class="form-group">
                  <label>Capacidade</label>
                  <input class="form-control" type="number" min="1" step="1" name="sla_cap" id="sla_cap" value="" required autocomplete="off">
                </div>
              </div>
          </div>
          <div class="modal-footer">
            <input type="button" class="btn btn-warning btn-fill" data-dismiss="modal" value="Cancelar">
            <input type="submit" class="btn btn-success btn-fill" value="Salvar" name="Editar">
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal Adicionar -->
    <div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="add">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="add"><span class="pe-7s-display2"></span> Adicionar Sala</h4>
          </div>
          <div class="modal-body">
            <form role="form" method="POST">
              <div class="form-group">
                <label>Código *</label>
                <input class="form-control" placeholder="Código da Sala" name="sla_cod" required autocomplete="off">
              </div>
              <div class="form-group">
                <label>Nome *</label>
                <input class="form-control" placeholder="Nome da Sala" name="sla_nom" required autocomplete="off">
              </div>
              <div class="form-group">
                <label>Capacidade *</label>
                <input class="form-control" type="number" min="1" step="1" placeholder="Capacidade da Sala" name="sla_cap" required autocomplete="off">
              </div>
          </div>
          <div class="modal-footer">
            <input type="submit" class="btn btn-success btn-fill" value="Adicionar" name="Adicionar" id="Adicionar">
            <button type="reset" class="btn btn-warning btn-fill">Limpar</button>
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


  <!--  Google Maps Plugin    -->
  <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>


  <!-- Light Bootstrap Table Core javascript and methods for Demo purpose -->
  <script src="assets/js/light-bootstrap-dashboard.js"></script>

  <!-- Light Bootstrap Table DEMO methods, don't include it in your project! -->
  <script src="assets/js/demo.js"></script>

  <script type="text/javascript">
    $(document).on("click", ".openEdit", function () {
      var sla_cod = $(this).data('cod');
      $(".modal-body #sla_cod").val(sla_cod);
      var sla_nom = $(this).data('nom');
      $(".modal-body #sla_nom").val(sla_nom);
      var sla_cap = $(this).data('cap');
      $(".modal-body #sla_cap").val(sla_cap);
    });
  </script>

  <script type="text/javascript">
    $(document).on("click", ".openDelete", function () {
      var sla_cod = $(this).data('cod');
      $(".modal-footer #sla_codx").val( sla_cod );
      var sla_nom = $(this).data('nom');
      $(".modal-footer #sla_nomx").html(sla_nom);
    });
  </script>
</html>
