<?php
  require_once('verificaSessao.php');
  require_once('verificaPapel.php');
  require_once('../controller/FluxoController.php');

  $fluxoController = new FluxoController();  

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <link rel="icon" type="image/png" href="assets/img/favicon.ico">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

    <title>LotaProf | Fluxo</title>

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
                 <?php
                    if (isset($_POST["Adicionar"])) {
                      $fluxo = new Fluxo();
                      $fluxo->__set("flx_cod", $_POST["flx_cod"]);
                      $fluxo->__set("flx_trn", $_POST["flx_trn"]);
                      $fluxo->__set("flx_sem", $_POST["flx_sem"]);
                      if ($fluxoController->register($fluxo)) { ?>
                        <div class="alert alert-success alert-with-icon" data-notify="container">
                          <span data-notify="icon" class="pe-7s-refresh-2"></span>
                          <span data-notify="message">Fluxo adicionado com sucesso!</span>
                        </div>
                      <?php } else { ?>
                        <div class="alert alert-danger alert-with-icon" data-notify="container">
                          <span data-notify="icon" class="pe-7s-refresh-2"></span>
                          <span data-notify="message">Ocorreu um erro ao tentar adicionar o fluxo.</span>
                        </div>
                      <?php }
                    } else
                    if (isset($_POST["Excluir"])) {
                      $return = $fluxoController->remove($_POST["flx_codx"]);
                      if ($return === 1) { ?>
                        <div class="alert alert-success alert-with-icon" data-notify="container">
                          <span data-notify="icon" class="pe-7s-refresh-2"></span>
                          <span data-notify="message">Fluxo excluído com sucesso!</span>
                        </div>
                      <?php } else { ?>
                        <div class="alert alert-danger alert-with-icon" data-notify="container">
                          <span data-notify="icon" class="pe-7s-refresh-2"></span>
                          <span data-notify="message"><?php echo $return; ?></span>
                        </div>
                      <?php }
                    } else
                    if (isset($_POST["Editar"])) {
                      $fluxo = new Fluxo();
                      $fluxo->__set("flx_cod", $_POST["flx_cod"]);
                      $fluxo->__set("flx_trn", $_POST["flx_trn"]);
                      $fluxo->__set("flx_sem", $_POST["flx_sem"]);

                      if ($fluxoController->update($fluxo)) { ?>
                        <div class="alert alert-success alert-with-icon" data-notify="container">
                          <span data-notify="icon" class="pe-7s-refresh-2"></span>
                          <span data-notify="message">Fluxo editado com sucesso!</span>
                        </div>
                      <?php } else { ?>
                        <div class="alert alert-danger alert-with-icon" data-notify="container">
                          <span data-notify="icon" class="pe-7s-refresh-2"></span>
                          <span data-notify="message">Ocorreu um erro ao tentar editar o fluxo.</span>
                        </div>
                      <?php }
                    }

                    $fluxos = $fluxoController->searchAll();
                ?>
                  <div class="header">
                    <h4 class="title">Fluxos</h4>
                    <p class="category">
                      Lista de fluxos cadastrados
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
                        <th class="col-xs-4 col-sm-4 col-md-4 col-lg-4">Código</th>
                        <th class="col-xs-3 col-sm-3 col-md-3 col-lg-3">Turno</th>
                        <th class="col-xs-3 col-sm-3 col-md-3 col-lg-3">Semestres</th>
                        <th class="col-xs-2 col-sm-2 col-md-2 col-lg-2">Ações</th>
                      </thead>
                      <tbody>
