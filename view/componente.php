<?php
  require_once('../controller/ComponenteController.php');

  $componenteController = new ComponenteController();
  $componentes = $componenteController->searchAll();

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <link rel="icon" type="image/png" href="assets/img/favicon.ico">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

    <title>LotaProf | Componente</title>

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
                        $componente = new Componente();
                        $componente->__set("flx_cod", $_POST["flx_cod"]);
                        $componente->__set("flx_trn", $_POST["flx_trn"]);
                        $componente->__set("flx_sem", $_POST["flx_sem"]);
                        if ($componenteController->register($componente)) { ?>
                          <div class="alert alert-success alert-with-icon" data-notify="container">
                            <span data-notify="icon" class="pe-7s-notebook"></span>
                            <span data-notify="message">Componente adicionado com sucesso!</span>
                          </div>
                        <?php } else { ?>
                          <div class="alert alert-danger alert-with-icon" data-notify="container">
                            <span data-notify="icon" class="pe-7s-notebook"></span>
                            <span data-notify="message">Ocorreu um erro ao tentar adicionar o componente.</span>
                          </div>
                        <?php }
                    } else
                    if (isset($_POST["Excluir"])) {
                        if ($componenteController->remove($_POST["flx_codx"])) { ?>
                          <div class="alert alert-success alert-with-icon" data-notify="container">
                            <span data-notify="icon" class="pe-7s-notebook"></span>
                            <span data-notify="message">Componente excluído com sucesso!</span>
                          </div>
                        <?php } else { ?>
                          <div class="alert alert-danger alert-with-icon" data-notify="container">
                            <span data-notify="icon" class="pe-7s-notebook"></span>
                            <span data-notify="message">Ocorreu um erro ao tentar excluir o componente.</span>
                          </div>
                        <?php }
                    } else
                    if (isset($_POST["Editar"])) {
                        $componente = new Componente();
                        $componente->__set("flx_cod", $_POST["flx_cod"]);
                        $componente->__set("flx_trn", $_POST["flx_trn"]);

                        if ($componenteController->update($componente)) { ?>
                          <div class="alert alert-success alert-with-icon" data-notify="container">
                            <span data-notify="icon" class="pe-7s-notebook"></span>
                            <span data-notify="message">Componente editado com sucesso!</span>
                          </div>
                        <?php } else { ?>
                          <div class="alert alert-danger alert-with-icon" data-notify="container">
                            <span data-notify="icon" class="pe-7s-notebook"></span>
                            <span data-notify="message">Ocorreu um erro ao tentar editar o componente.</span>
                          </div>
                        <?php }
                    }



                    $componentes = $componenteController->searchAll();
                ?>
                  <div class="header">
                    <h4 class="title">Componentes</h4>
                    <p class="category">
                      Lista de componentes cadastrados
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
                        <th class="col-xs-1 col-sm-1 col-md-1 col-lg-1">Fluxo</th>
                        <th class="col-xs-7 col-sm-7 col-md-7 col-lg-7">Disciplina</th>
                        <th class="col-xs-1 col-sm-1 col-md-1 col-lg-1">Semestre</th>
                        <th class="col-xs-1 col-sm-1 col-md-1 col-lg-1">CH</th>
                        <th class="col-xs-2 col-sm-2 col-md-2 col-lg-2">Ações</th>
                      </thead>
                      <tbody>
<?php foreach ($componentes as $componente) { ?>
                        <tr>
                          <td><?php echo $componente->__get("flx_cod")->__get("flx_cod"); ?></td>
                          <td><?php echo $componente->__get("dcp_cod")->__get("dcp_nom"); ?></td>
                          <td><?php echo $componente->__get("cmp_sem"); ?></td>
                          <td><?php echo $componente->__get("cmp_hor"); ?></td>
                          <td>
                            <a data-toggle="modal" data-flx="<?php echo $componente->__get("flx_cod")->__get("flx_cod"); ?>" data-dcp="<?php echo $componente->__get("dcp_cod")->__get("dcp_nom"); ?>" data-sem="<?php echo $componente->__get("cmp_sem"); ?>" data-hor="<?php echo $componente->__get("cmp_hor"); ?>" title="Editar" class="openEdit btn btn-warning" href="#edit"><span class="pe-7s-note" aria-hidden="true"></span></a>

                            <a data-toggle="modal" data-flx="<?php echo $componente->__get("flx_cod")->__get("flx_cod"); ?>" data-dcp="<?php echo $componente->__get("dcp_cod")->__get("dcp_nom"); ?>" title="Excluir" class="openDelete btn btn-danger" href="#delete"><span class="pe-7s-trash" aria-hidden="true"></span></a>
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
            <h4 class="modal-title"><span class="pe-7s-refresh-2"></span> Excluir Componente</h4>
          </div>
          <div class="modal-footer">
            <form role="form" method="POST">
              <input type="hidden" name="flx_codx" id="flx_codx" value="">
              <input type="hidden" name="dcp_codx" id="dcp_codx" value="">
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
            <h4 class="modal-title" id="edit"><span class="pe-7s-refresh-2"></span> Editar Componente</h4>
          </div>
          <div class="modal-body">
            <form role="form" method="POST">
              <div class="form-group">
                <div class="form-group">
                  <label>Código *</label>
                  <input class="form-control" type="text" name="flx_cod" id="flx_cod" value="" readonly>
                </div>
                <div class="form-group">
                  <label>Situação *</label>
                  <select class="form-control" name="flx_trn" id="flx_trn">
                    <option value="0">Integral</option>
                    <option value="1">Manhã</option>
                    <option value="2">Tarde</option>
                    <option value="3">Noite</option>
                  </select>
                </div>
                <div class="form-group">
                <label>Semestre *</label>
                <input class="form-control" type="number" placeholder="Quant. de semestres do Componente" name="flx_sem" id="flx_sem" required autocomplete="off" min="1">
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
            <h4 class="modal-title" id="add"><span class="pe-7s-refresh-2"></span> Adicionar Componente</h4>
          </div>
          <div class="modal-body">
            <form role="form" method="POST">
              <div class="form-group">
                <label>Código *</label>
                <input class="form-control" placeholder="Código do Componente" name="flx_cod" required autocomplete="off" maxlength="5" max="5" min="5">
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
                <label>Semestre *</label>
                <input class="form-control" type="number" placeholder="Quant. de semestres do Componente" name="flx_sem" required autocomplete="off" min="1">
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
      var flx_cod = $(this).data('flx');
      $(".modal-footer #flx_codx").val( flx_cod );
      var dcp_cod = $(this).data('dcp');
      $(".modal-footer #dcp_codx").val( dcp_cod );
    });
  </script>
</html>
