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

<?php
	$componente = $componenteController->searchAll();
?>

        <div class="content">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-12">
                <div class="card card-plain">
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
                        <th class="col-xs-2 col-sm-2 col-md-2 col-lg-2">Fluxo</th>
                        <th class="col-xs-4 col-sm-4 col-md-4 col-lg-4">Disciplina</th>
                        <th class="col-xs-2 col-sm-2 col-md-2 col-lg-2">Semestre</th>
                        <th class="col-xs-2 col-sm-2 col-md-2 col-lg-2">CH</th>
                        <th class="col-xs-2 col-sm-2 col-md-2 col-lg-2">Ações</th>
                      </thead>
                      <tbody>
<?php foreach ($componentes as $componente) { ?>
                        <tr>
                          <td><?php echo $componente->__get("flx_cod"); ?></td>
                          <td><?php echo ($componente->__get("dcp_cod"); ?></td>
                          <td><?php echo ($componente->__get("cmp_sem"); ?></td>
                          <td><?php echo ($componente->__get("cmp_hor"); ?></td>
                          <td>
                            <a data-toggle="modal" data-flx="<?php echo $componente->__get("flx_cod"); ?>" data-dcp="<?php echo $componente->__get("dcp_cod"); ?>" data-sem="<?php echo $componente->__get("cmp_sem"); ?>" data-hor="<?php echo $componente->__get("cmp_hor"); ?>" title="Editar" class="openEdit btn btn-warning" href="#edit"><span class="pe-7s-note" aria-hidden="true"></span></a>

                            <a data-toggle="modal" data-flx="<?php echo $componente->__get("flx_cod"); ?>" data-dcp="<?php echo $componente->__get("dcp_cod"); ?>" title="Excluir" class="openDelete btn btn-danger" href="#delete"><span class="pe-7s-trash" aria-hidden="true"></span></a>
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
            <h4 class="modal-title">Excluir Componente</h4>
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
        <form role="form" method="POST">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="edit">Editar Componente</h4>
            </div>
            <div class="modal-body">
              <div class="form-group">
                <label>Fluxo *</label>
                <select class="form-control" name="flx_cod" id="flx_cod">
                  <option value="20161">2016.1</option>
                  <option value="20162">2016.2</option>
                </select>
              </div>
              <div class="form-group">
                <label>Disciplina *</label>
                <select class="form-control" name="dcp_cod" id="dcp_cod">
                  <option value="1">Disciplina 1</option>
                  <option value="2">Disciplina 2</option>
                  <option value="3">Disciplina 3</option>
                </select>
              </div>
              <div class="form-group">
                <label>Semestre *</label>
                <select class="form-control" name="cmp_sem" id="cmp_sem">
                  <option value="1">1º</option>
                  <option value="2">2º</option>
                  <option value="3">3º</option>
                </select>
              </div>
              <div class="form-group">
                <label>Carga Horária *</label>
                <input type="number" name="cmp_hor" id="cmp_hor" step="1" min="1">
              </div>
            </div>
            <div class="modal-footer">
              <input type="button" class="btn btn-warning btn-fill" data-dismiss="modal" value="Cancelar">
              <input type="submit" class="btn btn-success btn-fill" value="Salvar" name="Editar">
            </div>
          </div>
        </form>
      </div>
    </div>

    <!-- Modal Adicionar -->
    <div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="add">
      <div class="modal-dialog" role="document">
        <form role="form" method="POST">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="add">Adionar Componente</h4>
            </div>
            <div class="modal-body">
              <div class="form-group">
                <label>Fluxo *</label>
                <select class="form-control" name="flx_cod" id="flx_cod">
                  <option value="20161">2016.1</option>
                  <option value="20162">2016.2</option>
                </select>
              </div>
              <div class="form-group">
                <label>Disciplina *</label>
                <select class="form-control" name="dcp_cod" id="dcp_cod">
                  <option value="1">Disciplina 1</option>
                  <option value="2">Disciplina 2</option>
                  <option value="3">Disciplina 3</option>
                </select>
              </div>
              <div class="form-group">
                <label>Semestre *</label>
                <select class="form-control" name="cmp_sem" id="cmp_sem">
                  <option value="1">1º</option>
                  <option value="2">2º</option>
                  <option value="3">3º</option>
                </select>
              </div>
              <div class="form-group">
                <label>Carga Horária *</label>
                <input type="number" name="cmp_hor" id="cmp_hor" step="1" min="1">
              </div>
            </div>
            <div class="modal-footer">
              <input type="submit" class="btn btn-success btn-fill" value="Adicionar" name="Adicionar" id="Adicionar">
              <button type="reset" class="btn btn-warning btn-fill">Limpar</button>
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


  <!--  Google Maps Plugin    -->
  <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>


  <!-- Light Bootstrap Table Core javascript and methods for Demo purpose -->
  <script src="assets/js/light-bootstrap-dashboard.js"></script>

  <!-- Light Bootstrap Table DEMO methods, don't include it in your project! -->
  <script src="assets/js/demo.js"></script>

  <script type="text/javascript">
    $(document).on("click", ".openEdit", function () {
      var flx_cod = $(this).data('flx');
      $(".modal-body #flx_cod").val(flx_cod);
      var dcp_cod = $(this).data('dcp');
      $(".modal-body #dcp_cod").val(dcp_cod);
      var cmp_sem = $(this).data('sem');
      $(".modal-body #cmp_sem").val(cmp_sem);
      var cmp_hor = $(this).data('hor');
      $(".modal-body #cmp_hor").val(cmp_hor);
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