<?php if (isset($fluxos)) foreach ($fluxos as $fluxo) { ?>
                        <tr>
                          <td><?php echo substr($fluxo->__get("flx_cod"), 0, 4) . '.' . substr($fluxo->__get("flx_cod"), 4, 1); ?></td>
                          <td><?php echo ($fluxo->__get("flx_trn") == "0" ? "Integral" : ($fluxo->__get("flx_trn") == "1" ? "Manhã" : ($fluxo->__get("flx_trn") == "2" ? "Tarde" : "Noite"))); ?></td>
                          <td><?php echo $fluxo->__get("flx_sem"); ?></td>
                          <td>
                            <a data-toggle="modal" data-cod="<?php echo $fluxo->__get("flx_cod"); ?>" data-trn="<?php echo $fluxo->__get("flx_trn"); ?>" data-sem="<?php echo $fluxo->__get("flx_sem"); ?>" title="Editar" class="openEdit btn btn-warning" href="#edit"><span class="pe-7s-note" aria-hidden="true"></span></a>

                            <a data-toggle="modal" data-cod="<?php echo $fluxo->__get("flx_cod"); ?>" title="Excluir" class="openDelete btn btn-danger" href="#delete"><span class="pe-7s-trash" aria-hidden="true"></span></a>
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
            <h4 class="modal-title"><span class="pe-7s-refresh-2"></span> Excluir Fluxo</h4>
          </div>
          <div class="modal-footer">
            <form role="form" method="POST">
              <input type="hidden" name="flx_codx" id="flx_codx" value="">
              <p>Você deseja excluir o fluxo <b id="flx_codxx"></b>?</p>
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
          <form role="form" method="POST">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="edit"><span class="pe-7s-refresh-2"></span> Editar Fluxo</h4>
            </div>
            <div class="modal-body">
              <div class="form-group">
                <label>Código *</label>
                <input class="form-control" type="text" name="flx_cod" id="flx_cod" value="" readonly>
              </div>
              <div class="form-group">
                <label>Turno *</label>
                <select class="form-control" name="flx_trn" id="flx_trn">
                  <option value="0">Integral</option>
                  <option value="1">Manhã</option>
                  <option value="2">Tarde</option>
                  <option value="3">Noite</option>
                </select>
              </div>
              <div class="form-group">
                <label>Semestres *</label>
                <input class="form-control" type="number" min="1" name="flx_sem" id="flx_sem" value="" required>
              </div>
            </div>
            <div class="modal-footer">
              <input type="button" class="btn btn-warning btn-fill" data-dismiss="modal" value="Cancelar">
              <input type="submit" class="btn btn-success btn-fill" value="Salvar" name="Editar">
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Modal Adicionar -->
    <div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="add">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <form role="form" method="POST">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="add"><span class="pe-7s-refresh-2"></span> Adicionar Fluxo</h4>
            </div>
            <div class="modal-body">
              <div class="form-group">
                <label>Código *</label>
                <input class="form-control" placeholder="Código do Fluxo" name="flx_cod" required autocomplete="off" maxlength="5" min="5" max="5">
              </div>
              <div class="form-group">
                <label>Turno *</label>
                <select class="form-control" name="flx_trn">
                  <option value="0">Integral</option>
                  <option value="1">Manhã</option>
                  <option value="2">Tarde</option>
                  <option value="3">Noite</option>
                </select>
              </div>
              <div class="form-group">
                <label>Semestres *</label>
                <input class="form-control" type="number" min="1" name="flx_sem" id="flx_sem" placeholder="Quant. de Semestres" required>
              </div>
            </div>
            <div class="modal-footer">
              <button type="reset" class="btn btn-warning btn-fill">Limpar</button>
              <input type="submit" class="btn btn-success btn-fill" value="Adicionar" name="Adicionar" id="Adicionar">
            </div>
          </form>
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
    $(document).on("click", ".openEdit", function () {
      var flx_cod = $(this).data('cod');
      $(".modal-body #flx_cod").val(flx_cod);
      var flx_trn = $(this).data('trn');
      $("#flx_trn").val(flx_trn);
      var flx_sem = $(this).data('sem');
      $("#flx_sem").val(flx_sem);
    });
  </script>

  <script type="text/javascript">
    $(document).on("click", ".openDelete", function () {
      var flx_cod = $(this).data('cod');
      $(".modal-footer #flx_codx").val( flx_cod );
      $(".modal-footer #flx_codxx").html(flx_cod.toString().substr(0, 4)+'.'+flx_cod.toString().substr(4, 5));
    });
  </script>

  <script>
    $(".alert").fadeTo(4000, 500).slideUp(1000, function(){
      $(".alert").slideUp(4000);
    });
  </script>
</html>
